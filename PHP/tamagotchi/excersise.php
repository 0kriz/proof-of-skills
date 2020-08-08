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
  $strengthStats = $value["strength"];
  $thirstStats = $value["thirst"];
}


#ligth weigth
if(!empty($_GET["ligthWeight"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $strength = $value["strength"] + 1;
  }
  $sql = "UPDATE tamagotchi SET strength='{$strength}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
  }
  header("Location: excersise.php");
}

# medium weigth
if(!empty($_GET["mediumWeight"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $strength = $value["strength"] + 2;
  }
  $sql = "UPDATE tamagotchi SET strength='{$strength}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
  }
  header("Location: excersise.php");
}

#ligth weigth
if(!empty($_GET["heavyWeight"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $strength = $value["strength"] + 3;
  }
  $sql = "UPDATE tamagotchi SET strength='{$strength}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
  }
  header("Location: excersise.php");
}

#ligth weigth
if(!empty($_GET["cardio"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $strength = $value["strength"] + 2;
  }
  $sql = "UPDATE tamagotchi SET strength='{$strength}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
  }
  header("Location: excersise.php");
}


#thirst
if(!empty($_GET["thirst"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $thirst = $value["thirst"] + 3;
  }
  $sql = "UPDATE tamagotchi SET thirst='{$thirst}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
  }
  header("Location: excersise.php");
}
?>

<div class="container">
  <h3 style="text-align:center;"> Choose excersise</h3>
  <h4 style="text-align:center;"><?php echo "Tamagotchi's strength: " . $strengthStats; ?></h4>
  <div class="flex-box">

    <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/light dumbell.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="ligthWeight" value="light weight">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/medium dumbell.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="mediumWeight" value="medium weight">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/heavy dumbell.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="heavyWeight" value="heavy weight">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/cardio.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="cardio" value="carido">
      </div>

    </form>
  </div>

  <h3 style="text-align:center;"> Give your Tamagotchi water</h3>
  <h4 style="text-align:center;"><?php echo "Tamagotchi's thirst status: " . $thirstStats; ?></h4>
  <div class="flex-box">
    <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <img src="../pageRelatedPictures/water.jpg" style="height: 100px; width: 100px;"><br>
          <input type="submit" name="thirst" value="thirst">
        </form>
    </div>

  </div>

</div>
