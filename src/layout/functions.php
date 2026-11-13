<?php
    require_once "../extensions/altorouter/AltoRouter.php";
    require_once "../extensions/vendor/autoload.php";
    require_once "../extensions/phpmailer/src/Exception.php";
    require_once "../extensions/phpmailer/src/PHPMailer.php";
    require_once "../extensions/phpmailer/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function send_email($recipient, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = SMTP_SECURITY;
            $mail->Port       = SMTP_PORT;

            $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
            $mail->addAddress($recipient);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            return $mail->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi mail vers " . $recipient . " : " . $mail->ErrorInfo);
            return false;
        }
    }

    function app_log(
        string $level,
        string $message,
        array $context = []
    ): void {
        $entry = [
            'timestamp' => date('c'),
            'level'     => strtoupper($level),
            'message'   => $message,
            'context'   => $context,
        ];

        error_log(
            json_encode(
                $entry,
                JSON_UNESCAPED_SLASHES
                | JSON_UNESCAPED_UNICODE
                | JSON_INVALID_UTF8_SUBSTITUTE
            ) ?: '{"level":"ERROR","message":"Log encoding failed"}'
        );
    }

    function log_page_access(string $page, string $user = "", ?float $start_time = null): void
    {
        app_log('LOAD', 'Consulted', [
            'page' => $page,
            'user' => $user,
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
            'duration_ms' => $start_time !== null
                ? round((microtime(true) - $start_time) * 1000, 2)
                : null,
        ]);
    }

    function my_autoload($class) {
        if(preg_match('/\A\w+\Z/', $class)) {
            include '../layout/classes/' . strtolower($class) . '.class.php';
        }
    }
    spl_autoload_register('my_autoload');

    /* A utiliser pour transformer un code depuis URL en un code lisible */
    function rud($string) {
        $string = rawurldecode($string);
        // Suivants : pas utile ?
        $string = str_replace('&#039;', "'", $string);
        $string = str_replace('&amp;', "&", $string);
        return str_replace('%2E', '.', $string);
    }

    /* A utiliser pour transformer un code en un chemin URL */
    function rue($string, $extension=false) {
        if (!$extension) {
            $string = str_replace('.', '%2E', $string);
        } else {
            $lastpoint = strrpos($string, '.');
            $first = substr($string, 0, $lastpoint);
            $last = substr($string, $lastpoint);
            $string = str_replace('.', '%2E', $first) . $last;
        }
        return secure(rawurlencode($string));
    }

    function secure($text = FALSE, $html = 0) {
    /* Permet d'afficher le texte avec une certaine sécurité au niveau de l'HTML. Il existe trois principaux modes :
    - 0 (rien d'affiché) : les éléments HTML sont affichés sans être évalués ;
    - 1 : les éléments HTML autorisés sont convertis en balises HTML, les autres sans être évalués ;
    */
        if (!$text) {
            return "";
        }
        elseif ($html === 1) {
            return strip_tags($text, '<b><strong><i><em><h3><h4><h5><h6><p><br><ol><ul><li><a>');
        } else {
            return htmlspecialchars($text);
        }
    }

    /* Vérifie si une clé existe dans $_POST, si oui retourne cet élément avec protections, sinon retourne texte vide */
    function check_post($key, $html = 0) {
        if (isset($_POST[$key])) {
            return text_secure($_POST[$key], $html);
        } else {
            return "";
        }
    }

    /* To do : convert markdown text into html text. Pour l'autre sens : text_secure($text, 2) */
    function check_br($part, $html) {
        if (strlen($part) > 1) {
            if ($part[-1] === ' ' AND $part[-2] === ' ') {
                return substr($part, 0, -2) . $html . '<br/>';
            } else {
                return $part . $html;
            }
        } else {
            return $part . $html;
        }
    }
    function markdown_to_html($text) {
        if ($text) {
            /* Gère les paragraphes en général */
            $newtext = '';
            $array = explode(PHP_EOL, $text);
            /* Variables des listes */
            $ol = FALSE;
            $ul = FALSE;
            $iol = FALSE;
            $iul = FALSE;
            $array_numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
            
            foreach($array as $part) {
                /* Vérifie s'il s'agit de titres */
                if ($part[0] === "#") {
                    if ($part[1] === "#" AND $part[2] === "#") {
                        if ($part[3] === "#") {
                            if ($part[4] === "#") {
                                if ($part[5] === "#") {
                                    $part = '<h6>' . check_br(substr($part, 7), '</h6>');
                                } else {
                                    $part = '<h5>' . check_br(substr($part, 6), '</h5>');
                                }
                            } else {
                                $part = '<h4>' . check_br(substr($part, 5), '</h4>');
                            }
                        } else {
                            $part = '<h3>' . check_br(substr($part, 4), '</h3>');
                        }
                    }
                /* Gestion des listes */
                } elseif (strlen($part) > 3) {
                    if (in_array($part[0], $array_numbers)) {
                        if ($part[1] == "." AND $part[2] == " ") {
                            if (!$ol) {
                                if ($part[0] == '1') {
                                    if ($iol) {
                                        $add = '\n</ol>';
                                        $iol = FALSE;
                                    } elseif ($iul) {
                                        $add = '\n</ul>';
                                        $iul = FALSE;
                                    }
                                    $part = '<ol>\n<li>' . check_br(substr($part, 3), '</li>');
                                    $ol = TRUE;
                                }
                            } else {
                                if ($iol) {
                                    $add = '\n</ol>';
                                    $iol = FALSE;
                                } elseif ($iul) {
                                    $add = '\n</ul>';
                                    $iul = FALSE;
                                }
                                $part = '<li>' . check_br(substr($part, 3), '</li>');
                            }
                        }
                    }
                    if ($part[0] == "-" AND $part[1] == " ") {
                        if ($iol) {
                            $add = '\n</ol>';
                            $iol = FALSE;
                        } elseif ($iul) {
                            $add = '\n</ul>';
                            $iul = FALSE;
                        }
                        if (!$ul) {
                            $part = '<ul>\n<li>' . check_br(substr($part, 2), '</li>');
                            $ul = TRUE;
                        } else {
                            $part = '<li>' . check_br(substr($part, 2), '</li>');
                        }
                    }
                    if ($part[0] == ' ' AND $part[1] == ' ' AND $part[2] == ' ' AND $part[3] == ' ') {
                        $part = substr($part, 4);
                        if (strlen($part) > 3) {
                            if (in_array($part[0], $array_numbers)) {
                                if ($part[1] == "." AND $part[2] == " ") {
                                    if (!$iol) {
                                        if ($part[0] == '1') {
                                            $part = '<ol>\n<li>' . check_br(substr($part, 3), '</li>');
                                            $iol = TRUE;
                                        }
                                    } else {
                                        $part = '<li>' . check_br(substr($part, 3), '</li>');
                                    }
                                }
                            }
                            if ($part[0] == "-" AND $part[1] == " ") {
                                if (!$iul) {
                                    $part = '<ul>\n<li>' . check_br(substr($part, 2), '</li>');
                                    $iul = TRUE;
                                } else {
                                    $part = '<li>' . check_br(substr($part, 2), '</li>');
                                }
                            }
                        }
                    }
                }
                /* Vérifie si la liste doit être fermée */
                if (strlen($part) > 3) {
                    /* Vérifie si le premier substring correspond à <li>, <ul> ou <ol> */
                    if (!in_array(substr($part, 0, 4), array('<li>', '<ul>', '<ol>'))) {
                        $check = TRUE;
                    }
                } else {
                    $check = TRUE;
                }
                if (isset($check)) {
                    if (!isset($add)) {
                        $add = '';
                    }
                    if ($iul) {
                        if ($ol) {
                            $add .= '</ul>\n</ol>';
                            $iul = FALSE;
                            $ol = FALSE;
                        } elseif ($ul) {
                            $add .= '</ul>\n</ul>';
                            $iul = FALSE;
                            $ul = FALSE;
                        }
                    } elseif ($iol) {
                        if ($ol) {
                            $add .= '</ol>\n</ol>';
                            $iol = FALSE;
                            $ol = FALSE;
                        } elseif ($ul) {
                            $add .= '</ol>\n</ul>';
                            $iol = FALSE;
                            $ul = FALSE;
                        }
                    } elseif ($ul) {
                        $add .= '</ul>';
                    } elseif ($ol) {
                        $add .= '</ol>';
                    }
                }
                /* Vérifie si on doit faire des paragraphes */
                if (strlen($part) > 0) {
                    if ($part[0] != '<') {
                        if ($part === '  ') {
                            $part = '<br>';
                        } else {
                            $part = '<p>' . check_br($part, '</p>');
                        }
                    }
                }

                if (strlen($add) > 0) {
                    $newtext .= $add;
                }
                if (strlen($newtext) > 0) {
                    $newtext .= $part;
                } else {
                    $newtext = $part;
                }
            }

            $text = $newtext;

            /* Gère les italiques et les gras */
            $convert = array(
                '***' => '***',
                '**' => 'strong',
                '*' => 'em',
            );
            $newtext = $text;
            foreach($convert as $markdown=>$html) {
                /* Subdivise selon l'expression */
                $array = explode($markdown, $newtext);

                /* Vérifie si le nombre de subdivisions est cohérente, sinon ne fait rien. */
                if (count($array) % 2 === 1) {

                    /* Ajoute les balises nécessaires */
                    $newtext = "";
                    $status = 0;
                    foreach ($array as $part) {
                        if (strlen($part) > 0) {
                            if ($newtext[-1] != "\\" OR $status === 0) {
                                $newtext .= $part;
                                $status = 1;
                            } elseif ($status === 1) {
                                if ($html = '***') { $newtext = $newtext . "<strong><em>" . $part;
                                } else { $newtext = $newtext . "<" . $html . ">" . $part; }
                                $status = 2;
                            } elseif ($status === 2) {
                                if ($html = '***') { $newtext = $newtext . "</strong></em>" . $part;
                                } else { $newtext = $newtext . "</" . $html . ">" . $part; }
                                $status = 1;
                            }
                        }
                    }
                }
            }
            return $newtext;
        } else {
            return "";
        }
    }

