<?php
header('Content-Type: application/json;charset=utf-8');
$fromAPI = true;
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (isset($_GET['uuid'])) {
  if (isset($_GET['type'])) {
    if (isset($_GET['version'])) {
      if (isset($_GET['data'])) {
        $sth = $dfPDO->prepare("INSERT INTO dfuAnalytics (type, data, uuid, version) VALUES (:type, :data, :uuid, :version)");
        $sth->execute(array(
          "type" => $_GET['type'],
          "data" => $_GET['data'],
          "uuid" => $_GET['uuid'],
          "version" => $_GET['version']
        ));

        if ($sth) {
          echo json_encode(array(
            "SUCCESS" => "ANALYTIC_UPLOADED"
          ));
        } else {
          echo json_encode(array(
            "ERROR" => "UNKNOWN_ERROR"
          ));
        }
      } else {
        $sth = $dfPDO->prepare("INSERT INTO dfuAnalytics (type, uuid, version) VALUES (:type, :uuid, :version)");
        $sth->execute(array(
          "type" => $_GET['type'],
          "uuid" => $_GET['uuid'],
          "version" => $_GET['version']
        ));

        if ($sth) {
          echo json_encode(array(
            "SUCCESS" => "ANALYTIC_UPLOADED"
          ));
        } else {
          echo json_encode(array(
            "ERROR" => "UNKNOWN_ERROR"
          ));
        }
      }
    } else {
      echo json_encode(array(
        "ERROR" => "NO_VERSION_SPECIFIED"
      ));
    }
  } else {
    echo json_encode(array(
      "ERROR" => "NO_TYPE_SPECIFIED"
    ));
  }
} else {
  echo json_encode(array(
    "ERROR" => "NO_UUID_SPECIFIED"
  ));
}

?>