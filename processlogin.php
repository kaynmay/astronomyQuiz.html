<?php
$fw = fopen("./passwd.txt","r");
$user = $_POST["userName"];
$pass = $_POST["passWord"];
$accounts = array();
while(!feof($fw)) {
  $a = fgets($fw);
  $b = explode(':',trim($a));
  if ($b[0] != ""){
    array_push($accounts, $b[0], $b[1]);
  }
}
for ($i = 0; $i < count($accounts); $i = $i + 2){
  if ($accounts[$i] == $user){
    if ($accounts[$i+1] == $pass){
      setcookie("loggedin", $user, time()+900);
      header("Location:./quiz.php");
      exit;
    }
  }
}
fclose($fw);
header("Location:./login.html");
exit;
?>
