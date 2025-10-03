// Enhanced Language Switcher with localStorage persistence
const languageSelector = document.getElementById('language-selector');

const translations = {
  en: {
    heroTitle: 'Welcome to My Portfolio',
    heroSubtitle: 'STUDENT',
    heroDescription: 'I am a passionate student developer with expertise in modern web technologies. I love creating user-friendly applications that solve real-world problems.',
    aboutTitle: 'About Me',
    aboutText: 'I am a passionate developer with expertise in modern web technologies. I love creating user-friendly applications that solve real-world problems.',
    aboutSkills: 'Skills & Technologies',
    portfolioTitle: 'My Projects',
    portfolioSubtitle: 'Some of my recent work',
    contactTitle: 'Contact Me',
    contactDescription: 'If want to get friend with me!',
    nameLabel: 'Name',
    emailLabel: 'Email',
    messageLabel: 'Message',
    sendButton: 'Send Message',
    charCount: 'characters',
    homeNav: 'Home',
    aboutNav: 'About',
    portfolioNav: 'Portfolio',
    contactNav: 'Contact'
  },
  fil: {
    heroTitle: 'Maligayang Pagdating sa Aking Portfolio',
    heroSubtitle: 'ESTYUDYANTE',
    heroDescription: 'Isa akong masigasig na developer ng mag-aaral na may kadalubhasaan sa mga modernong teknolohiya sa web. Gustung-gusto kong lumikha ng mga user-friendly na application na lumulutas ng mga problema sa totoong mundo.',
    aboutTitle: 'Tungkol Sa Akin',
    aboutText: 'Ako ay isang masigasig na developer na may expertise sa modern web technologies. Gusto kong gumawa ng user-friendly applications na nag-solve ng real-world problems.',
    aboutSkills: 'Skills & Technologies',
    portfolioTitle: 'Aking Mga Proyekto',
    portfolioSubtitle: 'Ilang sa aking mga recent work',
    contactTitle: 'Makipag-ugnayan',
    contactDescription: 'Kung gusto mo makipagkaibigan sa akin!',
    nameLabel: 'Pangalan',
    emailLabel: 'Email',
    messageLabel: 'Mensahe',
    sendButton: 'Ipadala ang Mensahe',
    charCount: 'mga character',
    homeNav: 'Home',
    aboutNav: 'Tungkol',
    portfolioNav: 'Proyekto',
    contactNav: 'Contact'
  }
};

// Check for saved language preference
const savedLanguage = localStorage.getItem('language') || 'en';
languageSelector.value = savedLanguage;

// Update all text content
function updateLanguage(lang) {
  const elements = {
    'hero-title': translations[lang].heroTitle,
    'hero-subtitle': translations[lang].heroSubtitle,
    'hero-description': translations[lang].heroDescription,
    'about-title': translations[lang].aboutTitle,
    'about-text': translations[lang].aboutText,
    'about-skills': translations[lang].aboutSkills,
    'portfolio-title': translations[lang].portfolioTitle,
    'portfolio-subtitle': translations[lang].portfolioSubtitle,
    'contact-title': translations[lang].contactTitle,
    'contact-description': translations[lang].contactDescription,
    'name-label': translations[lang].nameLabel,
    'email-label': translations[lang].emailLabel,
    'message-label': translations[lang].messageLabel,
    'send-button': translations[lang].sendButton,
    'char-count': translations[lang].charCount,
    'home-nav': translations[lang].homeNav,
    'about-nav': translations[lang].aboutNav,
    'portfolio-nav': translations[lang].portfolioNav,
    'contact-nav': translations[lang].contactNav
  };

  // Update all elements
  Object.keys(elements).forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.textContent = elements[id];
    }
  });

  // Update form labels
  const nameLabel = document.querySelector('label[for="name"]');
  const emailLabel = document.querySelector('label[for="email"]');
  const messageLabel = document.querySelector('label[for="message"]');
  const sendBtn = document.querySelector('#contact-form button[type="submit"]');

  if (nameLabel) nameLabel.textContent = translations[lang].nameLabel + ':';
  if (emailLabel) emailLabel.textContent = translations[lang].emailLabel + ':';
  if (messageLabel) messageLabel.textContent = translations[lang].messageLabel + ':';
  if (sendBtn) sendBtn.textContent = translations[lang].sendButton;

  // Update navigation links
  const navLinks = document.querySelectorAll('.nav-links a');
  if (navLinks.length >= 4) {
    navLinks[0].textContent = translations[lang].homeNav;
    navLinks[1].textContent = translations[lang].aboutNav;
    navLinks[2].textContent = translations[lang].portfolioNav;
    navLinks[3].textContent = translations[lang].contactNav;
  }
}

// Language change event
languageSelector.addEventListener('change', () => {
  const lang = languageSelector.value;
  localStorage.setItem('language', lang);
  updateLanguage(lang);
});

// Initialize language on page load
updateLanguage(savedLanguage);