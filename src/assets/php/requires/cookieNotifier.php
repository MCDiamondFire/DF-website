<?php if (!isset($_COOKIE['cookieControl']) || $_COOKIE['cookieControl'] < 1) { ?>
<div id="cookiePanel">
  <p><?php echo getLanguageString("cookiePolicy"); ?> <a draggable="false" href="cookiepolicy" target="_blank"><?php echo getLanguageString("cookiePolicyLink"); ?></a></p>
  <div id="buttonSaveArea">
    <button onclick="disableCookieMessage()"><?php echo getLanguageString("gotIt"); ?></button>
  </div>
</div>

<?php
} ?>

<style>
  #cookiePanel {
    z-index: 1000;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: auto;
    background-color: rgba(255, 255, 255, 0.75);
    color: black;
    box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.5);
  }

  #cookiePanel p {
    display: inline-block;
    margin: 15px;
    max-width: calc(100% - 130px);
  }

  #cookiePanel a {
    color: black;
  }

  #cookiePanel button {
    font-size: 20px;
    background-color: #fcb034;
    border: 2px solid #fcb034;
    float: right;
  }

  #cookiePanel button:hover {
    background-color: #e8a230;
    border: 2px solid #e8a230;
  }

  #cookiePanel button:active {
    background-color: #d29430;
    border: 2px solid #d29430;
  }

  #buttonSaveArea {
    width: 90px;
    float: right;
    position: absolute;
    top: 50%; right: 10px;
    transform: translateY(-50%);
  }
</style>

<script>
  function disableCookieMessage() {
    document.cookie = "cookieControl=1; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    $("#cookiePanel").fadeOut(300, function() { $(this).remove(); });
  }
</script>
