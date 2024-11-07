<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryPageModel extends Model
{
    protected $table = 'gallery_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'navbar_item_id',  // Added this field
        'page_title',
        'page_slug',
        'meta_description',
        'meta_keywords'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get gallery page with all its items
     * @param int $navbarItemId
     * @return array|null
     */
    public function getGalleryPageWithItems($navbarItemId)
    {
        $builder = $this->db->table($this->table);
        $builder->where('navbar_item_id', $navbarItemId);
        
        $page = $builder->get()->getRowArray();
        
        if ($page) {
            $page['items'] = $this->db->table('gallery_items')
                ->where('gallery_page_id', $page['id'])  // Changed from page_id to gallery_page_id
                ->where('is_active', 1)
                ->orderBy('display_order', 'ASC')
                ->get()
                ->getResultArray();
        }
        
        return $page;
    }

    /**
     * Find gallery page by slug
     * @param string $slug
     * @return array|null
     */
    public function findBySlug($slug)
    {
        $builder = $this->db->table($this->table);
        $builder->where('page_slug', $slug);
        
        $page = $builder->get()->getRowArray();
        
        if ($page) {
            $page['items'] = $this->db->table('gallery_items')
                ->where('gallery_page_id', $page['id'])  // Changed from page_id to gallery_page_id
                ->where('is_active', 1)
                ->orderBy('display_order', 'ASC')
                ->get()
                ->getResultArray();
        }
        
        return $page;
    }

    /**
     * Get all gallery pages
     * @return array
     */
    public function getAllGalleryPages()
    {
        return $this->select('gallery_pages.*, navbar_items.title as nav_title')
            ->join('navbar_items', 'navbar_items.id = gallery_pages.navbar_item_id')
            ->where('navbar_items.type', 'gallery')
            ->findAll();
    }

    /**
     * Get gallery page by navbar item ID
     * @param int $navbarItemId
     * @return array|null
     */
    

    /**
     * Create or update gallery page for navbar item
     * @param int $navbarItemId
     * @param array $data
     * @return int|bool
     */
    public function createOrUpdate($navbarItemId, array $data)
    {
        $existingPage = $this->where('navbar_item_id', $navbarItemId)->first();

        if ($existingPage) {
            // Update existing page
            return $this->update($existingPage['id'], $data);
        } else {
            // Create new page
            $data['navbar_item_id'] = $navbarItemId;
            return $this->insert($data);
        }
    }

    /**
     * Get gallery page with items and navbar info
     * @param int $navbarItemId
     * @return array|null
     */
    public function getFullGalleryPage($navbarItemId)
    {
        $builder = $this->db->table($this->table);
        $builder->select('gallery_pages.*, navbar_items.title as nav_title, navbar_items.slug as nav_slug');
        $builder->join('navbar_items', 'navbar_items.id = gallery_pages.navbar_item_id');
        $builder->where('gallery_pages.navbar_item_id', $navbarItemId);
        
        $page = $builder->get()->getRowArray();
        
        if ($page) {
            $page['items'] = $this->db->table('gallery_items')
                ->where('gallery_page_id', $page['id'])
                ->where('is_active', 1)
                ->orderBy('display_order', 'ASC')
                ->get()
                ->getResultArray();
        }
        
        return $page;
    }
    public function getByNavbarItemId($navbarItemId)
    {
        $builder = $this->db->table($this->table);
        $builder->where('navbar_item_id', $navbarItemId);
        return $builder->get()->getRowArray();
    }

}