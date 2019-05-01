<?php
// MAKE IT WORK
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (isset($_SESSION['plotID']) && permLevel() > 0) {
  $plotID = $_SESSION['plotID'];

  if (getPlotOwner($plotID) == $user_data['username']) {
    if (isset($_POST['imagebase64'])) {
      $data = $_POST['imagebase64'];

      list($type, $data) = explode(';', $data);
      list(, $data) = explode(',', $data);
      $data = base64_decode($data);
      file_put_contents($root . "/assets/images/plotImages/" . $_SESSION['plotID'] . '.png', $data);
      list($width, $height) = getimagesize($root . "/assets/images/plotImages/" . $_SESSION['plotID'] . '.png');
      if ($width <= 350 && $height <= 250) {
        $plot = $dfPDO->prepare('UPDATE trendingPlots SET image = :image WHERE plotID = :plotID');

        $plot->execute(array(
          'image' => 'plotImages/' . $_SESSION['plotID'] . '.png',
          'plotID' => $_SESSION['plotID']
        ));
      } else {
        echo error("Image too big. (max width 350px, max height 250)");
        unlink($root . "/assets/images/plotImages/" . $_SESSION['plotID'] . '.png');
      }
    }

    if (!isset($_POST['description'])) {
      $plotDescription = "";
    } else {
      $plotDescription = $_POST['description'];
    }

    $plotDescription = trim($plotDescription);

    if ($plotDescription == "") $plotDescription = null;

    $plot = $dfPDO->prepare('UPDATE trendingPlots SET description = :description WHERE plotID = :plotID');
    $plot->execute(array(
      'description' => $plotDescription,
      'plotID' => $plotID
    ));

    echo success("Changes saved");
  }
}


?>