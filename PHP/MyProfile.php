<?php
include "header.php";
include "ConnectDatabase.php";
if (empty($_SESSION["userID"])) {
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}



#update mytext
if(!empty($_GET["submitMyText"])){
  if(!empty($_GET["mytext"])){
    $mytext = mysqli_real_escape_string($connect, htmlentities($_GET["mytext"]));
    $sql = "UPDATE userdata SET myText='{$mytext}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
  } else { $mytextMessage = "Write a text to submit!"; }
}

# update profile info
if(!empty($_GET["submitProfileUpdate"])) {
  if(!empty($_GET["firstname"])){
    $firstname = mysqli_real_escape_string($connect, htmlentities($_GET["firstname"]));
    $sql = "UPDATE userdata SET firstname='{$firstname}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
  }
  if(!empty($_GET["lastname"])){
    $lastname = mysqli_real_escape_string($connect, htmlentities($_GET["lastname"]));
    $sql = "UPDATE userdata SET lastname='{$lastname}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
  }
  if(!empty($_GET["email"])){
    $email = mysqli_real_escape_string($connect, htmlentities($_GET["email"]));
    $sql = "UPDATE userdata SET email='{$email}' WHERE username='{$username}'";
    mysqli_query($connect, $sql);
  }
}

# if articles, Get articles
$sql = "SELECT * FROM articles WHERE username='{$username}'";
$do = mysqli_query($connect, $sql);
$userArticles = mysqli_fetch_all($do, MYSQLI_ASSOC);

# redirect to seeArticle.php
if(!empty($_GET["articleID"])){
  $_SESSION["articleID"] = $_GET["articleID"];
  header("Location: seeArticle.php");
}

#logOut
if(!empty($_GET["logOut"])){
  SESSION_DESTROY();
  header("Location: mainpage.php");
}

#Delete User
if(!empty($_GET["deleteUser"])){
  $sqlUser = "DELETE FROM userdata WHERE username='{$username}'";
  $sqlMessage = "DELETE FROM chat WHERE person1='{$username}' OR person2='{$username}'";
  $sqlTama = "DELETE FROM tamagotchi WHERE username='{$username}'";
  $sqlArticle = "DELETE FROM articles WHERE username='{$username}'";
  mysqli_query($connect, $sqlUser);
  mysqli_query($connect, $sqlMessage);
  mysqli_query($connect, $sqlTama);
  mysqli_query($connect, $sqlArticle);
  unset($_SESSION["userID"]);
  header("Location: mainpage.php");
}

# show personal info left bar
$sql = "SELECT * FROM userdata WHERE username='{$username}'";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
?>

<div class="container" style="display: flex">
  <div class="side-menu">
    <div class="side-menu-item" style="margin-top:80px;">
      <img src="pageRelatedPictures/unknownBlue.png" style="height: 130px; border-radius:30px;">
    </div>
    <?php foreach($arr as $value ): ?>
      <div class="side-menu-item" style="margin-top: 50px;"> <?php
        echo "Firstname: " . $value["firstname"]; ?>
      </div>
      <div class="side-menu-item"> <?php
        echo "Lastname: " . $value["lastname"]; ?>
      </div>
      <div class="side-menu-item"> <?php
        echo "Username: " . $value["username"]; ?>
      </div>
      <div class="side-menu-item"> <?php
        echo "Email: " . $value["email"]; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="container" style="display:flex; flex-direction:column; width:100%;">

  <div class="mytext-MyProfile">

    <div class="mytext-item">
      <?php if(!empty($arr[0]["myText"])) {
        echo $arr[0]["myText"];
      } else { echo "Write your text here!"; } ?>
    </div>

      <div class="mytext-item" style="margin-top: 20px;">
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="justify-content: center;">
          <textarea name="mytext" rows="5" cols="50"></textarea>
      </div>
      <div class="mytext-item" style="margin-top: 20px;">
          <input type="Submit" name="submitMyText" >
      </div>
        </form>
      </div>


<h3 style="text-align: center;">Update personal data</h3>
  <div class="flex-box" style="flex-direction: column; margin-top: 0px;">
    <form method="get" action="<?php echo$_SERVER["PHP_SELF"]; ?>">

      <div class="flex-item">
        <label>First name</label>
        <input type="text" name="firstname">
      </div>

      <div class="flex-item">
        <label>Lastname</label>
        <input type="text" name="lastname">
      </div>

      <div class="flex-item">
        <label>Email</label>
        <input type="text" name="email">
      </div>

      <div class="flex-item">
        <input type="Submit" name="submitProfileUpdate">
      </div>

    </form>
  </div>

    <?php

    if(count($userArticles) > 0): ?>
      <h2 style="text-align: center;">My articles</h2>
      <div class="flex-box-articles">
        <?php foreach($userArticles as $value ): ?>
          <div class="flex-item-articles">
            <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
              <button value="<?php echo $value["id"]; ?>" name="articleID" type="submit" style="border:none; border-radius:10px; padding:10px;">
            <h3><?php echo $value["title"] . "<br>"; ?></h3>
              <h5><?php echo $value["header"] . "<br>"; ?></h5>
            <img src="uploads/<?php echo $value['fileName']; ?>" style="height:100px; width:auto;" >
              </button>
            </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if(count($userArticles) == 0) : ?>
          <div class="flex-box-articles">
              <div class="flex-item-articles">
                <h4><?php echo "You have no articles posted"; ?></h4>
              </div>
            <?php endif; ?>
      </div>
      <div style="display:block; text-align:center;">
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="display:inline-block; margin-left:auto; margin-right:auto">
          <input type="submit" value="Log Out" name="logOut">
        </form>
      </div>
      <div style="display:block; text-align:center;">
        <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <input type="submit" value="Delete User" name="deleteUser">
        </form>
    </div>
  </div>


</div>





<?php include "footer.php"; ?>
