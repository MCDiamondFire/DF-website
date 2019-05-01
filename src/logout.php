<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

//* Destroy session
session_destroy();

//* Delete Auto Login Code
setcookie('ALC', '', time() - 3600, '/', '', true, true);

//* Redirect to last site
header('Location: ' . $_SERVER['HTTP_REFERER']);
header('Location: /');
exit();
