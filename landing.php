<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Campus Elect - School Voting System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --secondary: #06dc74;
      --dark: #1e293b;
      --light: #f8fafc;
      --gray: #64748b;
      --light-gray: #e2e8f0;
      --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      text-align: center;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* Background elements */
    .background-elements {
      position: fixed; 
      top: 0; 
      left: 0;
      width: 100%; 
      height: 100%;
      z-index: -1; 
      overflow: hidden;
    }
    
    .floating-icon {
      position: absolute; 
      opacity: 0.05;
      color: var(--primary); 
      font-size: 3rem;
      animation: float 20s infinite linear;
    }
    
    @keyframes float {
      0% { transform: translateY(0) translateX(0) rotate(0deg); }
      50% { transform: translateY(-15vh) translateX(15vw) rotate(180deg); }
      100% { transform: translateY(0) translateX(0) rotate(360deg); }
    }

    /* Header */
    header {
      margin-bottom: 30px;
      width: 100%;
      padding: 20px 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-left h1 {
      font-size: 1.8rem;
      margin: 0;
      color: var(--primary);
      font-weight: 700;
    }

    .header-left p {
      margin: 5px 0 0;
      font-size: 0.9rem;
      color: var(--gray);
      font-weight: 500;
    }
    
    /* Login button */
    .login-btn {
      background: var(--primary); 
      color: white;
      padding: 12px 30px;
      border-radius: 8px; 
      font-weight: 600;
      font-size: 1rem; 
      cursor: pointer;
      border: none;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: var(--card-shadow);
    }
    
    .login-btn:hover { 
      background: var(--primary-dark); 
      transform: translateY(-2px); 
      box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
    }
    
    /* Hero section */
    .hero {
      width: 100%;
      padding: 80px 20px;
      background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(6, 220, 116, 0.03) 100%);
      position: relative;
      overflow: hidden;
    }
    
    .hero-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .hero h1 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      font-weight: 800;
      color: var(--dark);
      line-height: 1.2;
    }
    
    .hero p {
      font-size: 1.2rem;
      color: var(--gray);
      max-width: 800px;
      margin-bottom: 30px;
    }
    
    /* Notice section */
    .notice {
      width: 100%;
      padding: 100px 20px;
      text-align: center;
      position: relative;
      overflow: hidden;
      background: url("Head.jpg") no-repeat center center;
      background-size: cover;
      color: white;
    }
    
    .notice::after {
      content: "";
      position: absolute;
      top: 0; 
      left: 0; 
      right: 0; 
      bottom: 0;
      background: rgba(255, 255, 255, 0.85);
      z-index: 0;
    }
    
    .notice-content {
      position: relative;
      z-index: 1;
      max-width: 1000px;
      margin: 0 auto;
    }

    .notice h1 {
      color: var(--dark);
      font-size: 2.2rem;
      margin-bottom: 25px;
      font-weight: 700;
    }

    .notice p {
      color: var(--dark);
      font-size: 1.2rem;
      margin: 15px 0;
      font-weight: 500;
    }
    
    .notice-highlight {
      background: linear-gradient(120deg, var(--primary) 0%, var(--secondary) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 700;
    }

    /* Gallery section */
    .gallery-section {
      width: 100%;
      padding: 80px 0;
      background: var(--light);
    }
    
    .section-title {
      font-size: 2.2rem;
      margin-bottom: 50px;
      color: var(--dark);
      font-weight: 700;
      position: relative;
      display: inline-block;
    }
    
    .section-title::after {
      content: "";
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      border-radius: 2px;
    }
    
    .gallery-container {
      width: 100%;
      overflow: hidden;
      position: relative;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .gallery-track {
      display: flex;
      gap: 25px;
      padding: 0 20px;
    }
    
    .gallery-item {
      flex: 0 0 auto;
      width: 320px;
      height: 220px;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      position: relative;
    }
    
    .gallery-item:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
    
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
    }
    
    .gallery-item:hover img {
      transform: scale(1.05);
    }
    
    .gallery-controls {
      margin-top: 40px;
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    
    .gallery-control-btn {
      background: var(--primary);
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .gallery-control-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }
    
    /* About section */
    .about {
      max-width: 1000px;
      margin: 60px auto;
      padding: 50px;
      background: white;
      border-radius: 20px;
      box-shadow: var(--card-shadow);
    }
    
    .about h2 { 
      margin-bottom: 25px; 
      font-size: 2rem; 
      color: var(--dark);
    }
    
    .about p { 
      font-size: 1.1rem; 
      line-height: 1.8; 
      color: var(--gray);
    }    
    
    /* Steps section */
    .steps-section {
      width: 100%;
      padding: 80px 20px;
      background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(6, 220, 116, 0.03) 100%);
    }
    
    .steps {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 50px;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: 50px auto 0;
    }
    
    .step {
      background: white;
      padding: 30px 25px;
      border-radius: 16px;
      width: 250px;
      text-align: center;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
    }
    
    .step:hover {
      transform: translateY(-5px);
    }
    
    .step-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      font-size: 1.8rem;
    }
    
    .step h3 { 
      font-size: 1.3rem; 
      margin-bottom: 12px; 
      color: var(--dark);
    }
    
    .step p { 
      font-size: 1rem; 
      color: var(--gray);
    }

    /* Footer */
    footer {
      margin-top: 100px;
      padding: 30px;
      font-size: 0.9rem;
      color: var(--gray);
      background: var(--dark);
      width: 100%;
    }
    
    footer p {
      color: white;
    }
    
    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1000;
      justify-content: center;
      align-items: center;
      backdrop-filter: blur(5px);
    }
    
    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 16px;
      width: 90%;
      max-width: 450px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      position: relative;
      animation: modalFadeIn 0.3s ease;
    }
    
    @keyframes modalFadeIn {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .close-modal {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--gray);
      transition: var(--transition);
    }
    
    .close-modal:hover {
      color: var(--dark);
    }
    
    .modal-logo {
      text-align: center;
      margin-bottom: 20px;
    }
    
    .modal-logo h2 {
      color: var(--primary);
      font-size: 1.8rem;
      font-weight: 700;
    }
    
    .modal-logo p {
      color: var(--gray);
      font-size: 0.9rem;
    }
    
    .modal-form {
      margin-top: 20px;
    }
    
    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }
    
    .form-group label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
      color: var(--dark);
    }
    
    .form-group input, 
    .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--light-gray);
      border-radius: 8px;
      font-family: 'Inter', sans-serif;
      transition: var(--transition);
    }
    
    .form-group input:focus, 
    .form-group select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .modal-btn {
      background: var(--primary);
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
      margin-top: 10px;
    }
    
    .modal-btn:hover {
      background: var(--primary-dark);
    }
    
    .modal-footer {
      text-align: center;
      font-size: 0.9rem;
      color: var(--gray);
      margin-top: 20px;
    }
    
    .modal-footer a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }
    
    .modal-footer a:hover {
      text-decoration: underline;
    }
    
    .error-message {
      color: #e53e3e;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9rem;
      display: none;
    }
    
    /* Responsive design */
    @media (max-width: 992px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      
      .notice h1 {
        font-size: 1.8rem;
      }
      
      .step {
        width: 220px;
      }
    }
    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }
      
      .hero h1 {
        font-size: 1.8rem;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .notice {
        padding: 60px 20px;
      }
      
      .notice h1 {
        font-size: 1.6rem;
      }
      
      .notice p {
        font-size: 1rem;
      }
      
      .about {
        padding: 30px 20px;
        margin: 40px 20px;
      }
      
      .steps {
        gap: 20px;
      }
      
      .step {
        width: 100%;
        max-width: 300px;
      }
      
      .gallery-item {
        width: 280px;
        height: 200px;
      }
      
      .modal-content {
        width: 95%;
        padding: 20px;
      }
    }
    
    @media (max-width: 576px) {
      .gallery-controls {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <!-- Background -->
  <div class="background-elements">
    <i class="floating-icon fas fa-vote-yea" style="top: 20%; left: 10%;"></i>
    <i class="floating-icon fas fa-check-circle" style="top: 60%; left: 80%;"></i>
    <i class="floating-icon fas fa-box-ballot" style="top: 40%; left: 50%;"></i>
    <i class="floating-icon fas fa-lock" style="top: 75%; left: 15%;"></i>
    <i class="floating-icon fas fa-user-shield" style="top: 30%; left: 85%;"></i>
  </div>

  <!-- Header -->
  <header>
    <div class="header-left">
      <h1>Campus Elect</h1>
      <p>Secure School Voting System</p>
    </div>
    <button class="login-btn" id="openLoginModal">
      <i class="fas fa-lock"></i> Access Portal
    </button>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1> Contemporary voting approach in <span class="notice-highlight">Modern Education</span></h1>
      <p>Empowering schools with secure, transparent, and accessible digital voting solutions powered by facial recognition technology.</p>
    </div>
  </section>

  <!-- Notice Section -->
  <section class="notice">
    <div class="notice-content">
      <h1>Election System Utilizing Face Recognition Technology</h1>
      <p>Provides excellency and reliability in ballot samples while conserving user identity.</p>
      <p>Amplifying efficiency for voting timeframes to match various schedules across school.</p>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery-section">
    <h2 class="section-title">Our Voting Process</h2>
    <div class="gallery-container">
      <div class="gallery-track">
        <div class="gallery-item">
          <img src="Balot.jpg" alt="Student voting">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Election booth">
        </div>
        <div class="gallery-item">
          <img src="Balot2.jpg" alt="Voting results">
        </div>
        <div class="gallery-item">
          <img src="Balot3.jpg" alt="Student election">
        </div>
        <div class="gallery-item">
          <img src="Balot4.jpg" alt="Ballot box">
        </div>
        <div class="gallery-item">
          <img src="Balot5.jpg" alt="Voting technology">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1552664688-cf412ec27db2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Election campaign">
        </div>
        <div class="gallery-item">
          <img src="Recognition.png" alt="Secure voting">
        </div>
        <!-- Duplicate items for seamless looping -->
        <div class="gallery-item">
          <img src="Balot.jpg" alt="Student voting">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Election booth">
        </div>
        <div class="gallery-item">
          <img src="Balot2.jpg" alt="Voting results">
        </div>
        <div class="gallery-item">
          <img src="Balot3.jpg" alt="Student election">
        </div>
      </div>
    </div>
    <div class="gallery-controls">
      <button class="gallery-control-btn" id="prevBtn"><i class="fas fa-chevron-left"></i> Previous</button>
      <button class="gallery-control-btn" id="nextBtn">Next <i class="fas fa-chevron-right"></i></button>
    </div>
  </section>

  <!-- About Section -->
  <section class="about">
    <h2><i class="fas fa-info-circle"></i> About Campus Elect</h2>
    <p>
      Campus Elect is a secure and reliable digital voting system designed specifically for educational institutions.  
      It ensures transparency, fairness, and accessibility for all students through cutting-edge facial recognition technology
      and strong encryption protocols. Your vote is always protected and your identity remains confidential throughout the process.
    </p>
  </section>

  <!-- Steps Section -->
  <section class="steps-section">
    <h2 class="section-title">How It Works</h2>
    <div class="steps">
      <div class="step">
        <div class="step-icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <h3>Register</h3>
        <p>Sign up as a verified student voter</p>
      </div>
      <div class="step">
        <div class="step-icon">
          <i class="fas fa-sign-in-alt"></i>
        </div>
        <h3>Login</h3>
        <p>Securely access your voting account</p>
      </div>
      <div class="step">
        <div class="step-icon">
          <i class="fas fa-vote-yea"></i>
        </div>
        <h3>Vote</h3>
        <p>Select your preferred candidates</p>
      </div>
      <div class="step">
        <div class="step-icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <h3>Results</h3>
        <p>View transparent, real-time outcomes</p>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2023 Campus Elect. All rights reserved.</p>
  </footer>

  <!-- Login Modal -->
  <div class="modal" id="loginModal">
    <div class="modal-content">
      <span class="close-modal" id="closeModal">&times;</span>
      
      <div class="modal-logo">
        <h2>Campus Elect</h2>
        <p>School Voting System</p>
      </div>
      
      <div class="error-message" id="errorMessage"></div>
      
      <form method="POST" action="login.php" id="loginForm" class="modal-form">
        <div class="form-group">
          <label for="roleSelect">Role</label>
          <select name="role" id="roleSelect" required onchange="toggleLoginFields()">
            <option value="">--Select Role--</option>
            <option value="admin">Admin</option>
            <option value="proctor">Proctor</option>
            <option value="student">Student</option>
          </select>
        </div>

        <div id="adminProctorFields">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
          </div>
        </div>

        <div id="studentFields" style="display:none;">
          <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" name="student_id" id="student_id">
          </div>
        </div>

        <button type="submit" class="modal-btn">Login</button>
        
        <div class="modal-footer">
          <p>Not yet Registered? <a href="register.php">Register</a></p>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Modal functionality
    const modal = document.getElementById('loginModal');
    const openModalBtn = document.getElementById('openLoginModal');
    const closeModalBtn = document.getElementById('closeModal');
    const errorMessage = document.getElementById('errorMessage');
    
    // Open modal
    openModalBtn.addEventListener('click', () => {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden'; // Prevent scrolling
    });
    
    // Close modal
    closeModalBtn.addEventListener('click', () => {
      modal.style.display = 'none';
      document.body.style.overflow = 'auto'; // Enable scrolling
      clearError();
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        clearError();
      }
    });
    
    // Clear error message
    function clearError() {
      errorMessage.style.display = 'none';
      errorMessage.textContent = '';
    }
    
    // Show error message
    function showError(message) {
      errorMessage.textContent = message;
      errorMessage.style.display = 'block';
    }
    
    // Toggle login fields based on role selection
    function toggleLoginFields() {
      const role = document.getElementById('roleSelect').value;
      document.getElementById('adminProctorFields').style.display = (role === "student") ? "none" : "block";
      document.getElementById('studentFields').style.display = (role === "student") ? "block" : "none";
      clearError();
    }
    
    // Form submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const role = document.getElementById('roleSelect').value;
      let isValid = true;
      let errorMsg = '';
      
      if (!role) {
        isValid = false;
        errorMsg = 'Please select a role.';
      } else if (role === 'admin' || role === 'proctor') {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
          isValid = false;
          errorMsg = 'Please fill all fields.';
        }
      } else if (role === 'student') {
        const studentId = document.getElementById('student_id').value;
        
        if (!studentId) {
          isValid = false;
          errorMsg = 'Please enter your Student ID.';
        }
      }
      
      if (!isValid) {
        showError(errorMsg);
        return;
      }
      
      // If validation passes, submit the form
      this.submit();
    });
    
    // Horizontal gallery functionality with infinite loop
    document.addEventListener('DOMContentLoaded', function() {
      const galleryTrack = document.querySelector('.gallery-track');
      const galleryItems = document.querySelectorAll('.gallery-item');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      
      let currentPosition = 0;
      let scrollAmount = 345; // Width of item + gap
      let autoScrollInterval;
      let isScrolling = true;
      
      // Calculate the point where we should reset to create the loop effect
      const originalItemsCount = 8; // Number of original items (not including duplicates)
      const loopThreshold = originalItemsCount * scrollAmount;

      // Function to move gallery
      function moveGallery(direction) {
        currentPosition += direction * scrollAmount;
        
        // Check if we need to loop back to the beginning
        if (currentPosition <= -loopThreshold) {
          currentPosition += loopThreshold;
          galleryTrack.style.transition = 'none';
          galleryTrack.style.transform = `translateX(${currentPosition}px)`;
          
          // Force a reflow
          void galleryTrack.offsetWidth;
          
          // Re-enable transition
          galleryTrack.style.transition = 'transform 0.5s ease';
        } 
        // Check if we need to loop to the end when going backwards
        else if (currentPosition > 0) {
          currentPosition -= loopThreshold;
          galleryTrack.style.transition = 'none';
          galleryTrack.style.transform = `translateX(${currentPosition}px)`;
          
          // Force a reflow
          void galleryTrack.offsetWidth;
          
          // Re-enable transition
          galleryTrack.style.transition = 'transform 0.5s ease';
        }
        
        galleryTrack.style.transform = `translateX(${currentPosition}px)`;
      }

      // Set up button events
      prevBtn.addEventListener('click', () => {
        moveGallery(1);
        // Reset auto-scroll timer
        resetAutoScroll();
      });
      
      nextBtn.addEventListener('click', () => {
        moveGallery(-1);
        // Reset auto-scroll timer
        resetAutoScroll();
      });

      // Auto-scroll functionality
      function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
          moveGallery(-1);
        }, 5000); // Scroll every 5 seconds
      }

      // Reset auto-scroll timer
      function resetAutoScroll() {
        clearInterval(autoScrollInterval);
        startAutoScroll();
      }

      // Start auto-scrolling
      startAutoScroll();

      // Pause auto-scroll on hover
      const galleryContainer = document.querySelector('.gallery-container');
      galleryContainer.addEventListener('mouseenter', () => {
        clearInterval(autoScrollInterval);
        isScrolling = false;
      });
      
      galleryContainer.addEventListener('mouseleave', () => {
        if (!isScrolling) {
          startAutoScroll();
          isScrolling = true;
        }
      });
    });
  </script>
</body>
</html>