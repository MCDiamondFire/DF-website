<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php $pageTitle = getLanguageString("page404Title");
  echo $pageTitle; ?></title>
  <?php require_once REQUIRES . 'head.php'; ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>404.css">
</head>

<body>
  <!-- ########## BACKGROUND ########## -->
  <?php
  require_once(REQUIRES . 'background.php');
  require_once(REQUIRES . 'header.php');
  ?>
  <div id="content">
    <div id="panelCenter">
      <div id="panelCenterWrapper">
        <div id="panelWrapper">
          <div id="panel">
            <div id="panelHeading">
              <h1><?php echo getLanguageString("title404"); ?></h1>
            </div>
            <div id="panelContent">
              <h3><?php echo getLanguageString("description404"); ?></h3>
              <button onclick="history.back()"><?php echo getLanguageString("takeMeBack"); ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once REQUIRES . 'footer.php'; ?>
</body>

</html>
