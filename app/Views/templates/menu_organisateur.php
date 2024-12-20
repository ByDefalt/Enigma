<div class="hero_area">
    <div class="bg-box">
        <img src="" alt="">
    </div>
    <!-- header section starts -->
    <header class="header_section">
        <div class="container">
            <nav class="navbar navbar-expand-lg custom_nav-container">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                    <span>Énigma</span>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""> </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url(); ?>">Home <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/compte/afficher_profil">Mon
                                Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/compte/deconnecter">Deconexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>index.php/scenario/afficher_gestion">Gestion
                                Scenarii</a>
                        </li>
                    </ul>
                    <div class="user_option">
                        <a href="<?php echo base_url(); ?>index.php/scenario/afficher" class="order_online">JOUER</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7 col-lg-6 ">
                                <div class="detail-box">
                                    <h1>Plein de jeux et d'énigmes</h1>
                                    <p>Venez découvrire plein d'énigme sur ce site.</p>
                                    <div class="btn-box">
                                        <a href="<?php echo base_url(); ?>index.php/scenario/afficher" class="btn1">JOUER</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7 col-lg-6 ">
                                <div class="detail-box">
                                    <h1>Gestion des scenarii</h1>
                                    <p>Venez voir tout les scenarii.</p>
                                    <div class="btn-box">
                                        <a href="<?php echo base_url(); ?>index.php/compte/lister" class="btn1">Gestion des
                                            scenarii</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7 col-lg-6 ">
                                <div class="detail-box">
                                    <h1>Mon Profil</h1>
                                    <p>Venez regardé votre profil</p>
                                    <div class="btn-box">
                                        <a href="<?php echo base_url(); ?>index.php/compte/afficher_profil" class="btn1">Mon
                                            Profil</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <ol class="carousel-indicators">
                    <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                    <li data-target="#customCarousel1" data-slide-to="1"></li>
                    <li data-target="#customCarousel1" data-slide-to="2"></li>
                </ol>
            </div>
        </div>
    </section>
    <!-- end slider section -->
</div>
