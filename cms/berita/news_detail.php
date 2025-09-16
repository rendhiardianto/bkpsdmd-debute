<?php
include "../db.php";

// Check for slug in URL
if (isset($_GET['slug']) && $_GET['slug'] !== '') {
    $slug = $conn->real_escape_string($_GET['slug']);
    $sql  = "SELECT * FROM news WHERE slug = '$slug' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $news = $result->fetch_assoc();
    } else {
        // No news found with this slug
        http_response_code(404);
        echo "<h1>404 - Berita Tidak Ditemukan</h1>";
        exit;
    }
} else {
    // No slug provided
    http_response_code(404);
    echo "<h1>404 - Berita Tidak Ditemukan</h1>";
    exit;
}
?>

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
    Dipublish oleh: <?php echo htmlspecialchars($news['created_by']); ?> | Category: <?php echo $news['category']; ?>
    <br><br><?php echo date("j F Y, H:i", strtotime($news['created_at'])); ?> </div>
   
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
