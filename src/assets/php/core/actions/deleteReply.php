<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if 1 or more fields empty
if (!empty($_POST["replyID"]) || permLevel() >= 5) {


  $sth = $dfPDO->prepare('SELECT thread_id FROM replies WHERE reply_id = :replyID');
  $sth->execute(array(
    'replyID' => $_POST["replyID"]
  ));
  $threadID = $sth->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('SELECT forum_id FROM threads WHERE thread_id = :threadID');
  $sth->execute(array(
    'threadID' => $threadID
  ));

  $forumID = $sth->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('SELECT * FROM forums WHERE forum_id = :forumID');

  $sth->execute(array(
    'forumID' => $forumID
  ));

  $row = $sth->fetch(PDO::FETCH_ASSOC);
  $posts = $row['posts'];
  $posts -= 1;

  $sth = $dfPDO->prepare('UPDATE forums SET posts = :posts WHERE forum_id = :forumID');

  $sth->execute(array(
    'posts' => $posts,
    'forumID' => $forumID
  ));

  $sth = $dfPDO->prepare('SELECT replies FROM threads WHERE thread_id = :threadID');

  $sth->execute(array(
    'threadID' => $threadID
  ));

  $replies = $sth->fetch(PDO::FETCH_COLUMN);
  $replies -= 1;

  $sth = $dfPDO->prepare('UPDATE threads SET replies = :replies WHERE thread_id = :threadID');

  $sth->execute(array(
    'replies' => $replies,
    'threadID' => $threadID
  ));

  $sth = $dfPDO->prepare('DELETE FROM replies WHERE thread_id = :threadID AND reply_id = :replyID');
  $sth->execute(array(
    'threadID' => $threadID,
    'replyID' => $_POST['replyID']
  ));

  echo success($replyDeletedSuccessfullyTXT);
  ajaxRedirect();
  reloadPage();
}