<meta charset="utf-8" />

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121195616-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121195616-1');
</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php require_once(REQUIRES . 'ogpHandler.php') ?>

<!-- ########## RESET ########## -->
<link rel="stylesheet" type="text/css" href="<?php echo $page ?>assets/css/main.css">

<!-- ########## ROBOTO ########## -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">


<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- ########## THEME COLOR ########## -->
<meta name="theme-color" content="#85c0ed" />

<!-- ########## JQUERY ########## -->
<script src="<?php echo $page ?>assets/js/jquery-3.4.0.min.js"></script>

<!-- ########## CLIPBOARD.JS ########## -->
<script src="<?php echo $page ?>assets/js/clipboard.min.js"></script>

<!-- ########## FUNCTIONS ########## -->
<script src="<?php echo $page ?>assets/js/functions.js"></script>

<!-- ########## FONTAWESOME 5 ########## -->
<script defer src="<?php echo $page ?>assets/js/fontawesome/lite.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.8.1/js/fontawesome.js"></script>

<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $page ?>assets/images/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $page ?>assets/images/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $page ?>assets/images/favicons/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $page ?>assets/images/favicons/favicon.ico">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.min.js"></script>


<script>
  $(function() {
      $('img:not(".lazy")').lazy({
        effect: "fadeIn",
        effectTime: 1000,
        threshold: 0
      });
      $('.lazy').lazy({
        scrollDirection: 'vertical',
        effect: "fadeIn",
        effectTime: 1000,
        threshold: 0
      });
    });
</script>
