<!-- app/Views/footer/manage.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/admin/footer_manager.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar'); ?>
    <div class="main-content">
        <div class="container">
            <h1 class="page-title">Manage Footer Content</h1>

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

            <!-- Company Information Settings -->
            <div class="section-card">
                <h2 class="section-title">Company Information</h2>
                <form action="<?= base_url('admin/footermanager/updateSettings') ?>" method="POST" class="footer-settings">
                    <?= csrf_field() ?>
                    
                    <div class="settings-card">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="settings[company_name]" 
                                   class="form-control" value="<?= esc($settings['company_name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_email">Email</label>
                            <input type="email" id="company_email" name="settings[company_email]" 
                                   class="form-control" value="<?= esc($settings['company_email'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_phone">Phone</label>
                            <input type="text" id="company_phone" name="settings[company_phone]" 
                                   class="form-control" value="<?= esc($settings['company_phone'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="settings-card">
                        <div class="form-group">
                            <label for="company_address">Address</label>
                            <textarea id="company_address" name="settings[company_address]" 
                                    class="form-control textarea-control" required><?= esc($settings['company_address'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_description">Company Description</label>
                            <textarea id="company_description" name="settings[company_description]" 
                                    class="form-control textarea-control" required><?= esc($settings['company_description'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </form>
            </div>

            <!-- Social Links Section -->
            <div class="section-card">
                <h2 class="section-title">
                    Social Links
                    <button type="button" class="btn btn-primary" onclick="addSocialLink()">
                        <i class="fas fa-plus"></i> Add Social Link
                    </button>
                </h2>
                
                <div id="socialLinksList">
                    <?php foreach ($socialLinks as $link): ?>
                    <div class="footer-item" data-id="<?= $link['id'] ?>">
                        <div class="handle">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <div class="title"><?= esc($link['platform']) ?></div>
                        <div class="url"><?= esc($link['url']) ?></div>
                        <div class="actions">
                            <button class="btn-icon delete" onclick="deleteSocialLink(<?= $link['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="socialLinkModal" class="modal">
    <div class="modal-content">
        <button type="button" class="modal-close" onclick="closeSocialLinkModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <h3>
            <i class="fas fa-link"></i>
            Add Social Link
        </h3>
        
        <form id="socialLinkForm">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="platform">
                    <i class="fas fa-hashtag"></i>
                    Platform Name
                </label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="platform" 
                           name="platform" 
                           class="form-control" 
                           placeholder="e.g. Facebook, Twitter, LinkedIn"
                           required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="url">
                    <i class="fas fa-globe"></i>
                    Profile URL
                </label>
                <div class="input-wrapper">
                    <input type="url" 
                           id="url" 
                           name="url" 
                           class="form-control"
                           placeholder="https://..."
                           required>
                </div>
            </div>

            <div class="modal-buttons">
                <button type="button" 
                        class="btn btn-secondary" 
                        onclick="closeSocialLinkModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" 
                        class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Link
                </button>
            </div>
        </form>
    </div>
</div>
<div class="section-card">
    <h2 class="section-title">Footer Quick Links</h2>
    <div class="settings-card">
        <form action="<?= base_url('admin/footermanager/updateQuickLinks') ?>" method="POST" class="footer-settings">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label>Select Navigation Items to Show in Footer</label>
                <div class="checkbox-list">
                    <?php 
                    $navbarModel = new \App\Models\NavbarItemModel();
                    $navItems = $navbarModel->where('is_active', 1)
                                          ->orderBy('order_position', 'ASC')
                                          ->findAll();
                    $footerConfig = json_decode(file_get_contents(WRITEPATH . 'json/footer_config.json'), true);
                    $selectedItems = $footerConfig['footer_links'] ?? [];
                    
                    foreach ($navItems as $item): 
                    ?>
                        <div class="checkbox-item">
                            <input type="checkbox" 
                                   id="nav_item_<?= $item['id'] ?>" 
                                   name="footer_links[]" 
                                   value="<?= $item['id'] ?>"
                                   <?= in_array($item['id'], $selectedItems) ? 'checked' : '' ?>>
                            <label for="nav_item_<?= $item['id'] ?>">
                                <?= esc($item['title']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Quick Links
            </button>
        </form>
    </div>
</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        // Initialize Sortable for social links
        new Sortable(document.getElementById('socialLinksList'), {
            handle: '.handle',
            animation: 150,
            ghostClass: 'ghost',
            onEnd: function(evt) {
                // Similar to your navbar order update logic
                updateSocialLinksOrder();
            }
        });

        function showMessage(isSuccess, message) {
            // Your existing showMessage function
        }

        function addSocialLink() {
            document.getElementById('socialLinkModal').style.display = 'block';
        }

        function closeSocialLinkModal() {
            document.getElementById('socialLinkModal').style.display = 'none';
        }

        function deleteSocialLink(id) {
            if (confirm('Are you sure you want to delete this social link?')) {
                // Send delete request
                fetch(`<?= base_url('admin/footermanager/deleteSocialLink/') ?>/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('[name="csrf_test_name"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.footer-item[data-id="${id}"]`).remove();
                        showMessage(true, 'Social link deleted successfully');
                    } else {
                        showMessage(false, 'Failed to delete social link');
                    }
                });
            }
        }

        function updateSocialLinksOrder() {
            const items = document.querySelectorAll('.footer-item');
            const itemOrder = Array.from(items).map((item, index) => ({
                id: item.dataset.id,
                position: index + 1
            }));

            fetch('<?= base_url('admin/footermanager/updateSocialLinksOrder') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('[name="csrf_test_name"]').value
                },
                body: JSON.stringify({ order: itemOrder })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(true, 'Order updated successfully');
                } else {
                    showMessage(false, 'Failed to update order');
                }
            });
        }

        // Handle social link form submission
        document.getElementById('socialLinkForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('<?= base_url('admin/footermanager/addSocialLink') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new social link to the list
                    const newLink = createSocialLinkElement(data.link);
                    document.getElementById('socialLinksList').appendChild(newLink);
                    closeSocialLinkModal();
                    showMessage(true, 'Social link added successfully');
                } else {
                    showMessage(false, 'Failed to add social link');
                }
            });
        });

        function createSocialLinkElement(link) {
            // Create and return new social link DOM element
            const div = document.createElement('div');
            div.className = 'footer-item';
            div.dataset.id = link.id;
            div.innerHTML = `
                <div class="handle">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <div class="title">${link.platform}</div>
                <div class="url">${link.url}</div>
                <div class="actions">
                    <button class="btn-icon delete" onclick="deleteSocialLink(${link.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            return div;
        }
        function addSocialLink() {
    const modal = document.getElementById('socialLinkModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close modal with cleanup
function closeSocialLinkModal() {
    const modal = document.getElementById('socialLinkModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    document.getElementById('socialLinkForm').reset();
}

// Close modal if clicking outside
document.getElementById('socialLinkModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSocialLinkModal();
    }
});

document.getElementById('socialLinkForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?= base_url('admin/footermanager/addSocialLink') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newLink = createSocialLinkElement(data.link);
                document.getElementById('socialLinksList').appendChild(newLink);
                closeSocialLinkModal();
                showMessage(true, 'Social link added successfully');
            } else {
                showMessage(false, 'Failed to add social link');
            }
        });
    });
    </script>
</body>
</html>