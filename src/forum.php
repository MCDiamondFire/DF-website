<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

if (isset($_GET['FID'])) {
  $fid = $_GET['FID'];
  $sth = $dfPDO->prepare(
    'SELECT forum_id FROM forums WHERE forum_id = :forumID'
  );
  $sth->execute(array('forumID' => $fid));
  if (!$sth->rowCount()) {
    header('Location: /forums/');
    exit();
  }
}

if (isset($_GET['THID'])) {
  $thid = $_GET['THID'];
  $sth = $dfPDO->prepare(
    'SELECT thread_id FROM threads WHERE thread_id = :threadID'
  );
  $sth->execute(array('threadID' => $thid));
  if (!$sth->rowCount()) {
    header('Location: /forums/');
    exit();
  }
}
?>
<html prefix="og: http://ogp.me/ns#">
  <head>
    <?php
    require_once REQUIRES . 'forumSEO.php';
    require_once REQUIRES . 'head.php';
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $page; ?>assets/css/forums.css">
  </head>

  <body>
    <?php require_once REQUIRES . 'header.php'; ?>
    <div id="content">
      <?php require_once REQUIRES . 'background.php'; ?>
      <div id="error-output"></div>
        <?php if (!isset($_GET['THID'])) {
          if (!isset($_GET['FID'])) {
            require_once REQUIRES . 'forums.php';
          } else {
            require_once REQUIRES . 'threads.php';
          }
        } else {
          require_once REQUIRES . 'threadview.php';
        } ?>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>

  <script>
    <?php if (permLevel() >= 7 && !isset($_GET['FID']) && !isset($_GET['THID'])) { ?>
    $(document).ready(function () {
      var e = document.getElementById("selectCategory");
      var selectObject = e.options[e.selectedIndex].value;
      if (selectObject == "<?php echo getLanguageString("newCategory"); ?>") {
        $('#newCatName').toggleClass('hidden')
      } else {
        $('#newCatName').addClass('hidden')
      }
    })

    <?php
  } ?>

function toggleNewCatTXTBox(selectObject) {
  if (selectObject.value == "<?php echo getLanguageString("newCategory"); ?>") {
    $('#newCatName').toggleClass('hidden')
  } else {
    $('#newCatName').addClass('hidden')
  }
}

function deleteForum(button, forumName, forumID) {
  button = $(button)

  var submitText = button.html()
  startCallback(button)
  var checkForumName = prompt(
    "Are you sure you want to delete this forum? Every thread and reply in that forum will be deleted.\nType the name of the Forum to continue.\n\n" +
    forumName, "")
  if (checkForumName == forumName) {
    ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>deleteForum.php', {'forumID': forumID})
  } else {
    if (checkForumName == null) {
      stopCallback(button, submitText)
    } else {
      alert('Incorrect!')
      stopCallback(button, submitText)
    }
  }
}

function deleteCategory(button, categoryName, categoryID, forumCount) {
  button = $(button)

  var submitText = button.html()
  startCallback(button)
  if(forumCount != 0) {
    var categoryNamePrompt = prompt(
      "Are you sure you want to delete this forum category? Every Forum, thread and reply in that category will be deleted.\nType the name of the Forum to continue.\n\n" +
      categoryName, "")
    if (categoryNamePrompt == categoryName) {
      ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>deleteForumCategory.php', {'forumCategoryID': categoryID})
    } else {
      if (categoryName == null) {
        stopCallback(button, submitText)
      } else {
        alert('Incorrect!')
        stopCallback(button, submitText)
      }
    }
  } else {
    $.ajax({
      type: "POST",
      url: '<?php echo ACTIONS; ?>deleteForumCategory.php',
      data: {
        'forumCategoryID': categoryID
      },
      success: function (data) {
        callback(button, submitText, data)
      }
    });
  }
}

function toggleForumLock(button, forumID) {
  button = $(button)
  var submitText = button.html()
  ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>toggleForumLock.php', {'forumID': forumID})
}

function toggleThreadLock(button, threadID) {
  button = $(button)
  var submitText = button.html()
  ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>toggleThreadLock.php', {'threadID': threadID})
}

function toggleThreadPin(button, threadID) {
  button = $(button)
  var submitText = button.html()
  ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>toggleThreadPin.php', {'threadID': threadID})
}

function deleteThread(button, threadID) {
  button = $(button)

  var submitText = button.html()
  var checkForumName = confirm(
    "Are you sure you want to delete this thread? Every reply in that thread will be deleted.")
  if (checkForumName == true) {
    ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>deleteThread.php', {'threadID': threadID})
  }
}

function deleteReply(button, replyID) {
  button = $(button)

  var submitText = button.html()
  var checkForumName = confirm(
    "Are you sure you want to delete this reply?")
  if (checkForumName == true) {
    ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>deleteReply.php', {'replyID': replyID})
  }
}

function likeReply(button, replyID) {
  button = $(button)
  var submitText = button.html()
  ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>likeReply.php', {'replyID': replyID})
}

function likeThread(button, threadID) {
  button = $(button)
  var submitText = button.html()
  ajaxRedirectRequest(button, submitText, '<?php echo ACTIONS; ?>likeThread.php', {'threadID': threadID})
}
  </script>
</html>
