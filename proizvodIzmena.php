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
<section id="izmenaAdmin" class="container-fluid">
    <div class="row">
        <div class="col-12">
        <h1 class="text-center my-3">Izmena proizvoda</h1>
        </div>
        <div class="col-12 col-md-6">
            <?php
                $proizvodUpit="SELECT p.*,k.naziv AS kategorija FROM (proizvodi p INNER JOIN kategorije k ON p.kategorijaId=k.id) WHERE p.id=:id";
                $proizvodPriprema=$konekcija->prepare($proizvodUpit);
                $proizvodPriprema->bindParam(":id",$id);
                $proizvodPriprema->execute();
                $proizvod=$proizvodPriprema->fetch();
            ?>
             <h2 class="text-center">Informacije o proizvodu</h2>
            <form action="" name="proizvodIzmena" id="proizvodIzmena" method="POST">
                <div class="form-group text-center">
                    <label for="izmenaNaziv">Naziv proizvoda</label>
                    <input type="text" class="form-control izmenaPolje clearFocus mx-auto" id="izmenaNaziv" name="izmenaNaziv" value="<?=$proizvod["imeProizvoda"]?>"/>
                    <input type="hidden" name="skriveniNaziv" value="<?=$proizvod["imeProizvoda"]?>" id="skriveniNaziv"/>
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="izmenaOpis">Opis proizovda</label>
                    <textarea class="form-control izmenaPolje clearFocus mx-auto" id="izmenaOpis" name="izmenaOpis" rows="7"><?=$proizvod["opis"]?></textarea>
                    <input type="hidden" name="skriveniOpis" value="<?=$proizvod["opis"]?>" id="skriveniOpis"/>
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="izmenaCena">Cena proizvoda</label>
                    <input type="text" class="form-control izmenaPolje clearFocus mx-auto" id="izmenaCena" name="izmenaCena" value="<?=$proizvod["cena"]?>"/>
                    <input type="hidden" name="skrivenaCena" value="<?=$proizvod["cena"]?>" id="skrivenaCena"/>
                    <p class="greska text-danger"></p>
                </div>
                <div class="form-group text-center">
                    <label for="izmenaKategorije">Kategorija</label>
                    <select name="izmenaKat" id="izmenaKat" class="form-control izmenaPolje clearFocus mx-auto">
                        <?php
                            $kategorijeUpit="SELECT * FROM kategorije";
                            $kategorije=$konekcija->query($kategorijeUpit)->fetchAll();
                            foreach($kategorije as $kategorija):
                                if($kategorija["id"]==$proizvod["kategorijaId"]):
                        ?>
                        <option value="<?=$kategorija["id"]?>" selected="selected"><?=$kategorija["naziv"]?></option>
                        <?php
                            else:
                        ?>
                        <option value="<?=$kategorija["id"]?>"><?=$kategorija["naziv"]?></option>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </select>
                    <input type="hidden" name="skrivenaKat" value="<?=$proizvod["kategorijaId"]?>" id="skrivenaKat"/>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 text-center">
            <h2>Specifikacije</h2>
            <?php
                $specUpit="SELECT k.naziv,s.karakId,s.vrednost FROM (proizvodi p INNER JOIN specifikacije s ON p.id=s.proizvodId) INNER JOIN karakteristike k ON k.id=s.karakId WHERE p.id=:id";
                $specPriprema=$konekcija->prepare($specUpit);
                $specPriprema->bindParam(":id",$id);
                $specPriprema->execute();
                $specifikacije=$specPriprema->fetchAll();
                foreach($specifikacije as $spec):
            ?>
            <div class="form-group text-center">
                    <label for="izmenaNaziv"><?=$spec["naziv"]?></label>
                    <input type="text" class="form-control izmenaPolje clearFocus specifikacija mx-auto" id="izmena<?=$spec["naziv"]?>" name="izmena<?=$spec["naziv"]?>" data-specid="<?=$spec["karakId"]?>" value="<?=$spec["vrednost"]?>" form="proizvodIzmena"/>
                    <input type="hidden" name="skrivenaSpec" value="<?=$spec["vrednost"]?>" class="skrivenaSpec"/>
                    <p class="greska text-danger"></p>
                </div>
                <?php
                    endforeach;
                ?>
            <h2 class="text-center">Slike</h2>
            <form action="modules/administrator/izmenaSlike.php" method="POST" id="slikaForma" enctype="multipart/form-data">
                <div class="form-group text-center">
                    <label for="izmenaSlike">Izmena naslovne slike</label>
                    <input type="file" class="form-control izmenaPolje clearFocus mx-auto" id="izmenaSlike" name="izmenaSlike" />
                    <input type="hidden" name="izmenaId" id="izmenaId" value="<?=$proizvod["id"]?>" />
                    <?php
                        if(isset($_SESSION["promenaSlike"])){
                                echo "<p class='greska text-danger'>{$_SESSION["promenaSlike"]}</p>";
                            unset($_SESSION["promenaSlike"]);
                        }
                        else{
                            echo "<p class='greska text-danger'></p>";
                        }
                    ?>
                    <button type="submit" class="btn dugme slikaPromena" name="slikaPromena">Promeni sliku</button>
                </div>
            </form>    
        </div>
        <div class="col-12">
            <div class="form-group text-center">
                <button type="button" id="izmenaProizvodBtn" class="btn dugme" form="proizvodIzmena">Izmeni</button>
                <button type="reset" class="btn dugme" form="proizvodIzmena">Poništi</button>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-center p-3">
            <ul class="alert alert-danger greskaUpdate"></ul>
        </div>
    </div>
</section>
<?php
    require_once "views/fixed/footer.php";
    require_once "views/fixed/scripts.php";
?>