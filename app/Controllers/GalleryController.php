<?php

namespace App\Controllers;

class GalleryController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Featured Collections',
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
            ]
        ];

        // Add metadata for SEO
        $data['meta'] = [
            'description' => 'Explore our curated collection of stunning imagery featuring nature, urban life, culture, wildlife, and abstract art.',
            'keywords' => 'photography, gallery, nature, urban, culture, wildlife, abstract art'
        ];

        return view('gallery', $data);
    }

    public function detail($id)
    {
        // For future implementation of detail pages
        // You can expand this to show individual collection details
    }
}