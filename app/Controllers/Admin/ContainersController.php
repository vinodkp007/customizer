<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NavbarItemModel;

class ContainersController extends BaseController
{
    protected $navbarItemModel;

    public function __construct()
    {
        $this->navbarItemModel = new NavbarItemModel();
    }

    public function index()
    {
        $data['containerPages'] = $this->navbarItemModel
            ->where('type', 'container')
            ->where('is_active', 1)
            ->orderBy('order_position', 'ASC')
            ->findAll();

        return view('admin/editContainerPages', $data);
    }
}