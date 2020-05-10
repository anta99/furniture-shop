<?php
     require_once "../../config/konekcija.php";
     require_once "../../function.php";
    if(isset($_POST["dugme"])){
        if(isset($_POST["id"])){
            $deleteId=$_POST["id"];
        }
        if(isset($_POST["strana"])){
            $strana=$_POST["strana"];
        }
        $deleteUpit="DELETE FROM proizvodi WHERE id=:id";
        $deletePriprema=$konekcija->prepare($deleteUpit);
        $deletePriprema->bindParam(":id",$deleteId);
        try{
            $deletePriprema->execute();
            $sviProizvodi=dohvatiProizvode($strana,[],"","",[],[]);
            $broj=count($sviProizvodi["proizvodi"]);
            if($broj==0){
                $sviProizvodi=dohvatiProizvode($strana-1,[],"","",[],[]);
            }
            header("Content-Type:application/json");
            http_response_code(200);
            echo json_encode($sviProizvodi);
        }
        catch(PDOException $e){
            http_response_code(500);
        }
    }
    else{
        header("Location:profil.php");
    }
?>