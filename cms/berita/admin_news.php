<?php
session_start();

include "../db.php";
include "../auth.php";

requireRole(['admin', 'user']);


// (Optional) check if admin logged in
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: login.php"); exit; }

$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - News</title>
  <meta name="google-site-verification" content="e4QWuVl6rDrDmYm3G1gQQf6Mv2wBpXjs6IV0kMv4_cM" />
  <link rel="shortcut icon" href="../images/button/logo2.png">
  <link href="admin_news.css" rel="stylesheet" type="text/css">

</head>
<body>

  <div class="header">
    <div class="navbar">
      <button onclick="window.history.back()" class="buttonBack">&#10094; Kembali</button>
    </div>
    <div class="roleHeader">
      <h1>Dashboard Berita</h1>
    </div>
  </div>
  
  <div class="topbar">
      <a href="add_news.php" class="button add">+ Tambah Berita Baru</a>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Category</th>
      <th>Created</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['title']; ?></td>
      <td><?php echo $row['category']; ?></td>
      <td><?php echo $row['created_at']; ?></td>
      <td>
        <a href="edit_news.php?id=<?php echo $row['id']; ?>" class="button edit">Edit</a>
        <a href="delete_news.php?id=<?php echo $row['id']; ?>" class="button red" onclick="return confirm('Delete this news?');">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>

<div class="footer">
    <p>Copyright &copy; 2025. Tim PUSDATIN - BKPSDMD Kabupaten Merangin.</p>
</div>

</body>
</html>
