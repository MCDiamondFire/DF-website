<?php

/**
 *
 * Creates the user data
 *
 * @param integer $user_id The id to get data from
 * @return array
 *
 */
function user_data($user_id)
{
  global $dfPDO;

  $data = array();
  $user_id = (int)$user_id;

  $func_num_args = func_num_args();
  $func_get_args = func_get_args();

  if ($func_num_args > 1) {
    unset($func_get_args[0]);
  }

  $fields = '`' . implode('`, `', $func_get_args) . '`';
  $sth = $dfPDO->query("SELECT $fields FROM `accounts` WHERE `user_id` = $user_id");
  $data = $sth->fetch(PDO::FETCH_ASSOC);

  return $data;
}

/**
 *
 * Returns the username from the user id
 *
 * @param integer $user_id The id to get data from
 * @return string
 *
 */
function usernameFromID($id)
{
  global $dfPDO;

  $sth = $dfPDO->query('SELECT username FROM accounts WHERE user_id = ' . $id);

  return $sth->fetch(PDO::FETCH_COLUMN);
}

/**
 *
 * Returns the avatar link from the user id
 *
 * @param integer $user_id The id to get data from
 * @return string
 *
 */
function avatarFromID($id, $size)
{
  global $dfPDO;

  $sth = $dfPDO->query('SELECT uuid FROM accounts WHERE user_id = ' . $id);

  return '//crafatar.com/avatars/' . $sth->fetch(PDO::FETCH_COLUMN) . '?overlay=true&size=' . $size;
}

/**
 *
 * Returns the 3D skin avatar from the user id
 *
 * @param integer $user_id The id to get data from
 * @return string
 *
 */
function avatar3DFromID($id, $size)
{
  global $dfPDO;

  $sth = $dfPDO->query('SELECT uuid FROM accounts WHERE user_id = ' . $id);

  return '//crafatar.com/renders/body/' . $sth->fetch(PDO::FETCH_COLUMN) . '?overlay=true&size=' . $size;
}

/**
 *
 * Returns the 3D head avatar from the user id
 *
 * @param integer $user_id The id to get data from
 * @return string
 *
 */
function head3DFromID($id, $size)
{
  global $dfPDO;

  $sth = $dfPDO->query('SELECT uuid FROM accounts WHERE user_id = ' . $id);

  return '//crafatar.com/renders/head/' . $sth->fetch(PDO::FETCH_COLUMN) . '?overlay=true&size=' . $size;
}

/**
 *
 * Returns the permission level of the user
 * 0 = Not logged in
 * 1 = Logged in
 * 2 = JrHelper
 * 3 = Helper
 * 4 = Expert
 * 5 = JrMod
 * 6 = Mod
 * 7 = Admin
 * 8 = Owner
 *
 * 9 = MAGIC WEBDEV!
 *
 * @return string
 *
 */
function permLevel($rankText = false)
{
  global $dfPDO;
  global $user_data;

  if ($rankText == false) {
    if (logged_in()) {
      $sth = $dfPDO->query('SELECT rank FROM accounts WHERE user_id = ' . $user_data['user_id']);
      $rankText = $sth->fetch(PDO::FETCH_COLUMN);
    } else {
      return 0;
    }
  }
  switch ($rankText) {
    case 'WebDev':
      return 9;
      break;
    case 'Owner':
      return 8;
      break;
    case 'Admin':
      return 7;
      break;
    case 'Mod':
      return 6;
      break;
    case 'JrMod':
      return 5;
      break;
    case 'Expert':
      return 4;
      break;
    case 'Helper':
      return 3;
      break;
    case 'JrHelper':
      return 2;
      break;
    default:
      if (logged_in()) {
        return 1;
      } else {
        return 0;
      }
  }
}

/**
 *
 * Checks if user exists
 *
 * @param string $uuid The uuid to check
 * @return boolean
 *
 */
function user_exists($uuid)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT COUNT(uuid) FROM accounts WHERE uuid = :uuid');

  $sth->execute(array('uuid' => $uuid));

  return ($sth->fetch(PDO::FETCH_COLUMN) == 1) ? true : false;
}


/**
 *
 * Checks if password is valid
 *
 * @param string $username The username to check
 * @param string $password The password for checking
 * @return boolean
 *
 */
