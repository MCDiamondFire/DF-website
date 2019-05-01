<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

if (permLevel() < 5) {
    header('Location: /');
}
?>

<html>
  <head>
    <title><?php $pageTitle = getLanguageString("pageModPanelTitle");
    echo $pageTitle; ?></title>
    <?php require_once REQUIRES . 'head.php'; ?>
    <link href="<?php echo CSS . 'modpanel.css'; ?>" rel="stylesheet">
  </head>
  <body>
    <div id="error-output"></div>
    <div id="content">
      <?php
require_once REQUIRES . 'header.php';
require_once REQUIRES . 'background.php';
?>

      <div id="panelWrapper">
        <div id="panel">
          <div id="userPanel">
            <h1><?php echo $usersTXT; ?></h1>
            <table>
              <thead>
                <tr>
                  <td>
                    <h1>
                      <?php echo $usernameTXT; ?>
                    </h1>
                  </td>
                  <td>
                    <h1>
                      <?php echo $rankTXT; ?>
                    </h1>
                  </td>
                </tr>
              </thead>
              <tbody>
                <?php
$sth = $dfPDO->query('SELECT * FROM accounts');
foreach ($sth->fetchAll() as $row) { ?>
                <tr>
                  <td>
                  <img draggable="false" data-src="<?php echo avatarFromID($row['user_id'], 16); ?>">
                    <?php echo $row['username']; ?></td>
                  <td><?php echo $row['rank']; ?></td>
                </tr>
                <?php }
?>
              </tbody>
            </table>
          </div>
        </div>
        <div id="panel">
          <div id="blacklist">
            <h1><?php echo $blacklistTXT; ?></h1>
            <table>
              <thead>
                <tr>
                  <td>
                    <h1>
                      <?php echo $wordTXT; ?>
                    </h1>
                  </td>
                  <td>
                    <h1>
                      <?php echo $creatorTXT; ?>
                    </h1>
                  </td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php
$sth = $dfPDO->query('SELECT * FROM blacklist');
foreach ($sth->fetchAll() as $row) { ?>
                <tr>
                  <td><?php echo $row['word']; ?></td>
                  <td><?php echo usernameFromID($row['creator']); ?></td>
                  <td>
                    <button onclick="removeWord(this, '<?php echo $row['word']; ?>')">
                      <i class="far fa-times-circle"></i>
                    </button>
                  </td>
                </tr>
                <?php }
?>
              </tbody>
            </table>
            <div id="actions">
              <form class="ajax" autocomplete="off" action="<?php echo $page; ?>assets/php/core/actions/addToBlacklist.php" method="post">
              <input type="text" name="word" placeholder="<?php echo $enterWordTXT; ?>">
              <button type="submit"><?php echo $addTXT; ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>

  <script>
    function removeWord(button, word) {
      button = $(button)

    var submitText = button.html()
    startCallback(button)
      $.ajax({
        type: "POST",
        url: '<?php echo ACTIONS; ?>removeFromBlacklist.php',
        data: {
          'word': word
        },
        success: function (data) {
          callback(button, submitText, data)
        }
      });
    }
  </script>
</html>
