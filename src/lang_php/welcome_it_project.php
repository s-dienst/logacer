            <h5>Benvenuti nella banca dati di <?php echo PROJECT->code() . ' - ' . PROJECT->name(); ?></h5>
            <p><?php echo PROJECT->credits(); ?></p>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <p>Questa banca dati si basa sul software <a href='<?php echo create_url_proj(['logacer']); ?>'>LOGACer</a> (un software online per la gestione e l'analisi dei dati relativi alla ceramica archeologica). La struttura relazionale della banca dati consente di effettuare interrogazioni avanzate e analisi trasversali tra i diversi siti.
            <h5>Contattaci</h5>
            <p><a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Contattaci</a> per condividere domande, suggerimenti o commenti, oppure scopri di più sul progetto nella pagina <a href="<?php echo create_url_proj(["about_us"]); ?>">Presentazione e contatti</a>.
            <p>Buona esplorazione!</p>
