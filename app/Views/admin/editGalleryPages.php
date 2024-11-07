<!-- app/Views/admin/editGalleryPages.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .content-wrapper {
            margin-left: 250px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
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

        .pages-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        .page-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .page-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(52, 152, 219, 0.2);
        }

        .page-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #3498db;
            transform: scaleY(0);
            transition: transform 0.3s ease;
            transform-origin: bottom;
        }

        .page-card:hover::before {
            transform: scaleY(1);
        }

        .page-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }

        .page-info {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            padding-left: 0.5rem;
        }

        .page-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            margin-left: 0.5rem;
        }

        .status-active {
            background-color: #27ae60;
            color: white;
        }

        .status-inactive {
            background-color: #e74c3c;
            color: white;
        }

        .page-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
            color: #95a5a6;
            font-size: 0.85rem;
        }

        .page-meta i {
            font-size: 1rem;
        }

        .modify-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            text-decoration: none;
        }

        .modify-btn:hover {
            background: #2980b9;
            transform: translateX(5px);
        }

        .modify-btn i {
            transition: transform 0.3s ease;
        }

        .modify-btn:hover i {
            transform: translateX(3px);
        }

        .add-page-card {
            border: 2px dashed #3498db;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: rgba(52, 152, 219, 0.05);
        }

        .add-page-card:hover {
            background: rgba(52, 152, 219, 0.1);
        }

        .add-icon {
            font-size: 2rem;
            color: #3498db;
            margin-bottom: 1rem;
        }

        .no-pages-message {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            color: #7f8c8d;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2>Gallery Pages</h2>
            <p>Manage and modify your website's gallery pages</p>
        </div>

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
            <?php if(isset($galleryPages) && is_array($galleryPages) && count($galleryPages) > 0): ?>
                <?php foreach($galleryPages as $page): ?>
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
                            Manage and modify the gallery content for <?= esc($page['title']) ?> page
                        </p>
                        <a href="<?= base_url('admin/gallery/modify/' . $page['id']) ?>" class="modify-btn">
                            <i class="fas fa-images"></i>
                            Modify Gallery
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-pages-message">
                    <i class="fas fa-info-circle"></i>
                    <p>No gallery pages found. Create your first gallery page by clicking the "Add New Gallery" button below.</p>
                </div>
            <?php endif; ?>

            <div class="page-card add-page-card" onclick="window.location.href='<?= base_url('admin/gallery/create') ?>'">
                <i class="fas fa-plus-circle add-icon"></i>
                <h3 class="page-name" style="margin-bottom: 0">Add New Gallery</h3>
            </div>
        </div>
    </div>

    <script>
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

        document.querySelectorAll('.modify-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            });
        });

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