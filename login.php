<?php

session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

?>


<?php

require_once "config.php";
 
$numripersonal = $password = "";
$numripersonal_err = $password_err = "";

 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["numripersonal"]))){
        $numripersonal_err = "Vendosni numrin personal.";
    } else{
        $numripersonal = trim($_POST["numripersonal"]);
    }
    if(empty(trim($_POST["passwordi"]))){
        $password_err = "Vendosni password.";
    } else{
        $password = trim($_POST["passwordi"]);
    }
    if(empty($numripersonal_err) && empty($password_err)){

        $sql = "SELECT id, numripersonal, password, isadmin, isvotues, emri, mbiemri,zona FROM user WHERE numripersonal = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_numripersonal);
  
            $param_numripersonal = $numripersonal;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){                    

                    mysqli_stmt_bind_result($stmt, $id, $numripersonal, $hashed_password,$isadmin,$isvotues,$emri,$mbiemri,$zona);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            //session_start();
                            if($isadmin == 1){
                                
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["roli"] = "admin";
                            $_SESSION["numripersonal"] = $numripersonal;
                            $_SESSION["emri"] = $emri;
                            $_SESSION["mbiemri"] = $mbiemri;
                            $_SESSION["zona"] = $zona;
                            header("location: admin-panel");
                                
                            }else if ($isvotues == 1){
                                
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["roli"] = "votues";
                            $_SESSION["numripersonal"] = $numripersonal;
                            $_SESSION["emri"] = $emri;
                            $_SESSION["mbiemri"] = $mbiemri;
                                $_SESSION["zona"] = $zona;
                            header("location: admin-panel/UneVotoj.php");
                            }
                        } else{
                            $password_err = "Password i gabuar.";
                        }
                    }
                } else{
                    $numripersonal_err = "Perdoruesi nuk u gjet.";
                }
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
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
  <title>Votim Elektronik</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet"/>
  <script src="assets/js/pace.min.js"></script>
  <!--favicon-->
  <link rel="icon" href="assets/images/al.svg" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
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

 <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/al.svg" alt="logo icon">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Hyrja Ne Platformë</div>
		    <form id="login" method="post">
			  <div class="form-group">
			  <label>Numeri ID: <span class="fadeIn"><?php echo $numripersonal_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="text" id="exampleInputUsername" name="numripersonal" class="form-control input-shadow" placeholder="Vendosni Numeri Indentifikus ID">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label>Password: <span class="fadeIn"><?php echo $password_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="password" id="pwd" name="passwordi" class="form-control input-shadow" placeholder="Vendosni Kodin">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
			<div class="form-row">
			 <div class="form-group col-6"
			 </div>
			</div>
				<button type="submit" class="btn btn-light btn-block"  onclick="Identifikohu()">Identifikohu</button>
			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <p class="text-warning mb-0">Nuk keni nje adrese aktive? <a href="register.php"> Regjistrohu</a></p>
		  </div>
	     </div>
     <footer>
    <p class="text-center" style="color: white">&copy; 2022 <a href="index.php" style="color: white">Zgjedhjet Online - Kthehu Te Kryefaqja</a></p>
    </footer>
</body>
</html>
