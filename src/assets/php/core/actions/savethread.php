<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (!logged_in()) header('Location: /login');
if (empty($_POST['THID'])) header('Location: /forums/');
if (empty($_POST['name'])) {
  $errors[] .= getLanguageString("enterThreadName");
} else {
  $name = $_POST['name'];
  $checkName = $name;
  $name = htmlentities($name);
  $checkName = str_replace('&nbsp;', '', $checkName);
  $checkName = str_replace(' ', '', $checkName);
  $checkName = preg_replace('/\s+/', '', $checkName);
  $checkName = filter_var($checkName, FILTER_SANITIZE_STRING);
  if (empty($checkName)) {
    $errors[] .= getLanguageString("enterThreadName");
  } elseif (strlen($checkName) < 6) {
    $errors[] .= getLanguageString("threadNameShort");
  } elseif (checkSwear($name)) {
    $errors[] .= getLanguageString("inputContainsCurse");
  } elseif (strlen($checkName) > 32) exit();
}
$description = $_POST['description'];
$checkDescription = $description;
$description = htmlentities($description);
$checkDescription = str_replace('&nbsp;', '', $checkDescription);
$checkDescription = str_replace(' ', '', $checkDescription);
$checkDescription = preg_replace('/\s/', '', $checkDescription);
$checkDescription = filter_var($checkDescription, FILTER_SANITIZE_STRING);
if (checkSwear($checkDescription)) {
  $errors[] .= getLanguageString("inputContainsCurse");
} elseif (strlen($checkDescription) > 32) exit();
if (empty($_POST['content'])) {
  $errors[] .= getLanguageString("enterContent");
} else {
  $content = $_POST['content'];
  $checkContent = $content;
  $checkContent = str_replace('&nbsp;', '', $checkContent);
  $checkContent = str_replace(' ', '', $checkContent);
  $checkContent = preg_replace('/\s+/', '', $checkContent);
  $checkContent = strip_tags($checkContent);
  if (empty($checkContent)) {
    $errors[] .= getLanguageString("enterContent");
  } elseif (strlen($checkContent) < 6) {
    $errors[] .= getLanguageString("threadContentShort");
  }
}

if (empty($errors)) {

  $sth = $dfPDO->prepare('UPDATE threads SET name = :name, description = :description, content = :content WHERE thread_id = :threadID');

  $sth->execute(array(
    'name' => $name,
    'description' => $description,
    'content' => $content,
    'threadID' => $_POST['THID']
  ));
  $_SESSION['header'] = '/forums/ThreadID=' . $_POST['THID'];
  echo success(getLanguageString("threadSaved"));
  ?>
    <meta http-equiv="refresh" content="0">
    <?php

  } else {
    foreach ($errors as $error) {
      echo error($error);
    }
  }

  ?>
