<?php
include "ConnectDatabase.php";
SESSION_START();
$username = $_SESSION["userID"];
if (empty($_SESSION["userID"])){
  $_SESSION["userID"] = "dummy";
  header("Location: mainpage.php");
}

/*
$_FILES[""] is how to access "type='file'"
$_FILES[""] is an assosiative array with keys:
  - name
  - tmp_name
  - size
  - error
  - type
*/



if(isset($_POST["submit"])){
    if(!empty($_POST["title"])){
      if(!empty($_POST["header"])){
        if(!empty($_POST["articleText"])){
          $title = mysqli_real_escape_string($connect, htmlentities($_POST["title"]));
          $header = mysqli_real_escape_string($connect, htmlentities($_POST["header"]));
          $articleText = mysqli_real_escape_string($connect, htmlentities($_POST["articleText"]));
          if($_FILES["file"]["name"] != ""){
            $file = $_FILES["file"];
            $fileName = $_FILES["file"]["name"];
            $filetmpName = $_FILES["file"]["tmp_name"];
            $fileSize = $_FILES["file"]["size"];
            $fileError = $_FILES["file"]["error"];
            $fileType = $_FILES["file"]["type"];

            $fileNameAndType = explode(".", $fileName); # explode create an array where $fileName is devided at "."
            $filetype = strtolower(end($fileNameAndType)); # end($fileExt) access the last element

            $allowed = array("jpg", "jpeg", "png");
            if(in_array($filetype, $allowed)){ # check if fileActualExt is in $allowed array
              if($fileError == 0){
                if($fileSize < 2000000){
                  $imgFileName = uniqid("", true). "." . $filetype;
                  $fileDestination = "uploads/" . $imgFileName;
                  move_uploaded_file($filetmpName, $fileDestination);
                } else { $articleMessage = "Your file is to big"; }
              } else {$articleMessage = "There was an error while uploading your file";}
            } else { $articleMessage = "You cannot upload this file type"; }
          } else{ $imgFileName = "../pageRelatedPictures/noImage.png"; }
          $sql = "INSERT INTO articles(title, header, myText, fileName, username)
          VALUES('{$title}', '{$header}', '{$articleText}', '{$imgFileName}', '{$username}')";
          mysqli_query($connect, $sql);
          header("Location: MyProfile.php");
        } else { $articleMessage ="Write article text"; }
      } else{ $articleMessage = "Write a header"; }
    } else { $articleMessage = "Write a title"; }
  }

  if(!empty($articleMessage)){
    echo $articleMessage;
  }
