<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["dodaj"])){
        $greske=[];
        $pitanjeRegex="/^[A-Z][A-z0-9\s\,\.\?\!]{1,79}$/";
        $odgRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/";
        header("Content-Type:application/json");
        if(isset($_POST["pitanje"])){
            $pitanje=$_POST["pitanje"];
            if(!preg_match($pitanjeRegex,$pitanje)){
                $greske[]="Pitanje nije u dobrom formatu";
            }
        }
        if(isset($_POST["odgovori"])){
            $odgovori=$_POST["odgovori"];
            foreach($odgovori as $odg){
                if(!preg_match($odgRegex,$odg)){
                    $greske[]="Odgvori nisu u dobrom formatu";
                break;
                }
            }
        }
        if(!count($greske)){
            $anketaUpit="INSERT INTO anketa(pitanje,aktivna) VALUES(:pitanje,0)";
            $pripremaAnketa=$konekcija->prepare($anketaUpit);
            $pripremaAnketa->bindParam(":pitanje",$pitanje);
            try{
                $pripremaAnketa->execute();
                $anketaId=$konekcija->lastInsertId();
                foreach($odgovori as $odg){
                    $odgUpit="INSERT INTO odgovori(tekst,anketaId) VALUES(:tekst,:anketaId)";
                    $pripremaOdg=$konekcija->prepare($odgUpit);
                    $pripremaOdg->bindParam(":tekst",$odg);
                    $pripremaOdg->bindParam(":anketaId",$anketaId);
                    $pripremaOdg->execute();
                }
                http_response_code(201);
                echo json_encode("Anketa uspešno dodata");
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode(["Došlo je do greške"]);
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