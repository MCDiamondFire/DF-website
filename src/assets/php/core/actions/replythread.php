<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (!logged_in()) header('Location: /login');
if (empty($_POST['THID'])) header('Location: /forums/');

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
    $errors[] .= getLanguageString("replyContentShort");
  }
}

if (empty($errors)) {

  $sth = $dfPDO->prepare('INSERT INTO replies (thread_id, content, creator, created) VALUES (:threadID, :content, :creator, :created)');

  $creator = $user_data['user_id'];
  $sth->execute(array(
    'threadID' => $_POST['THID'],
    'content' => $content,
    'creator' => $creator,
    'created' => date("Y-m-d H:i:s")
  ));

  $sth = $dfPDO->prepare('SELECT thread_id FROM replies WHERE thread_id = :threadID');

  $sth->execute(array(
    'threadID' => $_POST['THID']
  ));

  $replyCount = $sth->rowCount();

  $sth = $dfPDO->prepare('UPDATE threads SET replies = :replies WHERE thread_id = :threadID');

  $sth->execute(array(
    'replies' => $replyCount,
    'threadID' => $_POST['THID']
  ));

  $sth = $dfPDO->prepare('SELECT forum_id FROM threads WHERE thread_id = :threadID');

  $sth->execute(array(
    'threadID' => $_POST['THID']
  ));

  $forumID = $sth->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('SELECT posts FROM forums WHERE forum_id = :forumID');

  $sth->execute(array(
    'forumID' => $forumID
  ));

  $posts = $sth->fetch(PDO::FETCH_COLUMN);
  $posts += 1;

  $dfPDO->query('UPDATE forums SET posts = ' . $posts . ' WHERE forum_id = ' . $forumID);

  $sth = $dfPDO->prepare('SELECT creator FROM threads WHERE thread_id = :threadID');

  $sth->execute(array(
    'threadID' => $_POST['THID']
  ));

  $threadOwnerID = $sth->fetch(PDO::FETCH_COLUMN);

  $threadOwner = usernameFromID($threadOwnerID);

  $successfullyRepliedThreadTXT = str_replace('%USERNAME%', $threadOwner, getLanguageString("successfullyRepliedThread"));

  $threadName = $dfPDO->prepare('SELECT name FROM threads WHERE thread_id = :threadID');
  $threadName->execute(array(
    'threadID' => $_POST['THID']
  ));
  $threadName = $threadName->fetch(PDO::FETCH_COLUMN);


  $_SESSION['header'] = '/forums/threadid=' . $_POST['THID'];
  echo success($successfullyRepliedThreadTXT);
  ?>
    <meta http-equiv="refresh" content="0">
  <?php

} else {
  foreach ($errors as $error) {
    echo error($error);
  }
}


?>
