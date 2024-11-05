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

        .metadata-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .metadata-form {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-group {
            flex: 1;
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
        }

        .status-select {
            width: 200px;
        }

        .container-content {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
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

        .btn-add {
            background: #2ecc71;
            color: white;
        }

        .btn-add:hover {
            background: #27ae60;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            color: white;
        }

        .status-published {
            background-color: #27ae60;
        }

        .status-draft {
            background-color: #e74c3c;
        }


        .item-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .item-image {
            width: 100%;
            height: 160px; /* Reduced from 200px */
            overflow: hidden;
            position: relative;
            background: #f8f9fa;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .item-details {
            padding: 1rem; /* Reduced padding */
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .item-title {
            font-size: 1.1rem; /* Slightly smaller font */
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .item-description {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-meta {
            font-size: 0.8rem;
            color: #95a5a6;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            color: white;
            margin-bottom: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: auto; /* Push to bottom */
        }

        .btn {
            padding: 0.4rem 0.8rem; /* Smaller buttons */
            font-size: 0.85rem;
        }

        /* Adjust grid layout */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        /* Make cards same height */
        .item-card {
            height: 350px; /* Fixed height for consistency */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .item-card {
                height: 330px;
            }

            .item-image {
                height: 140px;
            }
        }

        .search-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .search-input {
            flex: 1;
        }

        .search-status {
            width: 200px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2rem;
            gap: 0.5rem;
        }

        .pagination .page-item {
            display: inline-flex;
        }

        .pagination .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination .active .page-link {
            background-color: #e67e22;
            color: white;
            border-color: #e67e22;
        }

        .pagination .page-link:hover {
            background-color: #f7fafc;
        }

        .pagination-info {
            text-align: center;
            color: #718096;
            margin-top: 1rem;
        }

        .no-results {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .btn-clear {
            background: #718096;
            color: white;
        }

        .btn-clear:hover {
            background: #4a5568;
        }

        /* Add your existing styles for container items grid here */
    </style>
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>


        <!-- Container Metadata Section -->
        <div class="metadata-section">
            <h2>Container Settings</h2>
            <form action="<?= base_url('admin/containers/update-metadata/' . $container['id']) ?>" 
                  method="POST" 
                  class="metadata-form">
                
                <div class="form-group">
                    <label for="title">Container Title</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="<?= esc($container['title']) ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control status-select" id="status" name="status">
                        <option value="published" <?= $container['is_active'] ? 'selected' : '' ?>>Published</option>
                        <option value="draft" <?= !$container['is_active'] ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 0;">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Container Content Section -->
        <div class="container-content">
    <div class="content-header">
        <h2>Container Content</h2>
        <a href="<?= base_url('admin/containers/' . $container['id'] . '/items/add') ?>" class="btn btn-add">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>

    <?php 
    $items = [];
    $jsonFile = WRITEPATH . 'container-content/' . $container['slug'] . '.json';
    if (file_exists($jsonFile)) {
        $containerData = json_decode(file_get_contents($jsonFile), true);
        $items = $containerData['items'] ?? [];
    }
    ?>

    <?php if(empty($items)): ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>No Items Yet</h3>
            <p>Start by adding your first item to this container</p>
        </div>
    <?php else: ?>
        <div class="items-grid">
            <?php foreach($items as $item): ?>
                <div class="item-card">
                    <?php if(isset($item['image'])): ?>
                        <div class="item-image">
                            <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['title']) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="item-details">
                        <h3 class="item-title"><?= esc($item['title']) ?></h3>
                        <span class="status-badge <?= $item['status'] === 'published' ? 'status-published' : 'status-draft' ?>">
                            <?= ucfirst($item['status']) ?>
                        </span>
                        <p class="item-description"><?= esc($item['description']) ?></p>
                        <div class="item-meta">
                            <span><i class="fas fa-clock"></i> <?= date('M d, Y', strtotime($item['updated_at'])) ?></span>
                        </div>
                        <div class="action-buttons">
                            <a href="<?= base_url('admin/containers/' . $container['id'] . '/items/edit/' . $item['id']) ?>" 
                               class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="<?= base_url('admin/containers/' . $container['id'] . '/items/delete/' . $item['id']) ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
    </div>

    <script>
        // Add your JavaScript here
    </script>
</body>
</html>

