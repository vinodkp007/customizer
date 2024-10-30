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
                            
        $html = '<nav class="navbar">';
        $html .= '<ul class="nav-links" id="navLinks">';
        
        foreach ($items as $item) {
            $url = base_url($item['type'] . '/' . $item['slug']);
            if ($item['type'] === 'home') {
                $url = base_url();
            }
            
            $html .= sprintf(
                '<li><a href="%s" data-page="%s">%s</a></li>',
                esc($url),
                esc($item['type']),
                esc($item['title'])
            );
        }
        
        $html .= '</ul>';
        $html .= '</nav>';
        
        return $html;
    }
}
