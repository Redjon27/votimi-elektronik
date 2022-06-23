<?php 
include '../config.php';
if($_REQUEST["id"]){
    $id_row = $_GET["id"];
    
    $query_delete = "DELETE FROM kandidatet WHERE id=".$id_row;
//    echo $query_delete;
    $query_delete_result = mysqli_query($conn,$query_delete);
    if(!$query_delete_result){
        echo "Error".mysqli_error();
    }else{
        header("Location:new-kandidat.php");
    }
    mysqli_close($conn);
}

?>
