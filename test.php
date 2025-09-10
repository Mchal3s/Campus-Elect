<!DOCTYPE html>
<html>
<body>
  <h2>Webcam Test</h2>
  <video id="camera" autoplay playsinline></video>
  <script>
    const video = document.getElementById("camera");
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => { video.srcObject = stream; })
      .catch(err => console.error("Camera error:", err));
  </script>
</body>
</html>
