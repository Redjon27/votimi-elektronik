<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}
elseif ($_SESSION["roli"]!="votues")
    header("location: home.php");
?>



<?php

$conn = mysqli_connect('localhost','root','','voting-db');
if(!$conn){
    echo "Error on Database".mysqli_connect_errno($conn);
}
//$querykandidatet = "SELECT * from kandidatet ";
$querykandidatet = "SELECT * from kandidatet where zona ='".$_SESSION["zona"]."'";

//var_dump($querykandidatet);die;
//echo $query;
$query_resultkandidatet = mysqli_query($conn,$querykandidatet);
$array_kandidatet = array();

while($row = mysqli_fetch_array($query_resultkandidatet)){
    $array_kandidatet[$row['id']]['id'] = $row['id'];
    $array_kandidatet[$row['id']]['emri'] = $row['emri'];
    $array_kandidatet[$row['id']]['mbiemri'] = $row['mbiemri'];
    $array_kandidatet[$row['id']]['partia'] = $row['partia'];
    $array_kandidatet[$row['id']]['zona'] = $row['zona'];
    
}

if($_REQUEST){
    $id_kandidat = $_GET["id"];
    $id_user=$_SESSION["id"];
    $sql = "INSERT INTO votat (userid, kandidatiid) VALUES (?,?)";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $id_user, $id_kandidat);
        if(mysqli_stmt_execute($stmt)){
            header("location: UneVotoj.php");
        } else{
            echo "Dicka shkoi gabim, provoni me vone.";
        }
    }

    mysqli_stmt_close($stmt);
}

$query_select = "SELECT * FROM votat WHERE userid=".$_SESSION["id"];
$query_select_result = mysqli_query($conn,$query_select);
if(!$query_select_result){
    echo "Error",mysqli_error();
}
$result = mysqli_fetch_array($query_select_result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
  <!-- Vector CSS -->
  <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
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
  
    <style>
    
        .card-header{
            
            text-align: center;
            text-shadow: 2px 2px 5px blue;
        }
    
    </style>
    
    
</head>

<body class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper" class="toggled">
 

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">

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
        <form method="post">
	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
           <?php if ($result !=null) { ?>
               <div class="mydiv"><h2 style="text-align: center">Votimi u krye me sukses!</h2></div>
           <?php } else { ?>

               <div class="card-header"><h3>Partit Kandidate</h3></div>
               <div class="table-responsive">
                   <table class="table align-items-center table-flush table-borderless">
                       <thead>
                       <tr>
                           <th class="form-style-5">Nr</th>
                           <th class="form-style-5">Emri</th>
                           <th class="form-style-5">Mbiemri</th>
                           <th class="form-style-5">Partia Politike</th>
                           <th class="form-style-5" style="text-algin: center;">Zona</th>
                           <th class="form-style-5;" style="text-algin: center;">Votoj</th>
                       </tr>
                       </thead>
                       <?php
                       $nr = 1;
                       foreach ($array_kandidatet as $value){ ?>
                       <tbody>
                       <td><?php echo $nr; ?></td>
                       <td><?php echo $value['emri']; ?></td>
                       <td><?php echo $value['mbiemri']; ?></td>
                       <td><?php echo $value['partia']; ?></td>
                       <td><?php echo $value['zona']; ?></td>

                       <td><button type="submit" class="btn btn-light px-5" value="Votoj" style="border-radius: 15px; margin-left: -47px;"><a href='UneVotoj.php?id=<?php echo $value['id'];?>'>Votoj</a></button></td>

                       <?php $nr++;} ?>
                       </tbody></table>
               </div>
           <?php } ?>
	   </div>
	 </div>
	</div>
    </form>    
    <!--End Row-->

      <!--End Dashboard Content-->
	  
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
  <!-- loader scripts -->
  <script src="assets/js/jquery.loading-indicator.js"></script>
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
  <!-- Chart js -->
  
  <script src="assets/plugins/Chart.js/Chart.min.js"></script>
 
  <!-- Index js -->
  <script src="assets/js/index.js"></script>

  
</body>
</html>
