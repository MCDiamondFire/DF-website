<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

// Check if logged in
if (logged_in()) exit();
$code = $_POST['code'];
if (!empty($_POST['password'])
  && !empty($_POST['confirm_Password'])) {

  $password = $_POST['password'];
  $passwordagain = $_POST['confirm_Password'];

    // Check password strength
  if ($password != $passwordagain) {
    $errors[] = getLanguageString('passwordsNotMatch');
  } elseif (preg_match('/\s/', $password)) {
    $errors[] = getLanguageString('passwordOnlyContain');
  } elseif (strlen($password) < 4) {
    $errors[] = getLanguageString('passwordWeak');
  }

  if (empty($errors)) {
    $dfPDO->query('use hypercube');
    $sth = $dfPDO->prepare('SELECT player_uuid FROM linked_accounts WHERE secret_key = :code');

    $sth->execute(array(
      'code' => $code
    ));

    $uuid = $sth->fetch(PDO::FETCH_COLUMN);
    $password = password_hash($password, PASSWORD_BCRYPT);

    $dfPDO->query('UPDATE linked_accounts SET secret_key = NULL');

    $dfPDO->query('use df_website');

    $sth = $dfPDO->prepare('UPDATE accounts SET password = :password, code = :code WHERE uuid = :uuid');

    $sth->execute(array(
      'password' => $password,
      'uuid' => $uuid,
      'code' => $code
    ));

    $sth = $dfPDO->prepare('SELECT user_id FROM accounts WHERE uuid = :uuid');

    $sth->execute(array(
      'uuid' => $uuid
    ));

    $_SESSION['user_id'] = $sth->fetch(PDO::FETCH_COLUMN);
    echo success(getLanguageString("passwordChangedSuccessfully"));
    ?>
<meta http-equiv="refresh" content="0">
<?php

}
} else {
  $errors[] = getLanguageString("fillAllFields");
}

if (!empty($errors)) {
  foreach ($errors as $error) {
    echo error($error);
  }
}

function codeValid($code)
{
  global $dfPDO;

  $dfPDO->query("use hypercube");
  $sth = $dfPDO->prepare("SELECT COUNT(`secret_key`) FROM linked_accounts WHERE secret_key = :code");
  $sth->execute(array(
    'code' => $code,
  ));
  $dfPDO->query("use df_website");
  return ($sth->fetch(PDO::FETCH_COLUMN) == 1) ? true : false;
}
?>
