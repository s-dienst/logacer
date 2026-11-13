            <h4>Zur Nutzung des Tools können Sie die <a href='<?php echo create_url_proj(['tutorials']); ?>'>Liste der Tutorials</a> konsultieren.</h4><br>
            <h2>Vorstellung der Datenbank <?php echo PROJECT->code(); ?></h2>
            <br>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <h2>Projektverantwortlicher und Projektmitarbeiter</h2>
            <br>
            <p>Das Projekt wird von <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?> geleitet. <?php
            $contributors = User::linked('project', 'contributor', PROJECT->id());
            if (count($contributors) > 0) {
                echo "Projektmitarbeiter: ";
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
            <h2>Geistiges Eigentum und Datenschutz</h2>
            <br>
            <ul>
                <li><b>Verantwortung der Nutzer:</b> Jeder Mitwirkende ist für die Rechte am geistigen Eigentum der von ihm eingestellten Daten verantwortlich. Unveröffentlichte Daten bleiben Eigentum ihrer Urheber, sofern nichts anderes angegeben ist.</li>
                <li><b>Vertraulichkeit:</b> Es werden keine Daten verschlüsselt (mit Ausnahme von Passwörtern). Der Datenbankverwalter verpflichtet sich, als privat gekennzeichnete Daten ohne Genehmigung weder einzusehen noch zu verwenden.</li>
                <li><b>Laufende Verbesserungen:</b> Bei Fragen oder Anregungen zum Datenschutz verwenden Sie bitte das Kontaktformular unter <a href="https://www.logacer.org/about_us#contact" target="_blank">dieser Adresse</a>.</li>
            </ul>
            <br>

            <h2>Softwarearchitektur</h2>
            <br>
            <p>Weitere Informationen zur technischen Infrastruktur finden Sie auf der Seite zu <a href='<?php echo create_url_proj(['logacer']); ?>'><?php serve_picture_public("Logo-logacer-2.png", true, false, 20); ?> LOGACer</a>.</p>
            <br>
