<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

// Check if logged in
if (logged_in()) {
  header('Location: /');
}
?>

<html>
  <head>
    <title><?php $pageTitle = getLanguageString("pageRecoverTitle");
          echo $pageTitle; ?></title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>form.css">
  </head>
  <body>
    <?php require_once REQUIRES . 'background.php';
    require_once(REQUIRES . 'header.php'); ?>
    <div id="content">
      <div id="error-output"></div>

      <!-- ########## RECOVER FORM ########## -->
      <div id="wrapper">
        <div id="panelWrapper" class="noMargin">
          <div id="panel" class="fullWidth">
            <form class="ajax" autocomplete="off" id="recover" action="<?php echo ACTIONS; ?>recover.php" method="post">
              <div id="panelHeading">
                <h2><?php echo getLanguageString("recover"); ?></h2>
              </div>
              <br>
              <input type="text" name="code" maxlength="8" placeholder="<?php echo getLanguageString("token"); ?>">
              <input type="password" name="password" placeholder="<?php echo getLanguageString("newPassword"); ?>"><br>
              <input type="password" name="confirm_Password" placeholder="<?php echo getLanguageString("repeatPassword"); ?>"><br>
              <button type="submit"><?php echo getLanguageString("recover"); ?></button>
              <br>
              <p class="big"><?php echo getLanguageString("knowYourPassword"); ?></p>
              <input type="button" onclick="goTo('login', this)" value="<?php echo getLanguageString("login"); ?>">
              <p class="big"><?php echo getLanguageString("dontHaveAccount"); ?></p>
              <input type="button" onclick="goTo('register', this)" value="<?php echo getLanguageString("register"); ?>">
            </form>
            <br>
          </div>
        </div>
      </div>
    </div>
    <?php require_once(REQUIRES . 'footer.php'); ?>
  </body>
</html>
