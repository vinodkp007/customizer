<!-- containers/index.php -->
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
        <div class="page-header">
            <h1 class="page-title"><?= esc($title) ?></h1>
        </div>

        <?php if(empty($containers)): ?>
            <div class="empty-state">
                <i class="fas fa-layer-group"></i>
                <h3>No Learning Containers Available</h3>
                <p>Check back later for new content</p>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach($containers as $container): ?>
                    <article class="blog-card">
                        <div class="blog-content">
                            <h2 class="blog-title">
                                <a href="<?= base_url('container/' . $container['slug']) ?>">
                                    <?= esc($container['title']) ?>
                                </a>
                            </h2>
                            <div class="blog-meta">
                                <span class="resource-count">
                                    <i class="fas fa-book-open"></i>
                                    <?= $container['item_count'] ?> Resources
                                </span>
                                <?php if(isset($container['updated_at'])): ?>
                                    <span class="update-time">
                                        <i class="fas fa-clock"></i>
                                        Updated: <?= date('M d, Y', strtotime($container['updated_at'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="blog-preview">
                                <p>Explore our curated collection of resources about <?= esc($container['title']) ?>.</p>
                            </div>
                            <a href="<?= base_url('container/' . $container['slug']) ?>" class="read-more">
                                Browse Resources <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <?= $this->include('partials/footer') ?>
</body>
</html>
