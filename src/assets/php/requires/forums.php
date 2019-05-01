<?php
$sth = $dfPDO->query('SELECT * FROM forum_categories');
foreach ($sth->fetchAll() as $row) {
  $sth = $dfPDO->query('SELECT * FROM forums WHERE category_id = ' . $row['category_id']);
  $rowCount = $sth->rowCount();
  ?>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo $row['name']; ?>
        <?php
        if (permLevel() >= 7) {
          ?>
        <button onclick="deleteCategory(this, '<?php echo $row['name'] ?>', <?php echo $row['category_id'] ?>, <?php echo $rowCount ?>)">
          <i class="fal fa-trash-alt"></i>
        </button>
        <?php
        } ?>
      </h1>
    </div>
    <div id="forumContent">
      <table>
        <thead>
          <tr class="not">
            <td>
              <h1>
                <?php echo getLanguageString("forums"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("threads"); ?>
              </h1>
            </td>
            <td>
              <h1>
                <?php echo getLanguageString("posts") ?>
              </h1>
            </td>
            <!-- <td>
              <h1>
                <?php echo getLanguageString("latestPosts") ?>
              </h1>
            </td> -->
          </tr>
        </thead>
        <tbody>
          <?php
          if ($rowCount != 0) {
            foreach ($sth->fetchAll() as $row) { ?>
          <tr>
            <td>
              <div>
                <h3>
                  <a href="/forums/ForumID=<?php echo $row['forum_id'] ?>" class="hoverUnderlineLR">
                    <?php echo $row['name']; ?>
                  </a>
                  <?php
                  if (permLevel() >= 7) { ?>
                    <button onclick="deleteForum(this, '<?php echo $row['name'] ?>', <?php echo $row['forum_id'] ?>)">
                      <i class="fal fa-trash-alt"></i>
                    </button>
                    <button onclick="goTo('<?php echo PAGE; ?>editForum?FID=<?php echo $row['forum_id'] ?>')">
                      <i class="fal fa-edit"></i>
                    </button>
                    <?php
                    if ($row['locked'] == 1) {
                      ?>
                    <button onclick="toggleForumLock(this, '<?php echo $row['forum_id'] ?>')">
                      <i class="fal fa-lock-open"></i>
                    </button>
                    <?php

                  } else { ?>
                    <button onclick="toggleForumLock(this, '<?php echo $row['forum_id'] ?>')">
                      <i class="fal fa-lock"></i>
                    </button>
                    <?php

                  }
                }
                ?>
                </h3>
                <h4>
                  <?php echo $row['description']; ?>
                </h4>
              </div>
            </td>
            <td>
              <?php echo $row['threads']; ?>
            </td>
            <td>
              <?php echo $row['posts']; ?>
            </td>
            <!-- <td>
              <?php echo $row['latest']; ?>
            </td> -->
          </tr>
          <?php

        }
      } else {
        ?>
      <tr>
        <td><?php echo getLanguageString("categoryEmpty"); ?></td>
      </tr>
      <?php

    } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php

}

if (permLevel() >= 7) { ?>
  <div id="forumContainer">
    <div id="forumHeading">
      <h1>
        <?php echo getLanguageString("forumManagement"); ?>
      </h1>
    </div>
    <div id="forumContent">

      <form class="ajaxRedirect" autocomplete="off" id="newForum" action="<?php echo ACTIONS; ?>createForum.php" method="post">
        <input type="text" name="forum_name" placeholder="<?php echo getLanguageString("forumName"); ?>">
        <input type="text" name="forum_description" placeholder="<?php echo getLanguageString("forumDescription"); ?>">
        <select id="selectCategory" onchange="toggleNewCatTXTBox(this)" name="category">
          <?php
          $sth = $dfPDO->query('SELECT * FROM forum_categories');
          foreach ($sth->fetchAll() as $row) {
            ?>

          <option>
            <?php echo $row['name']; ?>
          </option>

          <?php

        } ?>
          <option selected="selected" id="newCategory">
            <?php echo getLanguageString("newCategory"); ?>
          </option>
        </select>
        <input id="newCatName" type="text" placeholder="<?php echo getLanguageString("categoryName"); ?>" class="hidden" name="category_name">
        <button type="submit"><?php echo getLanguageString("create"); ?></button>
      </form>
    </div>
  </div>

  <?php

}
?>
