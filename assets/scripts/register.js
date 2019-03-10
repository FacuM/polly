/*
// Registration setup script.
//
// Dependencies: jQuery.
//
*/

$(document).ready(function () {
  /*
  // Whenever a change in the username field occurs, query the database for availability.
  // If you're willing to change this, ALWAYS use the API, do not expose your credentials at all.
  */
  $('#username').change( function () {
    $.ajax({
      url: 'api.php',
      type: 'GET',
      data: { request: 'usernameLookup', content: $('#username').val() },
    })
    .done(function (response) {
      if (parseInt(response) > 0)
      {
        M.toast({ html: 'Oops... that username is taken.' });
      }
      else
      {
        M.toast({ html: 'Yay! That username is available.'});
      }
    });
  });

  /*
  // Whenever a change in the mail address field occurs, query the database for availability.
  // If you're willing to change this, ALWAYS use the API, do not expose your credentials at all.
  */
  $('#mail').change( function () {
    $.ajax({
      url: 'api.php',
      type: 'GET',
      data: { request: 'mailaddressLookup', content: $('#mail').val() },
    })
    .done(function (response) {
      if (parseInt(response) > 0)
      {
        M.toast({ html: 'Oops... that mail address is already in use.' });
      }
      else
      {
        M.toast({ html: 'Yay! That mail address is available.'});
      }
    });
  });
});
