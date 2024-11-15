<div class="container">
    <?php if (!isset($erreur)) { ?>
        <div class="row justify-content-center">
            <?php if (isset($etape) && $etape->eta_code != null) { ?>
                <div class="col-md-12 text-center mb-4">
                    <h1><?php echo $etape->eta_intitule ?></h1>
                </div>
                <div class="col-md-12 text-center mb-4">
                    <img width="1000px" src="<?php echo base_url() . "images/" . $etape->res_chemin ?>" class="img-fluid">
                </div>
                <div class="col-md-12 text-center mb-4">
                    <h5><?php echo $etape->eta_desc ?></h5>
                </div>
                <div class="col-md-12 text-center mb-4">
                    <?= session()->getFlashdata('error') ?>
                    <?php echo form_open('/scenario/franchir_etape'); ?>
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <input name="reponsse" placeholder="Réponse">
                            <?= validation_show_error('reponsse') ?>
                        </div>
                        <input type="hidden" name="code" value="<?php echo $etape->eta_code ;?>">
                        <input type="hidden" name="niv" value="<?php echo $etape->niv ;?>">
                        <input type="submit" class="btn btn-primary mb-4" value="Valider">
                    </form>
                </div>
                <?php if(!empty($etape->ind_lien)){ ?>
                    <button class="btn btn-primary mb-4" onclick="toggleVisibility()">Indice</button>
                    <div id="myDiv" class="alert alert-primary mt-3 d-none">
                        <div class="col-md-12 text-center mb-4">
                            <h5><?php echo $etape->ind_desc ?></h5>
                        </div>
                        <div class="col-md-12 text-center mb-4">
                            <a href="<?php echo $etape->ind_lien ?>">
                                <?php echo $etape->ind_lien ?>
                            </a>
                        </div>
                    </div>
                <?php }?>
            </div>
        <?php } else { ?>
            <div class="col-md-12 text-center mb-4 mt-4">
                <h5>Ce scénario n'a aucune étape pour l'instant</h5>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <h3 class="text-center"><?php echo $erreur ?></h3>
<?php }?>
</div>
<script>
    function toggleVisibility() {
        var myDiv = document.getElementById("myDiv");
        myDiv.classList.toggle("d-none");
    }
</script>
