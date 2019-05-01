<?php
$fid = $_GET['FID'];

//! Needs to be changed
$maxThreadsPerSite = 10;

$sth = $dfPDO->prepare('SELECT COUNT(thread_id) FROM threads WHERE forum_id = :forumID AND pinned = 0');
$sth->execute(array(
  'forumID' => $fid
));
$threadCount = $sth->fetch(PDO::FETCH_COLUMN);
$queryStart = 0;
$pagesNeeded = ceil($threadCount / $maxThreadsPerSite);
$currentPage = 1;
if (isset($_GET['page'])) {
  $currentPage = $_GET['page'];
  if ($currentPage > 1) {
    if ($currentPage <= $pagesNeeded) {
      $currentPageCount = $currentPage - 1;
      $queryStart = $currentPageCount * $maxThreadsPerSite;
    } else {
      $_SESSION['header'] = "/forums/" . $fid; ?>
        <meta http-equiv="refresh" content="0">
      <?php
      exit();
    }
  }
} else {
  $currentPage = 1;
} ?>
<div id="forumHeader">
  <div id="headerMargin">
    <h1>
      <a href="/forums" class="hoverUnderlineLR"><?php echo forumCategoryNameFromForumID($fid); ?></a>
      <i class="fal fa-angle-double-right"></i>
      <?php echo forumNameFromID($fid); ?>
      <?php
      if ($threadCount > $maxThreadsPerSite) {
        ?>
      <span id="pageSelector">
          <?php if ($currentPage >= 2) { ?>
          <button class="not" onclick="goTo('/forums/ForumID=<?php echo $fid ?>')"><<</button>
          <button class="not" onclick="goTo('/forums/ForumID=<?php echo $fid ?>/page/<?php echo $currentPage - 1 ?>')"><</button>
          <?php
        } ?>
          <p>Page</p>
          <input onkeyup="handlePageChange(this)" id="pageSelectorTXT" class="not" type="text" value="<?php echo $currentPage; ?>">
          <button onclick="selectPage(this)" class="not">Go</button>
          <p> of <?php echo $pagesNeeded; ?></p>
          <?php if ($currentPage < $pagesNeeded) { ?>
          <button class="not" onclick="goTo('/forums/ForumID=<?php echo $fid ?>/page/<?php echo $currentPage + 1 ?>')">></button>
          <button class="not" onclick="goTo('/forums/ForumID=<?php echo $fid ?>/page/<?php echo $pagesNeeded ?>')">>></button>
          <?php
        } ?>
      </span>
      <?php

    } ?>
    </h1>
  </div>
</div>
<?php
$sth = $dfPDO->prepare('SELECT * FROM threads WHERE pinned = 2 AND forum_id = :forumID ORDER BY thread_id DESC');
$sth->execute(array(
  'forumID' => $fid
));
$rowCount = $sth->rowCount();
if ($rowCount
  > 0) {
  ?>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo getLanguageString("forumAnnouncements"); ?>
      </h1>
    </div>
    <div id="forumContent">
      <table>
        <thead>
          <tr class="not">
            <td>
              <h1>
                <?php echo getLanguageString("threads"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("replies"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("views"); ?>
              </h1>
            </td>
            <!--
            //TODO Make this work
            <td>
              <h1>
                <?php echo getLanguageString("latestReplies"); ?>
              </h1>
            </td> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sth->fetchAll() as $row) { ?>
          <tr>
            <td>
              <img id="<?php if (strlen($row['description']) == 0) {
              echo "regularForumHead";
              }?>" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatarFromID($row['creator'], 32); ?>" width="32px" height="32px">
              <div>
                <h3>
                  <a href="/forums/ThreadID=<?php echo $row['thread_id'] ?>" class="hoverUnderlineLR">
                    <?php echo $row['name']; ?>
                  </a>
                </h3>
                <h4 class="forumDescription">
                  <?php echo $row['description']; ?>
                </h4>
                <h4>
                  <?php echo getLanguageString("by"); ?>
                  <a class="noHovLR<?php
                  $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $row['creator']);
                  $rankText = $sth->fetch(PDO::FETCH_COLUMN);
                  echo " $rankText";
                  ?>">
                    <?php echo usernameFromID($row['creator']); ?>
                  </a>
                </h4>
              </div>
            </td>
            <td>
              <?php echo $row['replies']; ?>
            </td>
            <td>
              <?php echo $row['views']; ?>
            </td>
            <!--<td>
              <?php echo $row['latest']; ?>
            </td> -->
          </tr>
          <?php

        } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php

}

$sth = $dfPDO->prepare('SELECT * FROM threads WHERE pinned = 1 AND forum_id = :forumID ORDER BY thread_id DESC');
$sth->execute(array(
  'forumID' => $fid
));

