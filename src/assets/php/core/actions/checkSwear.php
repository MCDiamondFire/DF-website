<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if(!empty($_POST['word'])) {
  if(checkSwear($_POST['word'])) {
    echo success('Nothing found');
  } else {
    echo error('Something found');
  }
}


?>