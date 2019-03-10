<?php
 require_once('config.php');
 if (isset($secure) && $secure && !isset($_SESSION['network_id']))
 {
   header('location: login.php');
   exit();
 }
?>
<!DOCTYPE html>
<html>
 <head>
   <title><?php echo $title . ' - ' . $siteinfo['main_title']; ?></title>
   <meta charset="UTF-8"> <!-- Set custom charset. TODO: Evaluate non-UTF-8. -->
   <meta lang="en"> <!-- Set custom language. -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Responsive meta -->
   <!-- MaterializeCSS styles -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <!-- Material icons -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- jQuery -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!-- Common styles -->
   <link rel="stylesheet" href="assets/styles/common.css">
   <?php
    echo '<link rel="stylesheet" href="assets/styles/' . $css . '">';
   ?>
   <style>
    .spinner-layer {
      border-color:  <?php echo $colors['accent']; ?>;
    }
   </style>
   <!-- TODO: Fix up this accent issue.
   <style>
    * { border-bottom-color: <?php echo $colors['accent']; ?> }
   </style> -->
 </head>
 <body>
   <header>
     <!-- Desktop -->
     <nav>
       <div class="nav-wrapper">
         <a href="#" class="brand-logo">Polly</a>
         <a href="#" class="sidenav-trigger" data-target="sidenav-mobile"><i class="material-icons">menu</i></a>
         <?php
          if (isset($_SESSION['network_id']) && (!isset($no_menu) || !$no_menu))
          {
           echo '
           <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="index.php">Home</a></li>' . (isset($_SESSION['destination']) ? '
            <li><a href="#end_chat" class="modal-trigger">End chat</a></li>' : '') . '
            <li><a href="logout.php">Log out</a></li>
           </ul>';
          }
         ?>
       </div>
     </nav>

     <!-- Mobile -->
     <?php
      if (isset($_SESSION['network_id']) && (!isset($no_menu) || !$no_menu))
      {
       echo '
       <ul class="sidenav" id="sidenav-mobile">
        <li><a href="index.php">Home</a></li>' . (isset($_SESSION['destination']) ? '
        <li><a href="#end_chat" class="modal-trigger">End chat</a></li>' : '') . '
        <li><a href="logout.php">Log out</a></li>
       </ul>';
      }
     ?>
   </header>
   <main>
     <div class="section"></div>
