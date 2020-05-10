<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["brisi"])){
        $greska=false;
        header("Content-Type:application/json");
        if(isset($_POST["id"])){
            $anketaId=$_POST["id"];
        }
        else{
            $greska=true;
        }
        if(!$greska){
            $brisiUpit="DELETE FROM anketa WHERE id=:id";
            $priprema=$konekcija->prepare($brisiUpit);
            $priprema->bindParam(":id",$anketaId);
            try{
                $priprema->execute();
                http_response_code(204);
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode("Došlo je do greške");
            }
        }
        else{
            http_response_code(422);
            echo json_encode("Anketa nije izabrana");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>