function valid_password($username, $password)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT password FROM accounts WHERE username = :username');

  $sth->execute(array('username' => $username));

  $fetchedPassword = $sth->fetch(PDO::FETCH_COLUMN);

  return (password_verify($password, $fetchedPassword)) ? true : false;
}

/**
 *
 * Returns the user ID
 *
 * @param string $username The username to check
 * @return integer
 *
 */
function getUserID($username)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT user_id FROM accounts WHERE username = :username');

  $sth->execute(array('username' => $username));

  return $sth->fetch(PDO::FETCH_COLUMN);
}

function userIDFromUUID($uuid)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT user_id FROM accounts WHERE uuid = :uuid');

  $sth->execute(array('uuid' => $uuid));

  return $sth->fetch(PDO::FETCH_COLUMN);
}

function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}


function parseMinecraftColors($string)
{
  $string = str_replace('&', '§', $string);
  $string = utf8_decode(htmlspecialchars($string, ENT_QUOTES, "UTF-8"));
  $string = preg_replace('/\xA7([0-9a-f])/i', '<span class="mc-color mc-$1">', $string, -1, $count) . str_repeat("</span>", $count);
  return utf8_encode(preg_replace('/\xA7([k-or])/i', '<span class="mc-$1">', $string, -1, $count) . str_repeat("</span>", $count));
}

function plotVoteCount($id)
{
  global $dfPDO;

  $votes = $dfPDO->query('SELECT time FROM plot_votes WHERE plot = ' . $id);
  $votes = $votes->fetchAll();

  $votesTotal = array();

  foreach ($votes as $vote) {
    $vote = $vote['time'];

    $voteTime = date('Y-m-d H:i:s', $vote / 1000);
    $voteTimeTest = strtotime($voteTime);
    $lastWeek = strtotime('-1 week');

    if ($voteTimeTest >= $lastWeek) {
      $votesTotal[] = $voteTime;
    }


  }

  return count($votesTotal);
}

function getTrendingPlots()
{
  global $dfPDO;

  $dfPDO->query('use hypercube');

  $lastWeek = round(microtime(true) * 1000);
  $lastWeek = $lastWeek - 604800000;

  $trendingPlots = $dfPDO->query('SELECT * FROM plot_votes WHERE time >= ' . $lastWeek);

  $trendingPlots = $trendingPlots->fetchAll();

  $trendPlots = array();
  $checkDuplicate = array();
  $plotVotes = array();

  foreach ($trendingPlots as $plot) {
    if (empty($plotVotes[$plot['plot']])) {
      $plotVotes[$plot['plot']] = 1;
    } else {
      $newVotes = $plotVotes[$plot['plot']];
      $plotVotes[$plot['plot']] = $newVotes + 1;
    }
  }

  foreach ($plotVotes as $plotVote) {
    $plotVoteKey = array_search($plotVote, $plotVotes);
    if ($plotVote < 10) {
      unset($plotVotes[$plotVoteKey]);
    }
  }

  $bestTrendingsIDs = array();
  $bestTrendingsVotes = array();
  $i = 0;

//19872 - 12

  //Foreach Vote in Votes
  foreach ($plotVotes as $plotVote) {

    array_unshift($bestTrendingsIDs, key($plotVotes));
    array_unshift($bestTrendingsVotes, $plotVote);
    next($plotVotes);
  }
  array_multisort($bestTrendingsVotes, $bestTrendingsIDs, SORT_NUMERIC);
  $bestTrendingsIDs = array_slice($bestTrendingsIDs, count($bestTrendingsIDs) - 10, 10);
  $bestTrendingsVotes = array_slice($bestTrendingsVotes, count($bestTrendingsVotes) - 10, 10);

  $plotVotes = array();
  $i = 0;

  foreach ($bestTrendingsIDs as $plotID) {
    $plotVotes[$plotID] = $bestTrendingsVotes[$i];
    $i++;
  }

  $plotVotes = array_reverse($plotVotes, true);

  $dfPDO->query('use df_website');

  $sth = $dfPDO->query('SELECT plotID FROM trendingPlots');
  $results = $sth->fetchAll();
  $trendingPlotIDs = array();
  foreach ($results as $result) {
    $trendingPlotIDs[] .= $result['plotID'];
  }

  $sth = $dfPDO->prepare('INSERT INTO trendingPlots (plotID) VALUES (:plotID)');
  foreach ($bestTrendingsIDs as $bestTrendingsID) {
    if (!in_array($bestTrendingsID, $trendingPlotIDs)) {
      $sth->execute(array(
        'plotID' => $bestTrendingsID
      ));
    }
  }


  return $plotVotes;
}

