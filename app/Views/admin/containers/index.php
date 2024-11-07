<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/index.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2>Container Management</h2>
            <p>Create and manage your container pages</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(empty($containers)): ?>
            <div class="empty-state">
                <i class="fas fa-boxes"></i>
                <h3>No Containers Yet</h3>
                <p>Start by creating your first container page</p>
                <a href="<?= base_url('admin/containers/create') ?>" class="btn btn-edit">
                    <i class="fas fa-plus"></i> Create Container
                </a>
            </div>
        <?php else: ?>
            <div class="containers-grid">
                <?php foreach($containers as $container): ?>
                    <div class="container-card">
                        <div class="container-details">
                            <h3 class="container-title"><?= esc($container['title']) ?></h3>
                            <span class="status-badge <?= $container['status'] === 'published' ? 'status-published' : 'status-draft' ?>">
                                <?= ucfirst($container['status']) ?>
                            </span>
                            <p class="container-description"><?= esc($container['description']) ?></p>
                            <div class="container-meta">
                                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($container['updated_at'])) ?>
                            </div>
                            <div class="action-buttons">
                                <a href="<?= base_url('admin/containers/edit/' . $container['id']) ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= base_url('admin/containers/delete/' . $container['id']) ?>" 
                                   class="btn btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this container?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="<?= base_url('admin/navbarmanager')?>" class="btn btn-create">
            <i class="fas fa-plus"></i> New Container
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