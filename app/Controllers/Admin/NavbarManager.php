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
            'order_position' => $this->navbarItemModel->countAll() + 1
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
        return redirect()->to('/admin');
    }

    $ids = json_decode($this->request->getPost('ids'), true); // Added true to get array
    
    if ($ids && is_array($ids)) {
        try {
            // Begin transaction
            $this->navbarItemModel->db->transBegin();
            
            foreach ($ids as $position => $id) {
                // Properly specify the WHERE clause in the update
                $this->navbarItemModel->where('id', $id)
                                    ->set('order_position', $position + 1)
                                    ->update();
            }

            // Commit if all went well
            if ($this->navbarItemModel->db->transStatus() === false) {
                $this->navbarItemModel->db->transRollback();
                session()->setFlashdata('error', 'Failed to update order');
            } else {
                $this->navbarItemModel->db->transCommit();
                session()->setFlashdata('success', 'Order updated successfully');
            }
        } catch (\Exception $e) {
            $this->navbarItemModel->db->transRollback();
            log_message('error', 'Error updating order: ' . $e->getMessage());
            session()->setFlashdata('error', 'Failed to update order');
        }
    } else {
        session()->setFlashdata('error', 'Invalid order data provided');
    }

    return redirect()->back();
}
}