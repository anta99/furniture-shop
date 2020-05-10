<?php
    require_once "../../config/konekcija.php";
    require_once "../../function.php";
    $strana=$_POST["strana"];
    header("Content-Type:application/json");
    echo json_encode(dohvatiProizvode($strana,[],"","",[],[]));
?>