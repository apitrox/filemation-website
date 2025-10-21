// Filemation - Main JavaScript File
// Pure Vanilla JavaScript - No jQuery

document.addEventListener('DOMContentLoaded', function() {
  
  // Header fixed and Back to top button
  window.addEventListener('scroll', function() {
    const backToTop = document.querySelector('.back-to-top');
    const header = document.getElementById('header');
    
    if (window.pageYOffset > 100) {
      if (backToTop) {
        backToTop.classList.add('show');
      }
      if (header) {
        header.classList.add('scrolled');
      }
    } else {
      if (backToTop) {
        backToTop.classList.remove('show');
      }
      if (header) {
        header.classList.remove('scrolled');
      }
    }
  });
  
  // Back to top button click
  const backToTop = document.querySelector('.back-to-top');
  if (backToTop) {
    backToTop.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
  
  // Mobile Menu Toggle (AFCA-style)
  const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  if (mobileMenuToggle && mobileMenu) {
    mobileMenuToggle.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
      mobileMenu.classList.toggle('show');
      
      // Update hamburger icon
      const svg = this.querySelector('svg');
      const path = svg.querySelector('path');
      
      if (mobileMenu.classList.contains('show')) {
        // Change to X icon
        path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
      } else {
        // Change back to hamburger
        path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
      }
    });

    // Close mobile menu when clicking on a link
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(function(link) {
      link.addEventListener('click', function() {
        mobileMenu.classList.add('hidden');
        mobileMenu.classList.remove('show');
        
        // Reset hamburger icon
        const path = mobileMenuToggle.querySelector('svg path');
        path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
      });
    });
  }
  
  // Active Nav Link Highlighting
  function setActiveNavLink() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(function(link) {
      const linkPage = link.getAttribute('href').split('/').pop();
      if (linkPage === currentPage) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  }

  setActiveNavLink();
  
  // Smooth scroll on page hash links
  document.querySelectorAll('a[href*="#"]:not([href="#"])').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
          location.hostname === this.hostname) {
        let target = document.querySelector(this.hash);
        if (target) {
          e.preventDefault();
          let topSpace = 0;
          const header = document.getElementById('header');
          if (header) {
            topSpace = header.offsetHeight;
            if (!header.classList.contains('header-fixed')) {
              topSpace = topSpace - 20;
            }
          }
          
          window.scrollTo({
            top: target.offsetTop - topSpace,
            behavior: 'smooth'
          });
          
          // Update active menu item
          const navMenu = document.querySelector('.nav-menu');
          if (navMenu && this.closest('.nav-menu')) {
            const activeItem = navMenu.querySelector('.menu-active');
            if (activeItem) {
              activeItem.classList.remove('menu-active');
            }
            this.closest('li').classList.add('menu-active');
          }
          
          // Close mobile nav
          if (document.body.classList.contains('mobile-nav-active')) {
            document.body.classList.remove('mobile-nav-active');
            const toggleIcon = document.querySelector('#mobile-nav-toggle i');
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
            document.getElementById('mobile-body-overly').style.display = 'none';
          }
        }
      }
    });
  });
  
  // Animate on scroll (Tailwind animations)
  const animateElements = document.querySelectorAll('[data-animate]');
  if (animateElements.length > 0) {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const animationType = entry.target.getAttribute('data-animate');
          entry.target.classList.add('animate-' + animationType);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);
    
    animateElements.forEach(function(element) {
      observer.observe(element);
    });
  }
  
});

// Pricing page annual/monthly toggle
if (document.querySelector('.annual input') || document.querySelector('.monthly input')) {
  document.querySelectorAll('.annual input, .monthly input').forEach(function(input) {
    input.addEventListener('change', function() {
      document.querySelectorAll('.m, .y').forEach(function(el) {
        el.style.display = el.style.display === 'none' ? 'inline' : 'none';
      });
    });
  });
}

// Login form handler (non-functional - appears to work)
const loginForm = document.getElementById('Send_Form');
if (loginForm && window.location.pathname.includes('login')) {
  loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const username = document.getElementById('User_Name').value;
    const password = document.getElementById('Password').value;
    
    if (!username || !password) {
      const errorWrapper = document.getElementById('Message_Error_Wrapper');
      const messageContainer = document.getElementById('Message_Container');
      if (errorWrapper && messageContainer) {
        errorWrapper.style.display = 'block';
        messageContainer.style.display = 'block';
      }
    } else {
      // Simulate loading
      const submitButton = document.getElementById('send');
      if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Logging in...';
        
        setTimeout(function() {
          const errorWrapper = document.getElementById('Message_Error_Wrapper');
          const messageContainer = document.getElementById('Message_Container');
          if (errorWrapper && messageContainer) {
            errorWrapper.style.display = 'block';
            messageContainer.style.display = 'block';
          }
          submitButton.disabled = false;
          submitButton.textContent = 'Log In';
        }, 1000);
      }
    }
  });
}

// Register form handler (non-functional - appears to work)
const registerForm = document.getElementById('Send_Form');
if (registerForm && window.location.pathname.includes('register')) {
  registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitButton = document.getElementById('Register');
    
    if (submitButton) {
      submitButton.disabled = true;
      submitButton.textContent = 'Registering...';
      
      setTimeout(function() {
        const errorWrapper = document.getElementById('Message_Error_Wrapper');
        const messageContainer = document.getElementById('Message_Container');
        if (errorWrapper && messageContainer) {
          errorWrapper.style.display = 'block';
          messageContainer.style.display = 'block';
        }
        submitButton.disabled = false;
        submitButton.textContent = 'Register';
      }, 1000);
    }
  });
}

// Contact form handler (non-functional - appears to work)
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const submitButton = this.querySelector('button[type="submit"]');
    
    if (submitButton) {
      submitButton.disabled = true;
      submitButton.textContent = 'Sending...';
      
      setTimeout(function() {
        const successMessage = document.getElementById('sendmessage');
        if (successMessage) {
          successMessage.style.display = 'block';
          successMessage.textContent = 'Your message has been sent. Thank you!';
        }
        submitButton.disabled = false;
        submitButton.textContent = 'Send Message';
        contactForm.reset();
        
        // Hide success message after 5 seconds
        setTimeout(function() {
          if (successMessage) {
            successMessage.style.display = 'none';
          }
        }, 5000);
      }, 1000);
    }
  });
}
