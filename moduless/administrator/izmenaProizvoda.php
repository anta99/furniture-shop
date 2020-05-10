<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["izmena"])){
        $nazivRegex="/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/";
        $cenaRegex="/^[1-9][0-9]{0,7}$/";
        $specRegex="/^[1-9][0-9]{1,3}\scm$/";
        $opisRegex="/^[A-ZŽČĆŠĐ][A-zŽČĆŠĐšđčžć0-9\,\.\/\?\!\s]{1,}$/";
        $materijalRegex="/^[A-z]{2,30}$/";
        $code=500;
        $izmene=[];
        $greske=[];
        $izmeneUpit=false;
        $specUpit=false;
        $upit="UPDATE proizvodi SET ";
        if(isset($_POST["id"])){
            $id=$_POST["id"];
        }
        if(isset($_POST["naziv"])){
            $noviNaziv=$_POST["naziv"];
            if(preg_match($nazivRegex,$noviNaziv)){
                $upit.="imeProizvoda=:noviNaziv,";
                $izmene[]="noviNaziv";
                $izmeneUpit=true;
            }
            else{
                $greske[]="Naziv nije u dobrom formatu";
            }
        }
        if(isset($_POST["opis"])){
            $noviOpis=$_POST["opis"];
            if(preg_match($opisRegex,$noviOpis)){
                $upit.="opis=:noviOpis,";
                $izmene[]="noviOpis";
                $izmeneUpit=true;
            }
            else{
                $greske[]="Opis nije u dobrom formatu";
            }
        }
        if(isset($_POST["cena"])){
            $novaCena=$_POST["cena"];
            if(preg_match($cenaRegex,$novaCena)){
                $upit.="cena=:novaCena,";
                $izmene[]="novaCena";
                $izmeneUpit=true;
            }
            else{
                $greske[]="Cena nije u dobrom formatu";
            }
        }
        if(isset($_POST["kategorija"])){
            $novaKat=$_POST["kategorija"];
            $upit.="kategorijaId=:novaKat,";
            $izmene[]="novaKat";
            $izmeneUpit=true;
        }
        if(isset($_POST["spec"])){
            $spec=$_POST["spec"];
            $specUpit=true;
        }

        $upit=substr($upit,0,-1);
        $upit.=" WHERE id=:id";
        if(!count($greske)){
            $priprema=$konekcija->prepare($upit);
            foreach($izmene as $izmena){
                $priprema->bindParam(":$izmena",$$izmena);
            }
            $priprema->bindParam(":id",$id);
            try{
                if($izmeneUpit){
                    $priprema->execute();
                    if($priprema->rowCount()==1){
                        $code=204;
                    }
                }
                if($specUpit){
                    foreach($spec as $s){
                        if(preg_match($specRegex,$s["vrednost"])){
                            $upit2="UPDATE specifikacije SET vrednost=:vrednost WHERE karakId=:karakId AND proizvodId=:proId";
                            $priprema2=$konekcija->prepare($upit2);
                            $priprema2->bindParam(":vrednost",$s["vrednost"]);
                            $priprema2->bindParam(":karakId",$s["specId"]);
                            $priprema2->bindParam(":proId",$id);
                            $priprema2->execute();
                            if($priprema2->rowCount()==1){
                                $code=204;
                            }
                        }
                        else{
                            $greske[]="Specifikacija nije u dobrom formatu";
                        }
                    }
                }
                http_response_code($code);
                #echo json_encode(var_dump($spec));
            }
            catch(PDOException $e){
                http_response_code(500);
                $greske[]="Doslo je do greske.Molimo vas pokusajte kasnije";
                echo json_encode($greske);
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