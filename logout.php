<?php
include 'importClass.php';

// create the user and call the log out function.
$user = new User();
$user->logout();



header('Location: index.php');
?>
