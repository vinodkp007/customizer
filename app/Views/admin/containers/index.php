<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .content-wrapper {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .containers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .container-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .container-card:hover {
            transform: translateY(-5px);
        }

        .container-details {
            padding: 1.5rem;
        }

        .container-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .container-description {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            color: white;
            margin-bottom: 1rem;
        }

        .status-published {
            background-color: #27ae60;
        }

        .status-draft {
            background-color: #e74c3c;
        }

        .container-meta {
            color: #95a5a6;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #e67e22;
            color: white;
        }

        .btn-edit:hover {
            background: #d35400;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .btn-create {
            background: #2ecc71;
            color: white;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-create:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e67e22;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
        }
        .page-header {
            margin-bottom: 2rem;
            color: #2c3e50;
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