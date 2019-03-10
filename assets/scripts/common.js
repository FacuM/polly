/*
// Common setup script.
//
// Dependencies: jQuery.
//
*/


// Global variables

// Enable debugging
var debug = true;

// Functions
function logi(data) { if (debug) { console.log (data); } }
function logw(data) { if (debug) { console.warn (data); } }

function setPinnedContact(content, network_id)
{
  $('.ajax_indicator').show();
  $.ajax({
    url: 'api.php',
    data: { request: 'setPinnedContact', content: [ content, network_id ] }
  })
  .done(function (response)
  {
    error = 'Oops... there was a problem processing your request: ';
    if (parseInt(response) == 2)
    {
      M.toast({ html: error + 'not allowed. Are you logged in?' });
    }
    $('.ajax_indicator').hide();
  })
  .fail(function ()
  {
    M.toast({ html: 'Oops... there was an unkown issue while processing your request. Are we offline?' });
  });
}

$(document).ready(function () {
  // Initialize the sidenav
  $('.sidenav').sidenav();

  // Handle favorite icon click.
  $('.favorite').on('click', function () {
    if ( $(this).css('opacity') == 1 )
    {
     setPinnedContact(0, parseInt($(this).next().val()));
     $(this).css('opacity', '0.5');
    }
    else
    {
     setPinnedContact(1, parseInt($(this).next().val()));
     $(this).css('opacity', '1.0');
    }
  });

  // Initialize HTML elements through MaterializeCSS.
  M.AutoInit();

  // Initialize character counters for text and password inputs.
  $('input[type=text], input[type=password]').characterCounter();

  // Initialize date pickers.
  $('#date').datepicker({ autoClose: true, format: 'yyyy-mm-dd' });

  // Handle focused/lost focus events for those character counters.
  $('input[type=text], input[type=password]').focusin(function () {
    $('.character-counter').animate({ 'opacity' : 1 });
  });
  $('input[type=text], input[type=password]').focusout(function () {
    $('.character-counter').animate({ 'opacity' : 0 });
  });

  // Bind all contacts fields as "start chat" buttons
  $('.item').on('click', function() {
    $('.ajax_indicator').fadeIn(mAtime_short);
    item = $(this)
    $.ajax({
      url: 'api.php',
      data: { request: 'startChat', content: item.parent().find('a').find('input').val() }
    })
    .done(function (response) {
      $('.ajax_indicator').fadeOut(mAtime_short);
      if (response == 3)
      {
        M.toast({ html: 'The user you\'re trying to chat with is busy.' });
      }
      else
      {
        if (response == 1)
        {
          M.toast({ html: 'Oops... there\'s no such user.' });
          item.off('click').fadeOut(mAtime_short);
          setTimeout(function() {
            item.remove();
          }, mAtime_short);
        }
        else
        {
          $('#contacts').modal('close');
          setTimeout(function () {
            window.location = 'chats.php';
          }, mAtime_short);
        }
      }
    });
  });
});
