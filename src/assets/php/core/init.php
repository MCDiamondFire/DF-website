<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

#region ajaxRedirect cookie remover
if (isset($_COOKIE['ajaxRedirect'])) {
  unset($_COOKIE['ajaxRedirect']);
  setcookie('ajaxRedirect', null, -1, '/');
}
#endregion
#region enable error reporting
//! Remove/Disable at deployment!!!!
//* Report every error
ini_set("display_errors", 1);
error_reporting(E_ALL);
#endregion
#region Define Constants & Variables
//* Defined for easier use
$root = $_SERVER['DOCUMENT_ROOT'] . '/';
$page = '//' . $_SERVER['SERVER_NAME'] . '/';

define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PAGE', '//' . $_SERVER['SERVER_NAME'] . '/');
define('CORE', $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/');
define('REQUIRES', $_SERVER['DOCUMENT_ROOT'] . '/assets/php/requires/');
define('LANGUAGES', $_SERVER['DOCUMENT_ROOT'] . '/assets/languages/');
define('FUNCTIONS', $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/functions/');
define('GOOGLEAPI', $_SERVER['DOCUMENT_ROOT'] . '/assets/php/google-api/');
define('ACTIONS', PAGE . 'assets/php/core/actions/');
define('IMAGES', PAGE . 'assets/images/');
define('CSS', PAGE . 'assets/css/');
define('JS', PAGE . 'assets/js/');
#endregion

#region require_once needed files
//* Detect the language.
require_once(LANGUAGES . '/detect.php');
//* Connect with the database
require_once(ROOT . 'assets/php/core/database/connect.php');
//* Import functions
require_once(FUNCTIONS . '/users.php');
require_once(FUNCTIONS . '/antiSwear.php');
//* Import UserAgentParser
require_once(FUNCTIONS . '/UserAgentParser.php');
//* Import Google API V2
//! Disabled for now
//require_once(GOOGLEAPI . '/vendor/autoload.php');

//* Import autologin
require_once(FUNCTIONS . '/autoLogin.php');
#endregion
#region create user_data if logged in
if (logged_in()) {
  $user_data = user_data($_SESSION['user_id'], 'uuid', 'user_id', 'username', 'password', 'rank', 'code', 'created');
}
#endregion
#region DEPRECATED > Check if logged in
/**
 *
 ** Checks if the user is logged in.
 *! DEPRECATED Do not use
 *? Should i remove it
 * @return boolean
 *
 */
function logged_in()
{
  return (isset($_SESSION['user_id']) == true) ? true : false;
}
#endregion
#region Create needed arrays
//* Create error array
$errors = array();
//* Create info array
$infos = array();
//* Create success array
$success = array();
#endregion

#region Redirect if set
if (isset($_SESSION['header'])) {
  $header = $_SESSION['header'];
  unset($_SESSION['header']);
  header('Location: ' . $header);
}
#endregion

//! Remove at deployment!!!!
#region Check if allowed access
if (!logged_in()) {
  if (!isset($allowedAccess)) $allowedAccess = false;
  //* Testing...
  $allowedAccess = true;
  if ($allowedAccess == false) {
    $allowedURIs = array(
      "/noaccess",
      "/login",
      "/register",
      "/recover",
      "/test",
      "/cookiepolicy",
      "/dfutils/analytics"
    );
    if (isset($_SERVER['REQUEST_URI'])) {
      if (in_array(strtolower($_SERVER['REQUEST_URI']), $allowedURIs) == false) {
        if (strpos(strtolower($_SERVER['REQUEST_URI']), "/actions/") !== false || strpos(strtolower($_SERVER['REQUEST_URI']), "/api/") !== false || strpos(strtolower($_SERVER['REQUEST_URI']), "/statspng/") !== false || strpos(strtolower($_SERVER['REQUEST_URI']), "/verifybot/") !== false || strpos(strtolower($_SERVER['REQUEST_URI']), "/dfutils/") !== false) {

        } else {
          header('Location: /noAccess');
          exit();
        }
      }
    }
  }
}
#endregion

#region Prevent DOCTYPE errors
if (!isset($fromAPI) || $fromAPI == false) { ?>
<!DOCTYPE html>
<?php

}
#endregion
?>
