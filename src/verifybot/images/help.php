<?php

$fromAPI = true;
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

$montserratBlackItalic = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-BlackItalic.ttf";
$montserratBlack = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Black.ttf";
$montserratExtraBold = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-ExtraBold.ttf";
$montserratExtraBoldItalic = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-ExtraBoldItalic.ttf";
$montserratBold = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Bold.ttf";
$montserratMedium = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Medium.ttf";

if (isset($_GET['categories'])) {
  $categories = json_decode($_GET['categories'], true);

  $imageHeight = 50;

  foreach ($categories as $row) {
    $imageHeight = $imageHeight + 35;
  }

  $image = imagecreatetruecolor(400, 75 + $imageHeight);

  $background = imagecolorallocate($image, 68, 68, 68);

  $foreground = imagecolorallocate($image, 255, 255, 255);

  $lightGray = imagecolorallocate($image, 200, 200, 200);

  $highlight = imagecolorallocate($image, 80, 80, 80);

  imagefill($image, 0, 0, $background);


  $rowCount = 1;
  foreach ($categories as $row) {
    imagettftext($image, 15, 0, 20, 65 + 35 * $rowCount, $lightGray, $montserratExtraBold, "> " . $row);
    $rowCount++;
  }

  $queueLabelCoordinates = imagettfbbox(20, 0, $montserratBlackItalic, "Help Categories");
  $queueLabelCoordinatesX = abs(imagesx($image) / 2) - abs(($queueLabelCoordinates[4] - $queueLabelCoordinates[1]) / 2);
  imagettftext($image, 20, 0, $queueLabelCoordinatesX, 60, $foreground, $montserratBlack, "Help Categories");

  imagettftext($image, 15, 0, 285, 25, $highlight, $montserratBlackItalic, "VerifyBot");

  imagettftext($image, 15, 0, 10, 25, $highlight, $montserratExtraBold, "V" . $_GET['patch']);

  imagefilledrectangle($image, 0, imagesy($image), imagesx($image), imagesy($image) - 40, $highlight);

  imagettftext($image, 15, 0, 10, imagesy($image) - 13, $foreground, $montserratExtraBoldItalic, $_GET['requester']);

  $dateLabelCoordinates = imagettfbbox(15, 0, $montserratBold, date("M d, y"));
  $dateLabelX = imagesx($image) - $dateLabelCoordinates[4] - 10;
  $dateLabelY = imagesy($image) - $dateLabelCoordinates[3] - 10;
  imagettftext($image, 15, 0, $dateLabelX, $dateLabelY, $foreground, $montserratBold, date("M d, y"));
} else if (isset($_GET['commands'])) {
  $categories = json_decode($_GET['commands'], true);

  $imageHeight = 50;

  foreach ($categories as $row) {
    $imageHeight = $imageHeight + 45;
    $imageHeight = $imageHeight + (15 * count($row['description']));
  }

  $image = imagecreatetruecolor(400, 75 + $imageHeight);

  $background = imagecolorallocate($image, 68, 68, 68);

  $foreground = imagecolorallocate($image, 255, 255, 255);

  $lightGray = imagecolorallocate($image, 200, 200, 200);

  $highlight = imagecolorallocate($image, 80, 80, 80);

  imagefill($image, 0, 0, $background);

  $queueLabelCoordinates = imagettfbbox(20, 0, $montserratBlackItalic, $_GET['category']);
  $queueLabelCoordinatesX = abs(imagesx($image) / 2) - abs(($queueLabelCoordinates[4] - $queueLabelCoordinates[1]) / 2);
  imagettftext($image, 20, 0, $queueLabelCoordinatesX, 60, $foreground, $montserratBlack, $_GET['category']);

  imagettftext($image, 15, 0, 285, 25, $highlight, $montserratBlackItalic, "VerifyBot");

  imagettftext($image, 15, 0, 10, 25, $highlight, $montserratExtraBold, "V" . $_GET['patch']);

  $commandNameOffsetY = 100;
  $commandDescriptionOffsetY = 125;
  foreach ($categories as $row) {
    imagettftext($image, 15, 0, 15, $commandNameOffsetY, $lightGray, $montserratExtraBoldItalic, $row['name']);

    $commandDescriptionInitalOffsetY = 0;
    foreach ($row['description'] as $descRow) {
      imagettftext($image, 15, 0, 15, $commandDescriptionOffsetY + $commandDescriptionInitalOffsetY, $lightGray, $montserratMedium, $descRow);
      $commandDescriptionInitalOffsetY = $commandDescriptionInitalOffsetY + 20;
    }
    $commandNameOffsetY = $commandNameOffsetY + 45 + (15 * count($row['description']));
    $commandDescriptionOffsetY = $commandDescriptionOffsetY + 45 + (15 * count($row['description']));
    $firstRow = false;
  }

  imagefilledrectangle($image, 0, imagesy($image), imagesx($image), imagesy($image) - 40, $highlight);

  imagettftext($image, 15, 0, 10, imagesy($image) - 13, $foreground, $montserratExtraBoldItalic, $_GET['requester']);

  $dateLabelCoordinates = imagettfbbox(15, 0, $montserratBold, date("M d, y"));
  $dateLabelX = imagesx($image) - $dateLabelCoordinates[4] - 10;
  $dateLabelY = imagesy($image) - $dateLabelCoordinates[3] - 10;
  imagettftext($image, 15, 0, $dateLabelX, $dateLabelY, $foreground, $montserratBold, date("M d, y"));
}

header("Content-type: image/png");
imagepng($image);

?>