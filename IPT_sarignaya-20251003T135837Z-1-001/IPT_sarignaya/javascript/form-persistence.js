// Enhanced Form Persistence with sessionStorage and form validation
const form = document.getElementById('contact-form');
const formFields = ['name', 'email', 'message'];

// Load saved data on page load
window.addEventListener('load', () => {
  formFields.forEach(field => {
    const value = sessionStorage.getItem(`form_${field}`);
    if (value) {
      const input = document.getElementById(field);
      if (input) {
        input.value = value;
        // Trigger input event to update character count if it's the message field
        if (field === 'message') {
          input.dispatchEvent(new Event('input'));
        }
      }
    }
  });
});

// Save data on input with debouncing
formFields.forEach(field => {
  const input = document.getElementById(field);
  if (input) {
    let timeout;
    input.addEventListener('input', () => {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        sessionStorage.setItem(`form_${field}`, input.value);
      }, 300); // Save after 300ms of no typing
    });
  }
});

// Clear form data on successful submission
form.addEventListener('submit', (e) => {
  e.preventDefault();
  
  // Basic form validation
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message').value.trim();
  
  if (!name || !email || !message) {
    showFormMessage('Please fill in all fields.', 'error');
    return;
  }
  
  if (!isValidEmail(email)) {
    showFormMessage('Please enter a valid email address.', 'error');
    return;
  }
  
  // Simulate form submission
  const submitBtn = form.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.textContent = 'Sending...';
  submitBtn.disabled = true;
  
  setTimeout(() => {
    // Clear form data
    formFields.forEach(field => {
      sessionStorage.removeItem(`form_${field}`);
      document.getElementById(field).value = '';
    });
    
    // Reset character count
    const charCount = document.getElementById('char-count');
    if (charCount) {
      charCount.textContent = '0/150';
    }
    
    showFormMessage('Message sent successfully!', 'success');
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  }, 2000);
});

// Email validation function
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// Show form message
function showFormMessage(message, type) {
  // Remove existing messages
  const existingMessage = form.querySelector('.form-message');
  if (existingMessage) {
    existingMessage.remove();
  }
  
  // Create new message
  const messageDiv = document.createElement('div');
  messageDiv.className = `form-message ${type}`;
  messageDiv.textContent = message;
  
  // Insert at the beginning of the form
  form.insertBefore(messageDiv, form.firstChild);
  
  // Auto-remove after 5 seconds
  setTimeout(() => {
    if (messageDiv.parentNode) {
      messageDiv.remove();
    }
  }, 5000);
}

// Clear form data when user navigates away
window.addEventListener('beforeunload', () => {
  // Optionally clear data when leaving the page
  // Uncomment the next line if you want to clear data on page unload
  // formFields.forEach(field => sessionStorage.removeItem(`form_${field}`));
});