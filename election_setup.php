<?php
session_start();
require "db.php";

// ✅ Handle new election creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_election'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];
    $auth_method = $_POST['authentication_method'];
    $created_by = $_SESSION['user_id'] ?? 1; // Admin who creates election

    $stmt = $conn->prepare("INSERT INTO elections (title, description, start_datetime, end_datetime, authentication_method, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $start_datetime, $end_datetime, $auth_method, $created_by);

    if ($stmt->execute()) {
        $success = "Election created successfully!";
    } else {
        $error = "Error creating election.";
    }
}

// ✅ Fetch elections
$result = $conn->query("SELECT * FROM elections ORDER BY created_at DESC");
$elections = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Election Setup - eVote</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f3f4f6; margin:0; padding:20px; }
    h1 { color:#1e3a8a; }
    .container { max-width: 900px; margin:auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
    .form-group { margin-bottom:15px; }
    label { font-weight:600; }
    input, textarea, select { width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:6px; }
    button { padding:10px 20px; border:none; border-radius:6px; background:#2563eb; color:#fff; cursor:pointer; }
    button:hover { background:#1d4ed8; }
    .success { color:green; }
    .error { color:red; }
    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left; }
    th { background:#2563eb; color:#fff; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Election Setup</h1>

    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <!-- Create New Election -->
    <form method="POST">
      <div class="form-group">
        <label>Election Title</label>
        <input type="text" name="title" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" required></textarea>
      </div>
      <div class="form-group">
        <label>Start Date & Time</label>
        <input type="datetime-local" name="start_datetime" required>
      </div>
      <div class="form-group">
        <label>End Date & Time</label>
        <input type="datetime-local" name="end_datetime" required>
      </div>
      <div class="form-group">
        <label>Authentication Method</label>
        <select name="authentication_method" required>
          <option value="fingerprint">Fingerprint</option>
          <option value="face">Face</option>
          <option value="both">Both</option>
        </select>
      </div>
      <button type="submit" name="create_election">Create Election</button>
    </form>

    <!-- List Elections -->
    <h2 style="margin-top:30px;">Existing Elections</h2>
    <table>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Start</th>
        <th>End</th>
        <th>Auth Method</th>
      </tr>
      <?php foreach($elections as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['title']); ?></td>
        <td><?= htmlspecialchars($e['status']); ?></td>
        <td><?= htmlspecialchars($e['start_datetime']); ?></td>
        <td><?= htmlspecialchars($e['end_datetime']); ?></td>
        <td><?= htmlspecialchars($e['authentication_method']); ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
