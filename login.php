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
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      position: relative;
      overflow: hidden;
    }

    /* Particle Container */
    #particles-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #1e40af 100%);
      overflow: hidden;
    }

    /* Individual Particle */
    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.6);
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
      animation: float 15s infinite linear;
    }

    /* Particle Animation */
    @keyframes float {
      0% { transform: translateY(0) translateX(0); opacity: 0; }
      10% { opacity: 0.8; }
      90% { opacity: 0.8; }
      100% { transform: translateY(-100vh) translateX(20vw); opacity: 0; }
    }

    /* Building Silhouettes */
    .buildings {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 30%;
      background-image: 
        linear-gradient(to top, rgba(30, 58, 138, 0.8) 0%, transparent 100%),
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 200' fill='%231e3a8a'%3E%3Cpath d='M0,200 L0,50 L50,50 L50,150 L100,150 L100,100 L150,100 L150,150 L200,150 L200,75 L250,75 L250,200 L300,200 L300,50 L350,50 L350,125 L400,125 L400,200 L450,200 L450,100 L500,100 L500,200 L550,200 L550,50 L600,50 L600,150 L650,150 L650,100 L700,100 L700,200 L750,200 L750,75 L800,75 L800,150 L850,150 L850,50 L900,50 L900,200 L950,200 L950,125 L1000,125 L1000,200 L1050,200 L1050,100 L1100,100 L1100,150 L1150,150 L1150,75 L1200,75 L1200,200 Z'/%3E%3C/svg%3E");
      background-size: 100% 100%;
      z-index: -1;
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
      position: relative;
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
      background: #2563eb;
      color: #fff;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: background 0.3s;
      margin-top: 10px;
    }
    
    .btn:hover {
      background: #1d4ed8;
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
      color: #2563eb;
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
  <div id="back-button">
   <p><a href="landing.php">Back</a></p>
  </div>
  
  <div id="particles-container"></div>
  <div class="buildings"></div>

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
    window.onload = function() { createParticles(); };
    function createParticles() {
      const container = document.getElementById('particles-container');
      for (let i = 0; i < 40; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        const size = Math.random() * 5 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${Math.random() * 100}vw`;
        particle.style.animationDelay = `${Math.random() * 15}s`;
        particle.style.animationDuration = `${15 + Math.random() * 10}s`;
        container.appendChild(particle);
      }
    }
  </script>
</body>
</html>
