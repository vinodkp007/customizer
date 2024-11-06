<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NavbarItemModel;

class ContainersController extends BaseController
{
    protected $navbarItemModel;
    protected $jsonPath;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->jsonPath = WRITEPATH . 'container-content/';
        if (!is_dir($this->jsonPath)) {
            mkdir($this->jsonPath, 0755, true);
        }
    }

    public function index()
    {
        // Get ALL container pages, regardless of status
        $containerPages = $this->navbarItemModel
            ->where('type', 'container')
            ->orderBy('order_position', 'ASC')
            ->findAll();

        // Format the data to match the view requirements
        $containers = array_map(function($page) {
            return [
                'id' => $page['id'],
                'title' => $page['title'],
                'slug' => $page['slug'],
                'status' => $page['is_active'] ? 'published' : 'draft',
                'description' => 'Container page for ' . $page['title'],
                'updated_at' => $page['updated_at'] ?? date('Y-m-d H:i:s')
            ];
        }, $containerPages);

        $data = [
            'title' => 'Container Pages',
            'containers' => $containers
        ];

        return view('admin/containers/index', $data);
    }

    public function edit($id)
    {
        $container = $this->navbarItemModel->find($id);
        if (!$container) {
            return redirect()->to('admin/containers')->with('error', 'Container not found');
        }

        // Get container content from JSON
        $containerContent = [];
        $jsonFile = $this->jsonPath . $container['slug'] . '.json';
        if (file_exists($jsonFile)) {
            $containerContent = json_decode(file_get_contents($jsonFile), true);
        }

        $data = [
            'title' => 'Edit Container: ' . $container['title'],
            'container' => $container,
            'content' => $containerContent
        ];

        return view('admin/containers/edit', $data);
    }

    public function updateMetadata($id)
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'status' => 'required|in_list[published,draft]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => url_title($this->request->getPost('title'), '-', true),
            'is_active' => $this->request->getPost('status') === 'published' ? 1 : 0
        ];

        if ($this->navbarItemModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Container metadata updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update container metadata');
    }

    // Other methods remain the same...
}