<?php
if (!isset($_GET['THID'])) {
  if (!isset($_GET['FID'])) {
    $pageTitle = getLanguageString("pageForumTitle"); ?>
    <title><?php echo $pageTitle ?></title>
    <meta name="description" content="The DiamondFire Forums, Feel free to chat here!"/>
    <meta property="og:title" content="<?php echo getLanguageString("pageForumTitle"); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="The DiamondFire Forums, Feel free to chat here!"/>
    <meta property="og:url" content="<?php echo $page; ?>" />
    <meta property="og:image" content="<?php echo $page; ?>assets/images/logo.png" />
    <?php

  } else {
    $forum = $dfPDO->prepare('SELECT * FROM forums WHERE forum_id = :FID');
    $forum->execute(array(
      'FID' => $_GET['FID']
    ));
    $forum = $forum->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php
    $pageTitle = str_replace('%FORUMNAME%', $forum['name'], getLanguageString("pageForumForumsTitle"));
    ?>
    <meta property="og:title" content="<?php echo $pageForumTXT; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="<?php echo $forum['description'] ?>" />
    <meta property="og:url" content="<?php echo $page; ?>" />
    <meta property="og:image" content="<?php echo IMAGES; ?>logo.png" />
    <meta property="og:site_name" content="<?php echo $pageTitle; ?>" />
    <title><?php echo $pageTitle; ?></title>

    <?php

  }
} else {
  $thread = $dfPDO->prepare('SELECT * FROM threads WHERE thread_id = :THID');
  $thread->execute(array(
    'THID' => $_GET['THID']
  ));
  $thread = $thread->fetch(PDO::FETCH_ASSOC);

  $forum = $dfPDO->query('SELECT * FROM forums WHERE forum_id = ' . $thread['forum_id']);
  $forum = $forum->fetch(PDO::FETCH_ASSOC);
  ?>
    <meta property="og:title" content="<?php echo getLanguageString("pageForumTitle"); ?>" />
    <meta property="og:type" content="website" />
    <?php

    $pageTitle = str_replace('%FORUMNAME%', $forum['name'], getLanguageString("pageForumThreadsTitle"));
    $pageTitle = str_replace('%THREADNAME%', $thread['name'], $pageTitle);

    $replies = '0 Replies';
    if ($thread['replies'] == 1) $replies = '1 Reply';
    if ($thread['replies'] > 1) $replies = $thread['replies'] . ' Replies';

    $views = '0 Views';
    if ($thread['views'] == 1) $views = '1 View';
    if ($thread['views'] > 1) $views = $thread['views'] . ' Views';


    $likes = '0 Likes';
    $sth = $dfPDO->query('SELECT COUNT(user) FROM threadLikes WHERE thread_id = ' . $_GET['THID']);
    $threadLikes = $sth->fetch(PDO::FETCH_COLUMN);
    if ($threadLikes == 1) $likes = '1 Like';
    if ($threadLikes > 1) $likes = $threadLikes . ' Likes'; ?>
    <meta property="og:description" content="<?php echo $replies ?> &bull; <?php echo $views ?> &bull; <?php echo $likes ?>"
    <meta property="og:url" content="<?php echo $page; ?>" />
    <meta property="og:image" content="<?php echo head3DFromID($thread['creator'], 96); ?>" />
    <meta property="og:site_name" content="<?php echo $pageTitle; ?>" />
    <title><?php echo $pageTitle; ?></title>
  <?php

} ?>
