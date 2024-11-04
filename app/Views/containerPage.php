<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Containers Page</title>
    <style>
        /* Existing styles */
        main {
            margin-top: 60px;
        }

        .about-content {
            max-width: 1000px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        /* New styles for containers */
        .containers-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .container-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            max-width: 300px;
            margin: 0 auto;
        }

        .container-card:hover {
            transform: translateY(-5px);
        }

        .container-image {
            width: 100%;
            height: 160px;
            overflow: hidden;
        }

        .container-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .container-card:hover .container-image img {
            transform: scale(1.05);
        }

        .container-content {
            padding: 1.25rem; /* Reduced from 1.5rem */
        }

        .container-title {
            color: #2c3e50;
            font-size: 1.25rem; /* Reduced from 1.5rem */
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .container-text {
            color: #555;
            line-height: 1.5;
            margin-bottom: 1rem;
            font-size: 0.9rem; /* Added smaller font size */
        }

        .read-more-btn {
            display: inline-block;
            padding: 0.5rem 1.25rem; /* Reduced padding */
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-size: 0.9rem; /* Added smaller font size */
        }

        .read-more-btn:hover {
            background-color: #2980b9;
        }

        .section-title {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background: #3498db;
            transition: width 0.3s ease;
        }

        .content-section:hover .section-title::after {
            width: 150px;
        }

        @media (max-width: 1024px) {
            .containers-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .containers-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>
    
    <main>
        <div class="about-content">
            <section class="content-section visible">
                <h2 class="section-title">Featured Content</h2>
                <div class="containers-grid">
                    <!-- Container 1 -->
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Nature Landscape">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Mountain Adventures</h3>
                            <p class="container-text">
                                Discover the breathtaking beauty of mountain landscapes and the thrill of hiking through scenic trails.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>

                    <!-- Container 2 -->
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Forest View">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Forest Exploration</h3>
                            <p class="container-text">
                                Immerse yourself in the tranquility of ancient forests. Learn about diverse ecosystems.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>

                    <!-- Container 3 -->
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Coastal Scene">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Coastal Journeys</h3>
                            <p class="container-text">
                                Experience the magic of coastal landscapes, from dramatic cliffs to serene beaches.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Nature Landscape">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Mountain Adventures</h3>
                            <p class="container-text">
                                Discover the breathtaking beauty of mountain landscapes and the thrill of hiking through scenic trails.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>

                    <!-- Container 2 -->
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Forest View">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Forest Exploration</h3>
                            <p class="container-text">
                                Immerse yourself in the tranquility of ancient forests. Learn about diverse ecosystems.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>

                    <!-- Container 3 -->
                    <div class="container-card">
                        <div class="container-image">
                            <img src="https://placehold.co/300x160" alt="Coastal Scene">
                        </div>
                        <div class="container-content">
                            <h3 class="container-title">Coastal Journeys</h3>
                            <p class="container-text">
                                Experience the magic of coastal landscapes, from dramatic cliffs to serene beaches.
                            </p>
                            <a href="#" class="read-more-btn">Read More</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.content-section').forEach((section) => {
            observer.observe(section);
        });
    </script>
</body>
</html>