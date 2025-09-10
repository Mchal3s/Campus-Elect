<?php
session_start();
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];


$query = "
    SELECT v.vote_id, v.casted_at, 
           c.full_name AS candidate_name, 
           p.position_name, 
           e.election_name
    FROM votes v
    JOIN candidates c ON v.candidate_id = c.candidate_id
    JOIN positions p ON v.position_id = p.position_id
    JOIN elections e ON v.election_id = e.election_id
    WHERE v.voter_id = ?
    ORDER BY v.casted_at DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$votes = [];
while ($row = $result->fetch_assoc()) {
    $votes[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Voting History - eVOTE</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #1e3a8a, #2563eb, #3b82f6);
      color: white;
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    header {
      display: flex;
      justify-content: space-between;
      padding: 20px 40px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
    }
    .dashboard {
      flex: 1;
      display: flex;
      max-width: 1200px;
      margin: 40px auto;
      width: 90%;
      gap: 30px;
    }
    .sidebar {
      width: 250px;
      background: rgba(255,255,255,0.1);
      border-radius: 16px;
      padding: 25px;
    }
    .content {
      flex: 1;
      background: rgba(255,255,255,0.1);
      border-radius: 16px;
      padding: 30px;
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    th {
      color: #93c5fd;
      text-transform: uppercase;
      font-size: 0.85rem;
    }
    tr:hover {
      background: rgba(255,255,255,0.1);
    }
  </style>
</head>
<body>
<header>
  <div class="logo"><h1>eVOTE<span>.</span></h1></div>
  <a href="logout.php" style="color:white;">Logout</a>
</header>

<div class="dashboard">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="nav-item"><a href="dashboard.php" style="color:white;"><i class="fas fa-user-circle"></i> Profile</a></div>
    <div class="nav-item active"><i class="fas fa-vote-yea"></i> Voting History</div>
    <div class="nav-item"><a href="settings.php" style="color:white;"><i class="fas fa-cog"></i> Settings</a></div>
    <div class="nav-item"><a href="help.php" style="color:white;"><i class="fas fa-question-circle"></i> Help & Support</a></div>
  </div>

  
  <div class="content">
    <h2><i class="fas fa-history"></i> Your Voting History</h2>
    <table>
      <thead>
        <tr>
          <th>Election</th>
          <th>Position</th>
          <th>Candidate</th>
          <th>Date Casted</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($votes) > 0): ?>
          <?php foreach ($votes as $vote): ?>
            <tr>
              <td><?= htmlspecialchars($vote['election_name']); ?></td>
              <td><?= htmlspecialchars($vote['position_name']); ?></td>
              <td><?= htmlspecialchars($vote['candidate_name']); ?></td>
              <td><?= htmlspecialchars($vote['casted_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No votes recorded yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
