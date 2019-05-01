<?php
// require_once init file
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if set and not empty
if (isset($_POST['word']) && !empty($_POST['word'])) {
  // Check if permissions >= JrMod
  if (permLevel() >= 5) {
    $sth = $dfPDO->prepare('SELECT * FROM blacklist WHERE word = :word');

    $word = $_POST['word'];
    $word = strtolower($word);
    $word = str_replace(' ', '', $word);

    $sth->execute(array(
      'word' => $word
    ));

    if ($word == $sth->fetch(PDO::FETCH_COLUMN)) {
      echo error("Word already in table.");
    } else {
      $sth = $dfPDO->prepare('INSERT INTO blacklist (word, creator) VALUES (:word, :creator)');
      $sth->execute(array(
        'word' => $word,
        'creator' => $_SESSION['user_id']
      ));
      echo success("Word added to blacklist.");
      ?>
          <meta http-equiv="refresh" content="0">
      <?php

    }
  }
} else {
  echo info("Word added.");
}

?>