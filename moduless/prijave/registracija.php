<?php
    session_start();
    require_once "../../config/konekcija.php";
    if(isset($_POST["regBtn"])){
        $ime=$_POST["ime"];
        $prezime=$_POST["prezime"];
        $adresa=$_POST["adresa"];
        $grad=$_POST["grad"];
        $tel=$_POST["tel"];
        $korIme=$_POST["korIme"];
        $mail=$_POST["regMail"];
        $lozinka=$_POST["regPass"];
        $imeRegex="/^[A-Z][a-z]{2,9}(\s[A-Z][a-z]{2,9})*$/";
        $prezimeRegex="/^[A-Z][a-z]{4,19}(\s[A-Z][a-z]{2,19})*$/";
        $adresaRegex="/^[A-Z][a-z0-9]{3,29}(\s[A-z0-9]{1,19})*$/";
        $gradRegex="/^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,14})*$/";
        $telRegex="/^06[0-59][0-9]{6,8}$/";
        $korImeRegex="/^[A-z][A-z0-9\.\?\!]{3,59}$/";
        $mailRegex="/^[a-z0-9\.\?]{4,}\@([a-z0-9]{3,}\.)*[a-z]{2,3}$/";
        $lozinkaRegex="/^[\w\W\s]{6,}$/";
        if(preg_match($imeRegex,$ime) && preg_match($prezimeRegex,$prezime) && preg_match($adresaRegex,$adresa) && preg_match($gradRegex,$grad) && preg_match($korImeRegex,$korIme) && preg_match($mailRegex,$mail) && preg_match($lozinkaRegex,$lozinka) && preg_match($telRegex,$tel)){
            $mailUpit="SELECT email FROM korisnici WHERE email=:email";
            $korImeUpit="SELECT korIme FROM korisnici WHERE korIme=:korIme";
            $mailPriprema=$konekcija->prepare($mailUpit);
            $korImePriprema=$konekcija->prepare($korImeUpit);
            $mailPriprema->bindParam(":email",$mail);
            $korImePriprema->bindParam(":korIme",$korIme);
            $mailPriprema->execute();
            $korImePriprema->execute();
            if($mailPriprema->rowCount()!=0){
                $greska="Korisnik sa takvim mail-om vec postoji";
                header("Content-Type:application/json");
                echo json_encode("Korisnik sa takvim mail-om vec postoji");
                http_response_code(400);
                exit;
            }
            if($korImePriprema->rowCount()!=0){
                header("Content-Type:application/json");
                echo json_encode("Korisnik sa takvim imenom vec postoji");
                http_response_code(400);
                exit;
            }
            $insertUpit="INSERT INTO korisnici(ime,prezime,adresa,telefon,grad,korIme,email,sifra) VALUES(:ime,:prezime,:adresa,:tel,:grad,:korIme,:email,:lozinka);";
            $insertPriprema=$konekcija->prepare($insertUpit);
            //Bind-ovanje parametara
            $insertPriprema->bindParam(":ime",$ime);
            $insertPriprema->bindParam(":prezime",$prezime);
            $insertPriprema->bindParam(":adresa",$adresa);
            $insertPriprema->bindParam(":grad",$grad);
            $insertPriprema->bindParam(":korIme",$korIme);
            $insertPriprema->bindParam(":email",$mail);
            $insertPriprema->bindParam(":tel",$tel);
            $mdPass=md5($lozinka);
            $insertPriprema->bindParam(":lozinka",$mdPass);
            $izvrsiUnos=$insertPriprema->execute();
            if($izvrsiUnos){
                header("Content-Type:application/json");
                http_response_code(201);
                echo json_encode("Uspešno ste se registrovali.Prijavite se kako bi pristupili svom nalogu");
            }
            else{
                header("Content-Type:application/json");
                echo json_encode("Nazalost,imamo problema sa bazom molimo pokusajte kasnije");
                http_response_code(500);
            }
        }
        else{
            header("Location:../../prijave.php");
        }
    }
    else{
        header("Location: ../../prijave.php");
    }
?>