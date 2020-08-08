<?php include "header.php";

if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}

if(!empty($_SESSION["person2"])){
  $person2 = $_SESSION["person2"];
}

# Make dummy user
if(!empty($_GET["dummyUser"])){
  $person2 = $_GET["dummyUser"];
  $_SESSION["person2"] = $_GET["dummyUser"];
  $sql = "INSERT INTO userdata(username, myText) VALUES('{$person2}', 'dummy')";
  mysqli_query($connect, $sql);
  header("Location: chat.php");
  }

# get all users
$allUsers = [];
$sql = "SELECT * FROM userdata";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);
foreach($arr as $value){
  array_push($allUsers, $value);
}

#notification
$unseenMessages = [];
$sql = "SELECT * FROM chat WHERE person2='{$username}'";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);

foreach($arr as $value){
  if(intval($value["messageSeen"]) == 0){
    if($value["person1"] != $username){
      $unseenMessages[] = $value["person1"];
    }
    if($value["person2"] != $username){
      $unseenMessages[] = $value["person2"];
    }
  }
}


# switch person to chat to
if(!empty($_GET["switchperson2"])){
  $person2 = $_GET["switchperson2"];
  $_SESSION["person2"] = $_GET["switchperson2"];
  if(in_array($_GET["switchperson2"], $unseenMessages)){
    $sql = "UPDATE chat SET messageSeen=1 WHERE person1='{$person2}' AND person2='{$username}' OR person1='{$username}' AND person2='{$person2}'";
    mysqli_query($connect, $sql);
    unset($unseenMessages[$person2]);
  }
}


# send messages as user
if(!empty($_GET["submitMessage"])){
  $textMessage = mysqli_real_escape_string($connect, htmlentities($_GET["textMessage"]));
  $sql = "INSERT INTO chat(person1, person2, message, messageSeen) VALUES('{$username}', '{$person2}', '{$textMessage}', 0)";
  mysqli_query($connect, $sql);
  header("Location: Chat.php");
  }


#send messages as dummy
if(!empty($_GET["submitMessagedummy"])){
  $textMessage = mysqli_real_escape_string($connect, htmlentities($_GET["textMessage"]));
  $sql = "INSERT INTO chat(person1, person2, message, messageSeen) VALUES('{$person2}', '{$username}', '{$textMessage}', 0)";
  mysqli_query($connect, $sql);
  header("Location: Chat.php");
  }





?>


  <div class="flex-box" style="min-height: 200px; margin-top: 40px;">
    <div class="flex-item" style="margin-left:15px; margin-right:15px;" >
      <h4>You</h4>
        <img src="pageRelatedPictures/unknownBlue.png" style="height: 80px; margin:20px; border-radius:20px;">
    </div>

    <div class="flex-item" style="margin-left:15px; margin-right:15px;">
      <?php if(!empty($person2)): ?>
      <h4>Talking with: <br> <?php echo substr($person2, -5); ?></h4>
      <img src="pageRelatedPictures/unknownGreen.png" style="height: 80px; border-radius:30px; border: solid #55DB4B 5px; border-radius:20px;"></button>
    <?php endif; ?>
    </div>

    <div clasS="flex-item" style="margin-left:15px; margin-right:15px;">
      <h4>Make new User</h4>
      <form method="GET" action="<?php $_SERVER["PHP_SELF"]; ?>">
        <button type="submit" name="dummyUser" value="<?php echo uniqId('', true); ?>" style="border-radius:30px; border:none; background:none;">
          <img src="pageRelatedPictures/unknownAdd.png" style="height: 80px; margin:20px; border-radius:20px; "></button>
        </form>
    </div>
  </div>


  <h3 style="text-align:center; margin-bottom: 5px;">Users to Chat with</h3>
<div class="container" style="width: 500; border-radius: 15px; margin-left:auto; margin-right:auto; margin-bottom: 40px; background: cornflowerBlue; padding:3px;">
  <div class="flex-box" style="min-height: 100px; width:100%; margin-bottom:0px; background:white; flex-wrap:wrap;">
      <?php foreach($allUsers as $value):
        if($value["username"] != $username): ?>
        <div class="flex-item" style="margin:10px;">
          <?php if(in_array($value["username"], $unseenMessages)): ?>
            <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
              <button type="submit" name="switchperson2" value="<?php echo $value["username"]; ?>" style="border:none; background:none">
                <img src="pageRelatedPictures/notifakasjonimg.png" style="height: 60px; border:3px solid #E7E7E7; border-radius:10px;"><br>
                <div style="font-size: 12px;"><?php echo substr($value["username"], -5); ?></div>
              </button>
            </form>
          <?php endif;
          if(!in_array($value["username"], $unseenMessages)): ?>
          <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <button type="submit" name="switchperson2" value="<?php echo $value["username"]; ?>" style="border:none; background:none">
              <img src="pageRelatedPictures/unknownGreen.png" style="height: 60px; border:3px solid #E7E7E7; border-radius:10px;"><br>
              <div style="font-size: 12px;"><?php echo substr($value["username"], -5); ?></div>
            </button>
          </form>
        <?php endif; ?>
        </div>
      <?php endif; endforeach; ?>
    </div>
</div>

<div class="container" style="width: 500; border-radius: 15px; margin-left:auto; margin-right:auto; background: cornflowerBlue; padding:3px;">
  <div class="flex-box" style="min-height: 100px; width:100%; margin-bottom:0px; padding-top:10px; padding-bottom:10px; background:white; flex-wrap:wrap; flex-direction: column;">
  <?php
  if(!empty($person2)):
    $sql = "SELECT * FROM chat WHERE person1='{$username}' AND person2='{$person2}' OR person1='{$person2}' AND person2='{$username}'";
    $do = mysqli_query($connect, $sql);
    $arr = mysqli_fetch_all($do, MYSQLI_ASSOC);

    foreach($arr as $value): ?>
        <?php
          if($value["person1"] == $username): ?>
            <div class="flex-item" style="border:solid 2px green; border-radius:30px; width: 250px; margin-left: 230px; margin-bottom:15px; padding:3px;">
              <?php echo "<strong>". $value["person1"] . ": </strong>". $value["message"]; ?>
            </div>
          <?php endif;

          if($value["person1"] == $person2): ?>
          <div class="flex-item" style="border:solid 2px blue; border-radius:30px; width: 250px; margin-left: 15px; margin-bottom:15px;padding: 3px;">
            <?php echo "<strong>". substr($value["person1"], -5). ": </strong>". $value["message"]; ?>
          </div>
        <?php endif; endforeach; endif; ?>
  </div>
</div>


<div class="flex-box" style="margin-top: 40px;">
  <?php if(!empty($person2)): ?>

  <div class="flex-item" style="margin:5px;">
    Send message as You
    <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <textarea name="textMessage" cols="30" rows="3"></textarea><br>
      <input type="submit" name="submitMessage">
    </form>
  </div>

  <?php if(strlen($person2) == 23): ?>
  <div class="flex-item" style="margin:5px;">
    Send Message as user: <?php echo substr($person2, -5); ?>
    <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <textarea name="textMessage" cols="30" rows="3"></textarea><br>
      <input type="submit" name="submitMessagedummy">
    </form>
  </div>
  <?php endif; endif;?>
</div>



<?php include "footer.php" ?>
