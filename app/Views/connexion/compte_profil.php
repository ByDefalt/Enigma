<div class="container">
    <h2 class="mt-4">Mon Profil</h2>
    <?php
    $session = session();
    ?>
    <?= session()->getFlashdata('error') ?>
    <?php echo form_open('/compte/modifier'); ?>
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="pseudo">Pseudo : </label>
        <input type="pseudo" readonly class="form-control" name="pseudo" value="<?php echo $session->get('user'); ?>">
        <?= validation_show_error('mdp') ?>
    </div>
    <?= validation_show_error('pseudo') ?>
    <div class="form-group">
        <label for="mdp">Mot de passe : </label>
        <input type="password" class="form-control" name="mdp">
        <?= validation_show_error('mdp') ?>
    </div>
    <div class="form-group">
        <label for="mdp">Nouveau Mot de passe : </label>
        <input type="password" class="form-control" name="mdpchange">
        <?= validation_show_error('mdpchange') ?>
    </div>
    <div class="form-group">
        <label for="mdp">Confirmer nouveau Mot de passe : </label>
        <input type="password" class="form-control" name="mdpchangeconfirm">
        <?= validation_show_error('mdpchangeconfirm') ?>
    </div>
    <input type="submit" name="submit" class="btn btn-primary mb-4" value="Changer Mot de passe">
    </form>
    <input type="submit" class="btn btn-primary mb-4" onclick="redirection()" value="Annuler">
</div>
<script>
    function redirection() {
        window.location.href = "<?php echo base_url()?>index.php/accueil/afficher_back";
    }
</script>
