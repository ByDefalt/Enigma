<section id="content">
    <div class="container">
        <a role="button" class="btn btn-primary btn-lg btn-block" href="<?php echo base_url() ?>index.php/compte/creer"
            style="margin-top:1em;">+</a>

        <?php
        if (!empty($logins) && is_array($logins)) {
            $seule_admin_is_connect = true;

            foreach ($logins as $pseudos) {
                if ($pseudos['com_pseudo'] != 'administrATeur' && $pseudos['com_active'] == 'A') {
                    $seule_admin_is_connect = false;
                }
            }

            if ($seule_admin_is_connect == true) {
                ?>
                <h2 class="text-center mt-4">Pas de Comptes Activés</h2>
                <?php
            }
            ?>

            <h1 class="text-center">Comptes</h1>
            <h6 class="text-center">nombre de compte : <?php echo $nbcompte->nbcompte ?></h6>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Pseudo</th>
                        <th scope="col">Role</th>
                        <th scope="col">Etat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logins as $pseudos) {
                        echo ("<tr>" .
                            "<td>" . $pseudos["com_pseudo"] . "</td>" .
                            "<td>" . $pseudos["com_role"] . "</td>" .
                            "<td>" . $pseudos["com_active"] . "</td>" .
                            "</tr>");
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo ("<h3>Aucun Compte Activé pour le moment</h3>");
        }
        ?>
    </div>
</section>
