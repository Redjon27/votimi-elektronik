<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Ju lutemi vendosni password";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Password duhet te kete te pakten 8 karaktere.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Ju lutemi konfirmoni password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password nuk perputhet.";
        }
    }
    
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE user SET password = ? WHERE numripersonal = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
           
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_numripersonal = $_SESSION["numripersonal"];
            
             mysqli_stmt_bind_param($stmt, "si", $param_password, $param_numripersonal);
            $update = mysqli_stmt_execute($stmt);
            
            // Attempt to execute the prepared statement
            if($update){
                
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: ../login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
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

        .card-title{
            text-align: center;
        }
        
        .card{
            border-radius: 25px;
        }    
    </style>
  
</head>
</br>
</br>
    <body style="background-image: url(assets/images/bg-themes/1.png);">
<div class="col-lg-6" style="margin: auto;">
        <div class="card">
           <div class="card-body">
           <div class="card-title">Ndrysho Password</div>
           <hr>
            </br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

           <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label>New Password:  </b><span class="fadeIn"><?php echo $new_password_err; ?></span></label>
            <input type="password" name="new_password" class="form-control form-control-rounded"  id="input-9" placeholder="Vendos Kodin" value="<?php echo $new_password; ?>">
           </div>
               </br>
           <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password:  </b><span class="fadeIn"><?php echo $confirm_password_err; ?></span></label>
            <input type="password" name="confirm_password" class="form-control form-control-rounded" id="input-10" placeholder="Komfirmo Kodin">
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-light btn-round px-5" value="Ndrysho">Ndrysho</button>
            <button type="submit" class="btn btn-light btn-round px-5" href="index.php">Anulo</button>
          </div>
          </form>
         </div>
         </div>
      </div>
   </body>
</html>