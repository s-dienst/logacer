        <h2>LOGACer: ein Open-Source-Werkzeug zur Verwaltung und Analyse archäologischer Funde</h2>
        <br>
        <p>Die <b>Logiciel Online pour la Gestion et l'Analyse de la Céramique</b> (Online-Software zur Verwaltung und Analyse von Keramik) wurde unter dem Namen DBCer im Rahmen der Dissertation « Étude chronologique, économique et culturelle de la vaisselle du <i>Piano della Civita</i> à Artena (Latium) depuis la République romaine jusqu’à l’Antiquité tardive » (S. Dienst, 2024 – verfügbar auf <a href="https://hdl.handle.net/2268/318966">ORBi</a>) entwickelt. Ihr ursprüngliches Ziel bestand darin, die Daten dieser Forschung in einem für die wissenschaftliche Gemeinschaft vollständig nutzbaren Format zu strukturieren und bereitzustellen, im Sinne von Open Science und Open Access.</p>
        <p>Die Klassifizierung und Bereitstellung archäologischer Daten stellt eine wichtige Herausforderung dar. LOGACer ermöglicht nicht nur die gemeinsame Nutzung dieser Daten, sondern auch die Verknüpfung von Informationen verschiedener Forschungsteams, die an einer gemeinsamen Fragestellung arbeiten. Wir möchten dieses Werkzeug daher allen Forschenden zugänglich machen, die ihre Daten zum <i>instrumentum</i>, insbesondere zu Keramik und Glas, teilen möchten.</p>
        <br>

        <h2>Grundsätze der Umsetzung</h2>
        <br>
        <p>LOGACer basiert auf den folgenden Grundprinzipien:</p>
        <ul style="text-align:left;">
            <li><b>Zusammenarbeit und Begutachtung:</b> Die Software fördert die Zusammenarbeit zwischen Forschenden an gemeinsamen Projekten. In einer späteren Version wird sie es den Nutzern außerdem ermöglichen, Daten zu kommentieren und gegebenenfalls Korrekturen an von anderen veröffentlichten Daten vorzuschlagen.</li>
            <li><b>Datenschutz:</b> Obwohl LOGACer die gemeinsame Nutzung von Daten im Sinne von Open Access fördert, berücksichtigt die Software das Bedürfnis der Nutzer, ihre Daten privat zu halten, bis diese fertiggestellt oder veröffentlicht sind oder auch dauerhaft privat bleiben sollen. Für archäologische Untersuchungen, Fundhorizonte und Kontexte sowie für regionale Horizonte stehen verschiedene Stufen der Vertraulichkeit und Freigabe zur Verfügung.</li>
            <li><b>Chronologie:</b> Die Chronologie wird auf der Ebene der Fundstellen durch Phasen oder Fundhorizonte bestimmt; verschiedene Fundhorizonte können zu regionalen Horizonten zusammengefasst werden.</li>
            <li><b>Interoperabilität:</b> Die Daten sollen vergleichbar sein und miteinander verknüpft werden können. Suchen nach Typen, Pastengruppen oder anderen relevanten Kriterien sind möglich, um den gesamten Datenbestand abzufragen (soweit die Daten öffentlich zugänglich oder für den jeweiligen Nutzer freigegeben sind).</li>
            <!--<li><b>Anpassungsfähigkeit:</b> Die von verschiedenen Forschenden verwendeten Methoden und Referenzsysteme können voneinander abweichen. Auch die Veröffentlichung älterer Daten kann auf früheren Referenzsystemen beruhen. Wir möchten es allen ermöglichen, Daten auf die für sie geeignetste Weise zu veröffentlichen, ohne die verwendeten Bezeichnungen einzuschränken. Dieses Prinzip steht teilweise im Spannungsverhältnis zur Interoperabilität; hierfür werden Lösungen gesucht. Diese sollen unter anderem durch Möglichkeiten zur Personalisierung der Nutzererfahrung umgesetzt werden.</li>-->
            <li><b>Benutzerfreundlichkeit:</b> Trotz seiner technischen Komplexität soll LOGACer auch für Einsteiger zugänglich bleiben. Die Grundlagen seiner Nutzung sollen innerhalb von weniger als einer Stunde erlernt werden können, wobei Schutzmechanismen helfen, Bedienungsfehler zu vermeiden.</li>
        </ul>
        <br>

        <h2>Technische Infrastruktur</h2>
        <br>
        <p>Eine erste Version von LOGACer (DBCer Version 1) verwendete das Django-Framework mit einer SQLite-Datenbank. Die aktuelle Version basiert auf PHP und JavaScript (mit AJAX) und greift auf eine MySQL-Datenbank zu. Zu den verwendeten Bibliotheken gehören Bootstrap für die Seitengestaltung, Leaflet für die Kartendarstellung, Altorouter für das Routing und PhpSpreadsheet für die Verwaltung von Excel-Dateien.</p>
        <p>Die Software besteht aus mehreren Teilen bzw. „Modulen“:</p>
        <ul style="text-align:left;">
            <li><b>Bereits verfügbar</b></li><ul>
            <li><b>Grundstruktur:</b> Verwaltung archäologischer Untersuchungen bzw. Fundstellen, Fundhorizonte bzw. Phasen, Kontexte und Objekte. Umfasst die Benutzerverwaltung, das Hinzufügen von Abbildungen, Dateien und bibliografischen Angaben sowie Werkzeuge zur Abfrage, zum Import und Export von Daten und eine grundlegende Kartendarstellung.</li>
            <li><b>Chronologie anhand von Horizonten:</b> Definition regionaler Horizonte, denen Fundhorizonte mit unterschiedlichem Grad der Zuordnung zugeordnet werden können.</li>
            <li><b>Referenzsysteme:</b> Integration der Konzepte Kategorie, Pastengruppe, Funktion und Typ, die beschrieben und abgefragt werden können, mit logischen Einschränkungen (z. B. Verknüpfung zwischen Typen und Kategorien).</li>
            <li><b>Literaturauswertung:</b> Möglichkeit, eindeutig anzugeben, wenn Daten aus Veröffentlichungen anderer Autoren übernommen und überarbeitet wurden. Bereits veröffentlichte Daten zum Fundmaterial können zusätzlich zu den überarbeiteten Daten aufgenommen werden.</li>
            </ul><li><b>Derzeit in Entwicklung</b></li><ul>
            <li><b>Erweiterte Horizonte:</b> Bestimmung der Art der Verbindung zwischen regionalen Horizonten und den darin vorkommenden Typen, mit Werkzeugen für Seriationen und Korrespondenzanalyse (CA). Vergleich zwischen einer Phase/einem Fundhorizont/Kontext und einer Gruppe von Horizonten.</li>
            </ul><li><b>Bereits geplant</b></li><ul>
            <li><b>Erweiterte Pasten:</b> Einbindung von Pastenuntersuchungen direkt in die Datenbank, mit Angabe der verwendeten Protokolle und einfachen statistischen Werkzeugen (PCA, Dendrogramm).</li>
            <li><b>Diagramme:</b> Darstellung von Diagrammen, die für die Veröffentlichung oder den Vergleich von Daten nützlich sind (uni- oder bivariabel, nach Kontexten/Fundhorizonten/archäologischen Untersuchungen).</li>
            <li><b>Erweiterte Kartografie:</b> Verbesserung der Kartendarstellung mit Visualisierung quantitativer Verteilungen von Fundmaterial sowie Filterung und Unterscheidung nach verschiedenen Kriterien.</li>
            <li><b>Referenzsysteme – Vereinheitlichung:</b> Erkennung ähnlicher Elemente und gruppenweise Änderungen zur Unterstützung der Vereinheitlichung heterogener Daten.</li>
            <li><b>Weitere Funktionen:</b> Geplant sind zusätzliche Möglichkeiten für Mehrsprachigkeit, das Hinzufügen von Kommentaren, die Verwaltung bibliografischer Angaben sowie eine einfache Interoperabilität der Daten (mit Ein- und Ausgabeschnittstellen) zur Nutzung mit anderen, stärker spezialisierten Programmen. Die konkrete Umsetzung richtet sich nach den Bedürfnissen der Nutzer und der für die Entwicklung verfügbaren Zeit.</li>
        </ul></ul>          
        <br>

        <h2>LOGACer für Ihr eigenes Projekt implementieren</h2>
        <br>
        <p>LOGACer steht unter einer CC BY-NC-Lizenz, die die Wiederverwendung des Quellcodes, seine Änderung und seine Implementierung durch andere Teams erlaubt. Der Quellcode ist auf Anfrage beim Administrator (über das <a href="https://www.logacer.org/about_us#contact" target="_blank">Kontaktformular</a>) erhältlich.</p>
        <p>Wenn Sie LOGACer für Ihr Projekt einsetzen möchten, können wir:<p>
        <ul style="text-align:left;">
            <li>Ihnen kostenlos die notwendigen Elemente für eine lokale Implementierung durch Ihre IT-Abteilung zur Verfügung stellen, ohne besondere Konfiguration (abgesehen vom Namen und den Präsentationsseiten);</li>
            <li>das Werkzeug konfigurieren oder Funktionen hinzufügen (gegen eine finanzielle Beteiligung, die zur Weiterentwicklung des Projekts beiträgt) und die Implementierung des Werkzeugs unterstützen;</li>
            <li>die Implementierung des Werkzeugs für Ihre Nutzung auf einem externen Server anbieten (auch hierfür ist eine finanzielle Beteiligung zur Finanzierung der Installation und der Hostingkosten erforderlich).</li>
        </ul>
        <p>Unabhängig von Ihrer Situation: Wenn LOGACer für Sie interessant ist, zögern Sie nicht, uns über das <a href="https://www.logacer.org/about_us#contact" target="_blank">Kontaktformular</a> zu kontaktieren, um darüber zu sprechen!</p>
        