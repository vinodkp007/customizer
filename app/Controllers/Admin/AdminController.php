<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;
use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');

        }
        return view('admin/login');
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
    public function dashboard()
    {
        return view('admin/dashboard');
    }
}
