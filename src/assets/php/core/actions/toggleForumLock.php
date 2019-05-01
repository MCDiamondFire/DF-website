<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (!empty($_POST["forumID"]) && permLevel() >= 7) {
  $lockStatus = $dfPDO->prepare('SELECT locked FROM forums WHERE forum_id = :forumID');
  $lockStatus->execute(array(
    'forumID' => $_POST['forumID']
  ));

  $lockStatus = $lockStatus->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('UPDATE forums SET locked = :lockStatus WHERE forum_id = :forumID');
  if ($lockStatus == 0) {
    $sth->execute(array(
      'lockStatus' => 1,
      'forumID' => $_POST['forumID']
    ));
    echo success(getLanguageString("forumLockedSuccessfully"));
  } else {
    $sth->execute(array(
      'lockStatus' => 0,
      'forumID' => $_POST['forumID']
    ));
    echo success(getLanguageString("forumUnlockedSuccessfully"));
  }

  ajaxRedirect();
  ?>
  <meta http-equiv="refresh" content="0">
  <?php

}

?>