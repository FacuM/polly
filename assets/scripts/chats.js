/*
// Chats setup and runtime script.
//
// Dependencies: jQuery.
//
*/

TAG = 'CHAT';
$('document').ready(function () {

  // Async chat processing block
  lastMessage   = $('.message_id').last();
  lastMessageId = lastMessage.val();
  var running = false;
  setInterval(function () {
    logi(TAG + ': cycling chat heartbeat...');
    // If there isn't any other async instance running, execute the following code.
    if (!running)
    {
      $.ajax({
        url: 'api.php',
        data: { request: 'getLastMessage', content: null }
      })
      .done(function (response) {
        logi(TAG + ': got response from server.');
        if (response != "1")
        {
          logi(TAG + ': the reponse contains a message, adding it to the #messages container...');
          // try/catch block to determine wether the response is JSON and can be parsed.
          try {
           json_array = JSON.parse(response);
          }
          catch (e)
          {
            logw(TAG + ': unable to parse unexpected response, aborting...');
            json_array = null;
          }
          if (json_array != null)
          {
            if (json_array['id'] != lastMessageId)
            {
              if (json_array['nid_orig_match'] == $('#origin').val())
              {
                $('#messages').append('' +
                '<div class="row">' +
                ' <input class="message_id" type="hidden" value="' + json_array['id'] + '">' +
                ' <div class="col s8"></div>' +
                ' <div class="col s4 z-depth-1 collection teal message_bubble">' +
                '  <span class="collection-item teal white-text">' +
                    json_array['content']  +
                '  </span>' +
                ' </div>' +
                '</div>'
                );
              }
              else
              {
                $('#messages').append('' +
                '<div class="row">' +
                ' <input class="message_id" type="hidden" value="' + json_array['id'] + '">' +
                ' <div class="col s4 z-depth-1 collection red message_bubble message_bubble_other">' +
                '  <span class="collection-item red white-text">' +
                    json_array['content'] +
                '  </span>' +
                ' </div>' +
                ' <div class="col s9"></div>' +
                '</div>'
                );
              }
              logi(TAG + ': done parsing and appending.');
              // Now, pick the latest message as the last one.
              lastMessage = $('.message_id').last();

              logi(TAG + ': client-side effects (animations and scrolls) will take place now.');
              // This is the last real entry, lets simply animate scrollTop to the maximum.
              scrollTopMax = $('#messages').prop('scrollHeight') - $('#messages').innerHeight();
              $('#messages').animate({ scrollTop : scrollTopMax });
              $('#overflow').fadeOut();
            }

            // We're done with that entry, lets tell the server to remove it from the queue.
            logi(TAG + ': done, taking the message off the queue...');
            running = true;
            $.ajax({
              url: 'api.php',
              data: { request: 'notifyMessageReceived', content: null }
            })
            .done(function () {
              logi(TAG + ': success.');
              running = false;
            });
          }
        }
      })
      .fail(function () {
        logw(TAG + ': can\'t reach server. Are we offline?');
      });
      logi(TAG + ': ready for the next cycle.');
    }
    else
    {
      logi(TAG + ': stuck cycle detected, aborting and waiting for completion...');
    }
  }, mChatUrate);


  $('#message').keypress(function (e) {
    //             13 = Intro
    if (e.which == 13)
    {
      $('#send_icon').click();
    }
  });

  if ($('#messages').prop('scrollHeight') > $('#messages').height())
  {
    $('#overflow').css({ display: 'block' });
  }

  // Bind "scroll" event, if the box is overflowing, show a button to scroll all the way to the bottom.
  $('#messages').on('scroll', function() {
    scrollTopMax = $('#messages').prop('scrollHeight') - $('#messages').innerHeight();
    if ($('#messages').scrollTop() >= scrollTopMax)
    {
      if ($('#overflow').css('display') == 'block')
      {
        $('#overflow').fadeOut();
      }
    }
    else
    {
      if ($('#messages').scrollTop() == 0 && $('#overflow').css('display') == 'none')
      {
        $('#overflow').fadeIn();
      }
    }
  });
  scrollTopMax = $('#messages').prop('scrollHeight') - $('#messages').innerHeight();
  if (scrollTopMax >= $('#messages').height())
  {
    $('#messages').animate({ scrollTop: scrollTopMax }, mAtime_long);
    $('#overflow').fadeOut(mAtime_short);
  }

  // Handle click on the "overflow" button (aka "see more")
  $('#overflow').on('click', function () {
    scrollTopMax = $('#messages').prop('scrollHeight') - $('#messages').innerHeight();
    $('#messages').animate({ scrollTop : scrollTopMax });
    $('#overflow').fadeOut();
  });

  $('#end_chat_yes').on('click', function () {
    $('#end_chat').modal('close');
    $('.ajax_indicator').fadeIn(mAtime_short);
    setTimeout(function () {
      window.location = 'endchat.php';
    }, mAtime_short);
  });
});

function sendMessage()
{
  if ($('#message').val().length > 0)
  {
    $.ajax({
      url: 'api.php',
      data: { request: 'sendMessage', content: [ $('#destination').val(), $('#message').val() ]}
    })
    .done(function () {
      M.toast({ html: 'Sent!' });
      $('#message').val('');
    });
  }
  else
  {
    M.toast({ html: 'You can\'t send an empty message.' });
  }
}
