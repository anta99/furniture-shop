<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["rez"])){
        $greska=false;
        header("Content-Type:application/json");
        if(isset($_POST["id"])){
            $anketaId=$_POST["id"];
        }
        else{
            $greska=true;
        }
        if(!$greska){
            $upit="SELECT COUNT(ko.idOdg) as 'broj',o.tekst FROM korisnik_odgovor ko RIGHT OUTER JOIN odgovori o ON o.id=ko.idOdg WHERE o.anketaId=:id GROUP BY o.tekst ORDER BY o.id";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":id",$anketaId,PDO::PARAM_INT);
            $upit2="SELECT * FROM odgovori WHERE anketaId=:id ORDER BY id";
            $priprema2=$konekcija->prepare($upit2);
            $priprema2->bindParam(":id",$anketaId,PDO::PARAM_INT);
            try{
                $priprema->execute();
                $rezultati=$priprema->fetchAll();
                $priprema2->execute();
                $odgovori=$priprema2->fetchAll();
                http_response_code(200);
                echo json_encode(["rez"=>$rezultati,"odg"=>$odgovori]);
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }
        else{
            http_response_code(422);
            echo json_encode("Parametri nisu dobri");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>