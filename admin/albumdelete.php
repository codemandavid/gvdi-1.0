<?php 
session_start();
include('connfile.php');

if  (htmlspecialchars(isset($_GET['rn']))){
  $id = $_GET['rn'];

  $checkarticle =  mysqli_query($conn, "SELECT * FROM album_table WHERE id= '".$id."' ");
  $imagerow = mysqli_fetch_array($checkarticle);
  $image = $imagerow['album_img'];
  $target_dir ="album/";
  $target_file =$target_dir.$image;
  $remove= unlink($target_file);
  if ( $remove) {
   $deletearticle = mysqli_query($conn, "DELETE  FROM  album_table WHERE id = '".$id."' " );  
   
  
if ($deletearticle) {
  $_SESSION['update'] = "<p class='alert alert-success'> Album was successfully deleted</p>";
  header("Location: sermonview.php");
  exit();

  } else {
  $_SESSION['updatefail'] = "<p class='alert alert-warning'> Input was not deleted</p>";
  header("Location: sermonview.php");
  exit();
  }



  }else{

$_SESSION['updatefail'] = "<p class='alert alert-warning'> Image was not Removed</p>";
header("Location: sermonview.php");
exit();

  }
  
  }

  ?>


 