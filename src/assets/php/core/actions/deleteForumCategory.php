<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

if (permLevel() >= 7) {
  // Check if 1 or more fields empty
  if (!empty($_POST["forumCategoryID"]) && permLevel() >= 7) {
    $sth = $dfPDO->prepare('DELETE FROM forum_categories WHERE category_id = :category_id');
    $sth->execute(array(
      'category_id' => $_POST['forumCategoryID']
    ));

    if (!$sth) {
      echo "error";
    } else {
      ajaxRedirect();
      echo success(getLanguageString("forumCategoryDeletedSuccessfully"));
      ?>
      <meta http-equiv="refresh" content="0">
    <?php 
  }
}
}