<section id="content">
    <div class="container mt-3">
        <h2>
            <?php echo $titre; ?>
        </h2>
        <?= session()->getFlashdata('error') ?>

        <?php

        // Création d’un formulaire qui pointe vers l’URL de base + /compte/creer
        
        echo form_open('/compte/creer'); ?>
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="InputPseudo">Pseudo</label>
            <input type="pseudo" class="form-control" name="pseudo" aria-describedby="pseudoHelp"
                placeholder="Enter Pseudo">
            <?= validation_show_error('pseudo') ?>
        </div>
        <div class="form-group">
            <label for="InputPassword">Password</label>
            <input type="password" class="form-control" name="mdp" placeholder="Password">
            <?= validation_show_error('mdp') ?>
        </div>
        <div class="form-group" style="display:flex;flex-direction: column;">
            <label for="sel1" class="form-label">Role</label>
            <select class="form-select" id="role" name="role">
                <option value="A">A</option>
                <option value="O">O</option>
            </select>
            <?= validation_show_error('role') ?>
        </div>
        <button style="margin-bottom: 1em;" type="submit" class="btn btn-primary mt-3" name="submit">Créer un nouveau
            compte</button>
        </form>
    </div>
</section>