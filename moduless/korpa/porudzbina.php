<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["dugme"])){
        $porudzbina=$_POST["porudzbina"];
        $korisnik=$_POST["kupac"];
        $adresa=$_POST["adresa"];
        $grad=$_POST["grad"];
        $datumIsporuke=date("Y-m-d H:i:s",strtotime("3 days"));;
        $porudzbineQuery="INSERT INTO porudzbine(korisnikId,adresa,grad,datumIsporuke) VALUES(:korId,:adresa,:grad,:datumIsp)";
        $porudzbinaPriprema=$konekcija->prepare($porudzbineQuery);
        $porudzbinaPriprema->bindParam(":korId",$korisnik);
        $porudzbinaPriprema->bindParam(":adresa",$adresa);
        $porudzbinaPriprema->bindParam(":grad",$grad);
        $porudzbinaPriprema->bindParam(":datumIsp",$datumIsporuke);
        try{
            $unosPorudzbine=$porudzbinaPriprema->execute();
            if($unosPorudzbine){
                $porudzbinaId=$konekcija->lastInsertId();
                $detaljiPorudzbine="INSERT INTO proizvod_porudzbina VALUES";
                foreach($porudzbina as $artikal){
                    $detaljiPorudzbine.="($porudzbinaId,{$artikal["id"]},{$artikal["kolicina"]},{$artikal["cena"]}),";
                }
                $detaljiPorudzbine=substr($detaljiPorudzbine,0,-1);
                $unosDetalja=$konekcija->prepare($detaljiPorudzbine);
                $izvrsiUnos=$unosDetalja->execute();
                if($izvrsiUnos){
                    http_response_code(201);
                    header("Content-Type:application/json");
                    echo json_encode(["res"=>"OK"]);
                }
            }
        }
        catch(PDOException $e){
            http_response_code(500);
            header("Content-Type:application/json");
            echo json_encode(["res"=>"Greska"]);
        }
    }
    else{
        header("Location:404.php");
    }
?>