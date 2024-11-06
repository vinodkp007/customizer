<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EditHomeController extends BaseController
{
    protected $homeCarouselModel;
    protected $componentModel;
    protected $componentItemModel;

    public function __construct()
    {
        $this->homeCarouselModel = new \App\Models\HomeCarouselModel();
        $this->componentModel = new \App\Models\ComponentModel();
        $this->componentItemModel = new \App\Models\ComponentItemModel();
    }

    public function index()
    {
        $data = [
            'carouselItems' => $this->homeCarouselModel->orderBy('position', 'ASC')->findAll(),
            'components' => $this->componentModel->getAllActiveComponents()
        ];

        return view('admin/editHome', $data);
    }

    // Slide Management Methods
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

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/carousel', $newName);
            $data['image'] = 'uploads/carousel/' . $newName;

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

    public function updateSlideOrder()
{
    $itemOrder = json_decode($this->request->getPost('itemOrder'), true);
    
    if (!$itemOrder) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid order data'
        ]);
    }

    $db = \Config\Database::connect();
    $db->transStart();
    
    try {
        foreach ($itemOrder as $item) {
            $this->homeCarouselModel->update($item['id'], ['position' => $item['position']]);
        }
        
        $db->transCommit();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Slide order updated successfully'
        ]);
    } catch (\Exception $e) {
        $db->transRollback();
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update slide order'
        ]);
    }
}



    // Component Management Methods
    public function addComponent()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|min_length[3]|max_length[255]|is_unique[components.slug]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'is_active' => 1,
            'position' => $this->componentModel->getNextPosition()
        ];

        if ($this->componentModel->insert($data)) {
            return redirect()->back()->with('success', 'Component added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add component');
    }

    public function updateComponent()
    {
        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $id = $this->request->getPost('id');
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug')
        ];

        if ($this->componentModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Component updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update component');
    }

    public function deleteComponent($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $items = $this->componentItemModel->where('component_id', $id)->findAll();
            foreach ($items as $item) {
                if (file_exists(FCPATH . $item['image'])) {
                    unlink(FCPATH . $item['image']);
                }
            }
            $this->componentItemModel->where('component_id', $id)->delete();
            $this->componentModel->delete($id);
            
            $db->transCommit();
            return redirect()->back()->with('success', 'Component deleted successfully');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Failed to delete component');
        }
    }

    public function addComponentItem()
    {
        $rules = [
            'component_id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/components', $newName);

        $data = [
            'component_id' => $this->request->getPost('component_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image' => 'uploads/components/' . $newName,
            'position' => $this->componentItemModel->getNextPosition($this->request->getPost('component_id')),
            'is_active' => 1
        ];

        if ($this->componentItemModel->insert($data)) {
            return redirect()->back()->with('success', 'Item added successfully');
        }

        return redirect()->back()->with('error', 'Failed to add item');
    }

    public function updateComponentItem()
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

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/components', $newName);
            $data['image'] = 'uploads/components/' . $newName;

            $oldImage = $this->componentItemModel->find($id)['image'];
            if (file_exists(FCPATH . $oldImage)) {
                unlink(FCPATH . $oldImage);
            }
        }

        if ($this->componentItemModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Item updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update item');
    }

    public function deleteComponentItem($id)
    {
        $item = $this->componentItemModel->find($id);
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        if (file_exists(FCPATH . $item['image'])) {
            unlink(FCPATH . $item['image']);
        }

        if ($this->componentItemModel->delete($id)) {
            return redirect()->back()->with('success', 'Item deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete item');
    }

    public function getComponent($id)
    {
        $component = $this->componentModel->find($id);
        if (!$component) {
            return $this->response->setJSON(['error' => 'Component not found'])->setStatusCode(404);
        }
        return $this->response->setJSON($component);
    }

    public function getComponentItem($id)
    {
        $item = $this->componentItemModel->find($id);
        if (!$item) {
            return $this->response->setJSON(['error' => 'Item not found'])->setStatusCode(404);
        }
        return $this->response->setJSON($item);
    }

    public function updateComponentOrder()
{
    $itemOrder = json_decode($this->request->getPost('itemOrder'), true);
    
    if (!$itemOrder) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid order data'
        ]);
    }

    $db = \Config\Database::connect();
    $db->transStart();
    
    try {
        foreach ($itemOrder as $item) {
            $this->componentModel->update($item['id'], ['position' => $item['position']]);
        }
        
        $db->transCommit();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Component order updated successfully'
        ]);
    } catch (\Exception $e) {
        $db->transRollback();
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update component order'
        ]);
    }
}

    public function updateComponentItemOrder()
    {
        $data = $this->request->getJSON();
        $componentId = $data->component_id;
        $items = $data->items;
        
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            foreach ($items as $item) {
                $this->componentItemModel->update($item->id, ['position' => $item->position]);
            }
            
            $db->transCommit();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Item order updated successfully'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update item order'
            ]);
        }
    }
}