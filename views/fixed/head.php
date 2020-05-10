<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
        require_once "seo.php";
        $url=explode("/",$_SERVER["SCRIPT_NAME"]);
        $strana=explode(".",end($url));
        $prava=$strana[0];
        if($prava=="proizvod"){
            $keyWords=implode(",",$$prava["keywords"]);
            echo "
                <meta name='description' content='{$$prava["desc"]}' />
                <meta name='keywords' content='$keyWords' />
                <title>{$rezultat["imeProizvoda"]} -Salon nameštaja San</title>
                ";
        }
        else if($prava=="404"){
            $keyWords=implode(",",$notFound["keywords"]);
            echo "
                <meta name='description' content='{$notFound["desc"]}' />
                <meta name='keywords' content='$keyWords' />
                <title>{$notFound["title"]}</title>
                ";
        }
        else{
            $keyWords=implode(",",$$prava["keywords"]);
            echo "
                <meta name='description' content='{$$prava["desc"]}' />
                <meta name='keywords' content='$keyWords' />
                <title>{$$prava["title"]}</title>
                ";
        }
    ?>
    <link href="images/ikonica.ico" rel="shortcut icon" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
