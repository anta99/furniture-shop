<?php
    require_once "config/konekcija.php";
    function dohvatiProizvode($strana,$kategorije,$crit,$sort,$minCena,$maxCena){
        global $konekcija;
        $poStrani=6;
        $startIndex=($strana-1)*$poStrani;
        $imaLiWhere=false;
        $upit="SELECT s.src as src,s.alt as alt,p.*,k.naziv as kategorija FROM proizvodi p INNER JOIN kategorije k ON p.kategorijaId=k.id INNER JOIN slike s ON s.proizvodId=p.id";
        if(count($kategorije)!=0){
            $kategorijeUpit=implode($kategorije,",");
            if(!$imaLiWhere){
                $upit.=" WHERE";
                $imaLiWhere=true;
            }
            $upit.=" p.kategorijaId IN ($kategorijeUpit)";
        }
        if(count($maxCena)!=0){
            if(!$imaLiWhere){
                $upit.=" WHERE";
                $imaLiWhere=true;
            }
            else{
                $upit.=" AND";
            }
            foreach($minCena as $key=>$value){
                if($key==0){
                    $upit.="  (cena BETWEEN $value AND {$maxCena[$key]}";
                }
                else{
                    $upit.=" OR cena BETWEEN $value AND {$maxCena[$key]}";
                }
            }
            $upit.=")";   
        }
        if($crit!=""){
            if(!$imaLiWhere){
                $upit.=" WHERE";
                $upit.=" p.imeProizvoda LIKE '%$crit%'";
                $imaLiWhere=true;
            }
            else{
                $upit.=" AND p.imeProizvoda LIKE '%$crit%'";
            }
            
        }
        switch($sort){
            case "name":
                $upit.=" ORDER BY imeProizvoda";
            break;
            case "asc":
                $upit.=" ORDER BY cena";
            break;
            case "desc":
                $upit.=" ORDER BY cena DESC";
            break;
            case "date":
                $upit.=" ORDER BY datumUnosa DESC";
            break;
            default:
                $upit.=" ORDER BY datumUnosa";
            break;
        }
        $brojProizvodaUpit=$konekcija->prepare($upit);
        $brojProizvodaUpit->execute();
        $brojProizvoda=$brojProizvodaUpit->rowCount();
        $upit.=" LIMIT $startIndex,$poStrani";
        $priprema=$konekcija->prepare($upit);
        // $priprema->bindParam(":crit",$crit);
        $priprema->execute();
        $rezultat=$priprema->fetchAll();
       // $brojProizvoda=$priprema->rowCount();
        //$brojProizvoda=count($rezultat);
        $brojStrana=ceil($brojProizvoda/$poStrani);
        $res=["proizvodi"=>$rezultat,"brojStrana"=>$brojStrana];
        return $res;
    }
?>