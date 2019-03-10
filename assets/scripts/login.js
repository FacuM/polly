/*
// Login setup script.
//
// Dependencies: jQuery.
//
*/

$(document).ready(function () {
  $('button').on('click', function() {
    $('button').fadeOut(mAtime_short);
    setTimeout(function () {
      $('.preloader-wrapper').fadeIn(mAtime_short);
      setTimeout(function() {
        $('form').submit();
      }, mAtime_short);
    }, mAtime_short);
  });

  if (typeof mErrMsg !== 'undefined')
  {
    M.toast({ html: mErrMsg });
  }

  $(document).keypress(function (e) {
    if (e.which == 13)
    {
      $('button').click();
    }
  });
});
