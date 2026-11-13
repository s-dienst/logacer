            <h4>Per utilizzare lo strumento, è possibile consultare l’<a href='<?php echo create_url_proj(['tutorials']); ?>'>elenco dei tutorial</a>.</h4><br>
            <h2>Presentazione della banca dati <?php echo PROJECT->code(); ?></h2>
            <br>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <h2>Responsabile e collaboratori del progetto</h2>
            <br>
            <p>Il progetto è gestito da <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>. <?php
            $contributors = User::linked('project', 'contributor', PROJECT->id());
            if (count($contributors) > 0) {
                echo "Collaboratori del progetto: ";
                $already = 0;
                foreach ($contributors as $contrib) {
                    if ($already > 0) {
                        if (($already + 1) === count($contributors)) {
                            echo " " . thesaurus("and") . " ";
                        } else {
                            echo ", ";
                        }
                    }
                    echo $contrib->codename();
                    $already++;
                }
            } ?>.</p>
            <h2>Proprietà intellettuale e protezione dei dati</h2>
            <br>
            <ul>
                <li><b>Responsabilità degli utenti:</b> Ogni collaboratore è responsabile della proprietà intellettuale dei dati che inserisce. I dati inediti appartengono ai rispettivi autori, salvo diversa indicazione.</li>
                <li><b>Riservatezza:</b> Nessun dato è crittografato (ad eccezione delle password). Il gestore della banca dati si impegna a non consultare né utilizzare i dati contrassegnati come privati senza autorizzazione.</li>
                <li><b>Miglioramenti in corso:</b> Per qualsiasi domanda o suggerimento riguardante la protezione dei dati, utilizzare il modulo di contatto disponibile <a href="https://www.logacer.org/about_us#contact" target="_blank">a questo indirizzo</a>.</li>
            </ul>
            <br>

            <h2>Architettura software</h2>
            <br>
            <p>Per saperne di più sull’infrastruttura tecnica, consultare la pagina dedicata a <a href='<?php echo create_url_proj(['logacer']); ?>'><?php serve_picture_public("Logo-logacer-2.png", true, false, 20); ?> LOGACer</a>.</p>
            <br>
