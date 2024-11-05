<?php
// app/Controllers/Home.php

namespace App\Controllers;

class Home extends BaseController
{
    protected $homeCarouselModel;
    protected $homeServicesModel;

    public function __construct()
    {
        $this->homeCarouselModel = new \App\Models\HomeCarouselModel();
        $this->homeServicesModel = new \App\Models\HomeServicesModel();
    }

    public function index()
    {
        $data = [
            'carouselItems' => $this->homeCarouselModel->orderBy('position', 'ASC')->findAll(),
            // 'services' => $this->homeServicesModel->orderBy('position', 'ASC')->findAll()
            'components' => []
        ];
        
        return view('home', $data);
    }
}