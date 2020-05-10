<?php
    require_once "config/konekcija.php";
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php"; 
?>
<main>
    <section class="container-fluid p-3 p-md-5">
        <h2 class="text-center naslovSekcije mb-5">Proizvodi</h2>
        <article class="row">
            <section class="col-12 col-md-4 col-lg-3 p-3">
                <h3 class="text-center activeFilters">Filteri <i class="fa fa-angle-down"></i></h3>
                <div class="filteri">
                <form action="" method="POST" id="pretragaForma">
                    <h4>Pretraga proizvoda</h4>
                    <input type="text" id="pretraga" placeholder="Pretraga prozivoda"/>
                    <button class="btn pretragaBtn"><i class="fa fa-search"></i></button>
                
                <br/>
                <h4 class="mt-3">Kategorije</h4>
                <ul>
                    <?php
                        $kategorijeUpit="SELECT * FROM kategorije";
                        $kategorije=$konekcija->query($kategorijeUpit)->fetchAll();
                        foreach($kategorije as $kategorija):
                    ?>
                    <li><input type="checkbox" value="<?=$kategorija["id"]?>" id="kategorija<?=$kategorija["id"]?>" name="kategorije" />
                            <label for="kategorija<?=$kategorija["id"]?>"><?=$kategorija["naziv"]?></label>
                </li>
                    <?php
                        endforeach;
                    ?>
                </ul>
                <h4>Cena</h4>
                <ul>
                    <li>
                        <input type="checkbox" name="opsegCena" id="opseg1" data-min="0" data-max="5000" />
                        <label for="opseg1">0-5000</label>
                    </li>
                    <li>
                        <input type="checkbox" name="opsegCena" data-min="5000" data-max="10000" id="opseg2" />
                        <label for="opseg2">5000-10000</label>
                    </li>
                    <li>
                        <input type="checkbox" name="opsegCena" data-min="10000" data-max="25000" id="opseg3" />
                        <label for="opseg3">10000-25000</label>
                    </li>
                    <li>
                        <input type="checkbox" name="opsegCena" data-min="25000" data-max="50000" id="opseg4" />
                        <label for="opseg4">25000-50000</label>
                    </li>
                    <li>
                        <input type="checkbox" name="opsegCena" data-min="50000" data-max="500000000" id="opseg5"/>
                        <label for="opseg5">50000+</label>
                    </li>
                </ul>
                <button class="btn dugme mx-auto filteri-Btn">Primeni filtere</button>
                </form>
                </div>
            </section>
            <section class="col-12 col-md-8 col-lg-9 p-2 p-md-3">
            <article class="col-12 text-md-right text-center sort">
                <select name="sortDdl" id="sortDdl">
                    <option value="0">Sortiraj</option>
                    <option value="name">Nazivu</option>
                    <option value="asc">Cena rastuće</option>
                    <option value="desc">Cena opadajuće</option>
                    <option value="date">Najnovije</option>
                </select>
            </article>
            <article class="row" id="proizvodi">
        
            </article>
            <ul class="pagination pagination-lg justify-content-center">
               
             </ul>
        </section>
        </article>
    </section>
</main>

<?php
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
?>
