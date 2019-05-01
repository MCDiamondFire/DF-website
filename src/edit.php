<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

if (isset($_SESSION['header'])) {
  $header = $_SESSION['header'];
  unset($_SESSION['header']);
  header($header);
}

$sth = $dfPDO->prepare('SELECT * FROM threads WHERE thread_id = :threadID');
$sth->execute(array('threadID' => $_GET['THID']));

$row = $sth->fetch(PDO::FETCH_ASSOC);

if ($sth->rowCount() == 0) {
  header('Location: /forums/');
}
if (!logged_in()) {
  header('Location: /login');
}
if ($row['creator'] != $user_data['user_id']) {
  header('Location: /forums/');
}
?>

<html>
  <head>
    <title><?php $pageTitle = getLanguageString("pageEditThreadTitle");
    echo $pageTitle; ?></title>
    <?php require_once $root . 'assets/php/requires/head.php'; ?>
  </head>

  <body>

    <?php require_once $root . 'assets/php/requires/background.php'; ?>
    <div id="content">
      <div id="error-output"></div>
      <div>
        <div>
          <input maxlength="32" type="text" id="name" placeholder="<?php echo $threadNameTXT; ?>" value="<?php echo $row['name']; ?>">
          <textarea id="editor"><?php echo $row['content']; ?></textarea>
          <button onclick="save()"><?php echo $saveTXT; ?></button>
        </div>
      </div>
    </div>
  </body>
  <script src="<?php echo $page; ?>assets/editor/jquery.sceditor.bbcode.min.js"></script>
  <script src="<?php echo $page; ?>assets/editor/icons/monocons.js"></script>
  <script src="<?php echo $page; ?>assets/editor/formats/bbcode.js"></script>
  <script>
    $('#editor').sceditor({
      plugins: "bbcode",
      toolbarExclude: 'emoticon,time,date,email,quote,print,source,font',
      width: "90%",
      height: "300px",
      resizeWidth: false,
      icons: 'monocons',
      style: 'assets/editor/themes/content/default.min.css',
      bbcodeTrim: true,
      emoticonsEnabled: false,
      emoticons: {}
    })

    function save() {
      $.ajax({
        type: "POST",
        url: "<?php echo $page; ?>assets/php/core/actions/postthread.php",
        data: {
          name: $('#name').val(),
          content: $('#editor').sceditor('instance').val(),
          THID: "<?php echo $_GET['THID']; ?>"
          },
        success: function(data)
        {
          $('#error-output').html(data)
        }
      });
    }
  </script>
  <link rel="stylesheet" href="assets/editor/themes/default.min.css" />
  <link rel="stylesheet" href="<?php echo $page; ?>assets/css/main.css" />
</html>
