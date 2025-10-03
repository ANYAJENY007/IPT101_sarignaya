<?php
session_start();
include '../includes/db.php';
$messages = include '../languages/en.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Fetch messages
$sql = "SELECT * FROM email ORDER BY sent_at DESC";
$result = $conn->query($sql);

// Count messages for statistics
$total_messages = $result->num_rows;
$today = date('Y-m-d');
$today_count = 0;
$result->data_seek(0); // Reset pointer
while ($row = $result->fetch_assoc()) {
    if (substr($row['created_at'], 0, 10) == $today) {
        $today_count++;
    }
}
$result->data_seek(0); // Reset pointer again for main display
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Messages</title>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ---------- GLOBAL RESET & VARIABLES ---------- */
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
      --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fb;
      color: var(--dark);
      display: flex;
      min-height: 100vh;
      line-height: 1.6;
    }

    /* ---------- SIDEBAR ---------- */
    .sidebar {
      width: 280px;
      background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      padding: 25px 0;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      transition: transform 0.3s ease-in-out;
      z-index: 100;
      box-shadow: var(--box-shadow);
      display: flex;
      flex-direction: column;
    }

    .sidebar-header {
      padding: 0 25px 25px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 20px;
    }

    .sidebar-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar-header h2 i {
      background: rgba(255, 255, 255, 0.2);
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .sidebar-nav {
      flex: 1;
      padding: 0 15px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: rgba(255, 255, 255, 0.85);
      padding: 14px 20px;
      margin-bottom: 8px;
      border-radius: 10px;
      transition: var(--transition);
      font-weight: 500;
    }

    .sidebar a:hover, .sidebar a.active {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      transform: translateX(5px);
    }

    .sidebar a i {
      width: 20px;
      text-align: center;
    }

    .sidebar-footer {
      padding: 20px 25px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: auto;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 15px 0;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .user-details h4 {
      font-size: 0.9rem;
      font-weight: 600;
    }

    .user-details p {
      font-size: 0.8rem;
      opacity: 0.8;
    }

    /* ---------- MAIN CONTENT ---------- */
    .main-content {
      flex: 1;
      padding: 30px;
      margin-left: 280px;
      transition: margin-left 0.3s ease-in-out;
      width: 100%;
    }

    .sidebar.collapsed + .main-content {
      margin-left: 0;
    }

    /* ---------- HEADER ---------- */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title h1 {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 5px;
    }

    .page-title p {
      color: var(--gray);
      font-size: 0.95rem;
    }

    .header-actions {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      padding: 12px 15px 12px 40px;
      border: 1px solid var(--gray-light);
      border-radius: 30px;
      width: 280px;
      font-size: 0.9rem;
      transition: var(--transition);
      background: white;
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }

    .search-box i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
    }

    .notification-btn {
      background: white;
      border: none;
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--dark);
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .notification-btn:hover {
      background: var(--primary);
      color: white;
    }

    .notification-badge {
      position: absolute;
      top: -2px;
      right: -2px;
      background: var(--danger);
      color: white;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* ---------- STATS CARDS ---------- */
    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--box-shadow);
      display: flex;
      align-items: center;
      transition: var(--transition);
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      font-size: 1.5rem;
    }

    .stat-icon.total {
      background: rgba(67, 97, 238, 0.15);
      color: var(--primary);
    }

    .stat-icon.today {
      background: rgba(114, 9, 183, 0.15);
      color: var(--secondary);
    }

    .stat-info h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .stat-info p {
      color: var(--gray);
      font-size: 0.9rem;
    }

    /* ---------- TABLE ---------- */
    .table-container {
      background: white;
      border-radius: var(--border-radius);
      padding: 25px;
      box-shadow: var(--box-shadow);
      overflow: hidden;
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .table-header h2 {
      font-size: 1.3rem;
      font-weight: 600;
    }

    .table-actions {
      display: flex;
      gap: 10px;
    }

    .filter-btn, .export-btn {
      padding: 10px 15px;
      border: 1px solid var(--gray-light);
      background: white;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .filter-btn:hover, .export-btn:hover {
      background: var(--gray-light);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 15px 12px;
      text-align: left;
      border-bottom: 1px solid var(--gray-light);
    }

    table th {
      font-weight: 600;
      color: var(--gray);
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    table tr:last-child td {
      border-bottom: none;
    }

    table tr:hover {
      background: rgba(67, 97, 238, 0.03);
    }

    .email-cell {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .email-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .email-info h4 {
      font-size: 0.95rem;
      font-weight: 500;
    }

    .email-info p {
      font-size: 0.8rem;
      color: var(--gray);
    }

    .message-preview {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      color: var(--gray);
    }

    .date-cell {
      color: var(--gray);
      font-size: 0.9rem;
    }

    .status-badge {
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 500;
    }

    .status-new {
      background: rgba(76, 201, 240, 0.15);
      color: var(--success);
    }

    .status-read {
      background: rgba(108, 117, 125, 0.15);
      color: var(--gray);
    }

    /* ---------- ACTION BUTTONS ---------- */
    .actions {
      display: flex;
      gap: 8px;
    }

    .action-btn {
      border: none;
      cursor: pointer;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      transition: var(--transition);
    }

    .view-btn {
      background: rgba(67, 97, 238, 0.1);
      color: var(--primary);
    }

    .view-btn:hover {
      background: var(--primary);
      color: white;
    }

    .delete-btn {
      background: rgba(247, 37, 133, 0.1);
      color: var(--danger);
    }

    .delete-btn:hover {
      background: var(--danger);
      color: white;
    }

    /* ---------- HAMBURGER BUTTON ---------- */
    .hamburger {
      display: none;
      position: fixed;
      top: 20px;
      left: 20px;
      background: var(--primary);
      color: white;
      border: none;
      width: 44px;
      height: 44px;
      border-radius: 10px;
      font-size: 20px;
      cursor: pointer;
      z-index: 101;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* ---------- MODAL ---------- */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background: white;
      border-radius: var(--border-radius);
      width: 90%;
      max-width: 600px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
      padding: 20px 25px;
      border-bottom: 1px solid var(--gray-light);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h3 {
      font-size: 1.3rem;
      font-weight: 600;
    }

    .close-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--gray);
      transition: var(--transition);
    }

    .close-btn:hover {
      color: var(--dark);
    }

    .modal-body {
      padding: 25px;
    }

    .message-detail {
      margin-bottom: 20px;
    }

    .message-detail label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
      color: var(--gray);
      font-size: 0.9rem;
    }

    .message-detail p {
      background: var(--gray-light);
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    /* ---------- RESPONSIVE DESIGN ---------- */
    @media (max-width: 1024px) {
      .sidebar {
        width: 240px;
      }
      
      .main-content {
        margin-left: 240px;
      }
      
      .search-box input {
        width: 220px;
      }
    }

    @media (max-width: 768px) {
      .hamburger {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .sidebar {
        transform: translateX(-100%);
        width: 280px;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .header-actions {
        width: 100%;
        justify-content: space-between;
      }

      .search-box {
        flex: 1;
      }

      .search-box input {
        width: 100%;
      }

      .stats-container {
        grid-template-columns: 1fr;
      }

      .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .table-actions {
        width: 100%;
        justify-content: space-between;
      }
    }

    @media (max-width: 480px) {
      .main-content {
        padding: 15px;
      }
      
      .stat-card {
        padding: 20px;
      }
      
      .table-container {
        padding: 15px;
      }
      
      table th, table td {
        padding: 12px 8px;
      }
    }
  </style>
</head>
<body>
  <!-- Hamburger Button -->
  <button class="hamburger" onclick="toggleSidebar()">☰</button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <h2><i class="fa-solid fa-sliders"></i> Admin Panel</h2>
    </div>
    
    <div class="sidebar-nav">
      <a href="dashboard.php" class="active"><i class="fa-solid fa-envelope"></i> Messages</a>
      <a href="../index.php"><i class="fa-solid fa-house"></i> Back to Website</a>
    </div>
    
    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">
          <i class="fa-solid fa-user"></i>
        </div>
        <div class="user-details">
          <h4>Admin User</h4>
          <p>Administrator</p>
        </div>
      </div>
      <a href="../admin/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <div class="page-title">
        <h1>Messages</h1>
        <p>Manage and view all contact form submissions</p>
      </div>
      <div class="header-actions">
        <div class="search-box">
          <i class="fa-solid fa-search"></i>
          <input type="text" placeholder="Search messages..." onkeyup="filterMessages()" id="searchInput">
        </div>
        <button class="notification-btn">
          <i class="fa-solid fa-bell"></i>
          <span class="notification-badge">3</span>
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
      <div class="stat-card">
        <div class="stat-icon total">
          <i class="fa-solid fa-envelope-open-text"></i>
        </div>
        <div class="stat-info">
          <h3><?= $total_messages ?></h3>
          <p>Total Messages</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon today">
          <i class="fa-solid fa-calendar-day"></i>
        </div>
        <div class="stat-info">
          <h3><?= $today_count ?></h3>
          <p>Today's Messages</p>
        </div>
      </div>
    </div>

    <!-- Messages Table -->
    <div class="table-container">
      <div class="table-header">
        <h2>Recent Messages</h2>
        <div class="table-actions">
          <button class="filter-btn">
            <i class="fa-solid fa-filter"></i> Filter
          </button>
          <button class="export-btn">
            <i class="fa-solid fa-download"></i> Export
          </button>
        </div>
      </div>
      
      <table id="messagesTable">
        <thead>
          <tr>
            <th>Sender</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): 
            $initial = strtoupper(substr($row['recipient_email'], 0, 1));
            $status = rand(0, 1) ? 'status-new' : 'status-read';
            $statusText = $status == 'status-new' ? 'New' : 'Read';
          ?>
            <tr>
              <td>
                <div class="email-cell">
                  <div class="email-avatar"><?= $initial ?></div>
                  <div class="email-info">
                    <h4><?= htmlspecialchars($row['recipient_email']); ?></h4>
                    <p><?= htmlspecialchars($row['recipient_email']); ?></p>
                  </div>
                </div>
              </td>
              <td><?= htmlspecialchars($row['subject']); ?></td>
              <td>
                <div class="message-preview"><?= htmlspecialchars($row['messages']); ?></div>
              </td>
              <td class="date-cell"><?= htmlspecialchars($row['created_at']); ?></td>
              <td>
                <div class="actions">
                  <button class="action-btn view-btn" onclick="openMessageModal(
                    '<?= htmlspecialchars($row['recipient_email']); ?>',
                    '<?= htmlspecialchars($row['subject']); ?>',
                    `<?= htmlspecialchars($row['messages']); ?>`,
                    '<?= htmlspecialchars($row['created_at']); ?>'
                  )">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <a class="action-btn delete-btn" 
                    href="../delete_message.php?id=<?= $row['id']; ?>"
                    onclick="return confirm('Are you sure you want to delete this message?');">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Message Detail Modal -->
  <div class="modal" id="messageModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Message Details</h3>
        <button class="close-btn" onclick="closeMessageModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="message-detail">
          <label>From:</label>
          <p id="modal-email"></p>
        </div>
        <div class="message-detail">
          <label>Subject:</label>
          <p id="modal-subject"></p>
        </div>
        <div class="message-detail">
          <label>Date:</label>
          <p id="modal-date"></p>
        </div>
        <div class="message-detail">
          <label>Message:</label>
          <p id="modal-message"></p>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle sidebar for mobile
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }

    // Open message modal with details
    function openMessageModal(email, subject, message, date) {
      document.getElementById('modal-email').textContent = email;
      document.getElementById('modal-subject').textContent = subject;
      document.getElementById('modal-message').textContent = message;
      document.getElementById('modal-date').textContent = date;
      document.getElementById('messageModal').style.display = 'flex';
    }

    // Close message modal
    function closeMessageModal() {
      document.getElementById('messageModal').style.display = 'none';
    }

    // Filter messages based on search input
    function filterMessages() {
      const input = document.getElementById('searchInput');
      const filter = input.value.toLowerCase();
      const table = document.getElementById('messagesTable');
      const tr = table.getElementsByTagName('tr');

      for (let i = 1; i < tr.length; i++) {
        const tdEmail = tr[i].getElementsByTagName('td')[0];
        const tdSubject = tr[i].getElementsByTagName('td')[1];
        const tdMessage = tr[i].getElementsByTagName('td')[2];
        
        if (tdEmail && tdSubject && tdMessage) {
          const emailText = tdEmail.textContent || tdEmail.innerText;
          const subjectText = tdSubject.textContent || tdSubject.innerText;
          const messageText = tdMessage.textContent || tdMessage.innerText;
          
          if (emailText.toLowerCase().indexOf(filter) > -1 || 
              subjectText.toLowerCase().indexOf(filter) > -1 || 
              messageText.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = '';
          } else {
            tr[i].style.display = 'none';
          }
        }
      }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('messageModal');
      if (event.target === modal) {
        closeMessageModal();
      }
    }
  </script>
</body>
</html>