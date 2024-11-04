<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content Page</title>
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
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
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

        .content-editor {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .editor-section {
            padding: 2rem;
            border-bottom: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: #3498db;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #3498db;
            outline: none;
            background: white;
        }

        .image-preview {
            width: 100%;
            height: 300px;
            background: #f8f9fa;
            border: 2px dashed #e9ecef;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            overflow: hidden;
            position: relative;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .image-preview::after {
            content: 'Click to upload image';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #7f8c8d;
            font-size: 1rem;
            pointer-events: none;
            opacity: 0.7;
        }

        .paragraph-container {
            margin-top: 1rem;
            display: grid;
            gap: 1rem;
        }

        .paragraph-item {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .paragraph-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .paragraph-actions {
            position: absolute;
            right: 1rem;
            top: 1rem;
            display: flex;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .paragraph-item:hover .paragraph-actions {
            opacity: 1;
        }

        .action-btn {
            background: white;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .edit-btn {
            color: #3498db;
        }

        .delete-btn {
            color: #e74c3c;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .add-paragraph-btn {
            width: 100%;
            background: #f8f9fa;
            color: #3498db;
            border: 2px dashed #3498db;
            padding: 1rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .add-paragraph-btn:hover {
            background: #3498db;
            color: white;
        }

        .save-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin: 2rem auto 0;
        }

        .save-btn:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            opacity: 1;
            transition: opacity 0.5s ease;
            text-align: center;
            max-width: 1200px;
            margin: 0 auto 1rem;
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
            <h2>Edit Content Page</h2>
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
            <!-- In your form -->
<input type="hidden" name="navbar_item_id" value="<?= $navbar_item_id ?? '' ?>">
            <div class="content-editor">
                <div class="editor-section">
                    <h3 class="section-title">
                        <i class="fas fa-image"></i>
                        Hero Section
                    </h3>
                    <div class="form-group">
                        <label class="form-label">Hero Title</label>
                        <input type="text" class="form-control" name="hero_title" placeholder="Enter hero title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hero Image</label>
                        <input type="file" class="form-control" name="hero_image" accept="image/*" style="display: none;" id="heroImage">
                        <div class="image-preview" onclick="document.getElementById('heroImage').click()">
                            <img src="https://placehold.co/1920x400" alt="Hero Preview">
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
                        <input type="text" class="form-control" name="section_title" placeholder="Enter section title" required>
                    </div>

                    <div class="paragraph-container">
                        <div class="paragraph-item">
                            <div class="paragraph-actions">
                                <button type="button" class="action-btn delete-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <textarea class="form-control" name="paragraphs[]" rows="4" placeholder="Enter your content here" required></textarea>
                        </div>
                    </div>

                    <button type="button" class="add-paragraph-btn">
                        <i class="fas fa-plus"></i>
                        Add New Paragraph
                    </button>
                </div>

                <div class="editor-section">
                    <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i>
                        Save Changes
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