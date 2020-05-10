<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["add"])){
        $nazivRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/";
        $opisRegex="/^[A-ZŽČĆŠĐ][A-zŽČĆŠĐšđčžć0-9\,\.\/\?\!\s]{1,}$/";
        $cenaRegex="/^[1-9][0-9]{0,7}$/";
        $specRegex="/^[1-9][0-9]{1,3} cm$/";
        $materijalRegex="/^[A-z]{2,30}$/";
        $slikaRegex="/^image\/(jpeg|jpg|png)$/";
        $infoGreske=[];
        header("Content-Type:application/json");
        if(isset($_POST["naziv"])){
            $ime=$_POST["naziv"];
            if(!preg_match($nazivRegex,$ime)){
                $infoGreske[]="Ime nije u dobrom formatu!";
            }
        }
        if(isset($_POST["opis"])){
            $opis=$_POST["opis"];
            if(!preg_match($opisRegex,$opis)){
                $infoGreske[]="Opis nije u dobrom formatu!";
            }
            
        }
        if(isset($_POST["cena"])){
            $cena=$_POST["cena"];
            if(!preg_match($cenaRegex,$cena)){
                $infoGreske[]="Cena nije u dobrom formatu!";
            }
        }
        if(isset($_POST["kategorija"])){
            $kat=$_POST["kategorija"];
            if(empty($kat)){
                $infoGreske[]="Kategorija nije izabrana!";
            }
        }
        if(isset($_POST["spec"])){
            $spec=$_POST["spec"];
            $newSpec=json_decode($spec,true);
            foreach($newSpec as $s){
                if($s["specId"]=="4"){
                    if(!preg_match($materijalRegex,$s["vrednost"])){
                        $infoGreske=["Specifikacije nisu u dobrom formatu"];
                    }
                }
                else{
                    if(!preg_match($specRegex,$s["vrednost"])){
                        $infoGreske=["Specifikacije nisu u dobrom formatu"];
                    }
                }
            }
        }
        if(isset($_FILES["slika"])){
            $format=$_FILES["slika"]["type"];
            if(!preg_match($slikaRegex,$format)){
                $infoGreske[]="Slika nije u dobrom formatu!";
            }
            else{
                $uploadDir="../../images/";
                $staroIme=$_FILES["slika"]["name"];
                $tmpName=$_FILES["slika"]["tmp_name"];
                $ekstenzija=explode(".",$staroIme);
                $novoIme=time().".".end($ekstenzija);
                $novaPutanja=$uploadDir.$novoIme;
            }
        }
        if(count($infoGreske)==0){
            //INSERT proizvod
            $upit1="INSERT INTO proizvodi(imeProizvoda,kategorijaId,cena,opis) VALUES(:imeProizvoda,:kategorijaId,:cena,:opis)";
            $priprema1=$konekcija->prepare($upit1);
            $priprema1->bindParam(":imeProizvoda",$ime);
            $priprema1->bindParam(":kategorijaId",$kat);
            $priprema1->bindParam(":cena",$cena);
            $priprema1->bindParam(":opis",$opis);
            try{
                $konekcija->beginTransaction(); 
                $priprema1->execute();
                $proizvodId=$konekcija->lastInsertId();
                foreach($newSpec as $s){
                    $upit2="INSERT INTO specifikacije(proizvodId,karakId,vrednost) VALUES(:proizvodId,:karakId,:vrednost)";
                    $priprema2=$konekcija->prepare($upit2);
                    $priprema2->bindParam(":proizvodId",$proizvodId);
                    $priprema2->bindParam(":karakId",$s["specId"]);
                    $priprema2->bindParam(":vrednost",$s["vrednost"]);
                    $priprema2->execute();
                }
                $premestanjeSlike=move_uploaded_file($tmpName,$novaPutanja);
                if(!$premestanjeSlike){
                    $infoGreske[]="Doslo je do greske prilikom upload-a slike";
                }
                else{
                    $upit3="INSERT INTO slike(src,alt,tip,naslovna,proizvodId) VALUES('$novoIme','Slika proizvoda','proizvod',1,$proizvodId)";
                    $izvrsi=$konekcija->query($upit3);
                }
                    $konekcija->commit(); 
                    http_response_code(200);
                    echo json_encode($proizvodId);
            }
            catch(PDOException $e){
                $konekcija->rollback();
                http_response_code(500);
                $infoGreske=["Doslo je do greske.Molimo pokusajte kasnije."];
            }
            //echo json_encode("Info su dobre");
        }
        else{
            http_response_code(422);
            echo json_encode($infoGreske);
        }
    }
    else{
        header("Location:../../404.php");
    }
?>