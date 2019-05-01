<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (!empty($_POST["threadID"]) && permLevel() > 5) {
  $lockStatus = $dfPDO->prepare('SELECT pinned FROM threads WHERE thread_id = :threadID');
  $lockStatus->execute(array(
    'threadID' => $_POST['threadID']
  ));

  $lockStatus = $lockStatus->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare('UPDATE threads SET pinned = :pinStatus WHERE thread_id = :threadID');
  if ($lockStatus == 0) {
    $sth->execute(array(
      'pinStatus' => 1,
      'threadID' => $_POST['threadID']
    ));
    echo success(getLanguageString("threadPinnedSuccessfully"));
  } else {
    $sth->execute(array(
      'pinStatus' => 0,
      'threadID' => $_POST['threadID']
    ));
    echo success(getLanguageString("threadUnpinnedSuccessfully"));
  }
  ajaxRedirect();
  reloadPage();
}

?>