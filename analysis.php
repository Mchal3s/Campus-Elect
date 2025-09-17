<?php
session_start();
require "db.php";

// ✅ Ensure only logged-in users can view
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Analytics Dashboard - eVOTE</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    header {
      background: #1e3a8a;
      color: white;
      padding: 15px;
    }
    .container {
      margin: 30px auto;
      width: 90%;
      max-width: 1000px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #1e3a8a;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #2563eb;
    }
  </style>
</head>
<body>
  <header>
    <h1>Voting Analytics</h1>
  </header>

  <div class="container">
    <canvas id="votesChart"></canvas>
    <button onclick="window.location.href='dashboard.php'">CONTINUE TO VOTING</button>
  </div>

  <script>
    async function fetchData() {
      const response = await fetch("fetch_votes.php");
      const data = await response.json();

      const ctx = document.getElementById("votesChart").getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: data.candidates,
          datasets: [{
            label: "Votes",
            data: data.votes,
            backgroundColor: "rgba(37, 99, 235, 0.7)",
            borderColor: "rgba(37, 99, 235, 1)",
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            title: { display: true, text: "Live Voting Results" }
          }
        }
      });
    }

    fetchData();
    setInterval(fetchData, 5000); // refresh every 5 sec
  </script>
</body>
</html>
