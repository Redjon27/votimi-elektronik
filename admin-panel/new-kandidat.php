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

$query = "SELECT * from kandidatet";
//echo $query;
$query_result = mysqli_query($conn,$query);
if(!$query_result){
    echo "Error".mysqli_error();
}
$array_kandidatet = array();

while($row = mysqli_fetch_array($query_result)){
    $array_kandidatet[$row['id']]['id'] = $row['id'];
    $array_kandidatet[$row['id']]['emri'] = $row['emri'];
    $array_kandidatet[$row['id']]['mbiemri'] = $row['mbiemri'];
    $array_kandidatet[$row['id']]['partia'] = $row['partia'];
    $array_kandidatet[$row['id']]['zona'] = $row['zona'];
}
$emri_err = $mbiemri_err = $partia_err = $zona_err = "";

  
$querypartia = "SELECT * from partia";
//echo $query;
$query_resultpartia = mysqli_query($conn,$querypartia);
$array_partia = array();

while($row = mysqli_fetch_array($query_resultpartia)){
    $array_partia[$row['emri']] = $row['emri'];
}
 
if(!$query_resultpartia){
    echo "Error".mysqli_error();
}


$queryzona = "SELECT * from zona";
//echo $query;
$query_resultzona = mysqli_query($conn,$queryzona);
$array_zona = array();

while($row = mysqli_fetch_array($query_resultzona)){
    $array_zona[$row['emri']] = $row['emri'];
}
 
if(!$query_resultzona){
    echo "Error".mysqli_error();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["emri"]))){
        $emri_err = "Vendosni emrin.";
    } else{
        $sql = "SELECT id FROM kandidatet WHERE emri = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_emri = trim($_POST["emri"]);
            mysqli_stmt_bind_param($stmt, "s", $param_emri);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
//                 if(mysqli_stmt_num_rows($stmt) == 1){
//                    $emri_err = "Ky Kandidat Eshte I Rregjistruar Tashme!";
//                } else{
//                    $emri = trim($_POST["emri"]);
//                }
                
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["mbiemri"]))){
        $mbiemri_err = "Vendosni mbiemrin.";
    } else{
        $sql = "SELECT id FROM kandidatet WHERE mbiemri = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_mbiemri = trim($_POST["mbiemri"]);
            mysqli_stmt_bind_param($stmt, "s", $param_mbiemri);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
    if(empty(trim($_POST["zona"]))){
        $zona_err = "Vendosni Zonen.";
    } else{
        $sql = "SELECT id FROM kandidatet WHERE zona = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_zona = trim($_POST["zona"]);
            mysqli_stmt_bind_param($stmt, "s", $param_zona);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
    if(empty(trim($_POST["partia"]))){
        $partia_err = "Vendosni Partin.";
    } else{
        $sql = "SELECT id FROM kandidatet WHERE partia = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_partia = trim($_POST["partia"]);
            mysqli_stmt_bind_param($stmt, "s", $param_partia);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
    
  
  if(empty($emri_err) && empty($mbiemri_err) && empty($partia_err) && empty($zona_err) ){

        $sql = "INSERT INTO kandidatet (emri, mbiemri, partia, zona) VALUES (?,?,?,?)";
        if($stmt = mysqli_prepare($conn, $sql)){

            mysqli_stmt_bind_param($stmt, "ssss", $param_emri, $param_mbiemri, $param_partia, $param_zona);
            if(mysqli_stmt_execute($stmt)){
                header("location: new-kandidat.php");
            } else{
                echo "Dicka shkoi gabim, provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
    mysqli_close($conn);
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
    
.fadeIn{
    color: red;
    font-weight: bold;
  animation: fadeIn ease 3s;
  -webkit-animation: fadeIn ease 5s;
  -moz-animation: fadeIn ease 5s;
  -o-animation: fadeIn ease 5s;
  -ms-animation: fadeIn ease 5s;
}

</style>
  
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
    <div class="row">
        <div class="col-lg-6" style="margin: auto;">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Shto nje kandidat te ri</div>
           <hr>
            <form method="post">
           <div class="form-group">
            <label>Emri:  </b><span class="fadeIn"><?php echo $emri_err; ?></span></label>
            <input type="text" name="emri" class="form-control" id="input-1" placeholder="Vendos Emerin">
           </div>
           <div class="form-group">
            <label>Mbiemrin:  </b><span class="fadeIn"><?php echo $mbiemri_err; ?></span></label>
            <input type="text" name="mbiemri" class="form-control" id="input-2" placeholder="Vendos Mbiemerin">
           </div>
             
           <div class="form-group">
            <label>Selekto Partine:  </b><span class="fadeIn"><?php echo $partia_err; ?></span></label>
               
             <select class="form-control" name="partia">
                <option value=""></option>
                     <?php foreach($array_partia as $key): ?>                     
                     <option value="<?php echo $key ?>"><?php echo $key ?></option>		   
		          <?php endforeach; ?>
            </select>
           </div>
             
           <div class="form-group">
            <label>Selekto Zonen:  </b><span class="fadeIn"><?php echo $zona_err; ?></span></label>
                 <select class="form-control" name="zona">
                <option value=""></option>
                     <?php foreach($array_zona as $key): ?>                     
                     <option value="<?php echo $key ?>"><?php echo $key ?></option>		   
		          <?php endforeach; ?>
            </select>
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Register</button>
          </div>
          </form>
         </div>
         </div>
      </div>
	 <div class="col-12 col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Listat e Kandidateve</h5>
			  <div class="table-responsive">
               <table class="table">
                   <tbody>
                   <thead>
      <tr>
        <th class="form-style-5">Nr</th>
        <th class="form-style-5">Emri</th>
        <th class="form-style-5">Mbiemri</th>
        <th class="form-style-5">Partia Politike</th>
        <th class="form-style-5">Zona</th>
        <th class="form-style-5">Edit</th>
        <th class="form-style-5">Delete</th>
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
        <td><button style="background: #1abc9c"><a style="text-decoration: none; color: white" href='update-kandidat.php?id=<?php echo $value['id'];?>'>Edit</a></button></td>
        <td><button style="background: #1abc9c"><a style="text-decoration: none; color: white" onclick="checkDelete(<?php echo $value['id'];?>)" >Delete</a></button></td>
    </tbody>
      <?php $nr++;} ?>
                 </tbody>
                </table>
            </div>
            </div>
          </div>
        </div>
    
    </div><!--End Row-->

            <div class="container-fluid">
	  <!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

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
<script>
    
function checkDelete(el){
     if (confirm("Deshironi te Vazhdoni?")) {
        window.location.href = 'user-shuaj.php?id='+el+'';
    }
    return false;
    
}
</script>

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
