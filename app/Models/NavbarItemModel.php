<?php 
namespace App\Models;

use CodeIgniter\Model;

class NavbarItemModel extends Model 
{
    protected $table = 'navbar_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'type', 'slug', 'order_position', 'is_active'];
    
    // Add return type definition
    protected $returnType = 'array';
    
    // Set default ordering
    protected $orderBy = ['order_position' => 'ASC'];

    // Add a specific method for content pages
    public function getContentPages()
    {
        $builder = $this->db->table($this->table);
        $builder->where('type', 'content');
        $builder->where('is_active', 1);
        $builder->orderBy('order_position', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}