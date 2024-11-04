<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\ConnectionInterface;

class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/login');
    }

    public function getDashboardStats()
    {
        $builder = $this->db->table('navbar_items');
        
        // Get content pages count
        $contentPages = $builder->where('type', 'content')
                              ->where('is_active', 1)
                              ->countAllResults();
        
        // Reset the builder to get fresh query
        $builder = $this->db->table('navbar_items');
        
        // Get containers count
        $containers = $builder->where('type', 'container')
                            ->where('is_active', 1)
                            ->countAllResults();
        
        // Reset the builder again
        $builder = $this->db->table('navbar_items');
        
        // Get total nav items
        $navItems = $builder->where('is_active', 1)
                          ->countAllResults();

        return [
            'content_pages' => $contentPages,
            'containers' => $containers,
            'nav_items' => $navItems
        ];
    }

    public function dashboard()
    {
        // Create the data array
        $data = [
            'stats' => $this->getDashboardStats()
        ];

        // Pass the data array to the view
        return view('admin/dashboard', $data);
    }

    public function login()
    {
        $session = session();
        $model = new AdminModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $data = $model->where('email', $email)->first();
        
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            
            if ($authenticatePassword) {
                $sessionData = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];
                
                $session->set($sessionData);
                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/admin');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/admin');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin');
    }

    public function contentPages()
    {
        return view('admin/editContentPages');
    }
}