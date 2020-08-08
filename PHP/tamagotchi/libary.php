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
  $knowledgeSkills = intval($value["knowledge"]) + 1;
  $knowledge = $value["knowledge"];
  if(!empty($_GET["readBook"])){
    $sql = "UPDATE tamagotchi SET Knowledge='{$knowledgeSkills}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
    header("Location: libary.php");
  }
}

$books = ["book1.png", "book2.png", "book3.png"];
?>


<div class="container">
  <h3 style="text-align:center;"> ChooseBook to read</h3>
  <h2 style="text-align:center;">Knowledge level: <?php echo $knowledge; ?></h2>
  <div class="flex-box" style="min-height:500; flex-wrap:wrap; width:50%; padding-top:50px;">
    <?php
    for($i = 0; $i < 3; $i++): ?>
      <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="flex-item" style="margin:10px;">
          <img src="../pageRelatedPictures/<?php echo $books[$i]; ?>" style="height: 100px; width: 130px;"><br>
          <input type="Submit" name="readBook" value="<?php echo $books[$i]; ?>">
        </div>
      </form>
    <?php endfor; ?>
  </div>
</div>
