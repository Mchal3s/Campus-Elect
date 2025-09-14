<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please login first");
    exit();
}

// pull name safely from session
$fullName = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : "User";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>eVOTE - Student Verification</title>
  <script defer src="https://cdn.jsdelivr.net/npm/face-api.js"></script>
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
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #1e40af 100%);
      color: white;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    /* Particle Container */
    #particles-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    /* Individual Particle */
    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
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

    /* Header Styles */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .logo h1 {
      font-size: 1.8rem;
      font-weight: 700;
      color: white;
    }

    .logo span {
      color: #93c5fd;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-info p {
      font-weight: 500;
    }

    /* Logout Button */
    .logout-btn {
      background: rgba(239, 68, 68, 0.9);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .logout-btn:hover {
      background: rgba(220, 38, 38, 1);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Main Content */
    .main {
      max-width: 1200px;
      margin: 40px auto;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .welcome-section {
      text-align: center;
      margin-bottom: 30px;
    }

    .welcome-section h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .welcome-section p {
      font-size: 1.1rem;
      opacity: 0.9;
    }

    /* Camera Section */
    .verification-container {
      display: flex;
      gap: 40px;
      width: 100%;
      max-width: 1000px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 30px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .camera-section {
      flex: 1;
    }

    #camera {
      width: 100%;
      height: 350px;
      border-radius: 12px;
      object-fit: cover;
      border: 2px solid #93c5fd;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .info-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .student-info {
      background: rgba(255, 255, 255, 0.1);
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 20px;
      text-align: center;
      transition: all 0.3s;
    }

    .student-info.verified {
      background: rgba(34, 197, 94, 0.2);
      border: 1px solid rgba(34, 197, 94, 0.5);
    }

    .student-info h2 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      font-weight: 600;
    }

    #student-name {
      font-size: 1.8rem;
      font-weight: 700;
      color: #93c5fd;
      margin-bottom: 10px;
    }

    #student-id {
      font-size: 1.2rem;
      opacity: 0.9;
    }

    .status-indicator {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 8px;
      background: #ef4444;
    }

    .status-indicator.verified {
      background: #22c55e;
    }

    .instructions {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 12px;
    }

    .instructions h3 {
      margin-bottom: 15px;
      font-weight: 600;
    }

    .instructions ul {
      list-style-type: none;
    }

    .instructions li {
      margin-bottom: 10px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .instructions i {
      color: #93c5fd;
      margin-top: 3px;
    }

    /* Verification Animation */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .verifying {
      animation: pulse 1.5s infinite;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 100;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      color: #1e3a8a;
      padding: 30px;
      border-radius: 16px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .modal-content h2 {
      margin-bottom: 15px;
      font-weight: 600;
    }

    .modal-content p {
      margin-bottom: 25px;
      line-height: 1.5;
    }

    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .modal-btn {
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s;
    }

    .modal-btn.cancel {
      background: #e5e7eb;
      color: #374151;
      border: none;
    }

    .modal-btn.cancel:hover {
      background: #d1d5db;
    }

    .modal-btn.confirm {
      background: #ef4444;
      color: white;
      border: none;
    }

    .modal-btn.confirm:hover {
      background: #dc2626;
    }

    /* Responsive Design */
    @media (max-width: 900px) {
      .verification-container {
        flex-direction: column;
      }
      
      #camera {
        height: 300px;
      }
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }
      
      .welcome-section h1 {
        font-size: 2rem;
      }
      
      .verification-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Particle Background -->
  <div id="particles-container"></div>

  <!-- Header -->
  <header>
    <div class="logo">
      <h1>eVOTE<span>.</span></h1>
    </div>
    <div class="user-info">
      <p>Welcome, <?php echo htmlspecialchars($fullName); ?></p>
      <button class="logout-btn" onclick="showLogoutModal()">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </div>
  </header>

  
  <div class="main">
    <div class="welcome-section">
      <h1>Student Verification</h1>
      <p>Please look at the camera to verify your identity</p>
    </div>

    <div class="verification-container">
      <div class="camera-section">
        <video id="camera" autoplay muted></video>
      </div>
      
      <div class="info-section">
        <div class="student-info" id="student-info">
          <h2>Verification Status</h2>
          <div id="status">
            <span class="status-indicator"></span>
            <span id="status-text">Waiting for verification...</span>
          </div>
          <div id="student-name">No student detected</div>
          <div id="student-id"></div>
        </div>
        
        <div class="instructions">
          <h3>Verification Instructions</h3>
          <ul>
            <li><i class="fas fa-lightbulb"></i> Ensure good lighting on your face</li>
            <li><i class="fas fa-video"></i> Look directly at the camera</li>
            <li><i class="fas fa-user-alt"></i> Remove sunglasses or hats</li>
            <li><i class="fas fa-check-circle"></i> Stay still during verification</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Modal -->
  <div class="modal" id="logout-modal">
    <div class="modal-content">
      <h2>Confirm Logout</h2>
      <p>Are you sure you want to logout from the eVOTE system?</p>
      <div class="modal-buttons">
        <button class="modal-btn cancel" onclick="hideLogoutModal()">Cancel</button>
        <button class="modal-btn confirm" onclick="performLogout()">Logout</button>
      </div>
    </div>
  </div>

  <script>
    // Create floating particles
    function createParticles() {
      const container = document.getElementById('particles-container');
      const particleCount = 30;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Random properties
        const size = Math.random() * 5 + 2;
        const posX = Math.random() * 100;
        const delay = Math.random() * 15;
        const duration = 15 + Math.random() * 10;
        
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}vw`;
        particle.style.animationDelay = `${delay}s`;
        particle.style.animationDuration = `${duration}s`;
        
        container.appendChild(particle);
      }
    }

    // Logout modal functions
    function showLogoutModal() {
      document.getElementById('logout-modal').style.display = 'flex';
    }

    function hideLogoutModal() {
      document.getElementById('logout-modal').style.display = 'none';
    }

    function performLogout() {
      window.location.href = 'logout.php';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('logout-modal');
      if (event.target === modal) {
        hideLogoutModal();
      }
    };

    // Face recognition code
    const video = document.getElementById('camera');
    const studentName = document.getElementById('student-name');
    const studentId = document.getElementById('student-id');
    const studentInfo = document.getElementById('student-info');
    const statusText = document.getElementById('status-text');
    const statusIndicator = document.querySelector('.status-indicator');

    Promise.all([
      faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
      faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
      faceapi.nets.faceLandmark68Net.loadFromUri('/models')
    ]).then(startCamera);

    async function startCamera() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
        video.srcObject = stream;

        const labeledDescriptors = await loadStudents();
        const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);

        video.addEventListener('play', () => {
          setInterval(async () => {
            const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
              .withFaceLandmarks().withFaceDescriptors();

            if (detections.length > 0) {
              const bestMatch = faceMatcher.findBestMatch(detections[0].descriptor);
              
              if (bestMatch.label !== "unknown") {
                studentName.textContent = bestMatch.label;
                studentId.textContent = "Verified Student";
                statusText.textContent = "Verified";
                statusIndicator.classList.add('verified');
                studentInfo.classList.add('verified');
                
                // Send verification to server
                fetch("verify_student.php", {
                  method: "POST",
                  headers: {"Content-Type": "application/x-www-form-urlencoded"},
                  body: "student_id=" + encodeURIComponent(bestMatch.label)
                });
              } else {
                studentName.textContent = "Unknown Student";
                studentId.textContent = "Please try again or contact administrator";
                statusText.textContent = "Not Recognized";
                statusIndicator.classList.remove('verified');
                studentInfo.classList.remove('verified');
              }
            } else {
              studentName.textContent = "No face detected";
              studentId.textContent = "";
              statusText.textContent = "Waiting for verification...";
              statusIndicator.classList.remove('verified');
              studentInfo.classList.remove('verified');
            }
          }, 2000);
        });
      } catch (error) {
        console.error("Error accessing camera:", error);
        studentName.textContent = "Camera access denied";
        studentId.textContent = "Please allow camera access to continue";
      }
    }

    async function loadStudents() {
      try {
        const res = await fetch("students_api.php");
        const students = await res.json();

        return Promise.all(students.map(async stu => {
          const img = await faceapi.fetchImage("data:image/png;base64," + stu.photo);
          const desc = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();  
          return new faceapi.LabeledFaceDescriptors(stu.id, [desc.descriptor]);
        }));
      } catch (error) {
        console.error("Error loading students:", error);
        return [];
      }
    }

   
    window.onload = function() {
      createParticles();
    };
  </script>
</body>
</html>