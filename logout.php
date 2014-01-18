<?php
require 'facebook.php';
$facebook = new Facebook(array(
  'appId'  => '1414991652077072',
  'secret' => 'd7f434a8b143b848819e782d7d184645',
));
$facebook->destroySession();
header( "location:index.php" );
?>