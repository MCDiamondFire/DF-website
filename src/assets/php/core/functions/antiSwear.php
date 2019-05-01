<?php


function checkSwear($string, $returnWords = false)
{
  return false;
  //* Make use of global DFPDO variable
  global $dfPDO;

  //* Load blacklist and whitelist
  $blacklist = $dfPDO->query("SELECT word FROM blacklist");
  $blacklist = $blacklist->fetchAll();
  $whitelist = $dfPDO->query("SELECT word FROM whitelist");
  $whitelist = $whitelist->fetchAll();

  //* Make string lowercase
  $string = strtolower($string);
  //* Remove all spaces
  $string = preg_replace('/\s/', '', $string);

  $result = checkBlacklist($string, $blacklist, $whitelist);
}


function checkBlacklist($string, $blacklist, $whitelist)
{
  foreach ($blacklist as $blacklistString) {
    $stringCheck = str_replace($blacklistString['word'], '', $string);

    if ($stringCheck != $string) {
      echo info(getDifference($string, $stringCheck));
    }
  }
}

function getDifference($old, $new)
{
  $from_start = strspn($old ^ $new, "\0");
  $from_end = strspn(strrev($old) ^ strrev($new), "\0");

  $old_end = strlen($old) - $from_end;
  $new_end = strlen($new) - $from_end;

  $old_diff = substr($old, $from_start, $old_end - $from_start);

  return $old_diff;
}

/* function checkSwear($word, $returnWords = false)
{
  global $dfPDO;

  $foundWord = array();
  $checkedWord = array();

  $result = $dfPDO->query('SELECT word FROM blacklist');
  $blacklistResults = $result->fetchAll();

  $swearFound = false;

  $word = strtolower($word);
  $word = preg_replace('/\s/', '', $word);

  foreach ($blacklistResults as $checkWord) {
    $wordCheck = str_replace($checkWord['word'], '', $word);
    if ($wordCheck != $word) {
      $checkedWord[] .= $wordCheck;
      $foundWord[] .= $word;
      $swearFound = true;
    }
  }

  $word = preg_replace("/[^A-Za-z ]/", '', $word);

  foreach ($blacklistResults as $checkWord) {
    $wordCheck = str_replace($checkWord['word'], '', $word);
    if ($wordCheck != $word) {
      $checkedWord[] .= $wordCheck;
      $foundWord[] .= $word;
      $swearFound = true;
    }
  }

  $word = removeDuplicates($word);

  foreach ($blacklistResults as $checkWord) {
    $wordCheck = str_replace($checkWord['word'], '', $word);
    if ($wordCheck != $word) {
      $checkedWord[] .= $wordCheck;
      $foundWord[] .= $word;
      $swearFound = true;
    }
  }

  $int = 0;
  $foundWords = array();
  foreach ($foundWord as $test) {
    $foundWords[] .= getDifference($test, $checkedWord[$int]);
    $int += 1;
  }

  if ($returnWords == true) {
    if ($swearFound == true) {
      return array_unique($foundWords, SORT_STRING);
    } else {
      return false;
    }
  } else {
    if ($swearFound == false) {
      return false;
    } else {
      return true;
    }
  }
}

function removeDuplicates($string)
{
  $string = str_split($string);

  $previousChar = "";
  $curseStringNew = "";
  foreach ($string as $curseChar) {
    if ($previousChar != $curseChar) {
      $curseStringNew .= $curseChar;
    }
    $previousChar = $curseChar;
  }

  return $curseStringNew;
}
 */


?>