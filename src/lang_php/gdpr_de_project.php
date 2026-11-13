            <h2>Datenschutzerklärung - <?php echo PROJECT->code(); ?></h2>
            <h5>Erhobene personenbezogene Daten</h5>
            <p>Für registrierte Nutzer: Nachname, Vorname, E-Mail-Adresse, Benutzerkennung, Passwort (verschlüsselt), bevorzugte Browsersprache.</p>
            <p>Für andere Nutzer: bevorzugte Browsersprache.</p>
            <h5>Zweck der Datenerhebung</h5>
            <p>Die Daten werden ausschließlich zur Erstellung und Verwaltung von Benutzerkonten verwendet, um den Zugriff auf die Funktionen von <?php echo PROJECT->code(); ?> zu ermöglichen, sowie zur Verwaltung der Anzeigesprache der Website.</p>
            <h5>Rechtsgrundlage</h5>
            <p>Die Datenverarbeitung erfolgt auf Grundlage der Einwilligung des Nutzers (freiwillige Registrierung).</p>
            <h5>Speicherdauer der personenbezogenen Daten</h5>
            <p>Die Daten werden bis zur Löschung des Kontos durch den Nutzer gespeichert (auf Anfrage möglich: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Kontaktformular</a>), die bevorzugte Sprache wird ein Jahr lang gespeichert.</p>
            <h5>Rechte der Nutzer</h5>
            <p>Auskunft, Berichtigung, Löschung, Widerspruch, Datenübertragbarkeit. Zur Ausübung dieser Rechte: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Kontaktformular</a>.</p>
            <h5>Sicherheit der personenbezogenen Daten</h5>
            <p>Die Nutzerdaten werden durch technische Maßnahmen geschützt (Verschlüsselung der Passwörter, gesicherter Zugriff auf die Datenbank). Vor- und Nachname (oder, falls nicht vorhanden, der Benutzername) sind jedoch für andere registrierte Nutzer zugänglich. Im Falle der Veröffentlichung wissenschaftlicher Daten haben auch nicht registrierte Nutzer Zugriff auf diese Informationen. Der oder die Datenbankadministratoren haben ebenfalls Zugriff auf die bei der Registrierung verwendete E-Mail-Adresse.</p>
            <h5>Weitergabe personenbezogener Daten</h5>
            <p>Die Daten werden nicht verkauft und niemals verkauft werden. Sie werden nicht an Dritte weitergegeben, es sei denn, dies ist gesetzlich vorgeschrieben.</p>
            <h5>Verantwortlicher für die Datenverarbeitung</h5>
            <p><?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>.</p>
            <h5>Sichtbarkeit, Nutzung und Verarbeitung nicht personenbezogener Daten</h5>
            <p>Alle von einem registrierten Nutzer in <?php echo PROJECT->code(); ?> eingetragenen Daten sind öffentlich, mit Ausnahme von Projektdaten (die ausschließlich für die jeweiligen Mitwirkenden zugänglich sind), sofern sich deren Vertraulichkeit nicht anderweitig festlegen lässt.
                Die Ersteller der Daten gelten als deren Hauptautoren. In einigen Fällen können auch Mitwirkende (innerhalb von <?php echo PROJECT->code(); ?>) angegeben werden. Diese sind dafür verantwortlich, die Authentizität der Daten sowie die Einhaltung der Richtlinien zum Urheberrecht und zur Zitierung wissenschaftlicher Daten sicherzustellen.
                Der Administrator behält sich das Recht vor, das Konto und die Daten jeder Person zu löschen, die gegen diesen Grundsatz verstößt.</p>
