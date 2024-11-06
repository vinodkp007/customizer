<!-- app/Views/admin/editContainerPages.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Pages Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/editContainerPages.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2>Container Pages</h2>
            <p>Manage and modify your website's container pages</p>
        </div>

        <!-- Display Flash Messages -->
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

        <div class="pages-container">
            <?php if(isset($containerPages) && is_array($containerPages) && count($containerPages) > 0): ?>
                <?php foreach($containerPages as $page): ?>
                    <div class="page-card">
                        <h3 class="page-name"><?= esc($page['title']) ?></h3>
                        <span class="page-status <?= $page['is_active'] ? 'status-active' : 'status-inactive' ?>">
                            <?= $page['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                        <div class="page-meta">
                            <span><i class="fas fa-link"></i> <?= esc($page['slug']) ?></span>
                            <span><i class="fas fa-sort"></i> Order: <?= esc($page['order_position']) ?></span>
                        </div>
                        <p class="page-info">
                            Container page for <?= esc($page['title']) ?>
                        </p>
                        <a href="<?= base_url('admin/container/modify/' . $page['id']) ?>" class="modify-btn">
                            <i class="fas fa-edit"></i>
                            Modify
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-pages-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No container pages found. Create your first container page by clicking the "Add New Container" button below.</p>
                </div>
            <?php endif; ?>

            <!-- Add New Container Page Card -->
            <div class="page-card add-page-card" onclick="window.location.href='<?= base_url('admin/container/create') ?>'">
                <i class="fas fa-plus-circle add-icon"></i>
                <h3 class="page-name" style="margin-bottom: 0">Add New Container</h3>
            </div>
        </div>
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

        // Add button click animation
        document.querySelectorAll('.modify-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            });
        });

        // Add hover effect for add-page-card
        const addPageCard = document.querySelector('.add-page-card');
        if(addPageCard) {
            addPageCard.addEventListener('mouseenter', function() {
                this.querySelector('.add-icon').style.transform = 'scale(1.1)';
            });
            addPageCard.addEventListener('mouseleave', function() {
                this.querySelector('.add-icon').style.transform = 'scale(1)';
            });
        }
    </script>
</body>
</html>