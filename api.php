<?php

$url = $_GET['url'];

$im = new Imagick($url);
$im->setImageFormat('pdf');

header('Content-Type: application/pdf');

echo $im;

?>
