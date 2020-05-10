<?php
    require_once "config/konekcija.php";
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
    if(isset($_SESSION["user"])){
        $user=$_SESSION["user"];
        if($user["naziv"]=="admin"){
            if(isset($_GET["id"])){
                $id=$_GET["id"];

            }
        }
        else{
            header("Location:404.php");
        }
    }
    else{
        header("Location:404.php");
    }
?>
<section id="dodavanjeAdmin" class="container-fluid p-3">
    <div class="row">
        <div class="col-12">
        <h1 class="text-center my-3">Dodavanje proizvoda</h1>
        </div>
        <div class="col-12 col-md-7 p-2">
             <h2 class="text-center">Informacije o proizvodu</h2>
            <form action="" name="dodavanjeProizvoda" id="dodavanjeProizvoda" method="POST" enctype="multipart/form-data">
                <div class="form-group text-center">
                    <label for="addNaziv">Naziv proizvoda</label>
                    <input type="text" class="form-control izmenaPolje clearFocus mx-auto" id="addNaziv" name="addNaziv" />
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="addOpis">Opis proizovda</label>
                    <textarea class="form-control izmenaPolje clearFocus mx-auto" id="addOpis" name="addOpis" rows="7"></textarea>
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="addCena">Cena proizvoda</label>
                    <input type="text" class="form-control izmenaPolje clearFocus mx-auto" id="addCena" name="addCena" />
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="addKat">Kategorija</label>
                    <select name="addKat" id="addKat" class="form-control izmenaPolje clearFocus mx-auto">
                        <option value="">Izaberite kategoriju</option>
                        <?php
                            $kategorijeUpit="SELECT * FROM kategorije";
                            $kategorije=$konekcija->query($kategorijeUpit)->fetchAll();
                            foreach($kategorije as $kategorija):
                        ?>
                        <option value="<?=$kategorija["id"]?>"><?=$kategorija["naziv"]?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    <p class="greska text-danger"></p>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-4 ml-2 text-center">
            <h2>Specifikacije</h2>
            <?php
                $karakUpit="SELECT * FROM karakteristike";
                $karakteristike=$konekcija->query($karakUpit)->fetchAll();
                foreach($karakteristike as $karak):
            ?>
            <div class="form-group text-center">
                    <label for="addNaziv"><?=$karak["naziv"]?></label>
                    <input type="text" class="form-control izmenaPolje  clearFocus addSpec mx-auto" id="add<?=$karak["naziv"]?>" name="add<?=$karak["naziv"]?>" data-karakid="<?=$karak["id"]?>" form="dodavanjeProizvoda"/>
                    <p class="greska text-danger"></p>
                </div>
                <?php
                    endforeach;
                ?>
                <p class="alert alert-secondary">Proizvod mora da sadrži barem 3 navedene specifikacije!</p>
                 <h2 class="text-center">Slike</h2>
                <div class="form-group text-center">
                    <label for="addSlika">Naslovna slika</label>
                    <input type="file" class="form-control izmenaPolje clearFocus mx-auto" id="addSlika" name="addSlika" form="dodavanjeProizvoda"/>
                    <p class="greska text-danger"></p>
                </div>    
        </div>
        <div class="col-12">
            <div class="form-group text-center">
                <button type="button" class="btn dugme addDugme" form="dodavanjeProizvoda">Dodaj</button>
                <button type="reset" class="btn dugme" form="dodavanjeProizvoda">Poništi</button>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto d-none" >
            <div class="alert alert-danger p-3">
                <ul id="dodavanjeGreske">
                </ul>
            </div>
        </div>
            <div class="alert alert-success text-center uspesnoDodat mx-auto">

            </div>
    </div>
</section>
<?php
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
?>