<?php
include 'includes/db.php';
$messages = include 'languages/en.php';
require 'controllers/EmailController.php';

$emailController = new EmailController($conn, $messages);

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;
    $errors = $emailController->validate($_POST);

    if (empty($errors)) {
        if ($emailController->saveMessage($_POST)) {
            echo "<script>alert('{$messages['form_success']}');</script>";
            $old = []; // clear fields after success
        } else {
            echo "<script>alert('{$messages['form_error']}');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Portfolio</title>
    <!-- Global Styles -->
    <link rel="stylesheet" href="css_code/global.css" />
    <!-- Section Styles -->
    <link rel="stylesheet" href="css_code/navbar.css" />
    <link rel="stylesheet" href="css_code/hero.css" />
    <link rel="stylesheet" href="css_code/about.css" />
    <link rel="stylesheet" href="css_code/portfolio.css" />
    <link rel="stylesheet" href="css_code/contact.css" />
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <a href="#" class="logo">MyPortfolio</a>
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links" id="nav-links">
            <li><a href="#hero" id="home-nav">Home</a></li>
            <li><a href="#about" id="about-nav">About</a></li>
            <li><a href="#portfolio" id="portfolio-nav">Portfolio</a></li>
            <li><a href="#contact" id="contact-nav">Contact</a></li>
            <li>
                <button id="dark-mode-btn">🌙 Dark Mode</button>
            </li>
            <li>
                <select id="language-selector">
                    <option value="en">English</option>
                    <option value="fil">Filipino</option>
                </select>
            </li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-content">
            <h1 id="hero-title">Jeny's Portfolio</h1>

            <h2 id="hero-subtitle">STUDENT</h2>

            <p id="hero-description">Passionate about creating beautiful web experiences</p>
            <div class="hero-buttons">
                <a href="#portfolio" class="hero-btn primary">MY WORK!</a>
                <a href="#contact" class="hero-btn">CONTACT ME!</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="about-container">
            <div class="about-content">
                <h2 id="about-title">About Me</h2>
                <p id="about-text">I am a passionate student developer with expertise in modern web technologies. I love creating user-friendly applications that solve real-world problems.</p>
                
                <div class="about-skills">
                    <h3 id="about-skills">Skills & Technologies</h3>
                    <div class="skills-grid">
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">JavaScript</div>
                        </div>
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">GAMES</div>
                        </div>
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">CSS</div>
                        </div>
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">C++</div>
                        </div>
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">HTML</div>
                        </div>
                        <div class="skill-item">
                            <div class="skill-icon"></div>
                            <div class="skill-name">Mobile</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="about-image">
                <div class="profile-image">
                    <img src="css_img/IMG_20250625_232801_388.jpg" alt="Profile Photo" />
                </div>
            </div>
            
        </div>
        
        <div class="about-stats">
            <div class="stat-item">
                <div class="stat-number">1</div>
                <div class="stat-label">Projects Completed</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1 MONTH</div>
                <div class="stat-label">Experience</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">TBA</div>
                <div class="stat-label">Client Satisfaction</div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio-section">
        <h2 id="portfolio-title">My Projects</h2>
        <p id="portfolio-subtitle">Some of my recent work</p>
        
        <div class="projects-grid">
            <div class="project-card">
                <div class="project-image">E-Commerce App</div>
                <div class="project-content">
                    <h3 class="project-title">E-Commerce Platform</h3>
                    <p class="project-description">Basic.</p>
                    <div class="project-tech"> </div>
                    </div>
                    <div class="project-links">
                        <a href="#" class="project-link">Live Demo</a>
                        <a href="#" class="project-link secondary">GitHub</a>
                    </div>
                </div>
            </div>
            
            <div class="project-card">
                <div class="project-image">CALCULATOR</div>
                <div class="project-content">
                    <h3 class="project-title">CALCULATOR</h3>
                    <p class="project-description">CUTE CALCULATOR.</p>
                    <div class="project-tech">
                    
                    <div class="project-links">
                        <a href="#" class="project-link"></a>
                        <a href="#" class="project-link secondary"></a>
                    </div>
                </div>
            </div>
            
            <div class="project-card">
                <div class="project-image">notepad</div>
                <div class="project-content">
                    <h3 class="project-title">notepad</h3>
                    <p class="project-description"></p>
                    <div class="project-tech">
                        
                    </div>
                    <div class="project-links">
                        <a href="#" class="project-link"></a>
                        <a href="#" class="project-link secondary"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="contact-container">
            <div class="contact-info">
                <h2 id="contact-title">Contact Me</h2>
                <p id="contact-description">If want to get friend with me!</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div class="contact-text">
                            <h4>Email</h4>
                            <p>jenysarignaya.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div class="contact-text">
                            <h4>Phone</h4>
                            <p>09123214134</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div class="contact-text">
                            <h4>Location</h4>
                            <p>San Francisco, Agusan del Sur</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <form id="contact-form" method="POST" action="">
                <div class="form-group">
                    <label for="name" id="name-label">Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Your Name" 
               value="<?= htmlspecialchars($old['name'] ?? '') ?>">
        <div class="error"><?= $errors['name'] ?? '' ?></div>
                

                <div class="form-group">
                    <label for="subject" id="subject-label">Subject:</label>
                    <input type="text" id="subject" name="subject" required placeholder="Subject" 
               value="<?= htmlspecialchars($old['subject'] ?? '') ?>">
        <div class="error"><?= $errors['subject'] ?? '' ?></div>
                
                
                <div class="form-group">
                    <label for="email" id="email-label">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Email Address" 
               value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        <div class="error"><?= $errors['email'] ?? '' ?></div>
                
                
                <div class="form-group">
                    <label for="message" id="message-label">Message:</label>
                    <textarea id="message" name="message" maxlength="150" required placeholder="Message (max 150 characters)" maxlength="150">
                    <?= htmlspecialchars($old['message'] ?? '') ?></textarea>
        <div class="error"><?= $errors['message'] ?? '' ?></div>
                    <div id="char-count" class="char-count">0/500</div>
                </div>
                
                <button type="submit" class="submit-btn" id="send-button">Send Message</button>
                <a href="admin/dashboard.php" target="_blank">
            <button type="button" class="submit-db" id="check-db-button">Check DB</button>
        </a>
            </form>
        </div>
    </section>

    <!-- Scripts -->
    <script src="../javascript/toggle-bar.js"></script>
    <script src="../javascript/darkmode.js"></script>
    <script src="../javascript/langauge-section.js"></script>
    <script src="../javascript/char-limit.js"></script>
</body>
</html>