<?php include "header.php";
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}

if(!empty($_GET["articleID"])){
  $_SESSION["articleID"] = $_GET["articleID"];
  header("Location: seeArticle.php");
}

if(!empty($_GET["submitSeach"])){
  if($_GET["seach"] != ""){
    $seach = $_GET["seach"];
    $sql = "SELECT * FROM articles WHERE title='{$seach}' OR header='{$seach}' OR myText='{$seach}' OR username='{$seach}'";
    $do = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
    $header = "Seach Results";
  } else {
    $sql = "SELECT * FROM articles";
    $do = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
    $header = "All Articles"; }

} else {
  $sql = "SELECT * FROM articles";
  $do = mysqli_query($connect, $sql);
  $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
  $header = "All Articles";
}

?>


<div class="container">
  <div class="flex-box" style="min-height:100px; margin-top:40px; flex-direction:column">
    <div class="flex-item">
      <h3>Seach</h3>
    </div>

    <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <div class="flex-item" style="padding-bottom:40px;">
        <input type="text" name="seach">
        <input type="Submit" name="submitSeach">
      </div>
    </form>

  </div>

  <h1 style="text-align: center; margin-top: 80px; margin-bottom: 80px;"><?php echo $header; ?></h1>
  <div class="flex-box-articles" style="min-height:500px; margin-top:40px;">

    <?php
    foreach($arr as $value): ?>
        <div class="flex-item-articles" style="">
          <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <button type="submit" name="articleID" value="<?php echo $value["id"]; ?>" style="border:none; border-radius:10px; padding:20px;">
              <?php
                echo $value["title"] . "<br>";
                echo $value["header"] . "<br>";
                echo $value["myText"] . "<br>";
                echo $value["username"] . "<br>";
              ?>
              <img src="uploads/<?php echo $value['fileName']; ?>" style="height:100px;">
            </button>
          </form>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php include "footer.php" ?>
