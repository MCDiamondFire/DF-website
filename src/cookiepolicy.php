<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';
?>

<html>
  <head>
    <title>
      <?php $pageTitle = getLanguageString("pageCookiePolicyTitle");
      echo $pageTitle; ?>
    </title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>cookiepolicy.css">
  </head>
  <body>
    <?php require_once REQUIRES . 'header.php'; ?>
    <?php require_once REQUIRES . 'background.php'; ?>
    <div id="content">
      <div id="panelWrapper">
        <div id="panelHeading">
          <h1>Cookie Policy for MCDiamondFire</h1>
        </div>
        <div id="panelContent">
          <p>This is the Cookie Policy for MCDiamondFire, accessible from mcdiamondfire.com</p><br>
          <p><strong>What Are Cookies</strong></p><br>
          <p>As is common practice with almost all professional websites this site uses cookies, which are tiny files that are downloaded to your computer, to improve your experience. This page describes what information they gather, how we use it and why we sometimes need to store these cookies. We will also share how you can prevent these cookies from being stored however this may downgrade or 'break' certain elements of the sites functionality.</p><br>
          <p>For more general information on cookies see the Wikipedia article on HTTP Cookies.</p><br>
          <p><strong>How We Use Cookies</strong></p><br>
          <p>We use cookies for a variety of reasons detailed below. Unfortunately in most cases there are no industry standard options for disabling cookies without completely disabling the functionality and features they add to this site. It is recommended that you leave on all cookies if you are not sure whether you need them or not in case they are used to provide a service that you use.</p><br>
          <p><strong>Disabling Cookies</strong></p><br>
          <p>You can prevent the setting of cookies by adjusting the settings on your browser (see your browser Help for how to do this). Be aware that disabling cookies will affect the functionality of this and many other websites that you visit. Disabling cookies will usually result in also disabling certain functionality and features of the this site. Therefore it is recommended that you do not disable cookies.</p><br>
          <p><strong>The Cookies We Set</strong></p>
          <ul>
          <li>
            <p>Account related cookies</p>
            <p>If you create an account with us then we will use cookies for the management of the signup process and general administration. These cookies will usually be deleted when you log out however in some cases they may remain afterwards to remember your site preferences when logged out.</p>
          </li><br>
          <li>
            <p>Login related cookies</p>
            <p>We use cookies when you are logged in so that we can remember this fact. This prevents you from having to log in every single time you visit a new page. These cookies are typically removed or cleared when you log out to ensure that you can only access restricted features and areas when logged in.</p>
          </li><br>
          <li>
            <p>Site preferences cookies</p>
            <p>In order to provide you with a great experience on this site we provide the functionality to set your preferences for how this site runs when you use it. In order to remember your preferences we need to set cookies so that this information can be called whenever you interact with a page is affected by your preferences.</p>
          </li>
          </ul><br>
          <p><strong>Third Party Cookies</strong></p><br>
          <p>In some special cases we also use cookies provided by trusted third parties. The following section details which third party cookies you might encounter through this site.</p><br>
          <ul>
          <li>
            <p>From time to time we test new features and make subtle changes to the way that the site is delivered. When we are still testing new features these cookies may be used to ensure that you receive a consistent experience whilst on the site whilst ensuring we understand which optimisations our users appreciate the most.</p><br>
          </li>
          </ul>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
</html>
