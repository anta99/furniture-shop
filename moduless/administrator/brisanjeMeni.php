<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["brisanje"])){
        header("Content-Type:application/json");
        if(isset($_POST["id"])){
            $id=$_POST["id"];
            $upit="DELETE FROM navigacija WHERE id=:id";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":id",$id);
            try{
                $priprema->execute();
                if($priprema->rowCount()==1){
                    http_response_code(204);
                }
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }
        else{
            http_response_code(422);
        }
        
    }
?>