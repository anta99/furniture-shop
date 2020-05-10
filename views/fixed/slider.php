<section class="container-fluid">
<div class="row">
    <div class="col-12">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <?php
            require_once "config/konekcija.php";
            $slikeSlider="SELECT * FROM slike WHERE tip='slider'";
            $rezultat=$konekcija->query($slikeSlider)->fetchAll();
            foreach($rezultat as $index => $slide):
                if($index==0):
        ?>
         <div class="carousel-item active position-relative">
        <img src="images/<?=$slide["src"]?>" class="d-block w-100 img-fluid" alt="<?=$slide["alt"]?>" />
        <div class="position-absolute natpis">
            <h2>Namestaj San</h2>
        </div>
        </div> 
        <?php
            else:
        ?>            

         <div class="carousel-item position-relative">
        <img src="images/<?=$slide["src"]?>" class="d-block w-100 img-fluid" alt="<?=$slide["alt"]?>" />
        <!-- <div class="position-absolute natpis">
            <h2>Namestaj San</h2>
        </div> -->
        </div> 
        <?php
                endif;
            endforeach;
        ?>  

    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
    </div>
</div>
</section>
