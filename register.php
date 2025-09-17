<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - eVOTE</title>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #505254;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 420px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
    }
    input, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .btn {
      background: #2563eb;
      color: #fff;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
    }
    .btn:hover {
      background: #1d4ed8;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
  <script>
    function toggleFields() {
      const role = document.getElementById('role').value;
      
      // Show password for all roles
      document.getElementById('passwordField').style.display = "block";
      document.getElementById('confirmPasswordField').style.display = "block";

      // Student-only fields
      const studentFields = document.querySelectorAll('.student-only');
      studentFields.forEach(field => {
        field.style.display = (role === "student") ? "block" : "none";
      });
    }
  </script>
</head>
<body>
  <div class="card">
    <h2>Register</h2>
    <?php if(isset($_GET['error'])) echo "<p class='error'>".htmlspecialchars($_GET['error'])."</p>"; ?>
    <form method="POST" action="register_handler.php" enctype="multipart/form-data">
      <!-- Common Fields -->
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

      <!-- Password (for all roles now) -->
      <div id="passwordField" class="form-group" style="display:none;">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div id="confirmPasswordField" class="form-group" style="display:none;">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>
      </div>

      <!-- Student Only Fields -->
      <div class="form-group student-only" style="display:none;">
        <label>Phone Number</label>
        <input type="text" name="phone">
      </div>
      <div class="form-group student-only" style="display:none;">
        <label>Student ID</label>
        <input type="text" name="student_id">
      </div>
      <div class="form-group student-only" style="display:none;">
        <label>Section</label>
        <input type="text" name="section">
      </div>
      <div class="form-group student-only" style="display:none;">
        <label>Course</label>
        <input type="text" name="course">
      </div>
      <div class="form-group student-only" style="display:none;">
        <label>Year Level</label>
        <select name="year_level">
          <option value="">--Select Year Level--</option>
          <option value="1st Year">1st Year</option>
          <option value="2nd Year">2nd Year</option>
          <option value="3rd Year">3rd Year</option>
          <option value="4th Year">4th Year</option>
        </select>
      </div>
      <div class="form-group student-only" style="display:none;">
        <label>Upload Photo</label>
        <input type="file" name="photo" accept="image/*">
      </div>

      <button type="submit" class="btn">Register</button>
    </form>
  </div>
</body>
</html>
