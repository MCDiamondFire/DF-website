<header>
  <style>
  .mobile {
    display: none !important
  }

  @media (max-width: 680px) {
    .computer {
      display: none !important
    }

    .mobile {
      display: flex !important
    }

    header {
      position: fixed !important
    }

    #content {
      top: 75px;
      padding-bottom: 75px
    }
  }

  header {
    transition: height 0.2s ease-out;
    position: relative;
    top: 0;
    height: 75px;
    width: 100%;
    z-index: 100;
    cursor: default
  }

  #header {
    display: flex;
    align-items: center;
    top: 0;
    width: 100%;
    height: 75px;
    background-color: rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 2px -2px rgba(0, 0, 0, 0.5)
  }

  #content {
    position: relative;
    min-height: calc(100% - 125px);
    margin-top: 25px;
    margin-bottom: 25px
  }

  #header .logo img {
    flex: 1 1 70px;
    padding: 10px 7px 10px 7px;
    height: 60px;
    width: 60px
  }

  .links {
    color: black;
    text-decoration: none;
    font-size: 25px;
    font-weight: 600;
    text-transform: uppercase;
    margin: 0 15px 0 15px
  }

  #profile {
    margin-left: auto;
    height: 75px;
    width: auto;
    box-shadow: -1px 0px 10px 0px rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center
  }

  #profileImg img {
    margin-left: 8px;
    margin-top: 3px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5)
  }

  #profileText {
    margin-left: 10px;
    margin-right: 10px
  }

  #profileWelcome {
    font-size: 17px;
    font-weight: 500
  }

  #profileName {
    font-size: 17px;
    font-weight: 600;
    color: #4c98c2
  }

  #profileLogin, #profileLogout {
    transition: 0.15s color ease-out;
    color: black;
    text-decoration: none
  }

  @media screen and (max-width: 730px) {
    #header.computer #links li {
      transition: 0.5s margin cubic-bezier(0.44, 0.99, 0.12, 1.17);
      margin-left: 10px;
      margin-right: 10px
    }
  }
  </style>

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