/*    function sites_accessibles(int $iduser, int $public = 1) {
    /* Fournit une liste de sites accessibles pour l'utilisateur, du type id1, id2..., avec les paramètres suivants :
    - Si owner = 0, on ne tient compte que des cas publics, si public est implémenté
    - Si public = 1, on tient compte des cas publics (pas encore implémenté) ;
    - Si public = 0, on n'en tient pas compte */
/*        try {
            /* Initialise la connexion */
/*            $serveur = SERVEUR; $dbname = DBNAME; $login = LOGIN; $pass = PASS;
            $connexion = new PDO("mysql:host=$serveur;dbname=$dbname", $login, $pass);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /* Initialise les variables */
/*            $idsites_array = array();

            /* Array de sites */
/*            if ($iduser > 0) {
                /* Case 1-4 : l'utilisateur est owner, contributeur, ou owner ou contributeur d'un projet */
/*                $request = $connexion->query("SELECT id AS idsite FROM site WHERE owner = $iduser
                    UNION SELECT site AS idsite FROM link_site_contributor WHERE contributor = $iduser
                    UNION SELECT site.id AS idsite FROM site
                        INNER JOIN project ON site.project = project.id
                        WHERE project.owner = $iduser
                    UNION SELECT site.id AS idsite FROM site
                        INNER JOIN project ON site.project = project.id
                        INNER JOIN link_project_contributor ON link_project_contributor.project = project.id
                        WHERE link_project_contributor.contributor = $iduser");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idsites_array[] = $array['idsite'];
                }
            }
            if ($public = 1) {
                /* Case 5 : sites publics */
