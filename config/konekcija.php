<?php
    require_once "parametri.php";
    try{
        $konekcija=new PDO("mysql:host=$host;dbname=$baza;",$user,$password);
        $konekcija->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Konekcija sa bazom nije moguca";
        exit;
    }
?>