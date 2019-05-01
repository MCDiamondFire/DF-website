<?php
// ######################### require_once INIT #########################
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>


<html prefix="og: http://ogp.me/ns#">
  <head>
    <title><?php $pageTitle = getLanguageString("pageIndexTitle");
    echo $pageTitle; ?></title>
    <meta name="description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games! Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks."/>

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="<?php echo $page; ?>"/>
    <meta name="twitter:creator" content="Timeraa, joaoh1, Jeremaster"/>

    <meta property="og:title" content="DiamondFire Minecraft Server" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $page; ?>" />
    <meta property="og:description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games! Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks." />
    <meta property="og:image" content="<?php echo $page; ?>assets/images/logo.png" />
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>index.css">
    <?php require_once REQUIRES . 'head.php'; ?>
  </head>

  <body>
    <?php
    require_once(REQUIRES . 'background.php');
    require_once(REQUIRES . 'header.php');
    ?>

    <div id="content">
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
  <script type="text/javascript" src="<?php echo JS; ?>plotSlider.js"></script>
</html>
