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

        .container-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .container-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .item-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .item-card:hover {
            transform: translateY(-5px);
        }

        .item-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-details {
            padding: 1.5rem;
        }

        .item-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .item-content {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

        .btn-add {
            background: #2ecc71;
            color: white;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-add:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 10px;
            grid-column: 1 / -1;
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
    </style>
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