<?php 
session_save_path("sess");
session_start();
session_unset(); //remove the expected number to guess as well
header('Location: login.php');
?>
