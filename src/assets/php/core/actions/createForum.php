<?php 
// Adds neccessary files
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php');

#region Prepare Forum
//* If permLevel >= Admin
if (permLevel() >= 7) {
  //* If forum name and description not empty
  if (empty($_POST['forum_name']) || empty($_POST['forum_description'])) {
    $infos[] .= getLanguageString("fillAllFields");
  } else {
    $forumName = $_POST['forum_name'];
    $forumDescription = $_POST['forum_description'];
    //* Check if name and description only spaces
    if (strlen(preg_replace('/\s/u', '', $forumName)) >= 1 && strlen(preg_replace('/\s/u', '', $forumDescription)) >= 1) {
      //* Remove spaces at beginning and end
      $forumName = trim($forumName);
      $forumDescription = trim($forumDescription);
    } else {
      $infos[] .= getLanguageString("fillAllFields");
    }
  }
} else {
  $errors[] .= getLanguageString("noPermission");
}
#endregion

if (!empty($errors) || !empty($infos)) {
  foreach ($errors as $error) {
    echo error($error);
  }

  foreach ($infos as $info) {
    echo info($info);
  }
} else {
  //* Check if Forum Categorie selected/create one
  $forumCategory = $_POST['category'];

  //* Decide to create / use a category
  if ($forumCategory == getLanguageString('newCategory')) {
    //* Prepare category
    if (empty($_POST['category_name']) || strlen(trim($_POST['category_name'])) == 0) {
      $infos[] .= getLanguageString("fillAllFields");
    } else {
      $forumCategoryName = trim($_POST['category_name']);

      $sth = $dfPDO->prepare("INSERT INTO forum_categories (name, creator) VALUES (:name, :creator)");
      $sth->execute(array(
        'name' => $forumCategoryName,
        'creator' => $user_data['user_id']
      ));

      if ($sth) {
        $lastInsertedID = $dfPDO->lastInsertId();
        $sth = $dfPDO->prepare("INSERT INTO forums (category_id, creator, name, description) VALUES (:categoryID, :creator, :name, :description)");
        $sth->execute(array(
          'categoryID' => $lastInsertedID,
          'creator' => $user_data['user_id'],
          'name' => $forumName,
          'description' => $forumDescription
        ));
        if ($sth) {
          echo success(getLanguageString("forumCreatedSuccessfully"));
          ajaxRedirect();
          ?>
        <meta http-equiv="refresh" content="0">
      <?php

    } else {
      $errors[] .= getLanguageString("unexpectedError");
    }
  } else {
    $errors[] .= getLanguageString("unexpectedError");
  }
}
    //* Create category
} else {
  $sth = $dfPDO->prepare("SELECT category_id FROM forum_categories WHERE name = :name");
  $sth->execute(array(
    'name' => $forumCategory
  ));
  if ($sth) {
    $forumCategoryId = $sth->fetch(PDO::FETCH_COLUMN);
    $sth = $dfPDO->prepare("INSERT INTO forums (category_id, creator, name, description) VALUES (:categoryID, :creator, :name, :description)");
    $sth->execute(array(
      'categoryID' => $forumCategoryId,
      'creator' => $user_data['user_id'],
      'name' => $forumName,
      'description' => $forumDescription
    ));
    if ($sth) {
      echo success(getLanguageString("forumCreatedSuccessfully"));
      ajaxRedirect();
      ?>
          <meta http-equiv="refresh" content="0">
        <?php

      } else {
        $errors[] .= getLanguageString("unexpectedError");
      }
    } else {
      $errors[] .= getLanguageString("unexpectedError");
    }
  }
  if (!empty($errors) || !empty($infos)) {
    foreach ($errors as $error) {
      echo error($error);
    }

    foreach ($infos as $info) {
      echo info($info);
    }
  }
}
?>