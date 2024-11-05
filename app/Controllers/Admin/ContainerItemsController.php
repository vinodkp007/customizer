<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NavbarItemModel;

class ContainerItemsController extends BaseController
{
    protected $navbarItemModel;
    protected $jsonPath;
    protected $itemsPerPage = 8;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->jsonPath = WRITEPATH . 'container-content/';
        if (!is_dir($this->jsonPath)) {
            mkdir($this->jsonPath, 0755, true);
        }
    }
    
     public function edit($containerId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        // Debug logs
        log_message('debug', 'Container ID: ' . $containerId);
        log_message('debug', 'Container data: ' . print_r($container, true));

        // Initialize view data
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $page = (int)($this->request->getGet('page') ?? 1);

        // Get items
        $items = $this->getContainerItems($container['slug'], $search, $status);
        log_message('debug', 'Total items found: ' . count($items));

        // Pagination
        $totalItems = count($items);
        $totalPages = max(1, ceil($totalItems / $this->itemsPerPage));
        $currentPage = min(max(1, $page), $totalPages);
        $offset = ($currentPage - 1) * $this->itemsPerPage;
        $paginatedItems = array_slice($items, $offset, $this->itemsPerPage);

        $data = [
            'title' => 'Edit Container: ' . $container['title'],
            'container' => $container,
            'items' => $paginatedItems,
            'search' => $search,
            'status' => $status,
            'pager' => [
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'totalItems' => $totalItems,
                'startItem' => $offset + 1,
                'endItem' => min($offset + $this->itemsPerPage, $totalItems),
                'itemsPerPage' => $this->itemsPerPage
            ]
        ];

        log_message('debug', 'View data: ' . print_r($data, true));
        return view('admin/containers/edit', $data);
    }

    protected function getContainerItems($slug, $search = '', $status = '')
    {
        $jsonFile = $this->jsonPath . $slug . '.json';
        log_message('debug', 'Loading JSON file: ' . $jsonFile);

        if (!file_exists($jsonFile)) {
            log_message('debug', 'Creating new JSON file for: ' . $slug);
            $emptyContainer = ['items' => []];
            file_put_contents($jsonFile, json_encode($emptyContainer, JSON_PRETTY_PRINT));
            return [];
        }

        $jsonContent = file_get_contents($jsonFile);
        $containerData = json_decode($jsonContent, true);
        
        if (!isset($containerData['items'])) {
            log_message('debug', 'No items array found in JSON');
            return [];
        }

        $items = $containerData['items'];
        log_message('debug', 'Initial items count: ' . count($items));

        // Apply search filter
        if (!empty($search)) {
            $items = array_filter($items, function($item) use ($search) {
                return (
                    stripos($item['title'] ?? '', $search) !== false ||
                    stripos($item['description'] ?? '', $search) !== false ||
                    stripos($item['content'] ?? '', $search) !== false
                );
            });
            $items = array_values($items);
            log_message('debug', 'Items after search filter: ' . count($items));
        }

        // Apply status filter
        if (!empty($status)) {
            $items = array_filter($items, function($item) use ($status) {
                return ($item['status'] ?? '') === $status;
            });
            $items = array_values($items);
            log_message('debug', 'Items after status filter: ' . count($items));
        }

        // Sort by updated_at
        usort($items, function($a, $b) {
            $dateA = strtotime($a['updated_at'] ?? '0000-00-00');
            $dateB = strtotime($b['updated_at'] ?? '0000-00-00');
            return $dateB - $dateA;
        });

        return $items;
    }
    protected function getFilteredItems($slug, $search = '', $status = '')
    {
        $items = [];
        $jsonFile = $this->jsonPath . $slug . '.json';

        if (file_exists($jsonFile)) {
            $containerData = json_decode(file_get_contents($jsonFile), true);
            $items = $containerData['items'] ?? [];

            // Apply filters
            if (!empty($search) || !empty($status)) {
                $items = array_filter($items, function($item) use ($search, $status) {
                    // Search filter
                    $matchesSearch = empty($search) || 
                        stripos($item['title'], $search) !== false || 
                        stripos($item['description'] ?? '', $search) !== false || 
                        stripos($item['content'], $search) !== false;

                    // Status filter
                    $matchesStatus = empty($status) || $item['status'] === $status;

                    return $matchesSearch && $matchesStatus;
                });

                // Re-index array after filtering
                $items = array_values($items);
            }

            // Sort by updated_at
            usort($items, function($a, $b) {
                return strtotime($b['updated_at'] ?? 0) - strtotime($a['updated_at'] ?? 0);
            });
        }

        return $items;
    }
    
    public function addItem($containerId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        $data = [
            'title' => 'Add New Item',
            'container' => $container
        ];

        return view('admin/containers/item-form', $data);
    }

    public function storeItem($containerId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        // Updated validation rules to include description
        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'content' => 'required',
            'status' => 'required|in_list[published,draft]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle image upload
        $image = null;
        if ($uploadedFile = $this->request->getFile('image')) {
            if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
                $newName = $uploadedFile->getRandomName();
                $uploadedFile->move(FCPATH . 'uploads/containers', $newName);
                $image = 'uploads/containers/' . $newName;
            }
        }

        // Updated item data structure to include description
        $newItem = [
            'id' => uniqid(),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'image' => $image,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Get existing content or create new structure
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        $containerData = [];
        
        if (file_exists($jsonFile)) {
            $containerData = json_decode(file_get_contents($jsonFile), true) ?? [];
        }

        if (!isset($containerData['items'])) {
            $containerData['items'] = [];
        }

        // Add new item
        $containerData['items'][] = $newItem;

        // Save to JSON file
        if (file_put_contents($jsonFile, json_encode($containerData, JSON_PRETTY_PRINT))) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('success', 'Item added successfully');
        }

        return redirect()->back()->withInput()
                       ->with('error', 'Failed to add item');
    }

    public function updateItem($containerId, $itemId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        // Updated validation rules to include description
        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'content' => 'required',
            'status' => 'required|in_list[published,draft]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get container data
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        $containerData = json_decode(file_get_contents($jsonFile), true);

        // Handle image upload
        $image = null;
        if ($uploadedFile = $this->request->getFile('image')) {
            if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
                $newName = $uploadedFile->getRandomName();
                $uploadedFile->move(FCPATH . 'uploads/containers', $newName);
                $image = 'uploads/containers/' . $newName;
            }
        }

        // Update the specific item
        foreach ($containerData['items'] as &$item) {
            if ($item['id'] === $itemId) {
                // Keep existing image if no new image uploaded
                if (!$image) {
                    $image = $item['image'] ?? null;
                } else {
                    // Delete old image if exists
                    if (isset($item['image']) && file_exists(FCPATH . $item['image'])) {
                        unlink(FCPATH . $item['image']);
                    }
                }

                $item['title'] = $this->request->getPost('title');
                $item['description'] = $this->request->getPost('description');
                $item['content'] = $this->request->getPost('content');
                $item['status'] = $this->request->getPost('status');
                $item['image'] = $image;
                $item['updated_at'] = date('Y-m-d H:i:s');
                break;
            }
        }

        // Save updated data
        if (file_put_contents($jsonFile, json_encode($containerData, JSON_PRETTY_PRINT))) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('success', 'Item updated successfully');
        }

        return redirect()->back()->withInput()
                       ->with('error', 'Failed to update item');
    }


    public function editItem($containerId, $itemId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        // Get container data from JSON
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        if (!file_exists($jsonFile)) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('error', 'Container data not found');
        }

        $containerData = json_decode(file_get_contents($jsonFile), true);
        $item = null;

        // Find the specific item
        foreach ($containerData['items'] as $existingItem) {
            if ($existingItem['id'] === $itemId) {
                $item = $existingItem;
                break;
            }
        }

        if (!$item) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('error', 'Item not found');
        }

        $data = [
            'title' => 'Edit Item',
            'container' => $container,
            'item' => $item
        ];

        return view('admin/containers/item-form', $data);
    }

    public function deleteItem($containerId, $itemId)
    {
        $container = $this->navbarItemModel->find($containerId);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        if (!file_exists($jsonFile)) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('error', 'Container data not found');
        }

        $containerData = json_decode(file_get_contents($jsonFile), true);
        $imageToDelete = null;

        // Remove item and get image path if exists
        foreach ($containerData['items'] as $key => $item) {
            if ($item['id'] === $itemId) {
                $imageToDelete = $item['image'] ?? null;
                unset($containerData['items'][$key]);
                break;
            }
        }

        // Reindex array
        $containerData['items'] = array_values($containerData['items']);

        // Delete associated image if exists
        if ($imageToDelete && file_exists(FCPATH . $imageToDelete)) {
            unlink(FCPATH . $imageToDelete);
        }

        // Save updated data
        if (file_put_contents($jsonFile, json_encode($containerData, JSON_PRETTY_PRINT))) {
            return redirect()->to('admin/containers/edit/' . $containerId)
                           ->with('success', 'Item deleted successfully');
        }

        return redirect()->back()
                       ->with('error', 'Failed to delete item');
    }
}