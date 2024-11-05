<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentSectionModel extends Model
{
    protected $table = 'content_sections';
    protected $primaryKey = 'id';
    protected $allowedFields = ['content_page_id', 'content', 'order_position'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get sections for a specific content page
     * @param int $contentPageId
     * @return array
     */
    public function getSectionsByPageId($contentPageId)
    {
        return $this->where('content_page_id', $contentPageId)
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }

    /**
     * Update section positions
     * @param array $positions Array of section IDs in order
     * @return bool
     */
    public function updatePositions(array $positions)
    {
        $this->db->transStart();
        
        foreach ($positions as $index => $sectionId) {
            $this->update($sectionId, [
                'order_position' => $index + 1
            ]);
        }
        
        $this->db->transComplete();
        
        return $this->db->transStatus();
    }

    /**
     * Delete all sections for a content page
     * @param int $contentPageId
     * @return bool
     */
    public function deletePageSections($contentPageId)
    {
        return $this->where('content_page_id', $contentPageId)->delete();
    }

    /**
     * Bulk insert sections
     * @param array $sections Array of section data
     * @return bool
     */
    public function bulkInsert(array $sections)
    {
        return $this->insertBatch($sections);
    }
}