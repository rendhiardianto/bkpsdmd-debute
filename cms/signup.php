<?php include "db.php"; ?>

<?php
// Load PHPMailer classes manually (no Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nip = $conn->real_escape_string($_POST['nip']);
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profilePic = null;

    $profilePic = "default.png"; // default if no upload

    if (!empty($_FILES['profile_pic']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 1 * 1024 * 1024; // 1MB

        $fileTmp  = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileSize = $_FILES['profile_pic']['size'];
        $fileType = mime_content_type($fileTmp);

        // Validate type
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('❌ Hanya file JPG atau PNG yang diperbolehkan!'); window.location='signup.php';</script>";
            exit();
        }

        // Rename file → nip_fullname.jpg
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $safeFullname = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fullname);
        $newFileName = $nip . "_" . $safeFullname . "." . $ext;
        $uploadPath = __DIR__ . "/uploads/profile_pics/" . $newFileName;

        // Create image resource
        if ($fileType == 'image/jpeg') {
            $src = imagecreatefromjpeg($fileTmp);
        } elseif ($fileType == 'image/png') {
            $src = imagecreatefrompng($fileTmp);
        }

        // Resize all images to 400x400 (crop center if needed)
        $width = imagesx($src);
        $height = imagesy($src);
        $newWidth = 400;
        $newHeight = 600;

        $tmp = imagecreatetruecolor($newWidth, $newHeight);

        // Keep transparency for PNG
        if ($fileType == 'image/png') {
            imagealphablending($tmp, false);
            imagesavealpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Crop and resize (center crop)
        $minSide = min($width, $height);
        $srcX = ($width - $minSide) / 2;
        $srcY = ($height - $minSide) / 2;

        imagecopyresampled(
            $tmp, $src,
            0, 0, $srcX, $srcY,
            $newWidth, $newHeight,
            $minSide, $minSide
        );

        // Save compressed image
        if ($fileType == 'image/jpeg') {
            imagejpeg($tmp, $uploadPath, 70); // quality 70%
        } elseif ($fileType == 'image/png') {
            imagepng($tmp, $uploadPath, 7); // compression 0-9
        }

        imagedestroy($src);
        imagedestroy($tmp);

        // Double check size, if still >1MB → reduce quality more
        if (filesize($uploadPath) > $maxSize && $fileType == 'image/jpeg') {
            imagejpeg(imagecreatefromjpeg($uploadPath), $uploadPath, 60);
        }

        $profilePic = $newFileName;
    }


    // Validate NIP format (must be 18 digits numeric)
    if (!preg_match('/^[0-9]{18}$/', $nip)) {
    echo "<script>alert('NIP terdiri dari 18 angka.'); window.location='signup.php';</script>";
    exit();
    }
    
    // check if NIP already exists
    $checkNip = $conn->query("SELECT id FROM users WHERE nip='$nip'");
    if ($checkNip->num_rows > 0) {
        echo "<script>alert('NIP sudah terdaftar, silahkan login!'); window.location='index.php';</script>";
        exit();
    }

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    $token = bin2hex(random_bytes(16));
    if ($check->num_rows > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";}
    else {
        $token = bin2hex(random_bytes(16)); // email verification token

        $sql = "INSERT INTO users (nip, fullname, email, password, profile_pic, role, verified, verify_token)
        VALUES ('$nip', '$fullname', '$email', '$password', '$profilePic', 'user', 0, '$token')";

        if ($conn->query($sql)) {

            // ✅ Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bkd.merangin@gmail.com';  // 🔹 replace with your Gmail
                $mail->Password = 'dlmh zkgz awku aokg';   // 🔹 use Gmail App Password (not normal password!)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('yourgmail@gmail.com', 'BKPSDMD Merangin');
                $mail->addAddress($email, $fullname);

                // Content
                $verifyLink = "http://localhost/bkpsdmd-cms/cms/verify.php?token=$token";
                $mail->isHTML(true);
                $mail->Subject = "Verifkasi email Anda";
                $mail->Body = "Halo #KantiASN, <br>
                              Dear $fullname,<br><br>Mohon untuk verifikasi email anda terlebih dahulu, dengan klik link berikut ini: <br><br>
                              <a href='$verifyLink'>$verifyLink</a><br><br>

                              Ikan hiu dikejar macan tutul.<br>
                              We love you full.<br><br>

                              Best Regards,<br>Tim PUSDATIN BKPSDMD Kab. Merangin";

                $mail->send();
                echo "<script>alert('Cek email akun Gmail #KantiASN untuk verifikasi!'); window.location='index.php'; </script>";
            } catch (Exception $e) {
                echo "<script>alert('Mailer Error: {$mail->ErrorInfo}');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign up for CMS Account</title>
  <link href="signup.css" rel="stylesheet">
  <link rel="shortcut icon" href="images/button/logo2.png">
</head>

<body>

<div class="flex-container">

  <div class="form-box">
    <h2>Daftar Akun CMS</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="nip" placeholder="Nomor Induk Pegawai (NIP)" required>
      <input type="text" name="fullname" placeholder="Nama Lengkap" required>
      <input type="email" name="email" placeholder="Alamt Email" required>
      <input type="password" name="password" placeholder="Kata Sandi" required>
      <p>Upload Foto Profil<br>
      <input class="input-group" type="file" name="profile_pic" accept="image/*"/><p></p>
      <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun CMS? <a href="index.php">Masuk</a></p>
  </div>

  <div class="flex-background">

  </div>

</div>

</body>
</html>