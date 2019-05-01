<?php
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if 1 or more fields empty
if (!empty($_POST["threadID"]) || permLevel() > 0) {
  $threadID = $_POST['threadID'];
  $sth = $dfPDO->prepare('SELECT * FROM threadLikes WHERE thread_id = :threadID');

  $sth->execute(array(
    'threadID' => $threadID
  ));

  if ($sth->rowCount() > 0) {
    $results = $sth->fetchAll();
    foreach ($results as $result) {
      if ($result['user'] != $_SESSION['user_id']) {
        $alreadyReplied = false;
      } else {
        $alreadyReplied = true;
      }
    }
    if ($alreadyReplied) {
      $sth = $dfPDO->prepare('DELETE FROM threadLikes WHERE thread_id = :threadID AND user = :userID');
      $sth->execute(array(
        'threadID' => $threadID,
        'userID' => $_SESSION['user_id']
      ));

      $sth = $dfPDO->prepare('SELECT creator FROM threads WHERE thread_id = :threadID');

      $sth->execute(array(
        'threadID' => $threadID
      ));

      $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

      $replyRemoveLikeTXT = getLanguageString("threadLikeRemove");
      $replyRemoveLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replyRemoveLikeTXT);
      echo success($replyRemoveLikeTXT);
    } else {
      $sth = $dfPDO->prepare('INSERT INTO threadLikes (thread_id, user) VALUES (:threadID, :userID)');
      $sth->execute(array(
        'threadID' => $threadID,
        'userID' => $_SESSION['user_id']
      ));

      $sth = $dfPDO->prepare('SELECT creator FROM threads WHERE thread_id = :threadID');

      $sth->execute(array(
        'threadID' => $threadID
      ));

      $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

      $replySuccessLikeTXT = getLanguageString("threadLikeSuccess");
      $replySuccessLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replySuccessLikeTXT);
      echo success($replySuccessLikeTXT);
    }
  } else {
    $sth = $dfPDO->prepare('INSERT INTO threadLikes (thread_id, user) VALUES (:threadID, :userID)');
    $sth->execute(array(
      'threadID' => $threadID,
      'userID' => $_SESSION['user_id']
    ));

    $sth = $dfPDO->prepare('SELECT creator FROM threads WHERE thread_id = :threadID');

    $sth->execute(array(
      'threadID' => $threadID
    ));

    $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

    $replySuccessLikeTXT = getLanguageString("threadLikeSuccess");
    $replySuccessLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replySuccessLikeTXT);
    echo success($replySuccessLikeTXT);
  }
}
ajaxRedirect();

?>
<meta http-equiv="refresh" content="0">
