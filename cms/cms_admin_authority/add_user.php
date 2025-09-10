<?php include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $nip    = $conn->real_escape_string($_POST['nip']);
    $jabatan    = $conn->real_escape_string($_POST['jabatan']);
    $divisi    = $conn->real_escape_string($_POST['divisi']);

    $cek = mysqli_query($conn, "SELECT * FROM data_pegawai WHERE nip='$nip'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "";
        ?><script>
                alert('NIP Sudah terdaftar di database.');
                window.location.href='add_user.php';
        </script><?php
    } else {
        $insert = mysqli_query($conn, "INSERT INTO data_pegawai (nip, fullname, jabatan, divisi)
        VALUES ('$nip','$fullname','$jabatan', '$divisi')");
          if ($insert) {
            $success = "";
            ?><script>
                alert('Data sudah ditambahakan.');
                window.location.href='add_user.php';
            </script><?php
          } 
          else {
            $errMSG = "" . mysqli_error($conn);
            ?><script>
                alert('Maaaf, terjadi kesalahan, silahkan ulangi kembali');
                window.location.href='add_user.php';
        </script><?php
          }
        }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Add User</title>
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link href="add_user.css" rel="stylesheet">
  <link rel="shortcut icon" href="/images/button/logo.png">

  

</head>
<body>

<div class="header">
    <div class="navbar">
      <a href="../dashboard_super_admin.php" style="text-decoration: none; color:white;">&#10094; Kembali</a>
    </div>
    <div class="roleHeader">
      <h1>Dashboard Add CMS User</h1>
    </div>
</div>

<div class="flex-container">

  <div class="form-box">
    <h2>Tambahkan User Baru</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="nip" placeholder="Nomor Induk Pegawai (NIP)" required>
      <input type="text" name="fullname" placeholder="Nama Lengkap" required>
      <input type="text" name="jabatan" placeholder="Jabatan" required>
      <select type="text" name="divisi">
        <option value="">(Pilih Divisi)</option>
         <option value="SEKRETARIAT">SEKRETARIAT</option>
         <option value="BIDANG KEPEGAWAIAN">BIDANG KEPEGAWAIAN</option>
         <option value="BIDANG PENGEMBANGAN SDM">BIDANG PENGEMBANGAN SDM</option>
      </select>

      <button type="submit">Tambahkan</button>
    </form>
  </div>

</div>

<div class="footer">
    <p>Copyright &copy; 2025. Tim PUSDATIN - BKPSDMD Kabupaten Merangin.</p>
</div>

</body>
</html>