<?php
 require_once('config.php');
 if (
     isset($_POST['username'])   &&
     isset($_POST['password'])   &&
     isset($_POST['mail'])       &&
     isset($_POST['date'])       &&
     isset($_POST['phone'])      &&
     isset($_POST['first_name']) &&
     isset($_POST['last_name'])
    )
 {
   $server->query('INSERT INTO ' . $tables['users'] . '
     (
     `network_id`,
     `username`,
     `password`,
     `mail_address`,
     `birth_date`,
     `phone`,
     `registration_date`,
     `first_name`,
     `last_name`
     )
   VALUES
     (
       NULL ,
       ' . $server->quote($_POST['username']) . ',
       ' . $server->quote($_POST['password']) . ',
       ' . $server->quote($_POST['mail']) . ',
       ' . $server->quote($_POST['date']) . ',
       ' . $server->quote($_POST['phone']) . ',
           CURRENT_TIMESTAMP,
       ' . $server->quote($_POST['first_name']) . ',
       ' . $server->quote($_POST['last_name']) . '
     );
   ');
   header('location: login.php?from_registration=true');
 }
 $title = 'Register';
 require_once('includes/header.php');
?>
  <div class="container center-align form">
    <h5><?php echo $title; ?></h5>
    <div class="row grey z-depth-2 lighten-4 s12">
      <div class="section">
        <form class="col s12" method="post" action="">

          <div class="row">
            <div class="input-field col s12">
              <input name="username" placeholder="Your username" id="username" type="text" maxlength="50" data-length="50">
              <label for="username">Username</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="password" placeholder="Your password" id="password" type="password" maxlength="25" data-length="25">
              <label for="password">Password</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input placeholder="Repeat your password" id="password_verify" type="password" maxlength="25" data-length="25">
              <label for="password_verify">Repeat your password</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="mail" placeholder="Your mail address" id="mail" type="text" maxlength="75" data-length="75">
              <label for="mail">Mail address</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="date" placeholder="Your birth date" id="date" type="text">
              <label for="date">Birth date</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="phone" placeholder="Your phone number" id="phone" type="text" maxlength="20" data-length="20">
              <label for="phone">Phone number</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="first_name" placeholder="Your first name" id="first_name" type="text" maxlength="50" data-length="50">
              <label for="first_name">First name</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="last_name" placeholder="Your last name" id="last_name" type="text" maxlength="50" data-length="50">
              <label for="last_name">Last name</label>
            </div>
          </div>

          <div class="row center-align">
            <div class="col s12">
              <table id="login_buttons">
                <tr>
                  <td> Already in? <a href="login.php">Login!</a> </td>  <td class="right-align"> <button class="btn waves-effect waves-light red lighten-2" type="submit">Register</button> </td>
                </tr>
              </table>
            </div>
          </div>
       </form>
     </div>
    </div>
  </div>
  <script src="assets/scripts/register.js"></script>
<?php
 require_once('includes/footer.php');
?>
