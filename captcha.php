<?php
session_start();

$permitted_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_string = substr(str_shuffle($permitted_chars), 0, 5);
$_SESSION["vercode"] = $captcha_string;

$width = 120;
$height = 45;
$image = imagecreatetruecolor($width, $height);

// Colors
$bg_color = imagecolorallocate($image, 255, 255, 255);
$line_color = imagecolorallocate($image, 220, 220, 220);
$text_color = imagecolorallocate($image, 10, 82, 255);

imagefill($image, 0, 0, $bg_color);

for ($i = 0; $i < 500; $i++) {
    $dot_color = imagecolorallocate($image, rand(200, 240), rand(200, 240), rand(200, 240));
    imagesetpixel($image, rand(0, $width), rand(0, $height), $dot_color);
}

for ($i = 0; $i < 4; $i++) {
    imagesetthickness($image, rand(1, 2));
    $line_color = imagecolorallocate($image, rand(200, 230), rand(200, 230), rand(200, 230));
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

$font = __DIR__ . '/arial.ttf'; 

if (file_exists($font)) {
    $step = $width / 6;
    for ($i = 0; $i < 5; $i++) {
        $char = $captcha_string[$i];
        $angle = rand(-15, 15);
        $x = 10 + ($i * $step);
        $y = 32;
        imagettftext($image, 20, $angle, $x, $y, $text_color, $font, $char);
    }
} else {
    imagestring($image, 5, 22, 15, $captcha_string, $text_color);
}

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>