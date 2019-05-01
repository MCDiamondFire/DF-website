<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (!logged_in()) header('Location: /login');
if (empty($_POST['FID'])) header('Location: /forums/');
if (empty($_POST['name'])) {
  $errors[] .= $enterThreadName;
} else {
  $name = $_POST['name'];
  $checkName = $name;
  $name = htmlentities($name);
  $checkName = str_replace('&nbsp;', '', $checkName);
  $checkName = str_replace(' ', '', $checkName);
  $checkName = preg_replace('/\s+/', '', $checkName);
  $checkName = filter_var($checkName, FILTER_SANITIZE_STRING);
  if (empty($checkName)) {
    $errors[] .= $enterThreadName;
  } elseif (strlen($checkName) < 6) {
    $errors[] .= $threadNameShort;
  } elseif (strlen($checkName) > 32) exit();
}
if (empty($_POST['content'])) {
  $errors[] .= $enterContent;
} else {
  $content = $_POST['content'];
  $checkContent = $content;
  $checkContent = str_replace('&nbsp;', '', $checkContent);
  $checkContent = str_replace(' ', '', $checkContent);
  $checkContent = preg_replace('/\s+/', '', $checkContent);
  $checkContent = strip_tags($checkContent);
  if (empty($checkContent)) {
    $errors[] .= $enterContent;
  } elseif (strlen($checkContent) < 6) {
    $errors[] .= $threadContentShort;
  }
}

if (empty($errors)) {

  $fid = $_POST['FID'];
  $creator = $user_data['user_id'];

  $sth = $dfPDO->prepare('INSERT INTO threads (name, content, creator, created, forum_id) VALUES (:name, :content, :creator, :created, :forumID)');

  $sth->execute(array(
    'name' => $name,
    'content' => $content,
    'creator' => $creator,
    'created' => date("Y-m-d H:i:s"),
    'forumID' => $fid,
  ));
  $_SESSION['header'] = 'Location: /forums/threadid=' . $dfPDO->lastInsertId('thread_id');

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

  //ajaxRedirect();
    //echo '<meta http-equiv="refresh" content="0">';

} else {
  foreach ($errors as $error) {
    echo error($error);
  }
}

?>
