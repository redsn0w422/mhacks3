<?php

require_once 'Instagram.php';

$config = array(
	'client_id' => '359a0cb55e014c2a853b77fed4769564',
	'client_secret' => 'a03c4453898846abbdadca739b4c1dde',
	'grant_type' => 'authorization_code',
	'redirect_uri' => 'http://yashamostofi.com/drinkspls/insta/callback.php'
);

session_start();

if (isset($_SESSION['InstagramAccessToken']) && !empty($_SESSION['InstagramAccessToken']))
{
	header('Location: callback.php');
	die();
}

$instagram = new Instagram($config);
$accessToken = $instagram->getAccessToken();
$_SESSION['InstagramAccessToken'] = $accessToken;

$instagram->setAccessToken($_SESSION['InstagramAccessToken']);
$instagram->openAuthorizationUrl();
?>
