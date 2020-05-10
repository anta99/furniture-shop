<?php
    session_start();
    require_once "../../config/konekcija.php";
    if(isset($_POST["promenaProfil"])){
        $idKorisnika=$_SESSION["user"]["id"];
        $izmene=[];
        #$mailKorisnik=$_POST["izmenaMail"];
        $adresaRegex="/^[A-Z][a-z0-9]{3,29}(\s[A-z0-9]{1,19})*$/";
        $gradRegex="/^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,14})*$/";
        $telRegex="/^06[0-59][0-9]{6,8}$/";
        $korImeRegex="/^[A-z][A-z0-9\.\?\!]{3,59}$/";
        $upit="UPDATE korisnici SET ";
        if(isset($_POST["izmenaAdresa"])){
            $novaAdresa=$_POST["izmenaAdresa"];
            if(preg_match($adresaRegex,$novaAdresa)){
                $upit.="adresa=:novaAdresa";
                $izmene[]="novaAdresa";
            }
        }
        if(isset($_POST["izmenaGrad"])){
            $noviGrad=$_POST["izmenaGrad"];
            if(preg_match($gradRegex,$noviGrad)){
                $upit.=",grad=:noviGrad";
                $izmene[]="noviGrad";
            }
        }
        if(isset($_POST["izmenaTel"])){
            $noviTel=$_POST["izmenaTel"];
            if(preg_match($telRegex,$noviTel)){
                $upit.=",telefon=:noviTel";
                $izmene[]="noviTel";
            }
        }
        if(isset($_POST["izmenaKorIme"])){
            $novoIme=$_POST["izmenaKorIme"];
            if(preg_match($korImeRegex,$novoIme)){
                $upit.=",korIme=:novoIme";
                $izmene[]="novoIme";
            }
        }
        $upit.=" WHERE id=:id;";
        $priprema=$konekcija->prepare($upit);
        foreach($izmene as $izmena){
            $priprema->bindParam(":$izmena",$$izmena);
        }
        $priprema->bindParam(":id",$idKorisnika);
        // $adresaKorisnika=$_POST["izmenaAdresa"];
        // $izmenaIme=$_POST["izmenaKorIme"];
        try{
            // $izvrsenje=$konekcija->query($upit);
            $priprema->execute();
            $noviUpit="SELECT k.*,u.naziv FROM korisnici k INNER JOIN uloge u ON k.ulogaId=u.id WHERE k.id=$idKorisnika;";
            $izvrsi=$konekcija->query($noviUpit);
            //$izvrsi->execute();
            if($izvrsi->rowCount()==1){
                $korisnik=$izvrsi->fetch();
                $_SESSION["user"]=$korisnik;
            }
            header("Location: ../../profil.php");
        }
        catch(PDOException $e){
            echo "Doslo je do greske";
            $_SESSION["zauzeto"]="Korisnicko ime: $novoIme je vec zauzeto";
            header("Location: ../../profil.php");
        }   
    }
    else{
        echo "Niste kliknuli dugme";
    }
?>