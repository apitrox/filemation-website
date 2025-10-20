// Loading Spinner
window.addEventListener('load', function() {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) {
        setTimeout(() => {
            spinner.classList.add('hidden');
            setTimeout(() => {
                spinner.style.display = 'none';
            }, 300);
        }, 500);
    }
});

// Back to Top Button
const backToTopButton = document.getElementById('back-to-top');

if (backToTopButton) {
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Header Scroll Effect
const header = document.getElementById('main-header');
if (header) {
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

// Initialize AOS (Animate on Scroll) if available
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
}

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href !== '') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Form Validation Enhancement
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

// Update current year in footer
const yearElement = document.getElementById('current-year');
if (yearElement) {
    yearElement.textContent = new Date().getFullYear();
}

// Navbar Mobile Toggle (if needed)
const navbarToggler = document.querySelector('.navbar-toggler');
const navbarCollapse = document.querySelector('.navbar-collapse');

if (navbarToggler && navbarCollapse) {
    navbarToggler.addEventListener('click', function() {
        navbarCollapse.classList.toggle('show');
    });
}

// Add animation classes on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all cards and feature elements
document.querySelectorAll('.card, .feature-item').forEach(element => {
    observer.observe(element);
});

// Pricing Card Hover Effects
const pricingCards = document.querySelectorAll('.pricing-card');
pricingCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Console welcome message
console.log('%cFilemation', 'color: #0066CC; font-size: 24px; font-weight: bold;');
console.log('%cElectronic Document Management', 'color: #64748b; font-size: 14px;');
