<!-- app/Views/home.php -->
<?= $this->include('partials/header') ?>
<?= $this->include('partials/navbar') ?>

<main id="mainContent">
    <!-- Carousel Section -->
    <div class="carousel-container">
        <div class="carousel">
            <?php if (!empty($carouselItems)): ?>
                <?php foreach ($carouselItems as $slide): ?>
                <div class="carousel-slide">
                    <img src="<?= base_url($slide['image']) ?>" alt="<?= esc($slide['title']) ?>">
                    <div class="placeholder-text">
                        <h2><?= esc($slide['title']) ?></h2>
                        <p><?= esc($slide['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default Slides -->
                <div class="carousel-slide">
                    <img src="https://placehold.co/1200x600" alt="Welcome">
                    <div class="placeholder-text">
                        <h2>Welcome to Our Digital Solutions</h2>
                        <p>Transforming Ideas into Reality</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="https://placehold.co/1200x600" alt="Innovation">
                    <div class="placeholder-text">
                        <h2>Innovative Technology</h2>
                        <p>Building the Future Today</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="https://placehold.co/1200x600" alt="Expert Solutions">
                    <div class="placeholder-text">
                        <h2>Expert Solutions</h2>
                        <p>Delivering Excellence in Every Project</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="https://placehold.co/1200x600" alt="Creative Design">
                    <div class="placeholder-text">
                        <h2>Creative Design</h2>
                        <p>Where Vision Meets Innovation</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="https://placehold.co/1200x600" alt="Global Reach">
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
    <?php if (!empty($components)): ?>
    <?php foreach ($components as $component): ?>
        <?php if (!empty($component['items'])): ?>
            <section class="services-section">
                <h2 class="section-title"><?= esc($component['title']) ?></h2>

                <?php foreach ($component['items'] as $item): ?>
                    <div class="service-item">
                        <div class="service-content">
                            <h3 class="service-title"><?= esc($item['title']) ?></h3>
                            <p class="service-description"><?= esc($item['description']) ?></p>
                        </div>
                        <div class="service-image">
                            <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['title']) ?>">
                        </div>
                    </div>
                <?php endforeach; ?>

            </section>
        <?php else: ?>
            <!-- Default content for services if no items are found -->
            <?php if ($component['slug'] == 'services'): ?>
                <section class="services-section">
                    <h2 class="section-title"><?= esc($component['title']) ?></h2>

                    <div class="service-item">
                        <div class="service-content">
                            <h3 class="service-title">Web Development</h3>
                            <p class="service-description">Create stunning, responsive websites tailored to your needs. Our expert team combines cutting-edge technology with elegant design to deliver exceptional web solutions.</p>
                        </div>
                        <div class="service-image">
                            <img src="https://placehold.co/600x400" alt="Web Development">
                        </div>
                    </div>
                    <div class="service-item">
                        <div class="service-content">
                            <h3 class="service-title">Mobile Applications</h3>
                            <p class="service-description">Transform your ideas into powerful mobile applications. We develop intuitive, feature-rich apps that provide seamless user experiences across all platforms.</p>
                        </div>
                        <div class="service-image">
                            <img src="https://placehold.co/600x400" alt="Mobile Applications">
                        </div>
                    </div>
                    <div class="service-item">
                        <div class="service-content">
                            <h3 class="service-title">Cloud Solutions</h3>
                            <p class="service-description">Leverage the power of cloud computing for your business. Our cloud solutions help you scale efficiently while maintaining security and performance.</p>
                        </div>
                        <div class="service-image">
                            <img src="https://placehold.co/600x400" alt="Cloud Solutions">
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

</main>



<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Your company description here. Providing quality services since [year].</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p>Email: info@example.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: Your Address Here</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Your Company Name. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script>
// Add this before including home_script.js to pass PHP data to JavaScript
window.pageData = {
    carouselItems: <?= json_encode(!empty($carouselItems) ? $carouselItems : []) ?>,
    services: <?= json_encode(!empty($services) ? $services : []) ?>
};
</script>
<script src="<?= base_url('assets/js/home_script.js') ?>"></script>
</body>
</html>