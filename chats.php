<?php
 $title = 'Chats'; $css = 'chats.css'; $secure = true;
 require_once('config.php');
 require_once('includes/header.php');
?>
 <input id="origin" type="hidden" value="<?php echo $_SESSION['network_id']; ?>">
 <input id="destination" type="hidden" value="<?php echo $_SESSION['destination']; ?>">
 <div id="screen" class="row">
   <div id="chats" class="col s4">
       <?php
       // TODO: Write a relational query to improve the performance.
       $contactsQuery = $server->query('SELECT *          FROM ' . $tables['contacts'] . '
                                        WHERE  nid_match  =    ' . $_SESSION['network_id']); $contacts = '';
       foreach ($contactsQuery as $contact)
       {
         $user = $server->query('SELECT busy FROM ' . $tables['users'] . ' WHERE network_id = ' . $contact['nid_match'])->fetch();
         $is_selected = $contact['network_id'] == $_SESSION['destination'];
         $contact_item = '
          <form method="GET" action="chats.php">
             <li class="collection-item ' . ($is_selected ? 'active'  : '') . ' avatar">
              <div class="item">
               <img src="assets/images/' . ($contact['avatar'] === NULL ? 'public/avatar_default.svg' : 'private/' . $contact['avatar']) . '" alt="' . $contact['username'] . '_avatar" class="circle">
               <span class="title">' . $contact['first_name'] . ' ' . $contact['last_name'] . '</span>
               <p>
                @' . $contact['username']   . '<br>
                 ' . $contact['birth_date'] . '<br>
                 ' . $contact['phone']      . '<br>
               </p>
              </div>
               <a href="#!" class="secondary-content">
                <i class="material-icons favorite ' . ($contact['favorite'] == 1 ? 'favorite_pinned' : 'favorite_unpinned') .'">grade</i>
                <i class="material-icons ';
                // If it's the active item, append a material forum icon.
                if ($is_selected) { $contact_item .= '">forum'; }
                else { // If the user is available, append a material green check circle icon.
                       if ($user['busy'] == 0) { $contact_item .= 'green-text">check_circle'; }
                       // If the user is busy, append a darkened material red remove circle icon.
                       else { $contact_item .= 'red-text text-darken-3">remove_circle'; }
                }
               $contact_item .= '
                </i>
               </a>
             </li>
          </form>
          <div class="divider"></div>';
         if ($contact['favorite'] == 1)
         {
           $contacts = $contact_item . $contacts;
         }
         else
         {
           $contacts .= $contact_item;
         }
       }
       // Prepend and append parent element.
       $contacts = '
       <ul class="collection">' .
       $contacts;
       $contacts .= '
       </ul>';
       // Clean now unused variable.
       $contact_item = null;
       echo $contacts;
        ?>
<!--
     <div class="fixed-action-btn">
      <a class="btn-floating btn-large red waves-effect waves-light">
       <i class="large material-icons">add</i>
      </a>
     </div>
-->
   </div>
   <div id="content" class="col s8">
     <div id="messages">
       <?php
        foreach ($server->query('SELECT * FROM ' . $tables['messages'] . '
                                 WHERE
                                 nid_orig_match = ' . $_SESSION['network_id'] . '
                                 OR
                                 nid_dest_match = ' . $_SESSION['network_id'] . '
        ') as $message)
        {
          if ($message['nid_orig_match'] == $_SESSION['network_id'])
          {
          echo '
           <div class="row">
            <input class="message_id" type="hidden" value="' . $message['id'] . '">
            <div class="col s8"></div>
            <div class="col s4 z-depth-1 collection teal message_bubble">
             <span class="collection-item teal white-text">' .
              $message['content'] . '
             </span>
            </div>
           </div>';
          }
          else
          {
            echo '
            <div class="row">
             <input class="message_id" type="hidden" value="' . $message['id'] . '">
             <div class="col s4 z-depth-1 collection red message_bubble message_bubble_other">
              <span class="collection-item red white-text">' .
               $message['content'] . '
              </span>
             </div>
             <div class="col s9"></div>
            </div>';
          }
        }
      ?>
      <div id="overflow" class="z-depth-2 white valign-wrapper center-align">
        <i class="small material-icons">keyboard_arrow_down</i>
      </div>
     </div>
     <div class="row">
       <div class="input-field col s11">
         <input id="message" type="text" maxlength="65535" data-length="65535">
         <label for="message">Type your message...</label>
       </div>
       <div class="col s1 center-align">
         <i id="send_icon" class="material-icons red-text lighten-2" onclick="sendMessage();">send</i>
       </div>
     </div>
   </div>
 </div>

 <!-- Modals -->
 <div id="end_chat" class="modal">
   <div class="modal-content">
     <h5>End chat</h5>
     <div class="divider"></div>
     <p>Do you really want to end this chat session?</p>
   </div>
   <div class="modal-footer">
     <a id="end_chat_yes" href="#!" class="waves-effect btn-flat">Yes</a>
     <a href="#!" class="modal-close waves-effect btn-flat">No</a>
   </div>
 </div>

 <!-- Scripts -->
 <script defer src="assets/scripts/chats.js"></script>
<?php
 require_once('includes/footer.php');
?>
