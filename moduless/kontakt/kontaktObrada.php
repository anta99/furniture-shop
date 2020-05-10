<?php
    //session_start();
    require_once "../../config/konekcija.php";
    if(isset($_POST["dugme"])){
        if(isset($_POST["ime"])){
            $ime=$_POST["ime"];
        }
        if(isset($_POST["mail"])){
            $mail=$_POST["mail"];
        }
        if(isset($_POST["poruka"])){
            $poruka=$_POST["poruka"];
        }
        header("Content-Type:application/json");
        $imeRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/";
        $greske=[];
        $mailRegex="/^[a-z0-9\.\?]{4,}\@([a-z0-9]{3,}\.)+[a-z]{2,3}$/";
        $porukaRegex="/^([A-zŽČĆŠĐšđčžć0-9\.\,\!\?\s]{2,})+$/";
        if(preg_match($imeRegex,$ime) && preg_match($mailRegex,$mail) && preg_match($porukaRegex,$poruka)){
            $upit="INSERT INTO mejlovi(posiljalac,mail,poruka) VALUES(:ime,:mail,:poruka)";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":ime",$ime);
            $priprema->bindParam(":mail",$mail);
            $priprema->bindParam(":poruka",$poruka);
            try{
                $priprema->execute();
                http_response_code(201);
                echo json_encode("Poruka uspesno poslata!");
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode("Doslo je do greske.Molimo vas pokusajte ponovo kasnije");
            }
        }
        else{
            http_response_code(422);
            echo json_encode("Prosledjeni parametri nisu u dobrom formatu");
        }
        
    }
    else{
        header("Location: ../../kontakt.php");
    }
    
?>