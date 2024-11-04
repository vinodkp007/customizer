<?php

namespace App\Controllers;

use App\Models\NavbarItemModel;
use App\Models\ContentPageModel;
use App\Models\ContentSectionModel;

class Content extends BaseController
{
    protected $navbarItemModel;
    protected $contentPageModel;
    protected $contentSectionModel;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->contentPageModel = new ContentPageModel();
        $this->contentSectionModel = new ContentSectionModel();
    }

    public function index($slug = '')
    {
        helper('url');

        // Debug all segments
        $uri = service('uri');
        log_message('debug', 'URI Path: ' . $uri->getPath());
        log_message('debug', 'Total segments: ' . $uri->getTotalSegments());
        
        // If no slug provided in the route parameter, try to get it from the last segment
        if (empty($slug)) {
            // Get all segments and find the last one
            $segments = $uri->getSegments();
            if (!empty($segments)) {
                $slug = end($segments);
            }
        }

        log_message('debug', 'Final slug being used: ' . $slug);

        // Initialize default data
        $data = [
            'title' => 'Exploring Nature\'s Beauty',
            'hero_title' => 'Exploring Nature\'s Beauty',
            'section_title' => 'The Journey Through Wilderness',
            'hero_image' => 'https://placehold.co/1920x400',
            'sections' => [
                [
                    'content' => 'Nature has always been a source of inspiration and wonder. From the towering peaks of ancient mountains to the gentle whisper of forest streams, every moment spent in the wilderness is a story waiting to be told. The raw beauty of untamed landscapes reminds us of our connection to the earth and the importance of preserving these natural sanctuaries for future generations.'
                ],
                [
                    'content' => 'As we venture deeper into these pristine environments, we discover not just the physical beauty of our natural world, but also the profound impact it has on our well-being. The crisp mountain air, the symphony of birdsong, and the intricate patterns of wildlife behavior all contribute to an experience that transcends ordinary existence.'
                ],
                [
                    'content' => 'Each journey into nature offers new perspectives and challenges our understanding of the world around us. Whether scaling steep cliffs, traversing dense forests, or simply sitting in quiet contemplation by a crystal-clear lake, these experiences shape our appreciation for the delicate balance of life on Earth.'
                ]
            ]
        ];

        if ($slug && $slug !== 'content') {
            try {
                // Find the navbar item by slug
                $navbarItem = $this->navbarItemModel
                    ->where('slug', $slug)
                    ->where('type', 'content')
                    ->where('is_active', 1)
                    ->first();

                log_message('debug', 'Looking for navbar item with slug: ' . $slug);

                if ($navbarItem) {
                    log_message('debug', 'Navbar item found: ' . json_encode($navbarItem));
                    
                    // Get content page data using the navbar item ID
                    $contentPage = $this->contentPageModel->findBySlug($slug);
                    
                    if ($contentPage) {
                        log_message('debug', 'Content page found: ' . json_encode($contentPage));
                        
                        // Override default data with database content
                        $data['title'] = $contentPage['title'];
                        $data['hero_title'] = $contentPage['hero_title'];
                        $data['section_title'] = $contentPage['section_title'];
                        
                        // Set hero image if exists
                        if (!empty($contentPage['hero_image'])) {
                            $data['hero_image'] = base_url($contentPage['hero_image']);
                        }

                        // Get sections if they exist
                        if (!empty($contentPage['sections'])) {
                            $data['sections'] = $contentPage['sections'];
                        }
                    } else {
                        log_message('debug', 'No content page found for navbar item ID: ' . $navbarItem['id']);
                    }
                } else {
                    log_message('debug', 'No navbar item found for slug: ' . $slug);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error processing content page: ' . $e->getMessage());
            }
        }

        // Load the content view
        return view('contentPage', $data);
    }
}