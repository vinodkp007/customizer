<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/container.css') ?>">
    <style>
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
        <div class="page-header">
            <h2>Edit container Page</h2>
            <p>Customize your page container and layout</p>
        </div>

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

