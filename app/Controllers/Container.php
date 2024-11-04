<?php

namespace App\Controllers;

class Container extends BaseController
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
        return view('containerPage', $data);
    }
    
   
   
}