<DOCTYPE!>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
<html>
<head>
  <?php
  include "../ConnectDatabase.php";
  SESSION_START();
  if (!empty($_SESSION["userID"])): ?>
  <div class="navigation-bar">
    <a href="../MyProfile.php">MyProfile</a>
    <a href="../UploadArticle.php">Upload Article</a>
    <a href="../Articles.php">Articles</a>
    <a href="../Chat.php">Chat Application</a>
    <a href="../Tamagochi.php">Tamagochi game</a>
    <a href="../Contact.php">Contact</a>
    <?php $username= $_SESSION["userID"]; ?>
  </div>
<?php endif;
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: ../mainpage.php");
} ?>
</head>


<?php

$sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
foreach($arr as $value){
  $socialSkills = intval($value["socialisation"]) + 1;
  $socialisation = $value["socialisation"];
  if(!empty($_GET["talkToTama"])){
    $sql = "UPDATE tamagotchi SET socialisation='{$socialSkills}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
    header("Location: Socialize.php");
  }
}


?>


<div class="container">

  <h2 style="text-align:center;">Social level: <?php echo $socialisation; ?></h2>
  <h1 style="text-align:center;"> Choose Tamagotchi to talk to</h1>
  <div class="flex-box" style="min-height:500; flex-wrap:wrap; width:50%; padding-top:50px;">
    <?php $sql = "SELECT * FROM tamagotchi";
    $do = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
    foreach($arr as $value): ?>
      <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="flex-item" style="margin:10px;">
          <img src="../pageRelatedPictures/snauzer.jpg" style="height: 100px; width: 130px;"><br>
          <input type="Submit" name="talkToTama" value="<?php echo $value["username"] . "'s Tamagotchi";?>">
        </div>
      </form>
    <?php endforeach; ?>
  </div>
</div>
