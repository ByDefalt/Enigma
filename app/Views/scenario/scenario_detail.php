<div class="container">
    <?php
    $session = session();
    if (isset($scenarios)) {
        if (!empty($scenarios) && is_array($scenarios)) {
            $premiereLigne = reset($scenarios);
    ?>
            <h1 class="text-center mb-4 mt-4">Detail du Scenario <?php echo $premiereLigne['sce_code']; ?></h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Titre</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Description</th>
                            <th class="text-center" scope="col">Auteur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo $premiereLigne['sce_intitule']; ?></td>
                            <td class="text-center">
                                <img class="img-fluid mx-auto d-blocke" src="<?php echo base_url() . "images/" . $premiereLigne['sce_image'] ?>">
                            </td>
                            <td class="text-center"><?php echo $premiereLigne['sce_desc']; ?></td>
                            <td class="text-center"><?php echo $premiereLigne['com_pseudo']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
            foreach ($scenarios as $scenario) {
                if (isset($scenario['eta_num'])) {
            ?>
                    <h4 class="text-center mb-4 mt-4">Etape <?php echo $scenario['eta_num'] + 1; ?></h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Question</th>
                                <th class="text-center" scope="col">Réponse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?php echo $scenario['eta_question']; ?></td>
                                <td class="text-center"><?php echo $scenario['eta_reponsse']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php
                } else {
                ?>
                    <div class="col-md-12 text-center mb-4 mt-4">
                        <h5>Ce scénario n'a aucune étape pour l'instant</h5>
                    </div>
            <?php
                }
            }
        } else {
            ?>
            <div class="col-md-12 text-center mb-4 mt-4">
                <h5>Aucun scénario pour l'instant !</h5>
            </div>
    <?php
        }
    } else {
    ?>
        <div class="col-md-12 text-center mb-4 mt-4">
            <h5>Ce scénario n'existe pas !</h5>
        </div>
    <?php
    }
    ?>
</div>
