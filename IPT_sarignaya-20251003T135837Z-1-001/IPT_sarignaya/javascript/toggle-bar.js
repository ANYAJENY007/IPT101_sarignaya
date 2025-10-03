// Toggle Hamburger Menu
const menuToggle = document.getElementById('menu-toggle');
const navLinks = document.getElementById('nav-links');

// Initialize menu state
let isMenuOpen = false;

menuToggle.addEventListener('click', () => {
  isMenuOpen = !isMenuOpen;
  
  // Toggle menu visibility
  navLinks.classList.toggle('active');
  menuToggle.classList.toggle('active');
  
  // Prevent body scroll when menu is open on mobile
  if (isMenuOpen) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});

// Close menu when clicking on a link
const navLinksItems = navLinks.querySelectorAll('a');
navLinksItems.forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      navLinks.classList.remove('active');
      menuToggle.classList.remove('active');
      document.body.style.overflow = '';
      isMenuOpen = false;
    }
  });
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
  if (isMenuOpen && !menuToggle.contains(e.target) && !navLinks.contains(e.target)) {
    navLinks.classList.remove('active');
    menuToggle.classList.remove('active');
    document.body.style.overflow = '';
    isMenuOpen = false;
  }
});

// Handle window resize
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    navLinks.classList.remove('active');
    menuToggle.classList.remove('active');
    document.body.style.overflow = '';
    isMenuOpen = false;
  }
});