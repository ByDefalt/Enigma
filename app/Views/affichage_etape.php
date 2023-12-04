<div class="container">
    <div class="row justify-content-center">
        <?php if (isset($etape) && $etape->eta_code != null) { ?>
            <div class="col-md-12 text-center mb-4">
                <h1>
                    <?php echo $etape->eta_intitule ?>
                </h1>
            </div>
            <div class="col-md-12 text-center mb-4">
                <img width="1000px" src="<?php echo base_url() . "images/" . $etape->res_chemin ?>" class="img-fluid">
            </div>
            <div class="col-md-12 text-center mb-4">
                <h5>
                    <?php echo $etape->eta_desc ?>
                </h5>
            </div>
            <div class="col-md-12 text-center mb-4">
                <form>
                    <input placeholder="Réponse">
                </form>
            </div>
            <button class="btn btn-primary mb-4" onclick="toggleVisibility()">Indice</button>
            <div id="myDiv" class="alert alert-primary mt-3 d-none">
                <div class="col-md-12 text-center mb-4">
                    <h5>
                        <?php echo $etape->ind_desc ?>
                    </h5>
                </div>
                <div class="col-md-12 text-center mb-4">
                    <a href="<?php echo $etape->ind_lien ?>">
                        <?php echo $etape->ind_lien ?>
                        </h5>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-md-12 text-center mb-4">
            <p>pas d'étape 1</p>
        </div>
    <?php } ?>
</div>
</div>
<script>
    function toggleVisibility() {
        var myDiv = document.getElementById("myDiv");
        myDiv.classList.toggle("d-none");
    }
</script>