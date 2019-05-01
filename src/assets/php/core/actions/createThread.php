<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (!logged_in()) header('Location: /login');
if (empty($_POST['FID'])) header('Location: /forums/');
if (empty($_POST['name'])) {
  $errors[] .= getLanguageString("enterThreadName");
} else {
  $name = $_POST['name'];
  $checkName = $name;
  $name = htmlentities($name);
  $checkName = str_replace('&nbsp;', '', $checkName);
  $checkName = str_replace(' ', '', $checkName);
  $checkName = preg_replace('/\s/', '', $checkName);
  $checkName = filter_var($checkName, FILTER_SANITIZE_STRING);
  if (empty($checkName)) {
    $errors[] .= getLanguageString("enterThreadName");
  } elseif (strlen($checkName) < 6) {
    $errors[] .= getLanguageString("threadNameShort");
  } elseif (checkSwear($checkName)) {
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
} else { //if(!checkSwear($_POST['content'])) {
  $content = $_POST['content'];
  $checkContent = $content;
  $checkContent = str_replace('&nbsp;', '', $checkContent);
  $checkContent = str_replace(' ', '', $checkContent);
  $checkContent = preg_replace('/\s+/', '', $checkContent);
  $checkContent = strip_tags($checkContent);
  if (empty($checkContent)) {
    $errors[] .= getLanguageString("enterContent");
  } elseif (strlen($checkContent) < 6) {
    $errors[] .= getLanguageString("threadNameShort");
  }
  if (checkSwear($checkContent)) {
    $errors[] .= getLanguageString("inputContainsCurse");
  }
}

if (empty($errors)) {

  $fid = $_POST['FID'];
  $creator = $user_data['user_id'];

  $sth = $dfPDO->prepare('INSERT INTO threads (name, description, content, creator, created, forum_id) VALUES (:name, :description, :content, :creator, :created, :forumID)');

  $sth->execute(array(
    'name' => $name,
    'description' => $description,
    'content' => $content,
    'creator' => $creator,
    'created' => date("Y-m-d H:i:s"),
    'forumID' => $fid,
  ));

  $_SESSION['header'] = '/forums/threadid=' . $dfPDO->lastInsertId('thread_id');

  $sth = $dfPDO->prepare('SELECT forum_id FROM threads WHERE forum_id = :forumID');

  $sth->execute(array(
    'forumID' => $fid
  ));

  $threadCount = $sth->rowCount();

  $sth = $dfPDO->prepare('UPDATE forums SET threads = :threads WHERE forum_id = :forumID');

  $sth->execute(array(
    'threads' => $threadCount,
    'forumID' => $fid
  ));

  ajaxRedirect();
  echo success(getLanguageString("threadPosted"));
  reloadPage();

} else {
  foreach ($errors as $error) {
    echo error($error);
  }
}

?>
