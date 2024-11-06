<?php
// app/Models/HomeComponentModel.php

namespace App\Models;

use CodeIgniter\Model;

class HomeComponentModel extends Model
{
    protected $table = 'home_components';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type',
        'title',
        'description',
        'content',
        'image',
        'component_data',
        'styles',
        'layout',
        'position',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveComponents()
    {
        return $this->where('is_active', 1)
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }

    public function getComponentsByType($type)
    {
        return $this->where('type', $type)
                    ->where('is_active', 1)
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }
}