<?php
include "../db.php";
include "../auth.php";

requireRole(['admin', 'user']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $updateFields = "title='$title', content='$content'";

    // Handle thumbnail update
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbName = uniqid("thumb_") . "." . pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $tmpPath = $_FILES['thumbnail']['tmp_name'];

        list($width, $height) = getimagesize($tmpPath);
        $newWidth = 800;
        $newHeight = 400;

        $src = imagecreatefromstring(file_get_contents($tmpPath));
        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($dst, "uploads/thumbnails/" . $thumbName, 90);

        imagedestroy($src);
        imagedestroy($dst);

        $updateFields .= ", thumbnail='$thumbName'";
    }

    // Handle attachment update
    if (!empty($_FILES['attachment']['name'])) {
        $fileName = uniqid("file_") . "." . pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['attachment']['tmp_name'], "uploads/files/" . $fileName);
        $updateFields .= ", attachment='$fileName'";
    }

    // Update database
    $sql = "UPDATE announcements SET $updateFields WHERE id=$id";

    if ($conn->query($sql)) {
        echo "Pengumuman berhasil diperbarui!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
