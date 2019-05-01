<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

if (isset($_SESSION['header'])) {
  $header = $_SESSION['header'];
  unset($_SESSION['header']);
  header($header);
}

$sth = $dfPDO->prepare('SELECT * FROM replies WHERE reply_id = :replyID');
$sth->execute(array('replyID' => $_GET['RID']));

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
    <title>
      <?php $pageTitle = getLanguageString("pageEditReplyTitle");
      echo $pageTitle; ?></title>
    </title>
    <?php require_once $root . 'assets/php/requires/head.php'; ?>
    <link href="<?php echo CSS . 'editReply.css'; ?>" rel="stylesheet">
  </head>

  <body>
    <?php require_once REQUIRES . 'header.php'; ?>
    <?php require_once $root . 'assets/php/requires/background.php'; ?>
    <div id="content">
      <div id="error-output"></div>
      <div id="fullWidthPanelWrapper">
        <div id="panelHeading">
          <h1><?php echo getLanguageString("editReply") ?></h1>
        </div>
        <div id="panelContent">
          <div id="editorWrapper">
            <textarea id="editor"><?php echo $row['content']; ?></textarea>
          </div>
        </div>
        <div id="actions">
          <button id="saveBtn" onclick="save(this)"><?php echo getLanguageString("save"); ?></button>
        </div>
      </div>
    </div>
    <?php require_once REQUIRES . 'footer.php'; ?>
  </body>
  <script src="<?php echo $page; ?>assets/editor/jquery.sceditor.bbcode.min.js"></script>
  <script src="<?php echo $page; ?>assets/editor/icons/monocons.js"></script>
  <script src="<?php echo $page; ?>assets/editor/formats/bbcode.js"></script>
  <script>
    $('#editor').sceditor({
      plugins: "autosave,undo",
      toolbarExclude: 'time,date,email,print,source,font',
      charset: 'utf-8',
      enablePasteFiltering: true,
      width: "calc(100% - 20px)",
      height: "300px",
      resizeWidth: false,
      icons: 'monocons',
      style: 'assets/editor/themes/content/default.min.css',
      bbcodeTrim: true,
      emoticonsEnabled: true,
      emoticons: {
        dropdown: {
          ":air:": "<?php echo $page; ?>assets/images/emojis/air.png",
          ":bracket_left:": "<?php echo $page; ?>assets/images/emojis/bracket_left.png",
          ":bracket_right:": "<?php echo $page; ?>assets/images/emojis/bracket_right.png",
          ":break:": "<?php echo $page; ?>assets/images/emojis/break.png",
          ":call_function:": "<?php echo $page; ?>assets/images/emojis/call_function.png",
          ":chest:": "<?php echo $page; ?>assets/images/emojis/chest.png",
          ":chest_inverse:": "<?php echo $page; ?>assets/images/emojis/chest_inverse.png",
          ":connector:": "<?php echo $page; ?>assets/images/emojis/connector.png",
          ":entity_action:": "<?php echo $page; ?>assets/images/emojis/entity_action.png",
          ":entity_event:": "<?php echo $page; ?>assets/images/emojis/entity_event.png",
          ":function:": "<?php echo $page; ?>assets/images/emojis/function.png",
          ":game_action:": "<?php echo $page; ?>assets/images/emojis/game_action.png",
          ":if_entity:": "<?php echo $page; ?>assets/images/emojis/if_entity.png",
          ":if_game:": "<?php echo $page; ?>assets/images/emojis/if_game.png",
          ":if_player:": "<?php echo $page; ?>assets/images/emojis/if_player.png",
          ":if_variable:": "<?php echo $page; ?>assets/images/emojis/if_variable.png",
          ":location:": "<?php echo $page; ?>assets/images/emojis/location.png",
          ":particle_effect:": "<?php echo $page; ?>assets/images/emojis/particle_effect.png",
          ":loop:": "<?php echo $page; ?>assets/images/emojis/loop.png",
          ":number:": "<?php echo $page; ?>assets/images/emojis/number.png",
          ":player_action:": "<?php echo $page; ?>assets/images/emojis/player_action.png",
          ":player_event:": "<?php echo $page; ?>assets/images/emojis/player_event.png",
          ":potion_effect:": "<?php echo $page; ?>assets/images/emojis/potion_effect.png",
          ":repeat:": "<?php echo $page; ?>assets/images/emojis/repeat.png",
          ":select_object:": "<?php echo $page; ?>assets/images/emojis/select_object.png",
          ":set_variable:": "<?php echo $page; ?>assets/images/emojis/set_variable.png",
          ":sound_effect:": "<?php echo $page; ?>assets/images/emojis/sound_effect.png",
          ":special_spawn_egg:": "<?php echo $page; ?>assets/images/emojis/special_spawn_egg.png",
          ":text:": "<?php echo $page; ?>assets/images/emojis/text.png",
          ":value:": "<?php echo $page; ?>assets/images/emojis/value.png",
          ":variable:": "<?php echo $page; ?>assets/images/emojis/variable.png",
          ":variable_items:": "<?php echo $page; ?>assets/images/emojis/variable_items.png"
        },
        hidden: {
          ":chest_inv:": "<?php echo $page; ?>assets/images/emojis/chest_inverse.png",
          ":callfunction:": "<?php echo $page; ?>assets/images/emojis/call_function.png",
          ":entityaction:": "<?php echo $page; ?>assets/images/emojis/entity_action.png",
          ":entityevent:": "<?php echo $page; ?>assets/images/emojis/entity_event.png",
          ":gameaction:": "<?php echo $page; ?>assets/images/emojis/game_action.png",
          ":ifentity:": "<?php echo $page; ?>assets/images/emojis/if_entity.png",
          ":ifgame:": "<?php echo $page; ?>assets/images/emojis/if_game.png",
          ":ifplayer:": "<?php echo $page; ?>assets/images/emojis/if_player.png",
          ":ifvar:": "<?php echo $page; ?>assets/images/emojis/if_variable.png",
          ":loop~1:": "<?php echo $page; ?>assets/images/emojis/loop.png",
          ":particleeffect:": "<?php echo $page; ?>assets/images/emojis/particle_effect.png",
          ":playeraction:": "<?php echo $page; ?>assets/images/emojis/player_action.png",
          ":playerevent:": "<?php echo $page; ?>assets/images/emojis/player_event.png",
          ":potioneffect:": "<?php echo $page; ?>assets/images/emojis/potion_effect.png",
          ":repeat~1:": "<?php echo $page; ?>assets/images/emojis/repeat.png",
          ":selectobject:": "<?php echo $page; ?>assets/images/emojis/select_object.png",
          ":setvar:": "<?php echo $page; ?>assets/images/emojis/set_variable.png",
          ":soundeffect:": "<?php echo $page; ?>assets/images/emojis/sound_effect.png",
          ":specialspawnegg:": "<?php echo $page; ?>assets/images/emojis/special_spawn_egg.png",
          ":variableitems:": "<?php echo $page; ?>assets/images/emojis/variable_items.png"
        }
      }
    })

    function save(button) {
      button = $(button)

      var submitText = button.html()
      startCallback(button)
      $.ajax({
        type: "POST",
        url: "<?php echo $page; ?>assets/php/core/actions/savereply.php",
        data: {
          content: $('#editor').sceditor('instance').val(),
          RID: "<?php echo $_GET['RID']; ?>"
          },
        success: function(data)
        {
          callback(button, submitText, data)
        }
      });
    }
  </script>
  <link rel="stylesheet" href="assets/editor/themes/default.min.css" />
  <link rel="stylesheet" href="<?php echo $page; ?>assets/css/main.css" />
</html>
