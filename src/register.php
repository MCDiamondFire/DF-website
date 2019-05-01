<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

// Check if logged in
if (logged_in()) {
  header('Location: /');
}

if (isset($_GET['token'])) {
  $token = $_GET['token'];
} else {
  $token = NULL;
}
?>

<html>
  <head>
    <title><?php $pageTitle = getLanguageString("pageRegisterTitle");
          echo $pageTitle; ?></title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>form.css">
  </head>
  <body>
    <?php require_once REQUIRES . 'background.php';
    require_once(REQUIRES . 'header.php'); ?>
    <div id="content">
      <div id="error-output"></div>

      <!-- ########## REGISTER FORM ########## -->
      <div id="wrapper">
        <div id="panelWrapper" class="noMargin">
          <div id="panel" class="fullWidth">
            <form class="ajax" autocomplete="off" id="register" action="<?php echo ACTIONS; ?>register.php" method="post">
              <div id="panelHeading">
                <h2><?php echo getLanguageString("register"); ?></h2>
              </div>
              <br>
              <input type="text" name="Code" maxlength="8" placeholder="<?php echo getLanguageString("token"); ?>" value="<?php echo $token; ?>">
              <input type="password" name="Password" placeholder="<?php echo getLanguageString("password"); ?>">
              <input type="password" name="Password-Again" placeholder="<?php echo getLanguageString("repeatPassword"); ?>">
              <br>
              <button type="submit"><?php echo getLanguageString("register"); ?></button>
              <p class="big"><?php echo getLanguageString("alreadyHaveAccount"); ?></p>
              <input type="button" onclick="goTo('login', this)" value="<?php echo getLanguageString("login"); ?>">
              <p class="big"><?php echo getLanguageString("forgotPassword"); ?></p>
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
