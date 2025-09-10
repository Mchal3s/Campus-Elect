<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - eVOTE</title>
  <style>
    body {font-family: 'Inter', sans-serif;background:#505254;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;}
    .card {background:#fff;padding:30px;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,0.1);width:400px;}
    h2 {text-align:center;margin-bottom:20px;}
    .form-group {margin-bottom:15px;}
    label {display:block;font-weight:500;margin-bottom:5px;}
    input, select {width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;}
    .btn {background:#2563eb;color:#fff;padding:12px;border:none;width:100%;border-radius:8px;cursor:pointer;}
    .btn:hover {background:#1d4ed8;}
    .error {color:red;text-align:center;}
  </style>
  <script>
    function toggleFields() {
      const role = document.getElementById('role').value;
      document.getElementById('passwordField').style.display = (role === "admin" || role === "proctor") ? "block" : "none";
      document.getElementById('studentIdField').style.display = (role === "student") ? "block" : "none";
      document.getElementById('photoField').style.display = (role === "student") ? "block" : "none";
    }
  </script>
</head>
<body>
  <div class="card">
    <h2>Register</h2>
    <?php if(isset($_GET['error'])) echo "<p class='error'>".htmlspecialchars($_GET['error'])."</p>"; ?>
    <form method="POST" action="register_handler.php" enctype="multipart/form-data">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="full_name" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Role</label>
        <select name="role" id="role" onchange="toggleFields()" required>
          <option value="">--Select Role--</option>
          <option value="admin">Admin</option>
          <option value="proctor">Proctor</option>
          <option value="student">Student</option>
        </select>
      </div>

      <div id="passwordField" class="form-group" style="display:none;">
        <label>Password</label>
        <input type="password" name="password">
      </div>

      <div id="studentIdField" class="form-group" style="display:none;">
        <label>Student ID</label>
        <input type="text" name="student_id">
      </div>

      <div id="photoField" class="form-group" style="display:none;">
        <label>Upload Photo</label>
        <input type="file" name="photo" accept="image/*">
      </div>

      <button type="submit" class="btn">Register</button>
    </form>
  </div>
</body>
</html>
