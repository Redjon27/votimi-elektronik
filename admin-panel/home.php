
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}
elseif ($_SESSION["roli"]=="votues")
    header("location: UneVotoj.php");
?>


<?php
 $conn = mysqli_connect('localhost','root','','voting-db');
if(!$conn){
    echo "Error on Database".mysqli_connect_errno($conn);
}

$querykandidatet = "SELECT * from kandidatet";
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
    
        .rraporte{
            text-shadow: 2px 2px 5px blue;
        }
    </style>
    
</head>

<body class="bg-theme bg-theme1">

<!-- Start wrapper-->
 <div id="wrapper">

     <?php if ($_SESSION["roli"]=="admin") { ?>
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

     <?php } ?>

<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon">&ensp;&ensp;&ensp;<label class="rraporte"></label></i>
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

  <!--Start Dashboard Content-->
	<div class="row">
     <div class="col-12 col-lg-8 col-xl-8">
	    <div class="card">
		 <div class="card-header"><h4>Sipas Votave</h4>
		 </div>
		 <div class="card-body">
<!--
		    <ul class="list-inline">
			  <li class="list-inline-item"><i class="fa fa-circle mr-2 text-white"></i>New</li>
			  <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>Old</li>
			</ul>
-->

			<div class="chart-container-1">
			  <canvas id="chart1"></canvas>
			</div>

		 </div>
		</div>
	 </div>

     <div class="col-12 col-lg-4 col-xl-4">
        <div class="card">
           <div class="card-header"><h4>Sipas Zonave</h4>
             <div class="card-action">
             </div>
           </div>
           <div class="card-body">
		     <div class="chart-container-2">
               <canvas id="chart2"></canvas>
			  </div>
           </div>
           <div class="table-responsive">
             <table class="table align-items-center table-flush table-borderless">
                   <thead>
      <tr>
        <th class="form-style-5" style="text-algin: center;"></th>
      </tr>
    </thead>
    <?php
      $nr = 1;
      foreach ($array_kandidatet as $value){ ?>
    <tbody>
        <td><?php echo $nr; ?></td>
        <td><?php echo $value['zona']; ?></td>
      <?php $nr++;} ?>
                 </tbody></table>
           </div>
         </div>
     </div>
	</div><!--End Row-->

	<div class="row">
	 <div class="col-12 col-lg-12">
	   <div class="card">
	     <div class="card-header"><h3>Sipas Partive Politike</h3>
		 </div>
	       <div class="table-responsive">
                 <table class="table align-items-center table-flush table-borderless">
                   <thead>
      <tr>
        <th class="form-style-5">Nr</th>
        <th class="form-style-5">Emri</th>
        <th class="form-style-5">Mbiemri</th>
        <th class="form-style-5">Partia Politike</th>
        <th class="form-style-5" style="text-algin: center;">Zona</th>
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
      <?php $nr++;} ?>
                 </tbody></table>
               </div>
	   </div>
	 </div>
	</div><!--End Row-->

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
