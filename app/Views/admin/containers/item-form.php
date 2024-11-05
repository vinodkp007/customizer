<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Previous styles remain the same -->
    <style>
        
        
.content-wrapper {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #e67e22;
            box-shadow: 0 0 0 2px rgba(230, 126, 34, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .image-preview {
            max-width: 200px;
            margin-top: 1rem;
            border-radius: 5px;
        }

        .btn-container {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #e67e22;
            color: white;
        }

        .btn-primary:hover {
            background: #d35400;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .validation-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .description-field {
            margin-bottom: 1.5rem;
        }

        .description-field textarea {
            min-height: 100px;
        }

        .content-field textarea {
            min-height: 200px;
        }

        .status-select {
            background-color: white;
            width: 100%;
        }

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-row .form-group.status-group {
            flex: 0 0 200px;
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

        <div class="form-container">
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
                  enctype="multipart/form-data">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               value="<?= isset($item) ? esc($item['title']) : old('title') ?>" 
                               required>
                    </div>

                    <div class="form-group status-group">
                        <label for="status">Status</label>
                        <select class="form-control status-select" id="status" name="status">
                            <option value="published" <?= (isset($item) && $item['status'] === 'published') ? 'selected' : '' ?>>Published</option>
                            <option value="draft" <?= (isset($item) && $item['status'] === 'draft') ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="form-group description-field">
                    <label for="description">Short Description</label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              required><?= isset($item) ? esc($item['description']) : old('description') ?></textarea>
                    <small class="text-muted">A brief description that appears in the item preview</small>
                </div>

                <div class="form-group content-field">
                    <label for="content">Content</label>
                    <textarea class="form-control" 
                              id="content" 
                              name="content" 
                              required><?= isset($item) ? esc($item['content']) : old('content') ?></textarea>
                    <small class="text-muted">The main content of your item</small>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" 
                           class="form-control" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           <?= !isset($item) ? 'required' : '' ?>>
                    
                    <?php if(isset($item) && isset($item['image'])): ?>
                        <div class="current-image">
                            <p class="text-muted">Current Image:</p>
                            <img src="<?= base_url($item['image']) ?>" 
                                 alt="Current image" 
                                 class="image-preview">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <?= isset($item) ? 'Update Item' : 'Add Item' ?>
                    </button>
                    <a href="<?= base_url('admin/containers/edit/' . $container['id']) ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.classList.add('image-preview');
                        document.querySelector('.form-group:last-of-type').appendChild(preview);
                    }
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>