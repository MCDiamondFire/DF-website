<?php
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (permLevel() == 1) {
  header('Location: /login');
}
?>

<html>
  <head>
    <title>
      <?php echo getLanguageString("pageAPIKeys") ?>
    </title>
    <?php require(REQUIRES . 'head.php') ?>
  </head>
  <body>
    <?php require(REQUIRES . 'header.php') ?>
    <?php require(REQUIRES . 'background.php') ?>
    <div id="content">
      
    </div>
    <?php require(REQUIRES . 'footer.php') ?>
  </body>
</html>