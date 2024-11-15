<h1 class="text-center">Espace d'administration</h1>
<br />
<h2 class="text-center">Bienvenue
    <?php
    $session = session();
    echo $session->get('user');
    ?> !
</h2>
