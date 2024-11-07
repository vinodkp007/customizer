<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryItemModel extends Model
{
    protected $table = 'gallery_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'gallery_page_id',  // Changed from page_id
        'image',
        'title',
        'description',
        'alt_text',
        'display_order',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get items for a specific gallery page
     * @param int $galleryPageId
     * @return array
     */
    public function getItemsByGalleryPageId($galleryPageId)
    {
        return $this->where('gallery_page_id', $galleryPageId)
                    ->where('is_active', 1)
                    ->orderBy('display_order', 'ASC')
                    ->findAll();
    }

    /**
     * Update item positions
     * @param array $positions Array of item IDs in order
     * @return bool
     */
    public function updatePositions(array $positions)
    {
        $this->db->transStart();
        
        foreach ($positions as $index => $itemId) {
            $this->update($itemId, [
                'display_order' => $index + 1
            ]);
        }
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }

    /**
     * Delete all items for a gallery page
     * @param int $galleryPageId
     * @return bool
     */
    public function deleteGalleryItems($galleryPageId)
    {
        // First get all items to delete their images
        $items = $this->where('gallery_page_id', $galleryPageId)->findAll();
        
        foreach ($items as $item) {
            if (!empty($item['image']) && file_exists(FCPATH . $item['image'])) {
                unlink(FCPATH . $item['image']);
            }
        }
        
        return $this->where('gallery_page_id', $galleryPageId)->delete();
    }

    /**
     * Bulk insert items
     * @param array $items Array of item data
     * @return bool
     */
    public function bulkInsert(array $items)
    {
        return $this->insertBatch($items);
    }

    /**
     * Toggle item active status
     * @param int $itemId
     * @param bool $status
     * @return bool
     */
    public function toggleStatus($itemId, $status)
    {
        return $this->update($itemId, ['is_active' => $status ? 1 : 0]);
    }

    /**
     * Get items by navbar item ID
     * @param int $navbarItemId
     * @return array
     */
    public function getItemsByNavbarItemId($navbarItemId)
    {
        return $this->select('gallery_items.*')
                    ->join('gallery_pages', 'gallery_pages.id = gallery_items.gallery_page_id')
                    ->where('gallery_pages.navbar_item_id', $navbarItemId)
                    ->where('gallery_items.is_active', 1)
                    ->orderBy('gallery_items.display_order', 'ASC')
                    ->findAll();
    }

    /**
     * Delete item with image
     * @param int $itemId
     * @return bool
     */
    public function deleteWithImage($itemId)
    {
        $item = $this->find($itemId);
        
        if ($item) {
            // Delete image file if exists
            if (!empty($item['image']) && file_exists(FCPATH . $item['image'])) {
                unlink(FCPATH . $item['image']);
            }
            
            // Delete database record
            return $this->delete($itemId);
        }
        
        return false;
    }

    /**
     * Update item with image
     * @param int $itemId
     * @param array $data
     * @param array $newImage
     * @return bool
     */
    public function updateWithImage($itemId, array $data, $newImage = null)
    {
        if ($newImage && $newImage['error'] === 0) {
            // Get old item data to delete old image
            $oldItem = $this->find($itemId);
            
            if ($oldItem && !empty($oldItem['image']) && file_exists(FCPATH . $oldItem['image'])) {
                unlink(FCPATH . $oldItem['image']);
            }
            
            // Process and save new image
            $newName = $newImage['name'];
            move_uploaded_file($newImage['tmp_name'], FCPATH . 'uploads/gallery/' . $newName);
            $data['image'] = 'uploads/gallery/' . $newName;
        }
        
        return $this->update($itemId, $data);
    }

    /**
     * Move item to position
     * @param int $itemId
     * @param int $position
     * @return bool
     */
    public function moveToPosition($itemId, $position)
    {
        $item = $this->find($itemId);
        if (!$item) return false;

        $this->db->transStart();
        
        // Shift other items
        if ($position < $item['display_order']) {
            $this->db->query("
                UPDATE gallery_items 
                SET display_order = display_order + 1 
                WHERE gallery_page_id = ? 
                AND display_order >= ? 
                AND display_order < ?", 
                [$item['gallery_page_id'], $position, $item['display_order']]
            );
        } else {
            $this->db->query("
                UPDATE gallery_items 
                SET display_order = display_order - 1 
                WHERE gallery_page_id = ? 
                AND display_order > ? 
                AND display_order <= ?", 
                [$item['gallery_page_id'], $item['display_order'], $position]
            );
        }
        
        // Update item position
        $this->update($itemId, ['display_order' => $position]);
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }
}