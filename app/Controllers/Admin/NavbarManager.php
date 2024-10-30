<?php
namespace App\Controllers\Admin;

use App\Models\NavbarItemModel;
use App\Controllers\BaseController;

class NavbarManager extends BaseController 
{
    private $navbarItemModel;

    public function __construct() 
    {
        $this->navbarItemModel = new NavbarItemModel();
    }

    public function index() 
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }
        $data['navbarItems'] = $this->navbarItemModel->findAll();
        return view('admin/editNavbar', $data);
    }

    public function add() 
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type'),
            'slug' => url_title($this->request->getPost('title'), '-', true),
            'order_position' => $this->navbarItemModel->countAll() + 1,
        ];

        try {
            if ($this->navbarItemModel->insert($data)) {
                session()->setFlashdata('success', 'Navbar item added successfully');
            } else {
                session()->setFlashdata('error', 'Failed to add navbar item');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding navbar item: ' . $e->getMessage());
            session()->setFlashdata('error', 'Server error while adding item');
        }

        return redirect()->back();
    }

    public function delete($id = null) 
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        if ($id && $this->navbarItemModel->delete($id)) {
            session()->setFlashdata('success', 'Item deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete item');
        }

        return redirect()->back();
    }

    public function updateOrder() 
{
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Not authorized'
        ]);
    }

    $itemOrder = json_decode($this->request->getPost('itemOrder'), true);
    
    if (!$itemOrder || !is_array($itemOrder)) {
        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Invalid data received'
        ]);
    }

    try {
        $db = \Config\Database::connect();
        $db->transStart();
        
        foreach ($itemOrder as $item) {
            if (isset($item['id']) && isset($item['position'])) {
                $db->table('navbar_items')
                   ->where('id', $item['id'])
                   ->update(['order_position' => $item['position']]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Transaction failed in updateOrder');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update order'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Navigation order updated successfully'
        ]);

    } catch (\Exception $e) {
        log_message('error', 'Error updating order: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error updating order: ' . $e->getMessage()
        ]);
    }
}
}