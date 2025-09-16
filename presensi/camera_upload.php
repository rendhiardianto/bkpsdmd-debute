<?php
// camera_upload.php
// Single-file HTML+PHP to capture/upload photos from camera or file picker.

// --- Server-side upload handling ---
$uploadResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If using direct file upload (file input or canvas blob sent as "photo")
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['photo'];
        // Basic validations
        $maxSize = 5 * 1024 * 1024; // 5 MB
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadResult = ['success' => false, 'msg' => 'Upload error code: ' . $file['error']];
        } elseif ($file['size'] > $maxSize) {
            $uploadResult = ['success' => false, 'msg' => 'File too large (max 5 MB).'];
        } else {
            // Validate MIME using finfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime, $allowed)) {
                $uploadResult = ['success' => false, 'msg' => 'Invalid file type.'];
            } else {
                // prepare uploads folder
                $uploadDir = __DIR__ . '/uploads';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $ext = match ($mime) {
                    'image/jpeg' => '.jpg',
                    'image/png'  => '.png',
                    'image/webp' => '.webp',
                    default => ''
                };
                $filename = 'photo_' . time() . '_' . bin2hex(random_bytes(6)) . $ext;
                $destination = $uploadDir . '/' . $filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $uploadResult = ['success' => true, 'msg' => 'Uploaded successfully.', 'path' => 'uploads/' . $filename];
                } else {
                    $uploadResult = ['success' => false, 'msg' => 'Failed to move uploaded file.'];
                }
            }
        }
    }
    // If using fetch with blob (JS camera capture), we still receive it in $_FILES['photo'] above.
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Camera Upload</title>
<style>
  body{font-family:system-ui,Segoe UI,Roboto,Arial;max-width:800px;margin:20px auto;padding:10px}
  .card{border:1px solid #ddd;padding:14px;border-radius:8px;margin-bottom:16px}
  video{max-width:100%;border-radius:6px}
  img.preview{max-width:100%;border-radius:6px;margin-top:8px}
  .btn{display:inline-block;padding:8px 12px;border-radius:6px;border:1px solid #666;background:#f2f2f2;cursor:pointer}
  .btn-danger{background:#ffecec;border-color:#e06464}
  .small{font-size:0.9rem;color:#555}
</style>
</head>
<body>

<h1>Camera / Photo Upload</h1>

<div class="card">
  <h3>1) Quick (mobile-friendly) — open phone camera or file picker</h3>
  <p class="small">Tap the button on a phone to open the camera (uses the <code>capture</code> attribute). On desktop this opens file picker.</p>

  <form method="post" enctype="multipart/form-data" id="fileForm">
    <input type="file" name="photo" id="fileInput" accept="image/*" capture="environment">
    <br><br>
    <button type="submit" class="btn">Upload selected photo</button>
  </form>

  <div id="filePreview"></div>
</div>

<div class="card">
  <h3>2) Live camera capture (works on desktop & mobile browsers that allow camera)</h3>
  <p class="small">Click <em>Start Camera</em>, then <em>Capture Photo</em> to take a snapshot and upload it.</p>

  <div id="cameraArea">
    <video id="video" playsinline autoplay width="480" style="display:none"></video>
    <canvas id="canvas" style="display:none"></canvas>
    <div id="controls">
      <button id="startBtn" class="btn">Start Camera</button>
      <button id="captureBtn" class="btn" style="display:none">Capture Photo</button>
      <button id="stopBtn" class="btn btn-danger" style="display:none">Stop Camera</button>
    </div>
    <div id="snapPreview"></div>
  </div>
</div>

<?php if ($uploadResult !== null): ?>
  <div class="card">
    <h3>Upload result</h3>
    <p><?php echo htmlspecialchars($uploadResult['msg']); ?></p>
    <?php if (!empty($uploadResult['path']) && $uploadResult['success']): ?>
      <p>Saved as: <a href="<?php echo htmlspecialchars($uploadResult['path']); ?>" target="_blank"><?php echo htmlspecialchars($uploadResult['path']); ?></a></p>
      <img src="<?php echo htmlspecialchars($uploadResult['path']); ?>" class="preview" alt="uploaded image">
    <?php endif; ?>
  </div>
<?php endif; ?>

<script>
// --- Simple preview for file input ---
const fileInput = document.getElementById('fileInput');
const filePreview = document.getElementById('filePreview');
fileInput.addEventListener('change', e => {
  filePreview.innerHTML = '';
  const f = e.target.files?.[0];
  if (!f) return;
  const img = document.createElement('img');
  img.className = 'preview';
  img.src = URL.createObjectURL(f);
  filePreview.appendChild(img);
});

// --- Live camera capture using getUserMedia ---
const startBtn = document.getElementById('startBtn');
const captureBtn = document.getElementById('captureBtn');
const stopBtn = document.getElementById('stopBtn');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const snapPreview = document.getElementById('snapPreview');
let stream = null;

startBtn.addEventListener('click', async () => {
  try {
    // prefer environment (rear) camera on mobile
    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
    video.srcObject = stream;
    video.style.display = 'block';
    captureBtn.style.display = 'inline-block';
    stopBtn.style.display = 'inline-block';
    startBtn.style.display = 'none';
  } catch (err) {
    alert('Could not start camera: ' + err.message);
  }
});

stopBtn.addEventListener('click', () => {
  if (stream) {
    stream.getTracks().forEach(t => t.stop());
    stream = null;
  }
  video.style.display = 'none';
  captureBtn.style.display = 'none';
  stopBtn.style.display = 'none';
  startBtn.style.display = 'inline-block';
});

captureBtn.addEventListener('click', () => {
  if (!stream) return;
  // size canvas to video size
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  // show preview
  snapPreview.innerHTML = '';
  const img = document.createElement('img');
  img.className = 'preview';
  img.src = canvas.toDataURL('image/jpeg');
  snapPreview.appendChild(img);

  // convert to blob and upload via fetch
  canvas.toBlob(async (blob) => {
    const fd = new FormData();
    // name matters: server expects 'photo' in $_FILES
    fd.append('photo', blob, 'capture.jpg');

    try {
      const res = await fetch('', { method: 'POST', body: fd });
      // server returns full HTML (this page). To reflect server response, we reload.
      // you could parse response and show message, but reloading is simpler:
      location.reload();
    } catch (err) {
      alert('Upload failed: ' + err.message);
    }
  }, 'image/jpeg', 0.9);
});
</script>

</body>
</html>
