<?php
include "../db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard_admin_cms.php");
    exit();
}

$id = intval($_GET['id']);
$conn->query("DELETE FROM users WHERE id=$id");
echo "<script>alert('User deleted!'); window.location='dashboard_admin_cms.php';</script>";
?>
