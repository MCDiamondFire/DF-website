$(document).ready(function() {
  $(".ajax").each(function() {
    var element = this;
    $(element).submit(function(e) {
      var submit = $(this).find(":submit");
      var submitText = submit.html();
      startCallback(submit);

      $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function(data) {
          callback(submit, submitText, data);
        },
        error: function(data) {
          stopCallback(submit, submitText);
        }
      });
      e.preventDefault();
    });
  });
});

$(document).ready(function() {
  $(".ajaxRedirect").each(function() {
    var element = this;
    $(element).submit(function(e) {
      var submit = $(this).find(":submit");
      var submitText = submit.html();
      startCallback(submit);

      $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        success: function(data) {
          if (getCookiebyName("ajaxRedirect") == null) {
            callback(submit, submitText, data);
          } else {
            greenTickButton(submit);
            deleteCookie("ajaxRedirect");
            $(data)
              .appendTo("#error-output")
              .delay(5000)
              .queue(function() {
                $(this).remove();
              });
          }
        },
        error: function(data) {
          stopCallback(submit, submitText);
        }
      });
    });
  });
});

$(document).ready(function() {
  $(".ajaxImageRedirect").each(function() {
    var element = this;
    $(element).submit(function(e) {
      var submit = $(this).find(":submit");
      var submitText = submit.html();
      startCallback(submit);

      imageData = new FormData(this);

      $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: imageData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
          if (getCookiebyName("ajaxRedirect") == null) {
            callback(submit, submitText, data);
          } else {
            greenTickButton(submit);
            deleteCookie("ajaxRedirect");
            $(data)
              .appendTo("#error-output")
              .delay(5000)
              .queue(function() {
                $(this).remove();
              });
              window.location.reload();
          }
        },
        error: function(data) {
          stopCallback(submit, submitText);
        }
      });
      e.preventDefault();
    });
  });
});

function ajaxRedirectRequest(button, submitText, ajaxURL, data) {
  startCallback(button);

  $.ajax({
    type: "POST",
    url: ajaxURL,
    data: data,
    success: function(data) {
      if (getCookiebyName("ajaxRedirect") == null) {
        callback(button, submitText, data);
      } else {
        greenTickButton(button);
        $(data)
          .appendTo("#error-output")
          .delay(5000)
          .queue(function() {
            $(this).remove();
          });
      }
    },
    error: function(data) {
      stopCallback(button, submitText);
    }
  });
}

function goTo(href) {
  document.location = href;
}

function startCallback(submit) {
  submit.prop("disabled", true);
  submit.html('<i class="fal fa-circle-notch accelerateSpin"></i>');
}

function stopCallback(submit, submitText) {
  submit.html(submitText);
  submit.prop("disabled", false);
}

function callback(submit, submitText, data) {
  $(data)
    .appendTo("#error-output")
    .delay(5000)
    .queue(function() {
      $(this).remove();
    });
  submit.html(submitText);
  submit.prop("disabled", false);
}

function info(data) {
  return (
    "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='info' class='fal fa-info-circle'></i></div><div id='textSpace'><p>" +
    data +
    "</p></div></div></div>"
  );
}

function success(data) {
  return (
    "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='success' class='fal fa-check-circle'></i></div><div id='textSpace'><p>" +
    data +
    "</p></div></div></div>"
  );
}

function errorToast(data) {
  return (
    "<div class='output'><div id='squeezer'><div id='iconSpace'><i id='error' class='fal fa-times-circle'></i></div><div id='textSpace'><p>" +
    data +
    "</p></div></div></div>"
  );
}

function outputAppend(data) {
  $(data)
    .appendTo("#error-output")
    .delay(5000)
    .queue(function() {
      $(this).remove();
    });
}

var getCookiebyName = function(name) {
  var pair = document.cookie.match(new RegExp(name + "=([^;]+)"));
  return !!pair ? pair[1] : null;
};

function deleteCookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

function greenTickButton(button) {
  button.addClass("successBtn");
}
