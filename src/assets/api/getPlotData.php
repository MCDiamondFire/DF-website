<?php
header('Content-Type: application/json;charset=utf-8');
$fromAPI = true;
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (!isset($_GET['username']) || empty($_GET['username'])) {
  echo json_encode(
    array(
      "ERROR" => "NO_USERNAME_SPECIFIED"
    )
  );
} else if (!isset($_GET['plotName']) || empty($_GET['plotName'])) {
  echo json_encode(
    array(
      "ERROR" => "NO_PLOTNAME_SPECIFIED"
    )
  );
} else {
  $sth = $dfPDO->prepare("SELECT * FROM hypercube.plots WHERE owner_name = :ownerName AND name = :plotName");
  $sth->execute(array(
    "ownerName" => $_GET['username'],
    "plotName" => $_GET['plotName']
  ));

  if ($sth->rowCount() == 0) {
    echo json_encode(
      array(
        "ERROR" => "PLOT_NOT_FOUND"
      )
    );
  } else {
    echo json_encode($sth->fetch(PDO::FETCH_ASSOC));
  }
}
?>