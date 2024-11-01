<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function about(): string
    {
        return view('about');
    }

    public function content(): string
    {
        return view('contentPage');
    }
}
