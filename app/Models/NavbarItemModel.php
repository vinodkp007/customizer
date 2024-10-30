<?php
// app/Models/NavbarItemModel.php
namespace App\Models;

use CodeIgniter\Model;

class NavbarItemModel extends Model 
{
    protected $table = 'navbar_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'type', 'slug', 'order_position', 'is_active'];
    
    // Set default ordering
    protected $orderBy = ['order_position' => 'ASC'];
}