/*                $request = $connexion->query("SELECT id AS idsite FROM site WHERE public = 1");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idsites_array[] = $array['idsite'];
                }
            }
            
            /* Enlève les valeurs multiples */
/*            $idsites_array = array_unique($idsites_array);

            /* Retourne le résultat */
/*            return implode(',', $idsites_array);

        }

        catch (PDOException $e) {
            echo 'Echec de la connexion : ' . $e -> getMessage();
        }
    } */

    function projects_accessibles(int $iduser) {
        try {
            /* Initialise la connexion */
            $connexion = db_connect();

            /* Initialise les variables */
            $idprojects_array = array();

            /* Array de sites */
                /* Case 1 : l'utilisateur est owner */
                $request = $connexion->query("SELECT id AS idproject FROM project WHERE owner = $iduser");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idprojects_array[] = $array['idproject'];
                }
                /* Case 2 : l'utilisateur est contributeur */
                $request = $connexion->query("SELECT project AS idproject FROM link_project_contributor WHERE contributor = $iduser");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idprojects_array[] = $array['idproject'];
                }
    
            /* Enlève les valeurs multiples */
            $idprojects_array = array_unique($idprojects_array);

            /* Retourne le résultat */
            return implode(',', $idprojects_array);
        }

        catch (PDOException $e) {
            echo 'Echec de la connexion : ' . $e -> getMessage();
        }
    }

    function horizons_accessibles(int $iduser, int $public = 1) {
        try {
            /* Initialise la connexion */
            $connexion = db_connect();

            /* Initialise les variables */
            $idfacies_array = array();
            $idhorizons_array = array();

            /* Array de facies */
                /* Case 1-2 : l'utilisateur est owner ou contributeur */
                $request = $connexion->query("SELECT id AS idfacies FROM facies WHERE owner = $iduser
                    UNION SELECT facies AS idfacies FROM link_facies_contributor WHERE contributor = $iduser");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idfacies_array[] = $array['idfacies'];
                }
                if ($public = 1) {
                    /* Case 3 : faciès publics */
                    $request = $connexion->query("SELECT id AS idfacies FROM facies WHERE public = 1");
                    $add = $request->fetchAll();
                    foreach($add as $array) {
                        $idfacies_array[] = $array['idfacies'];
                    }
                }
    
            /* Enlève les valeurs multiples et crée la liste des facies */
            $idfacies_array = array_unique($idfacies_array);
            if (empty($idfacies_array)) {
                $idfacies = '0';
            } else {
                $idfacies = implode(',', $idfacies_array);
            }

            /* Crée la liste des horizons */
            $request = $connexion->query("SELECT id FROM horizon WHERE facies IN ($idfacies)");
            $add = $request->fetchAll();
            foreach($add as $array) {
                $idhorizons_array[] = $array['id'];
            }

            /* Retourne le résultat */
            if (empty($idhorizons_array)) {
                return '0';
            } else {
                return implode(',', $idhorizons_array);
            }
        }

        catch (PDOException $e) {
            echo 'Echec de la connexion : ' . $e -> getMessage();
        }
    }

    function typologies_accessibles(int $iduser, int $public = 1) {
        /* Fournit une liste de typologies accessibles pour l'utilisateur, du type id1, id2..., avec les paramètres suivants :
        - Si owner = 0, on ne tient compte que des cas publics, si public est implémenté
        - Si public = 1, on tient compte des cas publics ;
        - Si public = 0, on n'en tient pas compte */
        try {
            /* Initialise la connexion */
            $connexion = db_connect();
    
            /* Initialise les variables */
            $idtypologies_array = array();
    
            /* Array de typologies */
            if ($iduser > 0) {
                /* Case 1-4 : l'utilisateur est owner, contributeur, ou owner ou contributeur d'un projet */
                $request = $connexion->query("SELECT id AS idtypology FROM typology WHERE owner = $iduser
                    UNION SELECT typology AS idtypology FROM link_typology_contributor WHERE contributor = $iduser
                    UNION SELECT typology.id AS idtypology FROM typology
                        INNER JOIN project ON typology.project = project.id
                        WHERE project.owner = $iduser
                    UNION SELECT typology.id AS idtypology FROM typology
                        INNER JOIN project ON typology.project = project.id
                        INNER JOIN link_project_contributor ON link_project_contributor.project = project.id
                        WHERE link_project_contributor.contributor = $iduser");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idtypologies_array[] = $array['idtypology'];
                }
            }

            if ($public = 1) {
                /* Case 5 : typologies publiques */
                $request = $connexion->query("SELECT id AS idtypology FROM typology WHERE public = 1");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idtypologies_array[] = $array['idtypology'];
                }
            }
                
            /* Enlève les valeurs multiples */
            $idtypologies_array = array_unique($idtypologies_array);

            /* Retourne le résultat */
            return implode(',', $idtypologies_array);
    
        }
    
            catch (PDOException $e) {
                echo 'Echec de la connexion : ' . $e -> getMessage();
            }
        }

    function no_contributor(string $table, int $idobject) {
        try {
            /* Initialise la connexion */
            $connexion = db_connect();

            /* Array des utilisateurs contributeurs ou owners */
                /* Case 1 : l'owner */
                $request = $connexion->query("SELECT owner AS iduser FROM $table WHERE id = $idobject");
                $idusers_array = $request->fetch();
                /* Case 2 : les contributeurs */
                $request = $connexion->query("SELECT contributor AS iduser FROM link_" . $table . "_contributor WHERE $table = $idobject");
                $add = $request->fetchAll();
                foreach($add as $array) {
                    $idusers_array[] = $array['iduser'];
                }
            
            $idusers = implode(',', $idusers_array);

            /* Récupère la liste des utilisateurs */
            $request = $connexion->query("SELECT id, username, firstname, lastname FROM user WHERE id NOT IN (" . implode(',', $idusers_array) . ")");

            /* Retourne le résultat */
            return $request->fetchAll();
        }

        catch (PDOException $e) {
            echo 'Echec de la connexion : ' . $e -> getMessage();
        }
    }

    function query_add($query, $key, $value) {
        if ($query != "") {
            $query = $query . '&';
        }
        return $query . $key . '=' . $value;
    }

    // Lit le fichier CSV et le converti dans le bon format
    function normalize_csv_encoding($inputFile, $outputFile) {
        // Encodages les plus fréquents avec Excel
        $encodings = ['UTF-8', 'UTF-16LE', 'UTF-16BE', 'Windows-1252', 'ISO-8859-1'];

        $content = file_get_contents($inputFile);

        // Détection de l'encodage
        $detected = mb_detect_encoding($content, $encodings, true);
        if ($detected === false) {
            $detected = 'Windows-1252'; // fallback
        }

        // Conversion en UTF-8
        $utf8Content = mb_convert_encoding($content, 'UTF-8', $detected);

        // On écrit le contenu converti dans un fichier temporaire
        $tmpFile = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($tmpFile, $utf8Content);

        // Réouverture pour analyse
        $input = fopen($tmpFile, 'r');

        // Détection du séparateur probable (on lit la première ligne brute)
        $firstLine = fgets($input);
        rewind($input);

        $delimiter = ';'; // valeur par défaut
        if (substr_count($firstLine, ',') > substr_count($firstLine, ';')) {
            $delimiter = ','; // Excel anglais par ex.
        }

        // Réécriture normalisée
        $output = fopen($outputFile, 'w');
        fwrite($output, "\xEF\xBB\xBF"); // BOM UTF-8

        while (($row = fgetcsv($input, 0, $delimiter)) !== false) {
            fputcsv($output, $row, ';'); // on force le séparateur final à ";"
        }

        fclose($input);
        fclose($output);
        unlink($tmpFile);

        return $outputFile;
    }