function getPlotInfo($plotIDs)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');

  $sth = $dfPDO->prepare('SELECT id, name, owner_name FROM plots WHERE id = :plotID');
  $plotInfos = array();

  foreach ($plotIDs as $plotID) {
    $sth->execute(array(
      ':plotID' => $plotID
    ));
    $plot = $sth->fetch(PDO::FETCH_ASSOC);
    $plotInfos[] = $plot;
  }

  $dfPDO->query('use df_website');

  return $plotInfos;
}

function plotDescription($plotID)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT description FROM trendingPlots WHERE plotID = :plotID');

  $sth->execute(array(
    'plotID' => $plotID
  ));

  $result = $sth->fetch(PDO::FETCH_COLUMN);

  if ($result != "") {
    return $result;
  } else {
    return getLanguageString("noPlotDescription");
  }
}

function plotImage($plotID)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT image FROM trendingPlots WHERE plotID = :plotID');

  $sth->execute(array(
    'plotID' => $plotID
  ));

  if ($sth->rowCount() == 1) {
    return $sth->fetch(PDO::FETCH_COLUMN);
  }
}

function plotName($plotID)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');

  $sth = $dfPDO->prepare('SELECT name FROM plots WHERE id = :plotID');

  $sth->execute(array(
    'plotID' => $plotID
  ));

  $dfPDO->query('use df_website');

  if ($sth->rowCount() == 1) {
    return $sth->fetch(PDO::FETCH_COLUMN);
  }
}

function info($data)
{
  return "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='info' class='fal fa-info-circle'></i></div><div id='textSpace'><p>" . $data . "</p></div></div></div>";
}

function success($data)
{
  return "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='success' class='fal fa-check-circle'></i></div><div id='textSpace'><p>" . $data . "</p></div></div></div>";
}

function error($data)
{
  return "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='error' class='fal fa-times-circle'></i></div><div id='textSpace'><p>" . $data . "</p></div></div></div>";
}

function getCodeOwner($code)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');

  $sth = $dfPDO->prepare('SELECT player_uuid FROM linked_accounts WHERE secret_key = :code');

  $sth->execute(array(
    'code' => $code
  ));

  $codeOwner = $sth->fetch(PDO::FETCH_COLUMN);

  $dfPDO->query('use df_website');

  return $codeOwner;
}

function getPlotOwner($plotID)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');

  $sth = $dfPDO->prepare('SELECT owner_name FROM plots WHERE id = :plotID');

  $sth->execute(array(
    'plotID' => $plotID
  ));

  $plotOwner = $sth->fetch(PDO::FETCH_COLUMN);

  $dfPDO->query('use df_website');

  return $plotOwner;
}


function rank_from_uuid($uuid)
{
  global $dfPDO;

  $dfPDO->query('use hypercube');
  $sth = $dfPDO->query("SELECT * FROM `ranks` WHERE `uuid` = '$uuid'");
  $dfPDO->query('use df_website');
  $row = $sth->fetch(PDO::FETCH_ASSOC);

  switch ($row['moderation']) {
    case 4:
      return "Owner";
      break;
    case 3:
      return "Admin";
      break;
    case 2:
      return "Mod";
      break;
    case 1:
      return "JrMod";
      break;
  }

  switch ($row['support']) {
    case 3:
      return "Expert";
      break;
    case 2:
      return "Helper";
      break;
    case 1:
      return "JrHelper";
      break;
  }

  switch ($row['retirement']) {
    case 1:
      return "Retired";
      break;
    case 2:
      return "Emeritus";
      break;
    default:
      return "";
      break;
  }

  switch ($row['donor']) {
    case 4:
      return "Overlord";
      break;
    case 3:
      return "Mythic";
      break;
    case 2:
      return "Emperor";
      break;
    case 1:
      return "Noble";
      break;
    default:
      return "";
      break;

  }
}

