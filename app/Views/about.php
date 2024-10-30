<?= $this->include('partials/header') ?>
<?= $this->include('partials/navbar') ?>

    <main>
        <div class="about-hero">
            <img src="/api/placeholder/1920/1080" alt="About Us">
            <div class="hero-content">
                <h1>About Our Company</h1>
                <div class="hero-pixels">1920 × 1080 pixels | Digital Excellence</div>
            </div>
        </div>

        <div class="about-content">
            <div class="content-section">
                <h2 class="section-title">Our Story</h2>
                <p>Founded in 2020, our company has been at the forefront of digital innovation. We believe in creating solutions that not only meet current needs but anticipate future challenges. Our journey began with a simple mission: to make technology accessible and effective for businesses of all sizes.</p>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div>Projects Completed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div>Happy Clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div>Team Members</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div>Countries Served</div>
                </div>
            </div>

            <div class="content-section">
                <h2 class="section-title">Our Approach</h2>
                <div class="content-grid">
                    <div class="grid-item">
                        <h3>Innovation First</h3>
                        <p>We stay ahead of technological trends to deliver cutting-edge solutions that give our clients a competitive advantage.</p>
                    </div>
                    <div class="grid-item">
                        <h3>Client-Centric</h3>
                        <p>Your success is our success. We work closely with our clients to understand their unique needs and challenges.</p>
                    </div>
                    <div class="grid-item">
                        <h3>Quality Driven</h3>
                        <p>We maintain the highest standards in every project, ensuring robust, scalable, and efficient solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>


<?= $this->include('partials/footer') ?>