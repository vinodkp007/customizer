<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLinksModel extends Model
{
    protected $table = 'social_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['platform', 'url', 'order_position', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'platform' => 'required|min_length[2]|max_length[255]',
        'url' => 'required|valid_url|max_length[255]'
    ];
}