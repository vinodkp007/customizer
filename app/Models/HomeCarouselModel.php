<?php
// app/Models/HomeCarouselModel.php

namespace App\Models;

use CodeIgniter\Model;

class HomeCarouselModel extends Model
{
    protected $table = 'home_carousel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'image', 'position'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}