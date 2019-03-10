<?php
 /*
 // Public API.
 //
 // Possible statuses:
 // 0 -> Pass.
 // 1 -> General error/invalid request.
 // 2 -> Not allowed.
 // * -> Custom status(es).
 //
 //      Read the specific case documentation.
 */
 require_once('config.php');
 /*
 // TODO: Handle cases where "content" doesn't make sense instead of passing "NULL".
 */
 if (isset($_GET['request']) && isset($_GET['content']))
 {
   if (isset($_GET['content']))
   {
     switch ($_GET['request']) {
         case 'usernameLookup':
           echo $server->query('SELECT COUNT(\'id\') FROM ' . $tables['users'] . ' WHERE username = ' . $server->quote($_GET['content']))->fetch()[0];
           break;
         case 'mailaddressLookup':
           echo $server->query('SELECT COUNT(\'id\') FROM ' . $tables['users'] . ' WHERE mail_address = ' . $server->quote($_GET['content']))->fetch()[0];
           break;
         case 'setPinnedContact':
           if (isset($_SESSION['network_id']))
           {
             if (is_array($_GET['content']) && is_numeric($_GET['content'][0]) && is_numeric($_GET['content'][1]))
             {
               /*
               // NOTE: The "content" GET array consists of the parsed value of the JSON sent through the client-side JS.
               //
               // The indexes values are set as follows:
               // 0 -> nid_match (network ID to match with DB)
               // 1 -> network_id (network ID of the contact to change)
               */
               $server->query('UPDATE ' . $tables['contacts'] . '
                               SET   favorite    = ' . $server->quote($_GET['content'][0]) . '
                               WHERE nid_match   = ' . $server->quote($_SESSION['network_id']) . '
                               AND   network_id  = ' . $server->quote($_GET['content'][1]));
               print '0';
             }
             else
             {
               print '1';
             }
           }
           else
           {
             print '2';
           }
           break;
         case 'sendMessage':
           if (isset($_SESSION['network_id']))
           {
             if (is_array($_GET['content']) && is_numeric($_GET['content'][0]))
             {
               $server->query('INSERT INTO ' . $tables['messages'] . '
               (
                 id,
                 content,
                 date,
                 nid_orig_match,
                 nid_dest_match,
                 queued
               )
               VALUES
               (
                 NULL,
                 ' . $server->quote($_GET['content'][1]) . ',
                 CURRENT_TIMESTAMP,
                 ' . $_SESSION['network_id'] . ',
                 ' . $_GET['content'][0] . ',
                 1
               )
              ');
             }
           }
           else
           {
             print '2';
           }
         case 'getLastMessage':
           // Returns the first message in the queue.
           if (isset($_SESSION['network_id']))
           {
             $message = $server->query('SELECT * FROM ' . $tables['messages'] . ' WHERE queued = 1 ORDER BY id ASC LIMIT 1');
             if ($message->rowCount() > 0)
             {
               // 0 == output for this case
               print json_encode($message->fetch());
             }
             else
             {
               // 1 == invalid request in context of "no queued messages"
               print '1';
             }
           }
           else
           {
             print '2';
           }
           break;
         case 'notifyMessageReceived':
           if (isset($_SESSION['network_id']))
           {
             // Fetch the last message.
             $message = $server->query('SELECT id FROM ' . $tables['messages'] . ' WHERE queued = 1 ORDER BY id ASC LIMIT 1')->fetch();

             // Take it off the queue.
             $server->query('UPDATE ' . $tables['messages'] . ' SET  queued = 0 WHERE id = ' . $message['id']);
             print '0';
           }
           else
           {
             print '2';
           }
           break;
         case 'startChat':
          /*
          // NOTE: This case features a custom response.
          //
          // 3 -> Busy
          */
          if (isset($_SESSION['network_id']))
          {
            if (is_numeric($_GET['content']))
            {
              $users = $server->query('SELECT busy       FROM ' . $tables['users'] . '
                                       WHERE  network_id =    ' . $_SESSION['network_id'] . '
                                       OR     network_id =    ' . $_GET['content'] . '
                                       LIMIT  2');
              if ($users->rowCount() > 0)
              {
                foreach ($users as $user)
                {
                  if ($user['busy'] == 1)
                  {
                    print '3';
                  }
                  else
                  {
                    $_SESSION['currentChat'] = $_GET['content'];
                    // TODO: Rework this, it'll affect the peformance at some point.
                    $server->query('UPDATE ' . $tables['users'] . '
                                    SET        busy                = 1,
                                               current_destination = ' . $_SESSION['currentChat'] . '
                                    WHERE      network_id          = ' . $_SESSION['network_id']);
                    $server->query('UPDATE ' . $tables['users'] . '
                                    SET        busy                = 1,
                                               current_destination = ' . $_SESSION['network_id'] . '
                                    WHERE      network_id          = ' . $_GET['content']);
                    print '0';
                  }
                  break;
                }
              }
              else
              {
                print '1';
              }
            }
            else
            {
              print '1';
            }
          }
          else
          {
            print '2';
          }
          break;

         default:
           print '1';
           break;
        }
     exit();
   }
   else
   {
     echo '1';
     exit();
   }
 }
 $title = 'API'; $force_max_height = true; $no_menu = true;
 require_once('includes/header.php');
?>
   <!--

     _____      _ _
    |  __ \    | | |
    | |__) |__ | | |_   _
    |  ___/ _ \| | | | | |
    | |  | (_) | | | |_| |
    |_|   \___/|_|_|\__, |
                     __/ |
                    |___/

   Hmm... that's an easter egg, I suppose.
   -->
   <div class="row valign-wrapper">
     <div class="col s12 center-align grey-text">
       <h5>
         <i class="large material-icons">code</i> <br>
          Hello, this is our API!
        </h5>
        <h6>
          You're allowed to use the following requests: usernameLookup, mailaddressLookup, setPinnedContact and startChat. <br>
          <br>
          I can handle JSON and plain text as both input and output, these depend on the outcome of the request and the expected response. <br>
          Feel free to take a look at the source code to learn more.
        </h6>
     </div>
   </div>
<?php
 require_once('includes/footer.php');
?>
