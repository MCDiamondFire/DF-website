<?php
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if 1 or more fields empty
if (!empty($_POST["username"])
  && !empty($_POST["password"])) {
  if (!empty($_POST['stayLoggedIn'])) {
    $stayLoggedIn = true;
  } else {
    $stayLoggedIn = false;
  }

  $username = $_POST['username'];
  $password = $_POST['password'];


  $dfPDO->query('use hypercube');
  $sth = $dfPDO->prepare('SELECT * FROM linked_accounts WHERE player_name = :username');

  $sth->execute(array(
    'username' => $username
  ));

  $userRow = $sth->fetch(PDO::FETCH_ASSOC);

  $dfPDO->query('use df_website');


  $sth = $dfPDO->prepare('UPDATE accounts SET username = :username WHERE uuid = :uuid');
  $sth->execute(array(
    'username' => $userRow['player_name'],
    'uuid' => $userRow['player_uuid']
  ));

  $username = $userRow['player_name'];

  if (user_exists($userRow['player_uuid'])) {
    if (valid_password($username, $password)) {
      $userRank = user_data(getUserID($username), 'rank');

      //! Remove at deployment
      if (permLevel($userRank['rank']) > 0 || $userRank['rank'] == "Retired Staff" || $userRank['rank'] == "Emeritus") {

        $_SESSION['user_id'] = getUserID($username);

        $sth = $dfPDO->prepare('SELECT stayLoggedInCode FROM accounts WHERE user_id = :userID');
        $sth->execute(array(
          'userID' => $_SESSION['user_id']
        ));
        $randomLoggedIn = $sth->fetch(PDO::FETCH_COLUMN);

        //TODO Redo autologin code creation/check
        if ($stayLoggedIn == true) {
          if ($randomLoggedIn == null) {

            $alcs = $dfPDO->query("SELECT stayLoggedInCode FROM accounts");
            $alcs = $alcs->fetchAll();
            $duplicate = true;
            while ($duplicate) {
              $nextCode = generateRandomString(32);
              if (!in_array($nextCode, $alcs)) {
                $duplicate = false;
              }
            }
            $sth = $dfPDO->prepare('UPDATE accounts SET stayLoggedInCode = :code WHERE user_id = :userID');
            $sth->execute(array(
              'code' => $nextCode,
              'userID' => $_SESSION['user_id']
            ));
          }

          setcookie('ALC', $randomLoggedIn, time() + 60 * 60 * 24 * 30, '/', '', true, true);
        }

        $browserData = parse_user_agent();

        $sth = $dfPDO->prepare('SELECT * FROM devices WHERE user_id = :userID');
        $sth->execute(array(
          'userID' => $_SESSION['user_id']
        ));

        $fetchedBrowserData = $sth->fetchAll();
        foreach ($fetchedBrowserData as $row) {
          if ($browserData['platform'] == $row['device'] && $browserData['browser'] == $row['browser'] && $browserData['version'] == $row['version']) {
            $device_unique = $row['device_unique'];
            break;
          } else {
            continue;
          }
        }


        if (!isset($device_unique)) {
          if ($stayLoggedIn == true) {
            $stayLoggedIn = 1;
          } else {
            $stayLoggedIn = 0;
          }
          $sth = $dfPDO->prepare('INSERT INTO `df_website`.`devices` (user_id, stayLoggedIn, loginTime, device, browser, version) VALUES (:userID, :stayLoggedIn, :loginTime, :device, :browser, :version)');
          $sth->execute(array(
            'userID' => $_SESSION['user_id'],
            'stayLoggedIn' => $stayLoggedIn,
            'loginTime' => date("Y-m-d H:i:s"),
            'device' => $browserData['platform'],
            'browser' => $browserData['browser'],
            'version' => $browserData['version']
          ));
        } else {
          $sth = $dfPDO->prepare('UPDATE devices SET loginTime = :newTime, stayLoggedIn = :stayLoggedIn WHERE device_unique = :deviceUnique');
          $sth->execute(array(
            'newTime' => date("Y-m-d H:i:s"),
            'stayLoggedIn' => $stayLoggedIn,
            'deviceUnique' => $device_unique
          ));
        }

        ajaxRedirect();
        $success[] = getLanguageString("loginSuccess");
        ?>
      <meta http-equiv="refresh" content="0">
      <?php

    } else {
      echo info("The website is closed. Only staff members (> Mod) have access it will be avaiable at the release.");
    }
  } else {
    $errors[] = getLanguageString("passwordNotCorrect");
  }
} else {
  $errors[] = getLanguageString("userNotExist");
}
} else {
  // Report errors
  $infos[] = getLanguageString("fillAllFields");
}

if (!empty($errors)) {
  foreach ($errors as $error) {
    echo error($error);
  }
}

if (!empty($infos)) {
  foreach ($infos as $info) {
    echo info($info);
  }
}

if (!empty($success)) {
  foreach ($success as $succes) {
    echo success($succes);
  }
}

?>