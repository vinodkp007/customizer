<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentPageModel extends Model
{
    protected $table = 'content_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['navbar_item_id', 'hero_title', 'hero_image', 'section_title'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get content page with all its sections and navbar information
     * @param int $id
     * @return array|null
     */
    public function getContentPageWithSections($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('content_pages.*, navbar_items.title, navbar_items.slug');
        $builder->join('navbar_items', 'navbar_items.id = content_pages.navbar_item_id');
        $builder->where('content_pages.id', $id);
        
        $page = $builder->get()->getRowArray();
        
        if ($page) {
            $page['sections'] = $this->db->table('content_sections')
                ->where('content_page_id', $id)
                ->orderBy('order_position', 'ASC')
                ->get()
                ->getResultArray();
        }
        
        return $page;
    }

    /**
     * Find page by navbar item slug
     * @param string $slug
     * @return array|null
     */
    public function findBySlug($slug)
    {
        $builder = $this->db->table($this->table);
        $builder->select('content_pages.*, navbar_items.title, navbar_items.slug');
        $builder->join('navbar_items', 'navbar_items.id = content_pages.navbar_item_id');
        $builder->where('navbar_items.slug', $slug);
        
        $page = $builder->get()->getRowArray();
        
        if ($page) {
            $page['sections'] = $this->db->table('content_sections')
                ->where('content_page_id', $page['id'])
                ->orderBy('order_position', 'ASC')
                ->get()
                ->getResultArray();
        }
        
        return $page;
    }

    /**
     * Get all content pages with navbar information
     * @return array
     */
    public function getAllContentPages()
    {
        $builder = $this->db->table($this->table);
        $builder->select('content_pages.*, navbar_items.title, navbar_items.slug');
        $builder->join('navbar_items', 'navbar_items.id = content_pages.navbar_item_id');
        $builder->orderBy('navbar_items.order_position', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}