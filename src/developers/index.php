<?php
require($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (permLevel() < 1) {
  header('Location: /login');
} else {
  header('Location: /developers/applications');
}
?>