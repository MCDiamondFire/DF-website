<?php
//* Set Content type to JSON-UTF 8
header('Content-Type: application/json;charset=utf-8');
//* Remove DocType
$fromAPI = true;
//* Require init
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
//* If API key not set
if (!isset($_GET['key'])) {
  //* Output missing API key message
  echo json_encode(array(
    "error" => "No API key set."
  ));
  exit();
} else if (!isset($_GET['uuid'])) {
  //* Output missing UUID message
  echo json_encode(array(
    "error" => "No uuid set."
  ));
  exit();
} else {
  checkKey($_GET['key']);
  checkUUID($_GET['uuid']);
}

function checkKey($key)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT * FROM api_keys WHERE api_key = :key');
  $sth->execute(array(
    "key" => $key
  ));

  if ($sth->rowCount() > 0) {
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result['access_level'] < 4) {
      echo json_encode(array(
        "error" => "Access level too low (" . $result['access_level'] . ")"
      ));
      exit();
    }
  } else {
    echo json_encode(array(
      "error" => "Invalid API key."
    ));
    exit();
  }
}

function checkUUID($uuid)
{
  global $dfPDO;
  $dfPDO->query('use hypercube');
  $sth = $dfPDO->prepare('SELECT * FROM ranks WHERE uuid = :uuid');
  $sth->execute(array(
    "uuid" => $uuid
  ));

  $rowCount = $sth->rowCount();

  $dfPDO->query('use df_website');

  if ($rowCount > 0) {
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array("success" => $result), JSON_NUMERIC_CHECK);
    exit();
  } else {
    echo json_encode(array(
      "error" => "No user found with specified UUID (" . $_GET['uuid'] . ")"
    ));
    exit();
  }
}

?>