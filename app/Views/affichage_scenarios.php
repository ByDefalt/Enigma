<?php
if (isset($scenarios)) {
    if (!empty($scenarios) && is_array($scenarios)) {
?>
        <section class="gallery-block cards-gallery">
            <div class="container">
                <div class="row">
                    <?php foreach ($scenarios as $scenario) { ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <a class="lightbox">
                                    <img src="<?php echo base_url(); ?>images/<?php echo $scenario['sce_image']; ?>" class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <h6>
                                        <?php echo $scenario['sce_intitule']; ?>
                                    </h6>
                                    <p class="text-muted card-text">
                                        <?php echo $scenario['sce_desc']; ?>
                                    </p>

                                    <div class="list-group">
                                        <a href="<?php echo base_url(); ?>index.php/scenario/afficher_etape_1/<?php echo $scenario['sce_code']; ?>/1" class="list-group-item list-group-item-action">Facile</a>
                                        <a href="<?php echo base_url(); ?>index.php/scenario/afficher_etape_1/<?php echo $scenario['sce_code']; ?>/2" class="list-group-item list-group-item-action">Moyen</a>
                                        <a href="<?php echo base_url(); ?>index.php/scenario/afficher_etape_1/<?php echo $scenario['sce_code']; ?>/3" class="list-group-item list-group-item-action">Difficile</a>
                                    </div>
                                    <h5 style="margin-top:10px">
                                        <?php echo $scenario['com_pseudo']; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php
    } else {
    ?>
        <div class="container">
            <h3 class='text-center'>Aucun scénario pour l'instant !</h3>
        </div>
    <?php
    }
}
?>
</div>
