<?php
    session_start();
    require_once "../../config/konekcija.php";
    if(isset($_POST["slikaPromena"])){
        if(isset($_POST["izmenaId"])){
            $id=$_POST["izmenaId"];
        }
        if(isset($_FILES["izmenaSlike"])){
            $slikaRegex="/^image\/(jpeg|jpg|png)$/";
            $uploadDir="../../images/";
            $staroIme=$_FILES["izmenaSlike"]["name"];
            $tmpName=$_FILES["izmenaSlike"]["tmp_name"];
            $ekstenzija=explode(".",$staroIme);
            $novoIme=time().".".end($ekstenzija);
            $novaPutanja=$uploadDir.$novoIme;
            if(preg_match($slikaRegex,$_FILES["izmenaSlike"]["type"])){
                $premestanjeSlike=move_uploaded_file($tmpName,$novaPutanja);
                if(!$premestanjeSlike){
                    $_SESSION["promenaSlike"]="Doslo je do greske pilikom uplaod-a slike!";
                    header("Location:../../proizvodIzmena.php?id=$id");
                }
                else{
                    $upit="UPDATE slike SET src=:novoIme WHERE proizvodId=:id";
                    $priprema=$konekcija->prepare($upit);
                    $priprema->bindParam(":novoIme",$novoIme);
                    $priprema->bindParam(":id",$id);
                    $priprema->execute();
                    if($priprema->rowCount()==1){
                        header("Location:../../proizvod.php?id=$id");
                    }
                    else{
                        $_SESSION["promenaSlike"]="Doslo je do greške.Molimo vas pokušajte kasnije.";
                    }
                }

            }
            else{
                $_SESSION["promenaSlike"]="Morate izabrati jpg,png,jpeg format slike";
            }
            #header("Location:../../proizvodIzmena.php?id=$id");
        }
        else{
            $_SESSION["promenaSlike"]="Morate izabrati sliku";
            header("Location:../../proizvodIzmena.php?id=$id");
        }
    }
    else{
        header("Location:../../404.php");
    }
?>