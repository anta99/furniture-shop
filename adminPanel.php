<?php
    require_once "config/konekcija.php";
    require_once "function.php";
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
    //$admin=false;
    //$korisnik=false;
    if($user && $admin){
        $user=$_SESSION["user"];
        // if($user["naziv"]=="admin"){
        //     $admin=true;
        // }
    }
    else{
        header("Location:./prijave.php");
    }
?>
<section id="admin-panel" class="container-fluid ">
    <div class="row">
    <div class="col-12 col-md-4 userMeni">
        <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#mejlovi" role="tab">Inbox</a>

        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Proizvodi</a>
        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" >Anketa</a>
        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#navigacijaAdmin" role="tab" >Navigacija</a>
        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#korisniciAdmin" role="tab" >Korisnici</a>
        </div>
    </div>
    <div class="col-12 col-md-8 p-0 p-md-2 p-lg-5 mt-2 text-center">
        <div class="tab-content" id="nav-tabContent">
            <!-- Mejlovi -->
            <div class="tab-pane fade show active" id="mejlovi" role="tabpanel" >
                <h1 class="text-center">Inbox</h1>
                <div class="row inboxHead text-center">
                    <div class="col-1">Id</div>
                    <div class="col-3">Ime</div>
                    <div class="col-4">Mail</div>
                    <div class="col-4">Datum poruke</div>
                </div>
                <?php
                    $porukeUpit="SELECT * FROM mejlovi;";
                    $poruke=$konekcija->query($porukeUpit)->fetchAll();
                    foreach($poruke as $poruka):
                ?>
                <div class="row message text-center">
                    <div class="col-1 pt-2"><?=$poruka["id"]?></div>
                    <div class="col-3 pt-2 text-break"><?=$poruka["posiljalac"]?></div>
                    <div class="col-4 pt-2 text-break"><?=$poruka["mail"]?></div>
                    <div class=" col-4 pt-2 text-break"><?=date("d/m/Y H:i",strtotime($poruka["datumSlanja"]))?></div>
                    <div class="col-12">
                        <span class="procitaj my-1 d-block">Pročitaj poruku</span>
                        <div class="poruka p-3 text-left">
                            <p><?=$poruka["poruka"]?></p>
                            <?php 
                                if($poruka["odgovor"]==NULL):
                            ?>
                            <textarea name="odgovorArea" class="odgovorArea d-none" rows="10"></textarea>
                            <p class="greska alert my-2"></p>
                            <a href="#" class="m-2 posalji d-none" data-msgId="<?=$poruka["id"]?>">Pošalji</a>
                            <a href="#" class="m-2 d-inline-block odgovori">Odgovori</a>
                            <?php
                                else:
                            ?>
                            <p class="">Odgovor: <?=$poruka["odgovor"]?></p>
                            <p class="text-secondary"><em>Datum odgovra: <?= date("d/m/Y H:i",strtotime($poruka["datumOdg"]))?></em></p>
                            <?php
                                endif;
                            ?>
                            <a href="#" class="m-2 d-inline-block zatvori">Zatvori</a>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                ?>        
            </div>

            <!-- Admin proizvodi -->
        <div class="tab-pane fade px-5" id="list-messages" role="tabpanel" >
                <h1 class="text-center">Lista proizvoda</h1>
                <?php
                    $sviProizvodi=dohvatiProizvode(1,[],"","",[],[]);
                ?>
                <section class="container-fluid">
                    <article class="row" id="adminProizvodi">
                    <section class="col-12">
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Naziv proizvoda</th>
                                <th scope="col">Kategorija</th>
                                <th scope="col">Cena</th>
                                <th scope="col">Datum unosa</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="proizvodAdmin">
                            <?php
                                    foreach($sviProizvodi["proizvodi"] as $proizvod):
                            ?>
                            <tr>
                            <td><?=$proizvod["id"]?></td>
                            <td><?=$proizvod["imeProizvoda"]?></td>
                            <td><?=$proizvod["kategorija"]?></td>
                            <td><?=$proizvod["cena"]?></td>
                            <td><?=$proizvod["datumUnosa"]?></td>
                            <td>
                            <a href="proizvodIzmena.php?id=<?=$proizvod["id"]?>"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="obrisiBtn" data-delId="<?=$proizvod["id"]?>"><i class="fa fa-close"></i></a></td>
                            </tr>
                            <?php
                                    endforeach;
                            ?>
                            </tbody>
                        </table>
                        <ul class="pagination pagination-lg justify-content-center">
                        <?php
                            for($i=1;$i<=$sviProizvodi["brojStrana"];$i++):
                                if($i==1):
                        ?>
                            <li class="page-item active"><a class="page-link adminPag" href="#" data-strana="<?=$i?>"><?=$i?></a></li>
                        <?php
                                else:
                        ?>
                        <li class="page-item"><a class="page-link adminPag" href="#" data-strana="<?=$i?>"><?=$i?></a></li>    
                        <?php
                                endif;
                                endfor;
                        ?>    
                        </ul>
                    </section>
                        <a href="dodajProizvod.php" class="btn dugme text-right">Dodaj proizvod</a>
                    </article>
                </section>
        </div>
        <!-- Rezultati ankete -->
        <div class="tab-pane fade" id="list-settings" role="tabpanel" >
            <section class="container-fluid text-left p-3">
                <h1 class="text-center">Anketa</h1>
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-4">
                        <h2>Aktivna anketa</h2>
                        <form action="" method="POST">
                            <div class="form-group">
                                <select name="ankete" id="ankete" class="form-control clearFocus">
                                    <?php
                                        $anketeUpit="SELECT * FROM anketa";
                                        $ankete=$konekcija->query($anketeUpit)->fetchAll();
                                        //$ankete=dohvatiAnkete();
                                        foreach($ankete as $anketa):
                                            if($anketa["aktivna"]==1):
                                    ?>
                                    <option value="<?=$anketa["id"]?>" selected="selected"><?=$anketa["pitanje"]?></option>
                                    <?php
                                        else:
                                    ?>
                                    <option value="<?=$anketa["id"]?>"><?=$anketa["pitanje"]?></option>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <button class="btn dugme aktivAnketa">Aktiviraj</button>
                            <button class="btn dugme delAnketa">Obrisi</button>
                            <p class="aktivPoruka"></p>
                        </form>
                    </div>
                    <div class="col-12 col-md-12 col-lg-8 p-3">
                        <canvas id="grafik" ></canvas>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12 col-md-5 col-lg-3">
                    <h2>Izmena anketa</h2>
                        <form id="anketeIzmena" name="anketeIzmena" action="" method="POST">
                            <div class="form-group">
                                <select name="izmenaAnketeDdl" id="izmenaAnketeDdl" class="form-control clearFocus">
                                    <option value="0">Izaberite anketu</option>
                                    <?php
                                        foreach($ankete as $anketa):
                                    ?>
                                    <option value="<?=$anketa["id"]?>"><?=$anketa["pitanje"]?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                            
                        </form>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 ml-md-3">
                        <h2>Odgovori</h2>
                        <form id="odgovori" name="odgovori" method="POST" action="">
                            <!-- <div class="form-group">
                               <input type="text" class="form-control" />
                            </div> -->
                        </form>
                    </div>
                    <div class="col-12">
                        <button class="btn dugme izmeniAnketuBtn">Izmeni</button>
                        <button type="reset" class="btn dugme" form="odgovori">Ponisti</button>
                    </div>
                </div>
                <!-- Dodavanje ankete -->
                <div class="row my-3">
                    <div class="col-12 col-lg-6">
                    <h2>Dodavanje ankete</h2>
                        <form id="dodavanjeAnkete" name="dodavanjeAnkete" method="POST">
                            <div class="form-group">
                                <label for="pitanje">Pitanje</label>
                                <input type="text" class="form-control" id="pitanje" name="pitanje" />
                                <p class="greska text-danger"></p>
                            </div>
                            <h3>Odgovori</h3>
                            <div class="form-group">
                                <input type="text" class="form-control odg" name="odg" />
                                <p class="greska text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control odg" name="odg" />
                                <p class="greska text-danger"></p>
                            </div>
                        </form>
                        <button class="btn dugme my-2 dodajAnketu">Dodaj anketu</button>
                        <button class="btn dugme dodajOdg">Dodaj odgovor</button>
                        <ul class="text-center anketaPoruka"></ul>
                    </div>
                </div>
            </section>
        </div>

        <!-- Navigacija -->
        <div class="tab-pane fade" id="navigacijaAdmin" role="tabpanel" >
                <section class="container-fluid">
                    <h1 class="text-center">Navigacioni meni</h1>
                    <!-- Promena menija -->
                    <div class="row">
                    <h2>Izmena navigacije</h2>
                    <div class="col-12">
                    <form action="" method="POST" id="izmenaMeni" name="izmenaMeni">
                            <?php
                                $navigacijaUpit="SELECT * FROM navigacija ORDER BY prioritet;";
                                $navigacija=$konekcija->query($navigacijaUpit)->fetchAll();
                                #$brojPrioriteta=count($navigacija);
                                $brojPrioriteta=(int)end($navigacija)["prioritet"];
                            ?>
                            <div class="row p-2 p-sm-0">
                                <div class="col-12 col-md-3 m-md-2">
                                <label for="nazivLinka">Naziv stavke</label>
                                <select id="nazivLinka" class="form-control clearFocus" name="nazivLinka">
                                    <?php
                                        foreach($navigacija as $nav):
                                    ?>
                                    <option value="<?=$nav["id"]?>" data-link="<?=$nav["link"]?>" data-order="<?=$nav["prioritet"]?>"><?=$nav["imeLinka"]?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                                </div>
                                <div class="col-12 col-md-3  m-md-2">
                                <label for="link">Link</label>
                                <input type="text" class="form-control clearFocus" id="link" name="link" value="<?=$navigacija[0]["link"]?>"/>
                                <p class="greska text-danger"></p>
                                </div>
                                <div class="col-12 col-md-3 m-md-2">
                                <label for="prioritet">Prioritet</label>
                                <select id="prioritet" class="form-control clearFocus" name="prioritet">
                                    <?php
                                        for($i=1;$i<=$brojPrioriteta;$i++):
                                    ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                        endfor;
                                    ?>
                                </select>
                                
                                </div>
                                <div class="col-12">
                                    <button type="button" class="my-2 btn dugme promeniMeni">Promeni</button>
                                    <p class="alert text-center izmenaPoruka"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                    <!-- Dodavanje linka -->
                    <div class="row">
                    <h2>Dodavanje stavke</h2>
                    <div class="col-12">
                    <form action="" method="POST" id="dodavanjeMeni" name="dodavanjeMeni">
                            <div class="row p-2 p-sm-0">
                                <div class="col-12 col-md-3 m-md-2">
                                <label for="novaStavka">Naziv stavke</label>
                                <input type="text" id="novaStavka" class="form-control clearFocus" name="novaStavka" />
                                <p class="greska text-danger"></p>
                                </div>
                                <div class="col-12 col-md-3  m-md-2">
                                <label for="noviLink">Link</label>
                                <input type="text" class="form-control clearFocus" id="noviLink" name="noviLink" />
                                <p class="greska text-danger"></p>
                                </div>
                                <div class="col-12 col-md-3 m-md-2">
                                <label for="dodajPrioritet">Prioritet</label>
                                <select id="dodajPrioritet" class="form-control clearFocus" name="dodajPrioritet">
                                    <option value="0">Izaberite prioritet</option>
                                    <?php
                                        for($i=1;$i<=$brojPrioriteta+1;$i++):
                                    ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                        endfor;
                                    ?>
                                </select>
                                <p class="greska text-danger"></p>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="mx-2 btn dugme dodajMeni">Dodaj</button>
                                    <p class="alert text-center dodajPoruka"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                    <!-- Brisanje linka -->
                    <div class="row">
                    <h2>Brisanje stavke</h2>
                    <div class="col-12">
                    <form action="" method="POST" id="brisanjeMeni" name="brisanjeMeni">
                            <div class="row p-2 p-sm-0">
                                <div class="col-12 col-md-3 m-md-2">
                                <label for="brisanjeLinka">Naziv stavke</label>
                                <select id="brisanjeLinka" class="form-control clearFocus" name="brisanjeLinka">
                                    <option value="0">Izaberite stavku za brisanje</option>
                                    <?php
                                        foreach($navigacija as $nav):
                                    ?>
                                    <option value="<?=$nav["id"]?>"><?=$nav["imeLinka"]?></option>
                                    <?php
                                        endforeach;
                                    ?>
                                </select>
                                <p class="greska text-danger text-center"></p>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="my-2 btn dugme izbrisiMeni">Obriši</button>
                                    <p class="alert text-center brisanjePoruka"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </section>
        </div>
        <!-- Korisnici -->
            <div class="tab-pane fade" id="korisniciAdmin" role="tabpanel">
                <?php
                    $korisniciUpit="SELECT korIme,ulogaId FROM korisnici";
                    $ulogeUpit="SELECT * FROM uloge";
                    $korisnici=$konekcija->query($korisniciUpit)->fetchAll();
                    $uloge=$konekcija->query($ulogeUpit)->fetchAll();
                ?>      
                <section class="container-fluid">
                    <h1 class="text-center">Korisnici</h1>
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-left mt-5">Promeni ulogu korisnika</h2>
                            <form action="" method="POST" id="promenaUloge" name="promenaUloge">
                                <div class="row p-2 p-sm-0">
                                    <div class="col-12 col-md-3 m-md-2">
                                        <label for="korisnici">Korisnik</label>
                                        <select name="korisnici" class="form-control clearFocus" id="korisnici">
                                            <option value="0">Izaberite korisnika</option>
                                            <?php
                                                foreach($korisnici as $kor):
                                            ?>
                                            <option value="<?=$kor["korIme"]?>" data-uloga="<?=$kor["ulogaId"]?>"><?=$kor["korIme"]?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <p class="greska text-danger"></p>
                                    </div>
                                    <div class="col-12 col-md-3 m-md-2">
                                        <label for="uloge">Prioritet</label>
                                        <select id="uloge" class="form-control clearFocus" name="uloge">
                                            <option value="0">Izaberite ulogu</option>
                                            <?php
                                                foreach($uloge as $uloga):
                                            ?>
                                            <option value="<?=$uloga["id"]?>"><?=$uloga["naziv"]?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <p class="greska text-danger"></p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="mx-2 btn dugme promeniUlogu">Izmeni</button>
                                        <p class="alert text-center mt-2 ulogaPoruka"></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Brisanje korisnika -->
                    <div class="col-12">
                            <h2 class="text-left mt-5">Obriši korisnika</h2>
                            <form action="" method="POST" id="brisanjeKor" name="brisanjeKor">
                                <div class="row p-2 p-sm-0">
                                    <div class="col-12 col-md-3 m-md-2">
                                        <label for="brisanjeKorDdl">Korisnik</label>
                                        <select name="brisanjeKorDdl" class="form-control clearFocus" id="brisanjeKorDdl">
                                            <option value="0">Izaberite korisnika</option>
                                            <?php
                                                foreach($korisnici as $kor):
                                            ?>
                                            <option value="<?=$kor["korIme"]?>"><?=$kor["korIme"]?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <p class="greska text-danger"></p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="mx-2 btn dugme obrisiKor">Obriši korisnika</button>
                                        <p class="alert text-center mt-2 ulogaPoruka"></p>
                                    </div>
                        </div>
                        </form>
                    </div>
                </section>                  
            </div>
        </div>
    </div>
</div>
</section>
<?php
    require_once "views/fixed/footer.php";
    echo "<script src='https://cdn.jsdelivr.net/npm/chart.js@2.8.0'></script>";
    require_once "views/fixed/scripts.php";
?>