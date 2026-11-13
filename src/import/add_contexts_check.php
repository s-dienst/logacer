<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!PROJECT) {
        $error_message = 'no_project';
    } elseif (!PROJECT->contributor_rights()) {
        $error_message = 'not_project_contributor';
    } else {
        /* Cette partie gère l'intégration du contenu du JSON dans la base,
        la création des variables pour le décodage du CSV ou la redirection,
        la redirection éventuelle si importation finie et
        l'initialisation du fichier CSV */

        // Vérifie si c'est un nouveau fichier ou non
        if (isset($_FILES['file_to_upload'])) {
            $is_new = true;
        } else {
            $is_new = false;
        }
        // Vérifie si pas mis en pause
        $pausing = true;
        if (isset($params['arg'])) { if ($params['arg'] === 'validate') { $pausing = false; }}
        // Créer le chemin d'accès vers le JSON
        $file_path_json = "static/ajax/data_adding_context" . $_SESSION['user']->id() . ".json";
        // Sauvegarde des données du JSON (si validation des ajouts en cours)
        // Récupération du JSON
        if (file_exists($file_path_json)) {
            $json_file = file_get_contents($file_path_json);
            $json_file = json_decode($json_file, true);
        }
        if (!$is_new && !$pausing) {
            // Récupération des données dans le JSON
            foreach ($json_file['objects'] as $key => $object) {
                $site = Site::find_by_id($object['related_site']);
                // Vérification des droits d'enregistrement dans le site
                if ($site) { if ($site->contributor_rights()) {
                    // Check si nouvelle phase ;
                    // si phase correspondante, rien ne change et elle est importée.
                    // Sinon, on crée une nouvelle phase si possible,
                    // sinon on ajoute à la phase par défaut (qu'on crée si nécessaire)
                    if (strlen($object['phase_code']) > 0) {
                        $phase = Phase::find_by_site_code($site->id(), $object['phase_code']);
                        if (!$phase) {
                            // Cas 2 : création d'une nouvelle phase
                            $phase_object = $object;
                            $phase_object['code'] = $phase_object['phase_code']; $phase_object['name'] = $phase_object['phase_name'];
                            if (isset($phase_object['phase_descr'])) {
                                $phase_object['descr_html'] = $phase_object['phase_descr'];
                            }
                            $phase = new Phase($phase_object);
                            $success = $phase->save();
                            if ($success) {
                                $phase = Phase::find_by_site_code($site->id(), $object['phase_code']);
                            } else {
                                // S'il y a eu un problème, phase par défaut
                                if (!Phase::find_by_site_code($site->id(), '00')) {
                                    $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$site->id(), 'public'=>1, 'unpublished'=>1]);
                                    $default_phase->save();
                                }
                                $phase = Phase::find_by_site_code($site->id(), '00');
                            }
                        }
                        // Pas de else : si OK, rien ne doit être changé
                    } else {
                        // Cas 3 : rajout à la phase par défaut
                        if (!Phase::find_by_site_code($site->id(), '00')) {
                            $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$site->id(), 'public'=>1, 'unpublished'=>1]);
                            $default_phase->save();
                        }
                        $phase = Phase::find_by_site_code($site->id(), '00');
                    }
                    // Création du contexte
                    if (isset($object['context_descr'])) {
                        $context = new Context(['code'=>$object['context_code'], 'name'=>$object['context_name'], 'descr_html'=>$object['context_descr'], 'related_phase'=>$phase->id()]);
                    } else {
                        $context = new Context(['code'=>$object['context_code'], 'name'=>$object['context_name'], 'related_phase'=>$phase->id()]);
                    }
                    $context->save();
                }}
            }
        }

        // Vérifier si les contextes ont été ajoutés pour un site, une phase
        // Repéré par la création d'une variable $idsite/phase
        // NB Pour l'instant, seulement prévu sous forme globale
        // Cas où ce n'est pas une nouvelle importation
        if (!$is_new) {
            if (isset($json_file['site'])) {
                $idsite = $json_file['site'];
            } elseif (isset($json_file['phase'])) {
                $idphase = $json_file['phase'];
            }
            // Cas où c'est une nouvelle importation (intégré au formulaire)
        } elseif (isset($_POST['location'])) {
            switch($_POST['location']['type']) {
                case 'site':
                    $idsite = $_POST['location']['id'];
                    break;
                case 'phase':
                    $idphase = $_POST['location']['id'];
                    break;
            }
        }

        // Si arrivé à la fin du fichier, suppression des fichiers et retour à l'url de départ
        $end = false;
        if (isset($json_file)) { if ($json_file['rest'] == 0) { $end = true; }}
        // Idem si abandon
        if (isset($params['arg'])) { 
            if ($params['arg'] === 'drop') {
                $end = true;
                // Par contre, si $params = "resume", on ne met pas fin !
            } else if ($params['arg'] === 'resume') {
                $end = false;
            }
        }
        if ($end) {
            // Suppression des fichiers
            unlink("static/ajax/data_adding_context" . $_SESSION['user']->id() . ".json");
            unlink("static/temp/temp" . $_SESSION['user']->id() . ".xlsx");
            // Choix de la redirection
            if (isset($idsite)) {
                header('Location: ' . Site::find_by_id($idsite)->url());
                exit();
            } elseif (isset($idphase)) {
                header('Location: ' . Phase::find_by_id($idphase)->url());
                exit();
            } else {
                header('Location: ' . create_url(["homepage"]));
                exit();
            }
        }

        // Récupère le CSV et commence à le décrypter
        if ($is_new) {
            // Avant tout, supprimer les fichiers existants
            if (file_exists("static/ajax/data_adding_context" . $_SESSION['user']->id() . ".json")) {
                unlink("static/ajax/data_adding_context" . $_SESSION['user']->id() . ".json");
            }
            if (file_exists("static/temp/temp" . $_SESSION['user']->id() . ".xlsx")) {
                unlink("static/temp/temp" . $_SESSION['user']->id() . ".xlsx");
            }
            // Création du fichier
            $file = new File();
            $filename = $file->update_file(true, ['xlsx']);    
        } else {
            // Si pas nouveau, le récupère
            $filename = "static/temp/temp" . $_SESSION['user']->id() . ".xlsx";
        }
    }

    /* Prépare le fichier XLSX et les variables de comptage
    Vérifie si le XLSX correspond aux besoins minimaux pour l'intégration */

    if (!$error_message && $filename) {
        // Initialise le titre
        $title = ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("phases") . " " . thesaurus("and") . " " . thesaurus("contexts");

        if (PROJECT->setting_horizon()) {
            // Array des headers possibles
            $accepted_headers = ["responsable opération", "opération archéologique (code)", "opération archéologique (nom)",
                "code groupe horizons régionaux", "code horizon régional", "type de lien (majeur = 1, mineur = 2, incertain = 3)",
                "code horizon-site", "nom horizon-site", "description horizon-site",
                "code contexte", "nom contexte", "description contexte"
            ];
            // Array pour transformation des headers : UNIQUEMENT FR !!
            $convert_headers = ["responsable opération"=>"owner", "opération archéologique (code)"=>"site", "opération archéologique (nom)"=>"site_name",
                "code groupe horizons régionaux"=>"facies", "code horizon régional"=>"horizon_code", "type de lien (majeur = 1, mineur = 2, incertain = 3)"=>"horizon_strength",
                "code horizon-site"=>"phase_code", "nom horizon-site"=>"phase_name", "description horizon-site"=>"phase_descr",
                "code contexte"=>"context_code", "nom contexte"=>"context_name", "description contexte"=>"context_descr"
            ];
        } else {
            // Array des headers possibles
            $accepted_headers = ["responsable opération", "opération archéologique (code)", "opération archéologique (nom)",
                "code horizon-site", "nom horizon-site", "description horizon-site",
                "code contexte", "nom contexte", "description contexte"
            ];
            // Array pour transformation des headers : UNIQUEMENT FR !!
            $convert_headers = ["responsable opération"=>"owner", "opération archéologique (code)"=>"site", "opération archéologique (nom)"=>"site_name",
                "code horizon-site"=>"phase_code", "nom horizon-site"=>"phase_name", "description horizon-site"=>"phase_descr",
                "code contexte"=>"context_code", "nom contexte"=>"context_name", "description contexte"=>"context_descr"
            ];
        }

        // Lecture du fichier CSV
        $header = [];
        $objects = [];
        $objects_for_json = [];
        $context_codes = [];
        $phase_codes = [];
        // Nombre de lignes déjà traitées
        if (!$is_new) {
            if ($pausing) {
                $already_counted = $json_file['begin'] - 1;
            } else {
                $already_counted = $json_file['end'];
            }
        } else {
            $already_counted = 1;
        }
        // Premier incrément : nombre de lignes dans le tableau
        $lines_added = 0;
        // Second : nombre de lignes analysées (similaire si tout affiché)
        $lines_checked = 0;
        
        // Intégration de la feuille dans un objet Spreadsheet
        $real_filename = realpath($filename);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($real_filename);
        // Aller à la feuille contexte (UNIQUEMENT FR)
        $sheet = $spreadsheet->getSheetByName("HSite-Contextes");
        // Récupération de la valeur de la dernière colonne et ligne remplie
        $highest_column = $sheet->getHighestColumn();
        $highest_row = $sheet->getHighestRow();
        // Gestion des headers
        // Récupération de la ligne de header
        $headers_row = $sheet->rangeToArray("A1:" . $highest_column . "1", null, true, true, true);
        $headers_row = reset($headers_row);
        // Lecture de la ligne d'header
        $header = [];
        foreach ($headers_row as $hr) {
            $hr = strtolower($hr);
            if (in_array($hr, $accepted_headers)) {
                $header[] = $convert_headers[$hr];
            } else {
                $header[] = FALSE;
            }
        }

        // Vérifie si contient les informations minimales avant de continuer
        // Peu adapté à l'ajout non global
        $error_message = [];
        if (!((in_array("owner", $header) && in_array("site", $header)) || in_array("site_name", $header))) {
            $error_message[] = "add_contexts_no_site";
        }
        $required = ['context_code', 'context_name'];
        foreach ($required as $req) {
            if (!in_array($req, $header)) {
                $error_message[] = 'add_contexts_no_' . $req;
            }
        }

        /* Process de la ligne suivante : Crée un pointeur de ligne ;
        Crée les array et objets correspondants en adaptant les valeurs ;
        Crée les listes de données uniques pour la vérification des lignes suivantes */

        if (!$error_message) {
            // Pointeur de début
            $row_pointer = $already_counted + 1;

            // Commence le véritable comptage
            while ($row_pointer <= $highest_row && $lines_added < 200 && $lines_checked < 1000) {
                // Crée l'objet associatif
                $row = $sheet->rangeToArray("A" . $row_pointer . ":" . $highest_column . $row_pointer, null, true, true, true);
                $row = reset($row);
                $object = [];
                $col_pointer = 0;
                foreach ($row as $cell) {
                    $head = $header[$col_pointer];
                    if ($head) {
                        $object[$head] = $cell;
                    }
                    $col_pointer++;
                }
                $row_pointer++;
                // Ajoute le related_phase avec l'id de la phase et le related_site avec l'id du site
                $object['related_phase'] = 0;
                // Si ajout pour une phase, ajout des valeurs manquantes
                if (isset($idphase)) {
                    $phase = Phase::find_by_id($idphase);
                    if ($phase && $phase->contributor_rights()) {
                        $object['related_phase'] = $idphase;
                        $object['site'] = $phase->related_site()->name();
                        $object['related_site'] = $phase->related_site()->id();
                    }
                // Si ajout pour un site, ajout des valeurs manquantes
                } elseif (isset($idsite)) {
                    $phase = Phase::find_by_site_code($idsite, $object['phase_code']);
                    if ($phase && $phase->contributor_rights()) {
                        $object['related_phase'] = $phase->id();
                        $object['site'] = $phase->related_site()->name();
                        $object['related_site'] = $phase->related_site()->id();
                    }
                // Si ajout global, ajout des valeurs manquantes
                } else {
                    // Si présence d'un owner et code, on tente d'abord par owner et code
                    if (isset($object['owner']) && isset($object['site'])) {
                        // Double vérification : présent ET avec informations
                        if (strlen($object['owner']) > 0 && strlen($object['site']) > 0) {
                            $owner = User::find_by_sql("SELECT * FROM user WHERE username = :username", ['username'=>$object['owner']]);
                            if (count($owner) > 0) {
                                $site = Site::find_by_owner_code($owner[0]->id(), $object['site']);
                                // Check si raccord avec le site_name, si présent
                                if ($site && isset($object['site_name'])) {
                                    if (strlen($object['site_name'] > 0)) {
                                        $site_name = Site::find_by_name($object['site_name']);
                                        if ($site_name) {
                                            $site_name = $site_name->name();
                                        } else {
                                            $site_name = false;
                                        }
                                        if ($site->name() !== $site_name) {
                                            $site = false;
                                        }
                                    }
                                }
                            } else {
                                $site = false;
                            }
                        } else {
                            $site = Site::find_by_name($object['site_name']);
                        }
                    } else {
                        $site = Site::find_by_name($object['site_name']);
                    }
                    // Si tout est OK, ajout des valeurs, si droits
                    if ($site) {
                        if ($site->contributor_rights()) {
                            $object['site'] = $site->name();
                            $object['related_site'] = $site->id();
                            // Si pas de 'phase_code', il s'agit de la phase par défaut
                            if (!isset($object['phase_code'])) { $object['phase_code'] = '00'; }
                            $phase = Phase::find_by_site_code($site->id(), $object['phase_code']);
                            // Si la phase existe
                            if ($phase) {
                                $object['related_phase'] = $phase->id();
                            }
                        }
                    } else {
                        $object['site'] = "";
                        $object['related_site'] = 0;
                    }
                }
                // Calcule l'horizon, si indiqué
                $object['horizon'] = 0;
                if (PROJECT->setting_horizon()) {
                    if (isset($object['horizon_code'])) {
                        $facies = Facies::find_by_code($object['facies']);
                        if ($facies && ($facies->contributor_rights() || $facies->public())) {
                            $horizon = Horizon::find_by_facies_code($facies->id(), $object['horizon_code']);
                            if ($horizon) {
                                $object['horizon'] = $horizon->id();
                            }
                        }
                    }
                }
                // Crée le contexte (et éventuellement phase) sur base des données rentrées
                // Initialise certaines variables (plus complexe que pour l'objet)
                if (!isset($phase_codes[$object['related_site']])) {
                    $phase_codes[$object['related_site']] = [];
                }

                // Crée d'abord la phase, si pas déjà existante
                if ($object['related_phase'] === 0 && $object['related_site'] > 0 && !in_array($object['phase_code'], $phase_codes[$object['related_site']])) {
                    // D'abord, changement des clés (avec maintien de l'objet initial)
                    $phase_add = $object;
                    $phase_add['code'] = $object['phase_code']; $phase_add['name'] = $object['phase_name'];
                    if (isset($object['phase_descr'])) {
                        $phase_add['descr'] = $object['phase_descr'];
                    }
                    // Ensuite, création proprement dite
                    $phase_inst = new Phase($phase_add);
                    // Crée les erreurs pour l'objet si elles existent ; ajoute le numéro d'inventaire à la liste
                    $phase_codes[$object['related_site']][] = $phase_inst->check_errors_add($phase_codes[$object['related_site']]);
                }

                // Crée ensuite le contexte
                // D'abord, changement des clés (avec maintien de l'objet initial)
                $context_add = $object;
                $context_add['code'] = $object['context_code']; $context_add['name'] = $object['context_name'];
                if (isset($object['context_descr'])) {
                    $context_add['descr'] = $object['context_descr'];
                }
                // Ensuite, création proprement dite
                $context_inst = new Context($context_add);
                // Crée les erreurs pour l'objet si elles existent ; ajoute le numéro d'inventaire à la liste
                if (!isset($context_codes[$object['related_site']])) {
                    $context_codes[$object['related_site']] = [];
                }
                $context_codes[$object['related_site']][] = $context_inst->check_errors_add($context_codes[$object['related_site']], $object['related_site']);
                
                // Ajoute à la liste ; si check_all, d'office ; sinon, uniquement si erreur
                if ($is_new) {
                    if (isset($_POST['check_all'])) {
                        $check_all = true;
                    } else { $check_all = false; }
                } else {
                    $check_all = $json_file['check_all'];
                }
                // Cas 1 : toutes les lignes ajoutées
                if ($check_all) {
                    $object_index = $already_counted + $lines_checked + 1;
                    // Crée array avec arrays
                    $objects_for_json[$object_index] = $object;
                    // Crée array avec objets
                    // Si c'est une nouvelle phase au sein de cette ligne
                    if (isset($phase_inst)) {
                        $objects[] = [$object_index, $phase_inst, $context_inst];
                    } else {
                        // Si phase existe déjà
                        if ($object['related_phase'] > 0) {
                            $phase = Phase::find_by_id($object['related_phase']);
                        // Si la phase n'existe pas, et qu'il y a un problème avec le site désigné
                        } elseif ($object['related_site'] === 0) {
                            $phase_add = $object;
                            $phase_add['code'] = $object['phase_code']; $phase_add['name'] = $object['phase_name'];
                            if (isset($object['phase_descr'])) {
                                $phase_add['descr'] = $object['phase_descr'];
                            }
                            $phase = new Phase($phase_add);
                        // Si la phase n'existe pas, mais qu'elle a déjà été définie plus haut
                        } else {
                            // Récupération de l'objet phase pertinent dans la liste existante
                            foreach ($objects as $object_for_phase) {
                                foreach ($object_for_phase as $content_object) {
                                    if ($content_object instanceof Phase) {
                                        if ($content_object->related_site()) {
                                            if ($content_object->code() === $object['phase_code'] && $content_object->related_site()->id() === $object['related_site']) {
                                                $phase = $content_object;
                                                break 2;
                                            }
                                        }
                                    }
                                }
                            }
                            // Si pas créé : on utilise la phase par défaut
                            if (!isset($phase)) {
                                if (!Phase::find_by_site_code($object['related_site'], '00')) {
                                    $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$object['related_site'], 'public'=>1, 'unpublished'=>1]);
                                    $default_phase->save();
                                }
                                $phase = Phase::find_by_site_code($object['related_site'], '00');
                            }
                        }
                        $objects[] = [$object_index, $phase, $context_inst];
                    }
                    $lines_added++;
                } else {
                    // Cas 2 : uniquement si erreur
                    // Vérification de si erreurs
                    // Si phase et contexte (Si c'est une nouvelle phase au sein de cette ligne)
                    if (isset($phase_inst)) {
                        $errors = $phase_inst->display_errors(true);
                        if (!$errors) {
                            $errors = $context_inst->display_errors(true);
                        }
                    } else {
                        // Si contexte uniquement
                        $errors = $context_inst->display_errors(true);
                    }
                    // Si erreurs : préparer les données et leur affichage
                    if ($errors) {
                        $object_index = $already_counted + $lines_checked + 1;
                        // Crée array avec arrays
                        $objects_for_json[$object_index] = $object;
                        // Crée array avec objets
                        // Si c'est une nouvelle phase au sein de cette ligne
                        if (isset($phase_inst)) {
                            $objects[] = [$object_index, $phase_inst, $context_inst];
                        } else {
                            // Si phase existe déjà
                            if ($object['related_phase'] > 0) {
                                $phase = Phase::find_by_id($object['related_phase']);
                            // Si la phase n'existe pas, qu'il y ait ou non un problème avec le site désigné
                            // Si la phase a été définie plus haut, elle a été enregistrée ; il ne faudrait pas aller chercher la phase enregistrée ?
                            } else {
                                $phase_add = $object;
                                $phase_add['code'] = $object['phase_code']; $phase_add['name'] = $object['phase_name'];
                                if (isset($object['phase_descr'])) {
                                    $phase_add['descr'] = $object['phase_descr'];
                                }
                                $phase = new Phase($phase_add);
                            }
                            $objects[] = [$object_index, $phase, $context_inst];
                        }
                        $lines_added++;
                    } else {
                        // Sauvegarder les objet si tout est OK et pas présenté
                        // Si c'est une nouvelle phase au sein de cette ligne
                        if (isset($phase_inst)) {
                            $phase_inst->save();
                        }
                        // Il faut s'assurer que $context_inst a bel et bien une phase
                        if (!$context_inst->related_phase()) {
                            $has_phase = false;
                            // Etape 1 : si dispose d'une phase indiquée, on l'ajoute
                            if (isset($object['phase_code'])) {
                                if ($object['phase_code']) {
                                    $phase = Phase::find_by_site_code($object['related_site'], $object['phase_code']);
                                    if ($phase) {
                                        $context_inst->update_related_phase($phase->id());
                                        $has_phase = true;
                                    }
                                }
                            }
                            // Etape 2 : sinon, phase par défaut
                            // On vérifie si la phase par défaut existe, sinon on la crée
                            if (!$has_phase && !Phase::find_by_site_code($object['related_site'], '00')) {
                                $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$object['related_site'], 'public'=>1, 'unpublished'=>1]);
                                $default_phase->save();
                            }
                            // Ensuite, on la récupère, et on l'indique pour le contexte
                            if (!$has_phase) {
                                $phase = Phase::find_by_site_code($object['related_site'], '00');
                                $context_inst->update_related_phase($phase->id());
                            }
                        }
                        $context_inst->save();
                    }
                }
                $lines_checked++;
                // Suppression de la variable $phase_inst si existe pour ne pas contaminer l'itération suivante
                unset($phase_inst);
                unset($site);
            }
            // Préparation du fichier JSON
            // Calculate length of file
            $total = $highest_row;
            // Crée l'array à convertir (avec métadonnées et objets)
            $lines_data = ['begin'=>$already_counted + 1, 'end'=>$already_counted + $lines_checked, 'rest'=>$total - $already_counted - $lines_checked, 'total'=>$total, 'checked'=>$lines_checked, 'displayed'=>$lines_added, 'check_all'=>$check_all, 'objects'=>$objects_for_json];
            // Si ajout au sein d'un site ou phase : sauvegarde de la donnée spécifique
            if (isset($idphase)) {
                $lines_data['phase'] = $idphase;
            } elseif (isset($idsite)) {
                $lines_data['site'] = $idsite;
            }
            // Transformation en données JSON
            $json_data = json_encode($lines_data, JSON_PRETTY_PRINT);
            // Ajout au fichier JSON
            file_put_contents($file_path_json, $json_data);
        }
    } else {
        // Si pas d'erreur précédemment, mais que pas de fichier
        if (!$filename) {
            $error_message = 'add_data_file';
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) {
                if (is_array($error_message)) {
                    echo '<br><div class="alert alert-danger">'
                        . err_fatal('add_data_template')
                        . "<ul>";
                    foreach ($error_message as $err) {
                        echo "<li>" . err_fatal($err) . "</li>";
                    }
                    echo "</ul></div><br>";
                } else {
                    display_fatal_error($error_message);
                }
            } else {
                // Création de l'en-tête
                echo h(2, ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("phases") . " " . thesaurus("and") . " " . thesaurus("contexts"));
                echo "<p>Lignes <b>". $lines_data['begin'] . "</b> à <b>" . $lines_data['end'] . "</b>.
                <p>Total des lignes : <b>" . $lines_data['total'] . "</b>.
                <p>Lignes restantes : <b>" . $lines_data['rest'] . "</b>.
                <p>Lignes affichées : <b>" . $lines_data['displayed'] . "</b>";
                // Prépare contenu du POST
                $inc_valid_obj = 0;
                // Création liste de colonnes
                if (PROJECT->setting_horizon()) {
                    $cols_phase = ['site', 'facies', 'horizon_code', 'horizon_strength', 'phase_code', 'phase_name', 'phase_descr'];
                } else {
                    $cols_phase = ['site', 'phase_code', 'phase_name', 'phase_descr'];
                }
                $cols_context = ['context_code', 'context_name', 'context_descr'];
                $cols = array_merge($cols_phase, $cols_context);
                // Début table
                echo "<table class='table table-sm' id='inventory_table'><thead>";
                // Colonne 1 : numéro
                echo '<th>N°</th>';
                // Création colonnes
                foreach ($cols as $col) {
                    echo '<th>' . filter_labels($col, "label") . " <abbr title='" . filter_labels($col, "descr") . "'><i class='bi bi-info-circle'></i></abbr></th>";
                }
                // Passage aux lignes de la table
                echo "</thead><tbody>";
                foreach ($objects as $obj) {
                    echo '<tr>';
                    echo '<td>' . $obj[0] . '</td>';
                    foreach ($cols_phase as $col) {
                        $obj[1]->table_add($col, $obj[0]);
                    }
                    foreach ($cols_context as $col) {
                        $obj[2]->table_add($col, $obj[0]);
                    }
                    echo '</tr>';
                }
                echo "</tbody></table>";
                ?>
                
                
                <script>
        // Fonction pour discuter avec le PHP de check d'erreurs dans AJAX
        function verifyValidity(inputValue, column, row) {
            const project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;
            // Chemin du fichier PHP et autres données
            return fetch("<?php echo BASE_URL; ?>static/ajax/check_contexts_added.php", {
                method: "POST",
                headers: { "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest" // Ajout pour briser la sécurité
                 },
                // Envoie au PHP la valeur voulue
                body: JSON.stringify({ inputValue, column, row, project_id })
            })
            .then(response => response.json())
            .then(data => {
                return data;
            })
            .catch(error => {
                console.error("Erreur :", error);
                return { result: false };
            });
        }

        // Précise pour le type d'ajout pour la prochaine fonction
        let type = 'context';

        // Fonction pour discuter avec le PHP d'update de JSON dans AJAX
        function updateJsonFile(row, column, newText, type, response) {
            const project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;
            fetch("<?php echo BASE_URL; ?>static/ajax/update_json_data_adding.php", {
                method: "POST",
                headers: { "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest" // Ajout pour briser la sécurité
                 },
                body: JSON.stringify({ row, column, newText, type, response, project_id })
            })
            .then(response => response.json())
            .then(data => console.log("Mise à jour JSON :", data))
            .catch(error => console.error("Erreur JSON :", error));
        }


        document.addEventListener("DOMContentLoaded", function () {
            // Gestion du clic : transforme la cellule en input
            document.querySelectorAll("td").forEach(td => {
                td.addEventListener("click", function () {
                    let row = this.getAttribute("data-row");
                    let column = this.getAttribute("data-column");
                    let currentText = this.textContent.trim();
                    let input = document.createElement("input");
                    input.type = "text";
                    input.value = currentText;
                    input.style.width = "100%";
                    this.textContent = "";
                    this.appendChild(input);
                    input.focus();

                    input.addEventListener("blur", async function () {
                        let newText = input.value.trim();


                        // Appliquer la validation selon la colonne
                        let range = {'site':255, 'facies':32, 'horizon_code':32, 'phase_code':32, 'phase_name':255, 'context_code':32, 'context_name':255};
                        if ((['site', 'facies', 'horizon_code', 'phase_code', 'phase_name', 'context_code', 'context_name'].includes(column) && newText.length > range[column]) || (['site', 'context_code', 'context_name'].includes(column) && (!newText || newText.length === 0))) {
                            if (newText.length > range[column]) {
                                alert("Cette colonne ne doit pas dépasser" + range[column] + " caractères.");
                                td.textContent = currentText;
                            } else {
                                alert("Cette colonne doit contenir une valeur.");
                                td.textContent = currentText;
                            }
                        } else if (column === 'horizon_strength' && (isNaN(newText) || (newText != '0' && newText != '1' && newText != '2' && newText != '3')) && !(newText || newText.length === 0)) {
                            alert("Vous devez entrer un nombre entre 1 et 3 ou ne rien indiquer s'il n'y a pas d'horizon régional.");
                            td.textContent = currentText;
                        } else {
                            // Vérification d'unicité
                            let table = document.getElementById("inventory_table");
                            let duplicate = false;

                            if (column === "site" || column === "context_code") {
                                // On récupère la valeur de l'autre cellule (owner ou code) de la même ligne
                                let rowSelector = 'td[data-row="' + row + '"][data-column="' + (column === "site" ? "context_code" : "site") + '"]';
                                let otherValue = table.querySelector(rowSelector)?.textContent.trim();

                                // Si on est en train de modifier "owner", newText = owner et otherValue = code
                                // Si on est en train de modifier "code", newText = code et otherValue = owner
                                let site = (column === "site") ? newText : otherValue;
                                let code  = (column === "context_code")  ? newText : otherValue;

                                if (site && code) {
                                    // Vérifier si une autre ligne a la même combinaison
                                    table.querySelectorAll("tr").forEach(tr => {
                                        let rSite = tr.querySelector('td[data-column="site"]')?.textContent.trim();
                                        let rCode  = tr.querySelector('td[data-column="context_code"]')?.textContent.trim();
                                        let rRow   = tr.querySelector('td')?.getAttribute("data-row");

                                        if (rRow !== row && rSite === site && rCode === code) {
                                            duplicate = true;
                                        }
                                    });
                                }

                                if (duplicate) {
                                    alert("Il existe déjà dans ce tableau un autre contexte pour cette opération archéologique avec ce code. Les codes de contexte doivent être uniques au sein de chaque opération archéologique.");
                                    td.textContent = currentText;
                                    return;
                                }
                            }

                            // Valeur peut être affichée
                            td.textContent = newText;

                            // Vérifie la validité via AJAX et retourne une valeur
                            let check = await verifyValidity(newText, column, row);

                            // Change les propriétés de la cellule. Si 0, tout est ok
                            if (check === 0) {
                                td.style.color = "#000000";
                            }
                            // Si 100, signifie que l'importance dans l'horizon régional n'est pas valide
                            else if (check === 100) {
                                td.style.color = "#A9A9A9";
                            }
                            // Si 200, signifie que le contexte n'est pas bon ou que les formats ne sont pas valides
                            else if (check === 200) {
                                td.style.color = "#B80000";
                            }
                            // Si 302, signifie que le site et le code du contexte ne sont pas bons
                            else if (check === 302) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#B80000";
                                let tdContext = tr.querySelector('td[data-column="context_code"]');
                                tdContext.style.color = "#B80000";
                            }
                            <?php if (PROJECT->setting_horizon()) { ?>
                            // Si 303, signifie que le faciès et le code de l'horizon ne sont pas bons
                            else if (check === 303) {
                                let tr = td.parentElement;
                                let tdFacies = tr.querySelector('td[data-column="facies"]');
                                tdFacies.style.color = "#A9A9A9";
                                let tdHorizon = tr.querySelector('td[data-column="horizon_code"]');
                                tdHorizon.style.color = "#A9A9A9";
                            }
                            <?php } ?>
                            // Si 402, signifie que le site est bon mais pas le code contexte
                            else if (check === 402) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#000000";
                                let tdContext = tr.querySelector('td[data-column="context_code"]');
                                tdContext.style.color = "#B80000";
                            }
                            <?php if (PROJECT->setting_horizon()) { ?>
                            // Si 403, signifie que le faciès est bon mais pas le code horizon
                            else if (check === 403) {
                                let tr = td.parentElement;
                                let tdFacies = tr.querySelector('td[data-column="facies"]');
                                tdFacies.style.color = "#000000";
                                let tdHorizon = tr.querySelector('td[data-column="horizon_code"]');
                                tdHorizon.style.color = "#A9A9A9";
                            }
                            <?php } ?>
                            // Si 602, signifie que le site et le code contexte sont bons
                            else if (check === 602) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#000000";
                                let tdContext = tr.querySelector('td[data-column="context_code"]');
                                tdContext.style.color = "#000000";
                            }
                            // Si 603, signifie que le faciès et le code horizon sont bons
                            <?php if (PROJECT->setting_horizon()) { ?>
                            else if (check === 603) {
                                let tr = td.parentElement;
                                let tdFacies = tr.querySelector('td[data-column="facies"]');
                                tdFacies.style.color = "#000000";
                                let tdHorizon = tr.querySelector('td[data-column="horizon_code"]');
                                tdHorizon.style.color = "#000000";
                            }
                            <?php } ?>
                            else {
                                alert("Il semble que la validation ne fonctionne pas comme prévu. Veuillez s'il-vous-plait contacter l'administrateur à ce propos");
                            }

                            // Indique la nouvelle valeur dans le JSON
                            updateJsonFile(row, column, newText, "context", check);
                        }
                        if (currentText === "ERROR") {
                            td.style.color = "#B80000";
                        }
                    });

                    input.addEventListener("keypress", function (event) {
                        if (event.key === "Enter") {
                            input.blur();
                        }
                    });
                });
            });
        });
    </script>

<?php
                // Fin du post
                if ($lines_data['rest'] > 0) {
                    $next_action = "Importer les lignes valides et charger la suite";
                } else { $next_action = "Importer les lignes valides et terminer l&#39;upload"; }
                echo '<div class="btn-group" role="group">';
                    echo "<a href='" . create_url(["new_context", "validate"]) . "' class='btn btn-success' role='button'>" . $next_action . "</a>";
                    echo "<a href='";
                    if (isset($idsite)) {
                        echo Site::find_by_id($idsite)->url();
                    } elseif (isset($idphase)) {
                        echo Phase::find_by_id($idphase)->url();
                    } else {
                        echo create_url(["homepage"]);
                    }
                    echo "' class='btn btn-secondary' role='button'>Stopper temporairement l&#39;upload</a>";
                    echo "<a href='" . create_url(["new_context", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>Abandonner l&#39;upload</a>";
                echo "</div>";

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>