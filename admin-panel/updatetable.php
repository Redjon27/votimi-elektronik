<?php 
include '../config.php';

if($_REQUEST["id"]){
    $id_row = $_GET["id"];
    
    $query_select = "SELECT * FROM partia WHERE id=".$id_row;
    $query_select_result = mysqli_query($conn,$query_select);
    if(!$query_select_result){
        echo "Error",mysqli_error();
    }
    $row = mysqli_fetch_array($query_select_result);
    mysqli_close($conn);
}

if(isset($_POST["tables"])){
    include '../config.php';

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    
    $query_update = "UPDATE partia SET emri='".$name."' WHERE id=".$id_row;
    $query_update_result = mysqli_query($conn,$query_update);
    if(!$query_update_result){
        echo "Error".mysqli_error();
    }else{
        header("Location:tables.php");
    }
    mysqli_close($conn);
    
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>    
<link rel="stylesheet" href="updatetable.css">
</head>
    </br>
    </br>
    </br>
    </br>
<body style="background-image: url(assets/images/bg-themes/1.png);">
<div class="form">
    <div class="form-style-5">
            <h2 style="text-align: center"><b>Modifiko Partin Politike !</b></h2>

            <form method="POST">
                <fieldset>
            <label><span class="number">Emri: </span></label>
                    <input type="text" class="input-field" name="name" value="<?php echo $row['emri']; ?>">
                    </fieldset>
            <input type="submit" class="button-box" name="tables" value="Update">
                
            </form>
        </div>
    </div>
</body>
</html>