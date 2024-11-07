<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/item-form.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2><?= esc($title) ?></h2>
            <p><?= isset($item) ? 'Edit existing item' : 'Add new item to container' ?></p>
        </div>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-error">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= isset($item) 
            ? base_url('admin/containers/' . $container['id'] . '/items/update/' . $item['id'])
            : base_url('admin/containers/' . $container['id'] . '/items/store') ?>" 
              method="POST" 
              enctype="multipart/form-data"
              class="form-container">
            
            <div class="editor-section">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               value="<?= isset($item) ? esc($item['title']) : old('title') ?>" 
                               required>
                    </div>

                    <div class="form-group status-group">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="published" <?= (isset($item) && $item['status'] === 'published') ? 'selected' : '' ?>>Published</option>
                            <option value="draft" <?= (isset($item) && $item['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="editor-section">
                <div class="form-group">
                    <label class="form-label" for="image">Image</label>
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           <?= !isset($item) ? 'required' : '' ?>>
                    <div class="image-preview-container" id="dropZone">
                        <img src="<?= isset($item) && isset($item['image']) ? base_url($item['image']) : 'https://placehold.co/800x400' ?>" 
                             alt="Preview" 
                             id="imagePreview">
                    </div>
                </div>
            </div>

            <div class="editor-section">
                <div class="form-group">
                    <label class="form-label" for="description">Short Description</label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              required><?= isset($item) ? esc($item['description']) : old('description') ?></textarea>
                    <small class="text-muted">A brief description that appears in the item preview</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Content</label>
                    <textarea class="form-control" 
                              id="content" 
                              name="content" 
                              rows="6"
                              required><?= isset($item) ? esc($item['content']) : old('content') ?></textarea>
                    <small class="text-muted">The main content of your item</small>
                </div>
            </div>



            <div class="btn-container">
                <a href="<?= base_url('admin/containers/edit/' . $container['id']) ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <?= isset($item) ? 'Update Item' : 'Add Item' ?>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('dropZone');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            
            // Click to upload
            dropZone.addEventListener('click', () => {
                imageInput.click();
            });

            // Drag and drop functionality
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#3498db';
                dropZone.style.background = '#f1f5f9';
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#e9ecef';
                dropZone.style.background = '#f8f9fa';
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.style.borderColor = '#e9ecef';
                dropZone.style.background = '#f8f9fa';
                
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    imageInput.files = files;
                    showPreview(files[0]);
                }
            });

            // Handle file selection
            imageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    showPreview(file);
                }
            });

            // Show image preview
            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    dropZone.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }

            // Auto-hide alerts after 5 seconds
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>