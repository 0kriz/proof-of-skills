<?php
include "header.php";
include "ConnectDatabase.php";
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}


$sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);

foreach($arr as $value){
  $totalXp = intval($value["xp"]);
  $level = intval($value["level"]);
  $socialXp = intval($value["socialisation"]);
  $sLevel = intval($value["SLevel"]);
  $strengthXp = intval($value["strength"]);
  $sTLevel = intval($value["STLevel"]);
  $knowledgeXp = intval($value["knowledge"]);
  $kLevel = intval($value["KLevel"]);
}

$totalXp = $sLevel + $sTLevel + $kLevel;
$sql = "UPDATE tamagotchi SET totalXp='{$totalXp}' WHERE username='{$username}'";
mysqli_query($connect, $sql);


# Lvl bar system
$nextLevelXp = $level*50;
$xpPerBar = $nextLevelXp/10;
# how many xp the level start from
$totalXpInPastLvl = ($level - 1)*50;
# define amount of bars covered
if($totalXp >= $totalXpInPastLvl AND $totalXp < $nextLevelXp){
    $barProgress = ($totalXp - $totalXpInPastLvl)/$xpPerBar;
  }

if($totalXp >= $nextLevelXp){
  $level = $level+1;
  $sql = "UPDATE tamagotchi SET level='{$level}' WHERE username='{$username}'";
  mysqli_query($connect, $sql);
  header("Location: Tamagochi.php");
}

# Social LVL BAR SYSTEM
$socialNextLevelXp = $sLevel*50;
$xpPerBarSocial = $socialNextLevelXp/10;
# how many xp the level start from
$totalXpInPastLvlSocial = ($sLevel - 1)*50;
# define amount of bars covered
if($socialXp >= $totalXpInPastLvlSocial AND $socialXp < $socialNextLevelXp){
    $socialBarProgress = ($socialXp - $totalXpInPastLvlSocial)/$xpPerBarSocial;
  }
if($socialXp >= $socialNextLevelXp){
  $sLevel = $sLevel+1;
  $sql = "UPDATE tamagotchi SET SLevel='{$sLevel}' WHERE username='{$username}'";
  mysqli_query($connect, $sql);
  header("Location: Tamagochi.php");
}

# Strength LVL BAR SYSTEM
$strengthNextLevelXp = $sTLevel*50;
$xpPerBarStrength = $strengthNextLevelXp/10;
# how many xp the level start from
 $totalXpInPastLvlStrength = ($sTLevel - 1)*50;
# define amount of bars covered
if($strengthXp >= $totalXpInPastLvlStrength AND $strengthXp < $strengthNextLevelXp){
    $strengthBarProgress = ($strengthXp - $totalXpInPastLvlStrength)/$xpPerBarStrength;
  }
if($strengthXp >= $strengthNextLevelXp){
  $sTLevel = $sTLevel+1;
  $sql = "UPDATE tamagotchi SET STLevel='{$sTLevel}' WHERE username='{$username}'";
  mysqli_query($connect, $sql);
  header("Location: Tamagochi.php");
}

# Knowledge LVL BAR SYSTEM
$knowledgeNextLevelXp = $kLevel*50;
$xpPerBarKnowledge = $knowledgeNextLevelXp/10;
# how many xp the level start from
$totalXpInPastLvlKnowledge = ($kLevel - 1)*50;
# define amount of bars covered
if($knowledgeXp >= $totalXpInPastLvlKnowledge AND $knowledgeXp < $knowledgeNextLevelXp){
    $knowledgeBarProgress = ($knowledgeXp - $totalXpInPastLvlKnowledge)/$xpPerBarKnowledge;
  }
if($knowledgeXp >= $knowledgeNextLevelXp){
  $kLevel = $kLevel+1;
  $sql = "UPDATE tamagotchi SET KLevel='{$kLevel}' WHERE username='{$username}'";
  mysqli_query($connect, $sql);
  header("Location: Tamagochi.php");
}



$totalBars = 10;
$xpBars = 0;
$countSocial = 0;
$countStrength = 0;
$countKnowledge = 0;


if(!empty($_GET["eatDrink"])){
  header("Location: tamagotchi/eatDrink.php");
}

if(!empty($_GET["excersise"])){
  header("Location: tamagotchi/excersise.php");
}

if(!empty($_GET["libary"])){
  header("Location: tamagotchi/libary.php");
}

