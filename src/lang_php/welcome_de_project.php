            <h5>Willkommen in der Datenbank von <?php echo PROJECT->code() . ' - ' . PROJECT->name(); ?></h5>
            <p><?php echo PROJECT->credits(); ?></p>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <p>Diese Datenbank basiert auf der Software <a href='<?php echo create_url_proj(['logacer']); ?>'>LOGACer</a> (einer Online-Software zur Verwaltung und Analyse von Daten zu archäologischer Keramik). Die relationale Struktur der Datenbank ermöglicht komplexe Abfragen und standortübergreifende Analysen.
            <h5>Kontakt</h5>
            <p><a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Kontaktieren Sie uns</a>, um Ihre Fragen, Vorschläge oder Kommentare mitzuteilen, oder erfahren Sie mehr über das Projekt auf der Seite <a href="<?php echo create_url_proj(["about_us"]); ?>">Vorstellung und Kontakt</a>.
            <p>Viel Freude beim Erkunden!</p>
