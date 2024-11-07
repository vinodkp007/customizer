<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class FooterManager extends BaseController
{
    protected $footerJsonPath;
    
    public function __construct()
    {
        $this->footerJsonPath = WRITEPATH . 'json/footer_config.json';
        
        // Create json directory if it doesn't exist
        if (!is_dir(WRITEPATH . 'json')) {
            mkdir(WRITEPATH . 'json', 0777, true);
        }
        
        // Create footer config file if it doesn't exist
        if (!file_exists($this->footerJsonPath)) {
            $defaultConfig = [
                'company_info' => [
                    'name' => 'Your Company Name',
                    'description' => 'Your company description here.',
                    'email' => 'info@example.com',
                    'phone' => '(123) 456-7890',
                    'address' => 'Your Address Here',
                    'founded_year' => '2020'
                ],
                'social_links' => []
            ];
            file_put_contents($this->footerJsonPath, json_encode($defaultConfig, JSON_PRETTY_PRINT));
        }
    }
    public function updateQuickLinks()
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Invalid request method');
        }
        
        try {
            $selectedLinks = $this->request->getPost('footer_links') ?? [];
            
            // Convert to integers
            $selectedLinks = array_map('intval', $selectedLinks);
            
            // Get current config
            $config = $this->getFooterConfig();
            
            // Add or update footer_links section
            $config['footer_links'] = $selectedLinks;
            
            // Save the updated config
            $this->saveFooterConfig($config);
            
            return redirect()->back()->with('success', 'Footer quick links updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Error updating footer quick links: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update footer quick links. Please try again.');
        }
    }
    private function getFooterConfig()
    {
        $config = json_decode(file_get_contents($this->footerJsonPath), true);
        
        // Ensure footer_links exists in config
        if (!isset($config['footer_links'])) {
            $config['footer_links'] = [];
            $this->saveFooterConfig($config);
        }
        
        return $config;
    }
    
    private function saveFooterConfig($config)
    {
        file_put_contents($this->footerJsonPath, json_encode($config, JSON_PRETTY_PRINT));
    }
    
    public function index()
    {
        $config = $this->getFooterConfig();
        $data = [
            'settings' => $config['company_info'],
            'socialLinks' => $config['social_links'],
            'title' => 'Footer Management'
        ];
        
        return view('admin/footer/manage', $data);
    }
    
    public function updateSettings()
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Invalid request method');
        }
        
        $settings = $this->request->getPost('settings');
        
        // Validate required fields
        $requiredFields = [
            'company_name', 'company_email', 'company_phone',
            'company_address', 'company_description'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($settings[$field])) {
                return redirect()->back()
                    ->with('error', ucfirst(str_replace('_', ' ', $field)) . ' is required')
                    ->withInput();
            }
        }
        
        // Validate email format
        if (!filter_var($settings['company_email'], FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->with('error', 'Invalid email format')
                ->withInput();
        }
        
        try {
            $config = $this->getFooterConfig();
            $config['company_info'] = $settings;
            $this->saveFooterConfig($config);
            
            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Error updating footer settings: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update settings. Please try again.')
                ->withInput();
        }
    }
    
    public function addSocialLink()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $platform = $this->request->getPost('platform');
        $url = $this->request->getPost('url');
        
        if (empty($platform) || empty($url)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Platform and URL are required'
            ]);
        }
        
        try {
            $config = $this->getFooterConfig();
            
            // Generate new ID
            $maxId = 0;
            foreach ($config['social_links'] as $link) {
                $maxId = max($maxId, $link['id']);
            }
            
            $newLink = [
                'id' => $maxId + 1,
                'platform' => $platform,
                'url' => $url,
                'icon' => 'fab fa-' . strtolower($platform), // Default icon
                'order_position' => count($config['social_links']) + 1,
                'is_active' => true
            ];
            
            $config['social_links'][] = $newLink;
            $this->saveFooterConfig($config);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Social link added successfully',
                'link' => $newLink
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error adding social link: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add social link'
            ]);
        }
    }
    
    public function deleteSocialLink($id = null)
    {
        if (!$this->request->is('post') || !$id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }
        
        try {
            $config = $this->getFooterConfig();
            
            // Filter out the link to delete
            $config['social_links'] = array_filter($config['social_links'], function($link) use ($id) {
                return $link['id'] != $id;
            });
            
            // Reset array keys
            $config['social_links'] = array_values($config['social_links']);
            
            $this->saveFooterConfig($config);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Social link deleted successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error deleting social link: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete social link'
            ]);
        }
    }
    
    public function updateSocialLinksOrder()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $order = $this->request->getJSON(true);
        
        if (!isset($order['order']) || !is_array($order['order'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid order data'
            ]);
        }
        
        try {
            $config = $this->getFooterConfig();
            
            // Update positions
            foreach ($order['order'] as $item) {
                foreach ($config['social_links'] as &$link) {
                    if ($link['id'] == $item['id']) {
                        $link['order_position'] = $item['position'];
                        break;
                    }
                }
            }
            
            // Sort the array by order_position
            usort($config['social_links'], function($a, $b) {
                return $a['order_position'] - $b['order_position'];
            });
            
            $this->saveFooterConfig($config);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error updating social links order: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update order'
            ]);
        }
    }
    
}