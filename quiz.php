<?php
session_start();

$fw = fopen("./results.txt","a+");
if (!isset($_COOKIE["loggedin"])){
  if (isset($_SESSION["number"])){
    fwrite($fw, $_SESSION["user"].":".$_SESSION["correct"]."\r\n");
    fclose($fw);
    session_destroy();
  }
  header("Location:./login.html");
  die();
}

if (!isset($_SESSION["number"]))
{
  $_SESSION["number"] = 0;
  $_SESSION["correct"] = 0;
  $_SESSION["user"] = $_COOKIE["loggedin"];
}

$accounts = array();
while(!feof($fw)) {
  $a = fgets($fw);
  $b = explode(':',trim($a));
  if ($b[0] != ""){
    array_push($accounts, $b[0]);
  }
}
for ($i = 0; $i < count($accounts); $i++){
  if ($accounts[$i] == $_SESSION["user"]){
    header("Location:./taken.html");
    die();
  }
}

$total_number = 6;
$script = $_SERVER['PHP_SELF'];

print <<<TOP
<html>
<head>
<title> Astronomy Quiz </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="./quiz.css">
</head>
<body>
TOP;

$number = $_SESSION["number"];
$correct = $_SESSION["correct"];

if ($number == 0)
{
  print <<<FIRST
  <h3>Question 1:</h3>
  <p>According to Kepler the orbit of the earth is a circle with the sun at the center.</p>
  <div class="radio">
    <form method = "post" action = $script>
      <label class="radio-inline"><input type="radio" name="q1" value="true">True</label>
      <label class="radio-inline"><input type="radio" name="q1" value="false">False</label>
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
FIRST;
}

elseif ($number == 1)
{
  if (isset($_POST["q1"])){
    if ($_POST["q1"] == "false"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<SECOND
  <h3>Question 2:</h3>
  <p>Ancient astronomers did consider the heliocentric model of the solar system but rejected it because they could not detect parallax.</p>
  <div class="radio">
    <form method = "post" action = $script>
      <label class="radio-inline"><input type="radio" name="q2" value = "true">True</label>
      <label class="radio-inline"><input type="radio" name="q2" value = "false">False</label>
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
SECOND;
}

elseif ($number == 2)
{
  if (isset($_POST["q2"])){
    if ($_POST["q2"] == "true"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<THIRD
  <h3>Question 3:</h3>
  <p>The total amount of energy that a star emits is directly related to its</p>
  <div class="checkbox">
    <form method = "post" action = $script>
      <label class="checkbox-inline"><input type="checkbox" name="q3" value="s">surface gravity and magnetic field</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q3" value="r">radius and temperature</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q3" value="p">pressure and volume</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q3" value="l">location and velocity</label>
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
THIRD;
}

elseif ($number == 3)
{
  if (isset($_POST["q3"])){
    if ($_POST["q3"] == "r"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<FOURTH
  <h3>Question 4:</h3>
  <p>Stars that live the longest have</p>
  <div class="checkbox">
    <form method = "post" action = $script>
      <label class="checkbox-inline"><input type="checkbox" name="q4" value="m">high mass</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q4" value="t">high temperature</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q4" value="h">lots of hydrogen</label><br/>
      <label class="checkbox-inline"><input type="checkbox" name="q4" value="s">small mass</label>
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
FOURTH;
}

elseif ($number == 4)
{
  if (isset($_POST["q4"])){
    if ($_POST["q4"] == "s"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<FIFTH
  <h3>Question 5:</h3>
  <div class="">
    <form method = "post" action = $script>
      <b>5)</b> A collection of a hundred billion stars, gas, and dust is called a ____.
      <input type="text" name="q5" class="form-control">.
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
FIFTH;
}

elseif ($number == 5)
{
  if (isset($_POST["q5"])){
    if (strtolower($_POST["q5"]) == "galaxy"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<SIXTH
  <h3>Question 6:</h3>
  <div class="">
    <form method = "post" action = $script>
      <p>The inverse of the Hubbles constant is a measure of the ____ of the universe.</p>
      <input type="text" name="q6" class="form-control">
      <br/><input type="submit" class="btn btn-default" value="Submit"/>
    </form>
  </div>
SIXTH;
}

if ($number >= $total_number)
{
  if (isset($_POST["q6"])){
    if (strtolower($_POST["q6"]) == "age"){
      $correct = $correct + 10;
      $_SESSION["correct"] = $correct;
    }
  }
  print <<<FINAL_SCORE
  <h3>Grade</h3>
  Your final grade is $correct correct out of 60. <br /><br />
  Thank you for taking the quiz. <br /><br />
FINAL_SCORE;
  fwrite($fw, $_SESSION["user"].":".$correct."\r\n");
  fclose($fw);
  session_destroy();
}
else
{
  $number++;
  $_SESSION["number"] = $number;
}

print <<<BOTTOM
</body>
</html>
BOTTOM;

?>
