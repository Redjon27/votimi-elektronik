<?php 
include '../config.php';

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


if($_REQUEST["id"]){
    $id_row = $_GET["id"];
    
    $query_select = "SELECT * FROM kandidatet WHERE id=".$id_row;
    $query_select_result = mysqli_query($conn,$query_select);
    if(!$query_select_result){
        echo "Error",mysqli_error();
    }
    $row = mysqli_fetch_array($query_select_result);
    mysqli_close($conn);
}

if(isset($_POST["new-kandidat"])){
    include '../config.php';

    $emri = mysqli_real_escape_string($conn,$_POST["emri"]);
    $mbiemri = mysqli_real_escape_string($conn,$_POST["mbiemri"]);
    $partia = mysqli_real_escape_string($conn,$_POST["partia"]);
    $zona = mysqli_real_escape_string($conn,$_POST["zona"]);

    $query_update = "UPDATE kandidatet SET emri='".$emri."',mbiemri='".$mbiemri."',partia='".$partia."',zona='".$zona."' WHERE id=".$id_row;
    $query_update_result = mysqli_query($conn,$query_update);
    if(!$query_update_result){
        echo "Error".mysqli_error();
    }else{
        header("Location:new-kandidat.php");
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
  <!-- Custom Style-->
  <link href="assets/css/app-style.css" rel="stylesheet"/>
    
    <style>
    
        .card{
            border-radius: 30px;
            
        }
        
        .card-title{
            
            text-align: center;
        }
    
    </style>
    
</head>
</br>
</br>
<body style="background-image: url(assets/images/bg-themes/1.png);">
<div class="col-lg-6" style="margin: auto;">
         <div class="card">
           <div class="card-body">
           <div class="card-title">Shto nje kandidat te ri</div>
           <hr>
            <form method="post">
           <div class="form-group">
            <label>Emri:</label>
            <input type="text" name="emri" class="form-control" id="input-1" value="<?php echo $row['emri']; ?>">
           </div>
           <div class="form-group">
            <label>Mbiemrin:</label>
            <input type="text" name="mbiemri" class="form-control" id="input-2" value="<?php echo $row['mbiemri']; ?>">
           </div>
             
           <div class="form-group">
            <label>Selekto Partine:</label>
               
             <select class="form-control" name="partia" value="<?php echo $row['partia']; ?>">
                <option value=""></option>
                     <?php foreach($array_partia as $key): ?>                     
                     <option value="<?php echo $key ?>"><?php echo $key ?></option>		   
		          <?php endforeach; ?>
            </select>
           </div>
             
           <div class="form-group">
            <label>Selekto Zonen:</label>
                 <select class="form-control" name="zona" value="<?php echo $row['zona']; ?>">
                <option value=""></option>
                     <?php foreach($array_zona as $key): ?>                     
                     <option value="<?php echo $key ?>"><?php echo $key ?></option>		   
		          <?php endforeach; ?>
            </select>
           </div>
           <div class="form-group">
            <button type="submit" class="btn btn-light px-5" name="new-kandidat" value="Update">Update</button>
          </div>
          </form>
         </div>
         </div>
      </div>
</body>
</html>

