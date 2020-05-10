<?php
    require_once "../config/konekcija.php";
    $upit="SELECT * FROM proizvodi";
    $upit2="SELECT s.src as src,s.alt as alt,p.cena,p.imeProizvoda,k.naziv as kategorija,p.id FROM slike s INNER JOIN proizvodi p ON s.proizvodId=p.id INNER JOIN kategorije k ON p.kategorijaId=k.id ORDER BY p.datumUnosa DESC LIMIT 0,4";
    try{
        $rez=$konekcija->query($upit2)->fetchAll();
        header("Content-Type:application/json");
        http_response_code(200);
        echo json_encode($rez);
    }
    catch(PDOException $e){
        http_response_code(500);
        echo json_encode("Trentuno nedostupno");
    }
    
?>