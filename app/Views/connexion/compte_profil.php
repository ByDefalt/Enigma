<div class="container">
    <h2 class="mt-4">Mon Profil</h2>
    <?php
    $session = session();
    ?>
    <?= session()->getFlashdata('error') ?>
    <?php echo form_open('/compte/modifier_mdp'); ?>
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
        <?= validation_show_error('mdpconfirm') ?>
    </div>
    <input type="submit" name="submit" class="btn btn-primary mb-4" value="Changer Mot de passe">
    </form>
</div>