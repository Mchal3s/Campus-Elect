<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Success</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #505254;
      font-family: 'Inter', sans-serif;
      margin: 0;
    }
    .success-container {
  text-align: center;
  background: #fff;
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  animation: fadeIn 1s ease;
  display: flex;
  flex-direction: column;
  align-items: center;   /* centers everything horizontally */
  justify-content: center;
}

.checkmark {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 6px solid #4ade80;
  position: relative;
  animation: pop 0.5s ease forwards;
  display: flex;
  align-items: center;
  justify-content: center;
}

.checkmark::after {
  content: "";
  width: 30px;
  height: 60px;
  border: solid #4ade80;
  border-width: 0 6px 6px 0;
  transform: rotate(45deg) scale(0);
  transform-origin: center;
  animation: check 0.5s ease forwards 0.5s;
}


    h2 {
      margin-top: 20px;
      color: #16a34a;
    }
    p {
      color: #374151;
    }
    @keyframes pop {
      0% { transform: scale(0.5); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    @keyframes check {
      0% { transform: rotate(45deg) scale(0); }
      100% { transform: rotate(45deg) scale(1); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .btn {
      margin-top: 20px;
      background: #2563eb;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .btn:hover {
      background: #1d4ed8;
    }
    .btn-container {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 25px;
      flex-wrap: wrap;
    }
  </style>
</head>
<body>
  <div class="success-container">
    <div class="checkmark"></div>
    <h2>Registration Successful!</h2>
    <p>Welcome student 🎉 You can now log in.</p>

    <div class="btn-container">
      <a href="register.php" class="btn">Next Student</a>
      <a href="landing.php" class="btn">Home</a>
    </div>
  </div>
</body>
</html>
