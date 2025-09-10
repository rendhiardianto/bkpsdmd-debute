<?php
include "../db.php";

$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM news WHERE id=$id");
$news = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $imagePath = $news['image']; // keep old image

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    $stmt = $conn->prepare("UPDATE news SET title=?, content=?, category=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $content, $category, $imagePath, $id);
    $stmt->execute();

    header("Location: admin_news.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit News</title>
  <style>
    body { font-family: Arial, sans-serif; margin:20px; }
    form { max-width:600px; }
    input, textarea, select { width:100%; padding:10px; margin-bottom:15px; }
    button { padding:10px 15px; background:#003366; color:white; border:none; border-radius:4px; }
  </style>
</head>
<body>

<h2>Edit News</h2>
<form action="" method="post" enctype="multipart/form-data">
  <label>Title</label>
  <input type="text" name="title" value="<?php echo $news['title']; ?>" required>

  <label>Content</label>
  <textarea name="content" rows="8" required><?php echo $news['content']; ?></textarea>

  <label>Category</label>
  <input type="text" name="category" value="<?php echo $news['category']; ?>" required>

  <label>Image</label>
  <input type="file" name="image">
  <p>Current: <img src="<?php echo $news['image']; ?>" width="120"></p>

  <button type="submit">Update</button>
</form>

</body>
</html>
