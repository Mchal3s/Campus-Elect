<?php
session_start();
require "db.php";

// 🔒 Only allow logged-in users
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Voting Analytics Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      margin: 0;
      padding: 0;
    }
    header {
      background: #2563eb;
      color: white;
      padding: 15px 30px;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      background: #1d4ed8;
      padding: 8px 15px;
      border-radius: 6px;
      transition: 0.3s;
    }
    header a:hover {
      background: #06dc74;
    }
    .container {
      padding: 30px;
    }
    .stats {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }
    .card {
      flex: 1;
      min-width: 220px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .card h2 {
      font-size: 2rem;
      margin: 10px 0;
    }
    canvas {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 40px;
    }
    .continue-btn {
      display: block;
      margin: 30px auto;
      background: #2563eb;
      color: white;
      border: none;
      padding: 14px 28px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      transition: 0.3s;
    }
    .continue-btn:hover {
      background: #06dc74;
    }
  </style>
</head>
<body>
<header>
  <div>📊 Voting Analytics Dashboard</div>
  <!-- 🔵 Dashboard button -->
  <a href="dashboard.php">Dashboard</a>
</header>

<div class="container">
  <!-- Stats Summary -->
  <div class="stats">
    <div class="card">
      <p>Total Votes Cast</p>
      <h2 id="totalVotes">0</h2>
    </div>
    <div class="card">
      <p>Active Elections</p>
      <h2 id="activeElections">0</h2>
    </div>
    <div class="card">
      <p>Unique Voters</p>
      <h2 id="uniqueVoters">0</h2>
    </div>
  </div>

  <!-- Charts -->
  <h3>Votes per Candidate</h3>
  <canvas id="candidateChart"></canvas>

  <h3>Votes per Position</h3>
  <canvas id="positionChart"></canvas>

  <!-- Continue Voting Button -->
  <button class="continue-btn" onclick="window.location.href='dashboard.php'">
    CONTINUE TO VOTING
  </button>
</div>

<script>
async function fetchAnalytics() {
  const response = await fetch("fetch_analytics.php");
  const data = await response.json();

  // Update stats
  document.getElementById("totalVotes").innerText = data.totalVotes;
  document.getElementById("activeElections").innerText = data.activeElections;
  document.getElementById("uniqueVoters").innerText = data.uniqueVoters;

  // Update candidate chart
  candidateChart.data.labels = data.candidates.map(c => c.name);
  candidateChart.data.datasets[0].data = data.candidates.map(c => c.votes);
  candidateChart.update();

  // Update position chart
  positionChart.data.labels = data.positions.map(p => p.name);
  positionChart.data.datasets[0].data = data.positions.map(p => p.votes);
  positionChart.update();
}

// Candidate Chart
const candidateChart = new Chart(document.getElementById('candidateChart'), {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: 'Votes',
      data: [],
      backgroundColor: 'rgba(37, 99, 235, 0.7)'
    }]
  },
});

// Position Chart
const positionChart = new Chart(document.getElementById('positionChart'), {
  type: 'pie',
  data: {
    labels: [],
    datasets: [{
      label: 'Votes',
      data: [],
      backgroundColor: [
        '#2563eb','#06dc74','#f43f5e','#facc15','#8b5cf6','#ec4899'
      ]
    }]
  },
});

// Auto refresh every 5s
setInterval(fetchAnalytics, 5000);
fetchAnalytics();
</script>
</body>
</html>
