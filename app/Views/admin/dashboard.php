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
                    <h3>12</h3>
                    <p>Content Pages</p>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-boxes"></i></div>
                    <h3>8</h3>
                    <p>Containers</p>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-bars"></i></div>
                    <h3>6</h3>
                    <p>Nav Items</p>
                </div>
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-images"></i></div>
                    <h3>24</h3>
                    <p>Media Files</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    Add Content Page
                </button>
                <button class="action-btn">
                    <i class="fas fa-plus-square"></i>
                    New Container
                </button>
                <button class="action-btn">
                    <i class="fas fa-link"></i>
                    Add Nav Item
                </button>
            </div>
        </main>
    </div>
</body>
</html>