/**
 * Supprime le BOM éventuel au début d'une chaîne.
 */
function strip_bomFALSE($s) {
    if ($s === null) return $s;
    // Supprime BOM UTF-8 (octets EF BB BF)
    if (substr($s, 0, 3) === "\xEF\xBB\xBF") {
        $s = substr($s, 3);
    }
    // Supprime caractère Unicode U+FEFF
    $s = str_replace("\u{FEFF}", '', $s);
    return $s;
}

function strip_bom($s) {
    if ($s === null) return $s;
    // BOM UTF-8 (octets)
    $s = preg_replace('/^\xEF\xBB\xBF/', '', $s);
    // Caractère Unicode U+FEFF
    $s = preg_replace('/^\x{FEFF}/u', '', $s);
    // Séquence "ï»¿" issue d’une mauvaise décodage
    $s = preg_replace('/^(ï»¿)+/u', '', $s);
    return $s;
}

function fgetcsv_utf8($handle, $length = 0, $delimiter = ';') {
    $row = fgetcsv($handle, $length, $delimiter);
    if ($row === false) return false;
    foreach ($row as &$field) {
        // Convertit chaque champ en UTF-8
        $field = mb_convert_encoding($field, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
        // Supprime BOM éventuel
        $field = preg_replace('/^\x{FEFF}/u', '', $field);
    }
    return $row;
}

/**
 * Corrige les caractères mal encodés fréquents (mojibake).
 */
function fix_common_encoding_issues($s) {
    if ($s === null) return $s;

    // Table de remplacements : mojibake => caractère correct
    $map = [
        '""ï»¿' => '',   // remove BOM artifact + extra quotes
        'Ã©' => 'é',
        'Ã¨' => 'è',
        'Ãª' => 'ê',
        'Ã«' => 'ë',
        'Ã ' => 'à',
        'Ã¢' => 'â',
        'Ã¤' => 'ä',
        'Ã¹' => 'ù',
        'Ã»' => 'û',
        'Ã¼' => 'ü',
        'Ã¶' => 'ö',
        'Ã´' => 'ô',
        'Ã§' => 'ç',
        'Ã±' => 'ñ',
        'ÃŸ' => 'ß',
        'â‚¬' => '€',
        'â€œ' => '“',
        'â€�' => '”',
        'â€˜' => '‘',
        'â€™' => '’',
        'â€¢' => '•',
        'â€“' => '–',
        'â€”' => '—',
    ];

    return strtr($s, $map);
}

function clean_cell($s) {
    if ($s === null) return $s;

    // Remove UTF-8 BOM (mojibake or real)
    $s = preg_replace('/^\xEF\xBB\xBF/', '', $s);   // raw BOM
    $s = preg_replace('/^\x{FEFF}/u', '', $s);      // Unicode BOM
    $s = preg_replace('/^(ï»¿)+/u', '', $s);        // mojibake BOM

    // Remove weird prefix like ""ï»¿
    $s = preg_replace('/^""ï»¿/', '', $s);

    // Trim quotes and whitespace
    $s = trim($s, "\"' \t\n\r\0\x0B");

    if (ENVIRONMENT === "OVH") {
        // Fix common mojibake sequences
        $s = fix_common_encoding_issues($s);
    }

    return $s;
}

/**
 * Lit la première ligne du CSV et construit le header normalisé.
 * - $file : pointeur de fichier déjà ouvert
 * - $convert_headers : tableau de mapping ['id du projet' => 'code', ...]
 * Retourne : tableau $header
 */
function read_csv_header($file, array $convert_headers) {
    $row = fgetcsv($file, 0, ';');
    if ($row === false) {
        return [];
    }

    $header = [];
    foreach ($row as $head) {
        // Nettoyage BOM et guillemets
        $head = strip_bom($head);
        $head = trim($head, "\"' \t\n\r\0\x0B");
        $head = clean_cell($head);

        // Normalisation
        $key = strtolower($head);

        // Mapping si défini
        $found = false;

        foreach ($convert_headers as $searchKey => $replacement) {
            if (mb_strpos($key, $searchKey) !== false) {
                $header[] = $replacement;
                $found = true;
                break; // on arrête dès qu'on a trouvé
            }
        }

        if (!$found) {
            $header[] = $key;
        }
    }

    return $header;
}

/**
 * Lit une ligne de données et retourne un tableau associatif aligné sur $header.
 * - $file : pointeur de fichier
 * - $header : tableau des clés
 * Retourne : array associatif ou null si ligne vide
 */
function read_csv_row($file, array $header) {
    $row = fgetcsv($file, 0, ';');
    if ($row === false || $row == [NULL]) {
        return null;
    }

    // Normaliser le nombre de colonnes
    $colHeader = count($header);
    $colRow    = count($row);

    if ($colRow < $colHeader) {
        $row = array_pad($row, $colHeader, '');
    } elseif ($colRow > $colHeader) {
        $row = array_slice($row, 0, $colHeader);
    }

    // Nettoyage BOM éventuel sur le premier champ
    if (isset($row[0])) {
        $row[0] = strip_bom($row[0]);
    }

    // Correction des caractères mal encodés sur chaque cellule
    foreach ($row as &$cell) {
        $cell = clean_cell($cell);
    }
    unset($cell);

    return array_combine($header, $row);
}


?>