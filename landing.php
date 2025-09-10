<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>eVOTE - School Voting System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      justify-content: center;
      text-align: center;
      overflow-x: hidden;
      position: relative;
    }

    /* Animated Background Elements */
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
      opacity: 0.1;
      color: white;
      font-size: 2rem;
      animation: float 15s infinite linear;
    }

    @keyframes float {
      0% { transform: translateY(0) translateX(0) rotate(0deg); }
      25% { transform: translateY(-20vh) translateX(10vw) rotate(90deg); }
      50% { transform: translateY(10vh) translateX(20vw) rotate(180deg); }
      75% { transform: translateY(20vh) translateX(-10vw) rotate(270deg); }
      100% { transform: translateY(0) translateX(0) rotate(360deg); }
    }

    /* Header Styles */
    header {
      margin-top: 40px;
      margin-bottom: 40px;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    header h1 {
      font-size: 3rem;
      font-weight: 700;
      margin: 0;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    header p {
      margin-top: 10px;
      font-size: 1.2rem;
      opacity: 0.85;
    }

    /* Login Button */
    .login-btn {
      background: #fff;
      color: #2563eb;
      border: none;
      padding: 16px 40px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .login-btn:hover {
      background: #f3f4f6;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .login-btn:active {
      transform: translateY(1px);
    }

    .login-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      transition: 0.5s;
      z-index: -1;
    }

    .login-btn:hover::before {
      left: 100%;
    }

    /* Dynamic Section */
    .dynamic-section {
      margin-top: 60px;
      max-width: 600px;
      background: rgba(255,255,255,0.1);
      padding: 25px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
      animation: slideUp 1s ease-out;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .dynamic-section h2 {
      margin-bottom: 15px;
      font-size: 1.5rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .dynamic-section p {
      font-size: 1rem;
      line-height: 1.6;
      opacity: 0.9;
    }

    /* Features Section */
    .features {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 50px;
      flex-wrap: wrap;
      animation: fadeIn 1.5s ease-out;
    }

    .feature {
      background: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 12px;
      width: 160px;
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255,255,255,0.15);
      transition: transform 0.3s;
    }

    .feature:hover {
      transform: translateY(-5px);
    }

    .feature i {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #93c5fd;
    }

    .feature h3 {
      font-size: 1rem;
      margin-bottom: 5px;
    }

    /* Footer */
    footer {
      margin-top: 60px;
      padding: 20px;
      font-size: 0.9rem;
      opacity: 0.7;
    }

    /* Countdown Timer */
    .countdown {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
    }

    .countdown-item {
      background: rgba(255,255,255,0.15);
      padding: 10px;
      border-radius: 8px;
      min-width: 60px;
    }

    .countdown-number {
      font-size: 1.8rem;
      font-weight: 700;
    }

    .countdown-label {
      font-size: 0.7rem;
      text-transform: uppercase;
      margin-top: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      header h1 {
        font-size: 2.2rem;
      }
      
      .features {
        gap: 15px;
      }
      
      .feature {
        width: 140px;
        padding: 15px;
      }
      
      .dynamic-section {
        margin: 20px;
        padding: 20px;
      }
    }

    @media (max-width: 480px) {
      header h1 {
        font-size: 1.8rem;
      }
      
      header p {
        font-size: 1rem;
      }
      
      .login-btn {
        padding: 14px 30px;
        font-size: 1rem;
      }
      
      .feature {
        width: 120px;
      }
      
      .countdown {
        gap: 10px;
      }
      
      .countdown-item {
        min-width: 50px;
        padding: 8px;
      }
      
      .countdown-number {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Animated Background Elements -->
  <div class="background-elements">
    <i class="floating-icon fas fa-vote-yea" style="top: 20%; left: 10%; animation-delay: 0s;"></i>
    <i class="floating-icon fas fa-ballot" style="top: 60%; left: 80%; animation-delay: 2s;"></i>
    <i class="floating-icon fas fa-check-circle" style="top: 30%; left: 70%; animation-delay: 2s;"></i>
    <i class="floating-icon fas fa-democrat" style="top: 70%; left: 20%; animation-delay: 1s;"></i>
    <i class="floating-icon fas fa-republican" style="top: 10%; left: 50%; animation-delay: 2s;"></i>
    <i class="floating-icon fas fa-balance-scale" style="top: 80%; left: 60%; animation-delay: 1s;"></i>
  </div>

  <header>
    <h1>Welcome to Campus Elect</h1>
    <p>Secure School Voting System</p>
  </header>

  <button class="login-btn" onclick="window.location.href='login.php'">
    <i class="fas fa-lock"></i> Login to Vote
  </button>

  <div class="dynamic-section">
    <h2><i class="fas fa-bullhorn"></i> Announcements</h2>
    <p>Voting will be announced for <strong>Further Updates</strong>. Please ensure you are registered as a student to participate in the elections.</p>
    
    <div class="countdown">
      <div class="countdown-item">
        <div class="countdown-number" id="days">00</div>
        <div class="countdown-label">Days</div>
      </div>
      <div class="countdown-item">
        <div class="countdown-number" id="hours">00</div>
        <div class="countdown-label">Hours</div>
      </div>
      <div class="countdown-item">
        <div class="countdown-number" id="minutes">00</div>
        <div class="countdown-label">Minutes</div>
      </div>
      <div class="countdown-item">
        <div class="countdown-number" id="seconds">00</div>
        <div class="countdown-label">Seconds</div>
      </div>
    </div>
  </div>

  <div class="features">
    <div class="feature">
      <i class="fas fa-shield-alt"></i>
      <h3>Secure</h3>
      <p>Protected voting</p>
    </div>
    <div class="feature">
      <i class="fas fa-user-lock"></i>
      <h3>Private</h3>
      <p>Anonymous ballots</p>
    </div>
    <div class="feature">
      <i class="fas fa-bolt"></i>
      <h3>Fast</h3>
      <p>Quick results</p>
    </div>
    <div class="feature">
      <i class="fas fa-mobile-alt"></i>
      <h3>Mobile</h3>
      <p>Any device access</p>
    </div>
  </div>

  <footer>
    &copy; 2023 eVOTE. All rights reserved.
  </footer>

  <script>
    // Countdown timer
    function updateCountdown() {
      const targetDate = new Date('September 15, 2023 00:00:00').getTime();
      const now = new Date().getTime();
      const distance = targetDate - now;
      
      if (distance > 0) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('days').textContent = days.toString().padStart(2, '0');
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
      } else {
        document.querySelector('.countdown').innerHTML = '<div class="countdown-ended">Voting is not yet Open</div>';
      }
    }
    
    // Initial call and set interval
    updateCountdown();
    setInterval(updateCountdown, 1000);
    
    // Add hover effect to features
    const features = document.querySelectorAll('.feature');
    features.forEach(feature => {
      feature.addEventListener('mouseenter', () => {
        feature.style.background = 'rgba(255,255,255,0.2)';
      });
      feature.addEventListener('mouseleave', () => {
        feature.style.background = 'rgba(255,255,255,0.1)';
      });
    });
  </script>
</body>
</html>