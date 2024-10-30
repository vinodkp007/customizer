<!-- app/Views/admin/content_pages.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Pages Management</title>
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
    </style>
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2>Content Pages</h2>
            <p>Manage and modify your website's content pages</p>
        </div>

        <div class="pages-container">
            <!-- Home Page Card -->
            <div class="page-card">
                <h3 class="page-name">Home</h3>
                <p class="page-info">Main landing page of your website</p>
                <button class="modify-btn">
                    <i class="fas fa-edit"></i>
                    Modify
                </button>
            </div>

            <!-- Services Page Card -->
            <div class="page-card">
                <h3 class="page-name">Services</h3>
                <p class="page-info">Showcase your services and offerings</p>
                <button class="modify-btn">
                    <i class="fas fa-edit"></i>
                    Modify
                </button>
            </div>

            <!-- Contact Page Card -->
            <div class="page-card">
                <h3 class="page-name">Contact Us</h3>
                <p class="page-info">Contact information and inquiry form</p>
                <button class="modify-btn">
                    <i class="fas fa-edit"></i>
                    Modify
                </button>
            </div>

            <!-- Add New Page Card -->
            <div class="page-card add-page-card">
                <i class="fas fa-plus-circle add-icon"></i>
                <h3 class="page-name" style="margin-bottom: 0">Add New Page</h3>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.modify-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Add button click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
                
                // Here you can add your modification logic
                // e.g., redirect to edit page or open modal
            });
        });
    </script>
</body>
</html>