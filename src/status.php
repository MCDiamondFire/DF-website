<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');
?>


<html prefix="og: http://ogp.me/ns#">
  <head>
    <title><?php $pageTitle = getLanguageString("pageStatusTitle");
    echo $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>index.css">
<?php require_once REQUIRES . 'head.php'; ?>

  </head>

  <body>
    <?php
    require_once(REQUIRES . 'background.php');
    require_once(REQUIRES . 'header.php');
    ?>

    <div id="content">
      <div id="panelWrapper">
        <div id="panelHeading">
          <h1><?php echo getLanguageString("status") ?></h1>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
  <script type="text/javascript" src="<?php echo JS; ?>plotSlider.js"></script>
</html>
