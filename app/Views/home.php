<!-- app/Views/home.php -->
<?= $this->include('partials/header') ?>
<?= $this->include('partials/navbar') ?>
<pre><?php print_r($carouselItems); ?></pre>



<main id="mainContent">
    <!-- Carousel Section -->
    <div class="carousel-container">
        <div class="carousel">
            <?php 
            $carouselComponent = array_filter($components, function($comp) {
                return $comp['slug'] === 'home-carousel';
            });
            $carouselItems = !empty($carouselComponent) ? reset($carouselComponent)['items'] : [];
            ?>

            <?php if (!empty($carouselItems)): ?>
                <?php foreach ($carouselItems as $slide): ?>
                <div class="carousel-slide">
                    <img src="<?= !empty($slide['image']) ? base_url($slide['image']) : '/api/placeholder/1200x600' ?>" 
                         alt="<?= esc($slide['title']) ?>">
                    <div class="placeholder-text">
                        <h2><?= esc($slide['title']) ?></h2>
                        <p><?= esc($slide['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Slides -->
                <div class="carousel-slide">
                    <img src="/api/placeholder/1200x600" alt="Welcome">
                    <div class="placeholder-text">
                        <h2>Welcome to Our Digital Solutions</h2>
                        <p>Transforming Ideas into Reality</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="/api/placeholder/1200x600" alt="Innovation">
                    <div class="placeholder-text">
                        <h2>Innovative Technology</h2>
                        <p>Building the Future Today</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="/api/placeholder/1200x600" alt="Expert Solutions">
                    <div class="placeholder-text">
                        <h2>Expert Solutions</h2>
                        <p>Delivering Excellence in Every Project</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="/api/placeholder/1200x600" alt="Creative Design">
                    <div class="placeholder-text">
                        <h2>Creative Design</h2>
                        <p>Where Vision Meets Innovation</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="/api/placeholder/1200x600" alt="Global Reach">
                    <div class="placeholder-text">
                        <h2>Global Reach</h2>
                        <p>Connecting Business Worldwide</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="carousel-dots">
            <?php 
            $slideCount = !empty($carouselItems) ? count($carouselItems) : 5;
            for ($i = 0; $i < $slideCount; $i++): 
            ?>
                <div class="dot <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>"></div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Services Section -->
    <section class="services-section">
        <?php 
        $servicesComponent = array_filter($components, function($comp) {
            return $comp['slug'] === 'services';
        });
        $services = !empty($servicesComponent) ? reset($servicesComponent)['items'] : [];
        ?>

        <h2 class="section-title">Our Services</h2>
        <?php if (!empty($services)): ?>
            <?php foreach ($services as $service): ?>
            <div class="service-item">
                <div class="service-content">
                    <h3 class="service-title"><?= esc($service['title']) ?></h3>
                    <p class="service-description"><?= esc($service['description']) ?></p>
                </div>
                <div class="service-image">
                    <img src="<?= !empty($service['image']) ? base_url($service['image']) : '/api/placeholder/600x400' ?>" 
                         alt="<?= esc($service['title']) ?>">
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default Services -->
            <div class="service-item">
                <div class="service-content">
                    <h3 class="service-title">Web Development</h3>
                    <p class="service-description">Create stunning, responsive websites tailored to your needs. Our expert team combines cutting-edge technology with elegant design to deliver exceptional web solutions.</p>
                </div>
                <div class="service-image">
                    <img src="/api/placeholder/600x400" alt="Web Development">
                </div>
            </div>
            <div class="service-item">
                <div class="service-content">
                    <h3 class="service-title">Mobile Applications</h3>
                    <p class="service-description">Transform your ideas into powerful mobile applications. We develop intuitive, feature-rich apps that provide seamless user experiences across all platforms.</p>
                </div>
                <div class="service-image">
                    <img src="/api/placeholder/600x400" alt="Mobile Applications">
                </div>
            </div>
            <div class="service-item">
                <div class="service-content">
                    <h3 class="service-title">Cloud Solutions</h3>
                    <p class="service-description">Leverage the power of cloud computing for your business. Our cloud solutions help you scale efficiently while maintaining security and performance.</p>
                </div>
                <div class="service-image">
                    <img src="/api/placeholder/600x400" alt="Cloud Solutions">
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

<?= $this->include('partials/footer') ?>

<!-- Scripts -->
<script>
// Pass PHP data to JavaScript with proper component structure
window.pageData = {
    carouselItems: <?= json_encode(!empty($carouselItems) ? array_map(function($item) {
        return [
            'image' => !empty($item['image']) ? base_url($item['image']) : '/api/placeholder/1200x600',
            'title' => $item['title'],
            'description' => $item['description']
        ];
    }, $carouselItems) : []) ?>,
    services: <?= json_encode(!empty($services) ? array_map(function($item) {
        return [
            'title' => $item['title'],
            'description' => $item['description'],
            'image' => !empty($item['image']) ? base_url($item['image']) : '/api/placeholder/600x400'
        ];
    }, $services) : []) ?>
};
</script>
<script src="<?= base_url('assets/js/home_script.js') ?>"></script>
</body>
</html>