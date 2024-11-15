<?php
$code = '';
$code_est_correct = false;

while ($code_est_correct == false) {
    $code_est_correct = true;

    for ($i = 0; $i < 15; $i++) {
        $code = $code . strtoupper(dechex(random_int(0, 15)));
    }

    if (isset($scenarios)) {
        if (!empty($scenarios) && is_array($scenarios)) {
            foreach ($scenarios as $scenario) {
                if ($scenario['sce_code'] == $code) {
                    $code_est_correct = false;
                }
            }
        }
    }
}
?>

<section id="content">
    <div class="container mt-3">
        <h2>Ajouter un Scenario</h2>
        <?= session()->getFlashdata('error') ?>

        <?php echo form_open_multipart('/scenario/creer'); ?>
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="Inputtitre">Titre</label>
            <input type="titre" class="form-control" name="titre" placeholder="Entrer titre">
            <?= validation_show_error('titre') ?>
        </div>

        <div class="form-group">
            <label for="Inputdescription">Description</label>
            <input type="description" class="form-control" name="description" placeholder="description">
            <?= validation_show_error('description') ?>
        </div>

        <div class="form-group">
            <label for="Inputdescription">Code d'étape :</label>
            <input type="sce_code" readonly class="form-control" name="sce_code" placeholder="Code" value="<?php echo $code ?>">
            <?= validation_show_error('sce_code') ?>
        </div>

        <div class="form-group" style="display:flex;flex-direction: column;">
            <label for="sel1" class="form-label">Activer / Désactiver</label>
            <select class="form-select" id="active" name="active">
                <option value="A">Activer</option>
                <option value="D">Désactiver</option>
            </select>
            <?= validation_show_error('active') ?>
        </div>

        <div class="form-group">
            <label for="fichier">Image pour le scenario :</label>
            <input type="file" name="fichier">
            <p class="font-weight-bold"><?= validation_show_error('fichier') ?></p>
            <p class="text-secondary">
                Le fichier doit être au format image (jpg, jpeg, gif, png, webp).<br>
                La taille du fichier ne doit pas dépasser 1 Mo.
            </p>
        </div>

        <button style="margin-bottom: 1em;" type="submit" class="btn btn-primary mt-3" name="submit">Créer un nouveau
            scenario</button>
        </form>
    </div>
</section>
