<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery Items</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/contentModify.css') ?>">
    <style>
        .gallery-item {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .gallery-item .drag-handle {
            position: absolute;
            right: 20px;
            top: 20px;
            cursor: move;
            color: #666;
        }

        .image-preview {
            width: 100%;
            height: 400px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
            cursor: pointer;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-container {
            margin-top: 20px;
        }

        .gallery-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .item-number {
            font-weight: 500;
            color: #666;
            margin-bottom: 15px;
        }

        .delete-item {
            position: absolute;
            right: 60px;
            top: 20px;
            background: #ff4444;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        .add-item-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2>Edit Gallery Items</h2>
            <p>Modify gallery items and their order</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/gallery/save') ?>" method="POST" enctype="multipart/form-data" id="galleryForm">
            <?= csrf_field() ?>
            <input type="hidden" name="gallery_page_id" value="<?= $gallery_page_id ?>">
            <input type="hidden" name="item_order" id="itemOrder" value="">

            <div class="content-editor">
                <div class="editor-section">
                    <h3 class="section-title">
                        <i class="fas fa-heading"></i>
                        Gallery Page Title
                    </h3>
                    <div class="form-group">
                        <input type="text" 
                               class="form-control" 
                               name="page_title" 
                               placeholder="Enter gallery page title" 
                               value="<?= $isEdit ? esc($content['page_title']) : '' ?>"
                               required>
                    </div>
                </div>

                <div class="editor-section">
                    <h3 class="section-title">
                        <i class="fas fa-images"></i>
                        Gallery Items
                    </h3>
                    
                    <div class="gallery-container" id="sortableGallery">
                        <?php if($isEdit && !empty($content['items'])): ?>
                            <?php foreach($content['items'] as $index => $item): ?>
                                <div class="gallery-item" data-id="<?= $item['id'] ?>">
                                    <div class="item-number">Item #<?= $index + 1 ?></div>
                                    <div class="drag-handle">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                    <button type="button" class="delete-item" onclick="deleteItem(this, <?= $item['id'] ?>)">
                                         <i class="fas fa-trash"></i>
                                        </button>
                                    
                                    <div class="image-preview" onclick="triggerFileInput(this)">
                                        <img src="<?= base_url($item['image']) ?>" alt="Gallery item">
                                    </div>
                                    <input type="file" 
                                           name="images[]" 
                                           accept="image/*" 
                                           onchange="previewImage(this)">
                                    <input type="hidden" name="existing_images[]" value="<?= $item['image'] ?>">
                                    <input type="hidden" name="item_ids[]" value="<?= $item['id'] ?>">
                                    
                                    <div class="form-group">
                                        <label>Image Heading</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="item_titles[]" 
                                               value="<?= esc($item['title']) ?>" 
                                               required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" 
                                                  name="item_descriptions[]" 
                                                  rows="4" 
                                                  required><?= esc($item['description']) ?></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="add-item-btn" onclick="addNewItem()">
                        <i class="fas fa-plus"></i>
                        Add New Item
                    </button>
                </div>

                <div class="editor-section">
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sortable
            const gallery = document.getElementById('sortableGallery');
            new Sortable(gallery, {
                animation: 150,
                handle: '.drag-handle',
                onSort: updateItemOrder,
                onEnd: updateItemNumbers
            });

            // Initial order update
            updateItemOrder();
            updateItemNumbers();
        });

        function updateItemOrder() {
            const items = document.querySelectorAll('.gallery-item');
            const order = Array.from(items).map(item => item.dataset.id);
            document.getElementById('itemOrder').value = JSON.stringify(order);
        }

        function updateItemNumbers() {
            document.querySelectorAll('.gallery-item').forEach((item, index) => {
                item.querySelector('.item-number').textContent = `Item #${index + 1}`;
            });
        }

        function addNewItem() {
            const container = document.getElementById('sortableGallery');
            const itemCount = container.children.length;
            const newItem = document.createElement('div');
            const itemId = 'new_' + Date.now();
            
            newItem.className = 'gallery-item';
            newItem.dataset.id = itemId;
            
            newItem.innerHTML = `
                <div class="item-number">Item #${itemCount + 1}</div>
                <div class="drag-handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <button type="button" class="delete-item" onclick="deleteItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
                
                <div class="image-preview" onclick="triggerFileInput(this)">
                    <img src="https://placehold.co/800x600" alt="New gallery item">
                </div>
                <input type="file" 
                       name="new_images[]" 
                       accept="image/*" 
                       onchange="previewImage(this)" 
                       required>
                
                <div class="form-group">
                    <label>Image Heading</label>
                    <input type="text" 
                           class="form-control" 
                           name="new_titles[]" 
                           placeholder="Enter image heading" 
                           required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" 
                            name="new_descriptions[]" 
                            rows="4" 
                            placeholder="Enter description" 
                            required></textarea>
                </div>
            `;
            
            container.appendChild(newItem);
            updateItemOrder();
            updateItemNumbers();
        }

        function deleteItem(button, itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
        window.location.href = `<?= base_url('admin/gallery/delete-item') ?>/${itemId}`;
    }
}

        function triggerFileInput(previewDiv) {
            previewDiv.nextElementSibling.click();
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    input.previousElementSibling.querySelector('img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto-hide alerts
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>
</body>
</html>