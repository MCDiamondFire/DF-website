<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>
<html>
  <head>
    <title>
      Credits &bull; DiamondFire
    </title>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>credits.css">
    <?php require_once REQUIRES . 'head.php'; ?>
  </head>
  <body>
    <?php
    require_once(REQUIRES . 'background.php');
    require_once(REQUIRES . 'header.php');
    ?>
    <div id="content">
      <div id="fullWidthPanelWrapper">
        <div id="panel" class="fullWidth">
          <div id="panelHeading">
            <h1>This website has been developed proudly by</h1>
          </div>
          <div id="panelContent">
            <div id="creditsProfileWrapper">
              <div id="creditsProfile">
              <div id="panelBackground">
                <img src="<?php echo IMAGES ?>avatars/Timeraa.png">
                <h1>Timeraa</h1>
                <p>A <a href="https://wikipedia.org/wiki/Brony">brony</a> that loves to make the world better by coding.</p>
                <div id="tagWrapper">
                  <div id="tag" class="red">
                    <p>Backend</p>
                  </div>
                  <div id="tag" class="aqua">
                    <p>Frontend</p>
                  </div>
                </div>
                </div>
              </div>
              <div id="creditsProfile">
              <div id="panelBackground">
                <img src="<?php echo IMAGES ?>avatars/joaoh1.png">
                <h1>joaoh1</h1>
                <p>Just someone with glasses, i fix bugs and add small things.</p>
                <div id="tagWrapper">
                  <div id="tag" class="red">
                    <p>Semi-Backend</p>
                  </div>
                  <div id="tag" class="aqua">
                    <p>Frontend</p>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div id="centerHeadingWrapper">
            <div id="centerHeading">
              <h1>Without them, this wouldn't be possible:</h1>
              <p>Jeremaster</p>
              <p>PHP</p>
              <p>VerifyBot</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
</html>
