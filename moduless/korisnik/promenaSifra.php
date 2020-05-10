<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["promeniSifru"])){
        if(isset($_POST["trenutnaSifra"])){
            $trentuna=$_POST["trenutnaSifra"];
        }
        if(isset($_POST["novaSifra"])){
            $nova=$_POST["novaSifra"];
        }
        if(isset($_POST["potrvdiLozinku"])){
            $potvrda=$_POST["potrvdiLozinku"];
        }
        if(isset($_POST["korisnik"])){
            $idKorisnika=$_POST["korisnik"];
        }
        $greske=[];
        $korisnikUpit="SELECT * FROM korisnici WHERE id=:id";
        $priprema=$konekcija->prepare($korisnikUpit);
        $priprema->bindParam(":id",$idKorisnika);
        $priprema->execute();
        $korisnikInfo=$priprema->fetch();
        $lozinkaRegex="/^[\w\W\s]{6,}$/";
        if(!preg_match($lozinkaRegex,$trentuna) || $korisnikInfo["sifra"]!=md5($trentuna)){
            $greske["trenutna"]="Uneta lozinka nije ispravna";
        }
        if(!preg_match($lozinkaRegex,$nova)){
            $greske["nova"]="Molimo vas ispravno popunite ovo polje";
        }
        if($nova!=$potvrda){
            $greske["potvrda"]="Molimo vas ispravno popunite ovo polje";
        }
        if(!count($greske)){
            $updateUpit="UPDATE korisnici SET sifra=md5(:novaSifra) WHERE id=:id;";
            $updatePriprema=$konekcija->prepare($updateUpit);
            $updatePriprema->bindParam(":novaSifra",$nova);
            $updatePriprema->bindParam(":id",$idKorisnika);
            $updatePriprema->execute();
            if($updatePriprema->rowCount()==1){
                http_response_code(204);
            }
            else{
                http_response_code(500);
            }
        }
        else{
            header("Content-Type:application/json");
            echo json_encode($greske);
            http_response_code(422);
        }
    }
    else{
        header("Location:../../profil.php");
    }
?>