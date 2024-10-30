<!-- app/Views/navbar/manage.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .page-title {
            color: var(--secondary-color);
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .add-form {
            display: grid;
            grid-template-columns: 1fr 200px 120px;
            gap: 1rem;
            align-items: end;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .items-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .item {
            display: grid;
            grid-template-columns: 40px 1fr 150px 120px;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .item:hover {
            transform: translateX(5px);
            border-color: var(--primary-color);
        }

        .item .handle {
            cursor: move;
            color: #95a5a6;
        }

        .item .title {
            font-weight: 500;
            color: var(--secondary-color);
        }

        .item .type-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
        }

        .type-badge.content {
            background: rgba(52, 152, 219, 0.1);
            color: var(--primary-color);
        }

        .type-badge.container {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }

        .item .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-icon.delete {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }

        .btn-icon.delete:hover {
            background: var(--danger-color);
            color: white;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .message.success {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }

        .message.error {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Manage Navigation Items</h1>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <form action="<?= base_url('admin/navbarmanager/add') ?>" method="POST" class="add-form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="title">Navigation Title</label>
                    <input type="text" id="title" name="title" class="form-control" required placeholder="Enter navigation title">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="content">Content Page</option>
                        <option value="container">Container Page</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </form>
        </div>

        <div class="card">
            <ul id="navItemsList" class="items-list">
                <?php foreach ($navbarItems as $item): ?>
                <li class="item">
                    <div class="handle">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="title"><?= esc($item['title']) ?></div>
                    <div class="type-badge <?= $item['type'] ?>"><?= ucfirst($item['type']) ?></div>
                    <div class="actions">
                        <form action="<?= base_url('admin/navbarmanager/delete/' . $item['id']) ?>" method="POST" style="display: inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-icon delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
                <?php endforeach; ?>
                
                <?php if (empty($navbarItems)): ?>
                <li class="empty-state">
                    <i class="fas fa-list"></i>
                    <p>No navigation items yet. Add your first item above!</p>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        // Initialize sortable
        new Sortable(document.getElementById('navItemsList'), {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                const items = document.querySelectorAll('.item');
                const ids = Array.from(items).map(item => item.dataset.id);
                
                // Create a form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= base_url('admin/navbarmanager/updateorder') ?>';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '<?= csrf_token() ?>';
                csrfToken.value = '<?= csrf_hash() ?>';
                form.appendChild(csrfToken);
                
                // Add ids
                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = JSON.stringify(ids);
                form.appendChild(idsInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
</body>
</html>