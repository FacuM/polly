<?php
 $secure = true;
 require_once('config.php');
 if (isset($_SESSION['destination']))
 {
   header('location: chats.php');
 }
 $title = 'Home'; $css = 'index.css';
 require_once('includes/header.php');
 // Do a contacts lookup.
 $contactsQuery = $server->query('SELECT * FROM ' . $tables['contacts'] . ' WHERE nid_match = ' . $_SESSION['network_id']); $contacts = '';
 foreach ($contactsQuery as $contact)
 {
   $contact_item = '
     <li class="collection-item avatar">
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
        <input class="network_id" type="hidden" value="' . $contact['network_id'] . '">
       </a>
     </li>
    <div class="divider"></div>';
   if ($contact['favorite'] == 0)
   {
     $contacts .= $contact_item;
   }
   else
   {
     $contacts = $contact_item . $contacts;
   }
 }
 // Prepend and append parent element.
 $contacts = '
 <ul class="collection">' . $contacts;
 $contacts .= '
 </ul>';
 // Clean now unused variable.
 $contact_item = null;
?>
 <div class="row valign-wrapper">
   <div class="col s12">
     <h5 class="grey-text center-align">
       <i class="large material-icons">message</i> <br>
       Nothing here! Wanna chat? Head to the <a class="modal-trigger" href="#contacts_picker">contact picker</a>!</h5>
   </div>
 </div>
 <div id="contacts_picker" class="modal">
   <div class="modal-content">
    <?php echo $contacts; ?>
   </div>
 </div>
<?php
 require_once('includes/footer.php');
?>
