<?php
include "../db.php";

if (!isset($_GET['id'])) {
    // No id → redirect back to news list
    header("Location: news.php");
    exit;
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM news WHERE id=$id");

if ($result->num_rows == 0) {
    // News not found → show 404 page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Berita Tidak Ditemukan</title>
  <style>
        body { 
          font-family: Arial, sans-serif; 
          background:#f5f5f5; 
          margin:0; padding:0; 
          display:flex; justify-content:center; align-items:center; 
          height:100vh; text-align:center; 
        }
        .error-box {
          background:white; padding:40px; border-radius:8px; 
          box-shadow:0 2px 8px rgba(0,0,0,0.2); 
        }
        h1 { font-size:48px; margin:0; color:#cc0000; }
        p { font-size:16px; color:#555; }
        a {
          display:inline-block; margin-top:20px; 
          text-decoration:none; background:#003366; 
          color:white; padding:10px 20px; border-radius:5px;
        }
        a:hover { background:#0055aa; }
  </style>
</head>
<body>
  <div class="error-box">
    <h1>404</h1>
    <p>Maaf, artikel berita yang anda cari tidak tersedia.</p>
    <a href="../news.php">Back to News</a>
  </div>
</body>
</html>

<?php exit;} $news = $result->fetch_assoc(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $news['title']; ?></title>
  <link href="news_detail.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="article">
  <h1><?php echo $news['title']; ?></h1>
  <div class="meta">
    Diunggah oleh: <?php echo htmlspecialchars($news['created_by']); ?> , 
    <?php echo date("j F Y, H:i", strtotime($news['created_at'])); ?> 
   | Category: <?php echo $news['category']; ?></div>
  <img src="<?php echo $news['image']; ?>" alt="">
  <p><?php echo nl2br($news['content']); ?></p>
</div>
<!------------------- FOOTER ----------------------------------->	
	
<div class="row">
  <div class="column first">
		<img src="/icon/BKPLogo.png" alt="Logo BKPSDMD">
	  <p style="text-align: center">Copyright © 2025.</p>
	  <p style="text-align: center">Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Daerah (BKPSDMD) Kabupaten Merangin.</p> 
	  <p style="text-align: center">All Rights Reserved</p>
  </div>
	
  <div class="column second">
		<h3>Butuh Bantuan?</h3>
	  
		<p><a href="https://maps.app.goo.gl/idAZYTHVszUhSGRv8" target="_blank" class="Loc">
			<img src="/icon/sosmed/Loc.png" alt="Logo Loc" width="30px" style="float: left"></a> 
			Jl. Jendral Sudirman, No. 01, Kel. Pematang Kandis, Kec. Bangko, Kab. Merangin, Prov. Jambi - Indonesia | Kode Pos - 37313</p>
	  
		<p><a href="https://wa.me/6285159997813" target="_blank" class="wa">
			<img src="/icon/sosmed/WA.png" alt="Logo WA" width="30px" style="vertical-align:middle"></a> 
			+62851 5999 7813</p>
	  
		<p><a href="https://wa.me/6285159997813" target="_blank" class="em">
			<img src="/icon/sosmed/EM.png" alt="Logo Email" width="30px" style="vertical-align:middle"></a> 
			bkd.merangin@gmail.com</p>
  </div>
	
  <div class="column third">
		<h3>Follow Sosial Media Kami!</h3>
		  <a href="https://www.instagram.com/bkpsdmd.merangin/?hl=en" target="_blank" class="ig"><img src="/icon/sosmed/IG.png" alt="Logo IG"></a>
	  
		  <a href="https://www.youtube.com/@bkpsdmd.merangin" target="_blank" class="yt"><img src="/icon/sosmed/YT.png" alt="Logo YT"></a>
	  
		  <a href="https://www.facebook.com/bkpsdmd.merangin/" target="_blank" class="fb"><img src="/icon/sosmed/FB.png" alt="Logo FB"></a>
	  
		  <a href="https://x.com/bkpsdmdmerangin?t=a7RCgFHif89UfeV9aALj8g&s=08" target="_blank" class="x"><img src="/icon/sosmed/X.png" alt="Logo X"></a>
	  
		  <a href="https://www.tiktok.com/@bkpsdmd.merangin?_t=ZS-8z3dFdtzgYy&_r=1 " target="_blank" class="tt"><img src="/icon/sosmed/TT.png" alt="Logo TT"></a>
  </div>
  <div class="column fourth">
		<h3>Kunjungan Website</h3>
		<p>Hari Ini</p>
		<p>Total</p>
	  
	  	
	  <img src="/icon/BerAkhlak.png" alt="Logo BerAkhlak">
	  
  </div>
</div>
</body>
</html>
