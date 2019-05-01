<?php
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (isset($_GET['FID']) && !empty($_GET['FID'])) {
  if (permLevel() >= 7) {
    $sth = $dfPDO->prepare('SELECT name, description FROM forums WHERE forum_id = :forumID');
    $sth->execute(array(
      'forumID' => $_GET['FID']
    ));

    if ($sth->rowCount() == 0) {
      header('Location: /forums');
      exit();
    } else {
      $forumData = $sth->fetch(PDO::FETCH_ASSOC);
    }
  } else {
    header('Location: /forums');
    exit();
  }
} else {
  header('Location: /forums');
  exit();
}
?>

<html>
  <head>
    <title>
      <?php echo getLanguageString('pageEditForum') ?>
    </title>
    <?php require(REQUIRES . 'head.php'); ?>
  </head>
  <body>
    <?php require_once REQUIRES . 'header.php'; ?>
    <?php require_once REQUIRES . 'background.php'; ?>
    <div id="content">
      <div id="centerPanelWrapper">
        <div id="panel">
          <div id="panelHeading">
            <h1>Edit Forum Information</h1>
          </div>
          <div id="panelContent">
            <form class="ajaxRedirect" autocomplete="off" id="plotInfo" enctype="multipart/form-data" action="<?php echo ACTIONS; ?>editForum.php" method="post">
              <input type="text" name="forumName" maxlength="25" placeholder="Forum name" value="<?php echo $forumData['name'] ?>"><br>
              <input type="text" name="forumDescription" maxlength="75" placeholder="Forum description" value="<?php echo $forumData['description'] ?>"><br>
              <button type="button"><?php echo getLanguageString("save") ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
</html>