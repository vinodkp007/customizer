<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/containerItem.css') ?>">
</head>
<body>
    <?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>
    
    <main class="item-page">
        <div class="item-header">
            <a href="<?= base_url("container/$category") ?>" class="back-link">← Back to <?= ucfirst(esc($category)) ?></a>
            <h1><?= esc($item['title']) ?></h1>
            <p class="description"><?= esc($item['description']) ?></p>
        </div>

        <?php if (!empty($item['image'])): ?>
            <div class="item-image">
                <img src="<?= base_url($item['image']) ?>" 
                     alt="<?= esc($item['title']) ?>"
                     loading="lazy">
            </div>
        <?php endif; ?>

        <div class="item-content">
            <?= $item['content'] ?>
        </div>

        <div class="item-meta">
            <div class="meta-info">
                <span>Created: <?= esc($item['created_at']) ?></span>
                <?php if (!empty($item['updated_at'])): ?>
                    <span>Updated: <?= esc($item['updated_at']) ?></span>
                <?php endif; ?>
                <span class="status <?= esc($item['status']) ?>">
                    <?= ucfirst(esc($item['status'])) ?>
                </span>
            </div>
        </div>
    </main>

    <?= $this->include('partials/footer') ?>
</body>
</html>