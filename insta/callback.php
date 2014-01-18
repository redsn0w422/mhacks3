<?php

session_start();
require_once 'Instagram.php';

$config = array(
	'client_id' => '359a0cb55e014c2a853b77fed4769564',
	'client_secret' => 'a03c4453898846abbdadca739b4c1dde',
	'grant_type' => 'authorization_code',
	'redirect_uri' => 'http://yashamostofi.com/drinkspls/insta/callback.php'
);

// Instantiate the API handler object
$instagram = new Instagram($config);
$accessToken = $instagram->getAccessToken();
$_SESSION['InstagramAccessToken'] = $accessToken;

$instagram->setAccessToken($_SESSION['InstagramAccessToken']);
$popular = $instagram->getPopularMedia();

// After getting the response, let's iterate the payload
$response = json_decode($popular, true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<title>Instagram API PHP Implementation demo // Popular Media</title>
</head>

<body>

<h1>Popular Media</h1>

<?
    foreach ($response['data'] as $data) {
        $link = $data['link'];
        $id = $data['id'];
        $caption = $data['caption']['text'];
        $author = $data['caption']['from']['username'];
        $thumbnail = $data['images']['thumbnail']['url'];
    ?>
    <div class="photo">
        <a href="pic.php?id=<?= $id ?>"><span></span><img src="<?= $thumbnail ?>" title="<?= htmlentities($caption) ?>" alt="<?= htmlentities($caption) ?>" /></a>
    </div>
    <?
   }
?>

<p class="footer"><a href="http://www.webdesignerwall.com/tutorials/css-decorative-gallery/">www.webdesignerwall.com/tutorials/css-decorative-gallery/</a></p>

</body>
</html>
<?php die(); ?>
