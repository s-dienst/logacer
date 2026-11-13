            <h2>Impressum - <?php echo WEBSITE_NAME; ?></h2>
            <h5>Herausgeber von LOGACer</h5>
            <p>
                Simon Dienst
                </br>Service d'histoire de l'art et archéologie de l'Antiquité gréco-romaine (SHAARAGR)
                </br>Département des sciences historiques
                </br>Faculté de Philosophie et lettres
                </br>Université de Liège
                </br>Place du 20-Août, 7
                </br>B-4000 Liège, Belgique
                </br>Email : Simon.Dienst@uliege.be
                </br>Site web : www.logacer.org
            </p>
            <h5>Hosting-Anbieter</h5>
            <p>
                Für Informationen zum Hosting-Anbieter wenden Sie sich bitte über das <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Kontaktformular</a> an die für die Installation verantwortliche Person.
            </p>
            <h5>Verantwortlicher für die Veröffentlichung</h5>
            <p>Die veröffentlichten Daten liegen in der alleinigen Verantwortung von 
                <?php
                $users = User::find_all();
                $already = 0;
                foreach ($users as $user) {
                    if ($user->is_staff()) {
                        if ($already > 0) {
                            echo ", ";
                        }
                        echo $user->codename();
                        $already++;
                    }
                }
                ?>
                 und des/der Projektverantwortlichen. Sie begründen in keinem Fall eine Haftung des Hosting-Anbieters.</p>
            <h5>Verwendete Software</h5>
            <p>Die Datenbank wird mithilfe von <a href="https://www.logacer.org">LOGACer - Logiciel Online de Gestion et d'Analyse de la Céramique</a> veröffentlicht, einer von Simon Dienst entwickelten Software.</p>
            <h5>Geistiges Eigentum</h5>
            <p>Der Inhalt der Website (Texte, Bilder, wissenschaftliche Daten) ist urheberrechtlich geschützt. Die wissenschaftlichen Daten können unterschiedlichen Ursprungs sein: unveröffentlichte Daten, vom Autor der Datensätze veröffentlichte Daten oder vom Autor der Datensätze übernommene und überarbeitete Daten. Die Mitwirkenden an der Datenbank sind verpflichtet, diese verschiedenen Fälle voneinander zu unterscheiden. Die Nutzer verpflichten sich, die Urheberrechte zu respektieren.</p>
            <h5>Nutzungsbedingungen</h5>
            <p>Die Nutzung von <?php echo WEBSITE_NAME; ?> ist kostenlos und für berufliche oder akademische Zwecke bestimmt. Jede missbräuchliche oder betrügerische Nutzung ist untersagt. Die Verwendung von in LOGACer oder einem seiner Projekte veröffentlichten Daten (unveröffentlichte oder überarbeitete Daten) muss mit einer korrekten Quellenangabe erfolgen.</p>
            <h5>Kontakt</h5>
            <p>Bei Fragen: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Kontaktformular</a>.</p>
