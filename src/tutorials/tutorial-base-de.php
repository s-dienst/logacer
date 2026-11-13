    <!-- Barre latérale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Zurück: Liste der Tutorials</a></h6><br>
        <h4 class="px-3">Grundprinzipien und Navigation</h4>
        <a href="#principes-base"><h5 class="px-3">I. Grundprinzipien</h5></a>
        <a href="#opération-objet"><h5 class="px-3">II. Von der Grabungsoperation zum Objekt</h5></a>
        <a href="#liste-opérations">1. Liste der Grabungsoperationen</a>
        <a href="#opération-archéologique">2. Archäologische Operation</a>
        <a href="#horizon-site">3. Fundstellenhorizont</a>
        <a href="#contexte-inventaire">4. Kontext und Inventar</a>
        <a href="#objet-illustration">5. Objekt und Abbildung(en)</a>
        <a href="#horizons-régionaux"><h5 class="px-3">III. Regionale Horizonte</h5></a>
        <a href="#liste-groupes-horizons">1. Liste der Horizontgruppen</a>
        <a href="#groupe-horizons">2. Beschreibung der Horizontgruppe</a>
        <a href="#horizon-régional">3. Regionale Horizonte und zugehöriges Fundmaterial</a>
        <a href="#types-pâtes"><h5 class="px-3">IV. Typen und Pastengruppen</h5></a>
        <a href="#typologies-types">1. Typologien und Typen</a>
        <ul>
            <li><a href="#liste-typologies">Liste der Typologien</a></li>
            <li><a href="#typologie">Beschreibung der Typologie</a></li>
            <li><a href="#types">Beschreibung der Typen</a></li>
        </ul>
        <a href="#pâtes">2. Pastengruppen</a>
        <ul>
            <li><a href="#liste-groupes-pâtes">Liste der Pastengruppen</a></li>
            <li><a href="#groupes-pâtes">Beschreibung der Pastengruppen</a></li>
        </ul>
        <a href="#bibliographie"><h5 class="px-3">V. Bibliografie</h5></a>
        <a href="#liste-bibliographie">1. Liste der Literaturangaben</a>
        <a href="#consulter-bibliographie">2. Eine Literaturangabe aufrufen</a>
        <a href="#autres-éléments"><h5 class="px-3">VI. Weitere Elemente</h5></a>
        <a href="#fichiers-génériques">1. Allgemeine Dateien</a>
        <a href="#citer-page">2. Eine Seite zitieren</a>
        <a href="#a-propos">3. Über die Website</a>
        <a href="#recherche-simple">4. Einfache Suche</a>
        <a href="#enregistrement-connexion">5. Registrierung und Anmeldung</a>
    </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: Grundprinzipien und Navigation im Tool ohne Anmeldung</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Grundprinzipien</h2>

    <p>Das zentrale Ziel von LOGACer, das von CeVICA verwendet wird, besteht darin, Inventare von Objekten (insbesondere Keramik) bereitzustellen und gleichzeitig die Einbindung weiterer Informationen sowie Abfragen zu diesen Objekten zu ermöglichen. Zu diesem Zweck basiert LOGACer auf verschiedenen Elementen:</p>
    <ul>
        <li>Die Kontextualisierung des <b>Objekts</b>: Dies ist der zentrale Bestandteil von LOGACer. Das Objekt gehört zu einem <b>Kontext</b> (bzw. einer stratigrafischen Einheit), der wiederum mit anderen zeitgleichen Kontexten (dem <b>Fundstellenhorizont</b>) verbunden ist; all dies wurde im Rahmen einer <b>archäologischen Operation</b> erfasst;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>Die relative Chronologie des Objekts: Fundstellenhorizonte können zu <b>regionalen Horizonten</b> zusammengefasst werden. Diese folgen innerhalb einer geografischen Region aufeinander; diese Abfolge wird über <b>Horizontgruppen</b> zusammengefasst;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>Die Charakterisierung des Objekts: Die Keramik wird entsprechend dem in LOGACer hinterlegten Modell nach ihrer <b>Kategorie</b>, ihrer <b>Funktion</b>, ihrem <b>Typ</b> und ihrer <b>Pastengruppe</b> klassifiziert. Die beiden ersten Klassifikationskriterien sind relativ standardisiert und begrenzt. Die Typen sind hingegen wesentlich zahlreicher und werden in <b>Typologien</b> zusammengefasst; dasselbe gilt für die Pastengruppen, die hierarchisch gegliedert werden können. Die Charakterisierung der Typen und Pastengruppen sowie die Möglichkeit, nach diesen zu suchen, sind ebenfalls von Bedeutung. Kategorien, Funktionen, Typologien und Typen sind weitgehend mit ONICer verknüpft;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>Die Referenzen: Die Charakterisierung dieser verschiedenen Elemente kann durch die Angabe einer <b>Bibliografie</b> als Referenz oder durch das Hinzufügen von <b>Dateien</b> ergänzt werden. Darüber hinaus werden diese Elemente von <b>Benutzern</b> verwaltet (in bestimmten Fällen als Verantwortliche oder Mitwirkende). Schließlich können die Objekte durch <b>Abbildungen</b> wie Zeichnungen, Fotografien oder Vergrößerungen ergänzt werden;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>Die Zusammenarbeit: Ein Team, das an verschiedenen dieser Elemente (Fundstellen, regionalen Horizonten usw.) arbeitet, kann diese innerhalb von <b>Projekten</b> zusammenführen, wodurch die Verwaltung der Zugriffsrechte dieses Teams erleichtert wird.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>

    <p>Die Navigation ist darauf ausgelegt, den kontextbezogenen Ansatz (von der archäologischen Operation zum Objekt) zu bevorzugen, gleichzeitig aber auch diese verschiedenen Verknüpfungen zu berücksichtigen: Darstellung der Objekte nach regionalen Horizonten, Typen und Pastengruppen (sowie deren Abbildungen), Darstellung der Fundstellenhorizonte nach regionalen Horizonten (mit den vorhandenen Kategorien und Typen), mit einer Literaturangabe verknüpfte Elemente sowie weiterführende Abfragen.</p>
    </section>

    <section id="opération-object" class="mb-5">
    <h2>II. Navigation: von der archäologischen Operation zum Objekt</h2>
        <section id="liste-opérations" class="mb-5">
        <h3>1. Liste der archäologischen Operationen</h3>

            <p>Die Liste der archäologischen Operationen ist über die obere Navigationsleiste zugänglich.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_1.png" width="80%"></div>
            <p>Innerhalb dieser Liste kann die gewünschte Operation entweder über eine interaktive Karte oder über die Liste der archäologischen Operationen aufgerufen werden.

            <h4>1.1. Karte</h4>
                <p>Jede archäologische Operation wird auf der Karte durch einen Marker dargestellt. Wenn Sie auf den Marker klicken, können Sie sehen, um welche archäologische Operation es sich handelt. Sie können sie aufrufen, indem Sie darauf klicken.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2.png" width="80%"></div>
                <p>Wenn mehrere archäologische Operationen dieselben Koordinaten haben, werden sie auf demselben Marker angezeigt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_3.png" width="80%"></div>
                <p>Wenn ein Gebiet schließlich eine große Anzahl archäologischer Operationen enthält, erscheint anstelle eines einzelnen Markers ein farbiger Kreis mit der Anzahl der in diesem Gebiet vorhandenen Operationen. Wenn Sie darauf klicken, können Sie hineinzoomen und den Marker in mehrere weitere Kreise und/oder einzelne Marker unterteilen. Es ist auch möglich, wie gewohnt zu zoomen.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2b.png" width="80%"></div>

            <h4>1.2. Liste der archäologischen Operationen</h4>
                <p>Durch Anklicken des entsprechenden Reiters können Sie auch auf eine Übersichtstabelle der archäologischen Operationen zugreifen.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_4.png" width="80%"></div>
                <p>Die Tabelle ist zunächst nach Ländern und anschließend nach Regionen geordnet. Die archäologischen Operationen werden alphabetisch nach ihrem Code angezeigt. Diejenigen, die keiner Region zugeordnet wurden, werden am Ende der Liste zusammengefasst. Durch Anklicken der Spaltenüberschriften kann die Tabelle nach der jeweiligen Spalte sortiert werden (zunächst aufsteigend alphabetisch, bei einem zweiten Klick absteigend).</p>
                <p>Es ist außerdem möglich, die Tabelle nach einem oder mehreren Feldern zu filtern. Die Filter werden durch Anklicken von „Tabellenfilter anzeigen“ eingeblendet. Anschließend genügt es, einen Teil des Inhalts eines Feldes einzugeben, um die Tabelle zu filtern.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
        </section>

        <section id="opération-archéologique" class="mb-5">
        <h3>2. Beschreibung der archäologischen Operation</h3>
            <p>Wenn Sie auf eine archäologische Operation klicken, gelangen Sie zu ihrer Beschreibungsseite. Diese Seite enthält Informationen über:</p>
            <ul>
                <li>die Person, die die Operation zu CeVICA hinzugefügt hat, sowie die Mitwirkenden, die die Seite ergänzen können;</li>
                <li>die geografischen Informationen: Region, Breitengrad und Längengrad;</li>
                <li>eine Beschreibung der archäologischen Operation, deren Länge und Aufbau variieren können;</li>
                <li>die verschiedenen vorhandenen Fundstellenhorizonte. Wenn Kontexte keinem Fundstellenhorizont zugeordnet wurden, können sie durch Anklicken von „Kontexte ohne Fundstellenhorizont“ aufgerufen werden;</li>
                <li>die mit der archäologischen Operation verknüpften bibliografischen Literaturangaben;</li>
                <li>die mit der archäologischen Operation verknüpften Dateien;</li>
                <li>die Informationen zur korrekten Zitierung der Seite.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
            <p>Je nachdem, was ergänzt oder mit der archäologischen Operation verknüpft wurde, können einige dieser Bereiche fehlen. Bei der Bibliografie wird ausdrücklich angegeben, wenn die archäologische Operation (oder der Fundstellenhorizont oder der Kontext) nie veröffentlicht wurde.</p>
            <p>Eine der automatisch vorhandenen Dateien ermöglicht den Download des gesamten Inventars der archäologischen Operation. Dasselbe gilt für den Fundstellenhorizont und den Kontext.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_6.png" width="80%"></div>
            <p>Je nachdem, welche Angaben bei der Erfassung der Fundstelle gemacht wurden, kann der Hintergrund unterschiedlich sein, und ein Rahmen kann darauf hinweisen, dass es sich um Daten aus einer Veröffentlichung handelt. Diese Informationen ermöglichen es, Fälle hervorzuheben, in denen der Verfasser des Datensatzes nicht zu den Forschenden gehört, die an der archäologischen Operation gearbeitet haben, sondern die Daten im Rahmen einer umfassenderen Arbeit zur Literaturauswertung online gestellt wurden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_7.png" width="80%"></div>
        </section>

        <section id="horizon-site" class="mb-5">
        <h3>3. Beschreibung des Fundstellenhorizonts</h3>
            <p>Wenn Sie auf einen der Fundstellenhorizonte klicken, öffnet sich ein neues Fenster mit folgenden Informationen:</p>
            <ul>
                <li>die archäologische Operation, zu der der Fundstellenhorizont gehört;</li>
                <li>die Person, die die Operation zu CeVICA hinzugefügt hat, sowie die Person, die den Fundstellenhorizont hinzugefügt hat;</li>
                <li>die Informationen zum regionalen Horizont, wenn der Fundstellenhorizont mit einem regionalen Horizont verknüpft ist;</li>
                <li>eine Beschreibung des Fundstellenhorizonts, deren Länge und Aufbau variieren können;</li>
                <li>die verschiedenen vorhandenen Kontexte;</li>
                <li>die mit dem Fundstellenhorizont verknüpften bibliografischen Literaturangaben (im Allgemeinen dieselben wie für die archäologische Operation, sofern der Verfasser des Datensatzes keine ausdrückliche Änderung vorgenommen hat);</li>
                <li>die mit dem Fundstellenhorizont verknüpften Dateien;</li>
                <li>die Informationen zur korrekten Zitierung der Seite.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_8.png" width="80%"></div>
            <p>Der regionale Horizont ist anklickbar. Die Bedeutung des Fundstellenhorizonts für die Definition des regionalen Horizonts wird angegeben (wesentlich, untergeordnet, unsicher oder unbekannt).</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_9.png" width="80%"></div>
        </section>

        <section id="contexte-inventaire" class="mb-5">
        <h3>4. Beschreibung des Kontexts und Inventar</h3>
            <p>Wenn Sie auf einen der Kontexte klicken, gelangen Sie zu dessen Ansicht mit dem Inventar. Die Informationen entsprechen im Wesentlichen denen der Phase, sofern solche vorhanden sind. Über einen Reiter kann zwischen der Beschreibung und dem Inventar gewechselt werden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_10.png" width="80%"></div>
            <p>Wenn keine Beschreibung vorhanden ist, wird das Inventar direkt und ohne Reiter angezeigt. Es kann über die blaue Schaltfläche exportiert werden, ebenso wie über den Bereich der zugehörigen Dateien.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11.png" width="80%"></div>
            <p>Durch Anklicken der Inventarnummer können die Details des Objekts und seine Abbildungen aufgerufen werden.</p>
            <p>Kategorien, Funktionen, Typen und Pastengruppen können in CeVICA erfasst sein. In diesem Fall werden Kategorie und Funktion schwarz, Typ und Pastengruppe blau angezeigt (sie können angeklickt werden, um die entsprechende Beschreibung aufzurufen). Wenn Sie den Mauszeiger über die Kategorie oder die Pastengruppe bewegen, wird die vollständige Bezeichnung angezeigt.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_12.png" width="80%"></div>
            <p>Wenn eines dieser Elemente in der Datenbank nicht vorhanden ist, wird es grau und in einer kleineren Schrift angezeigt.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13.png" width="80%"></div>
            <p>Die Tabelle kann durch Anklicken der Spaltenüberschriften sortiert werden. Es ist zu beachten, dass Kategorien, Funktionen, Typen und Pastengruppen anhand ihres Codes und nicht anhand der angezeigten Bezeichnung sortiert werden; nicht referenzierte Elemente werden am Ende der Sortierung alphabetisch geordnet.</p>
            <p>Die Tabelle kann außerdem gefiltert werden, indem Sie auf den Filterreiter klicken und anschließend die gewünschten Suchbegriffe eingeben. Kategorien, Funktionen und Typen können ebenfalls anhand ihres Codes gesucht werden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11b.png" width="80%"></div>
            <p>Das Vorhandensein einer Abbildung wird durch ein „Ja“ im entsprechenden Feld angezeigt.</p>
            <p>Standardmäßig werden aus Performancegründen nur die ersten 200 Inventarzeilen abgerufen. Weitere Zeilen können (jeweils 200) durch Anklicken von „Mehr laden“ abgerufen werden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13b.png" width="80%"></div>
        </section>

        <section id="objet-illustration" class="mb-5">
        <h3>5. Beschreibung des Objekts und Abbildung(en)</h3>
            <p>Wenn Sie auf das Objekt klicken, werden dieselben Informationen wie bei den Kontexten in Form einer Liste angezeigt.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_14.png" width="60%"></div>
            <p>Über einen Reiter können die Abbildungen aufgerufen werden, sofern für das Objekt welche vorhanden sind. Durch Anklicken können die Abbildungen in einer größeren Darstellung angezeigt werden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_15.png" width="80%"></div>
            <p>Nach dem Anzeigen der Abbildung kann durch Anklicken des Bereichs daneben oder des Kreuzes oben rechts zur Grundansicht zurückgekehrt werden.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_16.png" width="80%"></div>
        </section>
    </section>

    <section id="horizons-régionaux" class="mb-5">
    <h2>III. Regionale Horizonte</h2>
        <section id="liste-groupes-horizons" class="mb-5">
        <h3>1. Liste der Horizontgruppen</h3>
            <p>Die Liste der regionalen Horizonte ist über die obere Navigationsleiste zugänglich.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_17.png" width="80%"></div>
            <p>Die Liste ist zunächst nach Ländern und anschließend nach Regionen geordnet. Die Horizontgruppen werden alphabetisch nach ihrem Code angezeigt. Wenn sich eine Horizontgruppe über mehrere Regionen erstreckt, erscheint sie mehrmals. Horizontgruppen, die keiner Region zugeordnet wurden, werden am Ende der Liste zusammengefasst.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_18.png" width="50%"></div>
        </section>

        <section id="groupe-horizons" class="mb-5">
        <h3>2. Beschreibung der Horizontgruppe</h3>
            <p>Wenn Sie auf eine Horizontgruppe klicken, gelangen Sie zu ihrer Beschreibungsseite. Diese Seite enthält Informationen zu:</p>
            <ul>
                <li>der Person, die die Horizontgruppe zu CeVICA hinzugefügt hat, sowie den Mitwirkenden, die die Seite ergänzen können;</li>
                <li>den Regionen, die von den Horizonten betroffen sind;</li>
                <li>einer Beschreibung der Horizontgruppe, deren Länge und Gliederung variieren können;</li>
                <li>den verschiedenen vorhandenen regionalen Horizonten (von denen einige intern in Unterhorizonte unterteilt sein können);</li>
                <li>den zugehörigen bibliografischen Referenzen;</li>
                <li>den zugehörigen Dateien;</li>
                <li>den Angaben zur korrekten Zitierung der Seite.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_19.png" width="80%"></div>
            <p>Je nachdem, welche Informationen ergänzt oder mit der archäologischen Operation verknüpft wurden, können einige dieser Bereiche fehlen. Bei der Bibliografie wird ausdrücklich angegeben, wenn die archäologische Operation (oder der Fundstellenhorizont bzw. der Kontext) noch nie veröffentlicht wurde.</p>
        </section>

        <section id="horizon-régional" class="mb-5">
        <h3>3. Regionale Horizonte und zugehöriges Fundmaterial</h3>
            <p>Wenn Sie einen Horizont auswählen (ausgehend von der Gruppe, einer Phase oder einem Inventar), erhalten Sie Zugriff auf verschiedene Informationen und mehrere Registerkarten.</p>
            <p><b>Wichtig:</b> Wenn ein Horizont mehrere Unterhorizonte besitzt, beziehen sich die angezeigten Informationen ausschließlich auf den übergeordneten Horizont und nicht auf die Unterhorizonte.</p>

            <h4>3.1. Allgemeine Informationen</h4>
                <p>Hier finden Sie:</p>
                <ul>
                    <li>die Gruppe, zu der der regionale Horizont gehört;</li>
                    <li>die Person, die die Horizontgruppe zu CeVICA hinzugefügt hat, sowie diejenige, die den regionalen Horizont hinzugefügt hat;</li>
                    <li>die Anzahl der erfassten Objekte (Inventarzeilen) für diesen Horizont.</li>
                </ul>

            <h4>3.2. Beschreibung</h4>
                <p>Die Beschreibung umfasst:</p>
                <ul>
                    <li>eine Beschreibung des Horizonts, deren Länge und Gliederung variieren können;</li>
                    <li>gegebenenfalls die verschiedenen vorhandenen Unterhorizonte;</li>
                    <li>eine Datierung (ebenfalls in freier Form);</li>
                    <li>die Fundstellenhorizonte, aus denen sich der regionale Horizont zusammensetzt, sowie deren Bedeutung für den Horizont;</li>
                    <li>die zugehörigen Dateien;</li>
                    <li>die Angaben zur korrekten Zitierung der Seite.</li>
                </ul> 
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_20.png" width="80%"></div>

            <h4>3.3. Verteilung</h4>
                <p>Die Verteilung zeigt eine Karte der verschiedenen Fundstellenhorizonte, aus denen sich der regionale Horizont zusammensetzt. Wenn Sie auf einen Marker klicken, können Sie den oder die an diesem Ort vorhandenen Fundstellenhorizont(e) sowie die Anzahl der Objekte sehen, die zu diesem Fundstellenhorizont gehören.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_21.png" width="80%"></div>

            <h4>3.4. Typenliste</h4>
                <p>Eine sortierbare Tabelle führt alle innerhalb des Horizonts vorhandenen Typen auf, geordnet nach Kategorie. Die Anzahl der Vorkommen gibt die Anzahl der Inventarzeilen an, die für diesen Horizont diesem Typ entsprechen.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_22.png" width="80%"></div>
                <p>Die Tabelle kann sortiert werden. Dabei ist zu beachten, dass für Kategorien und Typen der Code und nicht die Abkürzung bzw. der Name für die Sortierung verwendet wird. Die Tabelle kann außerdem über das Filtermenü gefiltert werden, das durch Anklicken der entsprechenden Option eingeblendet werden kann.</p>

            <h4>3.5. Abbildungen</h4>
                <p>Diese Registerkarte enthält alle Abbildungen der im Horizont vorhandenen Objekte. Die Abbildungen können nach ihrem Typ sortiert werden.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_23.png" width="80%"></div>
                <p>Die Abbildungen können durch Anklicken vergrößert angezeigt werden. Sobald eine Abbildung angezeigt wird, können Sie durch einen Klick daneben oder auf das Kreuz oben rechts zur normalen Ansicht zurückkehren.</p>

            <h4>3.6. Inventar</h4>
                <p>Diese letzte Registerkarte enthält das vollständige Inventar des regionalen Horizonts. Sie funktioniert auf die gleiche Weise wie das Inventar des Kontexts und enthält zusätzlich die Codes der Fundstellen, Fundstellenhorizonte und Kontexte. Sie können auf diese Codes klicken, um zur entsprechenden Beschreibung zu gelangen, oder einfach mit der Maus darüberfahren, um deren Namen anzuzeigen.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_24.png" width="80%"></div>
                <p>Die Tabelle kann auf die gleiche Weise wie das Inventar des Kontexts sortiert und gefiltert werden und ist standardmäßig ebenfalls auf 200 Inventarzeilen begrenzt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_25.png" width="80%"></div>
                <p>Die Aspekte im Zusammenhang mit den veröffentlichten Bezeichnungen von Kategorien, Funktionen, Typen und Tongruppen, wenn diese von den in CeVICA verwendeten Bezeichnungen abweichen, werden später hinzugefügt (diese Funktion wird derzeit nicht verwendet).</p>
        </section>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>IV. Typen und Tongruppen</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologien und Typen</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Liste der Typologien</h4>
                <p>Die Liste der Typologien ist über die obere Navigationsleiste zugänglich.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_26.png" width="80%"></div>
                <p>Die Liste ist nach der Kategorie geordnet, der die jeweilige Typologie zugeordnet ist. Einige Typologien sind mehreren Kategorien zugeordnet und erscheinen daher bei jeder dieser Kategorien. Typologien, die keiner Kategorie zugeordnet wurden (und daher nicht zur Verknüpfung mit Objekten verwendet werden können), werden am Ende der Liste zusammengefasst.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Beschreibung der Typologie</h4>
                <p>Wenn Sie auf eine Typologie klicken, gelangen Sie zu ihrer Beschreibungsseite. Diese Seite enthält zunächst Informationen zu:</p>
                <ul>
                    <li>der Person, die die Typologie zu CeVICA hinzugefügt hat, sowie den Mitwirkenden, die die Seite ergänzen können;</li>
                    <li>einer Beschreibung der Typologie, deren Länge und Gliederung variieren können;</li>
                    <li>den mit der archäologischen Operation verknüpften bibliografischen Referenzen;</li>
                    <li>den mit der archäologischen Operation verknüpften Dateien;</li>
                    <li>den Angaben zur korrekten Zitierung der Seite.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>Die Registerkarte „Kategorien“ enthält eine Liste der Kategorien, für die die Typologie (und damit ihre Typen) verwendet werden kann.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>Die Registerkarte „Typen“ führt die der Kategorie zugeordneten Typen in alphabetischer Reihenfolge ihrer Codes auf. Wenn einige Typen Untertypen besitzen, werden diese hier nicht angezeigt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Die Typen und ihr zugehöriges Fundmaterial</h4>
                <p>Wenn Sie einen Typ auswählen (über eine Typologie oder ausgehend von einem Inventar), erhalten Sie Zugriff auf verschiedene Informationen und mehrere Registerkarten.</p>
                <p><b>Wichtig:</b> Wenn ein Typ mehrere Untertypen besitzt, beziehen sich die angezeigten Informationen ausschließlich auf den übergeordneten Typ und nicht auf die Untertypen.</p>

                <h5>1.3.1. Allgemeine Informationen</h5>
                    <p>Hier finden Sie:</p>
                    <ul>
                        <li>die Typologie, zu der der Typ gehört (und gegebenenfalls den übergeordneten Typ des Untertyps);</li>
                        <li>die Person, die die Typologie zu CeVICA hinzugefügt hat, sowie diejenige, die den Typ hinzugefügt hat;</li>
                        <li>die Anzahl der erfassten Objekte (Inventarzeilen) für diesen Typ.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_31.png" width="80%"></div>

                <h5>1.3.2. Verteilung</h5>
                    <p>Die Verteilung wird entweder anhand einer interaktiven Karte oder anhand einer Liste der archäologischen Operationen dargestellt, in denen dieser Typ vorkommt.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_32.png" width="80%"></div>
                    <p>Wie bei der Liste der archäologischen Operationen können Sie durch Anklicken eines Markers die archäologischen Operationen sowie die Anzahl der Inventarzeilen sehen, die diesem Typ zugeordnet wurden.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_33.png" width="80%"></div>
                    <p>Die Liste der archäologischen Operationen wird in Form einer Tabelle mit denselben Daten dargestellt. Es ist möglich, auf die archäologische Operation oder auf das kombinierte Inventar der archäologischen Operation und des Typs zuzugreifen (durch Anklicken von „anzeigen“).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_34.png" width="80%"></div>
                    <p>Die Tabelle kann ebenfalls sortiert und gefiltert werden.</p>

                <h5>1.3.3. Beschreibung</h5>
                    <p>Die Beschreibung umfasst:</p>
                    <ul>
                        <li>eine Beschreibung des Typs, deren Länge und Gliederung variieren können;</li>
                        <li>gegebenenfalls die verschiedenen vorhandenen Untertypen;</li>
                        <li>eine Datierung (ebenfalls in freier Form);</li>
                        <li>die Bibliografie;</li>
                        <li>die Angaben zur korrekten Zitierung der Seite.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_35.png" width="80%"></div>

                <h5>1.3.4. Abbildungen</h5>
                    <p>Diese Registerkarte enthält alle Abbildungen der Objekte dieses Typs. Die Abbildungen können nach der Art der Abbildung sortiert werden.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_36.png" width="80%"></div>
                    <p>Die Abbildungen können durch Anklicken vergrößert angezeigt werden. Sobald eine Abbildung angezeigt wird, können Sie durch einen Klick daneben oder auf das Kreuz oben rechts zur normalen Ansicht zurückkehren.</p>

                <h5>1.3.5. Tongruppen</h5>
                    <p>Diese Registerkarte führt die für diesen Typ erfassten Tongruppen auf. Sie können die jeweilige Tongruppe aufrufen oder das Inventar der Objekte anzeigen, die dem ausgewählten Typ und der ausgewählten Tongruppe entsprechen.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_37.png" width="80%"></div>

                <h5>1.3.6. Inventar</h5>
                    <p>Diese letzte Registerkarte enthält das vollständige Inventar des Typs. Sie funktioniert auf die gleiche Weise wie das Inventar des Kontexts und enthält zusätzlich die Codes der Fundstellen, Fundstellenhorizonte und Kontexte. Sie können auf diese Codes klicken, um zur entsprechenden Beschreibung zu gelangen, oder einfach mit der Maus darüberfahren, um deren Namen anzuzeigen.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_38.png" width="80%"></div>
                    <p>Die Tabelle kann auf die gleiche Weise wie das Inventar des Kontexts sortiert und gefiltert werden und ist standardmäßig ebenfalls auf 200 Inventarzeilen begrenzt.</p>

                <h5>1.3.7. Entsprechungen</h5>
                    <p>Diese Registerkarte, die sich auf die veröffentlichten Bezeichnungen der Typen bezieht, wenn diese von den in CeVICA verwendeten Bezeichnungen abweichen, wird später beschrieben (diese Funktion wird derzeit nicht verwendet).</p>
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Tongruppen</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Liste der Tongruppen</h4>
                <p>Die Liste der Tongruppen ist über das obere Menü erreichbar.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_40.png" width="80%"></div>
                <p>Die Liste ist derzeit nicht sortiert. Wenn einige Tongruppen Untergruppen haben, werden diese hier nicht angezeigt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Tongruppen und die mit ihnen verknüpften Objekte</h4>
                <p>Wenn Sie eine Tongruppe auswählen (über die Liste der Tongruppen oder aus einem Inventar), erhalten Sie Zugriff auf verschiedene Informationen und mehrere Registerkarten.</p>
                <p><b>Wichtig:</b> Wenn eine Tongruppe mehrere Untergruppen hat, beziehen sich die vorhandenen Informationen ausschließlich auf die übergeordnete Tongruppe und nicht auf die Untergruppen.</p>

                <h5>2.2.1. Allgemeine Informationen</h5>
                    <p>Hier finden sich:</p>
                    <ul>
                        <li>gegebenenfalls die übergeordnete Gruppe der Untergruppe;</li>
                        <li>die Person, die die Tongruppe zu CeVICA hinzugefügt hat;</li>
                        <li>die Anzahl der erfassten Objekte (Inventarzeilen) für diese Tongruppe.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_42.png" width="70%"></div>

                <h5>2.2.2. Verteilung</h5>
                    <p>Die Verteilung wird entweder anhand einer interaktiven Karte oder anhand der Liste der archäologischen Operationen dargestellt, in denen diese Tongruppe vorkommt.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_43.png" width="80%"></div>
                    <p>Wie bei der Liste der archäologischen Operationen können Sie durch Anklicken eines Markers die archäologischen Operationen sowie die Anzahl der Inventarzeilen sehen, die dieser Tongruppe zugeordnet sind.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_44.png" width="80%"></div>
                    <p>Die Liste der archäologischen Operationen wird als Tabelle mit denselben Daten dargestellt. Sie können auf die archäologische Operation oder auf das kombinierte Inventar der archäologischen Operation und der Tongruppe zugreifen (durch Anklicken von « anzeigen »).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_45.png" width="80%"></div>
                    <p>Die Tabelle kann ebenfalls sortiert und gefiltert werden.</p>

                <h5>2.2.3. Beschreibung</h5>
                    <p>Die Beschreibung umfasst:</p>
                    <ul>
                        <li>eine Beschreibung der Tongruppe, deren Länge und Gliederung variieren können;</li>
                        <li>gegebenenfalls die verschiedenen vorhandenen Untergruppen;</li>
                        <li>eine Herkunftsangabe (ebenfalls in freier Form);</li>
                        <li>die Bibliografie;</li>
                        <li>die Angaben für die korrekte Zitierung der Seite.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_46.png" width="80%"></div>

                <h5>2.2.4. Abbildungen</h5>
                    <p>Diese Registerkarte enthält alle Abbildungen der Objekte dieser Tongruppe. Sie können nach der Art der Abbildung sortiert werden.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_47.png" width="80%"></div>
                    <p>Durch Anklicken können die Abbildungen vergrößert angezeigt werden. Nach der Anzeige der Abbildung können Sie zur normalen Ansicht zurückkehren, indem Sie daneben oder auf das Kreuz oben rechts klicken.</p>

                <h5>2.2.5. Typen</h5>
                    <p>Diese Registerkarte listet die für diese Tongruppe erfassten Typen auf. Sie können den jeweiligen Typ oder das Inventar der Objekte einsehen, die dem ausgewählten Typ und der ausgewählten Tongruppe entsprechen.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_48.png" width="80%"></div>

                <h5>2.2.6. Inventar</h5>
                    <p>Diese letzte Registerkarte zeigt das vollständige Inventar der Tongruppe. Es funktioniert auf dieselbe Weise wie das Inventar eines Kontexts, zusätzlich werden jedoch die Codes der Fundstellen, Fundstellenhorizonte und Kontexte angezeigt. Sie können auf diese Codes klicken, um den entsprechenden Eintrag aufzurufen, oder einfach mit der Maus darüberfahren, um den Namen anzuzeigen.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_49.png" width="80%"></div>
                    <p>Die Tabelle kann auf dieselbe Weise wie das Kontextinventar sortiert und gefiltert werden und ist standardmäßig ebenfalls auf 200 Inventarzeilen begrenzt.</p>

                <h5>2.2.7. Entsprechungen</h5>
                    <p>Diese Registerkarte, die sich auf die veröffentlichten Bezeichnungen der Tongruppen bezieht, wenn diese von den Bezeichnungen in CeVICA abweichen, wird später beschrieben (es handelt sich derzeit um eine nicht verwendete Funktion).</p>
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>V. Bibliografie</h2>
        <p>Wie an anderer Stelle erwähnt, können für verschiedene Elemente bibliografische Referenzen angegeben werden: archäologische Operation, Fundstellenhorizont, Kontext, regionaler Horizont, Typologie, Typ oder Tongruppe. Diese Funktion ist eher einfach gehalten, die Referenzen können jedoch in CeVICA eingesehen werden.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Liste der bibliografischen Referenzen</h3>
            <p>Die Liste der bibliografischen Referenzen ist über das obere Menü erreichbar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>Sie ist alphabetisch nach den Abkürzungen sortiert.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Eine Referenz einsehen</h3>
            <p>Sie können eine Referenz einsehen, indem Sie dort darauf klicken, wo sie angezeigt wird. Sie können dann die vollständige Referenz sowie die damit verknüpften Elemente der Datenbank einsehen.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In einigen Fällen wurde eine Seitenzahl angegeben. Diese ist sowohl auf der Seite des Elements als auch auf der Seite der Referenz verfügbar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>VI. Weitere Elemente</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Liste der herunterladbaren Dateien</h3>
            <p>Eine Liste der herunterladbaren Dateien ist über das obere Menü erreichbar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Hier können Dateien heruntergeladen werden, die nicht mit einem bestimmten Element (archäologische Operation, Fundstellenhorizont, Kontext, regionaler Horizont …) verknüpft sind, sondern einen allgemeinen Charakter haben und als nützlich für die Weitergabe erachtet wurden. Der Download erfolgt einfach durch Anklicken der jeweiligen Datei.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Eine Seite zitieren</h3>
            <p>Unter jeder Seite, auf der ein Element der Datenbank beschrieben wird, wird ein Zitationsvorschlag bereitgestellt, um dieses Element in der Bibliografie zu referenzieren. Zahlreiche Beispiele finden sich an anderer Stelle in diesem Tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informationen zur Website</h3>
            <p>Diese Informationen sind hauptsächlich über « Support und Informationen » im oberen Menü verfügbar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Diese Registerkarten enthalten:</p>
            <ul>
                <li>Eine ausführlichere Vorstellung von CeVICA unter « Vorstellung und Kontakt »;</li>
                <li>Ein Kontaktformular für den Administrator in derselben Registerkarte;</li>
                <li>Die Liste der verfügbaren Tutorials unter « Hilfe zur Nutzung von CeVICA »;</li>
                <li>Die Infrastruktur, in die CeVICA eingebettet ist, unter « Verwandte Werkzeuge »: ergänzende Entwicklungen (wie ONICer und DBCer sowie das von CeVICA verwendete Werkzeug LOGACer), aber auch empfohlene Werkzeuge, die ergänzend zu den von den Universitäten Lüttich und Lille entwickelten Werkzeugen eingesetzt werden können.</li>
            </ul>
            <p>Weitere Seiten sind am unteren Rand jeder Seite zugänglich:</p>
            <ul>
                <li>Das Impressum und die Datenschutzrichtlinie, die für jede Website erforderlich sind;</li>
                <li>Durch Anklicken des LOGACer-Logos kann eine Beschreibung der Software aufgerufen werden.</li>
            </ul>
        </section>

        <section id="recherche-simple" class="mb-5">
        <h3>4. Suchen</h3>
            <p>Derzeit ist das Suchwerkzeug noch recht einfach und besteht aus einer einfachen Suchleiste, die durch Anklicken der Lupe rechts im oberen Menü aufgerufen werden kann.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_58.png" width="80%"></div>
            <p>Anschließend können Sie beschreibende Angaben zu einem Elementtyp eingeben und diesen aus den bereits vorgeschlagenen Elementtypen auswählen.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_59.png" width="60%"></div>
            <p>Schließlich wird eine Liste oder Tabelle mit den entsprechenden Elementen angezeigt.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_60.png" width="80%"></div>
        </section>

        <section id="enregistrement-connexion" class="mb-5">
        <h3>5. Registrieren und anmelden</h3>
            <p>Die Registrierung und Anmeldung werden später beschrieben, sobald die Werkzeuge für die Zusammenarbeit vollständig funktionsfähig sind.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
