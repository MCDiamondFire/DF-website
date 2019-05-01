<?php

$fromAPI = true;
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

$montserratBlackItalic = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-BlackItalic.ttf";
$montserratBlack = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Black.ttf";
$montserratExtraBold = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-ExtraBold.ttf";
$montserratExtraBoldItalic = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-ExtraBoldItalic.ttf";
$montserratBold = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Bold.ttf";
$montserratMedium = $_SERVER['DOCUMENT_ROOT'] . "/assets/fonts/Montserrat/Montserrat-Medium.ttf";

if (isset($_GET['username'])) {
  if (strlen($_GET['username']) <= 16) {
    $usernameLength = strlen($_GET['username']);
    $username = utf8_encode(substr($_GET['username'], 0, $usernameLength));
  } else {
    $usernameLength = 16;
    $username = utf8_encode(substr($_GET['username'], 0, $usernameLength));
  }

  $uuid = file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $username);
  $uuid = json_decode($uuid, true);
  $username = $uuid['name'];
  $uuid = $uuid['id'];

  $uuidDashes = substr($uuid, 0, 8) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) . '-' . substr($uuid, 16, 4) . '-' . substr($uuid, 20, 12);

  $dfPDO->query("use hypercube");

  $playerSessionData = $dfPDO->prepare("SELECT * FROM support_sessions WHERE staff = :username");
  $playerSessionData->execute(array(
    'username' => $username
  ));

  $playerSessionsTotal = $playerSessionData->rowCount();
  if ($playerSessionData && $playerSessionsTotal != 0) {
    $playerSessionData = $playerSessionData->fetchAll();

    $playerRank = rank_from_uuid($uuidDashes);

    switch ($playerRank) {
      case "Owner":
        $highlightColor = [30, 30, 30];
        $backgroundColor = [180, 10, 10];
        $labelColor = [200, 30, 30];
        break;
      case "Admin":
        $highlightColor = [245, 41, 41];
        $backgroundColor = [225, 21, 21];
        break;
      case "Mod":
        $backgroundColor = [12, 192, 100];
        $highlightColor = [32, 212, 120];
        break;
      case "JrMod":
        $backgroundColor = [12, 192, 100];
        $highlightColor = [32, 212, 120];
        break;
      case "Emeritus":
        $backgroundColor = [48, 44, 207];
        $labelColor = [68, 64, 227];
        $highlightColor = [243, 140, 15];
        break;
      case "Expert":
        $backgroundColor = [221, 176, 0];
        $highlightColor = [241, 196, 15];
        break;
      case "Helper":
        $backgroundColor = [58, 131, 235];
        $highlightColor = [78, 151, 255];
        break;
      case "JrHelper":
        $backgroundColor = [58, 131, 235];
        $highlightColor = [78, 151, 255];
        break;
      case "Retired Staff":
        $backgroundColor = [97, 92, 232];
        $highlightColor = [77, 72, 212];
        break;
      default:
        $backgroundColor = [68, 68, 68];
        $highlightColor = [80, 80, 80];
        break;
    }

    $uniqueSessions = array();
    $totalSessionTime = 0;
    $totalSessionsMonth = 0;

    foreach ($playerSessionData as $sessionRow) {
      if (!in_array($sessionRow['name'], $uniqueSessions)) {
        array_push($uniqueSessions, $sessionRow['name']);
      }

      $totalSessionTime = $totalSessionTime + $sessionRow['duration'];

      if (strtotime("-5 hours -47 minutes -1 month") <= strtotime($sessionRow['time'])) {
        $totalSessionsMonth++;
      }
    }

    if ($totalSessionsMonth == 0) $totalSessionsMonth = "None";
    if ($totalSessionTime == 0) $totalSessionTime = "None";
    else $totalSessionTime = formatMilliseconds($totalSessionTime);

    $image = imagecreatetruecolor(700, 200);

    $background = imagecolorallocate($image, $backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);

    $foreground = imagecolorallocate($image, 255, 255, 255);

    $highlight = imagecolorallocate($image, $highlightColor[0], $highlightColor[1], $highlightColor[2]);

    imagesavealpha($image, true);
    imagefill($image, 0, 0, $background);

    $avatar = imagecreatefrompng("http://crafatar.com/renders/head/" . $uuid . "?overlay=true&scale=5");

    if (isset($labelColor)) $label = imagecolorallocate($image, $labelColor[0], $labelColor[1], $labelColor[2]);

    imagefilledellipse($image, 75, 75, 125, 125, $highlight);

    imagefilledrectangle($image, 0, imagesy($image), imagesx($image), 160, $highlight);

    imagecopymerge_alpha($image, $avatar, 26, 28, 0, 0, imagesx($avatar), imagesy($avatar), 100);

    $labelText = "VerifyBot";

    $patch = $_GET['patch'];

    $patchCoordinates = imagettfbbox(15, 0, $montserratExtraBold, "V" . $patch);
    $patchX = $labelX = imagesx($image) - $patchCoordinates[4] - 10;

    $labelCordinates = imagettfbbox(15, 0, $montserratBlackItalic, $labelText);
    $labelX = imagesx($image) - $labelCordinates[4] - 10;
    $labelY = $labelCordinates[3] - $labelCordinates[5] + 5;
    if (isset($label)) {
      imagettftext($image, 15, 0, $labelX, $labelY, $label, $montserratBlackItalic, $labelText);
      imagettftext($image, 15, 0, $patchX, 45, $label, $montserratExtraBold, "V" . $patch);
    } else {
      imagettftext($image, 15, 0, $labelX, $labelY, $highlight, $montserratBlackItalic, $labelText);
      imagettftext($image, 15, 0, $patchX, 45, $highlight, $montserratExtraBold, "V" . $patch);
    }

    imagettftext($image, 15, 0, 175, 40, $foreground, $montserratBlackItalic, "Total sessions");
    imagettftext($image, 15, 0, 175, 65, $foreground, $montserratMedium, $playerSessionsTotal);

    if ($playerRank == "Retired Staff" || $playerRank == "Emeritus") {
      $sessionTimeY = 40;

      $individualPlayersTTFBox = imagettfbbox(15, 0, $montserratBlackItalic, "Individual Players");
      $individualPlayersX = abs(imagesx($image) / 2) - abs(($individualPlayersTTFBox[4] - $individualPlayersTTFBox[1]) / 2);
    } else {
      $sessionTimeY = 105;
      $individualPlayersX = 175;
      imagettftext($image, 15, 0, 400, 40, $foreground, $montserratBlackItalic, "This month");
      imagettftext($image, 15, 0, 400, 65, $foreground, $montserratMedium, $totalSessionsMonth);
    }

    imagettftext($image, 15, 0, $individualPlayersX, 105, $foreground, $montserratBlackItalic, "Individual Players");
    imagettftext($image, 15, 0, $individualPlayersX, 130, $foreground, $montserratMedium, count($uniqueSessions));

    imagettftext($image, 15, 0, 400, $sessionTimeY, $foreground, $montserratBlackItalic, "Session Time");
    imagettftext($image, 15, 0, 400, $sessionTimeY + 25, $foreground, $montserratMedium, $totalSessionTime);


    imagettftext($image, 20, 0, 10, 190, $foreground, $montserratExtraBoldItalic, utf8_decode($username));

    $rankTextCenter = imagettfbbox(15, 0, $montserratExtraBold, $playerRank);
    imagettftext($image, 15, 0, abs(imagesx($image) / 2) - abs(($rankTextCenter[4] - $rankTextCenter[1]) / 2), 187, $foreground, $montserratBold, $playerRank);

    $dateLabelCoordinates = imagettfbbox(15, 0, $montserratBold, date("M d, y"));
    $dateLabelX = imagesx($image) - $dateLabelCoordinates[4] - 10;
    $dateLabelY = imagesy($image) - $dateLabelCoordinates[3] - 10;
    imagettftext($image, 15, 0, $dateLabelX, $dateLabelY, $foreground, $montserratBold, date("M d, y"));

  } else {
    $image = imagecreate(500, 75);

    $highlight = imagecolorallocate($image, 80, 80, 80);

    $background = imagecolorallocate($image, 68, 68, 68);

    $foreground = imagecolorallocate($image, 255, 255, 255);

    imagefill($image, 0, 0, $background);

    imagefilledrectangle($image, 0, 75, 500, 40, $highlight);

    imagettftext($image, 15, 0, 385, 25, $highlight, $montserratBlackItalic, "VerifyBot");

    $dateLabelCoordinates = imagettfbbox(15, 0, $montserratBlackItalic, date("M d, y"));
    $dateLabelX = imagesx($image) - $dateLabelCoordinates[4] - 10;
    $dateLabelY = imagesy($image) - $dateLabelCoordinates[3] - 7;
    imagettftext($image, 15, 0, $dateLabelX, $dateLabelY, $foreground, $montserratExtraBold, date("M d, y"));

    imagettftext($image, 20, 0, 10, 25, $foreground, $montserratBlackItalic, substr(utf8_decode($_GET['username']), 0, $usernameLength));


    $sth = $dfPDO->prepare("SELECT support FROM ranks WHERE uuid = :uuid");
    $sth->execute(array(
      'uuid' => $uuidDashes
    ));

    if ($sth->rowCount() == 1 && $sth->fetch(PDO::FETCH_COLUMN) >= 1) {
      imagettftext($image, 15, 0, 10, 65, $foreground, $montserratExtraBold, "has not done any sessions.");
    } else {
      imagettftext($image, 15, 0, 10, 65, $foreground, $montserratExtraBold, "is not a supporter.");
    }
  }
}

header("Content-type: image/png");
imagepng($image);

$dfPDO->query("use df_website");
exit();

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{ 
// creating a cut resource 
  $cut = imagecreatetruecolor($src_w, $src_h); 

// copying relevant section from background to the cut resource 
  imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 

// copying relevant section from watermark to the cut resource 
  imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 

// insert cut resource to destination image 
  imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

function formatMilliseconds($milliseconds)
{
  $seconds = floor($milliseconds / 1000);
  $minutes = floor($seconds / 60);
  $hours = floor($minutes / 60);
  $days = floor($hours / 24);
  $hours = $hours - ($days * 24);
  $milliseconds = $milliseconds % 1000;
  $seconds = $seconds % 60;
  $minutes = $minutes % 60;

  if ($days != 0) $days = $days . "d ";
  else $days = "";
  if ($hours != 0) $hours = $hours . "h ";
  else $hours = "";
  if ($minutes != 0) $minutes = $minutes . "m ";
  else $minutes = "";
  $time = $days . $hours . $minutes . $seconds . "s";
  return rtrim($time, '0');
}
?>