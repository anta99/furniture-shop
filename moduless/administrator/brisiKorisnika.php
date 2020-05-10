<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["brisiU"])){
        header("Content-Type:application/json");
        if(isset($_POST["korisnik"])){
            $korisnik=$_POST["korisnik"];
            $upit="DELETE FROM korisnici WHERE korIme=:korisnik";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":korisnik",$korisnik);
            try{
                $priprema->execute();
                if($priprema->rowCount()==1){
                    http_response_code(204);
                }
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode("Došlo je do greške!");
            }
        }
        else{
            http_response_code(422);
            echo json_encode("Korisnik ne postoji");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>