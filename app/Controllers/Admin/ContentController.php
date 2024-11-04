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

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->contentPageModel = new ContentPageModel();
        $this->contentSectionModel = new ContentSectionModel();
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
    public function modify()
    {
        // Get all content type pages from navbar_items table

        // Load the view with the data
        return view('admin/contentModify');
    }

}