<!-- containers/view.php -->
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
        <div class="container-header">
            <div class="breadcrumb">
                <a href="<?= base_url('container') ?>">Containers</a>
                <i class="fas fa-chevron-right"></i>
                <span><?= esc($container['title']) ?></span>
            </div>
            <h1 class="page-title"><?= esc($container['title']) ?></h1>
            
            <div class="search-box">
                <form action="<?= current_url() ?>" method="GET">
                    <input type="text" 
                           name="search" 
                           value="<?= esc($search) ?>" 
                           placeholder="Search resources...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <?php if(empty($items)): ?>
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>No Resources Found</h3>
                <p>Try adjusting your search terms</p>
            </div>
        <?php else: ?>
            <div class="resources-grid">
                <?php foreach($items as $item): ?>
                    <div class="resource-card">
                        <?php if(isset($item['image'])): ?>
                            <div class="resource-image">
                                <img src="<?= base_url($item['image']) ?>" 
                                     alt="<?= esc($item['title']) ?>">
                            </div>
                        <?php endif; ?>
                        <div class="resource-content">
                            <h2 class="resource-title">
                                <?= esc($item['title']) ?>
                            </h2>
                            <p class="resource-description">
                                <?= esc($item['description']) ?>
                            </p>
                            <div class="resource-meta">
                                <span class="update-time">
                                    <i class="fas fa-clock"></i>
                                    <?= date('M d, Y', strtotime($item['updated_at'])) ?>
                                </span>
                            </div>
                            <a href="<?= base_url('container/' . $container['slug'] . '/items/' . $item['id']) ?>" 
                               class="view-resource">
                                View Resource <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if($pager['totalPages'] > 1): ?>
                <div class="pagination">
                    <div class="pagination-container">
                        <?php for($i = 1; $i <= $pager['totalPages']; $i++): ?>
                            <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="page-link <?= $i === $pager['currentPage'] ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <?= $this->include('partials/footer') ?>
</body>
</html>