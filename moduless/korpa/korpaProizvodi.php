<?php
    require_once "../../config/konekcija.php";
    // $proizvodi=$_POST["korpa"];
    if(!empty($_POST["korpa"])){
        $proizvodi=$_POST["korpa"];
        $upit="SELECT p.id,p.imeProizvoda,p.cena,s.src,s.alt FROM proizvodi p INNER JOIN slike s ON p.id=s.proizvodId WHERE p.id IN ";
        $id="";
        foreach($proizvodi as $proizvod){
            $id.="'$proizvod',";
        }
        $id=substr($id,0,-1);
        $upit.="($id)";
        $priprema=$konekcija->prepare($upit);
        // $priprema->bindParam(":id",$id);
        $priprema->execute();
        $rezultat=$priprema->fetchAll();
        header("Content-Type:application/json");
        echo json_encode(["res"=>$rezultat]);
    }
    else{
        header("Content-Type:application/json");
        echo json_encode(["res"=>[]]);
    }
    
?>