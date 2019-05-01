<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

$newCode = generateRandomString(32);

$sth = $dfPDO->prepare('UPDATE accounts SET stayLoggedInCode = :newCode WHERE user_id = :userID');

$sth->execute(array(
  'newCode' => $newCode,
  'userID' => $user_data['user_id']
));

$sth = $dfPDO->prepare('DELETE FROM devices WHERE user_id = :userID');
$sth->execute(array(
  'userID' => $user_data['user_id']
));

$browserData = parse_user_agent();

$sth = $dfPDO->prepare('INSERT INTO `df_website`.`devices` (user_id, stayLoggedIn, loginTime, device, browser, version) VALUES (:userID, :stayLoggedIn, :loginTime, :device, :browser, :version)');

if (isset($_COOKIE['autoLoginCode'])) {
  $stayLoggedIn = 1;
} else {
  $stayLoggedIn = 0;
}

$sth->execute(array(
  'userID' => $user_data['user_id'],
  'stayLoggedIn' => $stayLoggedIn,
  'loginTime' => date("Y-m-d H:i:s"),
  'device' => $browserData['platform'],
  'browser' => $browserData['browser'],
  'version' => $browserData['version']
));

if (isset($_COOKIE['autoLoginCode'])) {
  setcookie('autoLoginCode', $newCode, time() + 60 * 60 * 24 * 30, '/', 'df.pocketclass.net', true, true);
  setcookie('autoLoginUserID', $_SESSION['user_id'], time() + 60 * 60 * 24 * 30, '/', 'df.pocketclass.net', true, true);
}
?>
<meta http-equiv="refresh" content="0">
