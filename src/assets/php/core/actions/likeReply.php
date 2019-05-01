<?php
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if 1 or more fields empty
if (!empty($_POST["replyID"]) || permLevel() > 0) {
  $replyID = $_POST['replyID'];
  $sth = $dfPDO->prepare('SELECT * FROM replyLikes WHERE reply_id = :replyID');

  $sth->execute(array(
    'replyID' => $replyID
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
      $sth = $dfPDO->prepare('DELETE FROM replyLikes WHERE reply_id = :replyID AND user = :userID');
      $sth->execute(array(
        'replyID' => $replyID,
        'userID' => $_SESSION['user_id']
      ));

      $sth = $dfPDO->prepare('SELECT creator FROM replies WHERE reply_id = :replyID');

      $sth->execute(array(
        'replyID' => $replyID
      ));

      $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

      $replyRemoveLikeTXT = getLanguageString("replyLikeRemove");
      $replyRemoveLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replyRemoveLikeTXT);
      echo success($replyRemoveLikeTXT);
    } else {
      $sth = $dfPDO->prepare('INSERT INTO replyLikes (reply_id, user) VALUES (:replyID, :userID)');
      $sth->execute(array(
        'replyID' => $replyID,
        'userID' => $_SESSION['user_id']
      ));

      $sth = $dfPDO->prepare('SELECT creator FROM replies WHERE reply_id = :replyID');

      $sth->execute(array(
        'replyID' => $replyID
      ));

      $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

      $replySuccessLikeTXT = getLanguageString("replyLikeSuccess");
      $replySuccessLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replySuccessLikeTXT);
      echo success($replySuccessLikeTXT);
    }
  } else {
    $sth = $dfPDO->prepare('INSERT INTO replyLikes (reply_id, user) VALUES (:replyID, :userID)');
    $sth->execute(array(
      'replyID' => $replyID,
      'userID' => $_SESSION['user_id']
    ));

    $sth = $dfPDO->prepare('SELECT creator FROM replies WHERE reply_id = :replyID');

    $sth->execute(array(
      'replyID' => $replyID
    ));

    $replyAuthor = usernameFromID($sth->fetch(PDO::FETCH_COLUMN));

    $replySuccessLikeTXT = getLanguageString("replyLikeSuccess");
    $replySuccessLikeTXT = str_replace('%USERNAME%', $replyAuthor, $replySuccessLikeTXT);
    echo success($replySuccessLikeTXT);
  }
}
ajaxRedirect();

?>
<meta http-equiv="refresh" content="0">
