<?php
$allowedAccess = true;
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php'); ?>
<html>
  <head>
    <title>
      <?php 
      if (isset($_GET['username'])) {
        $pageTitle = $_GET['username'] . "'s Support Stats &bull; DiamondFire";
      } else {
        $pageTitle = "Support Stats";
      }
      echo $pageTitle; ?>
    </title>
    <?php include(REQUIRES . 'head.php'); ?>
  </head>
    <?php
    if (isset($_GET['username'])) {
      ?>
<table>
  <thead>
    <tr>
      <th class="first">Name</th>
      <th class="second">Duration</th>
      <th class="third">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $dfPDO->query('use hypercube');
    $sth = $dfPDO->prepare("SELECT name, time, duration FROM support_sessions WHERE staff = :username ORDER BY duration DESC");
    $sth->execute(array(
      "username" => $_GET['username']
    ));
    $dfPDO->query('use df_website');

    foreach ($sth->fetchAll() as $row) {
      ?>
    <tr>
      <td><?php echo $row['name'] ?></td>
      <td><?php echo formatMilliseconds($row['duration']) ?></td>
      <td><?php echo date("h:i:s d.m.Y", strtotime($row['time'])) ?></td>
    </tr>
    <?php 
  } ?>
  </tbody>
</table>
<?php 
} else {
  echo "No username entered, you sucks lol.";
}

function formatMilliseconds($milliseconds)
{
  $seconds = floor($milliseconds / 1000);
  $minutes = floor($seconds / 60);
  $hours = floor($minutes / 60);
  $milliseconds = $milliseconds % 1000;
  $seconds = $seconds % 60;
  $minutes = $minutes % 60;

  $format = '%uh %02um %02us';
  $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
  return rtrim($time, '0');
}
?>
<style>
  table {
    border-collapse: collapse;
  }
  .first {
    width: 100px;
  }
  .second {
    width: 100px;
  }
  .third {
    width: 150px;
  }

  td {
    border-right: 1px solid black;
  }

  tr:nth-child(even) {background: #CCC}
  tr:nth-child(odd) {background: #FFF}
</style>
</html>