<?php
// app/Helpers/navbar_helper.php
if (!function_exists('generate_navbar')) {
    function generate_navbar() {
        $db = \Config\Database::connect();
        $navbarModel = new \App\Models\NavbarItemModel();
        
        // Get active navbar items ordered by position
        $items = $navbarModel->where('is_active', 1)
                            ->orderBy('order_position', 'ASC')
                            ->findAll();
                            
        $html = '<nav class="navbar" id="mainNav">';
        $html .= '<div class="nav-container">';
        
        // Logo section
        $html .= '<a href="' . base_url() . '" class="logo-container">';
        $html .= '<img src="' . base_url('assets/images/logo.png') . '" alt="Logo" class="logo-img">';
        $html .= '</a>';
        
        // Navigation links
        $html .= '<ul class="nav-links">';
        
        foreach ($items as $item) {
            $url = base_url($item['type'] . '/' . $item['slug']);
            if ($item['type'] === 'home') {
                $url = base_url();
            }
            
            // Check if current page matches the item type for active state
            $isActive = current_url() === $url ? 'active' : '';
            
            $html .= sprintf(
                '<li><a href="%s" class="%s" data-page="%s">%s</a></li>',
                esc($url),
                $isActive,
                esc($item['type']),
                esc($item['title'])
            );
        }
        
        $html .= '</ul>';
        $html .= '</div>'; // Close nav-container
        $html .= '</nav>';
        
        return $html;
    }
}