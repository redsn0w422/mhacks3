<?php
// https://github.com/cosenary/Instagram-PHP-API

require 'instagram.class.php';

// initialize class
$instagram = new Instagram(array(
  'apiKey'      => '359a0cb55e014c2a853b77fed4769564',
  'apiSecret'   => 'a03c4453898846abbdadca739b4c1dde',
  'apiCallback' => 'http://yashamostofi.com/drinkspls/insta/callback.php'
));

// create login URL
$loginUrl = $instagram->getLoginUrl();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - OAuth Login</title>
    <style>
      .login {
        display: block;
        font-size: 20px;
        font-weight: bold;
        margin-top: 50px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <header class="clearfix">
        <h1>Instagram <span>display your photo stream</span></h1>
      </header>
      <div class="main">
        <ul class="grid">
          <li>
            <a class="login" href="<? echo $loginUrl ?>">Login with Instagram</a>
            <h>Use your Instagram account to login.</h4>
          </li>
        </ul>
      </div>
    </div>
  </body>
</html>
