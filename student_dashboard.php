<?php
session_start();
require "db.php";

// 🔒 Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please login first");
    exit();
}

// ✅ Fetch logged-in student details
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT full_name, student_id, email, status, verified FROM users WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();
$conn->close();

// ✅ Fallback if user not found
if (!$student) {
    header("Location: login.php?error=Account not found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard - eVOTE</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
      color: #1f2937;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* Particle Background */
    #particles-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      animation: float 15s infinite linear;
    }

    @keyframes float {
      0% { transform: translateY(0) translateX(0); opacity: 0; }
      10% { opacity: 0.8; }
      90% { opacity: 0.8; }
      100% { transform: translateY(-100vh) translateX(20vw); opacity: 0; }
    }

    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .logo h1 { font-size: 1.8rem; font-weight: 700; color: white; }
    .logo span { color: #93c5fd; }

    .user-actions a.logout-btn {
      background: rgba(239, 68, 68, 0.9);
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .user-actions a.logout-btn:hover {
      background: rgba(220, 38, 38, 1);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Dashboard Layout */
    .dashboard {
      flex: 1;
      display: flex;
      max-width: 1200px;
      margin: 40px auto;
      width: 90%;
      gap: 30px;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .profile { text-align: center; margin-bottom: 25px; }
    .profile-img {
      width: 100px; height: 100px; border-radius: 50%;
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      margin: 0 auto 15px;
      display: flex; align-items: center; justify-content: center;
      color: white; font-size: 2.5rem;
    }
    .profile h2 { color: white; font-size: 1.3rem; margin-bottom: 5px; }
    .profile p { color: #e5e7eb; font-size: 0.9rem; }

    .nav-item {
      display: flex; align-items: center; gap: 12px;
      padding: 12px 15px; border-radius: 8px;
      color: #e5e7eb; margin-bottom: 8px; cursor: pointer;
      transition: all 0.3s;
    }
    .nav-item:hover, .nav-item.active { background: rgba(255, 255, 255, 0.15); color: white; }
    .nav-item i { width: 20px; text-align: center; }

    /* Content Area */
    .content { flex: 1; display: flex; flex-direction: column; gap: 30px; }

    .welcome-banner, .info-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.6s ease-out;
    }

    .welcome-banner h1 { color: white; font-size: 2rem; margin-bottom: 10px; }
    .welcome-banner p { color: #e5e7eb; line-height: 1.6; }

    .info-card h2 {
      color: white; font-size: 1.5rem; margin-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 15px; display: flex; align-items: center; gap: 10px;
    }

    .info-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;
    }
    .info-item {
      background: rgba(255, 255, 255, 0.05);
      padding: 20px; border-radius: 12px; transition: all 0.3s;
    }
    .info-item:hover { background: rgba(255, 255, 255, 0.1); transform: translateY(-3px); }
    .info-item h3 { color: #93c5fd; font-size: 0.9rem; margin-bottom: 8px; }
    .info-item p { color: white; font-size: 1.1rem; font-weight: 500; }

    /* Footer */
    footer { text-align: center; padding: 20px; color: #e5e7eb; font-size: 0.9rem; margin-top: auto; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <!-- Particle Background -->
  <div id="particles-container"></div>

  <!-- Header -->
  <header>
    <div class="logo"><h1>eVOTE<span>.</span></h1></div>
    <div class="user-actions">
      <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </header>

  <!-- Dashboard -->
  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="profile">
        <div class="profile-img"><i class="fas fa-user-graduate"></i></div>
        <h2 id="student-name"><?= htmlspecialchars($student['full_name']); ?></h2>
        <p id="student-id">ID: <?= htmlspecialchars($student['student_id']); ?></p>
      </div>
            <a href="profile.php" class="nav-item active">
            <i class="fas fa-user-circle"></i>
            <span>Profile</span>
            </a>

            <a href="vote_history.php" class="nav-item">
            <i class="fas fa-vote-yea"></i>
            <span>Voting History</span>
            </a>

            <a href="settings.php" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
            </a>

            <a href="help_support.php" class="nav-item">
            <i class="fas fa-question-circle"></i>
            <span>Help & Support</span>
            </a>
    </div>

    <!-- Main Content -->
    <div class="content">
      <div class="welcome-banner">
        <h1>Welcome back, <?= htmlspecialchars(explode(" ", $student['full_name'])[0]); ?>!</h1>
        <p>This is your student dashboard where you can view your information, participate in elections, and update your preferences. Your data is secure and private.</p>
      </div>

      <div class="info-card">
        <h2><i class="fas fa-info-circle"></i> Personal Information</h2>
        <div class="info-grid">
          <div class="info-item"><h3>Full Name</h3><p><?= htmlspecialchars($student['full_name']); ?></p></div>
          <div class="info-item"><h3>Student ID</h3><p><?= htmlspecialchars($student['student_id']); ?></p></div>
          <div class="info-item"><h3>Email Address</h3><p><?= $student['email'] ? htmlspecialchars($student['email']) : 'N/A'; ?></p>
</div>

          <div class="info-item"><h3>Account Status</h3><p><span style="color: <?= $student['verified'] ? '#4ade80' : '#f87171'; ?>;"><?= $student['verified'] ? 'Verified' : 'Unverified'; ?></span></p></div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2023 eVOTE Student Portal. All rights reserved.</p>
  </footer>

  <script>
    // ✅ Particle animation
    function createParticles() {
      const container = document.getElementById('particles-container');
      const particleCount = 25;

      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');

        const size = Math.random() * 5 + 2;
        const posX = Math.random() * 100;
        const delay = Math.random() * 15;
        const duration = 15 + Math.random() * 10;

        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}vw`;
        particle.style.animationDelay = `${delay}s`;
        particle.style.animationDuration = `${duration}s`;

        container.appendChild(particle);
      }
    }

    // ✅ Nav active highlight
    window.onload = function() {
      createParticles();
      const navItems = document.querySelectorAll('.nav-item');
      navItems.forEach(item => {
        item.addEventListener('click', function() {
          navItems.forEach(i => i.classList.remove('active'));
          this.classList.add('active');
        });
      });
    };
  </script>
</body>
</html>
