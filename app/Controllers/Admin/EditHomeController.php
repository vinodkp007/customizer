<?php
// app/Controllers/Admin/EditHomeController.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EditHomeController extends BaseController
{
    protected $homeCarouselModel;
    protected $homeServicesModel;

    public function __construct()
    {
        // Load your models
        $this->homeCarouselModel = new \App\Models\HomeCarouselModel();
        $this->homeServicesModel = new \App\Models\HomeServicesModel();
    }

    public function index()
    {
        $data = [
            'carouselItems' => $this->homeCarouselModel->orderBy('position', 'ASC')->findAll(),
            'services' => $this->homeServicesModel->orderBy('position', 'ASC')->findAll()
        ];

        return view('admin/editHome', $data);
    }

    // Carousel Management Methods
    public function addSlide()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/carousel', $newName);

        // Get the last position
        $lastPosition = $this->homeCarouselModel->selectMax('position')->get()->getRow()->position ?? 0;

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image' => 'uploads/carousel/' . $newName,
            'position' => $lastPosition + 1
        ];

        if ($this->homeCarouselModel->insert($data)) {
            return redirect()->back()->with('success', 'Slide added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add slide');
    }

    public function updateSlide()
    {
        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $id = $this->request->getPost('id');
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        // Handle image update if new image is uploaded
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/carousel', $newName);
            $data['image'] = 'uploads/carousel/' . $newName;

            // Delete old image
            $oldImage = $this->homeCarouselModel->find($id)['image'];
            if (file_exists(FCPATH . $oldImage)) {
                unlink(FCPATH . $oldImage);
            }
        }

        if ($this->homeCarouselModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Slide updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update slide');
    }

    public function deleteSlide($id)
    {
        $slide = $this->homeCarouselModel->find($id);
        if (!$slide) {
            return redirect()->back()->with('error', 'Slide not found');
        }

        // Delete image file
        if (file_exists(FCPATH . $slide['image'])) {
            unlink(FCPATH . $slide['image']);
        }

        if ($this->homeCarouselModel->delete($id)) {
            return redirect()->back()->with('success', 'Slide deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete slide');
    }

    public function getSlide($id)
    {
        $slide = $this->homeCarouselModel->find($id);
        if (!$slide) {
            return $this->response->setJSON(['error' => 'Slide not found'])->setStatusCode(404);
        }
        return $this->response->setJSON($slide);
    }

    // Services Management Methods
    public function addService()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/services', $newName);

        // Get the last position
        $lastPosition = $this->homeServicesModel->selectMax('position')->get()->getRow()->position ?? 0;

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image' => 'uploads/services/' . $newName,
            'position' => $lastPosition + 1
        ];

        if ($this->homeServicesModel->insert($data)) {
            return redirect()->back()->with('success', 'Service added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add service');
    }

    public function updateService()
    {
        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $id = $this->request->getPost('id');
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        ];

        // Handle image update if new image is uploaded
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/services', $newName);
            $data['image'] = 'uploads/services/' . $newName;

            // Delete old image
            $oldImage = $this->homeServicesModel->find($id)['image'];
            if (file_exists(FCPATH . $oldImage)) {
                unlink(FCPATH . $oldImage);
            }
        }

        if ($this->homeServicesModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Service updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update service');
    }

    public function deleteService($id)
    {
        $service = $this->homeServicesModel->find($id);
        if (!$service) {
            return redirect()->back()->with('error', 'Service not found');
        }

        // Delete image file
        if (file_exists(FCPATH . $service['image'])) {
            unlink(FCPATH . $service['image']);
        }

        if ($this->homeServicesModel->delete($id)) {
            return redirect()->back()->with('success', 'Service deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete service');
    }

    public function getService($id)
    {
        $service = $this->homeServicesModel->find($id);
        if (!$service) {
            return $this->response->setJSON(['error' => 'Service not found'])->setStatusCode(404);
        }
        return $this->response->setJSON($service);
    }

    // Order Management
    public function updateOrder()
    {
        $type = $this->request->getPost('type');
        $itemOrder = json_decode($this->request->getPost('itemOrder'), true);
        
        if (!$itemOrder) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid order data'
            ]);
        }

        $model = $type === 'carousel' ? $this->homeCarouselModel : $this->homeServicesModel;
        
        \Config\Database::connect()->transBegin();
        
        try {
            foreach ($itemOrder as $item) {
                $model->update($item['id'], ['position' => $item['position']]);
            }
            
            \Config\Database::connect()->transCommit();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            \Config\Database::connect()->transRollback();
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update order'
            ]);
        }
    }
}