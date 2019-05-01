<?php
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if logged in
if (logged_in()) header('Location: /');

// Check if 1 or more fields empty
if (!empty($_POST["Code"])
  && !empty($_POST["Password"])
  && !empty($_POST["Password-Again"])) {
  $code = $_POST['Code'];
  $password = $_POST['Password'];
  $passwordagain = $_POST['Password-Again'];

  // Check if code is valid
  if (!code_exist($code)) {
    $errors[] = getLanguageString('codeInvalid');

    // Check if user exists
  } else if (user_exists(getCodeOwner($code))) {
    $dfPDO->query("use hypercube");
    $sth = $dfPDO->prepare("UPDATE linked_accounts SET `secret_key` = NULL WHERE `secret_key` = :code");
    $sth->execute(array('code' => $code));
    $dfPDO->query("use df_website");

    $_SESSION['header'] = '/login';
    ?>
      <meta http-equiv="refresh" content="0">
    <?php

  }

  // Check password strength
  if ($password != $passwordagain) {
    $errors[] = getLanguageString('passwordsNotMatch');
  } elseif (preg_match('/\s/', $password)) {
    $errors[] = getLanguageString('passwordOnlyContain');
  } elseif (strlen($password) < 4) {
    $errors[] = getLanguageString('passwordWeak');
  }

} else {
  // Report errors
  $infos[] = getLanguageString('fillAllFields');
}

// Output errors if there are
// Else procceed
if (!empty($errors) || !empty($infos)) {
  foreach ($errors as $error) {
    echo error($error);
  }

  foreach ($infos as $info) {
    echo info($info);
  }
} else {
  // Gain all required fields for registration
  $dfPDO->query("use hypercube");
  $sth = $dfPDO->query("SELECT * FROM linked_accounts WHERE secret_key = '$code'");
  $row = $sth->fetch(PDO::FETCH_ASSOC);
  $dfPDO->query("use df_website");
  $uuid = $row['player_uuid'];
  $username = $row['player_name'];
  $password = password_hash($password, PASSWORD_BCRYPT);
  $rank = rank_from_uuid($uuid);
  $joindate = date("Y-m-d H:i:s");

  #region Remove at deploy!
  if (permLevel($rank) < 2 || $rank == "Retired" || $rank == "Emeritus") {
    $errors[] = "Only staff members may register at this time.";
    foreach ($errors as $error) {
      echo error($error);
    }
  }
  #endregion

  // Generate the register data
  $register_data = array(
    'uuid' => $uuid,
    'username' => $username,
    'password' => $password,
    'rank' => $rank,
    'code' => $code,
    'created' => $joindate
  );

  // Do some crazy conversation for SQL
  $fields = '`' . implode('`, `', array_keys($register_data)) . '`';

  // Prepare to prevent Injection .-.
  $sth = $dfPDO->prepare("INSERT INTO `df_website`.`accounts` ($fields) VALUES (:uuid, :username, :password, :rank, :code, :created)");
  $sth->execute($register_data);
  $_SESSION['user_id'] = $dfPDO->lastInsertId();
  $dfPDO->query("use hypercube");

  // Set the Code to NULL
  $sth = $dfPDO->prepare("UPDATE linked_accounts SET `secret_key` = NULL WHERE `secret_key` = :code");
  $sth->execute(array('code' => $code));
  $dfPDO->query("use df_website");

  $success[] = getLanguageString('registeredSuccessfully');
  foreach ($success as $succes) {
    echo success($succes);
  }
  ?>
  <meta http-equiv="refresh" content="0">
  <?php

}

// If code exists
function code_exist($code)
{
  global $dfPDO;

  $dfPDO->query("use hypercube");
  $sth = $dfPDO->prepare("SELECT COUNT(`secret_key`) FROM linked_accounts WHERE secret_key = :code");
  $sth->execute(array('code' => $code));
  $dfPDO->query("use df_website");
  return ($sth->fetch(PDO::FETCH_COLUMN) == 1) ? true : false;
}

// If user exists
function user_exist($code)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');
  $sth = $dfPDO->prepare("SELECT player_name FROM linked_accounts WHERE secret_key = :code");
  $sth->execute(array('code' => $code));
  $dfPDO->query('use df_website');

  $username = $sth->fetch(PDO::FETCH_COLUMN);

  $sth = $dfPDO->prepare("SELECT username FROM accounts WHERE username = :username");
  $sth->execute(array('username' => $username));

  $usernameCheck = $sth->fetch(PDO::FETCH_COLUMN);
  if ($username === $usernameCheck) return true;
}
?>
