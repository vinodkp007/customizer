<?php
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\NavbarItemModel;
use App\Models\ContentPageModel;
use App\Models\ContentSectionModel;

class ContentController extends Controller
{
    protected $navbarItemModel;
    protected $contentPageModel;
    protected $contentSectionModel;
    protected $db;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->contentPageModel = new ContentPageModel();
        $this->contentSectionModel = new ContentSectionModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Get all content type pages from navbar_items table
        $data['contentPages'] = $this->navbarItemModel
            ->where('type', 'content')
            ->where('is_active', 1)
            ->orderBy('order_position', 'ASC')
            ->findAll();

        // Load the view with the data
        return view('admin/editContentPages', $data);
    }

    public function modify($navbarItemId = null)
{
    if (!$navbarItemId) {
        return redirect()->to(base_url('admin/content'))
            ->with('error', 'No navbar item ID provided');
    }

    // First check if this navbar item has an associated content page
    $contentPage = $this->contentPageModel
        ->where('navbar_item_id', $navbarItemId)
        ->first();

    $data = [
        'navbar_item_id' => $navbarItemId,
        'isEdit' => false,
        'content' => null
    ];

    if ($contentPage) {
        // If content page exists, get its sections
        $sections = $this->contentSectionModel
            ->where('content_page_id', $contentPage['id'])
            ->orderBy('order_position', 'ASC')
            ->findAll();

        $data['isEdit'] = true;
        $data['content'] = [
            'content_page_id' => $contentPage['id'],
            'hero_title' => $contentPage['hero_title'],
            'hero_image' => $contentPage['hero_image'],
            'section_title' => $contentPage['section_title'],
            'sections' => $sections
        ];
    }

    return view('admin/contentModify', $data);
}

    public function save()
    {
        // Extract navbar_item_id from the last segment of the URL if not in POST
        $navbarItemId = $this->request->getPost('navbar_item_id') ?? 
                       $this->request->uri->getSegment(5); // Adjust segment number if needed

        // Validation rules
        $rules = [
            'hero_title' => 'required|min_length[3]|max_length[255]',
            'section_title' => 'required|min_length[3]|max_length[255]',
            'paragraphs' => 'required|is_array'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('error', 'Validation failed: ' . json_encode($this->validator->getErrors()))
                ->withInput();
        }

        try {
            $this->db->transStart();

            // Handle image upload
            $heroImage = $this->handleImageUpload();

            // Prepare content page data with the navbar_item_id from URL
            $contentPageData = [
                'navbar_item_id' => $navbarItemId,
                'hero_title' => $this->request->getPost('hero_title'),
                'section_title' => $this->request->getPost('section_title')
            ];

            if ($heroImage) {
                $contentPageData['hero_image'] = $heroImage;
            }

            // Debug log
            log_message('debug', 'Attempting to save content page with data: ' . json_encode($contentPageData));

            // Insert or update content page
            $contentPageId = $this->request->getPost('content_page_id');
            
            if ($contentPageId) {
                $this->contentPageModel->update($contentPageId, $contentPageData);
                log_message('debug', 'Updated content page with ID: ' . $contentPageId);
            } else {
                // Force insert using insert() method
                $contentPageId = $this->contentPageModel->insert($contentPageData, true);
                log_message('debug', 'Inserted new content page with ID: ' . $contentPageId);

                if (!$contentPageId) {
                    throw new \Exception('Failed to insert content page. DB Error: ' . json_encode($this->contentPageModel->errors()));
                }
            }

            // Save sections if we have a valid content page ID
            if ($contentPageId) {
                $this->saveSections($contentPageId);
            } else {
                throw new \Exception('No valid content page ID after save operation');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to(base_url('admin/content'))
                ->with('success', 'Content page saved successfully');

        } catch (\Exception $e) {
            log_message('error', '[ContentController::save] Error: ' . $e->getMessage());
            
            if (!empty($heroImage) && file_exists(FCPATH . $heroImage)) {
                unlink(FCPATH . $heroImage);
            }

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function handleImageUpload()
    {
        $img = $this->request->getFile('hero_image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/content';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $newName = $img->getRandomName();
            $img->move($uploadPath, $newName);
            return 'uploads/content/' . $newName;
        }
        return '';
    }

    private function saveSections($contentPageId)
    {
        $paragraphs = $this->request->getPost('paragraphs');
        
        // Delete existing sections if updating
        $this->contentSectionModel->where('content_page_id', $contentPageId)->delete();

        // Insert new sections
        foreach ($paragraphs as $index => $content) {
            if (trim($content) !== '') {
                $this->contentSectionModel->insert([
                    'content_page_id' => $contentPageId,
                    'content' => trim($content),
                    'order_position' => $index + 1
                ]);
            }
        }
    }
}