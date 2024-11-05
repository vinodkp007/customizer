// public/assets/js/home_script.js

// Page data
const defaultData = {
    carousel: [
        { 
            image: '/api/placeholder/1200x600',
            title: 'Welcome to Our Digital Solutions',
            description: 'Transforming Ideas into Reality'
        },
        { 
            image: '/api/placeholder/1200x600',
            title: 'Innovative Technology',
            description: 'Building the Future Today'
        },
        { 
            image: '/api/placeholder/1200x600',
            title: 'Expert Solutions',
            description: 'Delivering Excellence in Every Project'
        }
    ],
    services: [
        {
            title: 'Web Development',
            description: 'Create stunning, responsive websites tailored to your needs.',
            image: '/api/placeholder/600x400'
        },
        {
            title: 'Mobile Applications',
            description: 'Transform your ideas into powerful mobile applications.',
            image: '/api/placeholder/600x400'
        },
        {
            title: 'Cloud Solutions',
            description: 'Leverage the power of cloud computing for your business.',
            image: '/api/placeholder/600x400'
        }
    ]
};

// DOM Elements
const mainContent = document.getElementById('mainContent');
const adminToggle = document.getElementById('adminToggle');
const adminPanel = document.getElementById('adminPanel');

// Carousel state
let currentSlide = 0;
let carouselInterval;

// Intersection Observer for animations
const visibilityObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

// Event Listeners
adminToggle?.addEventListener('click', () => {
    adminPanel.classList.toggle('active');
});

// Carousel functionality
function startCarousel() {
    clearInterval(carouselInterval);
    const slides = document.querySelectorAll('.carousel-slide');
    if (!slides.length) return;

    carouselInterval = setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        updateCarousel();
    }, 5000);
}

function updateCarousel() {
    const carousel = document.querySelector('.carousel');
    const dots = document.querySelectorAll('.dot');
    if (carousel && dots) {
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
}

// Initialize dot click handlers
function initDotHandlers() {
    document.querySelectorAll('.dot').forEach(dot => {
        dot.addEventListener('click', () => {
            currentSlide = parseInt(dot.dataset.index);
            updateCarousel();
            startCarousel();
        });
    });
}

// Add intersection observer to service items
function initServiceAnimations() {
    document.querySelectorAll('.service-item').forEach(item => {
        visibilityObserver.observe(item);
    });
}

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    startCarousel();
    initDotHandlers();
    initServiceAnimations();
});