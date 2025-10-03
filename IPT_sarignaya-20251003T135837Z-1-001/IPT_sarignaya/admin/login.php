<?php
session_start();
include '../includes/db.php'; // FIXED PATH

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Fetch admin by username
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // Check if account exists
        if ($admin) {
            // Verify password using SHA-256
            if (hash('sha256', $password) === $admin['password']) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_id'] = $admin['id'];
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Both fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Secure Access</title>
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ---------- GLOBAL VARIABLES & RESET ---------- */
    :root {
      --primary: #4361ee;
      --primary-dark: #3a56d4;
      --secondary: #7209b7;
      --success: #4cc9f0;
      --danger: #f72585;
      --warning: #f8961e;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --gray-light: #e9ecef;
      --border-radius: 12px;
      --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      line-height: 1.6;
    }

    /* ---------- LOGIN CONTAINER ---------- */
    .login-container {
      display: flex;
      width: 100%;
      max-width: 900px;
      min-height: 550px;
      background: white;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--box-shadow);
    }

    /* ---------- LEFT SIDE (GRAPHICS) ---------- */
    .login-graphics {
      flex: 1;
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .graphics-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.05)"/></svg>');
      background-size: cover;
    }

    .graphics-content {
      position: relative;
      z-index: 2;
    }

    .graphics-content h1 {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .graphics-content p {
      font-size: 1rem;
      opacity: 0.9;
      margin-bottom: 30px;
    }

    .features-list {
      list-style: none;
    }

    .features-list li {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      font-size: 0.95rem;
    }

    .features-list i {
      margin-right: 12px;
      background: rgba(255, 255, 255, 0.2);
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
    }

    /* ---------- RIGHT SIDE (LOGIN FORM) ---------- */
    .login-form {
      flex: 1;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .form-header h2 {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .form-header p {
      color: var(--gray);
      font-size: 0.95rem;
    }

    .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 15px;
    }

    .logo-icon {
      width: 40px;
      height: 40px;
      background: var(--primary);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }

    /* ---------- FORM ELEMENTS ---------- */
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
      font-size: 0.9rem;
    }

    .input-with-icon {
      position: relative;
    }

    .input-with-icon i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1rem;
    }

    .form-control {
      width: 100%;
      padding: 14px 15px 14px 45px;
      border: 1px solid var(--gray-light);
      border-radius: 8px;
      font-size: 0.95rem;
      transition: var(--transition);
      background: white;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--gray);
      cursor: pointer;
      font-size: 1rem;
    }

    .password-toggle:hover {
      color: var(--dark);
    }

    /* ---------- REMEMBER ME & FORGOT PASSWORD ---------- */
    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      font-size: 0.9rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .remember-me input {
      width: 16px;
      height: 16px;
    }

    .forgot-password {
      color: var(--primary);
      text-decoration: none;
      transition: var(--transition);
    }

    .forgot-password:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }

    /* ---------- SUBMIT BUTTON ---------- */
    .submit-btn {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    /* ---------- ERROR MESSAGE ---------- */
    .error-message {
      background: rgba(247, 37, 133, 0.1);
      color: var(--danger);
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      text-align: center;
      font-size: 0.9rem;
      border-left: 4px solid var(--danger);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .error-message i {
      font-size: 1rem;
    }

    /* ---------- FOOTER ---------- */
    .login-footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid var(--gray-light);
      color: var(--gray);
      font-size: 0.85rem;
    }

    .security-notice {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 10px;
    }

    /* ---------- RESPONSIVE DESIGN ---------- */
    @media (max-width: 768px) {
      .login-container {
        flex-direction: column;
        max-width: 450px;
      }
      
      .login-graphics {
        padding: 30px;
        text-align: center;
      }
      
      .login-form {
        padding: 40px 30px;
      }
      
      .graphics-content h1 {
        font-size: 1.8rem;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
      }
      
      .login-graphics {
        padding: 25px 20px;
      }
      
      .login-form {
        padding: 30px 20px;
      }
      
      .form-options {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }
    }

    /* ---------- ANIMATIONS ---------- */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-form {
      animation: fadeIn 0.5s ease;
    }

    /* ---------- LOADING STATE ---------- */
    .submit-btn.loading {
      pointer-events: none;
      opacity: 0.8;
    }

    .submit-btn.loading i {
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <!-- Left Side: Graphics & Info -->
    <div class="login-graphics">
      <div class="graphics-overlay"></div>
      <div class="graphics-content">
        <h1>Admin Portal</h1>
        <p>Secure access to your administration dashboard</p>
        
        <ul class="features-list">
          <li><i class="fas fa-shield-alt"></i> Enhanced security with SHA-256 encryption</li>
          <li><i class="fas fa-tachometer-alt"></i> Full dashboard with analytics</li>
          <li><i class="fas fa-envelope"></i> Manage all contact messages</li>
          <li><i class="fas fa-mobile-alt"></i> Fully responsive design</li>
        </ul>
      </div>
    </div>
    
    <!-- Right Side: Login Form -->
    <div class="login-form">
      <div class="form-header">
        <div class="logo">
          <div class="logo-icon">
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <h2>Welcome Back</h2>
        <p>Please sign in to your account</p>
      </div>
      
      <?php if (!empty($error)): ?>
        <div class="error-message">
          <i class="fas fa-exclamation-circle"></i>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
      <?php endif; ?>
      
      <form method="POST" action="" id="loginForm">
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-with-icon">
            <i class="fas fa-user"></i>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
          </div>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <i class="fas fa-key"></i>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            <button type="button" class="password-toggle" id="passwordToggle">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        
        <div class="form-options">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="#" class="forgot-password">Forgot password?</a>
        </div>
        
        <button type="submit" class="submit-btn" id="submitBtn">
          <i class="fas fa-sign-in-alt"></i>
          <span>Sign In</span>
        </button>
      </form>
      
      <div class="login-footer">
        <p>Secure Admin Access &copy; <?= date('Y') ?></p>
        <div class="security-notice">
          <i class="fas fa-lock"></i>
          <span>Your credentials are protected</span>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');
    
    passwordToggle.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Toggle eye icon
      const icon = this.querySelector('i');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
    });
    
    // Form submission loading state
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    
    loginForm.addEventListener('submit', function() {
      submitBtn.classList.add('loading');
      submitBtn.innerHTML = '<i class="fas fa-spinner"></i><span>Signing In...</span>';
    });
    
    // Auto-focus username field
    document.getElementById('username').focus();
  </script>
</body>
</html>