<?php
include "../auth.php";
requireRole(['admin', 'user']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM transparansi WHERE id=$id";
    if ($conn->query($sql)) {
        echo "🗑️ Dokumen sudah dihapus!";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>
