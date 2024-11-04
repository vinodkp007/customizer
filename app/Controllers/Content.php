<?php

namespace App\Controllers;

class Content extends BaseController
{
    public function index()
    
    {
        // Add helper to use base_url() function if not already loaded
        helper('url');
        
        // Load essential data for the container page
        $data = [
            'title' => 'Container Page',
            'description' => 'Dynamic container page for custom content'
        ];
        
        // You can process any additional data or business logic here
        
        // Load the content view
        return view('contentPage', $data);
    }
    
    /**
     * Load dynamic content based on parameters
     * This can be extended later for more dynamic content handling
     */
    public function load($page = null)
    {
        if ($page === null) {
            return redirect()->to('/container');
        }
        
        $data = [
            'title' => ucfirst($page),
            'page' => $page
        ];
        
        // Check if the view exists
        if (is_file(APPPATH . 'Views/content/' . $page . '.php')) {
            return view('content/' . $page, $data);
        } else {
            // Load default content page if specific page not found
            return view('contentPage', $data);
        }
    }
}