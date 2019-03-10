<?php
 require_once('config.php');
 $server->query('UPDATE ' . $tables['users'] . '
                 SET        busy                 = 0
                 WHERE      network_id           = ' . $_SESSION['network_id'] . '
                 OR         network_id           = ' . $_SESSION['destination']);
 unset($_SESSION['destination']);
 header('location: index.php');
?>
