<?php
session_start();
include('connfile.php');
if (isset($_SESSION['id'])) {
  # code...
}else{
  header('Location:login.php');
}

$error1="";

if (array_key_exists("submit1",$_POST)) {
  if (!$_POST['title1']) {
    $error1.="An Album Title is required <br>";
    
}
if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['title1'])) {
      $error1 = "Only Leters Please !! No Urls";
    }
   
if (!$_POST['year']) {
    $error1.="Please include the Year <br>";
    
}
if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST['year'])) {
      $error1 = "Only the Year Alone !! No Urls";
    }
    if (!$_FILES['image1']['name']) {
    $error1.=" Album Image required<br>";
    
}

 
if ($error1 !="") {
    $error1 = "Incomplete Input<br>".$error1;
}else{


 $target_dir = "album/";
 $target_file = $target_dir . basename($_FILES["image1"]["name"]); 
 $uploadOk=1;
 $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
   /* $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;   
    } else {
        $error= "File is not an image.";
          $uploadOk = 0;
    }*/
    //check file size
     if ($_FILES["image1"]["size"] > 5000000) {
    $error1="Sorry, your file is too large.File should not be more than 5mb.";
      $uploadOk = 0;
  
 }
 // Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
 && $imageFileType != "gif" && $imageFileType != "JPG" &&  $imageFileType != "JPEG" &&  $imageFileType != "PNG") {
     $error1="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
     $uploadOk = 0;

  }

  if ($uploadOk == 0) {
    $error1="Sorry, your file was not uploaded.".$error;
 // if everything is ok, try to upload file
 }  else {
    if (move_uploaded_file($_FILES["image1"]["tmp_name"], $target_file)) {
        $image1=basename( $_FILES["image1"]["name"]);


        $title1= mysqli_real_escape_string($conn,$_POST['title1']);
   
        $year=mysqli_real_escape_string($conn, $_POST['year']);


       
  $sql = "INSERT INTO album_table (album_name,album_img,year) VALUES ('$title1','$image1','$year') ";
    
    if (mysqli_query($conn, $sql)) {
    $success1= "<p class='alert alert-success alert-dismissable'>You have successfully created Your Album</p>";
} else {
    $error1="There was a Problem uploading Your FIle<br>".mysqli_error($conn);
}     
} else {
        $error1= "Sorry, there was an error uploading your file.".mysqli_error($conn);
    }
 }
 
}
}




 ?>


<!DOCTYPE html>
<html lang="zxx">


<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Required meta tags -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>LTEN Admin</title>
  <!--form links -->
 <!--  -->
  <!-- endinject -->
  <!-- plugin css for this page -->
  
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-dark/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <!-- plugins:css -->
   <link rel="stylesheet" href="vendors/iconfonts/ti-icons/css/themify-icons.css">
   <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
   <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
   <!-- endinject -->
   <!-- plugin css for this page -->
   <link rel="stylesheet" href="vendors/summernote/dist/summernote-bs4.css">
   <!-- End plugin css for this page -->
   <!-- inject:css -->
   <link rel="stylesheet" href="css/vertical-layout-dark/style.css">
   <!-- endinject -->
  <link rel="shortcut icon" href="images/ltenlogo.png" />

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
      <?php include 'nav.php';?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                
                
              </ul>
            </div>
           
           
           
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See All</small>
            </div>
            <ul class="chat-list">
     
           
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <?php include 'sidebar.php';?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row grid-margin">


 <div class="col-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                   <?php if ($error1 !=""){
    echo "<p class='alert alert-danger alert-dismissable'>$error1</p>";
    }

if (isset($success1)) {
  echo $success1;

}
    ?>
                  <h4 class="card-title">CREATE NEW ALBUM</h4>
                  <p class="card-description">
                  </p>
                  <form class="forms-sample" method="post" enctype="multipart/form-data"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                      <b>PLEASE NOTE THAT ALL IMAGES MUST BE LANDSCAPE AND MUST NOT EXCEED 600*300</b><br><br>
                      <label for="exampleInputName1">Album Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Album Title" name="title1">
                    </div>
                    
                    
                  <div class="form-group">
                      <label>Album Picture</label><br>
                      <input type="file" name="image1"  class="file-upload-browse btn btn-primary">
                      
                    </div>
                      <div class="form-group">
                    
                      <label for="exampleInputName1">Year Preached</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Sermon Year" name="year">
                    </div>
                   <div class="form-group">
                     
                           <div class="row grid-margin">  
                              <div class="col-lg-12">
             
            </div>
               </div>
                 <button type="submit"  name="submit1" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>


          
          
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
      
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="vendors/tinymce/tinymce.min.js"></script>
  <script src="vendors/tinymce/themes/modern/theme.js"></script>
  <script src="vendors/summernote/dist/summernote-bs4.min.js"></script>
  <!-- plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.html"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/editorDemo.js"></script>
  <!-- End custom js for this page-->
</body>


</html>
