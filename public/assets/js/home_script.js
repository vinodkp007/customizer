const pages = {
    home: {
        type: 'home',
        carousel: [
{ 
image: 'https://placehold.co/1200x600',
title: 'Welcome to Our Digital Solutions',
description: 'Transforming Ideas into Reality'
},
{ 
image: 'https://placehold.co/1200x600',
title: 'Innovative Technology',
description: 'Building the Future Today'
},
{ 
image: 'https://placehold.co/1200x600',
title: 'Expert Solutions',
description: 'Delivering Excellence in Every Project'
},
{ 
image: 'https://placehold.co/1200x600',
title: 'Creative Design',
description: 'Where Vision Meets Innovation'
},
{ 
image: 'https://placehold.co/1200x600',
title: 'Global Reach',
description: 'Connecting Business Worldwide'
}
],
services: [
{
title: 'Web Development',
description: 'Create stunning, responsive websites tailored to your needs. Our expert team combines cutting-edge technology with elegant design to deliver exceptional web solutions.',
image: 'https://placehold.co/600x400'
},
{
title: 'Mobile Applications',
description: 'Transform your ideas into powerful mobile applications. We develop intuitive, feature-rich apps that provide seamless user experiences across all platforms.',
image: 'https://placehold.co/600x400'
},
{
title: 'Cloud Solutions',
description: 'Leverage the power of cloud computing for your business. Our cloud solutions help you scale efficiently while maintaining security and performance.',
image: 'https://placehold.co/600x400'
}
]
    },
    about: {
        type: 'simple',
        title: 'About Us',
        content: 'We are a forward-thinking company...',
        image: '/api/placeholder/800/400'
    }
};

// DOM Elements
const mainContent = document.getElementById('mainContent');
const adminToggle = document.getElementById('adminToggle');
const adminPanel = document.getElementById('adminPanel');
const navForm = document.getElementById('navForm');
const navLinks = document.getElementById('navLinks');

// Carousel state
let currentSlide = 0;
let carouselInterval;

// Event Listeners
adminToggle.addEventListener('click', () => {
    adminPanel.classList.toggle('active');
});

navForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const linkText = document.getElementById('linkText').value;
    const pageType = document.getElementById('pageType').value;
    
    // Add new nav link
    const link = document.createElement('li');
    link.innerHTML = `<a href="#" data-page="${linkText.toLowerCase()}">${linkText}</a>`;
    navLinks.appendChild(link);

    // Add new page to pages object
    pages[linkText.toLowerCase()] = {
        type: pageType,
        title: linkText,
        content: pageType === 'simple' ? 'New page content...' : '',
        items: pageType === 'container' ? [] : null,
        image: '/api/placeholder/800/400'
    };

    navForm.reset();
});

// Navigation handling
document.addEventListener('click', (e) => {
    if (e.target.matches('[data-page]')) {
        e.preventDefault();
        const pageId = e.target.dataset.page;
        renderPage(pageId);
    }
});

// Carousel functionality
function startCarousel() {
    clearInterval(carouselInterval);
    carouselInterval = setInterval(() => {
        currentSlide = (currentSlide + 1) % 5;
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

// Intersection Observer for animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

// Page rendering functions
function renderPage(pageId) {
    const page = pages[pageId];
    if (!page) return;

    switch (page.type) {
        case 'home':
            renderHomePage(page);
            break;
        case 'simple':
            renderSimplePage(page);
            break;
        case 'container':
            renderContainerPage(page);
            break;
    }
}

function renderHomePage(page) {
    mainContent.innerHTML = `
        <div class="carousel-container">
            <div class="carousel">
                ${page.carousel.map(slide => `
                    <div class="carousel-slide">
                        <img src="${slide.image}" alt="${slide.title}">
                        <div class="placeholder-text">
                            <h2>${slide.title}</h2>
                            <p>${slide.description}</p>
                        </div>
                    </div>
                `).join('')}
            </div>
            <div class="carousel-dots">
                ${page.carousel.map((_, index) => `
                    <div class="dot ${index === 0 ? 'active' : ''}" data-index="${index}"></div>
                `).join('')}
            </div>
        </div>
        <section class="services-section">
            <h2 class="section-title">Our Services</h2>
            ${page.services.map(service => `
                <div class="service-item">
                    <div class="service-content">
                        <h3 class="service-title">${service.title}</h3>
                        <p class="service-description">${service.description}</p>
                    </div>
                    <div class="service-image">
                        <img src="${service.image}" alt="${service.title}">
                    </div>
                </div>
            `).join('')}
        </section>
    `;

    startCarousel();

    // Add dot click handlers
    document.querySelectorAll('.dot').forEach(dot => {
        dot.addEventListener('click', () => {
            currentSlide = parseInt(dot.dataset.index);
            updateCarousel();
            startCarousel();
        });
    });

    // Add intersection observer to service items
    document.querySelectorAll('.service-item').forEach(item => {
        observer.observe(item);
    });
}

function renderSimplePage(page) {
    mainContent.innerHTML = `
        <div class="simple-page">
            <img src="${page.image}" alt="${page.title}" class="hero-image">
            <h1>${page.title}</h1>
            <div class="content">
                ${page.content}
            </div>
        </div>
    `;
}

function renderContainerPage(page) {
    mainContent.innerHTML = `
        <div class="container-page">
            <h1>${page.title}</h1>
            <div class="card-grid">
                ${page.items ? page.items.map(item => `
                    <div class="card">
                        <img src="${item.image}" alt="${item.title}">
                        <div class="card-content">
                            <h2 class="card-title">${item.title}</h2>
                            <p>${item.excerpt}</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                `).join('') : ''}
            </div>
        </div>
    `;
}

// Initial page load
renderPage('home');