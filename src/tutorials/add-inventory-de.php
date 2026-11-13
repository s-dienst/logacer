
  <!-- Barre latérale -->
  <nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Zurück: Liste der Tutorials</a></h6><br>
    <h4 class="px-3">Inventarintegration</h4>
    <a href="#introduction">Einleitung</a>
    <h5 class="px-3">I. Über den persönlichen Bereich</h5>
    <a href="#bugs-connus">Bekannte Fehler</a>
    <a href="#telecharger-completer-templates">Vorlagen herunterladen und ausfüllen</a>
    <ul>
      <li><a href="#telecharger-template">Vorlagen herunterladen</a></li>
      <li><a href="#contenu-templates">Inhalt der Vorlagen</a></li>
      <li><a href="#ouvrir-templates">Vorlagen öffnen</a></li>
      <li><a href="#completer-enregistrer">Ausfüllen und speichern</a></li>
    </ul>
    <a href="#integrer">Vorlagen integrieren</a>
    <ul>
      <li><a href="#ajouter-template">Vorlagen hinzufügen</a></li>
      <li><a href="#ecran-ajout">Eingabemaske</a></li>
      <li><a href="#corrections">Korrekturen</a></li>
      <li><a href="#validation">Bestätigen oder abbrechen</a></li>
    </ul>
    <a href="#longues-integrations">Lange Integrationen verwalten</a>
    <ul>
      <li><a href="#pause-integration">Vorübergehend anhalten</a></li>
      <li><a href="#reprendre-upload">Upload fortsetzen</a></li>
    </ul>
    <h5 class="px-3">II. Innerhalb der Seiten</h5>
    <h5 class="px-3">III. Manuelle Integration</h5>
  </nav>

  <!-- Hauptinhalt -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: Archäologische Untersuchungen, Fundstellenphasen, Kontexte und Inventardaten hinzufügen</h1>
    <section id="introduction" class="mb-5">
      <p>Das Hinzufügen (und Ändern) von Fundstellen, Phasen, Kontexten und Inventardaten kann in <?php echo WEBSITE_NAME; ?> auf verschiedene Arten erfolgen:</p>
      
      <ul>
        <li>Durch das globale Hinzufügen von Daten über den persönlichen Bereich;</li>
        <li>Durch das Hinzufügen von Daten, die spezifisch für ein Projekt, eine archäologische Untersuchung oder einen Kontext sind, über die entsprechenden Seiten;</li>
        <li>Durch das manuelle Hinzufügen, Ändern und Löschen von Daten über die Anzeigeseiten der jeweiligen Daten.</li>
      </ul>

      <p>Die verschiedenen Vorgehensweisen werden im Folgenden erläutert.</p>
    </section>

    <h2>I. Daten über den persönlichen Bereich integrieren</h2>

      <section id="bugs-connus" class="mb-5">
        <h4>Bekannte Fehler</h4>
        
        <p>Eine Reihe von Fehlern wurde bereits festgestellt und befindet sich derzeit in Bearbeitung. Die Implementierung dieser Funktionen nimmt jedoch ebenso wie die Behebung bestimmter Fehler viel Zeit in Anspruch. Bitte informieren Sie den Administrator, wenn Sie weitere Fehler feststellen.</p>
        <p>Im Allgemeinen kann eine farbliche Fehleranzeige auch nach einer Korrektur bestehen bleiben. Es wird empfohlen, ein zweites Mal in die betreffende Zelle zu klicken und anschließend die Eingabetaste zu drücken, um zu überprüfen, ob der Fehler tatsächlich behoben wurde.</p>
        <p>Beim Hinzufügen von Fundstellen:</p>
        <ul>
          <li>Wenn im importierten Dokument eine Region angegeben ist, die nicht existiert, wird sie lediglich aus der Tabelle entfernt.</li>
        </ul>
        <p>Beim Hinzufügen von Phasen und Kontexten:</p>
        <ul>
          <li>Auch wenn ein Fehler angezeigt wird, wird eine neue Phase ab dem Zeitpunkt hinzugefügt, an dem eine spätere Angabe korrekt ist, wenn die erste Angabe der neuen Phase fehlerhaft ist; die Kontexte werden dieser Phase hinzugefügt. Eine fehlerhafte Phase verhindert daher nicht den Import des Kontexts</li>
          <li>Wenn die Codierung des regionalen Horizonts fehlerhaft ist, wird dieser einfach entfernt, ohne dass ein Fehler angezeigt wird.</li>
        </ul>
        <p>Beim Hinzufügen von Inventardaten:</p>
        <ul>
          <li>Die Kurzversion muss noch ausführlicher getestet werden, insbesondere aufgrund der zahlreichen vorgenommenen Änderungen. Es ist wahrscheinlich, dass sie derzeit nicht korrekt funktioniert.</li>
          <li>Die Langversion wurde noch nicht implementiert, da hierfür Änderungen an der derzeitigen Funktionsweise von <?php echo WEBSITE_NAME; ?> erforderlich sind.</li>
        </ul>
      </section>


    <section id="telecharger-completer-templates" class="mb-5">
      <h3>1. Vorlagen herunterladen und ausfüllen</h3>
      <section id="telecharger-template" class="mb-5">
        <h4>1.1. Vorlagen herunterladen</h4>
        
        <p>Die verschiedenen Vorlagen können im persönlichen Bereich unter dem Reiter „Vorlagen“ heruntergeladen werden. Derzeit gibt es Vorlagen zum Hinzufügen von:</p>
        <ul>
          <li>archäologischen Untersuchungen;</li>
          <li>Kontexten (einschließlich ihrer möglichen Fundstellenphasen);</li>
          <li>Inventardaten.</li>
        </ul>

        <p>Wählen Sie die gewünschte Vorlage aus der bereitgestellten Liste aus und klicken Sie anschließend auf „Herunterladen“.</p>
      </section>

      <section id="contenu-templates" class="mb-5">
        <h4>1.2. Inhalt der Vorlagen</h4>

        <p>Diese Vorlagen sind jeweils in einer Kurz- und einer Langversion verfügbar.</p>

        <h5>Fundstellen – Kurzversion</h5>
        <ul>
          <li><b>Projekt-ID (optional):</b> Identifikator des Projekts, dem Ihre archäologische Maßnahme zugeordnet werden soll, falls Sie sie einem Projekt zuordnen möchten. Der Identifikator ist die numerische Kennung, die in der URL beim Öffnen Ihres Projekts sichtbar ist: „…/project/1“, wobei „1“ der Identifikator ist.</li>
          <li><b>Verantwortlicher der Maßnahme (optional):</b> Identifikator des Verantwortlichen in <?php echo WEBSITE_NAME; ?> (nicht zu verwechseln mit Vor- und Nachnamen), der für die Maßnahme angegeben werden soll. Wenn es sich um Sie selbst handelt, können Sie das Feld leer lassen. Wenn es sich um eine andere Person handelt, muss diese in <?php echo WEBSITE_NAME; ?> registriert sein; in diesem Fall werden Sie automatisch als Mitwirkender hinzugefügt.</li>
          <li><b>Code der archäologischen Maßnahme (obligatorisch):</b> Code zur einfachen Identifizierung der Maßnahme. Der Code muss für den Verantwortlichen der Maßnahme eindeutig sein und ist obligatorisch. Er ist auf 32 Zeichen begrenzt.</li>
          <li><b>Name der archäologischen Maßnahme (obligatorisch):</b> Vollständiger Name der archäologischen Maßnahme. Der Name ist auf 255 Zeichen begrenzt. In <?php echo WEBSITE_NAME; ?> darf keine andere archäologische Maßnahme mit demselben Namen existieren.</li>
        </ul>

        <h5>Fundstellen – Langversion</h5>
        <p>Zusätzliche Felder (alle optional):</p>
        <ul>
          <li><b>Koord. Breite:</b> Koordinaten der Fundstelle in Breitengrad (in Dezimalform mit einem Punkt, zwischen -90 und 90; positive Zahlen entsprechen dem nördlichen Breitengrad, negative Zahlen dem südlichen Breitengrad).</li>
          <li><b>Koord. Länge:</b> Koordinaten der Fundstelle in Längengrad (in Dezimalform mit einem Punkt, zwischen -180 und 180; positive Zahlen entsprechen dem östlichen Längengrad, negative Zahlen dem westlichen Längengrad).</li>
          <li><b>Regionscode:</b> Regionalcode. Die bereits integrierten Codes <a href="<?php echo create_url(['geography']); ?>" target='_blank'>sind hier verfügbar</a>. Wenn Sie eine weitere Region hinzufügen möchten, müssen Sie sich an den Administrator von <?php echo WEBSITE_NAME; ?> wenden.</li>
          <li><b>Öffentlich (ja/nein):</b> Angabe, ob die archäologische Maßnahme für alle oder nur für die Verantwortlichen und Mitwirkenden des Projekts und/oder der Maßnahme zugänglich sein soll. Standardmäßig ist die archäologische Maßnahme nicht öffentlich. Sie können sie auch öffentlich machen, aber bestimmte Fundstellenhorizonte und Kontexte manuell verbergen (außer beim Hinzufügen über eine Tabelle).</li>
          <li><b>Unpubliziert (ja/nein):</b> Angabe, ob die in <?php echo WEBSITE_NAME; ?> integrierten Daten bisher unveröffentlicht sind. Wenn nein, müssen Sie die Bibliografie nach dem Hinzufügen über die CSV-Datei manuell ergänzen. Standardmäßig wird die archäologische Maßnahme nicht als unveröffentlicht betrachtet. Sie können sie auch als bereits publiziert kennzeichnen, aber bestimmte Fundstellenhorizonte und Kontexte manuell als unveröffentlicht angeben (außer beim Hinzufügen über eine Tabelle).</li>
          <li><b>Lit.recherche (ja/nein):</b> Wenn diese archäologische Maßnahme nicht von Ihnen selbst veröffentlicht wurde, sondern von Ihnen aus einer Publikation übernommen wurde (mit oder ohne Änderungen), sollten Sie angeben, dass es sich um aus einer Publikation entnommene (und vermutlich überarbeitete) Daten handelt. Sie können diesen Parameter für Fundstellenhorizonte und Kontexte genauer festlegen (außer beim Hinzufügen über eine Tabelle).</li>
          <li><b>Beschreibung:</b> Sie können eine Beschreibung der Fundstelle hinzufügen (Freitext).</li>
        </ul>

        <h5>Kontexte – Kurzversion</h5>
        <p>Es muss entweder der Verantwortliche und der Code der archäologischen Maßnahme (eindeutige Kombination) oder der (eindeutige) Name der archäologischen Maßnahme angegeben werden.</p>
        <ul>
          <li><b>Verantwortlicher der Maßnahme:</b> Identifikator des Verantwortlichen in <?php echo WEBSITE_NAME; ?> (nicht zu verwechseln mit Vor- und Nachnamen) der archäologischen Maßnahme, zu der der Kontext hinzugefügt werden soll.</li>
          <li><b>Archäologische Maßnahme (Code):</b> Code der archäologischen Maßnahme, zu der der Kontext hinzugefügt werden soll.</li>
          <li><b>Archäologische Maßnahme (Name) (obligatorisch):</b> Name der archäologischen Maßnahme, zu der der Kontext hinzugefügt werden soll.</li>
          <li><b>Code des Fundstellenhorizonts (optional):</b> Wenn Sie den Kontext einem Fundstellenhorizont hinzufügen möchten, geben Sie hier dessen Code an, mit dem er leicht identifiziert werden kann. Es kann sich um einen neuen Fundstellenhorizont handeln (ein für diese archäologische Maßnahme noch nicht vorhandener Code), um einen bereits vorhandenen Fundstellenhorizont oder um einen Fundstellenhorizont, der für einen weiter oben in der CSV-Datei importierten Kontext hinzugefügt wurde. Der Code ist auf 32 Zeichen begrenzt.</li>
          <li><b>Name des Fundstellenhorizonts (optional, außer bei einem neuen):</b> Wenn es sich um einen für diesen Kontext neu eingeführten Fundstellenhorizont handelt, müssen Sie seinen Namen angeben. Andernfalls wird dieses Feld ignoriert. Der Name ist auf 255 Zeichen begrenzt.</li>
          <li><b>Kontextcode (obligatorisch):</b> Code zur einfachen Identifizierung des Kontexts. Der Code muss für die archäologische Maßnahme eindeutig sein (z. B. US). Er ist auf 32 Zeichen begrenzt.</li>
          <li><b>Kontextname (obligatorisch):</b> Vollständiger Name des Kontexts (kann mit dem Code identisch sein). Der Name ist auf 255 Zeichen begrenzt.</li>
        </ul>

        <h5>Kontexte – Langversion</h5>
        <p>Zusätzliche Felder (alle optional):</p>
        <ul>
          <li><b>Code der Gruppe regionaler Horizonte (obligatorisch, wenn das folgende Feld ausgefüllt ist):</b> Wenn ein neuer Fundstellenhorizont eingeführt wird, kann er mit einem regionalen Horizont verknüpft werden. Bevor der Code des letzteren angegeben wird, muss der Code der Horizontgruppe angegeben werden, zu der er gehört (z. B. ROME für die Horizonte der Region Rom). Der regionale Horizont muss bereits existieren. Dieses Feld und die beiden folgenden werden nicht berücksichtigt, wenn der Fundstellenhorizont bereits existiert oder weiter oben eingeführt wurde.</li>
          <li><b>Code des regionalen Horizonts:</b> Wenn der neue Fundstellenhorizont mit einem regionalen Horizont verknüpft ist, muss dessen Code in dieser Spalte angegeben werden. Der regionale Horizont muss bereits existieren.</li>
          <li><b>Art der Verknüpfung (übergeordnet = 1, untergeordnet = 2, unsicher = 3):</b> Gibt die Bedeutung des Fundstellenhorizonts für die Definition seines regionalen Horizonts an. Es muss sich um eine ganze Zahl zwischen 1 und 3 handeln. Kann leer gelassen werden, wenn die Bedeutung unbekannt ist.</li>
          <li><b>Beschreibung des Fundstellenhorizonts:</b> Sie können eine Beschreibung des neuen Fundstellenhorizonts hinzufügen (Freitext).</li>
          <li><b>Beschreibung des Kontexts:</b> Sie können eine Beschreibung des Kontexts hinzufügen (Freitext).</li>
        </ul>

        <h5>Inventar – Kurzversion</h5>
        <p>Dies ist derzeit die einzige vollständig funktionsfähige Möglichkeit zum Hinzufügen von Daten. Es muss entweder der Verantwortliche und der Code der archäologischen Maßnahme (eindeutige Kombination) oder der (eindeutige) Name der archäologischen Maßnahme angegeben werden.</p>
        <ul>
          <li><b> Verantwortlicher der Maßnahme:</b> Identifikator des Verantwortlichen in <?php echo WEBSITE_NAME; ?> (nicht zu verwechseln mit Vor- und Nachnamen) der archäologischen Maßnahme, zu der der Kontext gehört, dem eine Inventarzeile hinzugefügt werden soll.</li>
          <li><b>Archäologische Maßnahme (Code):</b> Code der archäologischen Maßnahme, zu der der Kontext gehört, dem eine Inventarzeile hinzugefügt werden soll.</li>
          <li><b>Archäologische Maßnahme (Name):</b> Name der archäologischen Maßnahme, zu der der Kontext gehört, dem eine Inventarzeile hinzugefügt werden soll.</li>
          <li><b>Kontext (Code) (obligatorisch):</b> Code des Kontexts, dem die Inventarzeile hinzugefügt werden soll.</li>
          <li><b>Inventarnummer (obligatorisch):</b> Inventarnummer des hinzuzufügenden Objekts, die innerhalb des Kontexts eindeutig sein muss. Die Inventarnummer ist auf 128 Zeichen begrenzt.</li>

          <li><b>Kategorie (obligatorisch):</b> Abkürzung der Kategorie, zu der das Objekt gehört (maximal 16 Zeichen). Die Kategorie muss nicht zuvor in <?php echo WEBSITE_NAME; ?> hinzugefügt worden sein.</li>
          <li><b>Funktion (obligatorisch):</b> Bezeichnung der Funktion, zu der das Objekt gehört (maximal 128 Zeichen). Die Funktion muss nicht zuvor in <?php echo WEBSITE_NAME; ?> hinzugefügt worden sein.</li>
          <li><b>Typ (obligatorisch):</b> Bezeichnung des Typs, zu dem das Objekt gehört (maximal 128 Zeichen). Der Typ muss nicht zuvor in <?php echo WEBSITE_NAME; ?> hinzugefügt worden sein. </li>
          <li><b>Var. (optional):</b> Wenn es sich um eine Variante des Typs handelt, geben Sie dies hier an (vorzugsweise mit der Angabe „var.“, maximal 8 Zeichen).</li>
          <li><b>Zweifel (optional):</b> Wenn Zweifel an der Identifizierung des Typs bestehen, geben Sie dies hier an (vorzugsweise mit dem Satzzeichen „?“, maximal 16 Zeichen).</li>
          <li><b>Ton (optional):</b> Code der Tongruppe, zu der das Objekt gehört (maximal 64 Zeichen). Die Tongruppe muss nicht zuvor in <?php echo WEBSITE_NAME; ?> hinzugefügt worden sein.</li>

          <li><b>Durchm. (optional):</b> Angaben zum Durchmesser des Objekts (maximal 16 Zeichen).</li>
          <li><b>Stempel (optional):</b> Wenn das Objekt Stempel aufweist, geben Sie diese getrennt vom Typ an, um die Suche nach diesem Merkmal zu erleichtern (maximal 255 Zeichen).</li>
          <li><b>Kommentar (optional):</b> Freier Kommentar oder Beschreibung (maximal 255 Zeichen).</li>
          <li><b>Ränder (optional):</b> Anzahl der Ränder (ganze Zahl >= 0).</li>
          <li><b>Böden (optional):</b> Anzahl der Böden (ganze Zahl >= 0).</li>
          <li><b>Henkel (optional):</b> Anzahl der Henkel (ganze Zahl >= 0).</li>
          <li><b>Wände (optional):</b> Anzahl der Wandfragmente (ganze Zahl >= 0).</li>
          <li><b>Mindestindividuen (NMI) (optional):</b> Mindestanzahl der Individuen (streng, ausschließlich auf Grundlage des Randes) (ganze Zahl >= 0).</li>
          <li><b>NR (optional):</b> Anzahl der Reste (oder Fragmente) (ganze Zahl >= 0).</li>
        </ul>


        <h5>Inventar – Langversion</h5>
        <p>Die Langversion ist insbesondere bei Literaturauswertungen (oder bei der Online-Stellung von bereits vor längerer Zeit untersuchten Kontexten) nützlich, da sie es ermöglicht, Kategorien, Funktionen, Typen und Tongruppen in der Datenbank anzupassen und gleichzeitig die ursprünglich publizierten Informationen verfügbar zu machen. <div style="color:#ff0000">Die Integration von Inventaren in dieser Form ist derzeit nicht möglich.</div> Die betreffenden Felder werden ersetzt durch:</p>
        <ul>
          <li><b>Kategorie (angepasst) (obligatorisch):</b> Entspricht der Kategorie in der Kurzvorlage.</li>
          <li><b>Kategorie (Bibliografie) (optional):</b> In der Bibliografie erwähnte Kategorie (Funktionalität noch hinzuzufügen).</li>
          <li><b>Funktion (angepasst) (obligatorisch):</b> Entspricht der Funktion in der Kurzvorlage.</li>
          <li><b>Funktion (Bibliografie) (optional):</b> In der Bibliografie erwähnte Funktion (Funktionalität noch hinzuzufügen).</li>
          <li><b>Typ (angepasst) (obligatorisch):</b> Entspricht dem Typ in der Kurzvorlage.</li>
          <li><b>Typ (Bibliografie) (optional):</b> In der Bibliografie erwähnter Typ (Funktionalität noch hinzuzufügen).</li>
          <li><b>Ton (angepasst) (optional):</b> Entspricht der Tongruppe in der Kurzvorlage.</li>
          <li><b>Ton (Bibliografie) (optional):</b> In der Bibliografie erwähnte Tongruppe (Funktionalität noch hinzuzufügen).</li>
        </ul>
      </section>

      <section id="ouvrir-templates" class="mb-5">
        <h4>1.3. Vorlagen öffnen</h4>
        
        <p>Die Vorlagen sind so konfiguriert, dass Semikolons als Trennzeichen verwendet werden. Dies ist die Standardeinstellung von MS Excel in der französischsprachigen Version. Es kann jedoch vorkommen, dass die Vorlage bei Ihnen nicht korrekt angezeigt wird. Wenden Sie sich in diesem Fall gerne an den Administrator der Website, um eine Lösung zu finden.</p>
      </section>

      <section id="completer-enregistrer" class="mb-5">
        <h4>1.4. Vorlagen ausfüllen und speichern</h4>
        <h5>Vorlage ausfüllen</h5>
        <p>Nach dem Öffnen können Sie die Vorlage ausfüllen. Achten Sie darauf, keine Felder aus der Vorlage zu entfernen und die Reihenfolge der Spalten nicht zu verändern. <?php echo WEBSITE_NAME; ?> verarbeitet normalerweise das Hinzufügen neuer Felder (diese werden ignoriert), das Entfernen obligatorischer Felder und die Änderung der Reihenfolge, dennoch können dabei Fehler auftreten.</p>
        <p>Lassen Sie nicht verwendete und nicht obligatorische Felder vollständig leer. Beachten Sie, dass Änderungen der Formatierung (fett, kursiv, unterstrichen, Schriftarten usw.) in einer CSV-Datei nicht erhalten bleiben. Kapitälchen werden in Großbuchstaben umgewandelt.</p>
        <p><b>Die maximale Größe der Vorlagen beträgt derzeit etwa 200 MB, wird jedoch auf 2 MB begrenzt werden (damit sie handhabbar bleiben), was ungefähr 50.000 Inventarzeilen entspricht. Bitte überschreiten Sie diese Zahl nicht.</b></p>

        <h5>Vorlage speichern</h5>
        <p>Die Vorlage muss immer im CSV-Format gespeichert werden, wobei das Semikolon als Trennzeichen verwendet wird. In MS Excel, das für französischsprachige Benutzer konfiguriert ist, sollte dies der Fall sein.</p>
        <p>Sie können dies jedoch überprüfen, indem Sie Ihre CSV-Datei in einem Texteditor (TextEdit auf dem Mac) öffnen und prüfen, ob Semikolons oder ein anderes Trennzeichen (in der Regel ein Komma) zur Trennung der Felder verwendet werden. Falls es sich um Kommas handelt und Sie sicher sind, dass Sie beim Ausfüllen der Vorlage keine Kommas verwendet haben, können Sie die Funktion „Suchen und Ersetzen“ verwenden, um die Kommas durch Semikolons zu ersetzen.</p>
      </section>
    </section>

    <section id="integrer" class="mb-5">
      <h3>2. Vorlagen integrieren</h3>
      <section id="ajouter-template" class="mb-5">
        <h4>2.1. Vorlagen hinzufügen und zum Eingabebildschirm gehen</h4>
        <p>Um die Vorlage hinzuzufügen, kehren Sie zum persönlichen Bereich zurück. Unter „Daten importieren“ müssen Sie:</p>
        <ul>
          <li>Eine Option aus der Liste auswählen, um den Typ der Vorlage auszuwählen, die Sie hinzufügen möchten (unabhängig davon, ob es sich um die Lang- oder Kurzvorlage handelt);</li>
          <li>Die ausgefüllte Datei hinzufügen;</li>
          <li>Angeben, ob Sie die fehlerfrei importierten Daten anzeigen möchten oder nicht. Mit „fehlerfrei“ ist gemeint, dass die Daten so integriert werden können, wie sie eingegeben wurden, ohne Änderungen durch den Benutzer. Das Fehlen einer Übereinstimmung bei Kategorien, Funktionen, Typen und Tongruppen gilt dabei nicht als Fehler. Wenn Sie diese Übereinstimmungen überprüfen möchten, empfehlen wir, dieses Kästchen nicht anzukreuzen. Diese Auswahl kann später nicht mehr geändert werden. Wenn Sie sich bei Ihrer Auswahl nicht sicher sind, können Sie jederzeit einen Test durchführen, anschließend die Integration der Daten abbrechen und sich dafür entscheiden, Ihre Auswahl zu ändern (siehe weiter unten).</li>
        </ul>
      </section>
      <section id="ecran-ajout" class="mb-5">
        <h4>2.2. Bildschirm zum Hinzufügen von Daten</h4>
        <p>Anschließend gelangen Sie zu einem Bildschirm, auf dem Sie das Hinzufügen der Daten bestätigen können. Dieser Bildschirm besteht aus zwei Teilen: einer Zusammenfassung der Integration und der Tabelle mit den integrierten Daten.</p>

        <h5>Integrationsdaten</h5>
        <p>Hierbei handelt es sich um eine Zusammenfassung der hinzugefügten Daten:</p>
        <ul>
          <li><b>Zeilen:</b> Die derzeit innerhalb der CSV-Datei verarbeiteten Zeilen (um die Zählung in Excel einzuhalten, wird die Titelzeile als Zeile 1 betrachtet).</li>
          <li><b>Gesamtzahl der Zeilen:</b> Anzahl der Zeilen, die die hochgeladene Datei umfasst (einschließlich der Titelzeile).</li>
          <li><b>Verbleibende Zeilen:</b> Anzahl der noch nicht verarbeiteten Zeilen.</li>
          <li><b>Angezeigte Zeilen:</b> Anzahl der in dieser Tabelle angezeigten Zeilen.</li>
        </ul>

        <h5>Datentabelle</h5>
        <p>Unterhalb dieser Angaben wird die Tabelle angezeigt, entweder mit allen integrierten Daten oder ausschließlich mit den fehlerhaften Daten, je nach der für die Integration getroffenen Auswahl. <?php echo WEBSITE_NAME; ?> ist so konfiguriert, dass maximal 200 Zeilen angezeigt werden. Wenn die Option „Auch die fehlerfrei importierten Daten anzeigen“ nicht aktiviert wurde, verarbeitet <?php echo WEBSITE_NAME; ?> maximal 1000 Zeilen auf einmal, unabhängig davon, ob Fehler vorhanden sind oder nicht (und zeigt maximal 200 fehlerhafte Zeilen an).</p>
        <p>Korrekt ausgefüllte Daten werden in Schwarz angezeigt. Die übrigen Daten werden je nach Schweregrad in verschiedenen Farben dargestellt.</p>

        <h5>Fehler, die den Import der Daten verhindern</h5>
        <p>Diese Fehler werden dunkelrot angezeigt. Der Import kann in einigen Fällen dennoch durchgeführt werden, wir haben sie jedoch als blockierende Fehler eingestuft, da die Benutzer sie wahrscheinlich korrigieren möchten. Im Allgemeinen gilt:</p>
        <ul>
          <li><b>Ungültiges Format:</b> Wenn erforderliche Daten fehlen, nicht das richtige Format aufweisen (z. B. Buchstaben anstelle von Zahlen) oder die maximale Zeichenanzahl überschritten wird.</li>
        </ul>
        <p>Beim Import von Fundstellen:</p>
        <ul>
          <li><b>Projekt:</b> Kein Projekt entspricht dieser Kennung oder der Benutzer ist nicht in das entsprechende Projekt aufgenommen.</li>
          <li><b>Verantwortlicher der archäologischen Untersuchung:</b> Der Benutzername existiert nicht. Der Code der Fundstelle kann nicht überprüft werden und wird ebenfalls als fehlerhaft betrachtet.</li>
          <li><b>Code:</b> Der Code fehlt, ist zu lang oder existiert bereits für diesen Verantwortlichen.</li>
          <li><b>Name:</b> Der Name fehlt, ist zu lang oder existiert bereits in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Region:</b> Der Code der angegebenen Region existiert noch nicht in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Koordinaten:</b> Die Breiten- und/oder Längengrade sind nicht als Zahlen angegeben oder weisen unmögliche Werte auf (zwischen -90 und 90 für den Breitengrad, zwischen -180 und 180 für den Längengrad).</li>
        </ul>
        <p>Beim Import von Fundstellenhorizonten und Kontexten:</p>
        <ul>
          <li><b>Fundstelle:</b> Keine Fundstelle entspricht diesem Code oder der Benutzer ist weder Verantwortlicher noch Mitwirkender dieser Fundstelle (der Kontextcode wird ebenfalls als fehlerhaft betrachtet, da er nicht überprüft werden kann).</li>
          <li><b>Code des Fundstellenhorizonts:</b> Dieser Code ist dieser Fundstelle bereits zugewiesen (wenn sich für diese Zeile ein anderer Name als der des bestehenden oder weiter oben unter demselben Code angegebenen Fundstellenhorizonts unterscheidet – <b>Regel muss noch bestätigt werden</b>).</li>
          <li><b>Verknüpfungstyp:</b> Der Verknüpfungstyp mit dem regionalen Horizont muss leer sein oder eine Zahl zwischen 0 und 3 enthalten (übergeordnet = 1, untergeordnet = 2, unsicher = 3, unbekannt = 0) – <b>Es muss noch geklärt werden, ob dies ein blockierender Fehler ist oder nicht</b>.</li>
          <li><b>Kontextcode:</b> Der Code existiert bereits für diese Fundstelle.</li>
        </ul>
        <p>Beim Import des Inventars:</p>
        <ul>
          <li><b>Fundstelle:</b> Keine Fundstelle entspricht diesem Code oder der Benutzer ist weder Verantwortlicher noch Mitwirkender dieser Fundstelle (der Kontextcode und die Inventarnummer werden ebenfalls als fehlerhaft betrachtet, da sie nicht überprüft werden können).</li>
          <li><b>Kontext:</b> Der für den Kontext angegebene Code existiert nicht für diese Fundstelle (die Inventarnummer wird ebenfalls als fehlerhaft betrachtet, da sie nicht überprüft werden kann).</li>
          <li><b>Inventarnummer:</b> Die Nummer muss innerhalb des Kontexts eindeutig sein (einschließlich der gerade hinzugefügten Daten).</li>
          <li><b>Ränder, Böden, Henkel, Wände, NMI, NR:</b> Wenn diese Spalten ausgefüllt sind, müssen sie positive ganze Zahlen (oder 0) enthalten.</li>
        </ul>

        <h5>Fehler, die den Import der Daten nicht verhindern</h5>
        <p>Diese Fehler werden (normalerweise) grau angezeigt. Beim Import des Inventars handelt es sich dabei nicht wirklich um Fehler, sondern vielmehr um das Hinzufügen von Daten, die auf Ebene des Referenzwerks nicht verknüpft sind.</p>
        <p>Beim Import von Fundstellen:</p>
        <ul>
          <li><b>Öffentlich, Unveröffentlicht, Literaturüberprüfung:</b> Wenn das Format nicht korrekt ist (eine andere Antwort als « ja » oder « nein » oder ein leeres Feld). Die Standardwerte werden angewendet.</li>
        </ul>
        <p>Beim Import von Fundstellenhorizonten und Kontexten:</p>
        <ul>
          <li><b>Horizontgruppe (Code):</b> Keine Horizontgruppe entspricht diesem Code oder der Benutzer ist weder Verantwortlicher noch Mitwirkender dieser Gruppe (der Horizontcode wird ebenfalls als fehlerhaft betrachtet, da er nicht überprüft werden kann).</li>
          <li><b>Horizont (Code):</b> Der für den regionalen Horizont angegebene Code existiert nicht für diese Horizontgruppe.</li>
          <li><b>Verknüpfungstyp:</b> Wenn der Typ angegeben ist, muss es sich um eine ganze Zahl zwischen 1 und 3 handeln.</li>
        </ul>
        <p>Beim Import des Inventars:</p>
        <ul>
          <li><b>Kategorie, Funktion, Typ und Tongruppe:</b> Wenn im Referenzwerk von <?php echo WEBSITE_NAME; ?> (derzeit nicht mit ONICer verbunden) kein Element existiert, mit dem eine Verknüpfung hergestellt werden kann.</li>
        </ul>
      </section>

      <section id="corrections" class="mb-5">
        <h4>2.3. Korrekturen während der Integration</h4>
        <p>Sowohl im Falle eines Fehlers als auch für jede andere Art von Korrektur können Sie den angezeigten Wert ändern, indem Sie einfach auf das zu bearbeitende Feld klicken und den Wert korrigieren. Wenn Sie an eine andere Stelle klicken, wird der Wert schwarz angezeigt, wenn er gültig ist, oder in der Farbe, die dem jeweiligen Fehlertyp entspricht.</p>
      </section>

      <section id="validation" class="mb-5">
        <h4>2.4. Integration bestätigen oder abbrechen</h4>
        <p>Sobald Sie alle gewünschten Änderungen überprüft und vorgenommen haben, können Sie die Integration bestätigen. Es gibt zwei mögliche Fälle:</p>
        <ul>
          <li><b>Gültige Zeilen importieren und mit der nächsten Seite fortfahren:</b> Wenn noch Daten vorhanden sind, die nicht bearbeitet wurden, werden die gültigen Daten integriert und die folgenden Daten angezeigt.</li>
          <li><b>Gültige Zeilen importieren und Upload beenden:</b> Wenn nur wenige Daten zu importieren sind oder Sie das Ende der zu importierenden Daten erreicht haben, werden die gültigen Daten integriert und Sie werden anschließend zu Ihrem persönlichen Bereich weitergeleitet.</li>
        </ul>
        <p>Ungültige Daten werden nicht hinzugefügt (<b style="color:#ff0000">ZU KLÄREN</b>).</p>
        <p>Sie können den Upload auch abbrechen. Die bereits importierten Daten (aus vorherigen Anzeigen) werden nicht gelöscht, aber die angezeigten Daten und alle noch zu bearbeitenden Daten werden nicht in <?php echo WEBSITE_NAME; ?> integriert. Sie können diesen Vorgang nicht rückgängig machen. Diese Option ist nützlich, wenn Sie viele Probleme in Ihrer Datei feststellen und diese überarbeiten möchten oder wenn Sie die Option zur Anzeige fehlerhafter bzw. nicht fehlerhafter Daten ändern möchten. Wenn Sie die Integration lediglich vorübergehend unterbrechen möchten, ist die Pausenfunktion geeigneter (siehe unten).</p>
      </section>
    </section>

    <section id="longues-integrations" class="mb-5">
      <h3>3. Längere Integrationen verwalten</h3>
      <section id="pause-integration" class="mb-5">
        <h4>3.1. Upload vorübergehend unterbrechen</h4>
        <p>Wenn Sie die Integration während des Hinzufügens von Daten unterbrechen müssen, können Sie über die Schaltfläche « Upload vorübergehend unterbrechen » die Datenintegration pausieren. Sofern zwischenzeitlich keine weiteren Daten hinzugefügt werden, können Sie anschließend die Integration an der Stelle fortsetzen, an der Sie aufgehört haben. Sie können den Bildschirm auch einfach verlassen.</p>
        <p>Dies hat keine Auswirkungen auf die bereits in die Datenbank eingefügten Zeilen.</p>
      </section>

      <section id="reprendre-upload" class="mb-5">
        <h4>3.2. Upload fortsetzen</h4>
        <p>Um einen auf diese Weise pausierten Upload fortzusetzen, müssen Sie Ihren persönlichen Bereich aufrufen. Unter « Daten importieren » ermöglicht eine grüne Schaltfläche das Fortsetzen eines pausierten Uploads. Diese Schaltfläche wird nicht angezeigt, wenn kein Upload pausiert wurde.</p> 
        <p>Derzeit ist nicht vorgesehen, mehrere Uploads für denselben Benutzer gleichzeitig zu pausieren und wieder aufzunehmen. Wenn Sie einen neuen Upload (von Fundstellen, Kontexten oder Inventar) starten, wird der pausierte Upload gelöscht.</p>
      </section>
    </section>

    <h2>II. Daten über die Seiten der Projekte, Fundstellen und Kontexte integrieren</h2>
    <p>Diese Möglichkeit ist in <?php echo WEBSITE_NAME; ?> noch nicht integriert.</p>

    <h2>III. Daten manuell integrieren</h2>
    <div style="color:#ff0000"><p>Abschnitt im Aufbau.</p></div>
  </div>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
