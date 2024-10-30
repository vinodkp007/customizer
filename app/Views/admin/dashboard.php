<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Builder Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
        }

        body {
            background: #f0f2f5;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Enhanced Sidebar Styles */
        .sidebar {
            background: var(--secondary-color);
            color: white;
            padding: 2rem 0;
            position: fixed;
            width: 250px;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
            text-align: center;
        }

        .brand h1 {
            font-size: 1.8rem;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .brand span {
            color: var(--primary-color);
            font-size: 1rem;
            display: block;
            letter-spacing: 1px;
        }

        .nav-menu {
            list-style: none;
            padding: 0.5rem 0;
        }

        .nav-menu li {
            margin: 0.5rem 0;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-menu a:hover {
            background: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
        }

        .nav-menu a.active {
            background: var(--primary-color);
            color: white;
        }

        .nav-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
        }

        /* Main Content Styles */
        .main-content {
            padding: 2rem;
            margin-left: 250px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: var(--secondary-color);
        }

        /* Enhanced Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-card .icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: inline-block;
            padding: 1rem;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 50%;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .stat-card p {
            color: #666;
            font-size: 1rem;
        }

        /* Enhanced Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .action-btn {
            background: white;
            border: none;
            padding: 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: var(--secondary-color);
            font-weight: 500;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            background: var(--primary-color);
            color: white;
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.2);
        }

        .action-btn i {
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .quick-stats {
                grid-template-columns: 1fr;
            }

            .action-btn {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <h1>Website Builder</h1>
                <span>Management Dashboard</span>
            </div>
            <ul class="nav-menu">
                <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= base_url('admin/navbarmanager')?>"><i class="fas fa-bars"></i> Navigation</a></li>
                <li><a href="#"><i class="fas fa-file-alt"></i> Content Pages</a></li>
                <li><a href="#"><i class="fas fa-boxes"></i> Containers</a></li>
            </ul>
        </aside>

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