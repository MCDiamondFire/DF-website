<?php
if (isset($_COOKIE['ALC'])) {
  $sth = $dfPDO->prepare("SELECT user_id FROM accounts WHERE stayLoggedInCode = :alc");
  $sth->execute(array(
    "alc" => $_COOKIE['ALC']
  ));
  if ($sth->rowCount() > 0) {
    $_SESSION['user_id'] = $sth->fetch(PDO::FETCH_COLUMN);
  } else {
    unset($_COOKIE['ALC']);
    setcookie('ALC', '', time() - 3600, '/', '', true, true);
  }
}
?>