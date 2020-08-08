<?php
include "ConnectDatabase.php";
include "header.php";
?>
<div class="background-login">

<?php

# check if user exsist before it is inserter to database
if(!empty($_GET["submitNewUser"])){
  if(!empty($_GET["newUserName"])){
    if(!empty($_GET["newUserPassword"])){
      if(!empty($_GET["newUserRepeatPassword"])){
        $username = mysqli_real_escape_string($connect, htmlentities($_GET["newUserName"]));
        $password = mysqli_real_escape_string($connect, htmlentities($_GET["newUserPassword"]));
        $sql = "SELECT * FROM userdata WHERE username='$username'";
        $result = mysqli_query($connect, $sql);
        $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if(empty($arr[0]["username"])){
          # insert new user
          $sql = "INSERT INTO userdata( username, password )
          VALUES ( '{$username}', '{$password}' )";
          mysqli_query($connect, $sql);
          #create user tamagotchi
          $sql = "INSERT INTO tamagotchi(hunger, thirst, socialisation, SLevel, strength, STLevel, knowledge, KLevel, username, xp, level)
          VALUES(5,5,1,1,1,1,1,1,'{$username}', 0, 1)";
          mysqli_query($connect,$sql);

          $_SESSION["userID"]= $username;
          header("Location: MyProfile.php");
        } else { $message = "Username is already in use"; }
      } else { $message = "repeat your pasword"; }
    } else { $message = "write a password"; }
  } else { $message = "write a username"; }
}

# user login
if(!empty($_GET["submitLogin"])) {
  if(!empty($_GET["username"])){
    if(!empty($_GET["password"])){
      $username = mysqli_real_escape_string($connect, htmlentities($_GET["username"]));
      $password = mysqli_real_escape_string($connect, htmlentities($_GET["password"]));
      $sql = "SELECT * FROM userdata WHERE username='{$username}'";
      $do = mysqli_query($connect, $sql);
      $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
      if($arr[0]["username"] == $username and $arr[0]["password"] == $password){
        $_SESSION["userID"] = $username;
        header("Location: Myprofile.php");
      } else { $messageLogin = "Username or Password is wrong"; }
    } else { $messageLogin = "Write your password"; }
  } else { $messageLogin = "write your username"; }
}

if(empty($_SESSION["userID"]) OR $_SESSION["userID"] == "dummy"): ?>
  <div class="flex-box">

      <form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">
        <div class="flex-item">
          <h2> Log In </h2>
        </div>
        <div class="flex-item">
          <label>Username</label>
        </div>
        <div class="flex-item">
          <input type="text" name="username">
        </div>
        <div class="flex-item">
          <label>Password</label>
        </div>
        <div class="flex-item">
          <input type="text" name="password">
        </div>
        <div class="flex-item">
          <input type="submit" value="Submit" name="submitLogin">
        </div>
        <?php if(!empty($messageLogin)): ?>
          <div class="flex-item" style="border: solid green; border-radius: 50px; padding: 10px; margin-top: 10px; ">
            <?php echo $messageLogin; ?>
          </div>
        <?php endif; ?>
      </form>
    </div>


  <div class="flex-box">
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
      <div class="flex-item">
        <h2>Make new user</h2>
      </div>
      <div class="flex-item">
        <label>Username</label>
      </div>
      <div class="flex-item">
        <input type="text" name="newUserName">
      </div>
      <div class="flex-item">
        <label>Password</label>
      </div>
      <div class="flex-item">
        <input type="text" name="newUserPassword">
      </div>
      <div class="flex-item">
        <label>Repeat password</label>
      </div>
      <div class="flex-item">
        <input type="text" name="newUserRepeatPassword">
      </div>
      <div class="flex-item">
        <input type="submit" value="Submit" name="submitNewUser">
      </div>
      <?php if(!empty($message)) : ?>
        <div class="flex-item" style="border: solid green; border-radius: 50px; padding: 10px; margin-top: 10px; ">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>
    </form>

  </div>
  <?php endif; ?>

<?php include "footer.php" ?>
</div>
