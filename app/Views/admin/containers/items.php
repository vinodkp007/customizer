<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/items.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="container-header">
            <h2 class="container-title"><?= esc($container['title']) ?></h2>
            <p>Manage items in this container</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(empty($items)): ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Items Yet</h3>
                <p>Start by adding your first item to this container</p>
                <a href="<?= base_url('admin/containers/' . $container['id'] . '/items/add') ?>" class="btn btn-edit">
                    <i class="fas fa-plus"></i> Add Item
                </a>
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
                            <p class="item-content"><?= esc($item['content']) ?></p>
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

        <a href="<?= base_url('admin/containers/' . $container['id'] . '/items/add') ?>" class="btn btn-add">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>

    <script>
        // Automatically hide alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>