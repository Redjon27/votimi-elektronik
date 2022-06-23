<?php 
include '../config.php';

if($_REQUEST["id"]){
    $id_row = $_GET["id"];
    
    $query_select = "SELECT * FROM user WHERE id=".$id_row;
    $query_select_result = mysqli_query($conn,$query_select);
    if(!$query_select_result){
        echo "Error",mysqli_error();
    }
    $row = mysqli_fetch_array($query_select_result);
    mysqli_close($conn);
}

if(isset($_POST["addnew"])){
    include '../config.php';

    $emri = mysqli_real_escape_string($conn,$_POST["emri"]);
    $mbiemri = mysqli_real_escape_string($conn,$_POST["mbiemri"]);
    $datelindja = mysqli_real_escape_string($conn,$_POST["datelindja"]);
    $numripersonal = mysqli_real_escape_string($conn,$_POST["numripersonal"]);

    $query_update = "UPDATE user SET emri='".$emri."',mbiemri='".$mbiemri."',datelindja='".$datelindja."' ,numripersonal='".$numripersonal."' WHERE id=".$id_row;
    $query_update_result = mysqli_query($conn,$query_update);
    if(!$query_update_result){
        echo "Error".mysqli_error();
    }else{
        header("Location:addnew.php");
    }
    mysqli_close($conn);
    
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>    
<link rel="stylesheet" href="updatezona.css">
</head>
    </br>
    </br>
    </br>
    </br>
<body style="background-image: url(assets/images/bg-themes/1.png);">
<div class="upload_movies_form">
    <div class="form-style-5">
            <h2 style="text-align: center"><b>Modifiko Perdorues</b></h2>

            <form method="POST">
                <fieldset>
            <legend><span class="number">Emri: </span></legend>
                    <input type="text" class="input-field" name="emri" value="<?php echo $row['emri']; ?>">
                    </fieldset>
                
                <fieldset>
            <legend><span class="number">Mbiemri: </span></legend>
                    <input type="text" class="input-field" name="mbiemri" value="<?php echo $row['mbiemri']; ?>">
                    </fieldset>
                
                <fieldset>
            <legend><span class="number">Datelindja: </span></legend>
                    <input type="date" class="input-field" name="datelindja" value="<?php echo $row['datelindja']; ?>">
                    </fieldset>
                
                <fieldset>
            <legend><span class="number">Numeri ID: </span></legend>
                    <input type="text" class="input-field" name="numripersonal" value="<?php echo $row['numripersonal']; ?>">
                    </fieldset>
                
            <input type="submit" class="button-box" name="addnew" value="Update">
                
            </form>
        </div>
    </div>
</body>
</html> 