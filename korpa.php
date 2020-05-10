<?php
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
?>
<section class="container p-0">
    <article class="row">
        <section class="col-12"><h1 class="text-center my-3">Korpa</h1></section>
        <section class="col-12" id="korpaIspis">
            
            <!-- <article class="row">
                <div class="col-3"></div>
                <div class="col-3"></div>
                <div class="col-3"></div>
                <div class="col-3"></div>
            </article> -->
        </section>
        <section class="col-12 text-right ukupnaCena my-2 px-3">
            <span>Ukupno: <span id="ukupno" class="font-weight-bold">0</span>  RSD </span>
            <button id="kupi" class="dugme btn mx-3 mb-3" data-toggle="modal" >Kupi</button>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="kupovinaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Potvrda porudzbine</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Lista proizvoda</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Naziv proizvoda</th>
                        <th scope="col">Kolicina</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaProizvoda">
                        <!-- <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                        </tr> -->
                    </tbody>
                </table>
                <h5>Kontakt podatci</h5>
                <p >Adresa: <span id="modalAdresa"><?=$_SESSION["user"]["adresa"]?></span></p>
                <p>Grad: <span id="modalGrad"><?=$_SESSION["user"]["grad"]?></span></p>
                <p>Broj telefona: <?=$_SESSION["user"]["telefon"]?></p>
                <p>Datum narudzbine: <?php echo date("d/m/Y")?></p>
                <p>Očekivani datum isporuke: <?php echo date("d/m/Y",strtotime("3 days"))?></p>

                <h4>Ukupna cena: <span id="cenaModal"></span> dinara</h4>
            </div>
            <div class="modal-footer">
            
                <button type="button" class="btn dugme" data-dismiss="modal">Zatvori</button>
                <button type="button" class="btn dugme" data-kupac="<?=$_SESSION["user"]["id"]?>" id="potvrdi">Potvrdi</button>
            </div>
            </div>
        </div>
        </div>
    </article>
</section>
<section class="container adresa">
    
</section>
<?php
    require_once "views/fixed/footer.php";
    require_once "moduless/korpa/korpaScript.php";
?>