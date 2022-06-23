<?php

session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

?>
<?php
/*
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
*/
require_once "config.php";
$emri = $mbiemri = $password = $datelindja = $numeripersonal = "";
$emri_err = $mbiemri_err = $password_err = $datelindja_err = $numripersonal_err = $zona_err = "";
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
        $sql = "SELECT id FROM user WHERE emri = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_emri = trim($_POST["emri"]);
            mysqli_stmt_bind_param($stmt, "s", $param_emri);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["mbiemri"]))){
        $mbiemri_err = "Vendosni mbiemrin.";
    } else{
        $sql = "SELECT id FROM user WHERE mbiemri = ?";
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
     if(empty(trim($_POST["numripersonal"]))){
        $numripersonal_err = "Vendosni numerin indentifikues.";
    } else{
        $sql = "SELECT id FROM user WHERE numripersonal = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_numripersonal);
            
            $param_numripersonal = trim($_POST["numripersonal"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $numripersonal_err = "Kjo ID eshte e rregjistruar";
                } else{
                    $numripersonal = trim($_POST["numripersonal"]);
                }
            } else{
                echo "Dicka ndodhi gabim. Provoni me vone.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Vendosni password.";
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password duhet te kete me shume se 8 karaktere.";
    } elseif(!preg_match("/[A-Z]/", $_POST["password"])){
        $password_err = "Password duhet të ketë një shkronjë të madhe";
    }
    else{
        $password = trim($_POST["password"]);
    }
  if(empty(trim($_POST["datelindja"]))){
        $datelindja_err = "Vendosni datelindjen.";
    } else{
        $sql = "SELECT id FROM user WHERE datelindja = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_datelindja = trim($_POST["datelindja"]);
            mysqli_stmt_bind_param($stmt, "s", $param_datelindja);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndidhi gabim, provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
         if(empty(trim($_POST["numripersonal"]))){
        $numripersonal_err = "Vendosni numrinpersonal.";
    } else{
        $sql = "SELECT id FROM user WHERE numripersonal = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_numeripersonal = trim($_POST["numripersonal"]);
            mysqli_stmt_bind_param($stmt, "s", $param_numeripersonal);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
            } else{
                echo "Dicka ndidhi gabim, provoni me vone.";
            }
        }
            mysqli_stmt_close($stmt);
        
    }
    if(empty(trim($_POST["zona"]))){
        $zona_err = "Vendosni Zonen.";
    } else{
        $sql = "SELECT id FROM user WHERE zona = ?";
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
    if(empty($emri_err) && empty($mbiemri_err) && empty($numripersonal_err) && empty($numripersonal_err) ){

        $sql = "INSERT INTO user (emri, mbiemri, numripersonal, password, datelindja, zona, isvotues) VALUES (?, ?, ?, ?, ?, ?, 1)";
        if($stmt = mysqli_prepare($conn, $sql)){
            $param_numripersonal = trim($_POST["numripersonal"]);
            $isvotues= false;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssssss", $param_emri, $param_mbiemri, $param_numripersonal, $param_password, $param_datelindja, $param_zona );
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
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

	<div class="card card-authentication1 mx-auto my-4">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/al.svg" alt="logo icon">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Rregjistrimi ne Platformë</div>
		    <form id="login" method="post">
                
			  <div class="form-group">
			  <label>Emri: <span class="fadeIn"><?php echo $emri_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="emri" class="form-control input-shadow" placeholder="Shkruani emrin tuaj ose Email"/>
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label>Mbiemri: <span class="fadeIn"><?php echo $mbiemri_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="text" id="mbiemri" name="mbiemri" class="form-control input-shadow" placeholder="Vendosni Mbiemerin tuaj"/>
			      <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
                  <div class="form-group">
                <label>Numri ID: <span class="fadeIn"><?php echo $numripersonal_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="text"  name="numripersonal" class="form-control input-shadow" placeholder="Vendosni ID Tuaj"/>
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>
                <div class="form-group">
			 <label>Datelindja: <span class="fadeIn"><?php echo $datelindja_err; ?></span></label>
			   <div class="position-relative">
				  <input type="date" name="datelindja" class="form-control input-shadow">
				 
			   </div>
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
			  <label>Password: <span class="fadeIn"><?php echo $password_err; ?></span></label>
			   <div class="position-relative has-icon-right">
				  <input type="password" id="pwd" name="password" class="form-control input-shadow" placeholder="Vendosni Kodin"/>
				  <input hidden name="isvotues" value="1"/>
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
			 <button type="submit" class="btn btn-light btn-block waves-effect waves-light" onclick="Regjistrohu">Regjistrohu</button>
			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <p class="text-warning mb-0">Keni nje adres aktive? <a href="login.php"> Hyni këtu</a></p>
		  </div>
	     </div>
     <footer>
    <p class="text-center" style="color: white">&copy; 2022 <a href="index.php" style="color: white">Zgjedhjet Online - Kthehu Te Kryefaqja</a></p>
    </footer>
</body>
</html>
