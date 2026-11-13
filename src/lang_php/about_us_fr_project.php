            <h4>Pour une utilisation de l'outil, vous pouvez vous référer à la <a href='<?php echo create_url_proj(['tutorials']); ?>'>liste des tutoriaux</a>.</h4><br>
            <h2>Présentation de la base de données <?php echo PROJECT->code(); ?></h2>
            <br>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <h2>Responsable et collaborateurs du projet</h2>
            <br>
            <p>Le projet est géré par <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>. <?php
            $contributors = User::linked('project', 'contributor', PROJECT->id());
            if (count($contributors) > 0) {
                echo "Collaborateurs du projet : ";
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
            <h2>Propriété intellectuelle et protection des données</h2>
            <br>
            <ul>
                <li><b>Responsabilité des utilisateurs :</b> Chaque contributeur est responsable de la propriété intellectuelle des données qu’il dépose. Les données inédites appartiennent à leurs auteurs, sauf mention contraire.</li>
                <li><b>Confidentialité :</b> Aucune donnée n’est cryptée (hors mots de passe). Le gestionnaire de la base de données s'engage à ne pas consulter ni utiliser les données marquées comme privées sans autorisation.</li>
                <li><b>Améliorations en cours :</b> Pour toute question ou suggestion concernant la protection des données, utilisez le formulaire de contact à <a href="https://www.logacer.org/about_us#contact" target="_blank">cette adresse</a>.</li>
            </ul>
            <br>

            <h2>Architecture logicielle</h2>
            <br>
            <p>Pour en savoir plus sur l’infrastructure technique, consultez la page dédiée à <a href='<?php echo create_url_proj(['logacer']); ?>'><?php serve_picture_public("Logo-logacer-2.png", true, false, 20); ?> LOGACer</a>.</p>
            <br>