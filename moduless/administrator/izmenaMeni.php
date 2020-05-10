<?php
    require_once "../../config/konekcija.php";
    if(isset($_POST["izmena"])){
        header("Content-Type:application/json");
        $greske=[];
        if(isset($_POST["id"])){
            $id=$_POST["id"];
        }
        if(isset($_POST["link"])){
            $link=$_POST["link"];
            $linkRegex="/^[A-z]{1,55}\.(html|php)$/";
            if(!preg_match($linkRegex,$link)){
                $greske[]="Link nije u dobrom formatu";
            }
        }
        if(isset($_POST["prioritet"])){
            $prior=$_POST["prioritet"];
        }
        if(!count($greske)){
            $upit="UPDATE navigacija SET link=:link,prioritet=:prioritet WHERE id=:id";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":link",$link);
            $priprema->bindParam(":prioritet",$prior);
            $priprema->bindParam(":id",$id);
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
            echo json_encode("Parametri nisu dobri");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>