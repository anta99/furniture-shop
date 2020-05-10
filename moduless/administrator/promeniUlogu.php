<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["izmenaU"])){
        $greska=false;
        header("Content-Type:application/json");
        if(isset($_POST["korisnik"])){
            $korisnik=$_POST["korisnik"];
        }
        else{
            $greska=true;
        }
        if(isset($_POST["uloga"])){
            $uloga=$_POST["uloga"];
        }
        else{
            $greska=true;
        }
        if(!$greska){
            $upit="UPDATE korisnici SET ulogaId=:uloga WHERE korIme=:korisnik";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":uloga",$uloga);
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
            echo json_encode("Prosleđene vrednosti nisu dobre");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>