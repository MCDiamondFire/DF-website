<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

// Check if logged in
if (logged_in()) {
  header('Location: /');
}
?>

<html>
  <head>
    <title><?php $pageTitle = getLanguageString("pageLoginTitle");
          echo $pageTitle; ?></title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>form.css">
  </head>
  <body>
    <?php require_once REQUIRES . 'background.php';
    require_once(REQUIRES . 'header.php'); ?>
    <div id="content">
      <div id="error-output"></div>

      <!-- ########## LOGIN FORM ########## -->
      <div id="wrapper">
        <div id="panelWrapper" class="noMargin">
          <div id="panel" class="fullWidth">
            <form class="ajax" autocomplete="off" id="login" action="<?php echo ACTIONS; ?>login.php" method="post">
              <div id="panelHeading">
                <h2><?php echo getLanguageString("login"); ?></h2>
              </div>
              <br>
              <input type="text" name="username" maxlength="16" placeholder="<?php echo getLanguageString("username"); ?>">
              <input type="password" name="password" placeholder="<?php echo getLanguageString("password"); ?>">
              <label class="checkboxWrapper">
                <input type="checkbox" name="stayLoggedIn" value="true">
                <span class="checkmark"></span>
                <p><?php echo getLanguageString("stayLoggedIn"); ?></p>
              </label>
              <br>
              <button type="submit" ><?php echo getLanguageString("login"); ?></button>
              <p class="big"><?php echo getLanguageString("dontHaveAccount"); ?></p>
              <input type="button" onclick="goTo('register', this)" value="<?php echo getLanguageString("register"); ?>">
              <p class="big"><?php echo getLanguageString("lostPassword"); ?></p>
              <input type="button" onclick="goTo('recover', this)" value="<?php echo getLanguageString("recover"); ?>">
            </form>
            <br>
          </div>
        </div>
      </div>
    </div>
    <?php require_once(REQUIRES . 'footer.php'); ?>
  </body>
</html>
