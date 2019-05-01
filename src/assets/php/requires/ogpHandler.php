<?php if (isset($pageTitle)) { ?>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="DiamondFire" />
  <meta property="og:title" content="<?php 
                                    $ogpTitle = str_replace(" &bull; DiamondFire", "", $pageTitle);
                                    echo $ogpTitle ?>"/>
  <meta property="og:description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games!  Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks."/>
  <meta name="description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games!  Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks."/>
  <meta property="og:url" content="<?php echo $page; ?>" />
  <meta property="og:image" content="<?php echo $page; ?>assets/images/logo.png" />
<?php 
} else { ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="DiamondFire"/>
    <meta property="og:description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games!  Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks."/>
    <meta name="description" content="DiamondFire is a Minecraft multiplayer server where players can create their own games!  Using DiamondFire's custom-built visual programming platform, players can construct game logic by simply placing regular Minecraft blocks."/>
    <meta property="og:url" content="<?php echo $page; ?>" />
    <meta property="og:image" content="<?php echo $page; ?>assets/images/logo.png" />
<?php 
} ?>