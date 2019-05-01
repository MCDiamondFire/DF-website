<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (empty($_POST['currentPassword'])
  || empty($_POST['newPassword'])
  || empty($_POST['repeatNewPassword'])) {

  $errors[] = $fillAllFieldsTXT;

} else {
  $checkCurrentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];
  $repeatNewPassword = $_POST['repeatNewPassword'];

  $sth = $dfPDO->prepare('SELECT password FROM accounts WHERE user_id = :userID');

  $sth->execute(array(
    'userID' => $user_data['user_id']
  ));

  $password = $sth->fetch(PDO::FETCH_COLUMN);

  if (password_verify($checkCurrentPassword, $password)) {
    if ($newPassword == $repeatNewPassword) {
      // Check password strength
      if (preg_match('/\s/', $newPassword)) {
        $errors[] = $passwordOnlyContainTXT;
      } elseif (strlen($newPassword) < 4) {
        $errors[] = $passwordShortTXT;
      }
    } else {
      $errors[] = $passwordNotMatchTXT;
    }
  } else {
    $errors[] = $passwordNotCorrectTXT;
  }
}

if (!empty($errors)) {
  foreach ($errors as $error) {
    echo error($error);
  }
} else {
  $sth = $dfPDO->prepare('UPDATE accounts SET password = :newPassword WHERE user_id = :userID');
  $sth->execute(array(
    'newPassword' => password_hash($newPassword, PASSWORD_BCRYPT),
    'userID' => $user_data['user_id']
  ));
  addMessage($_SESSION['user_id'], $passwordHasBeenChangedTXT, "important", "passwordChanged", json_encode(array(
    'url' => $recoverLinkTXT
  )));
  echo success("Done!");
}
?>