<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

#region Import and setup Google API
ini_set("display_errors", 1);
error_reporting(E_ALL);
//! Disabled for now
/* require $_SERVER['DOCUMENT_ROOT'] . '/assets/php/google-api/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('DiamondFire Website');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');

$jsonAuth = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/credentials/client_secret.json'), true);
$client->setAuthConfig($jsonAuth);

$sheets = new \Google_Service_Sheets($client); */
#endregion

//* Supported Languages
//* Array values = Google Sheets ID
$languages = array(
);

//! Disabled for now
// updateLanguageFiles();

//* Check if language files exist
foreach ($languages as $language) {
  $langFile = @file_get_contents(LANGUAGES . key($languages) . '.json');
  if ($langFile == null) {
    throw new Exception("ERROR: Language file \"" . key($languages) . ".json\" not found");
  }
  next($languages);
}
reset($languages);

//* If user set language
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];

 //* If language cookie
} else if (isset($_COOKIE['language'])) {
  $lang = $_COOKIE['language'];

 //* Detect language
} else {
  if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
  //* Set to Browser language
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

  //* Check if Browser language is avaiable
    if (array_key_exists($lang, $languages) == false) {
      $lang = 'en';
    }
  } else {
    $lang = 'en';
  }
}

/**
 * Update the language files
 */
function updateLanguageFiles()
{
  global $languages;
  global $sheets;

  foreach ($languages as $language) {
    $range = 'Translation!A2:D';
    $rows = $sheets->spreadsheets_values->get($language, $range, ['majorDimension' => 'ROWS']);
    $languageArray = [];

    foreach ($rows['values'] as $row) {
      if (isset($row[3])) {
        $languageArray[$row[0]] = $row[3];
      }
    }

    file_put_contents(LANGUAGES . key($languages) . '.json', json_encode($languageArray, JSON_PRETTY_PRINT));
    next($languages);
  }
  reset($languages);
}

/**
 * Output a language string from language files.
 * @param string $string The string to output
 * @return string
 * @throws Exception
 */
function getLanguageString($string)
{
  global $lang;
  global $languages;

 //* Get contents from specified language file
  $langFile = file_get_contents(LANGUAGES . $lang . '.json');
  $langArray = json_decode($langFile, true);
  if (array_key_exists($string, $langArray) == true) {
    return $langArray[$string];
  } else {
    try {
      $langFile = @file_get_contents(LANGUAGES . 'en.json');
      $langArray = json_decode($langFile, true);
    } catch (Exception $e) {
    }
    if ($langFile == null) {
      throw new Exception("ERROR: Language file \"en.json\" not found");
    } else {
      if (array_key_exists($string, $langArray) == true) {
        return $langArray[$string];
      } else {
        throw new Exception("ERROR: Language string \"" . $string . "\" not found");
      }
    }
  }
}
