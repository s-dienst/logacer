<?php
    // Traitement en back-end
    function error_install($error) {
        if (is_string($error)) {
            $err = $error;
        } else {
            $err = $error['error'];
            $arg = $error['arg'];
        }
        switch(LANGUAGE) {
            case "fr":
                switch ($err) {
                    case 'invalid_base_url':                return 'L&#39;URL de base est invalide.'; break;
                    case 'no_smtp_host':                    return 'Le serveur SMTP doit être renseigné.'; break;
                    case 'invalid_smtp_port':               return 'Le port SMTP est invalide.'; break;
                    case 'invalid_smtp_security':           return 'Le mode de sécurité SMTP est invalide.'; break;
                    case 'invalid_smtp_user':               return 'L&#39;identifiant SMTP doit être une adresse électronique valide.'; break;
                    case 'no_smtp_password':                return 'Le mot de passe SMTP doit être renseigné.'; break;
                    case 'invalid_smtp_from':               return 'L&#39;adresse d&#39;expédition SMTP est invalide.'; break;
                    case 'invalid_wm_mail':                 return 'L&#39;adresse électronique du webmaster est invalide.'; break;
                    case 'invalid_int_parameter':           return 'Le paramètre '. thesaurus($arg) . ' doit être un entier positif.'; break;
                    case 'unfound_config_dir':              return 'Le répertoire de configuration est introuvable.'; break;
                    case 'unwrite_config_dir':              return 'Le répertoire de configuration n&#39;est pas accessible en écriture. Veuillez contacter votre service informatique.'; break;
                    case 'unknown_db_setup':                return 'Mode de préparation de la base de données inconnu.'; break;
                    case 'db_connect_failed':               return 'Impossible de se connecter à la base de données.'; break;
                    case 'invalid_ssl_pilot':               return 'Le pilote PDO MySQL ne permet pas de configurer TLS/SSL.'; break;
                    case 'invalid_ssl_ca':                  return 'Le certificat CA est introuvable ou illisible.'; break;
                    case 'invalid_ssl_cert':                return 'Le certificat client est introuvable ou illisible.'; break;
                    case 'invalid_ssl_key':                 return 'La clé privée du certificat client est introuvable ou illisible.'; break;
                    case 'invalid_db_name':                 return 'Le nom de la base de données est invalide.'; break;
                    case 'existing_db_name':                return 'La base de données ' . $arg . ' existe déjà. Veuillez vérifier le mode d&#39;installation choisi.'; break;
                    case 'sql_install':                     return 'Le fichier SQL devant servir à l&#39;installation est introuvable ou illisible. Veuillez vérifier si vous avez correctement chargé vos fichiers d&#39;installation.'; break;
                    case 'sql_install_read':                return 'Le fichier SQL devant servir à l&#39;installation est vide ou n&#39;a pas pu être lu. Veuillez vérifier si vous avez correctement chargé vos fichiers d&#39;installation et éventuellement contacter votre service informatique.'; break;
                    case 'execute_sql':                     return 'Erreur lors de l&#39;exécution de l&#39;instruction ' . $arg['number'] . ' : ' . $arg['error']; break;
                    case 'database_not_selected':           return 'La base de données indiquée n&#39;existe pas. Veuillez vérifier le mode d&#39;installation choisi ou contacter votre service informatique.'; break;
                    case 'invalid_database_object_class':   return 'Le fichier variables.php ne semble pas correspondre à la version installée de LOGACer. Les éléments de type "' . $arg . '" n&#39;existent pas au sein de votre installation. Veuillez vérifier l&#39;installation.'; break;
                    case 'missing_table':                   return 'La table "' . $arg . '" manque au sein de votre base de données, alors qu&#39;elle est attendue par cette version de LOGACer. Veuillez vérifier le chargement des fichiers et, si nécessaire, contacter le développeur de LOGACer.'; break;
                    case 'missing_column':                  return 'La colonne "' . $arg['column'] . '" manque au sein de la table "' . $arg['table'] . '" dans la base de données, alors qu&#39;elle est attendue par cette version de LOGACer. Veuillez vérifier le chargement des fichiers et, si nécessaire, contacter le développeur de LOGACer.'; break;
                    case 'missing_link_table':              return 'La table "' . $arg[0] . '" ou "' . $arg[1] . '" manque au sein de votre base de données, alors qu&#39;elle est attendue par cette version de LOGACer. Veuillez vérifier le chargement des fichiers et, si nécessaire, contacter le développeur de LOGACer.'; break;
                    case 'ambiguous_link_table':            return 'Les tables "' . $arg[0] . '" et "' . $arg[1] . '" coexistent, ce qui ne devrait pas être le cas. Veuillez vérifier le chargement des fichiers et, si nécessaire, contacter le développeur de LOGACer.'; break;
                    case 'missing_link_column':             return 'La colonne "' . $arg['column'] . '" manque au sein de la table "' . $arg['table'] . '" dans la base de données, alors qu&#39;elle est attendue par cette version de LOGACer. Veuillez vérifier le chargement des fichiers et, si nécessaire, contacter le développeur de LOGACer.'; break;
                    case 'invalid_json':                    return 'Impossible de convertir la configuration en JSON : ' . $arg; break;
                    case 'error_write_json':                return 'Impossible d&#39;écrire le fichier temporaire de configuration.'; break;
                    case 'error_convert_json_temp':         return 'Impossible de finaliser l&#39;enregistrement de la configuration.'; break;
                    case 'error_read_json':                 return 'Impossible de lire le fichier de configuration.'; break;
                    case 'error_invalid_json':              return 'Le fichier de configuration est illisible ou invalide : ' . $arg; break;
                    case 'error_config_version':            return 'La version de la configuration est absente ou invalide.'; break;
                    case 'error_config_update':             return 'La configuration nécessite une mise à jour.'; break;
                    case 'not_in_config':                   return 'Le ' . thesaurus($arg) . ' (' . $arg . ') n&#39;a pas été correctement configuré.'; break;
                    case 'not_string_config':               return 'Le ' . thesaurus($arg) . ' (' . $arg . ') n&#39;a pas le bon format au sein de la configuration (chaîne de caractère attendu).'; break;
                    case 'empty_string_config':             return 'Le ' . thesaurus($arg) . ' (' . $arg . ') est vide dans le fichier de configuration.'; break;
                    case 'unset_db_value':                  return 'Le ' . thesaurus($arg) . ' est requis.'; break;
                    default:
                        return $err;
                }
                break;
            case "it":
                switch ($err) {
                    case 'invalid_base_url':                return 'L&#39;URL di base non è valida.'; break;
                    case 'no_smtp_host':                    return 'Il server SMTP deve essere specificato.'; break;
                    case 'invalid_smtp_port':               return 'La porta SMTP non è valida.'; break;
                    case 'invalid_smtp_security':           return 'La modalità di sicurezza SMTP non è valida.'; break;
                    case 'invalid_smtp_user':               return 'L&#39;identificativo SMTP deve essere un indirizzo e-mail valido.'; break;
                    case 'no_smtp_password':                return 'La password SMTP deve essere specificata.'; break;
                    case 'invalid_smtp_from':               return 'L&#39;indirizzo mittente SMTP non è valido.'; break;
                    case 'invalid_wm_mail':                 return 'L&#39;indirizzo e-mail del webmaster non è valido.'; break;
                    case 'invalid_int_parameter':           return 'Il parametro '. thesaurus($arg) . ' deve essere un numero intero positivo.'; break;
                    case 'unfound_config_dir':              return 'La directory di configurazione non è stata trovata.'; break;
                    case 'unwrite_config_dir':              return 'Non è possibile scrivere nella directory di configurazione. Si prega di contattare il proprio servizio informatico.'; break;
                    case 'unknown_db_setup':                return 'Modalità di preparazione della banca dati sconosciuta.'; break;
                    case 'db_connect_failed':               return 'Impossibile connettersi alla banca dati.'; break;
                    case 'invalid_ssl_pilot':               return 'Il driver PDO MySQL non consente di configurare TLS/SSL.'; break;
                    case 'invalid_ssl_ca':                  return 'Il certificato CA non è stato trovato o non è leggibile.'; break;
                    case 'invalid_ssl_cert':                return 'Il certificato client non è stato trovato o non è leggibile.'; break;
                    case 'invalid_ssl_key':                 return 'La chiave privata del certificato client non è stata trovata o non è leggibile.'; break;
                    case 'invalid_db_name':                 return 'Il nome della banca dati non è valido.'; break;
                    case 'existing_db_name':                return 'La banca dati ' . $arg . ' esiste già. Si prega di verificare la modalità di installazione scelta.'; break;
                    case 'sql_install':                     return 'Il file SQL necessario per l&#39;installazione non è stato trovato o non è leggibile. Si prega di verificare che i file di installazione siano stati caricati correttamente.'; break;
                    case 'sql_install_read':                return 'Il file SQL necessario per l&#39;installazione è vuoto o non è stato possibile leggerlo. Si prega di verificare che i file di installazione siano stati caricati correttamente ed eventualmente di contattare il proprio servizio informatico.'; break;
                    case 'execute_sql':                     return 'Errore durante l&#39;esecuzione dell&#39;istruzione ' . $arg['number'] . ' : ' . $arg['error']; break;
                    case 'database_not_selected':           return 'La banca dati indicata non esiste. Si prega di verificare la modalità di installazione scelta o di contattare il proprio servizio informatico.'; break;
                    case 'invalid_database_object_class':   return 'Il file variables.php non sembra corrispondere alla versione installata di LOGACer. Gli elementi di tipo "' . $arg . '" non esistono nella propria installazione. Si prega di verificare l&#39;installazione.'; break;
                    case 'missing_table':                   return 'La tabella "' . $arg . '" manca nella banca dati, sebbene sia prevista da questa versione di LOGACer. Si prega di verificare il caricamento dei file e, se necessario, di contattare lo sviluppatore di LOGACer.'; break;
                    case 'missing_column':                  return 'La colonna "' . $arg['column'] . '" manca nella tabella "' . $arg['table'] . '" della banca dati, sebbene sia prevista da questa versione di LOGACer. Si prega di verificare il caricamento dei file e, se necessario, di contattare lo sviluppatore di LOGACer.'; break;
                    case 'missing_link_table':              return 'La tabella "' . $arg[0] . '" o "' . $arg[1] . '" manca nella banca dati, sebbene sia prevista da questa versione di LOGACer. Si prega di verificare il caricamento dei file e, se necessario, di contattare lo sviluppatore di LOGACer.'; break;
                    case 'ambiguous_link_table':            return 'Le tabelle "' . $arg[0] . '" e "' . $arg[1] . '" coesistono, cosa che non dovrebbe verificarsi. Si prega di verificare il caricamento dei file e, se necessario, di contattare lo sviluppatore di LOGACer.'; break;
                    case 'missing_link_column':             return 'La colonna "' . $arg['column'] . '" manca nella tabella "' . $arg['table'] . '" della banca dati, sebbene sia prevista da questa versione di LOGACer. Si prega di verificare il caricamento dei file e, se necessario, di contattare lo sviluppatore di LOGACer.'; break;
                    case 'invalid_json':                    return 'Impossibile convertire la configurazione in JSON: ' . $arg; break;
                    case 'error_write_json':                return 'Impossibile scrivere il file temporaneo di configurazione.'; break;
                    case 'error_convert_json_temp':         return 'Impossibile completare il salvataggio della configurazione.'; break;
                    case 'error_read_json':                 return 'Impossibile leggere il file di configurazione.'; break;
                    case 'error_invalid_json':              return 'Il file di configurazione è illeggibile o non valido: ' . $arg; break;
                    case 'error_config_version':            return 'La versione della configurazione è assente o non valida.'; break;
                    case 'error_config_update':             return 'La configurazione richiede un aggiornamento.'; break;
                    case 'not_in_config':                   return 'Il ' . thesaurus($arg) . ' (' . $arg . ') non è stato configurato correttamente.'; break;
                    case 'not_string_config':               return 'Il ' . thesaurus($arg) . ' (' . $arg . ') non ha il formato corretto nella configurazione (è richiesta una stringa di caratteri).'; break;
                    case 'empty_string_config':             return 'Il ' . thesaurus($arg) . ' (' . $arg . ') è vuoto nel file di configurazione.'; break;
                    case 'unset_db_value':                  return 'Il ' . thesaurus($arg) . ' è obbligatorio.'; break;
                    default:
                        return $err;
                }
                break;
            case "de":
                switch ($err) {
                    case 'invalid_base_url':                return 'Die Basis-URL ist ungültig.'; break;
                    case 'no_smtp_host':                    return 'Der SMTP-Server muss angegeben werden.'; break;
                    case 'invalid_smtp_port':               return 'Der SMTP-Port ist ungültig.'; break;
                    case 'invalid_smtp_security':           return 'Der SMTP-Sicherheitsmodus ist ungültig.'; break;
                    case 'invalid_smtp_user':               return 'Die SMTP-Benutzerkennung muss eine gültige E-Mail-Adresse sein.'; break;
                    case 'no_smtp_password':                return 'Das SMTP-Passwort muss angegeben werden.'; break;
                    case 'invalid_smtp_from':               return 'Die SMTP-Absenderadresse ist ungültig.'; break;
                    case 'invalid_wm_mail':                 return 'Die E-Mail-Adresse des Webmasters ist ungültig.'; break;
                    case 'invalid_int_parameter':           return 'Der Parameter '. thesaurus($arg) . ' muss eine positive Ganzzahl sein.'; break;
                    case 'unfound_config_dir':              return 'Das Konfigurationsverzeichnis wurde nicht gefunden.'; break;
                    case 'unwrite_config_dir':              return 'Das Konfigurationsverzeichnis ist nicht beschreibbar. Bitte wenden Sie sich an Ihre IT-Abteilung.'; break;
                    case 'unknown_db_setup':                return 'Unbekannter Datenbank-Einrichtungsmodus.'; break;
                    case 'db_connect_failed':               return 'Es konnte keine Verbindung zur Datenbank hergestellt werden.'; break;
                    case 'invalid_ssl_pilot':               return 'Der PDO-MySQL-Treiber unterstützt keine TLS/SSL-Konfiguration.'; break;
                    case 'invalid_ssl_ca':                  return 'Das CA-Zertifikat wurde nicht gefunden oder ist nicht lesbar.'; break;
                    case 'invalid_ssl_cert':                return 'Das Client-Zertifikat wurde nicht gefunden oder ist nicht lesbar.'; break;
                    case 'invalid_ssl_key':                 return 'Der private Schlüssel des Client-Zertifikats wurde nicht gefunden oder ist nicht lesbar.'; break;
                    case 'invalid_db_name':                 return 'Der Datenbankname ist ungültig.'; break;
                    case 'existing_db_name':                return 'Die Datenbank ' . $arg . ' existiert bereits. Bitte überprüfen Sie den gewählten Installationsmodus.'; break;
                    case 'sql_install':                     return 'Die für die Installation benötigte SQL-Datei wurde nicht gefunden oder ist nicht lesbar. Bitte überprüfen Sie, ob Sie Ihre Installationsdateien korrekt hochgeladen haben.'; break;
                    case 'sql_install_read':                return 'Die für die Installation benötigte SQL-Datei ist leer oder konnte nicht gelesen werden. Bitte überprüfen Sie, ob Sie Ihre Installationsdateien korrekt hochgeladen haben, und wenden Sie sich gegebenenfalls an Ihre IT-Abteilung.'; break;
                    case 'execute_sql':                     return 'Fehler bei der Ausführung der Anweisung ' . $arg['number'] . ' : ' . $arg['error']; break;
                    case 'database_not_selected':           return 'Die angegebene Datenbank existiert nicht. Bitte überprüfen Sie den gewählten Installationsmodus oder wenden Sie sich an Ihre IT-Abteilung.'; break;
                    case 'invalid_database_object_class':   return 'Die Datei variables.php scheint nicht mit der installierten Version von LOGACer übereinzustimmen. Elemente vom Typ "' . $arg . '" sind in Ihrer Installation nicht vorhanden. Bitte überprüfen Sie die Installation.'; break;
                    case 'missing_table':                   return 'Die Tabelle "' . $arg . '" fehlt in Ihrer Datenbank, obwohl sie von dieser Version von LOGACer benötigt wird. Bitte überprüfen Sie, ob die Dateien korrekt geladen wurden, und wenden Sie sich gegebenenfalls an den Entwickler von LOGACer.'; break;
                    case 'missing_column':                  return 'Die Spalte "' . $arg['column'] . '" fehlt in der Tabelle "' . $arg['table'] . '" in der Datenbank, obwohl sie von dieser Version von LOGACer benötigt wird. Bitte überprüfen Sie, ob die Dateien korrekt geladen wurden, und wenden Sie sich gegebenenfalls an den Entwickler von LOGACer.'; break;
                    case 'missing_link_table':              return 'Die Tabelle "' . $arg[0] . '" oder "' . $arg[1] . '" fehlt in Ihrer Datenbank, obwohl sie von dieser Version von LOGACer benötigt wird. Bitte überprüfen Sie, ob die Dateien korrekt geladen wurden, und wenden Sie sich gegebenenfalls an den Entwickler von LOGACer.'; break;
                    case 'ambiguous_link_table':            return 'Die Tabellen "' . $arg[0] . '" und "' . $arg[1] . '" sind gleichzeitig vorhanden, was nicht der Fall sein sollte. Bitte überprüfen Sie, ob die Dateien korrekt geladen wurden, und wenden Sie sich gegebenenfalls an den Entwickler von LOGACer.'; break;
                    case 'missing_link_column':             return 'Die Spalte "' . $arg['column'] . '" fehlt in der Tabelle "' . $arg['table'] . '" in der Datenbank, obwohl sie von dieser Version von LOGACer benötigt wird. Bitte überprüfen Sie, ob die Dateien korrekt geladen wurden, und wenden Sie sich gegebenenfalls an den Entwickler von LOGACer.'; break;
                    case 'invalid_json':                    return 'Die Konfiguration konnte nicht in JSON umgewandelt werden: ' . $arg; break;
                    case 'error_write_json':                return 'Die temporäre Konfigurationsdatei konnte nicht geschrieben werden.'; break;
                    case 'error_convert_json_temp':         return 'Die Speicherung der Konfiguration konnte nicht abgeschlossen werden.'; break;
                    case 'error_read_json':                 return 'Die Konfigurationsdatei konnte nicht gelesen werden.'; break;
                    case 'error_invalid_json':              return 'Die Konfigurationsdatei ist nicht lesbar oder ungültig: ' . $arg; break;
                    case 'error_config_version':            return 'Die Konfigurationsversion fehlt oder ist ungültig.'; break;
                    case 'error_config_update':             return 'Die Konfiguration muss aktualisiert werden.'; break;
                    case 'not_in_config':                   return 'Der ' . thesaurus($arg) . ' (' . $arg . ') wurde nicht korrekt konfiguriert.'; break;
                    case 'not_string_config':               return 'Der ' . thesaurus($arg) . ' (' . $arg . ') hat in der Konfiguration das falsche Format (eine Zeichenkette wird erwartet).'; break;
                    case 'empty_string_config':             return 'Der ' . thesaurus($arg) . ' (' . $arg . ') ist in der Konfigurationsdatei leer.'; break;
                    case 'unset_db_value':                  return 'Der ' . thesaurus($arg) . ' ist erforderlich.'; break;
                    default:
                        return $err;
                }
                break;
            case "es":
                switch ($err) {
                    case 'invalid_base_url':                return 'La URL base no es válida.'; break;
                    case 'no_smtp_host':                    return 'Debe especificarse el servidor SMTP.'; break;
                    case 'invalid_smtp_port':               return 'El puerto SMTP no es válido.'; break;
                    case 'invalid_smtp_security':           return 'El modo de seguridad SMTP no es válido.'; break;
                    case 'invalid_smtp_user':               return 'El identificador SMTP debe ser una dirección de correo electrónico válida.'; break;
                    case 'no_smtp_password':                return 'Debe especificarse la contraseña SMTP.'; break;
                    case 'invalid_smtp_from':               return 'La dirección de envío SMTP no es válida.'; break;
                    case 'invalid_wm_mail':                 return 'La dirección de correo electrónico del webmaster no es válida.'; break;
                    case 'invalid_int_parameter':           return 'El parámetro '. thesaurus($arg) . ' debe ser un número entero positivo.'; break;
                    case 'unfound_config_dir':              return 'No se encuentra el directorio de configuración.'; break;
                    case 'unwrite_config_dir':              return 'No se puede escribir en el directorio de configuración. Póngase en contacto con su servicio informático.'; break;
                    case 'unknown_db_setup':                return 'Modo de preparación de la base de datos desconocido.'; break;
                    case 'db_connect_failed':               return 'No se puede conectar a la base de datos.'; break;
                    case 'invalid_ssl_pilot':               return 'El controlador PDO MySQL no permite configurar TLS/SSL.'; break;
                    case 'invalid_ssl_ca':                  return 'El certificado CA no se encuentra o no se puede leer.'; break;
                    case 'invalid_ssl_cert':                return 'El certificado de cliente no se encuentra o no se puede leer.'; break;
                    case 'invalid_ssl_key':                 return 'La clave privada del certificado de cliente no se encuentra o no se puede leer.'; break;
                    case 'invalid_db_name':                 return 'El nombre de la base de datos no es válido.'; break;
                    case 'existing_db_name':                return 'La base de datos ' . $arg . ' ya existe. Compruebe el modo de instalación seleccionado.'; break;
                    case 'sql_install':                     return 'No se encuentra el archivo SQL necesario para la instalación o no se puede leer. Compruebe si ha cargado correctamente los archivos de instalación.'; break;
                    case 'sql_install_read':                return 'El archivo SQL necesario para la instalación está vacío o no se ha podido leer. Compruebe si ha cargado correctamente los archivos de instalación y, si es necesario, póngase en contacto con su servicio informático.'; break;
                    case 'execute_sql':                     return 'Error al ejecutar la instrucción ' . $arg['number'] . ' : ' . $arg['error']; break;
                    case 'database_not_selected':           return 'La base de datos indicada no existe. Compruebe el modo de instalación seleccionado o póngase en contacto con su servicio informático.'; break;
                    case 'invalid_database_object_class':   return 'El archivo variables.php no parece corresponder a la versión instalada de LOGACer. Los elementos de tipo "' . $arg . '" no existen en su instalación. Compruebe la instalación.'; break;
                    case 'missing_table':                   return 'Falta la tabla "' . $arg . '" en la base de datos, aunque esta versión de LOGACer la requiere. Compruebe la carga de los archivos y, si es necesario, póngase en contacto con el desarrollador de LOGACer.'; break;
                    case 'missing_column':                  return 'Falta la columna "' . $arg['column'] . '" en la tabla "' . $arg['table'] . '" de la base de datos, aunque esta versión de LOGACer la requiere. Compruebe la carga de los archivos y, si es necesario, póngase en contacto con el desarrollador de LOGACer.'; break;
                    case 'missing_link_table':              return 'Falta la tabla "' . $arg[0] . '" o "' . $arg[1] . '" en la base de datos, aunque esta versión de LOGACer la requiere. Compruebe la carga de los archivos y, si es necesario, póngase en contacto con el desarrollador de LOGACer.'; break;
                    case 'ambiguous_link_table':            return 'Las tablas "' . $arg[0] . '" y "' . $arg[1] . '" coexisten, lo cual no debería ocurrir. Compruebe la carga de los archivos y, si es necesario, póngase en contacto con el desarrollador de LOGACer.'; break;
                    case 'missing_link_column':             return 'Falta la columna "' . $arg['column'] . '" en la tabla "' . $arg['table'] . '" de la base de datos, aunque esta versión de LOGACer la requiere. Compruebe la carga de los archivos y, si es necesario, póngase en contacto con el desarrollador de LOGACer.'; break;
                    case 'invalid_json':                    return 'No se puede convertir la configuración a JSON: ' . $arg; break;
                    case 'error_write_json':                return 'No se puede escribir el archivo temporal de configuración.'; break;
                    case 'error_convert_json_temp':         return 'No se puede finalizar el guardado de la configuración.'; break;
                    case 'error_read_json':                 return 'No se puede leer el archivo de configuración.'; break;
                    case 'error_invalid_json':              return 'El archivo de configuración es ilegible o no es válido: ' . $arg; break;
                    case 'error_config_version':            return 'La versión de la configuración no existe o no es válida.'; break;
                    case 'error_config_update':             return 'La configuración requiere una actualización.'; break;
                    case 'not_in_config':                   return 'El ' . thesaurus($arg) . ' (' . $arg . ') no se ha configurado correctamente.'; break;
                    case 'not_string_config':               return 'El ' . thesaurus($arg) . ' (' . $arg . ') no tiene el formato correcto en la configuración (se espera una cadena de caracteres).'; break;
                    case 'empty_string_config':             return 'El ' . thesaurus($arg) . ' (' . $arg . ') está vacío en el archivo de configuración.'; break;
                    case 'unset_db_value':                  return 'El ' . thesaurus($arg) . ' es obligatorio.'; break;
                    default:
                        return $err;
                }
                break;
            default:
                switch ($err) {
                    case 'invalid_base_url':                return 'The base URL is invalid.'; break;
                    case 'no_smtp_host':                    return 'The SMTP server must be specified.'; break;
                    case 'invalid_smtp_port':               return 'The SMTP port is invalid.'; break;
                    case 'invalid_smtp_security':           return 'The SMTP security mode is invalid.'; break;
                    case 'invalid_smtp_user':               return 'The SMTP username must be a valid email address.'; break;
                    case 'no_smtp_password':                return 'The SMTP password must be specified.'; break;
                    case 'invalid_smtp_from':               return 'The SMTP sender address is invalid.'; break;
                    case 'invalid_wm_mail':                 return 'The webmaster email address is invalid.'; break;
                    case 'invalid_int_parameter':           return 'The parameter '. thesaurus($arg) . ' must be a positive integer.'; break;
                    case 'unfound_config_dir':              return 'The configuration directory cannot be found.'; break;
                    case 'unwrite_config_dir':              return 'The configuration directory is not writable. Please contact your IT department.'; break;
                    case 'unknown_db_setup':                return 'Unknown database setup mode.'; break;
                    case 'db_connect_failed':               return 'Unable to connect to the database.'; break;
                    case 'invalid_ssl_pilot':               return 'The PDO MySQL driver does not support TLS/SSL configuration.'; break;
                    case 'invalid_ssl_ca':                  return 'The CA certificate cannot be found or read.'; break;
                    case 'invalid_ssl_cert':                return 'The client certificate cannot be found or read.'; break;
                    case 'invalid_ssl_key':                 return 'The client certificate private key cannot be found or read.'; break;
                    case 'invalid_db_name':                 return 'The database name is invalid.'; break;
                    case 'existing_db_name':                return 'The database ' . $arg . ' already exists. Please check the selected installation mode.'; break;
                    case 'sql_install':                     return 'The SQL file required for installation cannot be found or read. Please check whether you have uploaded your installation files correctly.'; break;
                    case 'sql_install_read':                return 'The SQL file required for installation is empty or could not be read. Please check whether you have uploaded your installation files correctly and, if necessary, contact your IT department.'; break;
                    case 'execute_sql':                     return 'Error while executing statement ' . $arg['number'] . ' : ' . $arg['error']; break;
                    case 'database_not_selected':           return 'The specified database does not exist. Please check the selected installation mode or contact your IT department.'; break;
                    case 'invalid_database_object_class':   return 'The variables.php file does not appear to correspond to the installed version of LOGACer. Elements of type "' . $arg . '" do not exist in your installation. Please check the installation.'; break;
                    case 'missing_table':                   return 'The table "' . $arg . '" is missing from your database, although it is required by this version of LOGACer. Please check that the files have been loaded correctly and, if necessary, contact the LOGACer developer.'; break;
                    case 'missing_column':                  return 'The column "' . $arg['column'] . '" is missing from the table "' . $arg['table'] . '" in the database, although it is required by this version of LOGACer. Please check that the files have been loaded correctly and, if necessary, contact the LOGACer developer.'; break;
                    case 'missing_link_table':              return 'The table "' . $arg[0] . '" or "' . $arg[1] . '" is missing from your database, although it is required by this version of LOGACer. Please check that the files have been loaded correctly and, if necessary, contact the LOGACer developer.'; break;
                    case 'ambiguous_link_table':            return 'The tables "' . $arg[0] . '" and "' . $arg[1] . '" coexist, which should not be the case. Please check that the files have been loaded correctly and, if necessary, contact the LOGACer developer.'; break;
                    case 'missing_link_column':             return 'The column "' . $arg['column'] . '" is missing from the table "' . $arg['table'] . '" in the database, although it is required by this version of LOGACer. Please check that the files have been loaded correctly and, if necessary, contact the LOGACer developer.'; break;
                    case 'invalid_json':                    return 'Unable to convert the configuration to JSON: ' . $arg; break;
                    case 'error_write_json':                return 'Unable to write the temporary configuration file.'; break;
                    case 'error_convert_json_temp':         return 'Unable to complete the configuration save operation.'; break;
                    case 'error_read_json':                 return 'Unable to read the configuration file.'; break;
                    case 'error_invalid_json':              return 'The configuration file is unreadable or invalid: ' . $arg; break;
                    case 'error_config_version':            return 'The configuration version is missing or invalid.'; break;
                    case 'error_config_update':             return 'The configuration requires an update.'; break;
                    case 'not_in_config':                   return 'The ' . thesaurus($arg) . ' (' . $arg . ') has not been configured correctly.'; break;
                    case 'not_string_config':               return 'The ' . thesaurus($arg) . ' (' . $arg . ') has the wrong format in the configuration (a character string is expected).'; break;
                    case 'empty_string_config':             return 'The ' . thesaurus($arg) . ' (' . $arg . ') is empty in the configuration file.'; break;
                    case 'unset_db_value':                  return 'The ' . thesaurus($arg) . ' is required.'; break;
                    default:
                        return $err;
                }            
        }
    }
    $title = ucfirst(thesaurus("installation"));

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Réception et validation du formulaire
        // 1A. Création de la variable de configuration
        $config = [
            'db_server'             => $_POST['db_server'],
            'db_login'              => $_POST['db_login'],
            'db_pass'               => $_POST['db_password'],
            'db_name'               => $_POST['db_name'],
            'db_port'               => intval($_POST['db_port']),
            'db_tls_ssl'            => isset($_POST['db_ssl_enabled']),
            'db_ssl_ca'             => $_POST['db_ssl_ca'] ?? null,
            'db_ssl_cert'           => $_POST['db_ssl_cert'] ?? null,
            'db_ssl_key'            => $_POST['db_ssl_key'] ?? null,
            'base_url'              => $_POST['base_url'],
            'isolated_website'      => ($_POST['instance_mode'] === 'single_project'),
            'website_name'          => $_POST['server_name'] ?? 'LOGACer',
            'supported_languages'   => [],
            'webmaster_mail'        => $_POST['webmaster_mail'],
            'smtp_host'             => $_POST['smtp_host'],
            'smtp_port'             => intval($_POST['smtp_port']),
            'smtp_security'         => $_POST['smtp_security'],
            'smtp_user'             => $_POST['smtp_user'],
            'smtp_password'         => $_POST['smtp_password'],
            'smtp_from'             => $_POST['smtp_from'] ?? $_POST['server_name'] ?? 'LOGACer',
            'smtp_from_name'        => $_POST['smtp_from_name'] ?? 'LOGACer',
            'max_size_picture'      => $_POST['max_image_size_kb'] * 1000 ?? 50000,
            'max_size_file'         => $_POST['max_file_size_mb'] * 1000000 ?? 20000000,
            'max_loaded_objects'    => intval($_POST['max_loaded_objects']) ?? 500,
            'rows_per_page'         => intval($_POST['rows_per_page']) ?? 200,
            'allow_local_pictures'  => false,
            'version'               => VERSION
        ];
        // Choix des supported_languages
        foreach ($_POST['languages'] as $abbr) {
            if (in_array($abbr, ALL_LANGUAGES)) {
                $config['supported_languages'][array_search($abbr, ALL_LANGUAGES)] = $abbr;
            }
        }
        if (count($config['supported_languages']) < 1) {
            $config['supported_languages']['English'] = 'en';
        }


        // 1B. Vérification des données
        // 1B.1. URL de base
        if (
            !filter_var($config['base_url'], FILTER_VALIDATE_URL)
            || !in_array(
                strtolower(parse_url($config['base_url'], PHP_URL_SCHEME) ?? ''),
                ['http', 'https'],
                true
            )
        ) {
            $errors[] = "invalid_base_url";
        }

        // 1B.2. Paramètres SMTP
        if (empty($config['smtp_host'])) {
            $errors[] = "no_smtp_host";
        }

        if (!filter_var($config['smtp_port'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]])) {
            $errors[] = "invalid_smtp_port";
        }

        if (!in_array($config['smtp_security'], ['none', 'ssl', 'starttls'], true)) {
            $errors[] = "invalid_smtp_security";
        }

        if (!filter_var($config['smtp_user'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "invalid_smtp_user";
        }

        if (empty($config['smtp_password'])) {
            $errors[] = "no_smtp_password";
        }

        if (isset($config['smtp_from']) && !filter_var($config['smtp_from'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "invalid_smtp_from";
        }

        // 1B.3. Adresse électronique
        if (!filter_var($config['webmaster_mail'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "invalid_wm_mail";
        }

        // 1B.4. Limites d'affichage
        $positive_parameters = [
            'max_size_picture',
            'max_size_file',
            'max_loaded_objects',
            'rows_per_page'
        ];

        foreach ($positive_parameters as $parameter) {

            if (
                !isset($config[$parameter])
                || !filter_var(
                    $config[$parameter],
                    FILTER_VALIDATE_INT,
                    ['options' => ['min_range' => 1]]
                )
            ) {
                $errors[] = ['error'=>'invalid_int_parameter', 'arg'=>$parameter];
            }
        }

        // 1B.5. Stockage local
        // TO DO :
        // Si le stockage local est autorisé :
        // - vérifier l'existence du répertoire storage/
        // - vérifier les permissions de lecture et d'écriture
        // - vérifier éventuellement l'espace disponible
        //
        // Dans une version ultérieure :
        // - prévoir la vérification d'un stockage distant.

        // 1B.6. Vérification du répertoire de configuration
        $config_directory = __DIR__ . '/../config/';

        if (!is_dir($config_directory)) {
            $errors[] = "unfound_config_dir";
        } elseif (!is_writable($config_directory)) {
            $errors[] = "unwrite_config_dir";
        }

        foreach (['db_server', 'db_port', 'db_login', 'db_pass'] as $key) {
            if (!isset($config[$key])) {
                $errors[] = ['error' => 'unset_db_value', 'arg' => $key];
            }
        }
                    

        if (count($errors) === 0) {
            // 2. Connexion au serveur SQL et 3. création/complétion/vérification de la base de données
            $number_attempt_db = 0;
            $db_setup_mode = $_POST['db_setup_mode'];
            while ($number_attempt_db < 3 && $db_setup_mode !== 'validated') {
                $errors_db = [];
                
                try {
                    // Première étape : connexion au serveur SQL, sans sélectionner de base
                    $pdo_server = db_connect($config, false);

                    // Selon le mode choisi
                    switch ($db_setup_mode) {

                        case 'create':

                            // Création de la base
                            $errors_db = create_sql_database($pdo_server, $config);
                            if (count($errors_db) > 0) {
                                break;
                            }

                            // Passage à l'étape suivante
                            $db_setup_mode = 'complete';

                        case 'complete':
                            
                            // Vérification étape 1
                            $pdo = db_connect($config, true);

                            // Import du fichier SQL depuis ../config/schema.sql
                            $errors_db = import_sql_schema($pdo, __DIR__ . '/../config/schema.sql');

                            if (count($errors_db) > 0) {
                                $db_setup_mode = 'complete';
                                break;
                            }

                            // Passage à l'étape suivante
                            $db_setup_mode = 'prepared';

                        case 'prepared':
                            
                            // Vérification étape 1
                            $pdo = db_connect($config, true);

                            // Vérification étape 2 ; ATTENTION : plus tard, on pourrait vouloir mettre à jour plutôt que détruire et recommencer.
                            $errors_db = verify_sql_schema($pdo);
                            if (count($errors_db) > 0) {
                                $db_setup_mode = 'complete';
                            } else {
                                $db_setup_mode = 'validated';
                            }

                            break;

                        default:
                            $errors_db = ["unknown_db_setup"];
                            $number_attempt_db = 9999;

                    }

                    $number_attempt_db++;
                    
                } catch (PDOException $e) {
                    $number_attempt_db++;
                    $errors_db = ["db_connect_failed"];
                    // Vérification de l'existence de la base
                    try {
                        $query = $pdo_server->prepare("
                            SELECT COUNT(*)
                            FROM information_schema.schemata
                            WHERE schema_name = :database
                        ");

                        $query->execute([
                            'database' => $config['db_name']
                        ]);

                        $database_exists = (int) $query->fetchColumn() > 0;

                    } catch (PDOException $e_check) {
                        $database_exists = false;
                    }
                    if ($database_exists) {
                        $db_setup_mode = 'complete';
                    } else {
                        $db_setup_mode = 'create';
                    }
                } catch (RuntimeException $e) {
                    $number_attempt_db++;
                    $errors_db = [$e->getMessage()];
                }
            }

            if ($db_setup_mode !== 'validated') {
                $errors = $errors_db;
            } else {

                // 4. Vérifications complémentaires
                // Structure SQL, connexions, prérequis nécessaires

                if (empty($errors)) {

                    // 5. Enregistrement de la configuration
                    $config_file = __DIR__ . '/../config/configuration.json';

                    $errors = save_configuration($config, $config_file);

                }

                if (empty($errors)) {

                    // On utilise la fonction dans variables.php pour définir les constantes
                    $errors = load_configuration($config_file);

                    if (empty($errors)) {
                        // 6. Redirection vers l'inscription
                        if (ISOLATED_WEBSITE) {
                            header('Location: ' . create_url(['register']));
                        } else {
                            header('Location: ' . create_url(['logacer', 'register']));
                        }
                        exit;
                    }

                }

            }
        }


    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("headers.php"); ?>
    <body>
        <div class="maindiv container my-4 my-lg-5">

            <div class="mb-4">
                <h1 class="mb-2">
                    <i class="bi bi-gear-wide-connected me-2"></i>
                    <?php echo ucfirst(thesaurus("logacer_installation")); ?>
                </h1>
                <p class="text-muted">
                    <?php echo ucfirst(thesaurus("logacer_install_text")); ?>
                </p>
            </div>

            <div class="alert alert-info" role="note">
                <i class="bi bi-info-circle me-2"></i>
                <strong><?php echo ucfirst(thesaurus("loginst_before_begin")); ?></strong><?php echo ucfirst(thesaurus("loginst_have_info")); ?>
                <br><strong><?php echo ucfirst(thesaurus("loginst_warning_reinst")); ?></strong>
            </div>

            <?php if (count($errors) > 0) {
                echo "<div class='alert alert-danger' role='note'>
                    <strong>" . ucfirst(thesaurus("loginst_errors")) . "</strong><ul>";
                foreach ($errors as $error) {
                    echo li(error_install($error));
                }
                echo "</ul></div>";
            } ?>


            <form id="installationForm" method="post" action="">

                <!-- 1. Base de données -->
                <section class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-database me-2"></i>
                            1. <?php echo ucfirst(thesaurus("database")); ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            <?php echo ucfirst(thesaurus("loginst_db")); ?>
                        </p>

                        <label class="form-label d-block">
                            <?php echo ucfirst(thesaurus("db_setup_mode")); ?>
                            <abbr title="<?php echo ucfirst(thesaurus("db_setup_mode_abbr")); ?>">
                                <i class="bi bi-info-circle"></i>
                            </abbr>
                        </label>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="db_setup_mode" id="db_setup_prepared" value="prepared"<?php if (isset($config) && isset($config["db_setup_mode"])) { if ($config["db_setup_mode"] === 'prepared') { echo " checked"; }} else { echo " checked"; } ?>>
                            <label class="form-check-label" for="db_setup_prepared">
                                <?php echo ucfirst(thesaurus("db_setup_mode_prep")); ?>
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="db_setup_mode" id="db_setup_complete" value="complete"<?php if (isset($config) && isset($config["db_setup_mode"]) && $config["db_setup_mode"] === 'complete') { echo " checked"; } ?>>
                            <label class="form-check-label" for="db_setup_complete">
                                <?php echo ucfirst(thesaurus("db_setup_mode_complete")); ?>
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="db_setup_mode" id="db_setup_create" value="create"<?php if (isset($config) && isset($config["db_setup_mode"]) && $config["db_setup_mode"] === 'create') { echo " checked"; } ?>>
                            <label class="form-check-label" for="db_setup_create">
                                <?php echo ucfirst(thesaurus("db_setup_mode_create")); ?>
                            </label>
                        </div>

                        <div class="form-text mb-3">
                            <?php echo ucfirst(thesaurus("db_setup_mode_comment")); ?>
                        </div>

                        <hr>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="db_server" class="form-label">
                                    <?php echo ucfirst(thesaurus("db_server")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("db_server_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="text" class="form-control"
                                       id="db_server" name="db_server"
                                       placeholder="localhost" required <?php if (isset($config) && isset($config['db_server'])) { echo ' value="' . $config['db_server'] . '"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="db_port" class="form-label">
                                    <?php echo ucfirst(thesaurus("db_port")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("db_port_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="number" class="form-control"
                                       id="db_port" name="db_port"
                                       <?php if (isset($config) && isset($config['db_port'])) { echo ' value="' . $config['db_port'] . '"'; } else { echo ' value="3306"'; } ?> min="1" max="65535" required>
                            </div>

                            <div class="col-md-6">
                                <label for="db_name" class="form-label">
                                    <?php echo ucfirst(thesaurus("db_name")); ?>
                                </label>
                                <input type="text" class="form-control"
                                       id="db_name" name="db_name" required<?php if (isset($config) && isset($config['db_name'])) { echo ' value="' . $config['db_name'] . '"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="db_login" class="form-label">
                                    <?php echo ucfirst(thesaurus("db_login")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("db_login_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="text" class="form-control"
                                       id="db_login" name="db_login" required<?php if (isset($config) && isset($config['db_login'])) { echo ' value="' . $config['db_login'] . '"'; } ?>>
                            </div>

                            <div class="col-12">
                                <label for="db_password" class="form-label">
                                    <?php echo ucfirst(thesaurus("db_password")); ?>
                                </label>
                                <input type="password" class="form-control"
                                       id="db_password" name="db_password"
                                       autocomplete="new-password" required<?php if (isset($config) && isset($config['db_password'])) { echo ' value="' . $config['db_password'] . '"'; } ?>>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       id="db_ssl_enabled" name="db_ssl_enabled"
                                       value="1"<?php if (isset($config) && isset($config['db_tls_ssl']) && $config['db_tls_ssl']) { echo ' checked'; } ?>>
                                <label class="form-check-label" for="db_ssl_enabled">
                                    <?php echo ucfirst(thesaurus("db_ssl_enabled")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("db_ssl_enabled_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                            </div>

                            <div id="dbSslOptions" class="border rounded p-3 mt-3 d-none">
                                <div class="mb-3">
                                    <label for="db_ssl_ca" class="form-label">
                                        <?php echo ucfirst(thesaurus("db_ssl_ca")); ?>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="db_ssl_ca" name="db_ssl_ca"<?php if (isset($config) && isset($config['db_ssl_ca'])) { echo ' value="' . $config['db_ssl_ca'] . '"'; } ?>>
                                </div>

                                <div class="mb-3">
                                    <label for="db_ssl_cert" class="form-label">
                                        <?php echo ucfirst(thesaurus("db_ssl_cert")); ?>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="db_ssl_cert" name="db_ssl_cert"<?php if (isset($config) && isset($config['db_ssl_cert'])) { echo ' value="' . $config['db_ssl_cert'] . '"'; } ?>>
                                </div>

                                <div>
                                    <label for="db_ssl_key" class="form-label">
                                        <?php echo ucfirst(thesaurus("db_ssl_key")); ?>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="db_ssl_key" name="db_ssl_key"<?php if (isset($config) && isset($config['db_ssl_key'])) { echo ' value="' . $config['db_ssl_key'] . '"'; } ?>>
                                </div>

                                <div class="form-text mt-2">
                                    <?php echo ucfirst(thesaurus("db_ssl_text")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. Paramètres généraux -->
                <section class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-sliders me-2"></i>
                            2. <?php echo ucfirst(thesaurus("general parameters")); ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="base_url" class="form-label">
                                <?php echo ucfirst(thesaurus("base_url")); ?>
                                <abbr title="<?php echo ucfirst(thesaurus("base_url_abbr")); ?>">
                                    <i class="bi bi-info-circle"></i>
                                </abbr>
                            </label>
                            <input type="url" class="form-control"
                                   id="base_url" name="base_url"
                                   placeholder="https://logacer.universite.edu/"
                                   required<?php if (isset($config) && isset($config['base_url'])) { echo ' value="' . $config['base_url'] . '"'; } ?>>
                        </div>

                        <div class="mb-3">
                            <label for="instance_mode" class="form-label">
                                <?php echo ucfirst(thesaurus("loginst_instance_mode")); ?>
                                <abbr title="<?php echo ucfirst(thesaurus("loginst_instance_mode_abbr")); ?>">
                                    <i class="bi bi-info-circle"></i>
                                </abbr>
                            </label>
                            <select class="form-select" id="instance_mode"
                                    name="instance_mode" required>
                                <option value="single_project"<?php if (isset($config) && isset($config['instance_mode']) && $config['instance_mode'] === 'single_project') { echo ' selected'; } ?>>
                                    <?php echo ucfirst(thesaurus("loginst_single_p")); ?>
                                </option>
                                <option value="multi_project"<?php if (isset($config) && isset($config['instance_mode']) && $config['instance_mode'] === 'multi_project') { echo ' selected'; } ?>>
                                    <?php echo ucfirst(thesaurus("loginst_multiple_p")); ?>
                                </option>
                            </select>
                        </div>

                        <div id="multiProjectOptions" class="mb-3 d-none">
                            <label for="server_name" class="form-label">
                                <?php echo ucfirst(thesaurus("website_name")); ?>
                            </label>
                            <input type="text" class="form-control"
                                   id="server_name" name="server_name"
                                   <?php if (isset($config) && isset($config['server_name'])) { echo ' value="' . $config['server_name'] . '"'; } else { echo ' value="LOGACer"'; } ?>>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">
                                <?php echo ucfirst(thesaurus("available_langs")); ?>
                                <abbr title="<?php echo ucfirst(thesaurus("available_langs_abbr")); ?>">
                                    <i class="bi bi-info-circle"></i>
                                </abbr>
                            </label>

                            <div class="row g-2">

                            <?php foreach (ALL_LANGUAGES as $lang => $abbr) { ?>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox" name="languages[]"
                                               id="lang_<?php echo $abbr; ?>" value="<?php echo $abbr; ?>"<?php if (isset($config) && isset($config['supported_languages']) && in_array($abbr, $config['supported_languages'])) { echo ' checked'; } ?>>
                                        <label class="form-check-label" for="lang_<?php echo $abbr; ?>">
                                            <?php echo $lang; ?>
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>
                                
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="webmaster_mail" class="form-label">
                                <?php echo ucfirst(thesaurus("webmaster_mail")); ?>
                                <abbr title="<?php echo ucfirst(thesaurus("webmaster_mail_abbr")); ?>">
                                    <i class="bi bi-info-circle"></i>
                                </abbr>
                            </label>
                            <input type="email" class="form-control"
                                   id="webmaster_mail" name="webmaster_mail"
                                   placeholder="nom.prenom@universite.edu"
                                   required<?php if (isset($config) && isset($config['webmaster_mail'])) { echo ' value="' . $config['webmaster_mail'] . '"'; } ?>>
                        </div>

                    </div>
                </section>


                <!-- 3. Courriels -->
                <section class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-envelope me-2"></i>
                            3. <?php echo ucfirst(thesaurus("loginst_smtp")); ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            <?php echo ucfirst(thesaurus("loginst_smtp_text")); ?>
                        </p>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="smtp_host" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_host")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("smtp_host_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="text" class="form-control"
                                       id="smtp_host" name="smtp_host" required<?php if (isset($config) && isset($config['smtp_host'])) { echo ' value="' . $config['smtp_host'] . '"'; } ?>>
                            </div>

                            <div class="col-md-4">
                                <label for="smtp_port" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_port")); ?>
                                </label>
                                <input type="number" class="form-control"
                                       id="smtp_port" name="smtp_port"
                                       min="1" max="65535" placeholder="587" required<?php if (isset($config) && isset($config['smtp_port'])) { echo ' value="' . $config['smtp_port'] . '"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_security" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_security")); ?>
                                </label>
                                <select class="form-select" id="smtp_security"
                                        name="smtp_security">
                                    <option value="starttls"<?php if (isset($config) && isset($config['smtp_security']) && $config['smtp_security'] === 'starttls') { echo ' selected'; } ?>><?php echo ucfirst(thesaurus("smtp_starttls")); ?></option>
                                    <option value="ssl"<?php if (isset($config) && isset($config['smtp_security']) && $config['smtp_security'] === 'ssl') { echo ' selected'; } ?>><?php echo ucfirst(thesaurus("smtp_ssl")); ?></option>
                                    <option value="none"<?php if (isset($config) && isset($config['smtp_security']) && $config['smtp_security'] === 'none') { echo ' selected'; } ?>><?php echo ucfirst(thesaurus("smtp_none")); ?></option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_user" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_user")); ?>
                                </label>
                                <input type="email" class="form-control"
                                       id="smtp_user" name="smtp_user" required<?php if (isset($config) && isset($config['smtp_user'])) { echo ' value="' . $config['smtp_user'] . '"'; } ?>>
                            </div>

                            <div class="col-12">
                                <label for="smtp_password" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_password")); ?>
                                </label>
                                <input type="password" class="form-control"
                                       id="smtp_password" name="smtp_password"
                                       autocomplete="new-password" required<?php if (isset($config) && isset($config['smtp_password'])) { echo ' value="' . $config['smtp_password'] . '"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_from" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_from")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("smtp_from_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="email" class="form-control"
                                       id="smtp_from" name="smtp_from"
                                       placeholder="noreply@exemple.org"<?php if (isset($config) && isset($config['smtp_from'])) { echo ' value="' . $config['smtp_from'] . '"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_from_name" class="form-label">
                                    <?php echo ucfirst(thesaurus("smtp_from_name")); ?>
                                </label>
                                <input type="text" class="form-control"
                                       id="smtp_from_name" name="smtp_from_name"
                                       placeholder="LOGACer"<?php if (isset($config) && isset($config['smtp_from_name'])) { echo ' value="' . $config['smtp_from_name'] . '"'; } ?>>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 4. Limites -->
                <section class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-speedometer2 me-2"></i>
                            4. <?php echo ucfirst(thesaurus("loginst_limits")); ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            <?php echo ucfirst(thesaurus("loginst_limits_text")); ?>
                        </p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="max_image_size_kb" class="form-label">
                                    <?php echo ucfirst(thesaurus("max_image_size")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("max_image_size_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="number" class="form-control"
                                       id="max_image_size_kb"
                                       name="max_image_size_kb"
                                       min="1" step="1"<?php if (isset($config) && isset($config['max_image_size_kb'])) { echo ' value="' . $config['max_image_size_kb'] . '"'; } else { echo ' value="500"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="max_file_size_mb" class="form-label">
                                    <?php echo ucfirst(thesaurus("max_file_size")); ?>
                                </label>
                                <input type="number" class="form-control"
                                       id="max_file_size_mb"
                                       name="max_file_size_mb"
                                       min="1" step="1"<?php if (isset($config) && isset($config['max_file_size_mb'])) { echo ' value="' . $config['max_file_size_mb'] . '"'; } else { echo ' value="20"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="max_loaded_objects" class="form-label">
                                    <?php echo ucfirst(thesaurus("max_loaded_objects")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("max_loaded_objects_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="number" class="form-control"
                                       id="max_loaded_objects"
                                       name="max_loaded_objects"
                                       min="1" step="1"<?php if (isset($config) && isset($config['max_loaded_objects'])) { echo ' value="' . $config['max_loaded_objects'] . '"'; } else { echo ' value="200"'; } ?>>
                            </div>

                            <div class="col-md-6">
                                <label for="rows_per_page" class="form-label">
                                    <?php echo ucfirst(thesaurus("rows_per_page")); ?>
                                    <abbr title="<?php echo ucfirst(thesaurus("rows_per_page_abbr")); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </abbr>
                                </label>
                                <input type="number" class="form-control"
                                       id="rows_per_page"
                                       name="rows_per_page"
                                       min="1" step="1"<?php if (isset($config) && isset($config['rows_per_page'])) { echo ' value="' . $config['rows_per_page'] . '"'; } else { echo ' value="500"'; } ?>>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 5. Stockage -->
                <section class="card shadow-sm mb-4" style="display:none">
                    <div class="card-header bg-light py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-folder2-open me-2"></i>
                            5. Stockage des fichiers et des images
                        </h2>
                    </div>

                    <div class="card-body">
                        <p>
                            Indiquez si cette installation est autorisée à stocker les fichiers et les images sur son serveur, et si un emplacement spécifique est prévu pour cela.
                        </p>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio"
                                   name="local_storage_allowed"
                                   id="local_storage_yes" value="1" checked>
                            <label class="form-check-label" for="local_storage_yes">
                                Stockage des fichiers et images au sein de l'application (option conseillée si vous disposez d'un serveur avec un espace de stockage conséquent)
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio"
                                   name="local_storage_allowed"
                                   id="local_storage_yes" value="1" checked>
                            <label class="form-check-label" for="local_storage_yes">
                                Stockage des fichiers et images sur un serveur ou répertoire dédié (à définir avec votre service informatique)
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio"
                                   name="local_storage_allowed"
                                   id="local_storage_no" value="0">
                            <label class="form-check-label" for="local_storage_no">
                                Stockage local non autorisé (préférable pour une installation sur un serveur avec peu d'espace)
                            </label>
                        </div>

                        <div id="localStorageOptions">
                            <label for="storage_path" class="form-label">
                                Répertoire de stockage (facultatif)
                                <abbr title="Chemin du répertoire utilisé pour stocker les fichiers. Le serveur PHP doit disposer des droits nécessaires.">
                                    <i class="bi bi-info-circle"></i>
                                </abbr>
                            </label>
                            <input type="text" class="form-control"
                                   id="storage_path" name="storage_path"
                                   placeholder="Répertoire par défaut"
                                   autocomplete="off">

                            <div class="form-text">
                                Laissez ce champ vide pour utiliser le chemin
                                par défaut de l'application.
                            </div>
                        </div>

                        <div id="remoteStorageNotice"
                             class="alert alert-info d-none mt-3 mb-0">
                            Le stockage local étant désactivé, un mécanisme de
                            stockage externe devra être configuré avant de
                            permettre les fonctionnalités nécessitant des fichiers.
                            Le stockage distant n'est pas encore implémenté.
                        </div>
                    </div>
                </section>


                <!-- Actions -->
                <div class="d-flex flex-column flex-sm-row
                            justify-content-between align-items-sm-center
                            gap-3 mb-5">

                    <p class="text-muted small mb-0">
                        <i class="bi bi-shield-lock me-1"></i>
                        <?php echo ucfirst(thesaurus("loginst_need_val")); ?>
                    </p>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check2-circle me-2"></i>
                        <?php echo ucfirst(thesaurus("loginst_submit")); ?>
                    </button>
                </div>

            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sslCheckbox =
                    document.getElementById('db_ssl_enabled');
                const sslOptions =
                    document.getElementById('dbSslOptions');

                const instanceMode =
                    document.getElementById('instance_mode');
                const multiProjectOptions =
                    document.getElementById('multiProjectOptions');
                const serverName =
                    document.getElementById('server_name');

                const localStorageYes =
                    document.getElementById('local_storage_yes');
                const localStorageNo =
                    document.getElementById('local_storage_no');
                const localStorageOptions =
                    document.getElementById('localStorageOptions');
                const remoteStorageNotice =
                    document.getElementById('remoteStorageNotice');

                function updateSslOptions() {
                    sslOptions.classList.toggle(
                        'd-none',
                        !sslCheckbox.checked
                    );
                }

                function updateInstanceMode() {
                    const isMultiProject =
                        instanceMode.value === 'multi_project';

                    multiProjectOptions.classList.toggle(
                        'd-none',
                        !isMultiProject
                    );

                    serverName.required = isMultiProject;
                }

                function updateStorageOptions() {
                    const localStorageEnabled =
                        localStorageYes.checked;

                    localStorageOptions.classList.toggle(
                        'd-none',
                        !localStorageEnabled
                    );

                    remoteStorageNotice.classList.toggle(
                        'd-none',
                        localStorageEnabled
                    );
                }

                sslCheckbox.addEventListener(
                    'change',
                    updateSslOptions
                );

                instanceMode.addEventListener(
                    'change',
                    updateInstanceMode
                );

                localStorageYes.addEventListener(
                    'change',
                    updateStorageOptions
                );

                localStorageNo.addEventListener(
                    'change',
                    updateStorageOptions
                );

                updateSslOptions();
                updateInstanceMode();
                updateStorageOptions();
            });
        </script>
    </body>
</html>
        
