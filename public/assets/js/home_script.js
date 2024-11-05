// Page data initialization from PHP
const pageData = window.pageData || { carouselItems: [], services: [] };

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

// Render Carousel items dynamically based on pageData
function renderCarousel() {
    const carouselContainer = document.querySelector('.carousel');
    if (!carouselContainer) return;

    const carouselItems = pageData.carouselItems.length > 0 ? pageData.carouselItems : [
        { image: '/api/placeholder/1200x600', title: 'Welcome to Our Digital Solutions', description: 'Transforming Ideas into Reality' },
        { image: '/api/placeholder/1200x600', title: 'Innovative Technology', description: 'Building the Future Today' },
        { image: '/api/placeholder/1200x600', title: 'Expert Solutions', description: 'Delivering Excellence in Every Project' }
    ];

    // Clear existing carousel content
    carouselContainer.innerHTML = '';

    // Render slides dynamically
    carouselItems.forEach(item => {
        const slide = document.createElement('div');
        slide.classList.add('carousel-slide');
        
        const img = document.createElement('img');
        img.src = item.image || '/api/placeholder/1200x600';
        img.alt = item.title;

        const placeholderText = document.createElement('div');
        placeholderText.classList.add('placeholder-text');

        const title = document.createElement('h2');
        title.textContent = item.title;

        const description = document.createElement('p');
        description.textContent = item.description;

        placeholderText.appendChild(title);
        placeholderText.appendChild(description);
        slide.appendChild(img);
        slide.appendChild(placeholderText);

        carouselContainer.appendChild(slide);
    });

    // Update dots dynamically
    const dotContainer = document.querySelector('.carousel-dots');
    if (dotContainer) {
        dotContainer.innerHTML = '';
        carouselItems.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            dot.dataset.index = index;
            if (index === 0) dot.classList.add('active');
            dotContainer.appendChild(dot);
        });
    }

    startCarousel();
    initDotHandlers();
}

// Render Services items dynamically based on pageData
function renderServices() {
    const servicesSection = document.querySelector('.services-section');
    if (!servicesSection) return;

    const services = pageData.services.length > 0 ? pageData.services : [
        { title: 'Web Development', description: 'Create stunning, responsive websites tailored to your needs.', image: '/api/placeholder/600x400' },
        { title: 'Mobile Applications', description: 'Transform your ideas into powerful mobile applications.', image: '/api/placeholder/600x400' },
        { title: 'Cloud Solutions', description: 'Leverage the power of cloud computing for your business.', image: '/api/placeholder/600x400' }
    ];

    // Clear existing service items
    servicesSection.innerHTML = '<h2 class="section-title">Our Services</h2>';

    // Render services dynamically
    services.forEach(service => {
        const serviceItem = document.createElement('div');
        serviceItem.classList.add('service-item');

        const serviceContent = document.createElement('div');
        serviceContent.classList.add('service-content');

        const serviceTitle = document.createElement('h3');
        serviceTitle.classList.add('service-title');
        serviceTitle.textContent = service.title;

        const serviceDescription = document.createElement('p');
        serviceDescription.classList.add('service-description');
        serviceDescription.textContent = service.description;

        serviceContent.appendChild(serviceTitle);
        serviceContent.appendChild(serviceDescription);

        const serviceImage = document.createElement('div');
        serviceImage.classList.add('service-image');

        const img = document.createElement('img');
        img.src = service.image || '/api/placeholder/600x400';
        img.alt = service.title;

        serviceImage.appendChild(img);
        
        serviceItem.appendChild(serviceContent);
        serviceItem.appendChild(serviceImage);
        
        servicesSection.appendChild(serviceItem);
    });

    // Initialize service animations
    initServiceAnimations();
}

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    renderCarousel();
    renderServices();
});
