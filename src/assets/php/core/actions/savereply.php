<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
if (!logged_in()) header('Location: /login');
if (empty($_POST['RID'])) header('Location: /forums/');

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

  $sth = $dfPDO->prepare('UPDATE replies SET content = :content WHERE reply_id = :replyID');

  $sth->execute(array(
    'content' => $content,
    'replyID' => $_POST['RID']
  ));

  $sth = $dfPDO->prepare('SELECT thread_id FROM replies WHERE reply_id = :replyID');

  $sth->execute(array(
    'replyID' => $_POST['RID']
  ));

  $_SESSION['header'] = 'Location: /forums/ThreadID=' . $sth->fetch(PDO::FETCH_COLUMN);
  echo success(getLanguageString("replySaved"));
  ?>
    <meta http-equiv="refresh" content="0">
    <?php

  } else {
    foreach ($errors as $error) {
      echo error($error);
    }
  }

  ?>
