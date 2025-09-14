<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST['role'] ?? '';

    if ($role === "admin" || $role === "proctor") {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = "Please fill all fields.";
        } else {
            $stmt = $conn->prepare("SELECT user_id, full_name, password, role FROM users WHERE email=? AND role=? LIMIT 1");
            $stmt->bind_param("ss", $email, $role);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    $_SESSION['role'] = $row['role'];

                    // ✅ Redirect by role
                    if ($row['role'] === "admin") {
                        header("Location: admin.php");
                    } elseif ($row['role'] === "proctor") {
                        header("Location: dashboard.php");
                    }
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "No account found for this role.";
            }
        }

    } elseif ($role === "student") {
        $student_id = trim($_POST['student_id'] ?? '');
        if (empty($student_id)) {
            $error = "Please enter your Student ID.";
        } else {
            $stmt = $conn->prepare("SELECT user_id, full_name, role FROM users WHERE student_id=? AND role='student' LIMIT 1");
            $stmt->bind_param("s", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['role'] = $row['role'];
                header("Location: student_dashboard.php");
                exit();
            } else {
                $error = "Student ID not found.";
            }
        }

    } else {
        $error = "Please select a role.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - eVOTE</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 50%, #ffffffff 100%);
      color: black;
      text-align: center;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      overflow-x: hidden;
      position: relative;
    }

    /* Background matching the first code */
    .background-elements {
      position: absolute; 
      top: 0; 
      left: 0;
      width: 100%; 
      height: 100%;
      z-index: -1; 
      overflow: hidden;
    }
    
    .floating-icon {
      position: absolute; 
      opacity: 0.15;
      color: black; 
      font-size: 3rem;
      animation: float 20s infinite linear;
    }
    
    @keyframes float {
      0% { transform: translateY(0) translateX(0) rotate(0deg); }
      50% { transform: translateY(-15vh) translateX(15vw) rotate(180deg); }
      100% { transform: translateY(0) translateX(0) rotate(360deg); }
    }

    /* Back button */
    #back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 10;
    }
    
    #back-button a {
      color: #6b6969ff;
      text-decoration: none;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    #back-button a:hover {
      color: #06dc74ff;
    }

    /* Login Card */
    .card {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      width: 400px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1e3a8a;
      font-weight: 600;
    }
    
    .form-group {
      margin-bottom: 15px;
    }
    
    label {
      display: block;
      font-weight: 500;
      margin-bottom: 5px;
      color: #374151;
    }
    
    input, select {
      width: 100%;
      padding: 12px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-family: 'Inter', sans-serif;
      transition: border-color 0.3s;
    }
    
    input:focus, select:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }
    
    .btn {
      background: #444343ff;
      color: #fff;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
      margin-top: 10px;
    }
    
    .btn:hover {
      background: #06dc74ff;
      transform: scale(1.05);
    }
    
    .error {
      color: #ef4444;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }
    
    .success {
      color: #10b981;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }
    
    .card-footer {
      text-align: center;
      font-size: 0.8125rem;
      color: #64748b;
      margin-top: 20px;
    }
    
    .card-footer a {
      color: #2563eb;
      text-decoration: none;
      font-weight: 500;
    }
    
    .card-footer a:hover {
      text-decoration: underline;
    }
    
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    
    .logo h1 {
      color: #6b6969ff;
      font-size: 2rem;
      font-weight: 700;
    }
    
    .logo p {
      color: #6b7280;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <!-- Background matching the first code -->
  <div class="background-elements">
    <i class="floating-icon fas fa-vote-yea" style="top: 20%; left: 10%;"></i>
    <i class="floating-icon fas fa-check-circle" style="top: 60%; left: 80%;"></i>
    <i class="floating-icon fas fa-box-ballot" style="top: 40%; left: 50%;"></i>
  </div>

  <!-- Back button -->
  <div id="back-button">
    <p><a href="landing.php"><i class="fas fa-arrow-left"></i> Back to Home</a></p>
  </div>

  <div class="card">
    <div class="logo">
      <h1>eVOTE</h1>
      <p>School Voting System</p>
    </div>
    
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <form method="POST" id="loginForm">
      <div class="form-group">
        <label>Role</label>
        <select name="role" id="roleSelect" required onchange="toggleLoginFields()">
          <option value="">--Select Role--</option>
          <option value="admin">Admin</option>
          <option value="proctor">Proctor</option>
          <option value="student">Student</option>
        </select>
      </div>

      <div id="adminProctorFields">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password">
        </div>
      </div>

      <div id="studentFields" style="display:none;">
        <div class="form-group">
          <label>Student ID</label>
          <input type="text" name="student_id">
        </div>
      </div>

      <button type="submit" class="btn">Login</button>
      
      <div class="card-footer">
        <p>Not yet Registered? <a href="register.php">Register</a></p>
      </div>
    </form>
  </div>

  <script>
    function toggleLoginFields() {
      const role = document.getElementById('roleSelect').value;
      document.getElementById('adminProctorFields').style.display = (role === "student") ? "none" : "block";
      document.getElementById('studentFields').style.display = (role === "student") ? "block" : "none";
    }
  </script>
</body>
</html>