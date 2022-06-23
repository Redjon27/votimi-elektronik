<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}

?>

<?php

$connect = mysqli_connect('localhost','root','','voting-db');
if(!$connect){
    echo "Error on Database".mysqli_connect_errno($connect);
}

$query = "SELECT * FROM kontakt ORDER BY id DESC";
$query_result = mysqli_query($connect,$query);
if(!$query_result){
    echo "Error".mysqli_error();
}
$array_kontakt = array();

while($row = mysqli_fetch_array($query_result)){
    $array_kontakt[$row['email']]['emri'] = $row['emri'];
    $array_kontakt[$row['email']]['mbiemri'] = $row['mbiemri'];
    $array_kontakt[$row['email']]['email'] = $row['email'];
    $array_kontakt[$row['email']]['telefon'] = $row['telefon'];
    $array_kontakt[$row['email']]['subjekti'] = $row['subjekti'];
   
}

$query = "SELECT * FROM user ORDER BY id DESC";
$query_result = mysqli_query($connect,$query);
if(!$query_result){
    echo "Error".mysqli_error();
}
$array_user = array();

while($row = mysqli_fetch_array($query_result)){
    $array_user[$row['numripersonal']]['emri'] = $row['emri'];
    $array_user[$row['numripersonal']]['mbiemri'] = $row['mbiemri'];  
}

mysqli_close($connect);
?>



<!DOCTYPE html>
<html lang="en">
<head> 
<script>

var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btnnn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
</script>
    
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Platforma Elektronike</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet"/>
  <script src="assets/js/pace.min.js"></script>
  <!--favicon-->
  <link rel="icon" href="../assets/images/al.svg" type="image/x-icon">
  <!-- simplebar CSS-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="assets/css/app-style.css" rel="stylesheet"/>
  
</head>

<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

  <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="home.php">
       <h5 class="logo-text">Dashboard</h5>
     </a>
   </div>

       <ul class="sidebar-menu do-nicescrol">
           <li class="sidebar-header">MENU NAVIGATION</li>
           <li>
               <a href="home.php">
                   <span>Home</span>
               </a>
           </li>
           <li>
               <a href="newzone.php">
                   <span>Zona</span>
               </a>
           </li>
           <li>
               <a href="tables.php">
                   <span>Partit</span>
               </a>
           </li>
           <li>
               <a href="new-kandidat.php">
                   <span>Kandidatet</span>
               </a>
           </li>
           <li>
               <a href="addnew.php">
                   <span>Perdoruesit</span>
               </a>
           </li>
           <li>
               <a href="inbox.php">
                   <span>Inbox</span>
               </a>
           </li>
       </ul>

   </div>
   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
     <label><span class="user-profile"><img src="../assets/images/al.svg" class="img-circle" alt="user avatar">&ensp;Profile</span></label>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
            <div class="media-body">
                <a style="cursor: default" href="home.php"></i><?php echo $_SESSION["emri"]; ?></a>
                <a style="cursor: default" href="home.php"></i><?php echo $_SESSION["mbiemri"]; ?></a>
            </div>
           </div>
          </a>
          </li>
          <li class="dropdown-item" onclick="Logout()"><i class="icon-power mr-2"></i><a href="reset-password.php">Ndrysho Password</a></li>
        <li class="dropdown-item" onclick="Logout()"><i class="icon-power mr-2"></i><a href="../logout.php">Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row mt-3">

        <div class="col-lg-12">
           <div class="card">
            <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                <li class="nav-item">
                    <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link active"><i class="icon-envelope-open"></i> <span class="hidden-xs">Messages</span></a>
                </li>
            </ul>
            <div class="tab-content p-3">

                <div class="tab-pane active" id="messages">
                    
                  <div class="table-responsive">
                   <table class="table">
                <thead>
                 <tr>
                 <th class="form-style-5">Emri</th>
                 <th class="form-style-5">Mbiemri</th>
                 <th class="form-style-5">Email</th>
                 <th class="form-style-5">Telefon</th>
                 <th class="form-style-5" style="width:20px">Mesazhi</th>
                 </tr>
               </thead>
      <?php 
      foreach ($array_kontakt as $value){ ?>
       <tbody>
        <td border="1px" style="border: 1px solid #1abc9c; text-align: center"><?php echo $value['emri']; ?></td>
        <td border="1px" style="border: 1px solid #1abc9c; text-align: center"><?php echo $value['mbiemri']; ?></td>
        <td border="1px" style="border: 1px solid #1abc9c; text-align: center"><?php echo $value['email']; ?></td>
        <td border="1px" style="border: 1px solid #1abc9c; text-align: center"><?php echo $value['telefon']; ?></td>
        <td border="1px" style="border: 1px solid #1abc9c; text-align: center"><?php echo $value['subjekti']; ?></td>
           </tbody>
                   <?php } ?>
                </table>
                  </div>
                </div>
            </div>
        </div>
      </div>
      </div>    
    </div>

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->
	
    </div>
    <!-- End container-fluid-->
   </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          Copyright © 2022 PLATFORMA ELEKTRONIKE
        </div>
      </div>
    </footer>
	<!--End footer-->
  </div><!--End wrapper-->


  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	
  <!-- simplebar js -->
  <script src="assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>
  
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
	
</body>
</html>