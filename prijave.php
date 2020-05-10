<?php
    require_once "views/fixed/head.php";
    require_once "views/fixed/nav.php";
    if(isset($_SESSION["user"])){
        header("Location:profil.php");
    }
?>
<section class="kontakt m-5">
    <article class="row">
        <section class="regForma forma p-0 p-md-4 col-12 col-md-4 mx-auto">
            <h2 class="text-center">Registracija</h2>
            <form action="views/prijave/registracija.php" method="POST" id="regForma" name="regForma">
            <div class="form-group">
                    <label for="korIme">Ime</label>
                    <input type="text" class="form-control" id="ime" name="ime" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="prezime">Prezime</label>
                    <input type="text" class="form-control" id="prezime" name="prezime" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="adresa">Adresa</label>
                    <input type="text" class="form-control" id="adresa" name="adresa" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="grad">Grad</label>
                    <input type="text" class="form-control" id="grad" name="grad" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="tel">Mobilni telefon</label>
                    <input type="text" class="form-control" id="tel" name="tel" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="korIme">Korisničko ime</label>
                    <input type="text" class="form-control" id="korIme" name="korIme" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="regMail">Email</label>
                    <input type="text" class="form-control" id="regMail" name="regMail" />
                   <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="regPass">Lozinka</label>
                    <input type="password" class="form-control" id="regPass" name="regPass" />
                   <span class="regGreska text-danger"></span>
                </div>
                <p class="regPoruka alert p-3 text-center"></p>
                <button type="submit" class="btn dugme regBtn" name="regBtn">Registruj se</button>
            </form>
        </section>


        <section class="logForma forma p-3 col-12 col-md-4 mx-auto">
            <h2 class="text-center">Prijava</h2>
            <?php
                if(isset($_SESSION["greska"])){
                    echo "<p class='p-3 text-center alert alert-danger'>{$_SESSION["greska"]}</p>";
                    unset($_SESSION["greska"]);
                }
            ?>
            <form action="moduless/prijave/prijava.php" method="POST" id="logForma" name="logForma" onsubmit="return prijavaProvera()">
                <div class="form-group">
                    <label for="korIme">Korisničko ime</label>
                    <input type="text" class="form-control" id="logIme" name="logIme" />
                    <span class="regGreska text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="kontaktMail">Lozinka</label>
                    <input type="password" class="form-control" id="logPass" name="logPass" />
                    <span class="regGreska text-danger"></span>
                </div>
                <button type="submit" class="btn dugme logBtn" name="logBtn">Prijavi se</button>
            </form>
        </section>
    </article>
</section>

<?php
    require_once "views/fixed/footer.php";
    require_once "moduless/prijave/prijaveScript.php";
    
?>
