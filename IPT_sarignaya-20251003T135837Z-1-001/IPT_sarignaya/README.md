# Personal Portfolio Website

A modern, responsive personal portfolio website built with HTML, CSS, and JavaScript using a modular file structure.

## Features

### Core Functionalities
- **Dark Mode Toggle** - Switch between light and dark themes with localStorage persistence
- **Language Selector** - Support for English and Filipino languages
- **Form Persistence** - Contact form retains values after page reload using sessionStorage
- **Character Limit** - Real-time character counting with visual feedback for message input
- **Responsive Design** - Mobile-first approach with hamburger menu for mobile devices

### Design Features
- **Modern UI/UX** - Clean, professional design with smooth animations
- **Modular CSS** - Separate CSS files for each section and component
- **Modular JavaScript** - Separate JS files for each functionality
- **Accessibility** - ARIA labels and keyboard navigation support
- **Performance** - Optimized animations and efficient code structure

## File Structure

```
IPT_sarignaya/
├── css code/
│   ├── myprofile.html          # Main HTML file
│   ├── global.css              # Global styles, variables, resets
│   ├── navbar.css              # Navigation bar styling
│   ├── hero.css                # Hero section styling
│   ├── about.css               # About section styling
│   ├── portfolio.css           # Portfolio section styling
│   └── contact.css             # Contact section styling
├── javascript/
│   ├── toggle-bar.js           # Hamburger menu functionality
│   ├── darkmode.js             # Dark mode toggle with persistence
│   ├── langauge-section.js     # Language switching functionality
│   ├── form-persistence.js     # Form data persistence
│   └── char-limit.js           # Character limit with visual feedback
└── README.md                   # Project documentation
```

##  Getting Started

1. **Open the website**: Open `css code/myprofile.html` in your web browser
2. **Test the features**:
   - Click the hamburger menu on mobile devices
   - Toggle dark mode using the button in the navigation
   - Switch languages using the dropdown selector
   - Fill out the contact form and test character limits
   - Reload the page to see form persistence in action

## CSS Architecture

### Global Styles (`global.css`)
- CSS custom properties (variables) for consistent theming
- Reset and base styles
- Typography and utility classes
- Dark mode variable overrides

### Section-Specific Styles
Each section has its own CSS file for maintainability:
- **navbar.css** - Fixed navigation with responsive hamburger menu
- **hero.css** - Full-screen hero section with animations
- **about.css** - Two-column layout with skills grid and statistics
- **portfolio.css** - Project cards with hover effects
- **contact.css** - Contact form with validation styling

## JavaScript Features

### 1. Dark Mode Toggle (`darkmode.js`)
- Toggle between light and dark themes
- localStorage persistence
- System preference detection
- Visual feedback with emoji icons

### 2. Language Selector (`langauge-section.js`)
- Support for English and Filipino
- localStorage persistence
- Dynamic content updates
- Navigation and form label translation

### 3. Form Persistence (`form-persistence.js`)
- sessionStorage for form data retention
- Debounced input saving
- Form validation
- Success/error message display
- Auto-clear on successful submission

### 4. Character Limit (`char-limit.js`)
- Real-time character counting
- Visual feedback with color changes
- Input prevention at limit
- Paste event handling
- Shake animation for limit exceeded

### 5. Hamburger Menu (`toggle-bar.js`)
- Responsive mobile navigation
- Click outside to close
- Smooth animations
- Body scroll prevention when open

## Key Features Explained

### Dark Mode Implementation
```javascript
// Check for saved preference
const savedDarkMode = localStorage.getItem('darkMode');
if (savedDarkMode === 'true') {
  document.body.classList.add('dark-mode');
}
```

### Language Switching
```javascript
// Update all text content dynamically
function updateLanguage(lang) {
  Object.keys(elements).forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.textContent = elements[id];
    }
  });
}
```

### Form Persistence
```javascript
// Save with debouncing
input.addEventListener('input', () => {
  clearTimeout(timeout);
  timeout = setTimeout(() => {
    sessionStorage.setItem(`form_${field}`, input.value);
  }, 300);
});
```

### Character Limit with Visual Feedback
```javascript
// Visual feedback based on character count
if (length >= errorThreshold) {
  charCount.classList.add('error');
  messageBox.classList.add('error');
}
```

## Design System

### Color Palette
- **Primary**: #007bff (Blue)
- **Secondary**: #6c757d (Gray)
- **Success**: #28a745 (Green)
- **Warning**: #ffc107 (Yellow)
- **Error**: #dc3545 (Red)

### Typography
- **Font Family**: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- **Headings**: 600 weight with 1.2 line-height
- **Body**: 1.6 line-height for readability

### Spacing
- **Container**: max-width 1200px with 20px padding
- **Sections**: 80px padding (60px on mobile)
- **Components**: Consistent 1rem, 1.5rem, 2rem spacing

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🔧 Customization

### Adding New Languages
1. Add new language option to the select element
2. Add translations to the `translations` object in `langauge-section.js`
3. Update the `updateLanguage` function to handle new elements

### Adding New Sections
1. Create new CSS file (e.g., `services.css`)
2. Add HTML structure to `myprofile.html`
3. Link the CSS file in the HTML head
4. Add navigation link if needed

### Modifying Dark Mode Colors
1. Update CSS custom properties in `global.css`
2. Add dark mode overrides for new elements
3. Test both light and dark modes

## Performance Optimizations

- **CSS**: Modular structure for better caching
- **JavaScript**: Debounced input events
- **Images**: Optimized and compressed
- **Animations**: Hardware-accelerated transforms
- **Storage**: Efficient localStorage/sessionStorage usage

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test all functionalities
5. Submit a pull request
