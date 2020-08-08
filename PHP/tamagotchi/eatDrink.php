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
  $hungerStats = $value["hunger"];
  $thirstStats = $value["thirst"];
}


#Egg
if(!empty($_GET["egg"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $hunger = $value["hunger"] + 1;
  }
  $sql = "UPDATE tamagotchi SET hunger='{$hunger}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
    header("Location: eatDrink.php");
  }
}

#hot dog
if(!empty($_GET["hotDog"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $hunger = $value["hunger"] + 2;
  }
  $sql = "UPDATE tamagotchi SET hunger='{$hunger}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
    header("Location: eatDrink.php");
  }
}
#chicken
if(!empty($_GET["chicken"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $hunger = $value["hunger"] + 3;
  }
  $sql = "UPDATE tamagotchi SET hunger='{$hunger}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
    header("Location: eatDrink.php");
  }
}

#Steak
if(!empty($_GET["steak"])){
  $sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  foreach($arr as $value){
    $hunger = $value["hunger"] + 4;
  }
  $sql = "UPDATE tamagotchi SET hunger='{$hunger}' WHERE username='{$username}'";
  if(!mysqli_query($connect, $sql)){
    echo mysqli_error($connect);
    header("Location: eatDrink.php");
  }
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
    header("Location: eatDrink.php");
  }
}
?>

<div class="container">
  <h3 style="text-align:center;"> Choose what to feed you Tamagotchi with</h3>
  <h4 style="text-align:center;"><?php echo "Tamagotchi's hunger status: " . $hungerStats; ?></h4>
  <div class="flex-box">

    <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/Egg.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="egg" value="Egg">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/hotDog.png" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="hotDog" value="Hot dog">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/Chicken.jpg" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="chicken" value="Chicken">
      </div>

      <div class="flex-item" style="margin:10px; padding:10px; border:solid 2px;">
        <img src="../pageRelatedPictures/steak.png" style="height: 100px; width: 100px;"><br>
        <input type="submit" name="steak" value="Steak">
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
