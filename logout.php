<?php
include 'importClass.php';

$user = new User();
$user->logout();



header('Location: index.php');
?>
