<DOCTYPE!>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<html>
<head>
  <?php
  include "ConnectDatabase.php";
  SESSION_START();
  if (!empty($_SESSION["userID"]) AND $_SESSION["userID"] != "dummy"): ?>
  <div class="navigation-bar">
    <a href="MyProfile.php">MyProfile</a>
    <a href="UploadArticle.php">Upload Article</a>
    <a href="Articles.php">Articles</a>
    <a href="Chat.php">Chat Application</a>
    <a href="Tamagochi.php">Tamagochi game</a>
    <a href="Contact.php">Contact</a>
    <?php $username = $_SESSION["userID"]; ?>
  </div>
  <?php endif; ?>
</head>
