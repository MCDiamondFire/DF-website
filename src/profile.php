<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

// Check if logged in
if (!logged_in()) {
  header('Location: /login');
}

//TODO Rewrite page

?>

<html>
  <head>
    <title><?php
          $pageTitle = str_replace('%USERNAME%', $user_data['username'], getLanguageString("pageProfileTitle"));
          echo $pageTitle; ?></title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $page; ?>assets/css/profile.css">
  </head>
  <body>
    <?php
    require_once REQUIRES . 'header.php';
    require_once REQUIRES . 'background.php';
    ?>
    <div id="content">
      <div id="error-output"></div>
        <div id="panelWrapper">
          <div id="panel">
            <div id="panelHeading">
              <h1><?php echo getLanguageString("changePassword"); ?></h1>
            </div>
            <div id="panelContent">
              <form class="ajax" autocomplete="off" action="<?php echo ACTIONS; ?>changePassword.php" method="post">
                <input type="password" name="currentPassword" placeholder="<?php echo getLanguageString("currentPassword"); ?>"><br>
                <input type="password" name="newPassword" placeholder="<?php echo getLanguageString("newPassword"); ?>">
                <input type="password" name="repeatNewPassword" placeholder="<?php echo getLanguageString("newPassword"); ?>"><br>
                <button type="submit"><?php echo getLanguageString("change"); ?></button>
              </form>
            </div>
          </div>
        </div>
        <div id="panelWrapper"
          <div id="panel">
            <div id="panelHeading">
              <h1><?php echo getLanguageString("devices"); ?></h1>
            </div>
            <div id="panelContent">
              <form class="ajax" autocomplete="off" action="<?php echo ACTIONS; ?>signOutAll.php" method="post">
                <h2><?php echo getLanguageString("deviceHistory"); ?></h2>
                <table>
                  <thead>
                    <tr>
                      <td><?php echo getLanguageString("device"); ?></td>
                      <td><?php echo getLanguageString("browser"); ?></td>
                      <td><?php echo getLanguageString("version"); ?></td>
                      <td><?php echo getLanguageString("stayLoggedIn"); ?></td>
                      <td><?php echo getLanguageString("lastLogin"); ?></td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $sth = $dfPDO->prepare('SELECT * FROM devices WHERE user_id = :userID');
                  $sth->execute(array('userID' => $_SESSION['user_id']));

                  $fetchedBrowserData = $sth->fetchAll();
                  foreach ($fetchedBrowserData as $row) {
                    if ($row['stayLoggedIn'] == 1) {
                      $stayLoggedIn = getLanguageString("yes");
                    } else {
                      $stayLoggedIn = getLanguageString("no");
                    }
                    ?>
                      <tr>
                        <td><?php echo $row['device']; ?></td>
                        <td><?php echo $row['browser']; ?></td>
                        <td><?php echo $row['version']; ?></td>
                        <td><?php echo $stayLoggedIn; ?></td>
                        <td><?php echo date("d.m.Y - H:i:s", strtotime($row['loginTime'])); ?></td>
                      </tr>
                    <?php

                  }
                  ?>
                  </tbody>
                </table>
                <button type="submit"><?php echo getLanguageString("signOutFromAllDevices"); ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
</html>
