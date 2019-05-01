<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (permLevel() >= 7) {
  // Check if 1 or more fields empty
  if (!empty($_POST["forumID"]) && permLevel() >= 7) {
    $sth = $dfPDO->prepare('DELETE FROM forums WHERE forum_id = :forumID');
    $sth->execute(array(
      'forumID' => $_POST['forumID']
    ));

    if (!$sth) {
      echo "error";
    } else {
      ajaxRedirect();
      echo success(getLanguageString("forumDeletedSuccessfully"));
      ?>
      <meta http-equiv="refresh" content="0">
    <?php 
  }
}
}