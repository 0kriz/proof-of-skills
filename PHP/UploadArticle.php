<?php include "header.php";
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}

?>



<div class="flex-box" style="margin-top: 40px; flex-direction:column;">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
    <div class="flex-item" style="margin-top: 40px;">
      <label>Title</label>
      <input type="text" name="title">
    </div>

    <div class="flex-item">
      <label>Header</label>
      <input type="text" name="header">
    </div>

    <div class="flex-item">
      <label><h3>Your Text</h3></label><br>
      <textarea name="articleText" rows="10" cols="60"></textarea>
    </div>

    <div class="flex-item" style="justify-content: flex-start;">
      <input type="file" name="file">
    </div>

    <div class="flex-item" style="margin-top: 40px;">
      <button type="submit" name="submit">Upload Article</button>
    </div>
  </form>


</div>

<?php include "footer.php" ?>
