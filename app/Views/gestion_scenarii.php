<style>
    .max-width-image {
      max-width: 50%;
    }
  </style>

<div class="container">
    <?php
    if (isset($scenarios)) {
        if (!empty($scenarios) && is_array($scenarios)) {
            ?>
            <h1 class="text-center">Actualiter</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Visualiser</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Suprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($scenarios as $scenario) { ?>
                        <tr>
                            <td>
                                <?php echo $scenario['sce_intitule']; ?>
                            </td>
                            <td>
                                <?php echo $scenario['sce_desc']; ?>
                            </td>
                            <td>
                                <?php echo $scenario["sce_active"] ?>
                            </td>
                            <td>
                                <?php echo $scenario['com_pseudo']; ?>
                            </td>
                            <td>
                                <img class="max-width-image" src="<?php echo base_url()."images/loupe.png"?>">
                            </td>
                            <td>
                            <img class="max-width-image" src="<?php echo base_url()."images/crayon.png"?>">
                            </td>
                            <td>
                            <img class="max-width-image" src="<?php echo base_url()."images/effacer.png"?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo ("<h3>Pas de Scenario</h3>");
        }
    } ?>
</div>

