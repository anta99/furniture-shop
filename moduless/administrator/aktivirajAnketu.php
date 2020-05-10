<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["aktiv"])){
        $greska=false;
        header("Content-Type:application/json");
        if(isset($_POST["id"])){
            $anketaId=$_POST["id"];
        }
        else{
            $greska=true;
        }
        if(!$greska){
            $aktivUpit="UPDATE anketa SET aktivna=1 WHERE id=:id";
            $deaktivUpit="UPDATE anketa SET aktivna=0 WHERE aktivna=1";
            $priprema=$konekcija->prepare($aktivUpit);
            
            $priprema->bindParam(":id",$anketaId,PDO::PARAM_INT);
            try{
                $konekcija->query($deaktivUpit);
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