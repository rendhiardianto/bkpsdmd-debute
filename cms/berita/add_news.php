<?php
include "../db.php";
include "../auth.php";

requireRole(['admin', 'user']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $created_by = $_SESSION['fullname']; 

    // Upload image
    $imagePath = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    $stmt = $conn->prepare("INSERT INTO news (title, content, image, category, created_by, created_at)
                            VALUES (?, ?, ?, ?, ?, NOW())");
    
    $stmt->bind_param("sssss", $title, $content, $imagePath, $category, $created_by);  

    $stmt->execute();

    header("Location: add_news.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add News</title>
  <style>
    body { font-family: Arial, sans-serif; margin:20px; }
    form { max-width:600px; }
    input, textarea, select { width:100%; padding:10px; margin-bottom:15px; }
    button { padding:10px 15px; background:#003366; color:white; border:none; border-radius:4px; }
  </style>
</head>
<body>

<h2>Add News</h2>
<form action="" method="post" enctype="multipart/form-data">
  <label>Title</label>
  <input type="text" name="title" required>

  <label>Content</label>
  <textarea name="content" rows="8" required></textarea>

  <label>Category</label>
  <input type="text" name="category" required>

  <label>Image</label>
  <input type="file" name="image">

  <button type="submit">Save</button>
</form>

</body>
</html>