if(!empty($_GET["socialize"])){
  header("Location: tamagotchi/socialize.php");
}



$sql = "SELECT * FROM tamagotchi WHERE username='{$username}'";
$do = mysqli_query($connect, $sql);
$arr = mysqli_fetch_all($do, MYSQLI_ASSOC);

?>

<div class="flex-box" style="margin-top:10px; flex-direction:column;">
  <div class="flex-item">
    <img src="pageRelatedPictures/snauzer.jpg" style="height:100px; margin:10px;">
  </div>
<h1 style="text-align: center;">Level <?php echo $level; ?></h1>
  <div class="flex-item" style="margin-top:20px; margin-bottom:100px;">
    <div class="lvl-Bar">
      <?php
      for($i = 0; $i < $barProgress; $i++): ?>
        <div class="lvl-Bar-Item" style="background-color:purple;">
        </div>
      <?php
        $xpBars = $xpBars + 1;
      endfor;

      for($i = 0; $i < ($totalBars-$xpBars); $i++): ?>
        <div class="lvl-Bar-Item">
        </div>
      <?php endfor;?>
    </div>
  </div>

  <div class="flex-item" style="border:solid; min-height:300px; margin:10px;">
    <div class="container">
      <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
      <?php foreach($arr as $value): ?>

        <button name="eatDrink" type="submit" value="eatDrink" style="border:none; background:none;">
          <div class="container-item" style="margin-top:20px; margin-bottom:20px; font-size: 21px;">
            <?php echo "<STRONG>Health: <STRONG>" . $value["hunger"]; ?>
          </div>
        </button>

        <button name="eatDrink" type="submit" value="eatDrink" style="border:none; background:none;">
          <div class="container-item" style="margin-top:20px; margin-bottom:20px; font-size: 21px;">
            <?php echo "<STRONG>Thirst: <STRONG>" .$value["thirst"]; ?>
          </div>
        </button>

        <button name="socialize" type="submit" value="socialize" style="border:none; background:none;">
          <div class="container-item" style="margin-top:20px; margin-bottom:20px; font-size: 21px;"><?php
            echo "<STRONG>Socialisation: Level " . $sLevel . "<STRONG>"?>
              <div class="lvl-Bar">
                <?php
                for($i = 0; $i < $socialBarProgress; $i++): ?>
                  <div class="lvl-Bar-Item" style="background-color:purple;">
                  </div>
                <?php
                  $countSocial = $countSocial + 1;
                endfor;

                for($i = 0; $i < ($totalBars-$countSocial); $i++): ?>
                  <div class="lvl-Bar-Item">
                  </div>
                <?php endfor;?>
              </div>
          </div>
        </button>

        <button name="excersise" type="submit" value="excersise" style="border:none; background:none;">
          <div class="container-item" style="margin-top:20px; margin-bottom:20px; font-size: 21px;"><?php
            echo "<STRONG>Strength: Level " . $sTLevel . "<STRONG>" ?>
              <div class="lvl-Bar">
                <?php
                for($i = 0; $i < $strengthBarProgress; $i++): ?>
                  <div class="lvl-Bar-Item" style="background-color:purple;">
                  </div>
                <?php
                  $countStrength = $countStrength + 1;
                endfor;

                for($i = 0; $i < ($totalBars-$countStrength); $i++): ?>
                  <div class="lvl-Bar-Item">
                  </div>
                <?php endfor;?>
              </div>
          </div>
        </button>

        <button name="libary" type="submit" value="libary" style="border:none; background:none;">
          <div class="container-item" style="margin-top:20px; margin-bottom:50px; font-size: 21px;"><?php
            echo "<STRONG>Knowledge: Level " . $kLevel . "<STRONG>" ?>
              <div class="lvl-Bar">
                <?php
                for($i = 0; $i < $knowledgeBarProgress; $i++): ?>
                  <div class="lvl-Bar-Item" style="background-color:purple;">
                  </div>
                <?php
                  $countKnowledge = $countKnowledge + 1;
                endfor;

                for($i = 0; $i < ($totalBars-$countKnowledge); $i++): ?>
                  <div class="lvl-Bar-Item">
                  </div>
                <?php endfor;?>
              </div>
            </div>
          </button>
        <?php endforeach; ?>
      </form>
    </div>
  </div>
</div>




<?php include "footer.php" ?>
