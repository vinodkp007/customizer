<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Builder Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <?= $this->include('admin/partials/sidebar') ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1>Dashboard Overview</h1>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-file-alt"></i></div>
                    <h3><?= $stats['content_pages'] ?></h3>
                    <p>Content Pages</p>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-boxes"></i></div>
                    <h3><?= $stats['containers'] ?></h3>
                    <p>Containers</p>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-bars"></i></div>
                    <h3><?= $stats['nav_items'] ?></h3>
                    <p>Nav Items</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="<?= base_url('admin/navbarmanager')?>" class="action-btn" style="text-decoration: none;">
                    <i class="fas fa-plus-circle"></i>
                    Add Content Page
                </a>
                <a href="<?= base_url('admin/navbarmanager')?>" class="action-btn" style="text-decoration: none;">
                    <i class="fas fa-plus-square"></i>
                    New Container
                </a>
                <a href="<?= base_url('admin/navbarmanager')?>" class="action-btn" style="text-decoration: none;">
                    <i class="fas fa-link"></i>
                    Add Nav Item
                </a>
            </div>
        </main>
    </div>
</body>
</html>