<?php
    require_once "config/konekcija.php";
    require_once "function.php";
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
    $admin=false;
    $korisnik=false;
    // if(isset($_SESSION["user"])){
    //     $user=$_SESSION["user"];
    //     if($user["naziv"]=="korisnik"){
    //         $korisnik=true;
    //     }
    //     if($user["naziv"]=="admin"){
    //         $admin=true;
    //     }
    // }
    if($user){
        $user=$_SESSION["user"];
    }
    else{
        header("Location:./prijave.php");
    }
?>
<section id="user-panel" class="container-fluid ">
    <div class="row">
  <div class="col-12 col-md-4 userMeni">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#korisnik" role="tab" aria-controls="home">Korisnički podatci</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#lozinka" role="tab" aria-controls="home">Promena lozinke</a>
      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#kupovina" role="tab" aria-controls="profile">Isorija kupovine
      </a>
    </div>
  </div>
  <div class="col-12 col-md-8 p-5 mt-2 text-center">
    <div class="tab-content" id="nav-tabContent">
        <!-- Korisnicki podatci -->
      <div class="tab-pane fade show active" id="korisnik" role="tabpanel" aria-labelledby="list-home-list">
        <h1 class="text-center">Korisnički podatci</h1>
        <form id="formaIzmene" action="moduless/korisnik/promenaProfil.php" method="POST">
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaIme" class="col-sm-2 col-form-label text-md-right">Ime</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext  w-75 d-inline" id="izmenaIme" name="izmenaIme" value="<?=$user["ime"]?>" />
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaPrezime" class="col-sm-2 col-form-label text-md-right">Prezime</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaPrezime" name="izmenaPrezime" value="<?=$user["prezime"]?>" />
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaAdresa" class="col-sm-2 col-form-label text-md-right">Adresa</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaAdresa" name="izmenaAdresa" value="<?=$user["adresa"]?>" />
                <i class="fa fa-pencil ml-3 izmena"></i>
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaGrad" class="col-sm-2 col-form-label text-md-right">Grad</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaGrad" name="izmenaGrad" value="<?=$user["grad"]?>" />
                <i class="fa fa-pencil ml-3 izmena"></i>
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaTel" class="col-sm-2 col-form-label text-md-right">Telefon</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaTel" name="izmenaTel" value="<?=$user["telefon"]?>" />
                <i class="fa fa-pencil ml-3 izmena"></i>
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaKorIme" class="col-sm-2 col-form-label text-md-right">Korisničko ime</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaKorIme" name="izmenaKorIme" value="<?=$user["korIme"]?>" />
                <i class="fa fa-pencil ml-3 izmena"></i>
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="izmenaMail" class="col-sm-2 col-form-label text-md-right">Email adresa</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="text" readonly="readonly" class="form-control-plaintext w-75 d-inline" id="izmenaMail" name="izmenaMail" value="<?=$user["email"]?>" />
                </div>
            </div>
            <?php
                if(isset($_SESSION["zauzeto"])){
                    echo "<p class='alert alert-danger'>{$_SESSION['zauzeto']}</p>";
                    unset($_SESSION["zauzeto"]);
                }
            ?>
            
            <div class="dugmici d-none">
            <button type="submit" name="promenaProfil" class="btn dugme promeni">Promeni</button>
            <button type="reset" class="btn dugme ponisti">Poništi</button>
            </div>
        </form>
      </div>
      <!-- Promena lozinke -->
      <div class="tab-pane fade" id="lozinka" role="tabpanel" aria-labelledby="list-messages-list">
        <h1 class="text-center">Promena lozinke</h1>
        <form action="" method="POST" id="sifraIzmena">
        <div class="form-group row justify-content-center my-4">
                <label for="trenutnaSifra" class="col-sm-2 col-form-label text-md-right">Trentuna lozinka</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="password" class="form-control clearFocus w-75 d-inline" id="trenutnaSifra" name="trenutnaSifra" />
                <input type="hidden" name="hiddenUser" class="form-control w-75 d-inline" id="hiddenUser" value="<?=$user["id"]?>" />
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="novaSifra" class="col-sm-2 col-form-label text-md-right">Nova lozinka</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="password" class="form-control clearFocus w-75 d-inline" id="novaSifra" name="novaSifra" />
                <p class="greska text-danger"></p>
                </div>
            </div>
            <div class="form-group row justify-content-center my-4">
                <label for="potrvdiLozinku" class="col-sm-2 col-form-label text-md-right">Potvrdi lozinku</label>
                <div class="col-12 col-md-10 col-lg-5">
                <input type="password" class="form-control clearFocus w-75 d-inline" id="potrvdiLozinku" name="potrvdiLozinku" />
                <p class="greska text-danger"></p>
                </div>
            </div>
            <p class="lozPoruka alert alert-success p-3 text-center d-none">Lozinka uspešno promenjena.</p>
            <div>
            <button type="submit" class="btn dugme promeniSifru" name="promeniSifra">Promeni</button>
            <button type="reset" class="btn dugme ponisti">Poništi</button>
            </div>
        </form>
      </div>
      <!-- Istorija kupovine -->
      <div class="tab-pane fade" id="kupovina" role="tabpanel" aria-labelledby="list-profile-list">
          <h1 class="text-center">Istorija kupovine</h1>
     
            <?php
                $kupovineUpit="SELECT pp.porudzbinaId,p.datumPorudzbine,SUM(pp.kolicina*pp.cenaProizvoda) AS cena
                FROM porudzbine p INNER JOIN proizvod_porudzbina pp ON pp.porudzbinaId=p.id 
                WHERE p.korisnikId=:id
                GROUP BY pp.porudzbinaId,p.datumPorudzbine
                ORDER BY p.datumPorudzbine";
                $priprema=$konekcija->prepare($kupovineUpit);
                $priprema->bindParam(":id",$user["id"]);
                $priprema->execute();
                if($priprema->rowCount()>0):
            ?>
             <table class="table table-hover mt-5">
        <thead>
            <tr>
            <th scope="col">Porudzbina ID</th>
            <th scope="col">Datum poruzdbine</th>
            <th scope="col">Cena</th>
            </tr>
        </thead>
        <tbody>        
            <?php
                    $kupovine=$priprema->fetchAll();
                    foreach($kupovine as $kup):
            ?>
            <tr>
            <td><?=$kup["porudzbinaId"]?></td>
            <td><?=date("d-m-Y",strtotime($kup["datumPorudzbine"]))?></td>
            <td><?=$kup["cena"]?></td>
            </tr>
            <?php
                endforeach;
            else:?>
                <h3 class="text-center pt-5">Vasa istorija kupovine je prazna</h3>
            <?php
                endif;
            ?>
        </tbody>
        </table>
      </div>
       
  </div>
</div>
</section>
<?php
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
?>