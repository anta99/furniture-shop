<?php
    session_start();
    require_once "../../config/konekcija.php";
    if(isset($_POST["odgovori"])){
        $greske=[];
        if(isset($_POST["korisnik"])){
            $korisnikId=$_POST["korisnik"];
        }
        else{
            $greske[]="Morate se prijaviti da biste glasali";
        }
        if(isset($_POST["odgovor"])){
            $odgovor=$_POST["odgovor"];
        }
        else{
            $greske[]="Morate izabrati odgovor";
        }
        if(!count($greske)){
            $anketaUpit="SELECT id FROM anketa WHERE aktivna=1";
            $anketaId=$konekcija->query($anketaUpit)->fetch();
            $odgovorioUpit="SELECT * FROM korisnik_odgovor ko INNER JOIN anketa a ON ko.idAnketa=a.id WHERE a.id=:id AND ko.idKor=:kor";
            $odgovorio=$konekcija->prepare($odgovorioUpit);
            $odgovorio->bindParam(":id",$anketaId["id"]);
            $odgovorio->bindParam(":kor",$korisnikId);
            $odgovorio->execute();
            if($odgovorio->rowCount()==0){
                $odgUpit="INSERT INTO korisnik_odgovor(idOdg,idKor,idAnketa) VALUES(:odg,:kor,:anketa)";
                $priprema=$konekcija->prepare($odgUpit);
                $priprema->bindParam(":odg",$odgovor);
                $priprema->bindParam(":kor",$korisnikId);
                $priprema->bindParam(":anketa",$anketaId["id"]);
                try{
                    $priprema->execute();
                    $_SESSION["anketa"]=["Hvala vam na učestvovanju u anketi"];
                }
                catch(PDOException $e){
                    $_SESSION["anketa"]=["Došlo je do greške.Molimo vas pokušajte kasnije."];
                }
            }
            else{
                $_SESSION["anketa"]=["Već ste učestvovali u ovoj anketi!"];
            }
        }
        else{
            $_SESSION["anketa"]=$greske;
        }
        header("Location:../../kontakt.php#anketa");
    }
    else{
        header("Location:../../404.php");
    }
?>