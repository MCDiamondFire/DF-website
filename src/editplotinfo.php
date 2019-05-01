<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/php/core/init.php';

if (isset($_GET['plotID']) && permLevel() > 0) {
  $plotID = $_GET['plotID'];
  $_SESSION['plotID'] = $plotID;

  if (getPlotOwner($plotID) == $user_data['username']) { ?>
    <html>
      <head>
        <title>Edit Plot</title>
        <?php require_once REQUIRES . 'head.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>editPlotInfo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
        <style>
          #imageWrapper {
            width: 350px;
            height: 250px;
            display: inline-block;
          }

          #plotInfo {
            text-align: center;
          }
        </style>
      </head>
      <body>
        <?php require_once REQUIRES . 'background.php'; ?>
        <?php require_once REQUIRES . 'header.php';
        $plotInfo = $dfPDO->prepare('SELECT * FROM trendingPlots WHERE plotID = :plotID');
        $plotInfo->execute(
          array('plotID' => $plotID)
        );
        $plotInfo = $plotInfo->fetch(PDO::FETCH_ASSOC); ?>
        <div id="content">
          <div id="error-output"></div>
          <div id="centerPanelWrapper">
            <div id="panelFullWrapper">
              <form class="ajaxImageRedirectCroppie" autocomplete="off" id="plotInfo" enctype="multipart/form-data" action="<?php echo ACTIONS; ?>savePlotInfo.php" method="post">
                <h1>Plot Image</h1>
                <div id="imageWrapper">
                  <img id="image" src="<?php echo IMAGES . plotImage($_SESSION['plotID']); ?>">
                </div>
                <input type="hidden" id="imagebase64" name="imagebase64">
                <input accept="image/x-png,image/jpeg" type="file" onchange="readURL(this)">
                <h1>Plot Description</h1>
                <textarea name="description" class="noMargin" maxlength="250" placeholder="Enter a description..."><?php echo $plotInfo['description']; ?></textarea>
                <button type="button" onclick="exportImg()">Save</button>
              </form>
            </div>
          </div>
        </div>
        <?php require_once REQUIRES . 'footer.php'; ?>
      </body>
      <script>
        var el = document.getElementById('image');
        var resize = new Croppie(el, {
            viewport: { width: 350, height: 250 },
            showZoomer: true,
            enableResize: true,
            enableOrientation: true,
            mouseWheelZoom: 'ctrl'
        });

        function exportImg() {
          resize.result({
            type: 'canvas',
            size: 'original'
        }).then(function(blob) {
              $('#imagebase64').val(blob)
              $('#plotInfo').submit();
          });
        }

        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
              resize.bind({
                  url: e.target.result,
              });
            };
            reader.readAsDataURL(input.files[0]);
          }
        }

        $(document).ready(function() {
          $(".ajaxImageRedirectCroppie").each(function() {
            var element = this
            $(element).submit(function(e) {
              
              var submit = $(this).find(":button")
              var submitText = submit.html()
              startCallback(submit)

              imageData = new FormData(this)
              
              $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: imageData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                  if(getCookiebyName("ajaxRedirect") == null) {
                    callback(submit, submitText, data)
                  } else {
                    greenTickButton(submit)
                    deleteCookie("ajaxRedirect")
                    $(data)
                    .appendTo('#error-output')
                    .delay(5000)
                    .queue(function() {
                      $(this).remove();
                    });
                  }
                },
                error: function(data) {
                  stopCallback(submit, submitText)
                }
              });
              e.preventDefault();
            });
          })
        })
      </script>
    </html>
  <?php 
} else {
  header('Location: /');
}
}
