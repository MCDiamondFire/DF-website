<?php
$sth = $dfPDO->prepare('SELECT views FROM threads WHERE thread_id = :threadID');

$sth->execute(array(
  'threadID' => $_GET['THID']
));

$views = $sth->fetch(PDO::FETCH_COLUMN);
$views = $views + 1;
$sth = $dfPDO->prepare('UPDATE threads SET views = :views WHERE thread_id = :threadID');

$sth->execute(array(
  'views' => $views,
  'threadID' => $_GET['THID']
));

$sth = $dfPDO->prepare('SELECT * FROM threads WHERE thread_id = :threadID');

$sth->execute(array(
  'threadID' => $_GET['THID']
));

foreach ($sth->fetchAll() as $row) {
  ?>
  <div id="forumHeader">
    <div id="headerMargin">
      <h1>
        <a href="/forums" class="hoverUnderlineLR"><?php echo forumCategoryNameFromForumID(getForumIDFromThreadID($_GET['THID'])); ?></a>
        <i class="fal fa-angle-double-right"></i>
        <a href="/forums/ForumID=<?php echo getForumIDFromThreadID($_GET['THID']); ?>" class="hoverUnderlineLR"><?php echo forumNameFromID(getForumIDFromThreadID($_GET['THID'])); ?></a>
        <i class="fal fa-angle-double-right"></i>
        <?php echo $row['name'] ?>
      </h1>
    </div>
  </div>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo $row['name']; ?>
      </h1>
    </div>
    <div id="authorInfo">
      <img id="big" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatar3DFromID($row['creator'], 64); ?>">
      <img id="small" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatarFromID($row['creator'], 40); ?>">
      <h3>
        <a class="noHovLR <?php
        $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $row['creator']);
        $rankText = $sth->fetch(PDO::FETCH_COLUMN);
        echo $rankText;
        ?>">
          <?php echo usernameFromID($row['creator']); ?>
        </a>
      </h3>
    </div>
    <div id="threadViewContent">
      <div id="threadContent">
        <?php echo $row['content']; ?>
      </div>
    </div>
    <div id="actions">
        <?php
        if (permLevel() >= 1 && $user_data['user_id'] == $row['creator'] && $row['locked'] != 1 || permLevel() >= 5) { ?>
        <button onclick="deleteThread(this, <?php echo $row['thread_id']; ?>)">
          <i class="fal fa-trash-alt"></i>
        </button>
        <?php if (permLevel() >= 5) {
          if ($row['locked'] == 1) { ?>
        <button onclick="toggleThreadLock(this, '<?php echo $row['thread_id'] ?>')">
          <i class="fal fa-lock-open"></i>
        </button>
        <?php

      } else { ?>
        <button onclick="toggleThreadLock(this, '<?php echo $row['thread_id'] ?>')">
          <i class="fal fa-lock"></i>
        </button>
        <?php

      }
    }
  }
  if (permLevel() >= 7) {
    if ($row['pinned'] == 1) {
      ?>
        <button onclick="toggleThreadPin(this, '<?php echo $row['thread_id'] ?>')">
          <i class="fal fa-thumbtack fa-rotate-90"></i>
        </button>
        <?php

      } else { ?>
        <button onclick="toggleThreadPin(this, '<?php echo $row['thread_id'] ?>')">
          <i class="fal fa-thumbtack"></i>
        </button>
        <?php

      }
    }
    if (permLevel() >= 1) {
      if ($row['locked'] == 1 && $row['creator'] == $user_data['user_id'] && permLevel() >= 5 || $row['locked'] != 1) { ?>
        <button id="reply" onclick="goTo('/replythread?THID=<?php echo $row['thread_id']; ?>')">
          <i class="fal fa-reply"></i>
        </button>
        <?php

      }
      if ($row['locked'] != 1 && $user_data['user_id'] == $row['creator'] || permLevel() >= 5 && $user_data['user_id'] == $row['creator']) { ?>
        <button id="edit" onclick="goTo('/editthread?THID=<?php echo $row['thread_id']; ?>')">
          <i class="fal fa-edit"></i>
        </button>
        <?php

      }
    }
    if (permLevel() >= 1 && $row['locked'] != 1 && $user_data['user_id'] != $row['creator']) { ?>
        <button id="likes" onclick="likeThread(this, <?php echo $row['thread_id']; ?>)">
          <p>
            <?php
            $sth = $dfPDO->query('SELECT COUNT(user) FROM threadLikes WHERE thread_id = ' . $row['thread_id']);

            echo $sth->fetch(PDO::FETCH_COLUMN) ?>
          </p>
          <i class="fal fa-thumbs-up"></i>
        </button>
    <?php

  } else { ?>
    <div id="likesDiv">
      <p>
        <?php
        $sth = $dfPDO->query('SELECT COUNT(user) FROM threadLikes WHERE thread_id = ' . $row['thread_id']);

        echo $sth->fetch(PDO::FETCH_COLUMN) ?>
        </p>
        <i class="fal fa-thumbs-up"></i>
      </div>
    <?php

  } ?>
    </div>
  </div>
  <?php

}

