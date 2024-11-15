<style>
    .max-width-image {
        max-width: 40%;
    }
</style>
<div class="container">
    <a role="button" class="btn btn-primary btn-lg btn-block" href="<?php echo base_url()?>index.php/scenario/creer" style="margin-top:1em;">+</a>

    <?php
    $session = session();
    if (isset($scenarios)) {
        if (!empty($scenarios) && is_array($scenarios)) {
            ?>
            <h1 class="text-center mb-4 mt-4">Scenarii</h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Titre</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Nombre d'étapes</th>
                            <th class="text-center" scope="col">Auteur</th>
                            <th class="text-center" scope="col">Validité</th>
                            <th class="text-center" scope="col">Visualiser</th>
                            <th class="text-center" scope="col">Copier</th>
                            <th class="text-center" scope="col">Modifier</th>
                            <th class="text-center" scope="col">Supprimer</th>
                            <th class="text-center" scope="col">Activer / Désactiver</th>
                            <th class="text-center" scope="col">Remise à zéro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($scenarios as $scenario) { 
                            if ($session->get('user') == $scenario['com_pseudo']) {?>
                                <tr class="table-success">
                            <?php }else{ ?>
                                <tr>
                            <?php } ?>
                                <td class="text-center"><?php echo $scenario['sce_intitule']; ?></td>
                                <td class="text-center">
                                    <img class="img-fluid mx-auto d-blocke" src="<?php echo base_url() . "images/" . $scenario['sce_image'] ?>">
                                </td>
                                <td class="text-center"><?php if($scenario['nb_etape']==0){echo "Aucune étape pour ce scénario";}else{echo $scenario['nb_etape'];} ?></td>
                                <td><?php echo $scenario['com_pseudo']; ?></td>
                                <td class="text-center">
                                    <?php if ($scenario["sce_active"] == 'A') { ?>
                                        <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/verifier.png" ?>">
                                    <?php } else { ?>
                                        <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/fermer.png" ?>">
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <img onclick="afficherLigne(this)" class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/loupe.png" ?>">
                                </td>
                                <td class="text-center">
                                    <?php if ($session->get('user') != $scenario['com_pseudo']) {?>
                                    <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/copie.png" ?>">
                                    <?php } ?>
                                </td>
                                <?php if ($session->get('user') == $scenario['com_pseudo']) { ?>
                                    <td class="text-center">
                                        <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/crayon.png" ?>">
                                    </td>
                                    <td class="text-center">
                                        <img onclick="supprimerLigne(this)" class="img-fluid mx-auto d-blocke max-width-image"  src="<?php echo base_url() . "images/effacer.png" ?>">
                                    </td>
                                <?php } else { ?>
                                    <td></td>
                                    <td></td>
                                <?php } ?>
                                <td class="d-none"><input type="hidden" readonly class="d-none" name="active" value="<?php echo $scenario['sce_code']?>"></td>
                                <?php if ($session->get('user') == $scenario['com_pseudo']) { ?>
                                <td>
                                    <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/cercle-de-fleches.png" ?>">
                                </td>
                                <td>
                                    <img class="img-fluid mx-auto d-blocke max-width-image" src="<?php echo base_url() . "images/reinitialiser.png" ?>">
                                </td>
                                <?php } else { ?>
                                    <td></td>
                                    <td></td>
                                    <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }else { ?>
                <div class="col-md-12 text-center mb-4 mt-4">
                    <h5>Aucun scénario pour l'instant !</h5>
                </div>
            <?php }
    } else { ?>
        <div class="col-md-12 text-center mb-4 mt-4">
            <h5>Ce scénario n'a aucune étape pour l'instant</h5>
        </div>
    <?php } ?>
</div>
<div class="d-none">
<?php echo form_open('/scenario/supprimer', 'id="supprimerForm"'); ?>
        <?= csrf_field() ?>
            <input type="hidden" class="d-none" id="codeInputsupr" name="sce_code" value="">
        </form>
</div>
<div class="d-none">
<?php echo form_open('/scenario/detail', 'id="afficherForm"'); ?>
        <?= csrf_field() ?>
            <input type="hidden" class="d-none" id="codeInputaff" name="sce_code" value="">
        </form>
</div>
<script>
function afficherLigne(element) {
    var ligne = element.parentNode.parentNode;
    var colonne10 = ligne.cells[9].firstChild.value;
    document.getElementById('codeInputaff').value = colonne10;
    document.getElementById('afficherForm').submit();
}
function supprimerLigne(element) {
    var ligne = element.parentNode.parentNode;
    var colonne10 = ligne.cells[9].firstChild.value;
    document.getElementById('codeInputsupr').value = colonne10;
    confirmerSuppression();
}
function confirmerSuppression() {
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet élément ?");
        if (confirmation) {
            document.getElementById('supprimerForm').submit();
        } else {
            alert("Suppression annulée !");
        }
    }
</script>
