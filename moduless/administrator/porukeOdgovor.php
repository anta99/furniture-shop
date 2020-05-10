<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["posalji"])){
        $porukaRegex="/^([A-zŽČĆŠĐšđčžć0-9\.\,\!\?\s]{2,})+$/";
        $greska=[];
        header("Content-Type:application/json");
        if(isset($_POST["odg"])){
            $odgovor=$_POST["odg"];
            if(!preg_match($porukaRegex,$odgovor)){
                $greska[]="Odgovor nije u dobrom formatu.";
            }
        }
        if(isset($_POST["msg"])){
            $msgId=$_POST["msg"];
        }
        if(!count($greska)){
            $odgUpit="UPDATE mejlovi SET odgovor=:odg,datumOdg=:datum WHERE id=:id";
            $datum=date("Y-m-d H:i:s",time());
            $priprema=$konekcija->prepare($odgUpit);
            $priprema->bindParam(":odg",$odgovor);
            $priprema->bindParam(":datum",$datum);
            $priprema->bindParam(":id",$msgId);
            try{
                $priprema->execute();
                if($priprema->rowCount()==1){
                    http_response_code(204);
                }
            }
            catch(PDOException $e){
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }
        else{
            http_response_code(422);
            echo json_encode($greska);
        }
    }
    else{
        header("Location:../../404.php");
    }
?>