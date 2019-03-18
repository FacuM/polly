<?php
 /*
 // Polly uses relative paths, that way, it doesn't rely on hardcoded or absolute paths.
 //
 // No extra path setups are required.
 */

 // Website name (displayed as part of the title tag).
 $siteinfo = array(
   'main_title' => 'Polly'
 );

 // Database server credentials.
 $server = array (
   'hostname'   => 'localhost',
   'port'       => 3307,
   'username'   => 'root',
   'password'   => 'usbw',
   'database'   => 'polly'
 );

 // Database tables.
 $tables = array (
   'users'      => 'polly_users',
   'contacts'   => 'polly_contacts',
   'messages'   => 'polly_messages'
 );

 // Website colors (to help improve MaterializeCSS support for custom colors).
 $colors = array(
   'accent'     => '#e57373'
 );

 // Global animations timeout (ms).
 $atime = array (
   'short'      => 500,
   'long'       => 4000
 );

 // Chat update rate (ms)
 $chat_urate = 500;


 // NOTE: From now on, don't edit anything.

 // Open a connection to the database.
 try {
  $server = new PDO('mysql:host=' . $server['hostname'] . ':' . $server['port'] . ';dbname=' . $server['database'] .';charset=utf8', $server['username'], $server['password']);
 } catch (PDOException $e) {
  $secure = false; $css = 'index.css'; $title = 'Fatal exception';
  require_once('includes/header.php');
  echo '
   <div class="row valign-wrapper">
     <div class="col s12">
       <h5 class="grey-text center-align">
         <i class="large material-icons">link_off</i> <br>
         Oops... We are unable to connect to the database. Would you like to <a href="">reload</a> and try again?</h5>
     </div>
   </div>';
  require_once('includes/footer.php');
  $server = null;
  error_log($e->getMessage());
  exit();
 }

 // Start or resume the session.
 session_start();

 if (isset($secure) && $secure && isset($_SESSION['network_id']))
 {
   // Prepare the environment, force join chat if left in the middle of a session.
   $user = $server->query('SELECT busy, current_destination FROM ' . $tables['users'] . '
                           WHERE  network_id =    ' . $_SESSION['network_id'] . '
                           LIMIT  1')->fetch();
   if ($user['busy'] == '1')
   {
     $_SESSION['destination'] = $user['current_destination'];
   }
 }

 // Include custom functions.
 require_once('includes/functions.php');
?>
