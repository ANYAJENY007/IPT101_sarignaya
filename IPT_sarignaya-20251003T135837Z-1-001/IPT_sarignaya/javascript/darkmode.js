// Dark Mode Toggle with localStorage persistence
const darkModeBtn = document.getElementById('dark-mode-btn');

// Check for saved dark mode preference
const savedDarkMode = localStorage.getItem('darkMode');
if (savedDarkMode === 'true') {
  document.body.classList.add('dark-mode');
  updateButtonText();
}

// Toggle dark mode
darkModeBtn.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  
  // Save preference to localStorage
  const isDarkMode = document.body.classList.contains('dark-mode');
  localStorage.setItem('darkMode', isDarkMode);
  
  updateButtonText();
});

// Update button text based on current mode
function updateButtonText() {
  if (document.body.classList.contains('dark-mode')) {
    darkModeBtn.textContent = '☀️ Light Mode';
    darkModeBtn.setAttribute('aria-label', 'Switch to light mode');
  } else {
    darkModeBtn.textContent = '🌙 Dark Mode';
    darkModeBtn.setAttribute('aria-label', 'Switch to dark mode');
  }
}

// Initialize button text
updateButtonText();

// Check for system preference on first load
if (savedDarkMode === null) {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  if (prefersDark) {
    document.body.classList.add('dark-mode');
    localStorage.setItem('darkMode', 'true');
    updateButtonText();
  }
}