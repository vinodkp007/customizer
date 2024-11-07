<?php
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\GalleryPageModel;
use App\Models\GalleryItemModel;
use App\Models\NavbarItemModel;

class GalleryController extends Controller
{
    protected $galleryPageModel;
    protected $galleryItemModel;
    protected $navbarItemModel;
    protected $db;

    public function __construct()
    {
        $this->galleryPageModel = new GalleryPageModel();
        $this->galleryItemModel = new GalleryItemModel();
        $this->navbarItemModel = new NavbarItemModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Get all gallery type pages from navbar_items table
        $data['galleryPages'] = $this->navbarItemModel
            ->where('type', 'gallery')
            ->where('is_active', 1)
            ->orderBy('order_position', 'ASC')
            ->findAll();
    
    
        // Load the view with the data
        return view('admin/editGalleryPages', $data);
    }

    public function modify($navbarItemId = null)
    {
        if (!$navbarItemId) {
            return redirect()->to(base_url('admin/gallery'))
                ->with('error', 'No gallery page ID provided');
        }

        // Get the gallery page with its items using the model method
        $galleryPage = $this->galleryPageModel->getGalleryPageWithItems($navbarItemId);

        $data = [
            'gallery_page_id' => $navbarItemId,
            'isEdit' => false,
            'content' => null
        ];

        if ($galleryPage) {
            $data['isEdit'] = true;
            $data['content'] = [
                'page_id' => $galleryPage['id'],
                'page_title' => $galleryPage['page_title'],
                'page_slug' => $galleryPage['page_slug'],
                'meta_description' => $galleryPage['meta_description'],
                'meta_keywords' => $galleryPage['meta_keywords'],
                'items' => array_map(function($item) {
                    return [
                        'id' => $item['id'],
                        'image' => $item['image'],
                        'title' => $item['title'],
                        'description' => $item['description'],
                        'alt_text' => $item['alt_text'],
                        'display_order' => $item['display_order'],
                        'is_active' => $item['is_active']
                    ];
                }, $galleryPage['items'])
            ];

            usort($data['content']['items'], function($a, $b) {
                return $a['display_order'] - $b['display_order'];
            });
        }

        return view('admin/ModifyGallery', $data);
    }

    public function save()
{
    $this->db->transStart();

    try {
        $navbarItemId = $this->request->getPost('gallery_page_id');
        $pageTitle = $this->request->getPost('page_title');

        // Create upload directory if it doesn't exist
        $uploadPath = FCPATH . 'uploads/gallery';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Prepare meta data
        $metaDescription = $this->request->getPost('meta_description') ?? $pageTitle . ' - Gallery Page';
        $metaKeywords = $this->request->getPost('meta_keywords') ?? 'gallery, ' . strtolower(str_replace(' ', ', ', $pageTitle));

        // Check if page exists
        $existingPage = $this->galleryPageModel->getByNavbarItemId($navbarItemId);

        $pageData = [
            'page_title' => $pageTitle,
            'page_slug' => url_title($pageTitle, '-', true),
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
            'navbar_item_id' => $navbarItemId
        ];

        if ($existingPage) {
            // Update existing page
            $success = $this->galleryPageModel->update($existingPage['id'], $pageData);
            $galleryPageId = $existingPage['id'];
        } else {
            // Create new page
            $galleryPageId = $this->galleryPageModel->insert($pageData);
            $success = $galleryPageId ? true : false;
        }

        if (!$success) {
            throw new \Exception('Failed to save gallery page');
        }

        // Process new images
        $images = $this->request->getFiles();
        if (!empty($images['new_images'])) {
            $newTitles = $this->request->getPost('new_titles') ?? [];
            $newDescriptions = $this->request->getPost('new_descriptions') ?? [];
            
            foreach ($images['new_images'] as $index => $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);
                    
                    $itemData = [
                        'gallery_page_id' => $galleryPageId,
                        'image' => 'uploads/gallery/' . $newName,
                        'title' => $newTitles[$index] ?? '',
                        'description' => $newDescriptions[$index] ?? '',
                        'display_order' => $index + 1,
                        'is_active' => 1,
                        'alt_text' => $newTitles[$index] ?? ''
                    ];
                    
                    if (!$this->galleryItemModel->insert($itemData)) {
                        throw new \Exception('Failed to insert gallery item');
                    }
                }
            }
        }

        // Update existing items
        $existingTitles = $this->request->getPost('item_titles') ?? [];
        $existingDescriptions = $this->request->getPost('item_descriptions') ?? [];
        $itemIds = $this->request->getPost('item_ids') ?? [];
        $existingImages = $this->request->getPost('existing_images') ?? [];

        foreach ($itemIds as $index => $itemId) {
            if (isset($existingTitles[$index], $existingDescriptions[$index])) {
                $updateData = [
                    'title' => $existingTitles[$index],
                    'description' => $existingDescriptions[$index],
                    'image' => $existingImages[$index]
                ];

                $this->galleryItemModel->update($itemId, $updateData);
            }
        }

        // Update item ordering
        $itemOrder = $this->request->getPost('item_order');
        if ($itemOrder) {
            $orderArray = json_decode($itemOrder, true);
            if (is_array($orderArray)) {
                $this->galleryItemModel->updatePositions($orderArray);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \Exception('Database transaction failed');
        }

        return redirect()->to(base_url("admin/gallery/modify/{$navbarItemId}"))
            ->with('success', 'Gallery saved successfully');

    } catch (\Exception $e) {
        $this->db->transRollback();
        log_message('error', '[Gallery Save] Exception: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}

    public function updateOrder()
    {
        try {
            $orderedItems = $this->request->getJSON(true);
            
            if (empty($orderedItems) || !is_array($orderedItems)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid order data provided'
                ]);
            }

            $positions = array_map(function($item) {
                return $item['id'];
            }, $orderedItems);

            $success = $this->galleryItemModel->updatePositions($positions);

            return $this->response->setJSON([
                'success' => $success,
                'message' => $success ? 'Order updated successfully' : 'Failed to update order'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Gallery Order Update] ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while updating the order'
            ])->setStatusCode(500);
        }
    }

    public function deleteItem($itemId)
{
    try {
        if (!$itemId) {
            return redirect()->back()->with('error', 'No item ID provided');
        }

        // Get the item first to check if it exists and get its gallery page ID
        $item = $this->galleryItemModel->find($itemId);
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        $galleryPageId = $item['gallery_page_id'];

        // Delete the item using the model method
        $success = $this->galleryItemModel->deleteWithImage($itemId);

        if ($success) {
            return redirect()->back()->with('success', 'Item deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete item');
        }

    } catch (\Exception $e) {
        log_message('error', '[Gallery Item Delete] Exception: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the item');
    }
}
}

   
