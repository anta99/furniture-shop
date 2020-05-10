<section class="container-fluid usluge p-4">
    <article class="row text-center ">
        <div class="col-12">
            <h2 class="naslovSekcije">Naše usluge</h2>
        </div>
    </article>
    <article class="row mt-5">
        <?php
            require_once "config/konekcija.php";
            $uslugeUpit="SELECT s.alt as alt,s.src as src,u.* FROM usluge u INNER JOIN slike s ON u.id=s.uslugaId";
            $usluge=$konekcija->query($uslugeUpit)->fetchAll();
            foreach($usluge as $usluga):
        ?>
        <div class="col-12 col-sm-6 col-lg-3 p-2 p-lg-5 text-center">
            <div class="mx-auto mb-3 w-25">
            <img class="img-fluid" src="images/<?=$usluga["src"]?>" alt="<?=$usluga["src"]?>" />
            </div>
            <h3><?=$usluga["naslov"]?></h3>
            <p><?=$usluga["tekst"]?></p>
        </div>
        <?php
            endforeach;
        ?>
    </article>
</section>