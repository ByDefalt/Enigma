<div class="container">
    <h2 class="mt-4">
        <?php echo $titre; ?>
    </h2>
    <?= session()->getFlashdata('error') ?>
    <?php echo form_open('/compte/connecter'); ?>
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="pseudo">Pseudo : </label>
        <input type="input" class="form-control" name="pseudo" placeholder="Enter Pseudo"
            value="<?= set_value('pseudo') ?>">
        <?= validation_show_error('pseudo') ?>
    </div>
    <div class="form-group">
        <label for="mdp">Password</label>
        <input type="password" class="form-control" name="mdp" placeholder="Password">
        <?= validation_show_error('mdp') ?>
    </div>
    <button type="submit" class="btn btn-primary mb-4" name="submit" value="Se connecter">Se connecter</button>
    </form>
    </form>
</div>