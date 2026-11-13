<?php $return_list = "<p><a href='" . create_url(['']) . "'>Retourner à la page d'accueil</a></p>";
$tuto_button = ""; ?>
    <!-- Seitenleiste -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['']); ?>'>Zurück zur Startseite</a></h6><br>
        <h4 class="px-3">Grundprinzipien und Navigation</h4>
        <a href="#principes-base"><h5 class="px-3">I. Grundprinzipien</h5></a>
        <a href="#navigation-generale"><h5 class="px-3">II. Allgemeine Navigation</h5></a>
            <a href="#projets">1. Projekte</a>
            <a href="#typologies-globales">2. Typologien und Warengruppen</a>
            <a href="#espace-personnel">3. Persönlicher Bereich</a>
            <a href="#referentiels">4. Referenzverzeichnisse</a>
            <a href="#gestion-utilisateurs">5. Benutzerverwaltung</a>
        <a href="#types-pâtes"><h5 class="px-3">III. Typen und Warengruppen</h5></a>
            <a href="#typologies-types">1. Typologien und Typen</a>
            <ul>
                <li><a href="#liste-typologies">Liste der Typologien</a></li>
                <li><a href="#typologie">Beschreibung der Typologie</a></li>
                <li><a href="#types">Beschreibung der Typen</a></li>
            </ul>
            <a href="#pâtes">2. Warengruppen</a>
            <ul>
                <li><a href="#liste-groupes-pâtes">Liste der Warengruppen</a></li>
                <li><a href="#groupes-pâtes">Beschreibung der Warengruppen</a></li>
            </ul>
        <a href="#bibliographie"><h5 class="px-3">IV. Bibliographie</h5></a>
            <a href="#liste-bibliographie">1. Liste der Literaturangaben</a>
            <a href="#consulter-bibliographie">2. Eine Literaturangabe aufrufen</a>
        <a href="#autres-éléments"><h5 class="px-3">V. Weitere Elemente</h5></a>
            <a href="#fichiers-génériques">1. Allgemeine Dateien</a>
            <a href="#citer-page">2. Eine Seite zitieren</a>
            <a href="#a-propos">3. Informationen zur Website</a>
        <a href="#compte-utilisateur"><h5 class="px-3">VI. Benutzerkonten</h5></a>
            <a href="#enregistrement-connexion">1. Registrierung und Anmeldung</a>
            <a href="#gestion-compte">2. Kontoverwaltung</a>
    </nav>

  <!-- Hauptinhalt -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: Grundprinzipien und Navigation im Tool ohne Anmeldung</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Grundprinzipien</h2>

    <p>Das Hauptziel von LOGACer besteht darin, Objektinventare (insbesondere Keramikobjekte) zugänglich zu machen und gleichzeitig die Einbindung zusätzlicher Informationen sowie die Durchführung von Abfragen zu diesen Objekten zu ermöglichen. Zu diesem Zweck basiert LOGACer auf verschiedenen Elementen:</p>
    <ul>
        <li>Die Kontextualisierung des <b>Objekts</b>: Sie bildet den zentralen Bestandteil von LOGACer. Ein Objekt gehört zu einem <b>Kontext</b> (oder einer stratigraphischen Einheit), der wiederum mit anderen zeitgleichen Kontexten verbunden ist (dem <b>Fundstellenhorizont</b>). Alle diese Elemente wurden im Rahmen einer <b>archäologischen Maßnahme</b> geborgen;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>Die relative Chronologie des Objekts: Fundstellenhorizonte können zu <b>regionalen Horizonten</b> zusammengefasst werden. Diese folgen innerhalb einer geografischen Region aufeinander; ihre Abfolge wird mithilfe von <b>Horizontgruppen</b> strukturiert;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>
        <li>Die Charakterisierung des Objekts: Keramik wird nach dem in LOGACer verwendeten Modell anhand ihrer <b>Kategorie</b>, <b>Funktion</b>, ihres <b>Typs</b> und ihrer <b>Warengruppe</b> klassifiziert. Die ersten beiden Klassifikationskriterien sind relativ standardisiert und in ihrer Anzahl begrenzt. Die Typen hingegen sind wesentlich zahlreicher und werden in <b>Typologien</b> zusammengefasst. Dasselbe gilt für die Warengruppen, die hierarchisch gegliedert werden können. Die Charakterisierung der Typen und Warengruppen sowie die Möglichkeit, nach ihnen zu suchen, sind ebenfalls wichtige Funktionen. Kategorien, Funktionen, Typologien und Typen stehen in engem Zusammenhang mit ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>
        <li>Referenzen: Die Charakterisierung dieser verschiedenen Elemente kann durch bibliografische <b>Literaturangaben</b> oder durch das Hinzufügen von <b>Dateien</b> ergänzt werden. Darüber hinaus werden diese Elemente von <b>Benutzern</b> verwaltet (die in bestimmten Fällen als Verantwortliche oder Mitwirkende fungieren). Schließlich können die Objekte durch <b>Abbildungen</b> wie Zeichnungen, Fotografien oder Vergrößerungen ergänzt werden;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>
        <li>Zusammenarbeit: Teams, die an verschiedenen Elementen (Fundstellen, regionalen Horizonten usw.) arbeiten, können diese innerhalb von <b>Projekten</b> zusammenführen. Dadurch lässt sich die Verwaltung der Zugriffsrechte des Teams verbessern.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>
   </section>

    <section id="navigation-generale" class="mb-5">
    <h2>II. Allgemeine Navigation</h2>
    <p>Zusätzlich zu den projektbezogenen Bereichen verfügt LOGACer über einen allgemeinen Bereich, in dem verfügbare Projekte eingesehen, gemeinsame Referenzverzeichnisse aufgerufen und Elemente verwaltet werden können, die die gesamte Installation betreffen.</p>
    <p>Die Navigation ist in zwei Leisten unterteilt:</p>
    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_1.png" width="80%"></div>-->
        <h3>1. Allgemeine Navigationsleiste</h3>
        <p>Über die obere Leiste sind die wichtigsten Ressourcen zugänglich, die für die gesamte LOGACer-Installation gemeinsam genutzt werden.</p>
            <h4>1.1. Projekte</h4>
            <p>Der Bereich „Projekte“ enthält eine Liste der verfügbaren Projekte, jeweils mit einer kurzen Beschreibung und einem Link zum entsprechenden Projektbereich.</p>
            <p>Öffentliche Projekte sind für alle Besucher zugänglich, unabhängig davon, ob sie über ein Benutzerkonto verfügen. Private Projekte werden in dieser Liste nicht angezeigt, außer für Benutzer, die daran mitarbeiten.</p>
            <h4>1.2. Typologien und Warengruppen</h4>
            <p>Die Bereiche „Typologien“ und „Warengruppen“ ermöglichen den Zugriff auf die allgemeinen, von den einzelnen Projekten unabhängigen Referenzverzeichnisse von LOGACer.</p>
            <p>Die Beschreibungsseiten der Typologien und Warengruppen funktionieren ähnlich wie die entsprechenden Seiten innerhalb der Projekte. Informationen zu archäologischen Objekten sind über diesen allgemeinen Bereich jedoch nicht zugänglich. Insbesondere enthalten die Seiten zu den Typen und Warengruppen keine geografischen Verteilungen, Abbildungen, zugehörigen Warengruppen oder Typen, Inventare und Entsprechungen, die innerhalb der Projekte verfügbar sind.</p>
            <h4>1.3. Anhänge</h4>
            <p>Der Bereich „Anhänge“ bietet Zugriff auf zwei gemeinsame Ressourcen:</p>
            <ul>
                <li><b>Bibliographie:</b> Liste der in LOGACer gespeicherten Literaturangaben. Informationen zum Aufrufen dieser Angaben finden sich in Abschnitt IV. Bibliographie;</li>
                <li><b>Allgemeine Dateien:</b> Liste der Dateien, die unabhängig von einem bestimmten Element der Datenbank zur Verfügung gestellt werden. Informationen zum Aufrufen dieser Dateien finden sich in Abschnitt V. Weitere Elemente.</li>
            </ul>
        <h3>2. Persönlicher Bereich</h3>
        <p>Die zweite Navigationsleiste bietet Zugriff auf Funktionen, die mit dem Benutzerkonto und den eigenen Beiträgen des Benutzers in LOGACer zusammenhängen.</p>
            <h4>2.1. Mein persönlicher Bereich</h4>
            <p>Dieser Bereich bündelt verschiedene Informationen und Funktionen zum Benutzerkonto. Die wichtigsten Funktionen sind auch über andere Seiten der Anwendung zugänglich.</p>
            <h4>2.2. Meine Projekte, meine Typen und meine Warengruppen</h4>
            <p>Über diese Bereiche können die Projekte, Typen und Warengruppen aufgerufen werden, an denen der Benutzer als Ersteller, Verantwortlicher oder Mitwirkender beteiligt ist.</p>
            <p>Sie ermöglichen somit einen direkten Zugriff auf die Elemente, mit denen der Benutzer verbunden ist, ohne die allgemeinen Listen von LOGACer durchsuchen zu müssen.</p>
            <h4>2.3. Referenzverzeichnisse</h4>
            <p>Der Bereich „Referenzverzeichnisse“ bündelt die in LOGACer verwendeten Referenzlisten:</p>
            <ul>
                <li><b>Länder und Regionen:</b> Liste der Länder und ihrer regionalen Untergliederungen mit den offiziellen Codes und Bezeichnungen;</li>
                <li><b>Kategorien:</b> Liste der zur Charakterisierung von Objekten verwendeten Kategorien. Die Tabelle enthält den Code, die Abkürzung, die Bezeichnung, gegebenenfalls die Angabe zur Aufnahme in ONICer sowie den Ersteller in LOGACer;</li>
                <li><b>Funktionen:</b> Liste der zur Charakterisierung von Objekten verwendeten Funktionen. Die Tabelle enthält den Code, die Bezeichnung, gegebenenfalls die Angabe zur Aufnahme in ONICer sowie den Ersteller in LOGACer;</li>
                <li><b>Zählmethoden:</b> Liste der in LOGACer berücksichtigten Zählmethoden.</li>
            </ul>
            <p>Mitwirkende und Administratoren können die allgemeinen Referenzverzeichnisse erstellen und verwalten (mit Ausnahme der Zählmethoden). Normale Benutzer haben lediglich Zugriff auf die übrigen Funktionen, für die sie eine Berechtigung besitzen.</p>
            <h4>2.4. Benutzer verwalten</h4>
            <p>Dieser Bereich ist den Administratoren von LOGACer vorbehalten. Er ermöglicht Folgendes:</p>
            <ul>
                <li>Neue Registrierungen freizuschalten;</li>
                <li>Die Liste der registrierten Benutzer einzusehen;</li>
                <li>Die allgemeinen Benutzerrechte in LOGACer zu ändern, indem ihnen der Status Administrator, Mitwirkender oder normaler Benutzer zugewiesen wird;</li>
                <li>Ein Benutzerkonto bei Bedarf zu löschen.</li>
            </ul>
            <p>Diese allgemeinen Rechte sind von den Rechten zu unterscheiden, die Benutzern innerhalb der einzelnen Projekte zugewiesen werden.</p>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>III. Typen und Warengruppen</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologien und Typen</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Liste der Typologien</h4>
                <p>Die Liste ist nach den Kategorien geordnet, denen die jeweilige Typologie zugeordnet ist. Einige Typologien sind mehreren Kategorien zugeordnet und erscheinen daher unter jeder dieser Kategorien. Typologien, die keiner Kategorie zugeordnet wurden (und somit nicht zur Verknüpfung mit Objekten verwendet werden können), werden am Ende der Liste zusammengefasst.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Beschreibung der Typologie</h4>
                <p>Wenn Sie auf eine Typologie klicken, gelangen Sie zu ihrer Beschreibungsseite. Diese enthält zunächst folgende Informationen:</p>
                <ul>
                    <li>Die Person, die die Typologie zu LOGACer hinzugefügt hat, sowie die Mitwirkenden, die die Seite ergänzen können;</li>
                    <li>Eine Beschreibung der Typologie, deren Umfang und Aufbau variieren können;</li>
                    <li>Die mit der Typologie verknüpften Literaturangaben;</li>
                    <li>Die der Typologie zugeordneten Dateien;</li>
                    <li>Informationen zur korrekten Zitierung der Seite.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>Der Reiter „Kategorien“ enthält eine Liste der Kategorien, für die die Typologie (und somit ihre Typen) verwendet werden kann.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>Der Reiter „Typen“ listet die der Typologie zugeordneten Typen in alphabetischer Reihenfolge ihrer Codes auf. Falls bestimmte Typen Untertypen besitzen, werden diese hier nicht angezeigt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Die Typen</h4>
                <p>Wenn Sie einen Typ über eine Typologie auswählen, haben Sie im Gegensatz zur Navigation innerhalb eines Projekts nur Zugriff auf die allgemeinen Informationen:</p>
                    <ul>
                        <li>Die Typologie, zu der der Typ gehört (und gegebenenfalls der übergeordnete Typ des Untertyps);</li>
                        <li>Die Person, die die Typologie zu LOGACer hinzugefügt hat, sowie die Person, die den Typ hinzugefügt hat;</li>
                        <li>Eine Beschreibung des Typs, deren Umfang und Aufbau variieren können;</li>
                        <li>Gegebenenfalls die vorhandenen Untertypen;</li>
                        <li>Eine Datierung (auch in freier Textform);</li>
                        <li>Die Bibliographie;</li>
                        <li>Informationen zur korrekten Zitierung der Seite.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_2.png" width="80%"></div>-->
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Warengruppen</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Liste der Warengruppen</h4>
                <p>Die Liste ist derzeit nicht sortiert. Falls bestimmte Warengruppen Untergruppen besitzen, werden diese hier nicht angezeigt.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Die Warengruppen</h4>
                <p>Wenn Sie eine Warengruppe auswählen (über die Gruppenliste oder aus einem Inventar heraus), erhalten Sie Zugriff auf verschiedene allgemeine Informationen:</p>
                    <ul>
                        <li>Gegebenenfalls die übergeordnete Gruppe der Untergruppe;</li>
                        <li>Die Person, die die Warengruppe zu LOGACer hinzugefügt hat;</li>
                        <li>Eine Beschreibung der Warengruppe, deren Umfang und Aufbau variieren können;</li>
                        <li>Gegebenenfalls die vorhandenen Untergruppen;</li>
                        <li>Eine Herkunftsangabe (auch in freier Textform);</li>
                        <li>Die Bibliographie;</li>
                        <li>Informationen zur korrekten Zitierung der Seite.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_3.png" width="80%"></div>-->
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>IV. Bibliographie</h2>
        <p>Wie an anderer Stelle erwähnt, können für verschiedene Elemente bibliografische Literaturangaben hinterlegt werden: archäologische Maßnahme, Fundstellenhorizont, Kontext, regionaler Horizont, Typologie, Typ oder Warengruppe. Die entsprechende Funktionalität ist relativ einfach gehalten, die Literaturangaben können jedoch in LOGACer eingesehen werden.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Liste der Literaturangaben</h3>
            <p>Die Liste der Literaturangaben ist über die obere Navigationsleiste zugänglich.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>Sie ist alphabetisch nach Abkürzungen sortiert.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Eine Literaturangabe aufrufen</h3>
            <p>Sie können eine Literaturangabe aufrufen, indem Sie an der Stelle, an der sie angezeigt wird, darauf klicken. Dadurch werden die vollständige Literaturangabe sowie die damit verknüpften Datenbankelemente angezeigt.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In einigen Fällen wurde eine Seitenzahl angegeben. Diese ist sowohl auf der Seite des betreffenden Elements als auch auf der Seite der Literaturangabe verfügbar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>V. Weitere Elemente</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Liste der herunterladbaren Dateien</h3>
            <p>Eine Liste der herunterladbaren Dateien ist über die obere Navigationsleiste zugänglich.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Es handelt sich um Dateien, die keinem bestimmten Element (archäologische Maßnahme, Fundstellenhorizont, Kontext, regionaler Horizont usw.) zugeordnet sind, sondern allgemeiner Natur sind und als sinnvoll für die gemeinsame Nutzung erachtet wurden. Zum Herunterladen genügt ein Klick auf die jeweilige Datei.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Eine Seite zitieren</h3>
            <p>Auf jeder Seite, die ein Element der Datenbank beschreibt, wird ein Zitiervorschlag bereitgestellt, mit dem dieses Element in der Bibliographie referenziert werden kann. Zahlreiche Beispiele finden sich an anderen Stellen dieses Tutorials.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informationen zur Website</h3>
            <p>Diese Informationen sind hauptsächlich über den Menüpunkt „Support und Informationen“ in der oberen Navigationsleiste zugänglich.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Diese Reiter enthalten:</p>
            <ul>
                <li>Eine ausführlichere Vorstellung von LOGACer unter „Präsentation und Kontakte“;</li>
                <li>Ein Kontaktformular für den Administrator im selben Reiter;</li>
                <li>Informationen zur Infrastruktur, in die LOGACer eingebunden ist, unter „Zugehörige Tools“, insbesondere zu ergänzenden Entwicklungen wie ONICer und DBCer.</li>
            </ul>
            <p>Weitere Seiten sind am unteren Rand jeder Seite zugänglich:</p>
            <ul>
                <li>Die rechtlichen Hinweise und die Richtlinie zur Datenverwaltung, die für jede Website erforderlich sind;</li>
            </ul>
        </section>

    <section id="compte-utilisateur" class="mb-5">
    <h2>VI. Benutzerkonten</h2>
        <section id="enregistrement-connexion" class="mb-5">
        <h3>1. Registrierung und Anmeldung</h3>
            <h4>1.1. Ein Konto erstellen</h4>
            <p>Um auf die Funktionen zugreifen zu können, die registrierten Benutzern vorbehalten sind, benötigen Sie ein LOGACer-Konto. Die Anmeldung ist über die allgemeine Navigationsleiste durch Anklicken von „Anmelden“ möglich.</p>
            <p>Auf der Anmeldeseite können neue Benutzer über den Link „Hier registrieren!“ das Registrierungsformular aufrufen.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_4.png" width="80%"></div>-->
            <p>Im Registrierungsformular werden folgende Angaben abgefragt:</p>
            <ul>
                <li>Ein Benutzername;</li>
                <li>Eine E-Mail-Adresse;</li>
                <li>Ein Passwort, das bestätigt werden muss;</li>
                <li>Vorname und Nachname (optional).</li>
            </ul>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_5.png" width="80%"></div>-->
            <p>Nach dem Absenden des Formulars muss das Konto von einem LOGACer-Administrator freigeschaltet werden, bevor es verwendet werden kann. Der Benutzer wird per E-Mail über die Freischaltung informiert. Denken Sie daran, Ihren Spam-Ordner zu überprüfen. Sollte sich die Freischaltung verzögern, können Sie den Administrator der Installation kontaktieren.</p>
            <h4>1.2. Erste Anmeldung</h4>
            <p>Nach der Freischaltung des Kontos enthält eine E-Mail die für dessen Aktivierung erforderlichen Informationen.</p>
            <p>Bei der ersten Anmeldung muss anstelle des bei der Registrierung festgelegten Passworts der per E-Mail erhaltene Aktivierungsschlüssel verwendet werden.</p>
            <p>Nach dieser ersten Anmeldung kann der Benutzer auf die LOGACer-Funktionen zugreifen, die seinen Berechtigungen entsprechen.</p>
            <p>Wenn Sie mehrmals ein falsches Passwort eingeben, wird Ihr Konto gesperrt. In diesem Fall müssen Sie den Administrator kontaktieren, um Ihr Konto entsperren zu lassen. Anschließend können Sie sich mit einem neuen Aktivierungsschlüssel anmelden und ein neues Passwort festlegen.</p>
            </section>

        <section id="gestion-compte" class="mb-5">
        <h3>2. Kontoverwaltung</h3>
        <p>Wenn ein Benutzer angemeldet ist, wird sein Name in der Navigationsleiste angezeigt. Über ein Dropdown-Menü kann er unter anderem seine Kontoeinstellungen aufrufen und sich abmelden.</p>
            <h4>2.1. Mein Konto</h4>
            <p>Im Bereich „Mein Konto“ können die persönlichen Angaben eingesehen und geändert werden:</p>
            <ul>
                <li>Benutzername;</li>
                <li>E-Mail-Adresse;</li>
                <li>Passwort;</li>
                <li>Vorname und Nachname.</li>
            </ul>
            <p>Um das Passwort zu ändern, muss das neue Passwort eingegeben und bestätigt werden. Wird kein neues Passwort angegeben, bleibt das aktuelle Passwort bestehen.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_6.png" width="80%"></div>-->
            <p>Auf dieser Seite können außerdem bestimmte Anzeigeeinstellungen angepasst werden:</p>
            <ul>
                <li><b>Zählmethoden:</b> Auswahl der Zählmethoden, die in den Inventaren angezeigt werden sollen, aus denjenigen, die in den eingesehenen Daten verwendet werden;</li>
                <li><b>Vereinfachter Modus:</b> Aktivierung einer Anzeige mit kontextbezogenen Hilfen, insbesondere in Form von Tooltipps, um das Verständnis und die Nutzung von LOGACer zu erleichtern.</li>
            </ul>
            <p>Die Änderungen müssen gespeichert werden, damit sie wirksam werden.</p>
            <h4>2.2. Abmelden</h4>
            <p>Um die Sitzung zu beenden, wählen Sie einfach im Dropdown-Menü neben Ihrem Namen in der Navigationsleiste den Eintrag „Abmelden“ aus.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
