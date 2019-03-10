<?php
 require_once('config.php');
 if (isset($_SESSION['network_id']))
 {
   header('location: index.php');
   exit();
 }
 if (
     isset($_POST['um']) &&
     isset($_POST['password'])
    )
 {
   if (empty($_POST['um']) || empty($_POST['password']))
   {
     $err = 'Empty fields? That won\'t work.';
   }
   else
   {
     // Look for a mail address in the username/mail address string.
     if (strpos($_POST['um'], '@') === false)
     {
       $user = $server->query('SELECT * FROM ' . $tables['users'] . '
       WHERE
       username = ' . $server->quote($_POST['um']) . '
       AND
       password = ' . $server->quote($_POST['password']) . '
       LIMIT 1');
     }
     else
     {
       $user = $server->query('SELECT * FROM ' . $tables['users'] . '
       WHERE
       mail_address = ' . $server->quote($_POST['um']) . '
       AND
       password     = ' . $server->quote($_POST['password']) . '
       LIMIT 1');
     }

     if ($user->rowCount() < 1)
     {
       $err = 'Oops... you must\'ve missed something! Please try again.';
     }
     else
     {
       $_SESSION['network_id'] = $user->fetch()['network_id'];
       header('location: index.php');
     }
   }
 }
 $title = 'Login'; $css = 'login.css';
 require_once('includes/header.php');
?>
 <div class="container center-align form">
   <h5><?php echo $title; ?></h5>
   <div class="row grey z-depth-2 lighten-4 s12">
     <div class="section">
       <form class="col s12" method="post" action="">

         <div class="row">
           <div class="input-field col s12">
             <input name="um" placeholder="Your username or mail address" id="um" type="text" maxlength="25" data-length="25">
             <label for="um">Username or mail address</label>
           </div>
         </div>

         <div class="row">
           <div class="input-field col s12">
             <input name="password" placeholder="Your password" id="password" type="password" maxlength="25" data-length="25">
             <label for="password">Password</label>
           </div>
         </div>

       </form>

       <div class="row center-align">
         <div class="col s12">
           <table id="login_buttons">
             <tr>
               <td> <a href="register.php">Create an account</a> </td>
               <td class="right-align">
                 <button id="login" class="btn waves-effect waves-light red lighten-2" type="submit">Login</button>
                 <!-- A oneline version of the preloader from the docs: https://materializecss.com/preloader.html -->
                 <div class="preloader-wrapper small active"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
               </td>
             </tr>
           </table>
         </div>
       </div>

    </div>
   </div>
 </div>
 <script defer src="assets/scripts/login.js"></script>
<?php
 if (isset($err))
 {
   echo '
   <script>
    var mErrMsg = "' . $err . '";
   </script>';
 }
 if (isset($_GET['from_registration']))
 {
   echo '
   <div class="tap-target" data-target="login">
    <div class="tap-target-content white-text">
     <h5>Hey there, welcome to ' . $siteinfo['main_title'] . '!</h5>
     <p>We\'re glad you just created an account on our site. You can now type in your credentials and login!</p>
    </div>
   </div>
   <script defer src="assets/scripts/firstlogin.js"></script>';
 }
 require_once('includes/footer.php');
?>
