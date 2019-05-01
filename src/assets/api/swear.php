<?php
//* Set Content type to JSON-UTF 8
header('Content-Type: application/json;charset=utf-8');
//* Remove DocType
$fromAPI = true;
//* Require init
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
//* If API key not set
if (!isset($_GET['content'])) {
  //* Output missing content message
  echo json_encode(array(
    "error" => "No content passed."
  ));
  exit();
} else {
  if (isset($_GET['returnWords']) && $_GET['returnWords'] == true) {
    $swearDetect = checkSwear($_GET['content'], true);
    if ($swearDetect != false) {
      echo json_encode(array(
        "success" => [
          "curse" => true,
          "wordsFound" => [$swearDetect]
        ]
      ));
    }
  } else {
    $swearDetect = checkSwear($_GET['content']);
    if ($swearDetect != false) {
      echo json_encode(array(
        "success" => [
          "curse" => true
        ]
      ));
    } else {
      echo json_encode(array(
        "success" => [
          "curse" => false
        ]
      ));
    }
  }
}