$rowCount = $sth->rowCount();
if ($rowCount
  > 0) {
  ?>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo getLanguageString("pinnedThreads"); ?>
      </h1>
    </div>
    <div id="forumContent">
      <table>
        <thead>
          <tr class="not">
            <td>
              <h1>
                <?php echo getLanguageString("threads"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("replies"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("views"); ?>
              </h1>
            </td>
            <!-- <td>
              <h1>
                <?php echo getLanguageString("latestReplies"); ?>
              </h1>
            </td> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sth->fetchAll() as $row) { ?>
          <tr>
            <td>
              <img id="<?php if (strlen($row['description']) == 0) {
              echo "regularForumHead";
            }?>" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatarFromID($row['creator'], 32); ?>" width="32px" height="32px">
              <div>
                <h3>
                  <a href="/forums/ThreadID=<?php echo $row['thread_id'] ?>" class="hoverUnderlineLR">
                    <?php echo $row['name']; ?>
                  </a>
                </h3>
                <h4 class="forumDescription">
                  <?php echo $row['description']; ?>
                </h4>
                <h4>
                  <?php echo getLanguageString("by"); ?>
                  <a class="noHovLR<?php
                  $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $row['creator']);
                  $rankText = $sth->fetch(PDO::FETCH_COLUMN);
                  echo " $rankText";
                  ?>">
                    <?php echo usernameFromID($row['creator']); ?>
                  </a>
                </h4>
              </div>
            </td>
            <td>
              <?php echo $row['replies']; ?>
            </td>
            <td>
              <?php echo $row['views']; ?>
            </td>
            <!-- <td>
              <?php echo $row['latest']; ?>
            </td> -->
          </tr>
          <?php

        } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php

}
$sth = $dfPDO->prepare('SELECT * FROM threads WHERE pinned = 0 AND forum_id = :forumID ORDER BY thread_id DESC LIMIT ' . $queryStart . ',' . $maxThreadsPerSite);
$sth->execute(array(
  'forumID' => $fid
));

$rowCount = $sth->rowCount();
?>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo getLanguageString("threads"); ?>
      </h1>
    </div>
    <div id="forumContent">
      <table>
        <thead>
          <tr class="not">
            <td>
            <?php if (permLevel() >= 1) {
              if ($rowCount
                > 0) {
                ?>
              <button id="newThread" onclick="goTo('/newthread?FID=<?php echo $_GET['FID']; ?>')">
                <h1 class="not">
                  <?php echo getLanguageString("newThread"); ?>
                </h1>
              </button>
            <?php

          }
        } ?>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("replies"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("views"); ?>
              </h1>
            </td>
            <!-- <td>
              <h1>
                <?php echo getLanguageString("latestReplies"); ?>
              </h1>
            </td> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sth->fetchAll() as $row) { ?>
          <tr>
            <td>
              <img id="<?php if (strlen($row['description']) == 0) {
              echo "regularForumHead";
              }?>" draggable="false" src="<?php echo IMAGES ?>loader.svg" data-src="<?php echo avatarFromID($row['creator'], 32); ?>" width="32px" height="32px">
              <div>
                <h3>
                  <a href="/forums/ThreadID=<?php echo $row['thread_id'] ?>" class="hoverUnderlineLR">
                    <?php echo $row['name']; ?>
                  </a>
                </h3>
                <h4 class="forumDescription">
                  <?php echo $row['description']; ?>
                </h4>
                <h4>
                  <?php echo getLanguageString("by"); ?>
                  <a class="noHovLR<?php
                  $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $row['creator']);
                  $rankText = $sth->fetch(PDO::FETCH_COLUMN);
                  echo " $rankText";
                  ?>">
                    <?php echo usernameFromID($row['creator']); ?>
                  </a>
                </h4>
              </div>
            </td>
            <td>
              <?php echo $row['replies']; ?>
            </td>
            <td>
              <?php echo $row['views']; ?>
            </td>
            <!-- <td>
              <?php echo $row['latest']; ?>
            </td> -->
          </tr>
          <?php

        } ?>
        </tbody>
        <?php if (permLevel() >= 1 && $sth->fetch(PDO::FETCH_COLUMN) == 0) { ?>
        <tfoot>
          <tr class="not">
            <td>
              <button id="newThread" onclick="goTo('/newthread?FID=<?php echo $_GET['FID']; ?>')">
              <h1>
                <?php echo getLanguageString("newThread"); ?>
              </h1>
            </button>
          </td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
        <?php

      } ?>
      </table>
    </div>
  </div>
  <script>
    function handlePageChange(input) {
      var page = $(input).val();
      if(page != "") {
        if(page <= 0 || page > <?php echo $pagesNeeded ?>) {
          $(input).val(<?php echo $currentPage ?>)
        }
      }
      console.log(page);

    }

    function selectPage(button) {
      var page = $('#pageSelectorTXT').val();
      if(page > 0 || page <= <?php echo $pagesNeeded ?>) {
        if(page != <?php echo $currentPage; ?>) {
          document.location.href = "/forums/forumID=<?php echo $fid ?>/page/" + page;
          //!Finish Thread Selection HTML
        }
      }
    }
  </script>
