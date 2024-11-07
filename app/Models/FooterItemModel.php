<?php
namespace App\Models;
// app/Models/FooterItemModel.php
use CodeIgniter\Model;

class FooterItemModel extends Model
{
    protected $table = 'footer_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'content', 'section', 'section_order', 'is_active'];
}