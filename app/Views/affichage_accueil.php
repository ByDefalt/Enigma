<section id="content">
    <?php
    if (!empty($all_actualite) && is_array($all_actualite)) {
    ?>
        <div class="container">
            <h1 class="text-center">Actualités</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Auteur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($all_actualite as $actualite) {
                        echo ("<tr>" .
                            "<td>" . $actualite["act_intitule"] . "</td>" .
                            "<td>" . $actualite["act_desc"] . "</td>" .
                            "<td>" . $actualite["act_date"] . "</td>" .
                            "<td>" . $actualite["com_pseudo"] . "</td>" .
                            "</tr>");
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <h3 class="text-center">Aucune Actualité pour le moment</h3>
        </div>
    <?php
    }
    ?>
</section>
