<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>

<html>
<head>
  <meta charset="utf-8" />
  <title><?php $pageTitle = getLanguageString("pageShopTitle");
  echo $pageTitle; ?></title>
  <?php require_once $root . 'assets/php/requires/head.php'; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>
  $( window ).resize(function() {
     if ($(window).width() > 783) {
         $("#needsUpdate").attr("height","1050px")
      }
     if ($(window).width() < 783) {
         $("#needsUpdate").attr("height","1600px")
      }
     if ($(window).width() < 354) {
         $("#needsUpdate").attr("height","1800px")
      }
  });
  </script>
  <style>
    #content {
      margin-top: 0 !important;
      margin-bottom: 0 !important;
    }
  </style>
</head>
<body>
<?php
require_once REQUIRES . 'background.php';
require_once REQUIRES . 'header.php';
?>
<div id="content">
<iframe id="needsUpdate" src="https://diamondfire.buycraft.net" height="1050px" width="100%" frameborder="0" scrolling="no"></iframe>
</div>
<?php require_once REQUIRES . 'footer.php'; ?>
</body>
</html>
