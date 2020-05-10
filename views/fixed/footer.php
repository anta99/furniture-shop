<?php
    require_once "config/konekcija.php";
    $navUpit="SELECT * FROM navigacija";
    $navigacija=$konekcija->query($navUpit)->fetchAll();
    $kategorijeUpit="SELECT * FROM kategorije";
    $kategorije=$konekcija->query($kategorijeUpit)->fetchAll();
?>
<footer class="container-fluid">
    <div class="container p-1 p-md-5">
        <div class="row">
            <div class="col-md-4 col-6 col-sm-6">
                <h2>Posetite</h2>
                <ul>
                   <?php
                        foreach($navigacija as $nav):
                   ?>
                   <li><a href="<?=$nav['link']?>"><?=$nav['imeLinka']?></a></li>
                   <?php
                        endforeach;
                   ?>
                </ul>
            </div>
            <!-- <div class="col-md-3 col-6 col-sm-6">
                <h2>Proizvodi</h2>
                <ul>
                <?php
                        foreach($kategorije as $kat):
                   ?>
                   <li><a href="proizvodi.php?kat=<?=$kat["id"]?>"><?=$kat["naziv"]?></a></li>
                   <?php
                        endforeach;
                   ?>
                </ul>
            </div> -->
            <div class="col-md-4 col-6 col-sm-6">
                <h2>Naša radnja</h2>
                <p>Adresa:Slavka Miljkovića 19</p>
                <p>Radno vreme:<br/>Pon – Sub: 08h – 22h<br/>Ned: 10h – 20h</p>
            </div>
            <div class="col-md-4 col-6 col-sm-6 text-center soc">
                <h2>Pratite nas</h2>
                <ul>
                    <li class="d-inline-block m-1 mt-3"><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block m-1"><a href="https://www.instagram.com/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    <li class="d-inline-block m-1"><a href="https://www.pinterest.com/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                </ul>
            </div>
            <div class="col-12 text-center mt-3">
                <p>Author:Djordje Antanaskovic</p>
            </div>
        </div>
    </div>

</footer>