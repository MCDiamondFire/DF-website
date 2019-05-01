<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (isset($_POST['word']) && !empty($_POST['word']) && permLevel() >= 5) {
  $word = $_POST['word'];
  $sth = $dfPDO->prepare('DELETE FROM blacklist WHERE word = :word');
  $sth->execute(array(
    'word' => $word
  ));
  echo success($wordDeletedTXT);
  ?>
  <meta http-equiv="refresh" content="0">
  <?php

}

?>