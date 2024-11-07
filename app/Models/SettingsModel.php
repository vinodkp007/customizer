<?php
// app/Models/SettingsModel.php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Get all settings as key-value pairs
     */
    public function getSettings()
    {
        $settings = $this->findAll();
        $result = [];
        
        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }
        
        return $result;
    }
    
    /**
     * Update or create a setting
     */
    public function updateSetting($key, $value)
    {
        $existing = $this->where('setting_key', $key)->first();
        
        if ($existing) {
            $this->update($existing['id'], ['setting_value' => $value]);
        } else {
            $this->insert([
                'setting_key' => $key,
                'setting_value' => $value
            ]);
        }
        
        return true;
    }
}