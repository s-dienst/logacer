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
        $file_path_json = "static/ajax/data_adding_inventory" . $_SESSION['user']->id() . ".json";
        // Sauvegarde des données du JSON (si validation des ajouts en cours)
        // Récupération du JSON
        if (file_exists($file_path_json)) {
            $json_file = file_get_contents($file_path_json);
            $json_file = json_decode($json_file, true);
        }
        if (!$is_new && !$pausing) {
            // Récupération des données dans le JSON
            foreach ($json_file['objects'] as $key => $object) {
                // Vérification des droits d'enregistrement pour ce contexte
                $context = Context::find_by_id($object['related_context']);
                if ($context) {
                    if ($context->contributor_rights()) {
                        // Enregistrement de l'objet
                        $read_object = new ObjectTable($object);
                        $read_object->save();
                    }
                }
            }
        }

        // Vérifier si l'inventaire a été ajouté pour un site, une phase, un contexte
        // Repéré par la création d'une variable $idsite/phase/context
        // NB Pour l'instant, seulement prévu sous forme globale
        // Cas où ce n'est pas une nouvelle importation
        if (!$is_new) {
            if (isset($json_file['site'])) {
                $idsite = $json_file['site'];
            } elseif (isset($json_file['phase'])) {
                $idphase = $json_file['phase'];
            } elseif (isset($json_file['context'])) {
                $idcontext = $json_file['context'];
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
                case 'context':
                    $idcontext = $_POST['location']['id'];
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
            unlink("static/ajax/data_adding_inventory" . $_SESSION['user']->id() . ".json");
            unlink("static/temp/temp" . $_SESSION['user']->id() . ".xlsx");
            // Choix de la redirection
            if (isset($idsite)) {
                header('Location: ' . Site::find_by_id($idsite)->url());
                exit();
            } elseif (isset($idphase)) {
                header('Location: ' . Phase::find_by_id($idphase)->url());
                exit();
            } elseif (isset($idcontext)) {
                header('Location: ' . Context::find_by_id($idcontext)->url());
                exit();
            } else {
                header('Location: ' . create_url(["homepage"]));
                exit();
            }
        }

        // Récupère le CSV et commence à le décrypter
        if ($is_new) {
            // Avant tout, supprimer les fichiers existants
            if (file_exists("static/ajax/data_adding_inventory" . $_SESSION['user']->id() . ".json")) {
                unlink("static/ajax/data_adding_inventory" . $_SESSION['user']->id() . ".json");
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
        $title = ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("inventory");

        if (PROJECT->setting_litterature()) {
            // Array des headers possibles : UNIQUEMENT FR !!
            $accepted_headers = ["responsable opération", "opération archéologique (code)", "opération archéologique (nom)", "contexte (code)",
                "numéro d'inventaire",
                "catégorie (biblio)",
                "catégorie", "catégorie (adaptée)",
                "fonction (biblio)",
                "fonction", "fonction (adaptée)",
                "type (biblio)",
                "type", "type (adapté)",
                "var.", "doute",
                "pâte (biblio)",
                "pâte", "pâte (adaptée)",
                "diam.",
                "estampilles",
                "commentaire",
                "bords",
                "fonds",
                "anses",
                "parois",
                "nmi",
                "nr",
            ];
            // Array pour transformation des headers : UNIQUEMENT FR !!
            $convert_headers = ["responsable opération"=>"owner", "opération archéologique (code)"=>"site", "opération archéologique (nom)"=>"site_name", "contexte (code)"=>"context",
                "numéro d'inventaire"=>"number",
                "catégorie (biblio)"=>"category_litt",
                "catégorie"=>"category_abbr", "catégorie (adaptée)"=>"category_abbr",
                "fonction (biblio)"=>"function_litt",
                "fonction"=>"function_name", "fonction (adaptée)"=>"function_name",
                "type (biblio)"=>"type_litt",
                "type"=>"type_name", "type (adapté)"=>"type_name",
                "var."=>"type_var", "doute"=>"type_doubt",
                "pâte (biblio)"=>"fabric_litt",
                "pâte"=>"fabric_code", "pâte (adaptée)"=>"fabric_code",
                "diam."=>"diameter",
                "estampilles"=>"stamp",
                "commentaire"=>"comment",
                "bords"=>"n_rim",
                "fonds"=>"n_bottom",
                "anses"=>"n_handle",
                "parois"=>"n_wall",
                "nmi"=>"n_mni",
                "nr"=>"n_sherd",
            ];
        } else {
            // Array des headers possibles : UNIQUEMENT FR !!
            $accepted_headers = ["responsable opération", "opération archéologique (code)", "opération archéologique (nom)", "contexte (code)",
                "numéro d'inventaire",
                "catégorie", "catégorie (adaptée)",
                "fonction", "fonction (adaptée)",
                "type", "type (adapté)",
                "var.", "doute",
                "pâte", "pâte (adaptée)",
                "diam.",
                "estampilles",
                "commentaire",
                "bords",
                "fonds",
                "anses",
                "parois",
                "nmi",
                "nr",
            ];
            // Array pour transformation des headers : UNIQUEMENT FR !!
            $convert_headers = ["responsable opération"=>"owner", "opération archéologique (code)"=>"site", "opération archéologique (nom)"=>"site_name", "contexte (code)"=>"context",
                "numéro d'inventaire"=>"number",
                "catégorie"=>"category_abbr", "catégorie (adaptée)"=>"category_abbr",
                "fonction"=>"function_name", "fonction (adaptée)"=>"function_name",
                "type"=>"type_name", "type (adapté)"=>"type_name",
                "var."=>"type_var", "doute"=>"type_doubt",
                "pâte"=>"fabric_code", "pâte (adaptée)"=>"fabric_code",
                "diam."=>"diameter",
                "estampilles"=>"stamp",
                "commentaire"=>"comment",
                "bords"=>"n_rim",
                "fonds"=>"n_bottom",
                "anses"=>"n_handle",
                "parois"=>"n_wall",
                "nmi"=>"n_mni",
                "nr"=>"n_sherd",
            ];
        }


        // Lecture du fichier CSV
        $header = [];
        $objects = [];
        $objects_for_json = [];
        $inventory_numbers = [];
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
        $sheet = $spreadsheet->getSheetByName("Inventaire");
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
            $error_message[] = "add_objects_no_site";
        }
        $required = ['context', 'number', 'category_abbr', 'function_name', 'type_name'];
        foreach ($required as $req) {
            if (!in_array($req, $header)) {
                $error_message[] = 'add_objects_no_' . $req;
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
                // Ajoute le related_context avec l'id du contexte
                $object['related_context'] = 0;
                    // Si ajout pour un contexte, ajout des valeurs manquantes
                if (isset($idcontext)) {
                    $context = Context::find_by_id($idcontext);
                    if ($context && $context->contributor_rights()) {
                        $object['related_context'] = $idcontext;
                        $object['site'] = $context->related_phase()->related_site()->name();
                    }
                    // Si ajout pour une phase, ajout des valeurs manquantes
                } elseif (isset($idphase)) {
                    $context = Context::find_by_phase_code($idphase, $object['context']);
                    if ($context && $context->contributor_rights()) {
                        $object['related_context'] = $context->id();
                        $object['site'] = $context->related_phase()->related_site()->name();
                    }
                    // Si ajout pour un site, ajout des valeurs manquantes
                } elseif (isset($idsite)) {
                    $context = Context::find_by_site_code($idsite, $object['context']);
                    if ($context && $context->contributor_rights()) {
                        $object['related_context'] = $context->id();
                        $object['site'] = $context->related_phase()->related_site()->name();
                    }
                    // Si ajout global, ajout des valeurs manquantes
                } else {
                    if (isset($object['owner'])) {
                        $owner = User::find_by_sql("SELECT * FROM user WHERE username = :username", ['username'=>$object['owner']]);
                        if (count($owner) > 0) {
                            $site = Site::find_by_owner_code($owner[0]->id(), $object['site']);
                        } else {
                            $site = false;
                        }
                    } else {
                        $site = Site::find_by_name($object['site_name']);
                    }
                    if ($site) {
                        $context = Context::find_by_site_code($site->id(), $object['context']);
                        if ($context && $context->contributor_rights()) {
                            $object['related_context'] = $context->id();
                            $object['site'] = $context->related_phase()->related_site()->name();
                        }
                    }
                }
                // Crée un objet sur base des données rentrées
                $object_inst = new ObjectTable($object);
                // Crée les erreurs pour l'objet si elles existent ; ajoute le numéro d'inventaire à la liste
                if (!isset($inventory_numbers[$object['related_context']])) {
                    $inventory_numbers[$object['related_context']] = [];
                }
                $inventory_numbers[$object['related_context']][] = $object_inst->check_errors_add($inventory_numbers[$object['related_context']]);
                
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
                    $objects[] = [$object_index, $object_inst];
                    $lines_added++;
                } else {
                    // Cas 2 : uniquement si erreur
                    $errors = $object_inst->display_errors(true);
                    if ($errors) {
                        $object_index = $already_counted + $lines_checked + 1;
                        // Crée array avec arrays
                        $objects_for_json[$object_index] = $object;
                        // Crée array avec objets
                        $objects[] = [$object_index, $object_inst];
                        $lines_added++;
                    } else {
                        // Sauvegarder l'objet si tout est OK et pas présenté
                        $object_inst->save();
                    }
                }
                $lines_checked++;
            }
            // Préparation du fichier JSON
            // Calculate length of file
            $total = $highest_row;
            // Crée l'array à convertir (avec métadonnées et objets)
            $lines_data = ['begin'=>$already_counted + 1, 'end'=>$already_counted + $lines_checked, 'rest'=>$total - $already_counted - $lines_checked, 'total'=>$total, 'checked'=>$lines_checked, 'displayed'=>$lines_added, 'check_all'=>$check_all, 'objects'=>$objects_for_json];
            // Si ajout au sein d'un site, phase ou contexte : sauvegarde de la donnée spécifique
            if (isset($idcontext)) {
                $lines_data['context'] = $idcontext;
            } elseif (isset($idphase)) {
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
        if (!$filename) {
            // Si pas d'erreur précédemment, mais que pas de fichier
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
                echo h(2, ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("inventory"));
                echo "<p>Lignes <b>". $lines_data['begin'] . "</b> à <b>" . $lines_data['end'] . "</b>.
                <p>Total des lignes : <b>" . $lines_data['total'] . "</b>.
                <p>Lignes restantes : <b>" . $lines_data['rest'] . "</b>.
                <p>Lignes affichées : <b>" . $lines_data['displayed'] . "</b>";
                // Prépare contenu du POST
                $inc_valid_obj = 0;
                // Création liste de colonnes
                $cols = [/*'owner',*/ 'site', /*'phase',*/ 'context', 'number', 'category_abbr', 'function_name', 'type_name', 'type_var', 'type_doubt', 'fabric_code', 'n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd', 'diameter', 'stamp', 'comment'/*, 'check'*/];
                // Complexification de la ligne si un seul des éléments biblio manque du cas
                foreach (['category_litt', 'function_litt', 'type_litt', 'fabric_litt'] as $bib) {
                    if (in_array($bib, $header) && PROJECT->setting_litterature()) {
                        $cols = [/*'owner',*/ 'site', /*'phase',*/ 'context', 'number', 'category_abbr', 'category_litt', 'function_name', 'function_litt', 'type_name', 'type_var', 'type_doubt', 'type_litt', 'fabric_code', 'fabric_litt', 'n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd', 'diameter', 'stamp', 'comment'/*, 'check'*/];
                    }
                }
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
                    foreach ($cols as $col) {
                        $obj[1]->table_add($col, $obj[0]);
                    }
                    echo '</tr>';
                }
                echo "</tbody></table>";
                ?>
                
                
                <script>
        // Fonction pour discuter avec le PHP de check d'erreurs dans AJAX
        function verifyValidity(inputValue, column, row, response) {
            const project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;
            // Chemin du fichier PHP et autres données
            return fetch("<?php echo BASE_URL; ?>static/ajax/check_objects_added.php", {
                method: "POST",
                headers: { "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest" // Ajout pour briser la sécurité
                 },
                // Envoie au PHP la valeur voulue
                body: JSON.stringify({ inputValue, column, row, response, project_id })
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
        let type = 'inventory';

        // Fonction pour discuter avec le PHP d'update de JSON dans AJAX
        function updateJsonFile(row, column, newText, type) {
            const project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;
            fetch("<?php echo BASE_URL; ?>static/ajax/update_json_data_adding.php", {
                method: "POST",
                headers: { "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest" // Ajout pour briser la sécurité
                 },
                body: JSON.stringify({ row, column, newText, type, project_id })
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
                        let range = {'site':255, 'context':32, 'number':128, 'category_abbr':16, 'category_litt':128, 'function_name':128, 'function_litt':128, 'type_name':128, 'type_var':8, 'type_doubt':16, 'type_litt':128, 'fabric_code':64, 'fabric_litt':128, 'diameter':16, 'stamp':255, 'comment':255};
                        if ((['site', 'context', 'number', 'category_abbr', 'category_litt', 'function_name', 'function_litt', 'type_name', 'type_var', 'type_doubt', 'type_litt', 'fabric_code', 'fabric_litt', 'diameter', 'stamp', 'comment'].includes(column) && newText.length > range[column]) || (['site', 'context', 'number', 'category_abbr', 'function_name', 'type_name'].includes(column) && (!newText || newText.length === 0))) {
                            if (newText.length > range[column]) {
                                alert("Cette colonne ne doit pas dépasser" + range[column] + " caractères.");
                                td.textContent = currentText;
                            } else {
                                alert("Cette colonne doit contenir une valeur.");
                                td.textContent = currentText;
                            }
                        } else if (['n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd'].includes(column) && isNaN(newText)) {
                            alert("Vous devez entrer un nombre.");
                            td.textContent = currentText;
                        } else {
                            // Vérification d'unicité
                            let table = document.getElementById("inventory_table");
                            let duplicate = false;

                            if (column === "site" || column === "context" || column === "number") {
                                if (column === "site") {
                                    let site = newText;
                                } else {
                                    // On récupère la valeur du site de la même ligne
                                    let rowSelector = 'td[data-row="' + row + '"][data-column="site"]';
                                    let site = table.querySelector(rowSelector)?.textContent.trim();
                                }
                                if (column === "context") {
                                    let context = newText;
                                } else {
                                    // On récupère la valeur du contexte de la même ligne
                                    let rowSelector = 'td[data-row="' + row + '"][data-column="context"]';
                                    let context = table.querySelector(rowSelector)?.textContent.trim();
                                }
                                if (column === "number") {
                                    let number = newText;
                                } else {
                                    // On récupère la valeur du numéro d'inventaire de la même ligne
                                    let rowSelector = 'td[data-row="' + row + '"][data-column="number"]';
                                    let number = table.querySelector(rowSelector)?.textContent.trim();
                                }

                                if (site && context && number) {
                                    // Vérifier si une autre ligne a la même combinaison
                                    table.querySelectorAll("tr").forEach(tr => {
                                        let rSite = tr.querySelector('td[data-column="site"]')?.textContent.trim();
                                        let rContext  = tr.querySelector('td[data-column="context"]')?.textContent.trim();
                                        let rNumber  = tr.querySelector('td[data-column="number"]')?.textContent.trim();
                                        let rRow   = tr.querySelector('td')?.getAttribute("data-row");

                                        if (rRow !== row && rSite === site && rContext === context && rNumber === number) {
                                            duplicate = true;
                                        }
                                    });
                                }

                                if (duplicate) {
                                    alert("Il existe déjà dans ce tableau un numéro d'inventaire appartenant à ce contexte. Le numéro d'inventaire doit être unique pour le contexte (code du contexte et nom de l'opération archéologique).");
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
                            // Si 100, signifie que la catégorie, type, fonction, pâte n'existe pas
                            else if (check === 100) {
                                td.style.color = "#A9A9A9";
                            }
                            // Si 200, signifie que le contexte n'est pas bon ou que les formats ne sont pas valides
                            else if (check === 200) {
                                td.style.color = "#B80000";
                            }
                            // Si 300, signifie que le site, le contexte et le numéro d'inventaire ne sont pas bons
                            else if (check === 300) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#B80000";
                                let tdContext = tr.querySelector('td[data-column="context"]');
                                tdContext.style.color = "#B80000";
                                let tdNumber = tr.querySelector('td[data-column="number"]');
                                tdNumber.style.color = "#B80000";
                            }
                            // Si 400, signifie que le contexte et le numéro d'inventaire ne sont pas bons
                            else if (check === 400) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#000000";
                                let tdContext = tr.querySelector('td[data-column="context"]');
                                tdContext.style.color = "#B80000";
                                let tdNumber = tr.querySelector('td[data-column="number"]');
                                tdNumber.style.color = "#B80000";
                            }
                            // Si 500, signifie que seul le numéro d'inventaire n'est pas bon
                            else if (check === 500) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#000000";
                                let tdContext = tr.querySelector('td[data-column="context"]');
                                tdContext.style.color = "#000000";
                                let tdNumber = tr.querySelector('td[data-column="number"]');
                                tdNumber.style.color = "#B80000";
                            }
                            // Si 600, signifie que le site, contexte et numéro d'inventaires sont OK
                            else if (check === 600) {
                                let tr = td.parentElement;
                                let tdSite = tr.querySelector('td[data-column="site"]');
                                tdSite.style.color = "#000000";
                                let tdContext = tr.querySelector('td[data-column="context"]');
                                tdContext.style.color = "#000000";
                                let tdNumber = tr.querySelector('td[data-column="number"]');
                                tdNumber.style.color = "#000000";
                            } else {
                                alert("Il semble que la validation ne fonctionne pas comme prévu. Veuillez s'il-vous-plait contacter l'administrateur à ce propos");
                            }

                            // Indique la nouvelle valeur dans le JSON
                            updateJsonFile(row, column, newText, "inventory", check);
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
                    echo "<a href='" . create_url(["new_inventory", "validate"]) . "' class='btn btn-success' role='button'>" . $next_action . "</a>";
                    echo "<a href='";
                    if (isset($idsite)) {
                        echo Site::find_by_id($idsite)->url();
                    } elseif (isset($idphase)) {
                        echo Phase::find_by_id($idphase)->url();
                    } elseif (isset($idcontext)) {
                        echo Context::find_by_id($idcontext)->url();
                    } else {
                        echo create_url(["homepage"]);
                    }
                    echo "' class='btn btn-secondary' role='button'>Stopper temporairement l&#39;upload</a>";
                    echo "<a href='" . create_url(["new_inventory", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>Abandonner l&#39;upload</a>";
                echo "</div>";

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>