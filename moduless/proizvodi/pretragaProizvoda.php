<?php
    require_once "../../konekcija.php";
    if(isset($_POST["dugme"])){
        if(isset($_POST["crit"]) && $_POST["crit"]!=""){
            $crit=$_POST["crit"];
            $upit="SELECT s.src as src,s.alt as alt,p.*,k.naziv as kategorija FROM proizvodi p INNER JOIN kategorije k ON p.kategorijaId=k.id INNER JOIN slike s ON s.proizvodId=p.id WHERE imeProizvoda LIKE :ime";
            $priprema=$konekcija->prepare($upit);
            $uslov="%$crit%";
            $priprema->bindParam(":ime",$uslov);
            $priprema->execute();
            $rezultat=$priprema->fetchAll();
            header("Content-Type:application/json");
            echo json_encode(["res"=>$rezultat]);
        }
    }  
?>