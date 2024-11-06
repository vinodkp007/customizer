<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Container extends BaseController
{
    protected $jsonPath;
    
    public function __construct()
    {
        $this->jsonPath = WRITEPATH . 'container-content/';
    }

    // This method handles the category listing (e.g., /container/java)
    public function category($slug)
    {
        try {
            // Load the specific category file (e.g., java.json)
            $categoryFile = $this->jsonPath . $slug . '.json';
            if (!file_exists($categoryFile)) {
                throw PageNotFoundException::forPageNotFound();
            }
            
            $categoryData = json_decode(file_get_contents($categoryFile), true);
            if (!$categoryData) {
                throw PageNotFoundException::forPageNotFound();
            }

            // Get all items for this category
            $items = $categoryData['items'] ?? [];
            
            // Implement pagination
            $page = (int)($this->request->getVar('page') ?? 1);
            $perPage = 6;
            $totalItems = count($items);
            
            // Calculate paginated items
            $start = ($page - 1) * $perPage;
            $paginatedItems = array_slice($items, $start, $perPage);
            
            // Configure pager
            $pager = service('pager');
            $pager->setPath("container/$slug");
            $pager->makeLinks($page, $perPage, $totalItems);
            
            // Get category info from containers.json
            $containersJson = file_get_contents($this->jsonPath . 'containers.json');
            $containersData = json_decode($containersJson, true);
            $categoryInfo = null;
            
            foreach ($containersData['containers'] as $container) {
                if ($container['slug'] === $slug) {
                    $categoryInfo = $container;
                    break;
                }
            }
            
            return view('categoryPage', [
                'title' => $categoryInfo['title'] ?? ucfirst($slug),
                'category' => $categoryInfo,
                'items' => $paginatedItems,
                'pager' => $pager
            ]);
            
        } catch (\Exception $e) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    // This method handles individual item view (e.g., /container/java/item/123)
    public function item($categorySlug, $itemId)
    {
        try {
            // Load the category file
            $categoryFile = $this->jsonPath . $categorySlug . '.json';
            if (!file_exists($categoryFile)) {
                throw PageNotFoundException::forPageNotFound();
            }
            
            $categoryData = json_decode(file_get_contents($categoryFile), true);
            if (!$categoryData) {
                throw PageNotFoundException::forPageNotFound();
            }
            
            // Find the specific item
            $item = null;
            foreach ($categoryData['items'] as $containerItem) {
                if ($containerItem['id'] === $itemId) {
                    $item = $containerItem;
                    break;
                }
            }
            
            if (!$item) {
                throw PageNotFoundException::forPageNotFound();
            }
            
            return view('containerItem', [
                'title' => $item['title'],
                'item' => $item,
                'category' => $categorySlug
            ]);
            
        } catch (\Exception $e) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    // This method shows the main categories listing (e.g., /container)
    public function index()
    {
        try {
            // Load main containers list
            $containersJson = file_get_contents($this->jsonPath . 'containers.json');
            $containersData = json_decode($containersJson, true);
            
            // Implement pagination
            $page = (int)($this->request->getVar('page') ?? 1);
            $perPage = 6;
            $totalContainers = count($containersData['containers'] ?? []);
            
            // Calculate paginated containers
            $start = ($page - 1) * $perPage;
            $paginatedContainers = array_slice($containersData['containers'] ?? [], $start, $perPage);
            
            // Configure pager
            $pager = service('pager');
            $pager->setPath('container');
            $pager->makeLinks($page, $perPage, $totalContainers);
            
            return view('containerPage', [
                'title' => 'Categories',
                'containers' => $paginatedContainers,
                'pager' => $pager
            ]);
            
        } catch (\Exception $e) {
            return view('containerPage', [
                'title' => 'Categories',
                'containers' => [],
                'pager' => service('pager')
            ]);
        }
    }
}