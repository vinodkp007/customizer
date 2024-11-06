<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponentItemModel extends Model
{
    protected $table = 'component_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['component_id', 'title', 'description', 'image', 'is_active', 'position'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get the next available position for items within a component
    public function getNextPosition($componentId)
    {
        $lastPosition = $this->where('component_id', $componentId)
                            ->selectMax('position')
                            ->first();
        return ($lastPosition ? $lastPosition['position'] : 0) + 1;
    }

    // Get items for a specific component
    public function getComponentItems($componentId)
    {
        return $this->where('component_id', $componentId)
                    ->where('is_active', 1)
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }
}