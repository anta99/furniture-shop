<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["dodavanje"])){
        $linkRegex="/^[A-z]{1,55}\.(html|php)$/";
        $nazivRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/";
        $greske=[];
        header("Content-Type:application/json");
        if(isset($_POST["naziv"])){
            $naziv=$_POST["naziv"];
            if(!preg_match($nazivRegex,$naziv)){
                $greske[]="Naziv nije u dobrom formatu";
            }
        }
        if(isset($_POST["link"])){
            $link=$_POST["link"];
            if(!preg_match($linkRegex,$link)){
                $greske[]="Link nije u dobrom formatu";
            }
        }
        if(isset($_POST["prioritet"])){
            $prioritet=$_POST["prioritet"];
            if($prioritet==0){
                $greske[]="Prioritet nije izabran";
            }
        }
        if(!count($greske)){
            $upit="INSERT INTO navigacija(imeLinka,link,prioritet) VALUES(:naziv,:link,:prioritet)";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":naziv",$naziv);
            $priprema->bindParam(":link",$link);
            $priprema->bindParam(":prioritet",$prioritet);
            try{
                $priprema->execute();
                http_response_code(201);
                echo json_encode("Link uspešno dodat!Osvežite stranicu da vidite izmenu.");
            }
            catch(PDOException $e){
                http_response_code(500);
                echo(["Došlo je do greške!"]);
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