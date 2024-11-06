<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponentModel extends Model
{
    protected $table = 'components';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'is_active', 'position'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get the next available position
    public function getNextPosition()
    {
        $lastPosition = $this->selectMax('position')->first();
        return ($lastPosition ? $lastPosition['position'] : 0) + 1;
    }

    // Get component with its items
    public function getComponent($id)
    {
        $component = $this->find($id);
        if ($component) {
            $itemModel = new ComponentItemModel();
            $component['items'] = $itemModel->where('component_id', $id)
                                          ->orderBy('position', 'ASC')
                                          ->findAll();
        }
        return $component;
    }

    // Get all active components with their items
    public function getAllActiveComponents()
    {
        $components = $this->where('is_active', 1)
                          ->orderBy('position', 'ASC')
                          ->findAll();

        $itemModel = new ComponentItemModel();
        foreach ($components as &$component) {
            $component['items'] = $itemModel->where('component_id', $component['id'])
                                          ->where('is_active', 1)
                                          ->orderBy('position', 'ASC')
                                          ->findAll();
        }
        return $components;
    }
}