<?php
    session_start();
    require_once "config/konekcija.php";
    //unset($_SESSION["user"]);
    $user=false;
    $admin=false;
    if(isset($_SESSION['user'])){
        $user=true;
        if($_SESSION['user']["naziv"]=="admin"){
            $admin=true;
        }
    }
?>
<body>
<header>
<section class="container-fluid navTraka text-center text-md-right">
    <div class="row">
        <div class="col-12 px-md-5">
        <?php
            if($user):
                if($admin):
            ?>
            <a href='adminPanel.php'>Admin panel<i class="fa fa-cogs mx-1"></i></a>
            <?php
                endif;
            ?>
            <a href='profil.php'>Moj nalog<i class='fa fa-user mx-1'></i></a>
            <a href='views/odjava.php'>Odjavi se</a>
            <?php
                else:
            ?>
            <a href='prijave.php'>Registruj se <i class='fa fa-user mx-1'></i></a>
            <a href='prijave.php'>Prijavi se</a>
            
        <?php
            endif;
        ?>
            <a href="<?php if($user) {echo "korpa.php";} else{echo "prijave.php";}?>"><i class="fa fa-shopping-basket"></i> <span id="korpaBrojac">0</span></a>
        </div>
    </div>
</section>
<section class="container-md container-fluid heder">
    <div class="row">
        <div class="col-12">
                <nav class="navbar navbar-expand-lg px-md-5 py-3">
                    <h1 id="naziv"><a class="navbar-brand" href="index.php">Namestaj San</a></h1>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                        <ul class="navbar-nav navigacija">
                        <?php
                            $upit="SELECT * FROM navigacija ORDER BY prioritet;";
                            $meni=$konekcija->query($upit)->fetchAll();
                            foreach($meni as $link):
                        ?>
                        <!-- <li class="nav-item active">
                            <a class="nav-link" href="#">Home</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?=$link["link"]?>"><?=$link["imeLinka"]?></a>
                        </li>
                        <?php
                            endforeach;
                        ?>
                        </ul>
                    </div>
        </nav>
        </div>
    </div>
</section>
</header>