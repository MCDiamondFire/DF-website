<header>
  <link rel="stylesheet" href="<?php echo $page; ?>/assets/css/header.css" />

<!-- ########################### Computer ########################### -->
  <div
  id="header"
  class="computer">
    <div class="logo">
      <a class="noHovLR"
      href="<?php echo $page; ?>">
        <img
        draggable="false"
        src="<?php echo IMAGES ?>loader.svg"
        data-src="<?php echo IMAGES; ?>logosmall.png">
        </img>
      </a>
    </div>
    <a class="hoverUnderline noHovLR links"
    href="<?php echo $page; ?>">
      <?php echo getLanguageString("navigationIndex"); ?>
    </a>
    <a class="hoverUnderline noHovLR links"
    href="<?php echo $page; ?>forums/">
      <?php echo getLanguageString("navigationForums"); ?>
    </a>
    <a class="hoverUnderline noHovLR links"
    href="<?php echo $page; ?>shop">
      <?php echo getLanguageString("navigationShop"); ?>
    </a>
    <div id="profile">
      <?php
      if (permLevel() > 0) { ?>
      <div id="profileImg">
        <p class="noHovLR" href="<?php echo $page; ?>login/">
          <img draggable="false" src="<?php echo avatarFromID($user_data['user_id'], 60); ?>">
        </p>
      </div>
      <div id="profileText">
        <p id="profileWelcome"><?php echo getLanguageString("welcomeBack") ?></p>
        <p>
          <a id="profileName" href="<?php echo $page; ?>profile/">
            <?php echo usernameFromID($user_data['user_id']); ?>
          </a>
        </p>
        <a draggable="false" href="/logout" id="profileLogout"><?php echo getLanguageString("logout") ?></a>
      </div>
      <?php } else {?>
      <div id="profileImg">
        <p class="noHovLR" href="<?php echo $page; ?>login/">
          <img draggable="false" src="<?php echo $page; ?>assets/images/avatars/guest.png">
        </p>
      </div>
      <div id="profileText">
        <p id="profileWelcome"><?php echo getLanguageString("welcome") ?></p>
        <p id="profileName">
          <?php echo getLanguageString("guest"); ?>
        </p>
        <a draggable="false" href="/login" id="profileLogin"><?php echo getLanguageString("login") ?></a>
      </div>
      <?php } ?>
    </div>
  </div>
<!-- ############################ Mobile ############################ -->
  <div id="header" class="mobile">
    <div class="logo">
      <a class="noHovLR"
      href="<?php echo $page; ?>">
        <img
        draggable="false"
        src="<?php echo IMAGES ?>loader.svg"
        data-src="<?php echo IMAGES; ?>logosmall.png">
        </img>
      </a>
    </div>
    <button
    id="burger">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div id="links">
      <a
      class="hoverUnderline links"
      draggable="false"
      href="<?php echo $page; ?>">
        <?php echo getLanguageString("navigationIndex"); ?>
      </a>
      <a
      class="hoverUnderline links"
      draggable="false"
      href="<?php echo $page; ?>forums/">
        <?php echo getLanguageString("navigationForums"); ?>
      </a>
      <a
      class="hoverUnderline links"
      draggable="false"
      href="<?php echo $page; ?>shop">
        <?php echo getLanguageString("navigationShop"); ?>
      </a>
    </div>
  </div>
</header>

<?php require_once(REQUIRES . 'cookieNotifier.php'); ?>

<script>
  $('#burger').click(function() {
    $('header').toggleClass('responsive')
  })
</script>
