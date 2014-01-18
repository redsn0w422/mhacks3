<?php

$im = new Imagick('http://distilleryimage0.s3.amazonaws.com/39d803746b8511e39c23126c29766154_6.jpg');
$im->setImageFormat('pdf');
$im->writeImage('test.pdf);

?>