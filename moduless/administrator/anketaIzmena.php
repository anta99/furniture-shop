<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["izmena"])){
        $odgRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{1,59}$/";
        $greske=[];
        header("Content-Type:application/json");
        if(isset($_POST["odgovori"])){
            $odgovori=$_POST["odgovori"];
            foreach($odgovori as $odg){
                if(!preg_match($odgRegex,$odg["noviOdg"])){
                    $greske[]="Odgovor nije u dobrom formatu";
                break;
                }
            }
        }
        if(!count($greske)){
            $updateUpit="UPDATE odgovori SET tekst=:noviOdg WHERE id=:id";
            try{
                foreach($odgovori as $odg){
                    $priprema=$konekcija->prepare($updateUpit);
                    $priprema->bindParam(":noviOdg",$odg["noviOdg"]);
                    $priprema->bindParam(":id",$odg["id"]);
                    $priprema->execute();
                }
                http_response_code(204);
            }
            catch(PDOException $e){
                http_response_code(500);
                $greske[]="Došlo je do greške";
                echo json_encode($greske);
            }
        }
        else{
            http_response_code(422);
            echo json_encode($greske);
        }
    }
    else{
        header("Location:../../404.php");
    }
?>