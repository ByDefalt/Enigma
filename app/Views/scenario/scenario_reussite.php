<section id="content">
    <div class="container mt-3">
        <div class="row justify-content-center">
            <?php if (!isset($formfini)) {
                if (isset($etape) && $etape->sce_code != null) { ?>
                    <div class="col-md-12 text-center mb-4">
                        <h1>Félicitation</h1>
                        <h5>
                            Vous avez fini <?php echo  $etape->sce_intitule?>
                        </h5>
                        <h10>
                            Remplissez le formulaire pour enregistrer votre réussite
                        </h10>
                    </div>
                    <?php echo form_open('scenario/reussite'); ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email">
                    </div>
                    <?= validation_show_error('email') ?>
                    <div class="form-group">
                        <label>Nom / Prenom</label>
                        <input type="name" class="form-control" name="name" placeholder="Nom Prénom">
                    </div>
                    <?= validation_show_error('name') ?>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="code" value="<?php echo $etape->eta_code ?>">
                        <input type="hidden" class="form-control" name="niv" value="<?php echo $etape->niv ?>">
                        <input type="submit" class="btn btn-primary  mb-4" value="Envoyer">
                    </div>
                    </form>
                <?php } else { ?>
                    <div class="col-md-12 text-center mb-4 mt-4">
                        <h5>Jouer pour accéder à cette page</h5>
                    </div>
                <?php }
            } else { ?>
                <div class="col-md-12 text-center mb-4 mt-4">
                    <h5><?php echo $formfini ?></h5>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
