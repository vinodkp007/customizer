<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Files\File;

class ContainerPageModel extends Model
{
    protected $table = 'container_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'slug',
        'layout_meta',
        'content_file',
        'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Path where content JSON files will be stored
    protected $contentPath = WRITEPATH . 'container-content/';

    public function __construct()
    {
        parent::__construct();
        // Ensure content directory exists
        if (!is_dir($this->contentPath)) {
            mkdir($this->contentPath, 0755, true);
        }
    }

    /**
     * Get all containers with their layout metadata
     * @return array
     */
    public function getAllContainers()
    {
        $containers = $this->where('status', 'published')
                          ->orderBy('created_at', 'DESC')
                          ->findAll();

        foreach ($containers as &$container) {
            $container['layout_meta'] = json_decode($container['layout_meta'], true);
        }

        return $containers;
    }

    /**
     * Get container with full content by slug
     * @param string $slug
     * @return array|null
     */
    public function getContainerBySlug($slug)
    {
        $container = $this->where('slug', $slug)
                         ->where('status', 'published')
                         ->first();

        if ($container) {
            $container['layout_meta'] = json_decode($container['layout_meta'], true);
            $container['content'] = $this->getContainerContent($container['content_file']);
        }

        return $container;
    }

    /**
     * Create a new container
     * @param array $data Container data
     * @return bool|int
     */
    public function createContainer($data)
    {
        // Prepare layout meta
        $layoutMeta = json_encode([
            'image' => $data['image'] ?? '',
            'title' => $data['display_title'] ?? $data['title'],
            'description' => $data['description'] ?? ''
        ]);

        // Generate content file name
        $contentFile = 'container-' . time() . '.json';

        // Prepare container data
        $containerData = [
            'title' => $data['title'],
            'slug' => $this->createUniqueSlug($data['title']),
            'layout_meta' => $layoutMeta,
            'content_file' => $contentFile,
            'status' => $data['status'] ?? 'draft'
        ];

        // Create content file
        $this->saveContainerContent($contentFile, $data['content'] ?? ['sections' => []]);

        // Insert into database
        return $this->insert($containerData);
    }

    /**
     * Update container
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateContainer($id, $data)
    {
        $container = $this->find($id);
        if (!$container) {
            return false;
        }

        // Update layout meta if provided
        if (isset($data['image']) || isset($data['display_title']) || isset($data['description'])) {
            $currentMeta = json_decode($container['layout_meta'], true);
            $layoutMeta = json_encode([
                'image' => $data['image'] ?? $currentMeta['image'],
                'title' => $data['display_title'] ?? $currentMeta['title'],
                'description' => $data['description'] ?? $currentMeta['description']
            ]);
            $data['layout_meta'] = $layoutMeta;
        }

        // Update content file if content provided
        if (isset($data['content'])) {
            $this->saveContainerContent($container['content_file'], $data['content']);
            unset($data['content']);
        }

        // Update database record
        return $this->update($id, $data);
    }

    /**
     * Delete container and its content file
     * @param int $id
     * @return bool
     */
    public function deleteContainer($id)
    {
        $container = $this->find($id);
        if (!$container) {
            return false;
        }

        // Delete content file
        $contentFile = $this->contentPath . $container['content_file'];
        if (file_exists($contentFile)) {
            unlink($contentFile);
        }

        // Delete database record
        return $this->delete($id);
    }

    /**
     * Get container content from JSON file
     * @param string $filename
     * @return array
     */
    protected function getContainerContent($filename)
    {
        $filepath = $this->contentPath . $filename;
        if (!file_exists($filepath)) {
            return ['sections' => []];
        }

        $content = file_get_contents($filepath);
        return json_decode($content, true) ?? ['sections' => []];
    }

    /**
     * Save container content to JSON file
     * @param string $filename
     * @param array $content
     * @return bool
     */
    protected function saveContainerContent($filename, $content)
    {
        return file_put_contents(
            $this->contentPath . $filename,
            json_encode($content, JSON_PRETTY_PRINT)
        ) !== false;
    }

    /**
     * Create unique slug from title
     * @param string $title
     * @return string
     */
    protected function createUniqueSlug($title)
    {
        $slug = url_title($title, '-', true);
        $count = 0;
        $originalSlug = $slug;
        
        while ($this->where('slug', $slug)->first()) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }
        
        return $slug;
    }
}