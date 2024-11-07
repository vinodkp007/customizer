<?php

namespace App\Controllers;

use App\Models\NavbarItemModel;
use App\Models\GalleryPageModel;
use App\Models\GalleryItemModel;

class GalleryController extends BaseController
{
    protected $navbarItemModel;
    protected $galleryPageModel;
    protected $galleryItemModel;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
        $this->galleryPageModel = new GalleryPageModel();
        $this->galleryItemModel = new GalleryItemModel();
    }

    public function index($slug = null)
    {
        // Default featured collections data
        $defaultData = [
            'title' => 'Default Collections',
            'collections' => [
                [
                    'id' => 1,
                    'image' => 'https://picsum.photos/seed/1/800/600',
                    'title' => 'Natural Wonders',
                    'description' => 'Discover breathtaking landscapes and natural phenomena that showcase Earth\'s incredible beauty. From majestic mountains to serene lakes, experience nature at its finest.',
                    'button_text' => 'Explore More',
                    'alt_text' => 'Nature landscape'
                ],
                [
                    'id' => 2,
                    'image' => 'https://picsum.photos/seed/2/800/600',
                    'title' => 'Urban Exploration',
                    'description' => 'Journey through modern cityscapes and architectural marvels. Experience the pulse of urban life through stunning photography of city streets and skylines.',
                    'button_text' => 'Discover Cities',
                    'alt_text' => 'Urban architecture'
                ],
                [
                    'id' => 3,
                    'image' => 'https://picsum.photos/seed/3/800/600',
                    'title' => 'Cultural Heritage',
                    'description' => 'Immerse yourself in diverse cultural traditions and historical landmarks. Each image tells a story of heritage, tradition, and human creativity.',
                    'button_text' => 'Learn More',
                    'alt_text' => 'Cultural heritage'
                ],
                [
                    'id' => 4,
                    'image' => 'https://picsum.photos/seed/4/800/600',
                    'title' => 'Wildlife Encounters',
                    'description' => 'Get up close with amazing wildlife from around the globe. Our collection captures the beauty and diversity of Earth\'s magnificent creatures in their natural habitats.',
                    'button_text' => 'View Gallery',
                    'alt_text' => 'Wildlife photography'
                ],
                [
                    'id' => 5,
                    'image' => 'https://picsum.photos/seed/5/800/600',
                    'title' => 'Abstract Visions',
                    'description' => 'Explore the world of abstract photography where colors, shapes, and patterns create stunning visual compositions that challenge perception.',
                    'button_text' => 'See Collection',
                    'alt_text' => 'Abstract art'
                ]
            ],
            'meta' => [
                'description' => 'Explore our curated collection of stunning imagery featuring nature, urban life, culture, wildlife, and abstract art.',
                'keywords' => 'photography, gallery, nature, urban, culture, wildlife, abstract art'
            ]
        ];

        // If no slug provided, return default data
        if (empty($slug)) {
            return view('gallery', $defaultData);
        }

        try {
            // Find navbar item by slug
            $navbarItem = $this->navbarItemModel->where('slug', $slug)
                                               ->where('type', 'gallery')
                                               ->first();

            // If no navbar item found, return default data
            if (!$navbarItem) {
                return view('gallery', $defaultData);
            }

            // Get gallery page data
            $galleryPage = $this->galleryPageModel->getFullGalleryPage($navbarItem['id']);

            // If no gallery page found, return default data
            if (!$galleryPage) {
                return view('gallery', $defaultData);
            }

            // Format gallery items to match the collections structure
            $collections = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'image' => base_url($item['image']),
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'button_text' => 'View Details',
                    'alt_text' => $item['alt_text']
                ];
            }, $galleryPage['items']);

            $data = [
                'title' => $galleryPage['page_title'],
                'collections' => $collections,
                'meta' => [
                    'description' => $galleryPage['meta_description'],
                    'keywords' => $galleryPage['meta_keywords']
                ]
            ];

            return view('gallery', $data);

        } catch (\Exception $e) {
            // Log the error
            log_message('error', 'Error in GalleryController: ' . $e->getMessage());
            
            // Return default data if anything goes wrong
            return view('gallery', $defaultData);
        }
    }
}