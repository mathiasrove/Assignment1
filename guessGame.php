<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>GuessGame</title>
  </head>
  <body>
<?php 
session_save_path("sess");
session_start(); // must be first thing in the php file
?>

<?php
if(empty($_SESSION['username'])){
  //username is unset or empty
  header('Location: login.php');
}
?>
<h1> Welcome to guessGame </h1>
<a href="logout.php">Logout (user: <?php echo $_SESSION['username']?>)</a>
<form action="guessGame.php" method="post">
  <p> Your guess: </p>
  <input type="text" name="guess"> 
  <input type="submit" value="Check my guess"> 
</form>
<?php

if(!is_numeric($_SESSION['expect'])){
  $_SESSION['expect'] = rand(1,100);
}
$expect = $_SESSION['expect'];

if(!is_array($_SESSION['guesses'])){
  $_SESSION['guesses'] = array();
}

if(is_numeric($_REQUEST['guess'])){
  array_push($_SESSION['guesses'],$_REQUEST['guess']);
}
$guesses = $_SESSION['guesses'];
echo "<p>";
foreach ($guesses as $key=>$val) {
  echo "Your guess # ".($key+1)." was $val ";
  if($val!=$expect){
    echo $val<$expect?"too low":"too high";
  }else{
    echo "correct!<br/><br/><b>Your game has been reset, try guessing another number now?</b>";
    $_SESSION['guesses']=array();
    $_SESSION['expect'] = rand(1,100);
  }
  echo "<br/>";
}
echo "</p>";

?>
</body>
</html>
