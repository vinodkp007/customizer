<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content Page</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/contentModify.css') ?>">
</head>
<body>
    <?= $this->include('admin/partials/sidebar') ?>

    <div class="content-wrapper">
        <div class="page-header">
            <h2><?= $isEdit ? 'Edit' : 'Create' ?> Content Page</h2>
            <p>Customize your page content and layout</p>
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

        <form action="<?= base_url('admin/content/save') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="navbar_item_id" value="<?= $navbar_item_id ?>">
            <?php if($isEdit && isset($content['content_page_id'])): ?>
                <input type="hidden" name="content_page_id" value="<?= $content['content_page_id'] ?>">
            <?php endif; ?>

            <div class="content-editor">
                <div class="editor-section">
                    <h3 class="section-title">
                        <i class="fas fa-image"></i>
                        Hero Section
                    </h3>
                    <div class="form-group">
                        <label class="form-label">Hero Title</label>
                        <input type="text" 
                               class="form-control" 
                               name="hero_title" 
                               placeholder="Enter hero title" 
                               value="<?= $isEdit ? esc($content['hero_title']) : '' ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hero Image</label>
                        <input type="file" 
                               class="form-control" 
                               name="hero_image" 
                               accept="image/*" 
                               style="display: none;" 
                               id="heroImage">
                        <div class="image-preview" onclick="document.getElementById('heroImage').click()">
                            <img src="<?= $isEdit && $content['hero_image'] 
                                        ? base_url($content['hero_image']) 
                                        : 'https://placehold.co/1920x400' ?>" 
                                 alt="Hero Preview">
                        </div>
                    </div>
                </div>

                <div class="editor-section">
                    <h3 class="section-title">
                        <i class="fas fa-paragraph"></i>
                        Content Sections
                    </h3>
                    <div class="form-group">
                        <label class="form-label">Section Title</label>
                        <input type="text" 
                               class="form-control" 
                               name="section_title" 
                               placeholder="Enter section title" 
                               value="<?= $isEdit ? esc($content['section_title']) : '' ?>"
                               required>
                    </div>

                    <div class="paragraph-container">
                        <?php if($isEdit && !empty($content['sections'])): ?>
                            <?php foreach($content['sections'] as $section): ?>
                                <div class="paragraph-item">
                                    <div class="paragraph-actions">
                                        <button type="button" class="action-btn delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <textarea class="form-control" 
                                              name="paragraphs[]" 
                                              rows="4" 
                                              placeholder="Enter your content here" 
                                              required><?= esc($section['content']) ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="paragraph-item">
                                <div class="paragraph-actions">
                                    <button type="button" class="action-btn delete-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <textarea class="form-control" 
                                          name="paragraphs[]" 
                                          rows="4" 
                                          placeholder="Enter your content here" 
                                          required></textarea>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="add-paragraph-btn">
                        <i class="fas fa-plus"></i>
                        Add New Paragraph
                    </button>
                </div>

                <div class="editor-section">
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i>
                        <?= $isEdit ? 'Update Changes' : 'Save Changes' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview
            const imageInput = document.getElementById('heroImage');
            const previewImg = document.querySelector('.image-preview img');
            
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => previewImg.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });

            // Add paragraph button
            document.querySelector('.add-paragraph-btn').addEventListener('click', function() {
                const container = document.querySelector('.paragraph-container');
                const newParagraph = document.createElement('div');
                newParagraph.className = 'paragraph-item';
                newParagraph.innerHTML = `
                    <div class="paragraph-actions">
                        <button type="button" class="action-btn delete-btn" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <textarea class="form-control" name="paragraphs[]" rows="4" placeholder="Enter your content here" required></textarea>
                `;
                container.appendChild(newParagraph);
                
                // Add delete listener
                newParagraph.querySelector('.delete-btn').addEventListener('click', function() {
                    if (document.querySelectorAll('.paragraph-item').length > 1) {
                        if (confirm('Are you sure you want to delete this paragraph?')) {
                            newParagraph.remove();
                        }
                    } else {
                        alert('You must have at least one paragraph.');
                    }
                });
            });

            // Initialize delete buttons
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const paragraphs = document.querySelectorAll('.paragraph-item');
                    if (paragraphs.length > 1) {
                        if (confirm('Are you sure you want to delete this paragraph?')) {
                            btn.closest('.paragraph-item').remove();
                        }
                    } else {
                        alert('You must have at least one paragraph.');
                    }
                });
            });

            // Auto-hide alerts
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>