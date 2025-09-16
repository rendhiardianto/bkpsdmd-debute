<?php
// upload.php
// Requirements: PHP 7+, enable file uploads, create directory 'uploads/' writable by web server
header('Content-Type: application/json');

$uploadsDir = __DIR__ . '/uploads';
if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0755, true);

function jsonResponse($arr, $status = 200) {
  http_response_code($status);
  echo json_encode($arr);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  jsonResponse(['success' => false, 'error' => 'Method not allowed'], 405);
}

$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$timestamp = isset($_POST['timestamp']) ? trim($_POST['timestamp']) : date('c');
$lat = isset($_POST['lat']) ? trim($_POST['lat']) : null;
$lng = isset($_POST['lng']) ? trim($_POST['lng']) : null;

if (!$name) jsonResponse(['success' => false, 'error' => 'Missing name'], 400);
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
  jsonResponse(['success' => false, 'error' => 'Photo upload failed'], 400);
}

// MIME check
$allowed = ['image/jpeg','image/jpg','image/png'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['photo']['tmp_name']);
if (!in_array($mime, $allowed)) jsonResponse(['success'=>false,'error'=>'Invalid image type'], 400);

// Save file
$ext = $mime === 'image/png' ? 'png' : 'jpg';
$basename = 'att_' . preg_replace('/[^0-9a-zA-Z_-]/','', $name) . '_' . time() . '.' . $ext;
$target = $uploadsDir . '/' . $basename;

if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
  jsonResponse(['success' => false, 'error' => 'Failed to save file'], 500);
}

// DB insert (optional)
$dbHost = 'localhost';
$dbName = 'attendance_db';
$dbUser = 'root';
$dbPass = '';

try {
  $pdo = new PDO(\"mysql:host={$dbHost}; dbname={$dbName}; charset=utf8mb4\", $dbUser, $dbPass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $stmt = $pdo->prepare('INSERT INTO attendance (name, timestamp_iso, lat, lng, photo_path, created_at)
    VALUES (:name, :timestamp_iso, :lat, :lng, :photo_path, NOW())');
  $stmt->execute([
    ':name' => $name,
    ':timestamp_iso' => $timestamp,
    ':lat' => $lat,
    ':lng' => $lng,
    ':photo_path' => 'uploads/' . $basename
  ]);
  $id = $pdo->lastInsertId();
} catch (Exception $e) {
  $id = null; // if DB fails still succeed file upload
  error_log('DB error: ' . $e->getMessage());
}

jsonResponse(['success' => true, 'id' => $id, 'photo' => 'uploads/' . $basename]);
