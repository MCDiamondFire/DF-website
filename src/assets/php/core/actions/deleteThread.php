<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if 1 or more fields empty
if (!empty($_POST["threadID"]) || $user_data['rank'] == "Admin") {


  $sth = $dfPDO->prepare('SELECT thread_id FROM replies WHERE thread_id = :threadID');
  $sth->execute(array(
    'threadID' => $_POST["threadID"]
  ));
  $removedPosts = $sth->rowCount();

  $sth = $dfPDO->prepare('SELECT forum_id FROM threads WHERE thread_id = :threadID');
  $sth->execute(array(
    'threadID' => $_POST['threadID']
  ));

  $forumID = $sth->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('SELECT * FROM forums WHERE forum_id = :forumID');

  $sth->execute(array(
    'forumID' => $forumID
  ));

  $row = $sth->fetch(PDO::FETCH_ASSOC);
  $threads = $row['threads'];
  $posts = $row['posts'];
  $threads -= 1;
  $posts -= $removedPosts;

  $sth = $dfPDO->prepare('UPDATE forums SET threads = :threads, posts = :posts WHERE forum_id = :forumID');

  $sth->execute(array(
    'threads' => $threads,
    'posts' => $posts,
    'forumID' => $forumID
  ));

  $sth = $dfPDO->prepare('DELETE FROM threads WHERE thread_id = :threadID');
  $sth->execute(array(
    'threadID' => $_POST['threadID']
  ));


  $_SESSION['header'] = '/forums/forumid=' . $forumID;
  echo success(getLanguageString("threadDeletedSuccessfully"));
  ajaxRedirect();
  reloadPage();
} ?>