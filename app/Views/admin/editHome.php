<!-- app/Views/admin/home_manager.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Content Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <style>
        /* Base Variables */
:root {
    --primary-color: #3498db;
    --secondary-color: #2c3e50;
    --success-color: #2ecc71;
    --danger-color: #e74c3c;
    --light-bg: #f8f9fa;
    --border-color: #ddd;
    --text-primary: #2c3e50;
    --text-secondary: #636e72;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    color: var(--text-primary);
    line-height: 1.6;
}

/* Main Content Area */
.main-content {
    flex: 1;
    margin-left: 250px;
    padding: 2rem;
    min-height: 100vh;
    width: calc(100% - 250px);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Page Title */
.page-title {
    color: var(--secondary-color);
    margin-bottom: 2rem;
    font-size: 2rem;
    font-weight: 600;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
}

/* Cards */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    transition: var(--transition);
}

.card h2 {
    color: var(--secondary-color);
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    font-weight: 600;
}

/* Forms */
.add-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--light-bg);
    border-radius: 8px;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: #2980b9;
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

/* Items List */
.items-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.item {
    display: grid;
    grid-template-columns: 40px 1fr 120px 120px;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    margin-bottom: 0.75rem;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.item:hover {
    transform: translateX(5px);
    border-color: var(--primary-color);
    box-shadow: var(--shadow-sm);
}

.item .handle {
    cursor: move;
    color: #95a5a6;
    display: flex;
    align-items: center;
    justify-content: center;
}

.item-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.item-image img {
    border-radius: 6px;
    object-fit: cover;
    box-shadow: var(--shadow-sm);
}

.title {
    font-weight: 500;
    color: var(--text-primary);
}

.title strong {
    display: block;
    margin-bottom: 0.25rem;
}

.title small {
    display: block;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Badges */
.type-badge {
    padding: 0.5rem 1rem;
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

/* Action Buttons */
.actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
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
    transition: var(--transition);
    background: var(--light-bg);
    color: var(--text-primary);
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-icon.edit {
    background: rgba(52, 152, 219, 0.1);
    color: var(--primary-color);
}

.btn-icon.edit:hover {
    background: var(--primary-color);
    color: white;
}

.btn-icon.delete {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
}

.btn-icon.delete:hover {
    background: var(--danger-color);
    color: white;
}

/* Messages */
.message {
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    opacity: 0;
    transform: translateY(-20px);
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.message.show {
    opacity: 1;
    transform: translateY(0);
}

.message.hide {
    opacity: 0;
    transform: translateY(-20px);
    margin-top: -4rem;
}

.message.success {
    background: rgba(46, 204, 113, 0.1);
    color: var(--success-color);
    border-left: 4px solid var(--success-color);
}

.message.error {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
    border-left: 4px solid var(--danger-color);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    backdrop-filter: blur(4px);
}

.modal-content {
    background: white;
    margin: 5% auto;
    padding: 2rem;
    border-radius: 12px;
    width: 90%;
    max-width: 600px;
    position: relative;
    box-shadow: var(--shadow-lg);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.close {
    position: absolute;
    right: 1.5rem;
    top: 1.5rem;
    font-size: 1.5rem;
    cursor: pointer;
    transition: var(--transition);
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--light-bg);
}

.close:hover {
    color: var(--danger-color);
    background: rgba(231, 76, 60, 0.1);
    transform: rotate(90deg);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .add-form {
        grid-template-columns: 1fr;
    }
    
    .item {
        grid-template-columns: 40px 1fr 100px;
    }
    
    .type-badge {
        display: none;
    }
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 200px;
        width: calc(100% - 200px);
    }
    
    .modal-content {
        width: 95%;
        margin: 10% auto;
    }
}

@media (max-width: 576px) {
    .main-content {
        margin-left: 0;
        width: 100%;
    }
    
    .item {
        grid-template-columns: 1fr auto;
    }
    
    .handle {
        display: none;
    }
    
    .item-content {
        flex-direction: column;
        align-items: flex-start;
    }
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: var(--border-color);
}

/* Drag and Drop Visual Feedback */
.sortable-ghost {
    opacity: 0.5;
    background: var(--light-bg);
}

.sortable-drag {
    background: white;
    box-shadow: var(--shadow-lg);
    border: 2px dashed var(--primary-color);
}
    </style>
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>
    
    <div class="main-content">
        <div class="container">
            <h1 class="page-title">Manage Home Page Content</h1>
            
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

            <!-- Carousel Management Section -->
            <div class="card">
                <h2>Carousel Management</h2>
                <form action="<?= base_url('admin/home-edit/addslide') ?>" method="POST" enctype="multipart/form-data" class="add-form">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="slideTitle">Slide Title</label>
                        <input type="text" id="slideTitle" name="title" class="form-control" required placeholder="Enter slide title">
                    </div>
                    <div class="form-group">
                        <label for="slideDescription">Description</label>
                        <input type="text" id="slideDescription" name="description" class="form-control" required placeholder="Enter slide description">
                    </div>
                    <div class="form-group">
                        <label for="slideImage">Image</label>
                        <input type="file" id="slideImage" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Slide
                    </button>
                </form>

                <ul id="carouselItems" class="items-list">
                    <?php foreach ($carouselItems as $item): ?>
                    <li class="item" data-id="<?= $item['id'] ?>">
                        <div class="handle">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-image">
                                <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['title']) ?>" width="100">
                            </div>
                            <div class="title">
                                <strong><?= esc($item['title']) ?></strong>
                                <small><?= esc($item['description']) ?></small>
                            </div>
                        </div>
                        <div class="type-badge content">Slide</div>
                        <div class="actions">
                            <button class="btn-icon edit" onclick="editSlide(<?= $item['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="<?= base_url('admin/home-edit/deleteslide/' . $item['id']) ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-icon delete" onclick="return confirm('Are you sure you want to delete this slide?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Services Management Section -->
            <div class="card">
                <h2>Services Management</h2>
                <form action="<?= base_url('admin/home-edit/addservice') ?>" method="POST" enctype="multipart/form-data" class="add-form">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="serviceTitle">Service Title</label>
                        <input type="text" id="serviceTitle" name="title" class="form-control" required placeholder="Enter service title">
                    </div>
                    <div class="form-group">
                        <label for="serviceDescription">Description</label>
                        <textarea id="serviceDescription" name="description" class="form-control" required placeholder="Enter service description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="serviceImage">Image</label>
                        <input type="file" id="serviceImage" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Service
                    </button>
                </form>

                <ul id="servicesItems" class="items-list">
                    <?php foreach ($services as $service): ?>
                    <li class="item" data-id="<?= $service['id'] ?>">
                        <div class="handle">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-image">
                                <img src="<?= base_url($service['image']) ?>" alt="<?= esc($service['title']) ?>" width="100">
                            </div>
                            <div class="title">
                                <strong><?= esc($service['title']) ?></strong>
                                <small><?= esc($service['description']) ?></small>
                            </div>
                        </div>
                        <div class="type-badge container">Service</div>
                        <div class="actions">
                            <button class="btn-icon edit" onclick="editService(<?= $service['id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="<?= base_url('admin/home-edit/deleteservice/' . $service['id']) ?>" method="POST" style="display: inline;">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-icon delete" onclick="return confirm('Are you sure you want to delete this service?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div id="editSlideModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Slide</h2>
            <form action="<?= base_url('admin/home-edit/updateslide') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="editSlideId">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="editSlideTitle" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="editSlideDescription" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>New Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Update Slide</button>
            </form>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Service</h2>
            <form action="<?= base_url('admin/home-edit/updateservice') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="editServiceId">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="editServiceTitle" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="editServiceDescription" class="form-control" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>New Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Update Service</button>
            </form>
        </div>
    </div>

    <style>
    /* Additional styles for the home manager page */
    .item-content {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .item-image img {
        border-radius: 4px;
        object-fit: cover;
    }

    .title small {
        display: block;
        color: #666;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
    }

    .modal-content {
        background: white;
        margin: 10% auto;
        padding: 2rem;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        position: relative;
    }

    .close {
        position: absolute;
        right: 1rem;
        top: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .close:hover {
        color: var(--danger-color);
    }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        // Initialize Sortable for both lists
        new Sortable(document.getElementById('carouselItems'), {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                updateOrder('carousel', evt.target);
            }
        });

        new Sortable(document.getElementById('servicesItems'), {
            handle: '.handle',
            animation: 150,
            onEnd: function(evt) {
                updateOrder('services', evt.target);
            }
        });

        function updateOrder(type, list) {
            const items = list.querySelectorAll('.item');
            const itemOrder = Array.from(items).map((item, index) => ({
                id: item.dataset.id,
                position: index + 1
            }));

            const formData = new FormData();
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            formData.append('type', type);
            formData.append('itemOrder', JSON.stringify(itemOrder));

            fetch('<?= base_url('admin/home-edit/updateorder') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.success, data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage(false, 'Failed to update order');
            });
        }

        // Modal handling functions
        function editSlide(id) {
            // Fetch slide data and populate modal
            fetch(`<?= base_url('admin/home-edit/getslide/') ?>/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editSlideId').value = data.id;
                    document.getElementById('editSlideTitle').value = data.title;
                    document.getElementById('editSlideDescription').value = data.description;
                    document.getElementById('editSlideModal').style.display = 'block';
                });
        }

        function editService(id) {
            // Fetch service data and populate modal
            fetch(`<?= base_url('admin/home-edit/getservice/') ?>/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editServiceId').value = data.id;
                    document.getElementById('editServiceTitle').value = data.title;
                    document.getElementById('editServiceDescription').value = data.description;
                    document.getElementById('editServiceModal').style.display = 'block';
                });
        }

        // Close modals when clicking the close button or outside
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.onclick = function() {
                this.closest('.modal').style.display = 'none';
            }
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // Message handling function (same as your existing code)
        function showMessage(isSuccess, message) {
            const existingMessages = document.querySelectorAll('.message');
            existingMessages.forEach(msg => {
                msg.classList.add('hide');
                setTimeout(() => msg.remove(), 500);
            });

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isSuccess ? 'success' : 'error'}`;
            messageDiv.textContent = message;
            
            const container = document.querySelector('.container');
            container.insertBefore(messageDiv, container.firstChild);
            
            setTimeout(() => {
                messageDiv.classList.add('show');
            }, 10);

            setTimeout(() => {
                messageDiv.classList.add('hide');
                messageDiv.classList.remove('show');
                setTimeout(() => {
                    messageDiv.remove();
                }, 500);
            }, 3000);
        }

        // Initialize flash messages
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.message');
            flashMessages.forEach(message => {
                message.classList.add('show');
                setTimeout(() => {
                    message.classList.add('hide');
                    message.classList.remove('show');
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }, 3000);
            });
        });
    </script>
</body>
</html>