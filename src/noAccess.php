<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>
<html>
  <head>
    <title>
      <?php $pageTitle = getLanguageString("pageNoAccessTitle");
      echo $pageTitle; ?>
    </title>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>credits.css">
    <?php require_once REQUIRES . 'head.php'; ?>
  </head>
  <body>
    <?php require(REQUIRES . 'background.php'); ?>
    <div id="content">
      <div id="fullWidthPanelWrapper">
        <div id="panel" class="fullWidth">
          <div id="panelHeading">
            <h1>3 people, one plan...</h1>
          </div>
          <div id="panelContent">
            <div id="profileWrapper">
              <div id="profile">
                <div id="panelBackground">
                <img src="<?php echo IMAGES ?>avatars/RedstoneDaedalus.gif">
                <h1>RedstoneDaedalus</h1>
                <div id="tagWrapper">
                  <div id="tag" class="gold">
                    <p>VerifyBot<br>Integration</p>
                  </div>
                </div>
              </div>
              </div>
              <div id="profile">
              <div id="panelBackground">
                <img src="<?php echo IMAGES ?>avatars/Timeraa.png">
                <h1>Timeraa</h1>
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
              <div id="profile">
              <div id="panelBackground">
                <img src="<?php echo IMAGES ?>avatars/joaoh1.png">
                <h1>joaoh1</h1>
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
              <h1>DiamondFire Website</h1>
              <p>Coming really soon!</p>
            </div>
          </div>
          <div id="centerHeadingWrapper">
            <div id="centerHeading">
              <h2>Estimated release Date:</h2>
              <p>unknown :L</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
