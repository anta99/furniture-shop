<?php
    session_start();
    require_once "../../config/konekcija.php";

    if(isset($_POST["logBtn"])){
        if(isset($_POST["logIme"])){
            $logIme=$_POST["logIme"];
        }
        if(isset($_POST["logPass"])){
            $lozinka=$_POST["logPass"];
        }
        $korImeRegex="/^[A-z][A-z0-9\.\?\!]{3,59}$/";
        $lozinkaRegex="/^[\w\W\s]{6,}$/";
        if(!preg_match($korImeRegex,$logIme) || !preg_match($lozinkaRegex,$lozinka)){
            $_SESSION["greska"]="Korisnicko ime ili lozinka nisu ispravni";
            header("Location: ../../prijave.php");
        }
        else{
            $logovanjeUpit="SELECT k.*,u.naziv FROM korisnici k INNER JOIN uloge u ON k.ulogaId=u.id WHERE korIme=:korIme AND sifra=md5(:sifra)";
            $logovanjePriprema=$konekcija->prepare($logovanjeUpit);
            $logovanjePriprema->bindParam(":korIme",$logIme);
            //$mdSifra=md5($lozinka);
            $logovanjePriprema->bindParam(":sifra",$lozinka);
            $logovanjePriprema->execute();
            if($logovanjePriprema->rowCount()==1){
                $_SESSION["user"]=$logovanjePriprema->fetch();
                header("Location: ../../profil.php");
            }
            else{
                $_SESSION["greska"]="Korisnicko ime ili lozinka nisu ispravni";
                header("Location: ../../prijave.php");
            }
        }
    }
    else{
        header("Location: ../../prijave.php");
    }
?>