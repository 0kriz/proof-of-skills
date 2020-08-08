<?php
include "header.php";
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
} ?>

<div class="container">
  <div class="flex-box" style="margin-top: 50px;">
    <div class="flex-item" style="margin:40px;">
      <?php
      $articleId = $_SESSION["articleID"];

      $sql = "SELECT * FROM articles WHERE id=$articleId";
      $do = mysqli_query($connect, $sql);
      $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);

      foreach($arr as $value): ?>
        <h3><?php echo $value["title"] . "<br>"; ?></h3>
        <img src="uploads/<?php echo $value['fileName']; ?>" style="height:250px;"><br><br>
        <h4><?php echo $value["header"] . "<br>"; ?></h4>
        <div style="min-height: 250px; text-align: left;">
          <?php echo $value["myText"] . "<br>"; ?>
        </div>
        <?php echo "User: " . $value["username"] . "<br>"; ?>

      <?php endforeach; ?>
  </div>
  </div>
</div>

<?php include "footer.php" ?>
