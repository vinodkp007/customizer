<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            background-color: #fafafa;
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 6rem 2rem;
        }

        .page-header {
            margin-bottom: 6rem;
            text-align: center;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 300;
            letter-spacing: -0.5px;
            color: #1a1a1a;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: #1a1a1a;
        }

        .splits-container {
            display: flex;
            flex-direction: column;
            gap: 8rem;
        }

        .split-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .split-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .image-side {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4/3;
        }

        .image-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.1);
            transition: transform 1.2s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .split-container:hover .image-side img {
            transform: scale(1);
        }

        .content-side {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background: #1a1a1a;
            transition: width 0.6s ease;
        }

        .content-side:hover .section-title::after {
            width: 60px;
        }

        .content-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #4a4a4a;
            max-width: 90%;
        }

        @media (max-width: 968px) {
            .split-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .content-text {
                font-size: 1rem;
                max-width: 100%;
            }

            main {
                padding: 4rem 1.5rem;
            }

            .splits-container {
                gap: 6rem;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }

            main {
                padding: 3rem 1rem;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('partials/header') ?>
    <?= $this->include('partials/navbar') ?>
    
    <main>
        <header class="page-header">
            <h1 class="page-title"><?= esc($title) ?></h1>
        </header>

        <div class="splits-container">
            <?php foreach ($collections as $collection): ?>
                <div class="split-container">
                    <div class="image-side">
                        <img src="<?= esc($collection['image']) ?>" alt="<?= esc($collection['alt_text']) ?>">
                    </div>
                    <div class="content-side">
                        <h2 class="section-title"><?= esc($collection['title']) ?></h2>
                        <p class="content-text"><?= esc($collection['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.split-container').forEach(container => {
                observer.observe(container);
            });
        });
    </script>
</body>
</html>