$sth = $dfPDO->prepare('SELECT * FROM replies WHERE thread_id = :threadID');

$sth->execute(array(
  'threadID' => $_GET['THID']
));

foreach ($sth->fetchAll() as $row) {
  ?>
  <div id="forumContainer" class="rounded">
    <div id="authorInfo">
      <img id="big" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatar3DFromID($row['creator'], 64); ?>">
      <img id="small" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatarFromID($row['creator'], 40); ?>">

      <h3>
        <a class="noHovLR <?php
        $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $row['creator']);
        $rankText = $sth->fetch(PDO::FETCH_COLUMN);
        echo $rankText;
        ?>">
          <?php echo usernameFromID($row['creator']); ?>
        </a>
      </h3>
    </div>
    <div id="threadViewContent" class="replyMargin">
      <div id="threadContent">
        <?php echo $row['content']; ?>
      </div>
    </div>
    <div id="actions">
        <?php
        $sth = $dfPDO->prepare('SELECT * FROM threads WHERE thread_id = :thread_ID');
        $sth->execute(array(
          'thread_ID' => $_GET['THID']
        ));
        $row1 = $sth->fetch(PDO::FETCH_ASSOC);

        if (permLevel() >= 1 && $user_data['user_id'] == $row['creator'] && $row1['locked'] != 1 || permLevel() >= 5) { ?>
        <button onclick="deleteReply(this, <?php echo $row['reply_id']; ?>)">
          <i class="fal fa-trash-alt"></i>
        </button>
        <?php

      }
      if (permLevel() >= 1) {
        if ($row1['locked'] != 1 && $user_data['user_id'] == $row['creator'] || permLevel() >= 7 && $user_data['user_id'] == $row['creator']) { ?>
        <button id="edit" onclick="goTo('/editreply?RID=<?php echo $row['reply_id']; ?>')">
          <?php echo getLanguageString("editReply"); ?>
        </button>
        <?php

      }
    }
    if (permLevel() >= 1 && $row1['locked'] != 1 && $user_data['user_id'] != $row['creator']) { ?>
        <button id="likes" onclick="likeReply(this, <?php echo $row['reply_id']; ?>)">
          <p>
            <?php
            $sth = $dfPDO->query('SELECT COUNT(user) FROM replyLikes WHERE reply_id = ' . $row['reply_id']);

            echo $sth->fetch(PDO::FETCH_COLUMN) ?>
          </p>
          <i class="fal fa-thumbs-up"></i>
        </button>
    <?php

  } else { ?>
    <div id="likesDiv">
      <p>
        <?php
        $sth = $dfPDO->query('SELECT COUNT(user) FROM replyLikes WHERE reply_id = ' . $row['reply_id']);

        echo $sth->fetch(PDO::FETCH_COLUMN) ?>
      </p>
      <i class="fal fa-thumbs-up"></i>
    </div>
    <?php

  } ?>
      </div>
</div>
    <?php

  } ?>
