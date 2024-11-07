<!-- containers/item.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/containers.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>
    <main>
        <div class="item-container">
            <div class="breadcrumb">
                <a href="<?= base_url('container') ?>">Containers</a>
                <i class="fas fa-chevron-right"></i>
                <a href="<?= base_url('container/' . $container['slug']) ?>"><?= esc($container['title']) ?></a>
                <i class="fas fa-chevron-right"></i>
                <span><?= esc($item['title']) ?></span>
            </div>

            <article class="item-content">
                <?php if(isset($item['image'])): ?>
                    <div class="item-hero">
                        <img src="<?= base_url($item['image']) ?>" 
                             alt="<?= esc($item['title']) ?>">
                    </div>
                <?php endif; ?>

                <div class="item-header">
                    <h1 class="item-title"><?= esc($item['title']) ?></h1>
                    <div class="item-meta">
                        <span class="update-time">
                            <i class="fas fa-clock"></i>
                            Last updated: <?= date('M d, Y', strtotime($item['updated_at'])) ?>
                        </span>
                    </div>
                </div>

                <div class="item-description">
                    <?= esc($item['description']) ?>
                </div>

                <div class="item-body">
                    <?= $item['content'] ?>
                </div>
            </article>
        </div>
    </main>

    <?= $this->include('partials/footer') ?>
</body>
</html>