<?php
    require_once "config/konekcija.php";
    $id=$_GET["id"];
    $upit="SELECT p.*,k.naziv,s.src as src,s.alt as alt FROM (proizvodi p INNER JOIN kategorije k ON p.kategorijaId=k.id) INNER JOIN slike s ON s.proizvodId=p.id WHERE p.id=:id";
    $priprema=$konekcija->prepare($upit);
    $priprema->bindParam(":id",$id);
    $priprema->execute();
    $rezultat=$priprema->fetch();
    if(!$rezultat){
        header("Location: 404.php");
    }
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
    //echo "Naziv izabranog proizvoda je {$rezultat["imeProizvoda"]}";
?>
<section class="container-fluid p-1 p-md-5 my-5" id="proizvod">
    <article class="row">
        <section class="galerija col-12 col-sm-10 mx-sm-auto col-lg-5 p-1 p-md-5 order-2 order-md-1">
            <!-- <?php
                // $slikeUpit="SELECT src,alt FROM slike WHERE proizvodId=:id";
                // $slikePriprema=$konekcija->prepare($slikeUpit);
                // $slikePriprema->bindParam(":id",$rezultat["id"]);
                // $slikePriprema->execute();
                // $slike=$slikePriprema->fetchAll();
            ?> -->
            <article id="velikaSlika">
                <img src="images/<?=$rezultat["src"]?>" class="img-fluid" alt="<?=$rezultat["alt"]?>" />
            </article>
            <!-- <article id="maleSlike" class="row mt-5">
                <?php
                    #foreach($slike as $slika):
                ?>
                <div class="slicica col-4 col-sm-3 p-1 p-md-0 mr-1">
                    
                </div>
                <?php
                    #endforeach;
                ?>
            </article> -->
        </section>
        <section class="col-12 col-lg-4 order-1 order-md-2 specifikacije p-3 p-md-5 mx-auto">
            <h1><?=$rezultat["imeProizvoda"]?></h1>
            <span>Šifra proizvoda: <?=$rezultat["id"]?></span>
            <p class="font-weight-bold">Kategorija: <?=$rezultat["naziv"]?></p>
            <h2 class="my-3"><?=$rezultat["cena"]?> din.</h2>
            <p  class="opis font-weight-bold"><?=$rezultat["opis"]?></p>
            <div class="karakteristike py-2 px-3 my-4">
                <h3>Karakteristike proizvoda</h3>
                <ul>
                    <?php
                        $karakteristikeUpit="SELECT k.naziv,s.* FROM `specifikacije` s INNER JOIN karakteristike k ON s.karakId=k.id WHERE s.proizvodId=:proizvod;";
                        $karakPriprema=$konekcija->prepare($karakteristikeUpit);
                        $karakPriprema->bindParam(":proizvod",$rezultat["id"]);
                        $karakPriprema->execute();
                        $karakteristike=$karakPriprema->fetchAll();
                        foreach($karakteristike as $karakteristika):
                    ?>
                    <li class="text-muted"><?=$karakteristika["naziv"]?>: <?=$karakteristika["vrednost"]?></li>
                    <?php
                        endforeach;
                        
                    ?>
                </ul>
            </div>
            <a class="btn dugme" href="<?php if($user) {echo "korpa.php";} else{echo "prijave.php";}?>" id="kupiProizvod" data-id="<?=$id?>">Kupi</a>
            <a class="btn dugme dodajUKorpu dodajProizvod" href="#" data-id="<?=$id?>"><i class="fa fa-cart-plus"></i> Dodaj u korpu</a>
            
        </section>
    </article>
    
</section>
<?php
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
?>
