<?php
session_start();
require "db.php";

// Protect page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ✅ Example queries to show summary
$totalVoters = $conn->query("SELECT COUNT(*) AS cnt FROM users WHERE role='student'")->fetch_assoc()['cnt'];
$totalVotes = $conn->query("SELECT COUNT(*) AS cnt FROM votes")->fetch_assoc()['cnt'];
$ongoingElections = $conn->query("SELECT COUNT(*) AS cnt FROM elections WHERE status='ongoing'")->fetch_assoc()['cnt'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - eVOTE</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
      margin: 0;
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    .logo h1 { margin: 0; font-size: 1.8rem; color: #fff; }
    .logout-btn {
      background: #ef4444;
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      color: white;
      font-weight: 600;
      cursor: pointer;
    }
    .dashboard {
      flex: 1;
      display: flex;
      max-width: 1300px;
      margin: 40px auto;
      width: 95%;
      gap: 25px;
    }
    .sidebar {
      width: 250px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 20px;
    }
    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      margin-bottom: 10px;
      border-radius: 8px;
      color: #e5e7eb;
      cursor: pointer;
      transition: 0.3s;
    }
    .nav-item:hover, .nav-item.active {
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
    }
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .card {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 25px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .summary-item {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
      text-align: center;
    }
    .summary-item h2 { margin: 10px 0; font-size: 2rem; }
    footer {
      text-align: center;
      padding: 15px;
      color: #ddd;
      font-size: 0.9rem;
      background: rgba(255, 255, 255, 0.05);
    }
  </style>
</head>
<body>
  <header>
    <div class="logo"><h1>eVOTE Admin</h1></div>
    <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </header>

  <div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="nav-item active"><i class="fas fa-home"></i> Dashboard</div>
      <a href="election_setup.php" class="nav-item"><i class="fas fa-cogs"></i> Election Setup</a>
      <a href="voter_management.php" class="nav-item"><i class="fas fa-users"></i> Voter Management</a>
      <a href="candidate_management.php" class="nav-item"><i class="fas fa-user-tie"></i> Candidate Management</a>
      <a href="biometric_setup.php" class="nav-item"><i class="fas fa-fingerprint"></i> Biometric Setup</a>
      <a href="reports.php" class="nav-item"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
      <a href="settings.php" class="nav-item"><i class="fas fa-cog"></i> Settings</a>
    </div>

    <!-- Content -->
    <div class="content">
      <div class="card">
        <h1>System Summary</h1>
        <div class="summary-grid">
          <div class="summary-item">
            <i class="fas fa-users fa-2x"></i>
            <h2><?= $totalVoters ?></h2>
            <p>Total Voters</p>
          </div>
          <div class="summary-item">
            <i class="fas fa-vote-yea fa-2x"></i>
            <h2><?= $totalVotes ?></h2>
            <p>Total Votes Cast</p>
          </div>
          <div class="summary-item">
            <i class="fas fa-bullhorn fa-2x"></i>
            <h2><?= $ongoingElections ?></h2>
            <p>Ongoing Elections</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>&copy; <?= date("Y") ?> eVOTE System. All Rights Reserved.</footer>
</body>
</html>
