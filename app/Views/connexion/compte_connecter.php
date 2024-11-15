<div class="container">
    <h2 class="mt-4">
        Se Connecter
    </h2>
    <p>
        <?php if(isset($erreur)) { echo $erreur; } ?>
    </p>
    <?= session()->getFlashdata('error') ?>
    <?php echo form_open('/compte/connecter'); ?>
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="pseudo">Pseudo : </label>
        <input type="input" class="form-control" name="pseudo" placeholder="Enter Pseudo">
        <?= validation_show_error('pseudo') ?>
    </div>
    <div class="form-group">
        <label for="mdp">Password</label>
        <input type="password" class="form-control" name="mdp" placeholder="Password">
        <?= validation_show_error('mdp') ?>
    </div>
    <input type="submit" class="btn btn-primary mb-4" name="submit" value="Se connecter">
    </form>
</div>