function getDiscordUser($uuid)
{
  global $dfPDO;
  $dfPDO->query('use hypercube');
  $sth = $dfPDO->prepare('SELECT discord_id FROM linked_accounts WHERE player_uuid = :uuid');
  $sth->execute(array(
    'uuid' => $uuid
  ));
  $dfPDO->query('use df_website');

  if ($sth->rowCount() > 0) {
    return $sth->fetch(PDO::FETCH_COLUMN);
  } else {
    return false;
  }
}

function getUUID($userid)
{
  global $dfPDO;

  $sth = $dfPDO->prepare('SELECT uuid FROM accounts WHERE user_id = :userID');
  $sth->execute(array(
    'userID' => $userid
  ));

  return $sth->fetch(PDO::FETCH_COLUMN);
}

function addMessage($userID, $message, $level, $type, $parameters = array())
{
  global $dfPDO;
  $sth1 = $dfPDO->prepare('INSERT INTO messages (uuid, type, level, message, parameters) VALUES (:uuid, :type, :level, :message, :parameters)');
  $sth1->execute(array(
    'uuid' => getUUID($userID),
    'level' => $level,
    'type' => $type,
    'message' => $message,
    'parameters' => $parameters
  ));
}

function ajaxRedirect()
{
  setcookie('ajaxRedirect', 1, time() + 60 * 5, '/');
}

function discordLoggedIn()
{
  // Authorization url
  $authURL = 'https://discordapp.com/api/oauth2/authorize';

  $auth = curl_init($authURL);

  curl_setopt(
    $auth,
    CURLOPT_POSTFIELDS,
    json_encode(array(
      'client_id' => "348664362505863178",
      'redirect_uri' => "https://df.pocketclass.net/verifybot/callback.php",
      "response_type" => "code",
      "scope" => "identify"
    ))
  );

  echo curl_exec($auth);
  curl_close($auth);

}

function forumCategoryNameFromForumID($forumID)
{
  global $dfPDO;

  $sth = $dfPDO->prepare("SELECT category_id FROM forums WHERE forum_id = :forumID");
  $sth->execute(array(
    "forumID" => $forumID
  ));
  $categoryID = $sth->fetch(PDO::FETCH_COLUMN);
  $sth = $dfPDO->prepare("SELECT name FROM forum_categories WHERE category_id = :categoryID");
  $sth->execute(array(
    "categoryID" => $categoryID
  ));
  return $sth->fetch(PDO::FETCH_COLUMN);
}

function forumNameFromID($forumID)
{
  global $dfPDO;

  $sth = $dfPDO->prepare("SELECT name FROM forums WHERE forum_id = :forumID");
  $sth->execute(array(
    "forumID" => $forumID
  ));
  return $sth->fetch(PDO::FETCH_COLUMN);
}

function getForumIDFromThreadID($threadID)
{
  global $dfPDO;

  $sth = $dfPDO->prepare("SELECT forum_id FROM threads WHERE thread_id = :threadID");
  $sth->execute(array(
    'threadID' => $threadID
  ));

  return $sth->fetch(PDO::FETCH_COLUMN);
}

function reloadPage()
{
  echo "<script>$(() => {window.location.reload();})</script>";
}


/*
! From the Webhook

curl_setopt(
$curl,
CURLOPT_POSTFIELDS,
json_encode(array(
  "content" => $for,
  "embeds" =>
    [
      [
      "thumbnail" =>
        [
            "url" =>
                "https:" .
                    avatarFromID(
                        $parameters[
                            'repliedBy'
                        ],
                        96
                    ),
            "height" => 96,
            "width" => 96
        ],
    "color" => $color,
    "title" => $threadReplyTXT,
    "description" =>
        $repliedByUser .
            ' (**' .
            $parameters['threadName'] .
            '**)',
    "author" =>
        [
            "icon_url" => $avatarURL,
            "name" => $name,
            "url" => ""
        ],
    "fields" =>
        [
            [
                "name" => $visitThreadTXT,
                "value" => $threadURL,
                "inline" => false
            ]
        ],
      "footer" => ['text' => $hookName]
    ]
  ]
))
);
 */
?>
