<?php

namespace App\Controllers;

use App\Models\NavbarItemModel;

class ContainerController extends BaseController
{
    protected $navbarItemModel;
    protected $jsonPath;
    protected $itemsPerPage = 9;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->jsonPath = WRITEPATH . 'container-content/';
    }

    public function index()
    {
        $containers = $this->navbarItemModel
            ->where('type', 'container')
            ->where('is_active', 1)
            ->orderBy('order_position', 'ASC')
            ->findAll();

        foreach ($containers as &$container) {
            $jsonFile = $this->jsonPath . $container['slug'] . '.json';
            $itemCount = 0;
            if (file_exists($jsonFile)) {
                $containerData = json_decode(file_get_contents($jsonFile), true);
                $itemCount = count(array_filter($containerData['items'] ?? [], function($item) {
                    return $item['status'] === 'published';
                }));
            }
            $container['item_count'] = $itemCount;
        }

        $data = [
            'title' => 'Learning Resources',
            'containers' => $containers
        ];

        return view('containers/index', $data);
    }

    public function view($slug)
    {
        // First, find the container by slug
        $container = $this->navbarItemModel
            ->where('type', 'container')
            ->where('is_active', 1)
            ->where('slug', $slug)
            ->first();

        if (!$container) {
            return redirect()->to('/containers')->with('error', 'Container not found');
        }

        // Get pagination parameters
        $page = (int)($this->request->getGet('page') ?? 1);
        $search = $this->request->getGet('search');

        // Get container items
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        $items = [];
        
        if (file_exists($jsonFile)) {
            $containerData = json_decode(file_get_contents($jsonFile), true);
            $items = $containerData['items'] ?? [];
            
            // Filter for published items only
            $items = array_filter($items, function($item) {
                return $item['status'] === 'published';
            });

            // Apply search if provided
            if (!empty($search)) {
                $items = array_filter($items, function($item) use ($search) {
                    return (
                        stripos($item['title'], $search) !== false ||
                        stripos($item['description'], $search) !== false
                    );
                });
            }

            // Re-index array after filtering
            $items = array_values($items);

            // Sort by latest first
            usort($items, function($a, $b) {
                return strtotime($b['updated_at']) - strtotime($a['updated_at']);
            });
        }

        // Pagination
        $totalItems = count($items);
        $totalPages = max(1, ceil($totalItems / $this->itemsPerPage));
        $currentPage = min(max(1, $page), $totalPages);
        $offset = ($currentPage - 1) * $this->itemsPerPage;
        $paginatedItems = array_slice($items, $offset, $this->itemsPerPage);

        $data = [
            'title' => $container['title'],
            'container' => $container,
            'items' => $paginatedItems,
            'search' => $search,
            'pager' => [
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'totalItems' => $totalItems,
                'startItem' => $offset + 1,
                'endItem' => min($offset + $this->itemsPerPage, $totalItems),
                'itemsPerPage' => $this->itemsPerPage
            ]
        ];

        return view('containers/view', $data);
    }

    // Display single item
    public function item($slug, $itemId)
    {
        $container = $this->navbarItemModel
            ->where('type', 'container')
            ->where('is_active', 1)
            ->where('slug', $slug)
            ->first();

        if (!$container) {
            return redirect()->to('/containers')->with('error', 'Container not found');
        }

        // Get item data
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        $item = null;

        if (file_exists($jsonFile)) {
            $containerData = json_decode(file_get_contents($jsonFile), true);
            foreach ($containerData['items'] ?? [] as $containerItem) {
                if ($containerItem['id'] === $itemId && $containerItem['status'] === 'published') {
                    $item = $containerItem;
                    break;
                }
            }
        }

        if (!$item) {
            return redirect()->to('/containers/' . $slug)->with('error', 'Item not found');
        }

        $data = [
            'title' => $item['title'],
            'container' => $container,
            'item' => $item
        ];

        return view('containers/item', $data);
    }
}