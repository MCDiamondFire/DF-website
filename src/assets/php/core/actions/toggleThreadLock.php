<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (!empty($_POST["threadID"]) && permLevel() >= 5) {
  $lockStatus = $dfPDO->prepare('SELECT locked FROM threads WHERE thread_id = :threadID');
  $lockStatus->execute(array(
    'threadID' => $_POST['threadID']
  ));

  $lockStatus = $lockStatus->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('UPDATE threads SET locked = :lockStatus WHERE thread_id = :threadID');
  if ($lockStatus == 0) {
    $sth->execute(array(
      'lockStatus' => 1,
      'threadID' => $_POST['threadID']
    ));
    echo success(getLanguageString("threadLockedSuccessfully"));
  } else {
    $sth->execute(array(
      'lockStatus' => 0,
      'threadID' => $_POST['threadID']
    ));
    echo success(getLanguageString("threadUnlockedSuccessfully"));
  }
  ajaxRedirect();
  reloadPage();
}

?>