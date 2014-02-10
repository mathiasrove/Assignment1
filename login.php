<!DOCTYPE html >
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>GuessGame - Login</title >
  </head>
  <body>

<?php 
session_save_path('sess');
session_start(); 
?>

<h1> Welcome to ToDo </h1>
<form action="login.php" method="post">
  <p> Enter username and password: </p>
  <input type="text" name="username"> 
  <input type="password" name="password" > 
  <br/>
  <input type="checkbox" id="signupid" name="signup">
  <label for="signupid">I am a new user, sign me up.</label>
  <br/>
  <input type="submit" name="" id="" value="Submit" />
</form>

<?php
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$signup = $_REQUEST['signup'];
if (!empty($username) && !empty($password)){
  //TODO: hash password
  $dbconn = pg_connect("host=localhost port=5432 dbname= user=  password=");
	if(!$dbconn){
		echo("Can't connect to the database");	
		exit;
	}

  if($signup!="on"){
    $select_query="SELECT * from appuser where username = $1 and password = $2";
    $result = pg_prepare($dbconn, "my_query", $select_query);
    $result = pg_execute($dbconn, "my_query", array($username,$password)); # fill in the $1 and $2 respectively and run query
    if($result){
      if (pg_fetch_row($result)){
        $_SESSION['username'] = $username;
	header('Location: guessGame.php' ) ;
      }else {
        echo("Wrong username/password;");
      }

    } else {
      echo("Wrong username/password;");
    }
  }else{
    $insert_query="INSERT INTO appuser VALUES ($1,$2)";
    $result = pg_prepare($dbconn, "my_query", $insert_query);
    $result = pg_execute($dbconn, "my_query", array($username,$password)); # fill in the $1 and $2 respectively and run query
    if($result){
      $rows_affected=pg_affected_rows($result);
      if ($rows_affected>0){
        echo("Sucessfully signed you up, you may log in now.");
      }else{
        echo("Something went wrong, try another username?");
      }
    } else {
      echo("Something went wrong");
    }
  }
}

?>

</body>
</html>

