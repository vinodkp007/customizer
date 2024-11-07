<?php
// app/Helpers/footer_helper.php

if (!function_exists('get_footer_config')) {
    function get_footer_config() {
        $jsonPath = WRITEPATH . 'json/footer_config.json';
        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        }
        return null;
    }
}

if (!function_exists('generate_footer')) {
    function generate_footer() {
        $config = get_footer_config();
        if (!$config) return '';
        
        $companyInfo = $config['company_info'];
        $socialLinks = $config['social_links'];
        
        // Initialize NavbarItemModel
        $navbarModel = new \App\Models\NavbarItemModel();
        
        // Start building footer HTML
        $html = '<footer class="main-footer">';
        $html .= '<div class="footer-wrapper">';
        
        // Left Section - About Company
        $html .= '<div class="footer-left">';
        $html .= '<h3 class="company-name">' . esc($companyInfo['company_name']) . '</h3>';
        $html .= '<p class="company-desc">' . esc($companyInfo['company_description']) . '</p>';
        
        // Social Links
        if (!empty($socialLinks)) {
            $html .= '<div class="social-links">';
            foreach ($socialLinks as $link) {
                if ($link['is_active']) {
                    $html .= sprintf(
                        '<a href="%s" target="_blank"><i class="%s"></i></a>',
                        esc($link['url']),
                        esc($link['icon'])
                    );
                }
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        
        // Middle Section - Quick Links from NavbarItemModel
        $html .= '<div class="footer-middle">';
$html .= '<h4>Quick Links</h4>';
$html .= '<div class="quick-links">';

// Get navbar items that are selected for footer
$navbarModel = new \App\Models\NavbarItemModel();
$footerConfig = json_decode(file_get_contents(WRITEPATH . 'json/footer_config.json'), true);
$selectedLinks = $footerConfig['footer_links'] ?? [];

if (!empty($selectedLinks)) {
    $navItems = $navbarModel->whereIn('id', $selectedLinks)
                           ->where('is_active', 1)
                           ->orderBy('order_position', 'ASC')
                           ->findAll();
    
    if (!empty($navItems)) {
        $totalItems = count($navItems);
        $halfCount = ceil($totalItems / 2);
        
        // First column
        $html .= '<ul class="links-column">';
        for ($i = 0; $i < $halfCount; $i++) {
            if (isset($navItems[$i])) {
                $url = base_url($navItems[$i]['type'] . '/' . $navItems[$i]['slug']);
                if ($navItems[$i]['type'] === 'home') {
                    $url = base_url();
                }
                
                $html .= sprintf(
                    '<li><a href="%s">%s</a></li>',
                    esc($url),
                    esc($navItems[$i]['title'])
                );
            }
        }
        $html .= '</ul>';
        
        // Second column
        $html .= '<ul class="links-column">';
        for ($i = $halfCount; $i < $totalItems; $i++) {
            if (isset($navItems[$i])) {
                $url = base_url($navItems[$i]['type'] . '/' . $navItems[$i]['slug']);
                if ($navItems[$i]['type'] === 'home') {
                    $url = base_url();
                }
                
                $html .= sprintf(
                    '<li><a href="%s">%s</a></li>',
                    esc($url),
                    esc($navItems[$i]['title'])
                );
            }
        }
        $html .= '</ul>';
    }
} else {
    // Fallback to default links if no items are selected
    $html .= '<ul class="links-column">';
    $html .= '<li><a href="' . base_url() . '">Home</a></li>';
    $html .= '<li><a href="' . base_url('about') . '">About</a></li>';
    $html .= '</ul>';
}

$html .= '</div>'; // close quick-links
$html .= '</div>'; // close footer-middle
        
        // Right Section - Contact Info
        $html .= '<div class="footer-right">';
        $html .= '<h4>Contact Info</h4>';
        $html .= '<div class="contact-info">';
        $html .= '<p><i class="fas fa-envelope"></i> ' . esc($companyInfo['company_email']) . '</p>';
        $html .= '<p><i class="fas fa-phone"></i> ' . esc($companyInfo['company_phone']) . '</p>';
        $html .= '<p><i class="fas fa-map-marker-alt"></i> ' . esc($companyInfo['company_address']) . '</p>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>'; // close footer-wrapper
        
        // Footer Bottom
        $html .= '<div class="footer-bottom">';
        $html .= '<p>&copy; ' . date('Y') . ' ' . esc($companyInfo['company_name']) . '. All rights reserved.</p>';
        $html .= '</div>';
        
        $html .= '</footer>';
        
        return $html;
    }
}