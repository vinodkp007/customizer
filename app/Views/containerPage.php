
    <?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>
    
    <main>
        <div class="page-header">
            <h1 class="page-title">Featured Content</h1>
        </div>

        <div class="containers-grid">
            <?php if (!empty($containers)): ?>
                <?php foreach ($containers as $container): ?>
                    <div class="container-card">
                        <div class="container-image">
                            <?php if ($container['image_url']): ?>
                                <img src="<?= base_url($container['image_url']) ?>" 
                                     alt="<?= esc($container['title']) ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <img src="/api/placeholder/300/160" 
                                     alt="Placeholder"
                                     loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="container-content">
                            <h3 class="container-title"><?= esc($container['title']) ?></h3>
                            <p class="container-text">
                                <?= esc($container['description']) ?>
                            </p>
                            <a href="<?= base_url('container/' . esc($container['slug'])) ?>" 
                               class="read-more-btn">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-containers">
                    <p>No container pages found.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?= $pager->links() ?>
        </div>
    </main>

    <?= $this->include('partials/footer') ?>
</body>
</html>