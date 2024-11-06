<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .content-wrapper {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 2rem;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
        }

        .page-header h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 1rem;
        }

        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .editor-section {
            padding: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: #3498db;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #3498db;
            outline: none;
            background: white;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-row .form-group.status-group {
            flex: 0 0 200px;
        }

        .image-preview-container {
            width: 100%;
            height: 300px;
            background: #f8f9fa;
            border: 2px dashed #e9ecef;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .image-preview-container:hover {
            border-color: #3498db;
            background: #f1f5f9;
        }

        .image-preview-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .image-preview-container::after {
            content: 'Click or drag to upload image';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #7f8c8d;
            font-size: 1rem;
            pointer-events: none;
            opacity: 0.7;
        }

        .image-preview-container.has-image::after {
            content: '';
        }

        .btn-container {
            padding: 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-primary:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            opacity: 1;
            transition: opacity 0.5s ease;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto 1rem;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .text-muted {
            color: #7f8c8d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Hide default file input */
        input[type="file"] {
            display: none;
        }
    </style>
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