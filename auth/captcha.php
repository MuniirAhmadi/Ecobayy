<?php
session_start();
$code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION['captcha_code'] = $code;

header("Content-type: image/png");
$image = imagecreate(120, 40);
$bg = imagecolorallocate($image, 255, 255, 255);
$text = imagecolorallocate($image, 0, 0, 0);
imagestring($image, 5, 10, 10, $code, $text);
imagepng($image);
imagedestroy($image);
?>
