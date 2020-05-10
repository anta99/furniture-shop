<?php
    require_once "config/konekcija.php";
    require_once "views/fixed/head.php";
    require_once "views//fixed/nav.php";
    if($user){
       $user=$_SESSION["user"];
    }
?>
<h1 class="text-center m-5 naslovSekcije">Kontakt</h1>
<section class="kontakt m-5">
    <article class="row">
        <section class="kontaktForma forma p-3 col-12 col-md-6">
            <h2 class="text-center">Kontaktirajte nas</h2>
            <form action="" method="POST" id="kontaktForma" name="kontaktForma">
                <div class="form-group">
                    <label for="kontaktIme">Vaše ime</label>
                    <input type="text" class="form-control" id="kontaktIme" name="kontaktIme" />
                    <span class="greska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="kontaktMail">Vaš mail</label>
                    <input type="text" class="form-control" id="kontaktMail" name="kontaktMail" />
                   <span class="greska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="kontaktPoruka">Poruka</label><br/>
                   <textarea name="kontaktPoruka" id="kontaktPoruka" rows="10"></textarea>
                   <span class="greska text-danger"></span>
                </div>
                <div class="response text-center"></div>
                <button class="btn dugme" name="dugme">Pošalji</button>
            </form>
        </section>
        <section class="radnja col-12 p-3 col-md-4 mx-auto">
            <article class="row">
                <div class="col-12">
                    <h2 class="text-center">Posetite nas</h2>
                    <h3 class="mt-5">Salon nameštaja San - Resnik</h3>
                    <p><span class="radnjaInfo">Adresa</span>: Slavka Miljkovića 19</p>
                    <p><span class="radnjaInfo">Radno vreme: </span>Pon – Sub: 08 – 22h, Ned: 10h – 20h</p>
                    <p><span class="radnjaInfo">Prodaja:</span> 011/35-26-338</p>
                    <p><span class="radnjaInfo">Mail: </span>resnik@sanpromet.rs</p>
                </div>
                <div class="col-12 mt-2" id="anketa">
                    <?php
                        $pitanjeUpit="SELECT a.*,o.* FROM anketa a INNER JOIN odgovori o ON a.id=o.anketaId WHERE a.aktivna=1;";
                        $pitanjeiOdg=$konekcija->query($pitanjeUpit)->fetchAll();
                        // $odgovorKorisnik="SELECT ";
                        #var_dump($pitanjeiOdg);
                    ?>
                    <h2 class="text-center">Anketa</h2>
                    <h3 class="mt-3"><?=$pitanjeiOdg[0]["pitanje"]?></h3>
                    <form action="moduless/kontakt/anketaOdgovor.php" method="POST" class="mt-3" id="formaAnketa" name="formaAnketa" <?php
                        if($user){
                            echo "onsubmit='return anketaProvera()'";
                        }
                        else{
                            echo "onsubmit='return anketaKorisnik()'";
                        }
                    ?>>
                        <?php
                            foreach($pitanjeiOdg as $odg):
                        ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="odg<?=$odg["id"]?>" name="odgovor" class="custom-control-input" value="<?=$odg["id"]?>" />
                            <?php
                                if($user):
                            ?>
                            <input type="hidden" name="korisnik" class="custom-control-input" value="<?=$user["id"]?>" />
                            <?php
                                endif;
                            ?>
                            <label class="custom-control-label" for="odg<?=$odg["id"]?>"><?=$odg["tekst"]?></label>
                        </div>
                        <?php
                            endforeach;
                        ?>
                        <p class="greska mt-2 text-danger d-none">Morate izabrati odgovor</p>
                        <button type="submit" id="odgovori" name="odgovori" class="btn dugme mt-2">Odgovori</button>
                        <div class="mt-2">
                            <ul class="mt-2">
                                <?php
                                    if(isset($_SESSION["anketa"])):
                                        $anketa=$_SESSION["anketa"];
                                        foreach($anketa as $a):
                                            
                                ?>
                                <li class="mt-1"><?=$a?></li>
                                <?php
                                    endforeach;
                                    unset($_SESSION["anketa"]);
                                endif;
                                ?>
                            </ul>
                        </div>
                    </form>
                </div>
            </article>
        </section>
    </article>
</section>
<?php
    require_once "views/fixed/usluge.php";
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
    
?>
