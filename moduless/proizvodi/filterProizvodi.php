 <?php
    require_once "../../function.php";
    $kategorije=[];
    $strana=1;
    $minCena=[];
    $maxCena=[];
    $crit="";
    $sort="";
    if(isset($_POST["strana"])){
        $strana=$_POST["strana"];
    }
    if(isset($_POST["kategorije"])){
        $kategorije=$_POST["kategorije"];
    }
    if(isset($_POST["minCena"]) && isset($_POST["maxCena"])){
        $minCena=$_POST["minCena"];
        $maxCena=$_POST["maxCena"];
    }
    if(isset($_POST["sort"])){
        $sort=$_POST["sort"];
    }
    if(isset($_POST["crit"])){
        $crit=$_POST["crit"];
    }
     header("Content-Type:application/json");
     http_response_code(200);
     echo json_encode(dohvatiProizvode($strana,$kategorije,$crit,$sort,$minCena,$maxCena));
     
    //$rezultat=$konekcija->query($upit)->fetchAll();
    // header("Content-Type:application/json");
    // echo json_encode(["res"=>$rezultat]); 
?> 
