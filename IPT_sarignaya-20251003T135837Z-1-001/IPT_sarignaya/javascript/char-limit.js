// Enhanced Character Limit with visual feedback
const messageBox = document.getElementById('message');
const charCount = document.getElementById('char-count');
const maxChars = 150;

// Warning and error thresholds
const warningThreshold = Math.floor(maxChars * 0.8); // 80%
const errorThreshold = Math.floor(maxChars * 0.95); // 95%

function updateCharCount() {
  const length = messageBox.value.length;
  const remaining = maxChars - length;
  
  // Update count display
  charCount.textContent = `${length}/${maxChars}`;
  
  // Remove all classes first
  charCount.classList.remove('warning', 'error');
  
  // Add appropriate class based on length
  if (length >= errorThreshold) {
    charCount.classList.add('error');
  } else if (length >= warningThreshold) {
    charCount.classList.add('warning');
  }
  
  // Update textarea styling
  messageBox.classList.remove('warning', 'error');
  if (length >= errorThreshold) {
    messageBox.classList.add('error');
  } else if (length >= warningThreshold) {
    messageBox.classList.add('warning');
  }
  
  // Disable/enable submit button based on content
  const submitBtn = document.querySelector('#contact-form button[type="submit"]');
  if (submitBtn) {
    submitBtn.disabled = length === 0;
  }
}

// Input event handler
messageBox.addEventListener('input', () => {
  const length = messageBox.value.length;
  
  // Prevent typing beyond limit
  if (length > maxChars) {
    messageBox.value = messageBox.value.substring(0, maxChars);
  }
  
  updateCharCount();
});

// Keydown event to prevent typing at limit
messageBox.addEventListener('keydown', (e) => {
  const length = messageBox.value.length;
  
  // Allow backspace, delete, arrow keys, etc.
  const allowedKeys = ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Tab'];
  
  if (length >= maxChars && !allowedKeys.includes(e.key) && !e.ctrlKey && !e.metaKey) {
    e.preventDefault();
    
    // Show a brief visual feedback
    messageBox.classList.add('shake');
    setTimeout(() => {
      messageBox.classList.remove('shake');
    }, 300);
  }
});

// Paste event handler
messageBox.addEventListener('paste', (e) => {
  setTimeout(() => {
    const length = messageBox.value.length;
    if (length > maxChars) {
      messageBox.value = messageBox.value.substring(0, maxChars);
      updateCharCount();
    }
  }, 0);
});

// Initialize count on page load
window.addEventListener('load', () => {
  updateCharCount();
});

// Add CSS for visual feedback
const style = document.createElement('style');
style.textContent = `
  .shake {
    animation: shake 0.3s ease-in-out;
  }
  
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
  }
  
  .warning {
    border-color: #ff9800 !important;
    box-shadow: 0 0 0 2px rgba(255, 152, 0, 0.25) !important;
  }
  
  .error {
    border-color: #f44336 !important;
    box-shadow: 0 0 0 2px rgba(244, 67, 54, 0.25) !important;
  }
`;
document.head.appendChild(style);