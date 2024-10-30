<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Page</title>
    <style>
        main {
            margin-top: 60px;
        }

        .about-hero {
            position: relative;
            height: 400px;
            width: 100%;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .about-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            color: white;
            width: 80%;
            max-width: 800px;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 1s ease forwards;
        }

        .hero-pixels {
            font-family: monospace;
            font-size: 1.2rem;
            color: #3498db;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            margin-top: 1rem;
            opacity: 0;
            animation: fadeIn 1s ease 0.5s forwards;
        }

        .about-content {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .content-section {
            margin-bottom: 3rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .content-section.visible {
            opacity: 1;
            transform: translateY(0);
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

        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }
        }

        p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<?= $this->include('partials/header') ?>
<?= $this->include('partials/navbar') ?>
<body>
    <main>
        <div class="about-hero">
            <img src="https://placehold.co/1920x400" alt="Hero Image">
            <div class="hero-content">
                <h1>Exploring Nature's Beauty</h1>
                <div class="hero-pixels">1920 x 400 pixels</div>
            </div>
        </div>

        <div class="about-content">
            <section class="content-section visible">
                <h2 class="section-title">The Journey Through Wilderness</h2>
                <p>
                    Nature has always been a source of inspiration and wonder. From the towering peaks of ancient mountains to the gentle whisper of forest streams, every moment spent in the wilderness is a story waiting to be told. The raw beauty of untamed landscapes reminds us of our connection to the earth and the importance of preserving these natural sanctuaries for future generations.
                </p>
                <p>
                    As we venture deeper into these pristine environments, we discover not just the physical beauty of our natural world, but also the profound impact it has on our well-being. The crisp mountain air, the symphony of birdsong, and the intricate patterns of wildlife behavior all contribute to an experience that transcends ordinary existence.
                </p>
                <p>
                    Each journey into nature offers new perspectives and challenges our understanding of the world around us. Whether scaling steep cliffs, traversing dense forests, or simply sitting in quiet contemplation by a crystal-clear lake, these experiences shape our appreciation for the delicate balance of life on Earth.
                </p>
            </section>
        </div>
    </main>

    <script>
        // Add intersection observer to handle scroll animations
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