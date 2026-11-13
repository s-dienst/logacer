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
        $file_path_json = "static/ajax/data_adding_site" . $_SESSION['user']->id() . ".json";
        // Sauvegarde des données du JSON (si validation des ajouts en cours)
        // Récupération du JSON
        if (file_exists($file_path_json)) {
            $json_file = file_get_contents($file_path_json);
            $json_file = json_decode($json_file, true);
        }
        if (!$is_new && !$pausing) {
            // Récupération des données dans le JSON
            foreach ($json_file['objects'] as $key => $object) {
                // Vérification des droits d'enregistrment pour ce projet
                // Lie uniquement si projet mentionné et droits, sinon enregistrement sans lier
                $object['project'] = PROJECT->id();
                // Description copiée comme description HTML
                if (isset($object['descr'])) {
                    $object['descr_html'] = $object['descr'];
                }
                // Enregistrement du site
                $read_object = new Site($object);
                // Soit le créateur est responsable du site, soit il est responsable ou contributeur du projet
                if ($read_object->contributor_rights()) {
                    $success = $read_object->save();
                // Si le créateur ajoute un site pour quelqu'un d'autre, il doit en être contributeur
                } else {
                    $success = $read_object->save();
                    if ($success) {
                        $added_site = Site::find_by_owner_code($read_object->owner('prop'), $read_object->code());
                        if ($added_site) {
                            DatabaseObject::find_by_sql("INSERT INTO link_site_contributor (site, contributor) VALUES (" . $added_site->id() . ", " . $_SESSION['user']->id() . ")");
                        }
                    }
                }
                if ($success) {
                    // Crée la nouvelle phase par défaut
                    $idsite = Site::find_by_owner_code($read_object->owner('prop'), $read_object->code())->id();
                    $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$idsite, 'public'=>1, 'unpublished'=>1]);
                    $default_phase->save();
                }
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
            unlink("static/ajax/data_adding_site" . $_SESSION['user']->id() . ".json");
            unlink("static/temp/temp" . $_SESSION['user']->id() . ".xlsx");
            // Redirection
            header('Location: ' . create_url(["homepage"]));
            exit();
        }

        // Récupère le CSV et commence à le décrypter
        if ($is_new) {
            // Avant tout, supprimer les fichiers existants
            if (file_exists("static/ajax/data_adding_site" . $_SESSION['user']->id() . ".json")) {
                unlink("static/ajax/data_adding_site" . $_SESSION['user']->id() . ".json");
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
        $title = ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("sites");

        // Array des headers possibles : UNIQUEMENT FR !!
        $accepted_headers = ["responsable opération", "code opération archéologique", "nom opération archéologique",
            "coord. lat", "coord. long", "code région",
            "public (oui/non)", "inédit (oui/non)", "revue litt. (oui/non)", "description"
        ];
        // Array pour transformation des headers : UNIQUEMENT FR !!
        $convert_headers = ["responsable opération"=>"owner_username", "code opération archéologique"=>"code", "nom opération archéologique"=>"name",
            "coord. lat"=>"coord_lat", "coord. long"=>"coord_long", "code région"=>"region_code",
            "public (oui/non)"=>"public_displ", "inédit (oui/non)"=>"unpublished_displ", "revue litt. (oui/non)"=>"biblio_review_displ", "description"=>"descr"
        ];

        // Lecture du fichier CSV
        $header = [];
        $objects = [];
        $objects_for_json = [];
        $site_codes = [];
        $site_names = [];
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
        $sheet = $spreadsheet->getSheetByName("Opérations archéologiques");
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
        $required = ['code', 'name'];
        foreach ($required as $req) {
            if (!in_array($req, $header)) {
                $error_message[] = 'add_sites_no_' . $req;
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
                // Ajoute le owner avec username, et avec l'ID
                if (isset($object['owner_username'])) {
                    if (!User::find_by_sql("SELECT * FROM user WHERE username = :username", ['username'=>$object['owner_username']])) {
                        $object['owner_username'] = User::find_by_id($_SESSION['user']->id())->username();
                    }
                } else {
                    $object['owner_username'] = User::find_by_id($_SESSION['user']->id())->username();
                }
                $object['owner'] = User::find_by_sql("SELECT * FROM user WHERE username = :username", ['username'=>$object['owner_username']])[0]->id();
                // S'il y a une région, ajoute le numéro d'ID de la région
                if (isset($object['region_code'])) {
                    $region = Region::find_by_code($object['region_code']);
                    if ($region) {
                        $object['region'] = $region->id();
                    }
                }
                // Transforme les public, unpublished et biblio_review display en booléens
                foreach (['public', 'unpublished', 'biblio_review'] as $bool) {
                    $bool_val = $bool . '_displ';
                    if (isset($object[$bool_val])) {
                        if (in_array($object[$bool_val], ['oui', 'Oui', 'OUI'])) {
                            $object[$bool] = 1;
                        } elseif (in_array($object[$bool_val], ['non', 'Non', 'NON'])) {
                            $object[$bool] = 0;
                        } else {
                            $object[$bool_val] = "";
                        }
                    }
                }

                // Crée un site sur base des données rentrées
                $object_inst = new Site($object);
                // Crée les erreurs pour l'objet si elles existent ; ajoute le numéro d'inventaire à la liste
                if (!isset($site_codes[$object['owner']])) {
                    $site_codes[$object['owner']] = [];
                }
                list($site_codes[$object['owner']][], $site_names) = $object_inst->check_errors_add($site_codes[$object['owner']], $site_names);
                
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
                        $success = $object_inst->save();
                        // Soit le créateur est responsable du site, soit il est responsable ou contributeur du projet
                        if ($object_inst->contributor_rights()) {
                            $success = $object_inst->save();
                        // Si le créateur ajoute un site pour quelqu'un d'autre, il doit en être contributeur
                        } else {
                            $success = $object_inst->save();
                            if ($success) {
                                $added_site = Site::find_by_owner_code($object_inst->owner('prop'), $object_inst->code());
                                if ($added_site) {
                                    DatabaseObject::find_by_sql("INSERT INTO link_site_contributor (site, contributor) VALUES (" . $added_site->id() . ", " . $_SESSION['user']->id() . ")");
                                }
                            }
                        }
                        if ($success) {
                            // Crée la nouvelle phase par défaut
                            $idsite = Site::find_by_owner_code($object_inst->owner('prop'), $object_inst->code())->id();
                            $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$idsite, 'public'=>1, 'unpublished'=>1]);
                            $default_phase->save();
                        }
                    }
                }
                $lines_checked++;
            }
            // Préparation du fichier JSON
            // Calculate length of file
            $total = $highest_row;
            // Crée l'array à convertir (avec métadonnées et objets)
            $lines_data = ['begin'=>$already_counted + 1, 'end'=>$already_counted + $lines_checked, 'rest'=>$total - $already_counted - $lines_checked, 'total'=>$total, 'checked'=>$lines_checked, 'displayed'=>$lines_added, 'check_all'=>$check_all, 'objects'=>$objects_for_json];
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
                echo h(2, ucfirst(thesaurus('add data')) . thesaurus(":") . " " . thesaurus("sites"));
                echo "<p>Lignes <b>". $lines_data['begin'] . "</b> à <b>" . $lines_data['end'] . "</b>.
                <p>Total des lignes : <b>" . $lines_data['total'] . "</b>.
                <p>Lignes restantes : <b>" . $lines_data['rest'] . "</b>.
                <p>Lignes affichées : <b>" . $lines_data['displayed'] . "</b>";
                // Prépare contenu du POST
                $inc_valid_obj = 0;
                // Création liste de colonnes
                $cols = ['owner', 'code', 'name', 'coord_lat', 'coord_long', 'region', 'public', 'unpublished', 'biblio_review', 'descr'];
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
        function verifyValidity(inputValue, column, row) {
            const project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;
            // Chemin du fichier PHP et autres données
            return fetch("<?php echo BASE_URL; ?>static/ajax/check_sites_added.php", {
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
        let type = 'site';

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
                        let range = {'code':32, 'name':255, 'region':16};
                        if ((['code', 'name', 'region'].includes(column) && newText.length > range[column]) || (['code', 'name', 'number'].includes(column) && (!newText || newText.length === 0))) {
                            if (newText.length > range[column]) {
                                alert("Cette colonne ne doit pas dépasser" + range[column] + " caractères.");
                                td.textContent = currentText;
                            } else {
                                alert("Cette colonne doit contenir une valeur.");
                                td.textContent = currentText;
                            }
                        } else if (['coord_lat', 'coord_long'].includes(column) && isNaN(newText)) {
                            alert("Vous devez entrer un nombre.");
                            td.textContent = currentText;
                        } else if (['coord_lat', 'coord_long'].includes(column) && newText == 0) {
                            td.textContent = "";
                        } else if (['public', 'unpublished', 'biblio_review'].includes(column) && ((newText.toLowerCase() !== 'oui' && newText.toLowerCase() !== 'non') || !newText || newText.length === 0)) {
                            alert("Vous ne pouvez entrer que 'oui' ou 'non'");
                            td.textContent = currentText;
                        } else {
                            // Vérification d'unicité
                            let table = document.getElementById("inventory_table");
                            let duplicate = false;

                            if (column === "owner" || column === "code") {
                                // On récupère la valeur de l'autre cellule (owner ou code) de la même ligne
                                let rowSelector = 'td[data-row="' + row + '"][data-column="' + (column === "owner" ? "code" : "owner") + '"]';
                                let otherValue = table.querySelector(rowSelector)?.textContent.trim();

                                // Si on est en train de modifier "owner", newText = owner et otherValue = code
                                // Si on est en train de modifier "code", newText = code et otherValue = owner
                                let owner = (column === "owner") ? newText : otherValue;
                                let code  = (column === "code")  ? newText : otherValue;

                                if (owner && code) {
                                    // Vérifier si une autre ligne a la même combinaison
                                    table.querySelectorAll("tr").forEach(tr => {
                                        let rOwner = tr.querySelector('td[data-column="owner"]')?.textContent.trim();
                                        let rCode  = tr.querySelector('td[data-column="code"]')?.textContent.trim();
                                        let rRow   = tr.querySelector('td')?.getAttribute("data-row");

                                        if (rRow !== row && rOwner === owner && rCode === code) {
                                            duplicate = true;
                                        }
                                    });
                                }

                                if (duplicate) {
                                    alert("Il existe déjà dans ce tableau une autre opération archéologique avec ce responsable et ce code. Le nom doit être unique.");
                                    td.textContent = currentText;
                                    return;
                                }
                            }

                            if (column === "name") {
                                // Vérifier unicité du name
                                table.querySelectorAll('td[data-column="name"]').forEach(cell => {
                                    let rRow = cell.getAttribute("data-row");
                                    if (rRow !== row && cell.textContent.trim() === newText) {
                                        duplicate = true;
                                    }
                                });

                                if (duplicate) {
                                    alert("Il existe déjà dans ce tableau une autre opération archéologique avec ce nom. Le nom doit être unique.");
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
                            // Si 100, signifie que public, unpublished ou biblio-review sont mal configurés
                            else if (check === 100) {
                                td.style.color = "#A9A9A9";
                            }
                            // Si 200, signifie que le contexte n'est pas bon ou que les formats ne sont pas valides
                            else if (check === 200) {
                                td.style.color = "#B80000";
                            }
                            // Si 301, signifie que l'owner et le code du site ne sont pas bons
                            else if (check === 301) {
                                let tr = td.parentElement;
                                let tdOwner = tr.querySelector('td[data-column="owner"]');
                                tdOwner.style.color = "#B80000";
                                let tdCode = tr.querySelector('td[data-column="code"]');
                                tdCode.style.color = "#B80000";
                            }
                            // Si 401, signifie que l'owner est bon mais pas le code du site
                            else if (check === 401) {
                                let tr = td.parentElement;
                                let tdOwner = tr.querySelector('td[data-column="owner"]');
                                tdOwner.style.color = "#000000";
                                let tdCode = tr.querySelector('td[data-column="code"]');
                                tdCode.style.color = "#B80000";
                            }
                            // Si 601, signifie que l'owner et le code du site sont bons
                            else if (check === 601) {
                                let tr = td.parentElement;
                                let tdOwner = tr.querySelector('td[data-column="owner"]');
                                tdOwner.style.color = "#000000";
                                let tdCode = tr.querySelector('td[data-column="code"]');
                                tdCode.style.color = "#000000";
                            } else {
                                alert("Il semble que la validation ne fonctionne pas comme prévu. Veuillez s'il-vous-plait contacter l'administrateur à ce propos.");
                            }

                            // Indique la nouvelle valeur dans le JSON
                            updateJsonFile(row, column, newText, "site", check);
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
                    echo "<a href='" . create_url(["new_site", "validate"]) . "' class='btn btn-success' role='button'>" . $next_action . "</a>";
                    echo "<a href='" . create_url(["homepage"]) . "' class='btn btn-secondary' role='button'>Stopper temporairement l&#39;upload</a>";
                    echo "<a href='" . create_url(["new_site", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>Abandonner l&#39;upload</a>";
                echo "</div>";

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>