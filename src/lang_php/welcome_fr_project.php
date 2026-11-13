            <h5>Bienvenue sur la base de données de <?php echo PROJECT->code() . ' - ' . PROJECT->name(); ?></h5>
            <p><?php echo PROJECT->credits(); ?></p>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <p>Cette base de données s’appuie sur le logiciel <a href='<?php echo create_url_proj(['logacer']); ?>'>LOGACer</a> (un logiciel online de gestion et d'analyse de données sur la vaisselle archéologique). La structure relationnelle de la base permet des requêtes avancées et des analyses transversales entre les sites.
            <h5>Nous contacter</h5>
            <p><a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Contactez-nous</a> pour partager vos questions, suggestions ou commentaires, ou apprenez-en plus sur le projet sur la page de <a href="<?php echo create_url_proj(["about_us"]); ?>">Présentation et contacts</a>.
            <p>Bonne exploration !</p>