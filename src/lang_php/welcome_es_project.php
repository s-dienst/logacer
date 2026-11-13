            <h5>Bienvenido a la base de datos de <?php echo PROJECT->code() . ' - ' . PROJECT->name(); ?></h5>
            <p><?php echo PROJECT->credits(); ?></p>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <p>Esta base de datos se basa en el software <a href='<?php echo create_url_proj(['logacer']); ?>'>LOGACer</a> (un software en línea para la gestión y el análisis de datos sobre cerámica arqueológica). La estructura relacional de la base de datos permite realizar consultas avanzadas y análisis transversales entre los distintos yacimientos.
            <h5>Contacte con nosotros</h5>
            <p><a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Póngase en contacto con nosotros</a> para compartir sus preguntas, sugerencias o comentarios, o descubra más sobre el proyecto en la página de <a href="<?php echo create_url_proj(["about_us"]); ?>">Presentación y contacto</a>.
            <p>¡Que disfrute de la exploración!</p>
