<?php
    // Fonctions spécifiques
    require_once('functions_horizons_advanced.php');

    // Check si module bien intégré
    $error_message = false;
    if (!PROJECT) {
        $error_message = 'no_project';
    } elseif (!PROJECT->setting_horizon_adv()) {
        $error_message = 'no_mod_advanced_horizons';
    } elseif (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        // Recherche des configurations
        $general_configs = ConfigHorizon::find_all();
        $configs_js= [];
        $configs_inventory = [];
        $configs_types = [];
        foreach ($general_configs as $c) {
            if ($c->contributor_rights()) {
                $t = $c->type();
                if (in_array($t, ['phases', 'contexts'])) {
                    $configs_inventory[] = $c;
                } elseif ($t === 'types') {
                    $configs_types[] = $c;
                }
                // Création data pour javascript
                $contribs = [];
                foreach (User::linked('config_horizon', 'contributor', $c->id()) as $contrib) {
                    $contribs[] = ['name'=>$contrib->codename(), 'id'=>$contrib->id()];
                }
                $configs_js[$c->id()] = ['type'=>$t, 'name'=>$c->codename(), 'owner'=>User::find_by_id($c->owner('prop'))->codename(), 'is_owner'=>$c->owner_rights(), 'contributors'=>$contribs];
            }
        }

        // Recherche des sites, horizons, phases et contextes
        $list_inventory = [
            'sites'    => [],
            'phases'   => [],
            'contexts' => [],
            'horizons' => [],
            'facies'   => [],
        ];
        $sites = Site::find_all(['code']);
        foreach ($sites as $s) {
            if ($s->contributor_rights() || ($s->public() && $s->allow_graphs())) {
                array_push($list_inventory['sites'], [
                    'type'  => 'site',
                    'site' => $s->name(),
                    'code' => $s->code(),
                    'name'  => $s->codename()
                ]);
                $phases = Phase::find_by_parent($s->id());
                foreach ($phases as $p) {
                    if ($p->contributor_rights() || $p->public()) {
                        $horizon = 0;
                        $facies = 0;
                        if ($p->horizon()) {
                            if (($p->horizon()->facies()->contributor_rights() || $p->horizon()->facies()->public()) && ($p->horizon()->contributor_rights() || $p->horizon()->public())) {
                                $horizon = $p->horizon()->code();
                                $facies = $p->horizon()->facies()->code();
                            }
                        }
                        array_push($list_inventory['phases'], [
                            'type'    => 'phase',
                            'facies'  => $facies,
                            'horizon' => $horizon,
                            'site'    => $s->name(),
                            'code'    => $p->code(),
                            'name'    => ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $p->codename()
                        ]);
                        $contexts = Context::find_by_parent($p->id());
                        foreach ($contexts as $c) {
                            if ($c->contributor_rights() || $c->public()) {
                                array_push($list_inventory['contexts'], [
                                    'type'    => 'context',
                                    'facies'  => $facies,
                                    'horizon' => $horizon,
                                    'site'    => $s->name(),
                                    'phase'   => $p->code(),
                                    'code'    => $c->code(),
                                    'name'    => ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $c->codename()
                                ]);
                            }
                        }
                    }
                }
            }
        }
        // Recherche de tous les horizons publics
        $facies = Facies::find_all(['code']);
        foreach ($facies as $f) {
            if ($f->contributor_rights() || ($f->public() && $f->allow_graphs())) {
                $list_inventory['facies'][$f->code()] = $f->codename();
                $horizons = Horizon::find_by_parent($f->id());
                foreach ($horizons as $h) {
                    if ($h->contributor_rights() || $h->public()) {
                        array_push($list_inventory['horizons'], [
                            'type'   => 'horizon',
                            'facies' => $f->code(),
                            'code'   => $h->code(),
                            'name'   => $h->codename()
                        ]);
                    }
                }
            }
        }

        // Recherche des méthodes de comptage
        $countings_methods = Counting::find_all();

        // Titre
        $title = ucfirst(thesaurus("seriations_horizons"));
    }

?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
        <!-- Error message if not a valid horizon -->
        <?php if ($error_message) { display_fatal_error($error_message); } else {

        echo "<div class='container my-4'>
            <h1 class='mb-4'>" . $title . "</h1>";

            /* Paramètres */
            // Sélection des contextes ou phases
                // Menu déroulant de la configuration (et bouton gestion)
                $options = opt('', ucfirst(thesaurus('unregistered_config')));
                foreach ($configs_inventory as $c) {
                    $options .= opt($c->id(), $c->codename());
                }
                $select_config = label(ucfirst(thesaurus('config')), 'config-inventory-select')
                    . bloc(select('', $options, 'config-inventory-select', 'config-inventory-select', '', 'form-select me-2')
                    . "<button type='button' class='btn btn-outline-secondary flex-shrink-0' id='manage-config-inventory'>"
                        . ucfirst(thesaurus('manage')) .
                    "</button>",
                    0, 0, '', 'd-flex');
                
                // Menu déroulant de choix entre phases ou contextes
                $select_type_items = select(ucfirst(thesaurus('working_with')) . thesaurus(':'),
                    opt('phases', ucfirst(thesaurus('phases')))
                    . opt('contexts', ucfirst(thesaurus('contexts'))),
                    'mode-select');
                
                // Recherche des sites, phases ou contextes
                $options = '';
                foreach (['site', 'horizon', 'phase'] as $el) {
                    $options .= opt($el . 's', ucfirst(thesaurus('by')) . ' ' . thesaurus($el));
                }
                $search_elements = label(ucfirst(thesaurus('search')) . thesaurus(':'))
                    . bloc(select('', $options, 'add-mode-select', 'add-mode-select', 'max-width: 300px;')
                    . input('text', 'search-input', ucfirst(thesaurus('search_input'))),
                    0, 0, '', 'input-group');
                
                // Emplacement des résultats de la recherche
                $search_results = bloc(bloc('', 0, 2, 'search-results', 'list-group'));
                
                // Emplacement des éléments sélectionnés
                $selected_items = bloc(h(4, ucfirst(thesaurus('selected_items')) . thesaurus(':')) . bloc('', 0, 0, 'selected-items', 'flex-wrap'), 0);

            // Création de la carte
            $card_header = "1. " . ucfirst(thesaurus('phases')) . ' ' . thesaurus('or') . ' ' . thesaurus('contexts');
            $card_body = in_columns([$select_config, $select_type_items]) . $search_elements . $search_results . $selected_items;
            echo card($card_header, $card_body);

            // Sélection des types
                // Header
                $header_title = "<span>2. " . ucfirst(thesaurus('typologies')) . ' ' . thesaurus('and') . ' ' . thesaurus('types') . "</span>";
                $header_button = "<button id='button-update-types' class='btn btn-sm btn-secondary' type='button'>" . ucfirst(thesaurus('update')) . "</button>";

                // Spinner
                $spinner = "<div id='loading-spinner-types' class='text-center my-3' style='display:none;'>
                    <div class='spinner-border text-primary' role='status'>
                        <span class='visually-hidden'>Loading...</span>
                    </div>
                </div>";

                // Menu déroulant de la configuration (et bouton gestion)
                $options = opt('', ucfirst(thesaurus('unregistered_config')));
                foreach ($configs_types as $c) {
                    $options .= opt($c->id(), $c->codename());
                }
                $select_config = label(ucfirst(thesaurus('config')), 'config-types-select')
                    . bloc(select('', $options, 'config-types-select', 'config-types-select', '', 'form-select me-2')
                    . "<button type='button' class='btn btn-outline-secondary flex-shrink-0' id='manage-config-types'>"
                        . ucfirst(thesaurus('manage')) .
                    "</button>",
                    0, 0, '', 'd-flex');

                // Emplacement pour les typologies
                $display_typologies = bloc('', 0, 2, 'display-typologies', 'accordion');

            // Création de la carte
            $card_header = ['content'=>$header_title . $header_button, 'style'=>'d-flex justify-content-between align-items-center'];
            $card_body = $spinner . $select_config . $display_typologies;
            echo card($card_header, $card_body);

            // Counting methods
            echo "<div class='card mb-3'>
                <div class='card-header'>3. " . ucfirst(thesaurus('counting')) . "</div>
                <div class='card-body'>";
                    // Choix de la méthode de comptage
                    echo "<div class='mb-3'>
                        <label for='counting-select' class='form-label'>" . ucfirst(thesaurus('choose_counting')) . thesaurus(':') . "</label>
                        <select id='counting-select' class='form-select'>";
                            // Options disponibles
                            echo "<option value=''>-- " . thesaurus('select counting') . " --</option>";
                            foreach ($countings_methods as $cm) {
                                echo "<option value='" . $cm->id() . "'>" . $cm->name() . "</option>";
                            }
                            // Ajouter option nombre de lignes d'inventaire
                            echo "<option value='0'>" . ucfirst(thesaurus('occurence number')) . "</option>";
                        echo "</select>";
                    echo "</div>";
                echo "<div id='counting-special-zone' class='mt-3'></div>";
                echo "</div>
            </div>";

            /* Bouton de lancement */
            echo "<div class='text-center my-4'>
                <button id='btn-analyse' class='btn btn-primary btn-lg'>" . ucfirst(thesaurus('launch_analysis')) . "</button>
            </div>";

            /* Résultats */
            echo "<div class='card mb-3'>
                <div class='card-header'>" . ucfirst(thesaurus("results_single")) . "</div>
                <div class='card-body'>";
                // Boutons pour lancer les analyses plus poussées
                echo "<div class='text-center my-4' id='buttons-results' hidden>
                    <button id='btn-seriation-reverse' class='btn btn-primary'>" . ucfirst(thesaurus('reverse_seriation')) . "</button>
                    <button id='btn-fa-calculation' class='btn btn-primary'>" . ucfirst(thesaurus('ca_full')) . "</button>
                </div>";
                // Spinner
                echo "<div id='loading-spinner' class='text-center my-3' style='display:none;'>
                    <div class='spinner-border text-primary' role='status'>
                        <span class='visually-hidden'>" . ucfirst(thesaurus('loading')) . "...</span>
                    </div>
                </div>";
                // Partie avec le graphique
                echo "<div class='d-flex flex-wrap mb-4' id='graphic-zone'>";
                echo "</div>";
                
                echo "<div class='table-responsive' id='table-result' style='max-height:600px'>";
                    // Tableau généré via AJAX -->
                echo "</div>
                </div>
            </div>
        </div>";

        // Emplacement pour le modal :
        echo "<div id='div-modal'></div>";

        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

<script>
    // Création constantes et variables nécessaires
    // Variables pour les recherches de phases et contextes
    const listInventoryData     = <?php echo json_encode($list_inventory); ?>;
    let   selectedList          = []; // liste des éléments choisis
    const configInventorySelect = document.getElementById('config-inventory-select');
    const modeSelect            = document.getElementById('mode-select');
    const addModeSelect         = document.getElementById('add-mode-select');
    const searchInput           = document.getElementById('search-input');
    const searchResults         = document.getElementById('search-results');
    const selectedItems         = document.getElementById('selected-items');
    const colors                = <?php echo json_encode(COLORS_HORIZONS_ADVANCED_1); ?>;
    let   colorIndex            = 1;
    // Variables pour les typologies et types
    const configTypesSelect     = document.getElementById('config-types-select');
    const btnUpdateType         = document.getElementById('button-update-types');
    let typeList                = null;
    let disabledTypes           = [];
    let usedTypes               = [];
    let listGroupCardIds        = [];
    let listConfigTypeIds       = [];
    // Variables pour la gestion des modals
    const displayTypologies     = document.getElementById('display-typologies');
    let configInformation       = <?php echo json_encode($configs_js); ?>;
    let configInventoryHasChanged = false;

    // Variables pour les calculs statistiques
    let tableResults            = null;
    let typeGroupsInfo          = null;
    let tableResultsCA          = null;
    let typeGroupsInfoCA        = null;
    let limitsCoordCA           = null;

    /* Partie recherche des phases et contextes. Éléments présents :
    * Fonctions utilitaires :
    *  resetSelection : réinitialise la sélection
    *  orderedInsertion : utilisé pour insérer un élément dans le DOM de façon alphabétique des ID
    *  addToSelected : ajout phase/contexte dans variable et HTML avec parents
    *  addItem : recherche les items à ajouter et délenche addToSelected
    * Déclenchements par boutons :
    *  modeSelect : gère le changement de mode
    *  addModeSelect : vide la zone de recherche si changement sur ce qui est recherché
    *  searchInput : crée les résultats d'une recherche
    *  removeSelectedItems : gère la suppression des phases/contextes etc.
    *  configInventorySelect : gère le changement de configuration, qui implique un affichage différent
    */

    // Réinitialiser la sélection
    function resetSelection() {
        selectedList = [];
        colorIndex = 1;
        selectedItems.innerHTML = '';
        searchInput.value = '';
        searchResults.innerHTML = '';
    }


    // Permet d'insérer l'élément de façon alphabétique selon l'identifiant
    function orderedInsertion(parent, toInsert) {
        const children = parent.children;
        let inserted = false;

        for (let i = 0; i < children.length; i++) {
            if (children[i].id.localeCompare(toInsert.id) > 0) {
                // insère avant le premier enfant dont l'id est "plus grand"
                parent.insertBefore(toInsert, children[i]);
                inserted = true;
                break;
            }
        }

        // si aucun enfant n'a un id supérieur, on ajoute à la fin
        if (!inserted) {
            parent.appendChild(toInsert);
        }
    }


    // Ajout de la phase/contexte à la variable selectedList et dans la liste affichée (avec parents si nécessaire)
    function addToSelected(item, isContext = false, color=false) {
        // D'abord, on va récupérer la couleur
        let configColor = false;
        let numberColor = 0;
        if (color) {
            if (Number.isInteger(color)) {
                configColor = colors[color].rgb;
                numberColor = color;
            } else if (color[0] === "#") {
                configColor = color;
                numberColor = color;
            } else {
                configColor = colors[parseInt(color)].rgb;
                numberColor = parseInt(color);
            }
        }
        let idFacies = 'selected-items-facies-' + item.facies;
        if (item.facies === 0) {
            idFacies = 'selected-items-no-facies';
        }

        // Création hiérarchie si nécessaire
        if (!selectedList[item.facies]) {
            selectedList[item.facies] = {};
            // Création du titre
            let faciesName = ucfirst(thesaurus('no facies'));
            if (!(item.facies === 0)) {
                faciesName = listInventoryData['facies'][item.facies];
            }
            const fTitle = document.createElement('h5');
            fTitle.classList.add('d-flex', 'align-items-center');
            const fColor = document.createElement('button');
            fColor.classList.add('btn', 'btn-sm', 'p-0', 'color-btn', 'me-2');
            fColor.type = 'button';
            if (item.facies === 0) {
                if (configColor) {
                    fColor.style.backgroundColor = configColor;
                } else {
                    fColor.style.backgroundColor = '#808080';
                }
            } else {
                fColor.style.backgroundColor = "#ffffff";
            }
            fColor.addEventListener('click', () => {
                createColorModal(idFacies, faciesName)
            });
            const fDelete = document.createElement('button');
            fDelete.classList.add('btn-close');
            fDelete.type = 'button';
            fDelete.addEventListener('click', () => {
                removeSelectedItems(item, 'facies', isContext)
            });
            const fName = document.createElement('span');
            fName.classList.add('flex-grow-1');
            fName.textContent = faciesName;
            if (item.facies === 0) {
                fName.textContent = ucfirst(thesaurus('no facies'));
            } else {
                fName.textContent = listInventoryData['facies'][item.facies];
            }
            fTitle.append(fColor, fDelete, fName);

            // Insertion dans un div avec titre et contenu
            const divContent = document.createElement('div');
            divContent.id = idFacies + '-content';
            if (item.facies === 0 && !isContext) {
                divContent.classList.add('d-flex', 'flex-wrap', 'mb-2');
            }
            fDiv = addToDiv([fTitle, divContent], 3, idFacies);
            if (item.facies === 0) {
                if (configColor) {
                    fDiv.dataset.color = numberColor;
                } else {
                    fDiv.dataset.color = "#808080";
                }
            } else {
                fDiv.dataset.color = 0;
            }

            // Insertion du div au bon endroit
            orderedInsertion(selectedItems, fDiv);
        }

        if (!selectedList[item.facies][item.horizon]) {
            selectedList[item.facies][item.horizon] = {};
            // Création du titre (si faciès)
            if (!(item.facies === 0)) {
                const horizon = listInventoryData['horizons'].find(
                    el => el.facies === item.facies && el.code === item.horizon
                );
                const hTitle = document.createElement('h5');
                hTitle.classList.add('d-flex', 'align-items-center');
                const hColor = document.createElement('button');
                hColor.classList.add('btn', 'btn-sm', 'p-0', 'color-btn', 'me-2', 'ms-2');
                hColor.type = 'button';
                let colorChosen = null;
                if (color) {
                    hColor.style.backgroundColor = configColor;
                    colorChosen = numberColor;
                } else {
                    hColor.style.backgroundColor = colors[colorIndex].rgb;
                    colorChosen = colorIndex;
                    if ((colorIndex + 1) in colors) {
                        colorIndex++;
                    }
                }
                hColor.addEventListener('click', () => {
                    createColorModal('selected-items-horizon-' + item.facies + '-' + item.horizon, horizon.name);
                });
                const hDelete = document.createElement('button');
                hDelete.classList.add('btn-close');
                hDelete.type = 'button';
                hDelete.addEventListener('click', () => {
                    removeSelectedItems(item, 'horizon', isContext);
                });
                const hName = document.createElement('span');
                hName.classList.add('flex-grow-1');
                hName.textContent = horizon.name;
                hTitle.append(hColor, hDelete, hName);

                // Insertion dans un div avec titre et contenu
                const divContent = document.createElement('div');
                divContent.id = 'selected-items-horizon-' + item.facies + '-' + item.horizon + '-content';
                if (!isContext) {
                    divContent.classList.add('d-flex', 'flex-wrap', 'mb-2');
                }
                hDiv = addToDiv([hTitle, divContent], 3, 'selected-items-horizon-' + item.facies + '-' + item.horizon);
                hDiv.dataset.color = colorChosen;

                // Insertion du div au bon endroit
                orderedInsertion(document.getElementById(idFacies + '-content'), hDiv);
            }
        }

        if (!isContext) {
            if (!selectedList[item.facies][item.horizon][item.site]) {
                selectedList[item.facies][item.horizon][item.site] = [];
            }
            const phases = selectedList[item.facies][item.horizon][item.site];
            if (!phases.includes(item.code)) {
                phases.push(item.code);
                // Ajout du badge
                const badge = document.createElement('badge');
                badge.classList.add('badge', 'd-flex', 'align-items-center', 'text-white', 'me-2', 'mb-2', 'context-badge');
                if (color) {
                    badge.style.backgroundColor = configColor;
                    badge.dataset.color = numberColor;
                } else if (item.facies === 0) {
                    badge.style.backgroundColor = document.getElementById(idFacies).querySelector('button').style.backgroundColor;
                    badge.dataset.color = document.getElementById(idFacies).dataset.color;
                } else {
                    badge.style.backgroundColor = document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon).querySelector('button').style.backgroundColor;
                    badge.dataset.color = document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon).dataset.color;
                }
                badge.style.cursor = 'pointer';
                badge.id = 'selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.code;
                badge.addEventListener('click', () => {
                    createColorModal('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.code, item.name);
                });
                const bDelete = document.createElement('button');
                bDelete.classList.add('btn-close', 'btn-close-white', 'ms-2');
                bDelete.type = 'button';
                bDelete.addEventListener('click', () => {
                    removeSelectedItems(item, 'phase', isContext);
                });
                badge.textContent = item.code;
                badge.appendChild(bDelete);
                if (item.facies === 0) {
                    orderedInsertion(document.getElementById(idFacies + '-content'), badge);
                } else {
                    orderedInsertion(document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon + '-content'), badge);
                }
            }
        } else {
            if (!selectedList[item.facies][item.horizon][item.site]) {
                selectedList[item.facies][item.horizon][item.site] = {};
            }
            if (!selectedList[item.facies][item.horizon][item.site][item.phase]) {
                selectedList[item.facies][item.horizon][item.site][item.phase] = [];
                // Création du titre
                const phase = listInventoryData['phases'].find(
                    el => el.site === item.site && el.code === item.phase
                );
                const pTitle = document.createElement('h6');
                pTitle.classList.add('d-flex', 'align-items-center');
                const pColor = document.createElement('button');
                pColor.classList.add('btn', 'btn-sm', 'p-0', 'color-btn', 'me-2', 'ms-4');
                pColor.type = 'button';
                if (color) {
                    pColor.style.backgroundColor = configColor;
                } else if (item.facies === 0) {
                    pColor.style.backgroundColor = document.getElementById(idFacies).querySelector('button').style.backgroundColor;
                } else {
                    pColor.style.backgroundColor = document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon).querySelector('button').style.backgroundColor;
                }
                pColor.addEventListener('click', () => {
                    createColorModal('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase, phase.name)
                });
                const pDelete = document.createElement('button');
                pDelete.classList.add('btn-close');
                pDelete.type = 'button';
                pDelete.addEventListener('click', () => {
                    removeSelectedItems(item, 'phase', isContext);
                });
                const pName = document.createElement('span');
                pName.classList.add('flex-grow-1');
                pName.textContent = phase.name;
                pTitle.append(pColor, pDelete, pName);

                // Insertion dans un div avec titre et contenu
                const divContent = document.createElement('div');
                divContent.id = 'selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase + '-content';
                divContent.classList.add('d-flex', 'flex-wrap', 'mb-2');
                pDiv = addToDiv([pTitle, divContent], 3, 'selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase);
                if (color) {
                    pDiv.dataset.color = numberColor;
                } else if (item.facies === 0) {
                    pDiv.dataset.color = document.getElementById(idFacies).dataset.color;
                } else {
                    pDiv.dataset.color = document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon).dataset.color;
                }
                // Insertion du div au bon endroit
                if (item.facies === 0) {
                    orderedInsertion(document.getElementById(idFacies + '-content'), pDiv);
                } else {
                    orderedInsertion(document.getElementById('selected-items-horizon-' + item.facies + '-' + item.horizon + '-content'), pDiv);
                }
            }
            const contexts = selectedList[item.facies][item.horizon][item.site][item.phase];
            if (!contexts.includes(item.code)) {
                contexts.push(item.code);
                // Ajout du badge
                const badge = document.createElement('badge');
                badge.classList.add('badge', 'd-flex', 'align-items-center', 'text-white', 'me-2', 'mb-2', 'context-badge');
                if (color) {
                    badge.style.backgroundColor = configColor;
                    badge.dataset.color = numberColor;
                } else {
                    badge.style.backgroundColor = document.getElementById('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase).querySelector('button').style.backgroundColor;
                    badge.dataset.color = document.getElementById('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase).dataset.color;
                }
                badge.style.backgroundColor = document.getElementById('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase).querySelector('button').style.backgroundColor;
                badge.dataset.color = document.getElementById('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase).dataset.color;
                badge.style.cursor = 'pointer';
                badge.id = 'selected-items-context-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase + '-' + item.code;
                badge.addEventListener('click', () => {
                    createColorModal('selected-items-context-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase + '-' + item.code, item.name);
                });
                const bDelete = document.createElement('button');
                bDelete.classList.add('btn-close', 'btn-close-white', 'ms-2');
                bDelete.type = 'button';
                bDelete.addEventListener('click', () => {
                    removeSelectedItems(item, 'context', isContext);
                });
                badge.textContent = item.code;
                badge.appendChild(bDelete);
                orderedInsertion(document.getElementById('selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase + '-content'), badge);
            }
        }
    }


    // Ajouter l'élément sélectionné (badge contexte ou phase)
    function addItem(item) {
        if (item.type === 'site') {
            if (modeSelect.value === 'phases') {
                // Récupération des phases avec ce site
                listInventoryData['phases'].filter(el => el.site === item.site)
                // On ajoute ces phases
                    .forEach(el => addToSelected(el, false))
            } else if (modeSelect.value === 'contexts') {
                // Récupération des contextes avec ce site
                listInventoryData['contexts'].filter(el => el.site === item.site)
                // On ajoute ces contextes
                    .forEach(el => addToSelected(el, true))
            }
        } else if (item.type === 'horizon') {
            if (modeSelect.value === 'phases') {
                // Récupération des phases avec cet horizon
                listInventoryData['phases'].filter(el => el.horizon === item.code)
                // On ajoute ces phases
                    .forEach(el => addToSelected(el, false))
            } else if (modeSelect.value === 'contexts') {
                // Récupération des contextes avec cet horizon
                listInventoryData['contexts'].filter(el => el.horizon === item.code)
                // On ajoute ces contextes
                    .forEach(el => addToSelected(el, true))
            }
        } else if (item.type === 'phase') {
            if (modeSelect.value === 'phases') {
                // Ajout de la phase
                addToSelected(item, false)
            } else if (modeSelect.value === 'contexts') {
                // Récupération des contextes avec cette phase
                listInventoryData['contexts'].filter(el => el.phase === item.code)
                // On ajoute ces contextes
                    .forEach(el => addToSelected(el, true))
            }
        } else if (item.type === 'context' && modeSelect.value === 'contexts') {
            // Ajout du contexte
            addToSelected(item, true)
        }

        // Nettoie le champ de recherche et la liste des propositions
        searchResults.innerHTML = '';
        searchInput.value = '';
    }


    // Gère le changement de mode (phases/contextes)
    modeSelect.addEventListener('change', function() {
        resetSelection();
        // Si phase ou contexte sélectionné, recherche possible.
        if (this.value) {
            searchInput.disabled = false;
            // Possibilité de recherche par contexte possible ou non
            const optContext = addModeSelect.querySelector('option[value="contexts"]');
            if (this.value === "phases" && optContext) {
                // Si phase, elle ne doit pas exister
                addModeSelect.removeChild(optContext);
            } else if (this.value === "contexts" && !optContext) {
                // Si contexte, elle doit exister
                const opt = document.createElement('option');
                opt.value = "contexts";
                opt.textContent = ucfirst(thesaurus('by')) + ' ' + thesaurus('context');
                addModeSelect.appendChild(opt);
            }
        } else {
            searchInput.disabled = true;
        }
    });


    // Si changement de manière d'ajout, la zone de recherche doit se vider
    addModeSelect.addEventListener('change', function() {
        searchResults.innerHTML = '';
        searchInput.value = '';
    });


    // Recherche dynamique dans la liste correspondance (sites, phases, contextes, horizons)
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        searchResults.innerHTML = '';
        if (!query) return;
        
        // Récupère les 10 premiers éléments concordants (avec addModeSelect.value permettant de sélectionner la bonne partie)
        const matches = listInventoryData[addModeSelect.value].filter(item => item.name.toLowerCase().includes(query)).slice(0, 10);
        matches.forEach(item => {
            // Pour chaque élément présenté, crée un bouton qui permet d'ajouter cet élément (via addItem)
            const option = document.createElement('button');
            option.classList.add('list-group-item', 'list-group-item-action');
            option.textContent = item.name;
            option.onclick = () => addItem(item);
            // Ajoute le bouton aux résultats de la recherche
            searchResults.appendChild(option);
        });
    });    

    
    // Retire l'élément du DOM, mais aussi de la selectedList
    function removeSelectedItems(item, itemType, isContext=false) {
        let itemId = null;
        // On retrouve le niveau de la branche à couper
        if (itemType === 'facies') {
            delete selectedList[item.facies];
            itemId = 'selected-items-facies-' + item.facies;
            if (item.facies === 0) {
                itemId = 'selected-items-no-facies';
            }
        } else if (itemType === 'horizon') {
            delete selectedList[item.facies][item.horizon];
            itemId = 'selected-items-horizon-' + item.facies + '-' + item.horizon;
        } else if (itemType === 'phase') {
            if (isContext) {
                delete selectedList[item.facies][item.horizon][item.site][item.phase];
                itemId = 'selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase;
            } else {
                const listPhases = selectedList[item.facies][item.horizon][item.site];
                const index = listPhases.indexOf(item.code);
                if (index !== -1) {
                    listPhases.splice(index, 1);
                }
                itemId = 'selected-items-phase-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.code;
            }
        } else if (itemType === 'context') {
            const listContexts = selectedList[item.facies][item.horizon][item.site][item.phase];
            const index = listContexts.indexOf(item.code);
            if (index !== -1) {
                listContexts.splice(index, 1);
            }
            itemId = 'selected-items-context-' + item.facies + '-' + item.horizon + '-' + item.site + '-' + item.phase + '-' + item.code;
        }
        // Enfin, retrait du DOM
        document.getElementById(itemId).remove();
    }


    // Gère le changement de configuration
    configInventorySelect.addEventListener('change', function() {
        if (this.value) {
            // Si config existante, on reset la sélection, puis on va chercher les données de la config, et enfin on fait les ajouts
            resetSelection();
            // On crée un spinner comme innerHTML
            selectedItems.appendChild(loadingSpinner('loading-spinner-config-inventory'));
            const spinner = document.getElementById('loading-spinner-config-inventory');
            spinner.style.display = 'block';

            // Construction de l'objet à envoyer
            const payload = {
                function: "load_config_seriation",
                type: "inventory",
                configId: this.value,
                project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
            }
                    // Envoi (et réception) AJAX
            fetch("/static/ajax/horizons_advanced.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                // Cache le spinner
                spinner.style.display = 'none';
                // On récupère les données (si pas d'erreur)
                if (!data.error) {
                    const configType = data.configType;
                    const listItems = data.listItems;
                    // On initialise isContext
                    let isContext = null;
                    if (configType === 'phases') {
                        isContext = false;
                    } else if (configType === 'contexts') {
                        isContext = true;
                    }
                    if (isContext !== null) {
                        modeSelect.value = configType;
                        listItems.forEach(i => {
                            // On essaie de retrouver l'item correspondant dans la list
                            const item = listInventoryData[configType].find(
                                el => el.site === i.site && el.code === i.code
                            );
                            // On ajoute à la sélection
                            addToSelected (item, isContext, i.color);
                        });
                    }
                }
            })
            .catch(error => {
                // Cache le spinner
                spinner.style.display = 'none';
                // Affiche l'erreur
                console.error("Erreur AJAX:", error);
            });
        }
    });

    /* Partie gestion des typologies et types. Éléments présents :
    * Fonctions utilitaires :
    *  createTypology : crée l'accordéon d'une typologie
    *  createSubtype : crée les sous-types pour un type principal
    *  createType : crée un type principal
    *  isDisabled : vérifie si le type est désactivé
    *  isUsed : vérifie si le type est utilisé
    *  createNewGroupCard : crée une nouvelle carte de regroupement
    *  addTypeToGroupCard : rajoute le type en badge
    *  addTypeToUsed : signale un type comme utilisé
    *  addParentToDisabled : rend inutilisable tous les types parents
    *  removeTypeFromCard : supprime un badge, et s'il est le dernier, supprime la carte
    * Déclenchements par boutons :
    *  btnUpdateType : déclenche la mise à jour des types présents selon les contextes sélectionnés
    *  handleDragType : stocke les données en prévision du drop du type
    *  handleDropType : pilote les changements nécessaires après un drop de type
    *  renameGroupCard : donne un nouveau nom à la carte et la replace
    *  deleteGroupCard : supprime le groupe et libère tous les types
    *  deleteTypeBadge : retire un badge isolé
    *  configTypesSelect : gère le changement de configuration
    */

    // Crée l'accordéon d'une typologie avec tous ses éléments (sans type)
    function createTypology (code, name) {
        const subtitleUsed = document.createElement('h6');
        subtitleUsed.textContent = "Types utilisés";
        const contentUsed = document.createElement('div');
        contentUsed.id = 'used-types-for-' + code;
        contentUsed.classList.add('p-2', 'pe-5', 'border', 'rounded');
        contentUsed.setAttribute('ondragover', 'event.preventDefault()');
        contentUsed.setAttribute('ondrop', 'handleDropType(event)');
        contentUsed.dataset.typology = code;
        contentUsed.style.minHeight = "100%";
        const contentMessage = document.createElement('div');
        contentMessage.classList.add('placeholder-typologies', 'text-muted', 'fst-italic', 'mt-2');
        contentMessage.textContent = "Glissez ici des types de la typologie " + code + "...";
        contentUsed.appendChild(contentMessage);
        divUsed = addToDiv([subtitleUsed, contentUsed]);
        divUsed.classList.add('col-md-6');
        const subtitleAvailable = document.createElement('h6');
        subtitleAvailable.textContent = "Types disponibles";
        const contentAvailable = document.createElement('div');
        contentAvailable.id = 'available-types-for-' + code;
        divAvailable = addToDiv([subtitleAvailable, contentAvailable]);
        divAvailable.classList.add('col-md-6');
        const divTypology = addToDiv([divUsed, divAvailable]);
        divTypology.classList.add('row');
        return accordionItem (name, divTypology, "typology-" + code, 'display-typologies', false);
    }

    // Crée le corps de la carte d'un type principal s'il y a des sous-types (fonction récursive)
    function createSubtype (typology, code, subtype, main = true) {
        const subDiv = document.createElement('div');
        if (main) {
            subDiv.classList.add('ms-3');
        } else {
            subDiv.classList.add('ms-2');
        }
        subDiv.classList.add('mb-1', 'align-items-center');
        const dragDiv = document.createElement('div');
        dragDiv.classList.add('mb-1', 'handle-type');
        dragDiv.setAttribute('draggable', 'true');
        dragDiv.setAttribute('ondragstart', 'handleDragType(event)');
        dragDiv.dataset.code = code;
        dragDiv.dataset.name = subtype.name;
        dragDiv.dataset.typology = typology;
        dragDiv.id = 'handle-type-' + code;
        const span = document.createElement('span');
        span.classList.add('me-2');
        span.textContent = '⠿';
        let text = null;
        if (subtype.hasOwnProperty('count')) {
            text = document.createTextNode(' ' + subtype.name + ' (' + subtype.count + ')')
        } else {
            text = document.createTextNode(' ' + subtype.name);
        }
        dragDiv.appendChild(span);
        dragDiv.appendChild(text);
        subDiv.appendChild(dragDiv);
        if (Object.keys(subtype.types).length > 0) {
            Object.entries(subtype.types).forEach(([code, type]) => {
                const divSubtype = createSubtype(typology, code, type, false);
                subDiv.appendChild(divSubtype);
            })
        }
        return subDiv;
    }

    // Crée le titre de la carte d'un type principal
    function createType (codeTypology, codeMain, type) {
        const mainDiv = document.createElement('div');
        mainDiv.classList.add('card', 'mb-2', 'handle-type');
        mainDiv.setAttribute('draggable', 'true');
        mainDiv.setAttribute('ondragstart', 'handleDragType(event)');
        mainDiv.dataset.code = codeMain;
        mainDiv.dataset.name = type.name;
        mainDiv.dataset.typology = codeTypology;
        mainDiv.id = 'handle-type-' + codeMain;
        const span = document.createElement('span');
        span.classList.add('me-2');
        span.textContent = '⠿';
        const strong = document.createElement('strong');
        if (type.hasOwnProperty('count')) {
            strong.textContent = " " + type.name + " (" + type.count + ")";
        } else {
            strong.textContent = " " + type.name;
        }
        const headerDiv = insertElement(document.createElement('div'), [span, strong]);
        headerDiv.classList.add('card-header', 'd-flex', 'align-items-center');
        mainDiv.appendChild(headerDiv);
        if (Object.keys(type.types).length > 0) {
            const bodyDiv = document.createElement('div');
            bodyDiv.classList.add('card-body', 'p-2');
            Object.entries(type.types).forEach(([code, subtype]) => {
                const divSubtype = createSubtype(codeTypology, code, subtype);
                bodyDiv.appendChild(divSubtype);
            })
            mainDiv.appendChild(bodyDiv);
        }
        return mainDiv;
    }

    // Ces deux fonctions vérifient si un type est inaccessible ou utilisé
    function isDisabled (type) {
        return disabledTypes.includes(type);
    }

    function isUsed (type) {
        return usedTypes.includes(type);
    }

    // On crée un nouveau groupe (le premier badge est ajouté à la fin)
    function createNewGroupCard (code, name, typology, dropZone, groupName = false) {
        // On cherche le nom du type (pas juste le code)
        // D'abord, on crée l'élément
        const newCard = document.createElement('div');
        newCard.classList.add('card', 'mb-2', 'mt-2', 'group-card');
        let title = "";
        if (groupName) {
            newCard.id = 'group-card-' + groupName;
            title = groupName;
        } else {
            newCard.id = 'group-card-' + code;
            title = code;
        }
        newCard.innerHTML = `
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center">
                <strong>${title}</strong>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="renameGroupCard(this)">Renommer</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteGroupCard(this)">Supprimer</button>
                </div>
                </div>
                <div class="badges-area mt-2"></div>
            </div>
            `;
        // On intègre à la liste des group-cards
        listGroupCardIds.push(newCard.id);
        // On intègre dans la dropZone, avant le placeholder et selon le nom indiqué
        let dropped = false;
        const groupCards = Array.from(dropZone.querySelectorAll(".group-card"));
        if (groupCards.length > 0) {
            for (let i = 0; i < groupCards.length; i++) {
                const otherGroupCard = groupCards[i];
                if (newCard.id < otherGroupCard.id) {
                    dropZone.insertBefore(newCard, otherGroupCard);
                    dropped = true;
                    break;
                }
            }
        }
        if (!dropped) {
            const placeholder = dropZone.querySelector(".placeholder-typologies");
            dropZone.insertBefore(newCard, placeholder);
        }
        // On y intègre le badge du type (gère aussi l'intégration comme utilisé et les désactivations)
        addTypeToGroupCard (code, name, newCard);

    }

    // On rajoute un badge à un groupe (puis déclenche la fonction addTypeToUsed)
    function addTypeToGroupCard (code, name, groupCard) {
        // On récupère la zone des badges (et return si absent)
        const area = groupCard.querySelector(".badges-area");
        if (!area) return;
        // On crée le badge
        const badge = document.createElement("span");
        badge.classList.add('badge', 'bg-secondary', 'me-1');
        badge.id = "badge-type-code-" + code;
        badge.dataset.code = code;
        badge.textContent = name;
        badge.addEventListener('click', () => {
            deleteTypeBadge(badge);
        });
        badge.style.cursor = "pointer";
        // On ajoute le badge (alphabétiquement)
        let dropped = false;
        const badges = Array.from(area.querySelectorAll(".badge"));
        if (badges.length > 0) {
            for (let i = 0; i < badges.length; i++) {
                const otherBadge = badges[i];
                if (badge.id < otherBadge.id) {
                    area.insertBefore(badge, otherBadge);
                    dropped = true;
                    break;
                }
            }
        }
        if (!dropped) {
            area.appendChild(badge);
        }
        // Ensuite, on indique le type comme utilisé (et on désactive les sur- et sous-types)
        addTypeToUsed (code);
    }

    function addTypeToUsed (code) {
        if (isDisabled(code) || isUsed(code)) return;
        const usedTypeDiv = document.getElementById('handle-type-' + code);
        let card = null;
        // Deux cas de figure : il y a "card" dans la classe ou non
        if (usedTypeDiv.classList.contains('card')) {
            card = usedTypeDiv;
            // On récupère le titre
            const cardHeader = usedTypeDiv.querySelector(':scope > .card-header');
            // On applique used
            cardHeader.classList.add('h-a-type-used');
        } else {
            // On applique used directement
            usedTypeDiv.classList.add('h-a-type-used');
            // On applique disabled à ses parents et on récupère la carte
            card = addParentToDisabled(usedTypeDiv);
        }
        // On ajoute l'élément à la liste des éléments utilisés
        usedTypes.push(code);
        let subtypes = null;
        // On récupère tous les types-enfants
        // On distingue le cas où on doit légèrement remonter (sous-type) ou non
        if (usedTypeDiv.classList.contains('card')) {
            subtypes = usedTypeDiv.querySelectorAll('.handle-type');
        } else {
            subtypes = usedTypeDiv.parentElement.querySelectorAll('.handle-type');
        }
        subtypes.forEach(sub => {
            // On les indique comme inutilisables, si ce n'est pas déjà le cas, et on les ajoute à la liste
            if (!(isDisabled(sub.dataset.code) || isUsed(sub.dataset.code))) {
                sub.classList.add('h-a-type-disabled');
                disabledTypes.push(sub.dataset.code);
            }
        });
        // A cacher si utilisé le type principal
        let toHide = true;
        if (!usedTypeDiv.classList.contains('card')) {
            // Sinon, on vérifie si tous les éléments de la carte sont disabled ou used
            const allTypes = card.querySelectorAll('.handle-type');
            allTypes.forEach(t => {
                // Si un seul n'est pas bon, on ne peut pas cacher la carte
                if (!(isDisabled(t.dataset.code) || isUsed(t.dataset.code))) {
                    toHide = false;
                }
            });
        }
        if (toHide) {
            // On cache la carte
            card.hidden = true;
        }
    }

    // Remonte la hiérarchie, rend les parents disabled, et retourne la carte
    function addParentToDisabled (div) {
        const parent = div.parentElement.parentElement;
        // On vérifie si c'est le dernier sous-type
        if (parent.classList.contains('card-body')) {
            // Ok, on est arrivé à la fin, il est temps de rendre inutilisable le header
            // On récupère le parent (la carte)
            const card = parent.parentElement;
            // On y prend le header
            const cardHeader = card.querySelector(':scope > .card-header');
            // On le rend inutilisable si pas encore fait
            if (!(isDisabled(card.dataset.code) || isUsed(card.dataset.code))) {
                cardHeader.classList.add('h-a-type-disabled');
                disabledTypes.push(card.dataset.code);
            }
            // Et enfin, on renvoie la carte
            return card;
        } else {
            // Sinon, on rend inutilisable et on continue à remonter
            // On doit récupérer l'enfant avec handle-type comme style
            const parentType = parent.querySelector(':scope > .handle-type');
            // On le désactive si pas encore fait
            if (!(isDisabled(parentType.dataset.code) || isUsed(parentType.dataset.code))) {
                parentType.classList.add('h-a-type-disabled');
                disabledTypes.push(parentType.dataset.code);
            }
            // Et on continue à remonter
            return addParentToDisabled(parentType);
        }
    }


    function removeTypeFromCard(badge) {
        // Récupère le groupe
        const group = badge.closest(".group-card");
        // On récupère le code du type
        const typeCode = badge.dataset.code;
        // On retire l'élément de la liste des éléments utilisés
        usedTypes = usedTypes.filter(t => t !== typeCode);
        // On récupère le handle du type
        const typeHandle = document.getElementById('handle-type-' + typeCode);
        let card = null;
        // Deux cas de figure : il y a "card" dans la classe ou non
        if (typeHandle.classList.contains('card')) {
            card = typeHandle;
            // On récupère le titre
            const cardHeader = typeHandle.querySelector(':scope > .card-header');
            // On retire used
            cardHeader.classList.remove('h-a-type-used');
        } else {
            // On retire used directement
            typeHandle.classList.remove('h-a-type-used');
            // On vérifie si ça doit aussi être fait pour les parents et on récupère la carte
            card = checkParentIfEnabled(typeHandle);
        }
        // Si la carte était cachée, elle réapparaît
        if (card.hidden) {
            card.hidden = false;
        }
        let subTypes = null;
        // Selon les règles, tous les enfants peuvent être à nouveau utilisé
        // On récupère tous les types-enfants
        // On distingue le cas où on doit légèrement remonter (sous-type) ou non
        if (typeHandle.classList.contains('card')) {
            subtypes = typeHandle.querySelectorAll('.handle-type');
        } else {
            subtypes = typeHandle.parentElement.querySelectorAll('.handle-type');
        }
        subtypes.forEach(sub => {
            // On les indique comme à nouveau utilisables, si ce n'est pas déjà le cas, et on les ajoute à la liste
            if (isDisabled(sub.dataset.code)) {
                sub.classList.remove('h-a-type-disabled');
                disabledTypes = disabledTypes.filter(t => t !== sub.dataset.code);
            }
        });
        // On retire le badge du DOM
        badge.remove();
        // Vérification de s'il reste encore des badges
        const remainingBadges = Array.from(group.querySelectorAll(".badges-area .badge"));
        if (remainingBadges.length === 0) {
            // On supprime la carte
            // Supprime la carte des listes de groupes
            listGroupCardIds  = listGroupCardIds.filter(id => id !== group.id);
            listConfigTypeIds = listConfigTypeIds.filter(id => id !== group.id);
            // Supprime la carte
            group.remove();
        }
    }


    function checkParentIfEnabled(typeHandle) {
        const parent = typeHandle.parentElement.parentElement;
        // On vérifie si c'est le dernier sous-type
        if (parent.classList.contains('card-body')) {
            // Ok, on est arrivé à la fin, il est temps de rendre voir si le header est utilisable ou non
            // On récupère le parent (la carte)
            const card = parent.parentElement;
            // On y prend le header
            const cardHeader = card.querySelector(':scope > .card-header');
            // On check si il y a besoin de réactiver ou non
            let toEnable = true;
            const subtypes = card.querySelectorAll('.handle-type');
            subtypes.forEach(t => {
                // Si un seul est utilisé, on ne réactive pas ; sinon, c'est bon (un de ses parents ne peut pas être utilisé en même temps qu'un enfant)
                if (isUsed(t.dataset.code)) {
                    toEnable = false;
                }
            });
            if (toEnable) {
                cardHeader.classList.remove('h-a-type-disabled');
                disabledTypes = disabledTypes.filter(t => t !== card.dataset.code);
            }
            // Et enfin, on renvoie la carte
            return card;
        } else {
            // Sinon, on voit si déjà à ce stade on peut réactiver et on continue à remonter (c'est un peu overkill de remonter mais j'ai la flemme, il est 18h39, je suis en burnout et je suis dans un train sans tablette)
            // On doit récupérer l'enfant avec handle-type comme style
            const parentType = parent.querySelector(':scope > .handle-type');
            // On check si il y a besoin de réactiver ou non
            let toEnable = true;
            const subtypes = parent.querySelectorAll('.handle-type');
            subtypes.forEach(t => {
                // Si un seul est utilisé, on ne réactive pas ; sinon, c'est bon (un de ses parents ne peut pas être utilisé en même temps qu'un enfant)
                if (isUsed(t.dataset.code)) {
                    toEnable = false;
                }
            });
            if (toEnable) {
                parentType.classList.remove('h-a-type-disabled');
                disabledTypes = disabledTypes.filter(t => t !== parentType.dataset.code);
            }
            // Et on continue à remonter
            return checkParentIfEnabled(parentType);
        }
    }


    // Mise à jour des types
    btnUpdateType.addEventListener('click', function() {
        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner-types');
        spinner.style.display = 'block';

        const mode = modeSelect.value;
        // Préparation de la liste des items à intégrer
        let listItems = [];
        if (mode === "phases") {
            // Récupération d'une liste de phases
            // On parcourt l'ensemble des phases disponibles
            listInventoryData['phases'].forEach(el => {
                // On check s'il existe une phase qui correspond dans le DOM
                const phaseDiv = document.getElementById('selected-items-phase-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.code);
                if (phaseDiv) {
                    listItems.push({ site: el.site, code: el.code });
                }
            })
        } else if (mode === "contexts") {
            // Récupération d'une liste de contextes
            // On parcourt l'ensemble des contextes disponibles
            listInventoryData['contexts'].forEach(el => {
                // On check s'il existe un contexte qui correspond dans le DOM
                const contextDiv = document.getElementById('selected-items-context-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.phase + '-' + el.code);
                if (contextDiv) {
                    listItems.push({ site: el.site, code: el.code });
                }
            })
        }
        // Construction de l'objet à envoyer
        const payload = {
            function: "update_types_showed",
            mode: mode,
            listItems: listItems,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }
                // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Cache le spinner
            spinner.style.display = 'none';
            // On stocke le résultat
            typeList = data.typeList;
            // On enlève ce qui existait
            displayTypologies.innerHTML = "";
            configTypesSelect.value = "";
            disabledTypes = [];
            usedTypes = [];
            listGroupCardIds = [];
            listConfigTypeIds = [];
            // Création du DOM
            Object.entries(typeList).forEach(([code, typology]) => {
                // On crée l'accordéon de typologie
                const divTypology = createTypology(code, typology.name);
                orderedInsertion(displayTypologies, divTypology);
                // On crée les objets à l'intérieur
                Object.entries(typology.types).forEach(([codeType, type]) => {
                    const divType = createType(code, codeType, type);
                    divAvailableTypes = document.getElementById('available-types-for-' + code);
                    orderedInsertion(divAvailableTypes, divType);
                });
                
            });
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            //document.getElementById('graphic-result').innerHTML = "<p class='text-danger'>Erreur lors de l'analyse.</p>";
        });
    })

    // Stocke les données nécessaires pour un drag and drop de type
    function handleDragType (event) {
        // Récupère les codes de type et typologie + nom de type
        const code     = event.target.dataset.code;
        const name     = event.target.dataset.name;
        const typology = event.target.dataset.typology;
        // Vérification que ces éléments sont bien présents
        if (!code || !name || !typology) return;
        // Vérifie que ces éléments ne sont pas dans la liste des éléments utilisés ou inaccessibles
        if (isDisabled (code) || isUsed (code)) {
            event.preventDefault();
            return;
        }
        // Les intègre dans les données du drag and drop
        event.dataTransfer.setData('code', code);
        event.dataTransfer.setData('name', name);
        event.dataTransfer.setData('typology', typology);
    }

    // Pilote les changements nécessaires au drop
    function handleDropType (event) {
        event.preventDefault();
        // Récupère les données stockées
        const code     = event.dataTransfer.getData('code');
        const name     = event.dataTransfer.getData('name');
        const typology = event.dataTransfer.getData('typology');
        // Récupère la typologie de la drop zone
        const dropZoneTypology = event.currentTarget.dataset.typology;
        // Vérifie si les données sont bien stockées et si la typologie correspond à la drop zone
        if (!code || !name || !typology || dropZoneTypology !== typology) return;

        // On vérifie à nouveau que ces éléments ne sont pas dans la liste des éléments utilisés ou inaccessibles
        if (isDisabled(code) || isUsed(code)) return;

        // Vérifie si c'est intégré dans un groupe existant ou non
        const groupCard = event.target.closest(".group-card");
        // Selon le cas, ajoute le type ou crée un nouveau groupe (et gère tous les besoins successifs pour le dropping)
        if (groupCard) {
            addTypeToGroupCard(code, name, groupCard);
        } else {
            createNewGroupCard(code, name, typology, event.currentTarget);
        }
    }

    // Si on renomme un groupe de carte, vérifie si le nom est disponible, le change, change l'ID et replace le groupe
    function renameGroupCard (btn) {
        // On récupère les variables
        const card = btn.closest(".group-card");
        const title = card.querySelector("strong");
        // On crée le prompt pour indiquer un nouveau nom
        const newName = prompt("Nouveau nom du groupement :", title.textContent);
        if (newName) {
            // Vérifie la taille
            if (newName.length > 128) {
                alert("Le nom ne peut pas faire plus de 128 caractères.");
                return; // on arrête la fonction
            }
            // Vérifie si le nom existe déjà dans l'une des listes
            if (listGroupCardIds.includes('group-card-' + newName) || listConfigTypeIds.includes('group-card-' + newName)) {
                alert("Ce nom est déjà utilisé. Veuillez en choisir un autre.");
                return; // on arrête la fonction
            }
            // Si changement : changement du texte, mais aussi de l'ID
            title.textContent = newName;
            listGroupCardIds  = listGroupCardIds.filter(id => id !== card.id);
            listConfigTypeIds = listConfigTypeIds.filter(id => id !== card.id);
            card.id = 'group-card-' + newName;
            listGroupCardIds.push(card.id);
            if (configTypesSelect.value !== "") {
                listConfigTypeIds.push(card.id);
            }

            // Réinsertion au bon endroit
            const dropZone = card.parentElement;
            const groupCards = Array.from(dropZone.querySelectorAll(".group-card"))
                .filter(c => c !== card); // toutes sauf celle qu'on déplace

            let placed = false;
            for (let i = 0; i < groupCards.length; i++) {
                const other = groupCards[i];
                if (card.id < other.id) {
                    dropZone.insertBefore(card, other);
                    placed = true;
                    break;
                }
            }

            if (!placed) {
                const placeholder = dropZone.querySelector(".placeholder-typologies");
                dropZone.insertBefore(card, placeholder);
            }
        }
    }

    // Supprime le groupe
    function deleteGroupCard (btn, isCard = false) {
        let card = null;
        // Récupère la carte
        if (isCard) {
            card = btn;
        } else {
            card = btn.closest(".group-card");
        }
        // Supprime tous les badges de type
        const badges = card.querySelectorAll(".badges-area .badge");
        badges.forEach(b => {
            removeTypeFromCard(b);
        });
    }

    // Supprime un seul badge
    function deleteTypeBadge (btn) {
        // Supprime le badge
        removeTypeFromCard(btn);
    }

    // Gère le changement de configuration
    configTypesSelect.addEventListener('change', function() {
        if (this.value) {
            // Si config existante, on reset les groups, puis on va chercher les données de la config, et enfin on fait les ajouts
            // D'abord, on récupère le spinner
            const spinner = document.getElementById('loading-spinner-types');
            spinner.style.display = 'block';
            // Ensuite, on annule tous les groupements existants
            document.querySelectorAll(".group-card").forEach(deleteGroup => {
                deleteGroupCard(deleteGroup);
            })

            // Construction de l'objet à envoyer
            const payload = {
                function: "load_config_seriation",
                type: "types",
                configId: this.value,
                project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
            }
                    // Envoi (et réception) AJAX
            fetch("/static/ajax/horizons_advanced.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                // Cache le spinner
                spinner.style.display = 'none';
                if (!data.error) {
                    // On crée une liste de types présents
                    let availableTypes = [];
                    document.querySelectorAll('.handle-type').forEach(handle => {
                        availableTypes.push(handle.dataset.code);
                    })
                    data.listGroups.forEach(g => {
                        // Attention : on ne doit pas créer de groupCard s'il n'y a pas de type
                        let groupIsCreated = false;
                        g.types.forEach(t => {
                            // On check si le type est dans la liste des types présents
                            if (availableTypes.includes(t.code)) {
                                if (!groupIsCreated) {
                                    // On récupère la dropzone
                                    const dropZone = document.getElementById('used-types-for-' + g.typology);
                                    // On crée le groupe si besoin
                                    createNewGroupCard(t.code, t.name, g.typology, dropZone, g.name);
                                    groupIsCreated = true;
                                } else {
                                    // Sinon, on ajoute le type au groupCard
                                    const groupCard = document.getElementById('group-card-' + g.name);
                                    addTypeToGroupCard(t.code, t.name, groupCard);
                                }
                            }
                        });
                    });
                }
            })
            .catch(error => {
                // Cache le spinner
                spinner.style.display = 'none';
                // Affiche l'erreur
                console.error("Erreur AJAX:", error);
                //document.getElementById('graphic-result').innerHTML = "<p class='text-danger'>Erreur lors de l'analyse.</p>";
            });
        }
    });

    /* Partie création-gestion des modals. Éléments présents :
    * Fonctions utilitaires :
    *  createContentModalConfig : permet de créer la partie "contenu" d'un modal de gestion de configuration
    *  createButtonsModalConfig : permet de créer la partie "boutons" d'un modal de gestion de configuration
    *  createContentModalColor : permet de créer la partie "contenu" d'un modal de couleurs
    *  createButtonsModalColor : permet de créer la partie "boutons" d'un modal de couleurs
    *  saveConfig : permet sauvegarde de la nouvelle configuration
    *  deleteConfig : permet suppression de la configuration actuelle
    *  changeColor : permet le changement de couleur après validation
    * Déclenchements par boutons :
    *  manage-config-inventory : ouverture modal de configuration phases-contextes
    *  createColorModal : ouverture modal de changement de couleur
    */

    // Fonctions utilitaires pour modal
    // Création du contenu du modal pour une configuration
    function createContentModalConfig(configId) {
        // Si existant
        if (configId > 0) {
            // Add name
            const divName = addToDiv(`<label for="config-name" class="form-label">Nom</label>
                <input type="text" id="config-name" class="form-control" value="${configInformation[configId].name}">`, 1);
            // Add owner
            const divOwner = addToDiv(`<?php echo ucfirst(thesaurus('managed by')); ?> <b>${configInformation[configId].owner}</b>.`);
            // Add contributors
            const divContrib = showContribs(configInformation[configId].contributors, 'config_horizon', configId, configInformation[configId].is_owner);
            // Création d'un spinner caché
            const spinner = loadingSpinner('loading-spinner-modal');
            // Retour
            return [divName, divOwner, divContrib, spinner];
        }
        // Si pas existant
        // Add name
        const divName = addToDiv(`<label for="config-name" class="form-label">Nom</label>
            <input type="text" id="config-name" class="form-control" value="Nouvelle configuration">`, 1);
        // Add owner
        const divOwner = addToDiv(`<?php echo ucfirst(thesaurus('managed by')); ?> <b><?php echo $_SESSION['user']->codename(); ?></b>.`);
        // Add contributors
        const divContrib = addToDiv("Vous devez d'abord créer la configuration avant d'ajouter des contributeurs.");
        // Création d'un spinner caché
        const spinner = loadingSpinner('loading-spinner-modal');
        // Retour
        return [divName, divOwner, divContrib, spinner];
    }

    // Création de la partie "boutons" d'un modal lié à une configuration
    function createButtonsModalConfig(configId, mode) {
        let deleteBtn = null;
        if (!(configId === 0)) {
            deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.classList.add('btn', 'btn-danger');
            deleteBtn.textContent = ucfirst(thesaurus('delete'));
            deleteBtn.addEventListener('click', () => {
                deleteConfig(configId, mode);
            });
        }
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.classList.add('btn', 'btn-secondary');
        closeBtn.setAttribute('data-bs-dismiss', 'modal');
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.textContent = ucfirst(thesaurus('close'));
        const saveBtn = document.createElement('button');
        saveBtn.type = 'button';
        if (configId === 0) {
            saveBtn.classList.add('btn', 'btn-success');
            saveBtn.textContent = ucfirst(thesaurus('create'));
        } else {
            saveBtn.classList.add('btn', 'btn-primary');
            saveBtn.textContent = ucfirst(thesaurus('modify'));
        }
        saveBtn.addEventListener('click', () => {
            saveConfig(configId, mode);
        });
        if (mode === 'types' && configId !== 0) {
            const saveBtn2 = document.createElement('button');
            saveBtn2.type = 'button';
            saveBtn2.classList.add('btn', 'btn-primary');
            saveBtn2.textContent = ucfirst(thesaurus('modify_locally'));
            saveBtn2.addEventListener('click', () => {
                saveConfig(configId, mode, false);
            });
            const icon = document.createElement('i');
            icon.classList.add('bi', 'bi-info-circle');
            const abbr = document.createElement('abbr');
            abbr.title = thesaurus("explain_modify_seriation");
            abbr.appendChild(icon);
            return [deleteBtn, closeBtn, saveBtn, saveBtn2, abbr];
        } else {
            return [deleteBtn, closeBtn, saveBtn];
        }
    }

    // Création du contenu du modal pour un choix de couleur
    function createContentModalColor (checked) {
        const title = document.createElement('h5');
        title.textContent = ucfirst(thesaurus('choose_color'));
        const divColor = document.createElement('div');
        divColor.classList.add('d-flex', 'flex-wrap', 'color-modal-div-color');
        Object.entries(colors).forEach(([index, color]) => {
            const input = document.createElement('input');
            input.type = 'radio';
            input.classList.add('btn-check');
            input.name = 'modal-choice-color';
            input.id = 'modal-color-' + index;
            input.value = parseInt(index);
            if (checked === index) {
                input.checked = true;
            }
            const label = document.createElement('label');
            label.classList.add('btn', 'me-1', 'mb-1');
            label.setAttribute('for', 'modal-color-' + index);
            label.style.backgroundColor = color.rgb;
            label.style.width = '30px';
            label.style.height = '30px';
            label.style.border = '2px solid #xxx';
            divColor.append(input, label);
        });
        return [title, divColor];
    }

    function createButtonsModalColor (itemId) {
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.classList.add('btn', 'btn-secondary');
        closeBtn.setAttribute('data-bs-dismiss', 'modal');
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.textContent = ucfirst(thesaurus('cancel'));
        const saveBtn = document.createElement('button');
        saveBtn.type = 'button';
        saveBtn.classList.add('btn', 'btn-primary');
        saveBtn.textContent = ucfirst(thesaurus('validate'));
        saveBtn.addEventListener('click', () => {
            changeColor(itemId);
        });
        return [closeBtn, saveBtn];
    }

    // Fonction appelée pour sauvegarder une configuration (nouvelle ou non)
    function saveConfig (configId, mode, full = true) {
        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner-modal');
        spinner.style.display = 'block';

        // Récupération nom de la configuration
        const nameConfig = document.getElementById('config-name').value;
        // Préparation de la liste des items à intégrer
        let listItems = [];
        if (mode === "phases") {
            // Récupération d'une liste de phases et couleurs
            // On parcourt l'ensemble des phases disponibles
            listInventoryData['phases'].forEach(el => {
                // On check s'il existe une phase qui correspond dans le DOM
                const phaseDiv = document.getElementById('selected-items-phase-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.code);
                if (phaseDiv) {
                    let phaseColor = phaseDiv.dataset.color;
                    if (phaseColor === undefined) {
                        phaseColor = phaseDiv.style.backgroundColor;
                    }
                    listItems.push({ site: el.site, code: el.code, color: phaseColor });
                }
            })
        } else if (mode === "contexts") {
            // Récupération d'une liste de contextes et couleurs
            // On parcourt l'ensemble des contextes disponibles
            listInventoryData['contexts'].forEach(el => {
                // On check s'il existe un contexte qui correspond dans le DOM
                const contextDiv = document.getElementById('selected-items-context-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.phase + '-' + el.code);
                if (contextDiv) {
                    let contextColor = contextDiv.dataset.color;
                    if (contextColor === undefined) {
                        contextColor = contextDiv.style.backgroundColor;
                    }
                    listItems.push({ site: el.site, code: el.code, color: contextColor });
                }
            })
        } else if (mode === "types") {
            let usedTypesByGroup = {};
            let nonUsedTypes = [];
            // Récupération de la liste des types en présence
            document.querySelectorAll('.handle-type').forEach(handle => {
                const code = handle.dataset.code;
                // On vérifie s'il y a un badge
                const badge = document.getElementById('badge-type-code-' + code);
                if (badge) {
                    // On récupère le groupCard
                    const groupCard = badge.closest(".group-card");
                    const groupName = groupCard.id.replace("group-card-", "");
                    // On checke si déjà présent
                    if (usedTypesByGroup[groupName]) {
                        // Si oui, on ajoute le code
                        usedTypesByGroup[groupName].push(code);
                    } else {
                        // Si non, on le crée avec le code
                        usedTypesByGroup[groupName] = [code];
                    }
                } else {
                    // On ajoute aux types non utilisés
                    nonUsedTypes.push(code);
                }
            });
            listItems = {
                used: usedTypesByGroup,
                nonUsed: nonUsedTypes,
            };
        }
        // Construction de l'objet à envoyer
        const payload = {
            function: "save_config_seriation",
            mode: mode,
            full: full,
            configName: nameConfig,
            configId: configId,
            listItems: listItems,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }
                // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Cache le spinner
            spinner.style.display = 'none';
            // On récupère le bon select
            let selectConfig = null;
            if (mode === "phases" || mode === "contexts") {
                selectConfig = document.getElementById('config-inventory-select');
            } else if (mode === "types") {
                selectConfig = document.getElementById('config-types-select');
            }
            // Vérification de si nouveau ou non
            if (configId === 0) {
                // On crée une nouvelle option dans le select correspondant
                const newConfig = document.createElement('option');
                newConfig.value = data.id;
                newConfig.textContent = data.name;
                selectConfig.appendChild(newConfig);
                selectConfig.value = data.id;
                configInformation[data.id] = {
                    type: mode,
                    name: data.name,
                    owner: <?php echo json_encode($_SESSION['user']->codename()); ?>,
                    is_owner: 1,
                    contributors: []
                }
            } else {
                // Seulement le nom à changer
                Array.from(selectConfig.options)
                    .find(opt => opt.value == data.id)
                    .textContent = data.name;                
            }
            // Fermeture du modal
            if (mode === "phases" || mode === "contexts") {
                closeModal('config-inventory-modal');
            } else if (mode === "types") {
                closeModal('config-types-modal');
            }
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            //document.getElementById('graphic-result').innerHTML = "<p class='text-danger'>Erreur lors de l'analyse.</p>";
        });
    }

    // Fonction appelée pour supprimer une configuration (nouvelle ou non)
    function deleteConfig (configId, mode) {
        // Construction de l'objet à envoyer
        const payload = {
            function: "delete_config_seriation",
            configId: configId,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }
                // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // On récupère le bon select
            let selectConfig = null;
            console.log("Mode : " + mode);
            if (mode === "phases" || mode === "contexts") {
                selectConfig = document.getElementById('config-inventory-select');
                console.log(selectConfig);
            } else if (mode === "types") {
                selectConfig = document.getElementById('config-types-select');
            }
            console.log(selectConfig);
            // On supprime
            Array.from(selectConfig.options)
                .find(opt =>opt.value == configId)
                .remove();
            selectConfig.value = "";
            // Fermeture du modal
            if (mode === "phases" || mode === "contexts") {
                closeModal('config-inventory-modal');
            } else if (mode === "types") {
                closeModal('config-types-modal');
            }
        })
        .catch(error => {
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            //document.getElementById('graphic-result').innerHTML = "<p class='text-danger'>Erreur lors de l'analyse.</p>";
        });
    }

    // Fonction appelée pour changer la couleur d'éléments (facies à contexte)
    function changeColor (itemId) {
        // Récupère l'élément
        const element = document.getElementById(itemId);
        // Récupère la valeur de la couleur
        const selected = document.querySelector('input[name="modal-choice-color"]:checked');
        if (selected) {
            const newColorIndex = selected.value;
            // Change la valeur de l'élément
            element.dataset.color = newColorIndex;
            // Change le background-color de l'élément, si pertinent
            if (element.style.backgroundColor) {
                element.style.backgroundColor = colors[newColorIndex].rgb;
            }
            // Parcourt tous les descendants
            element.querySelectorAll("*").forEach(el => {
                // Vérifie si dataset.color existe
                if (el.dataset.color !== undefined) {
                    // Met à jour dataset.color
                    el.dataset.color = newColorIndex;
                }
                // Met à jour background-color si défini inline
                if (el.style.backgroundColor) {
                    el.style.backgroundColor = colors[newColorIndex].rgb;
                }
            });
        }
        // Ferme le modal
        closeModal('color-modal');
    }

    // Création et ouverture du modal de configuration des phases et contextes
    document.getElementById('manage-config-inventory').addEventListener('click', () => {
        let configId = 0
        if (document.getElementById('config-inventory-select').value !== '') {
            configId = parseInt(document.getElementById('config-inventory-select').value);
        }
        // Creation ID and header
        const mode = document.getElementById('mode-select').options[document.getElementById('mode-select').selectedIndex].text;
        const modeValue = document.getElementById('mode-select').options[document.getElementById('mode-select').selectedIndex].value;
        const id = 'config-inventory-modal';
        const header = ucfirst(thesaurus('config_management')) + ucfirst(thesaurus(':')) + " " + mode;
        // Création du contenu (appel à une fonction)
        const content = createContentModalConfig(configId);
        const buttons = createButtonsModalConfig(configId, modeValue);
        const modal = createModal(id, header, content, buttons);
        addModal(modal);
    });

    // Création et ouverture du modal de configuration des horizons
    document.getElementById('manage-config-types').addEventListener('click', () => {
        let configId = 0
        if (document.getElementById('config-types-select').value !== '') {
            configId = parseInt(document.getElementById('config-types-select').value);
        }
        // Creation ID and header
        const id = 'config-types-modal';
        const header = ucfirst(thesaurus('config_management')) + ucfirst(thesaurus(':')) + " " + ucfirst(thesaurus('types'));
        // Création du contenu (appel à une fonction)
        const content = createContentModalConfig(configId);
        const buttons = createButtonsModalConfig(configId, 'types');
        const modal = createModal(id, header, content, buttons);
        addModal(modal);
    });

    // Création et ouverture du modal de gestion des couleurs pour un facies/horizon/phase/contexte
    function createColorModal (itemId, itemName) {
        const element = document.getElementById(itemId);
        const id = 'color-modal';
        const header = itemName;
        const content = createContentModalColor(element.dataset.color);
        const buttons = createButtonsModalColor(itemId);
        const modal = createModal(id, header, content, buttons);
        addModal(modal);
    }

    /* Gestion des méthodes de comptage : une seule fonction
    */
   // Si méthode de comptage = B-F-A-P : il faut choisir ce qui est pris en compte
    document.getElementById('counting-select').addEventListener('change', function() {
        // On check si a la valeur 1
        const zone = document.getElementById('counting-special-zone');
        if (parseInt(this.value) === 1) {
            zone.innerHTML = ''; // D'abord, on supprime tout ce qu'il y a dedans
            const list = document.createElement('div');
            const partsVase = new Map([
                ['n_rim',    ucfirst(thesaurus('n_rim'))   ],
                ['n_bottom', ucfirst(thesaurus('n_bottom'))],
                ['n_handle', ucfirst(thesaurus('n_handle'))],
                ['n_wall',   ucfirst(thesaurus('n_wall'))  ],
            ]);
            partsVase.forEach((label, part) => {
                const item = document.createElement('div');
                item.classList.add('mb-2');
                // Création de la checkbox
                item.innerHTML = `
                    <input class="btn-check" type="checkbox"
                        name="counting_parts[]" value="${part}" id="count-${part}" checked autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm" for="count-${part}">
                        ${label}
                    </label>
                `;
                list.appendChild(item)
            });
            zone.appendChild(list);
        } else {
            zone.innerHTML = '';
        }
    });

    /* Partie création-gestion des résultats. Éléments présents :
    * Fonctions utilitaires :
    *  svg_container : balise svg
    *  svg_layer : balise g (group)
    *  svg_dot : balise circle
    *  svg_text : balise text
    *  svg_line : balise line
    *  svg_move : déplace un élément défini par une coordonnée
    * Déclenchements par boutons :
    *  btn-analyse : crée le tableau sérié
    *  btn-seriation-reverse : inverse la sériation
    *  btn-fa-calculation : crée les données de l'AFC et génère un premier affichage
    */

    function adapt_color(color) {
        let finalColor = false;
        if (color) {
            if (Number.isInteger(color)) {
                finalColor = colors[color].rgb;
            } else if (color[0] === "#") {
                finalColor = color;
            } else {
                finalColor = colors[parseInt(color)].rgb;
            }
        }
        return finalColor;
    }

    const SVG_NS = 'http://www.w3.org/2000/svg';

    // Création de la balise svg générale
    function svg_container (x, y, id = false, content = false) {
        const svg = document.createElementNS(SVG_NS, 'svg');
        svg.setAttribute("width", x);
        svg.setAttribute("height", y);
        if (id) svg.setAttribute("id", id);
        if (content) {
            return insertElement(svg, content);
        } else {
            return svg;
        }
    }

    // Création d'un groupe g (calque)
    function svg_layer (id, content = false) {
        const group = document.createElementNS(SVG_NS, 'g');
        group.setAttribute("id", id);
        if (content) {
            return insertElement(group, content);
        } else {
            return group;
        }
    }

    // Création d'un point, via un circle
    function svg_dot (x, y, color, id = false, radius = 5) {
        const dot = document.createElementNS(SVG_NS, 'circle');
        dot.setAttribute("cx", x);
        dot.setAttribute("cy", y);
        dot.setAttribute("fill", adapt_color(color));
        if (id) dot.setAttribute("id", id);
        dot.setAttribute("r", radius);
        return dot;
    }

    // Création d'un texte
    function svg_text (x, y, text, size = 12, anchor = false, id = false) {
        const textEl = document.createElementNS(SVG_NS, 'text');
        textEl.setAttribute("x", x);
        textEl.setAttribute("y", y);
        textEl.setAttribute("font-size", size);
        if (anchor) textEl.setAttribute("text-anchor", anchor);
        if (id)     textEl.setAttribute("id", id);
        textEl.textContent = text;
        return textEl;
    }

    // Création d'une ligne
    function svg_line (x1, y1, size_x = 0, size_y = 0, id = false, color = false, dash = false) {
        const line = document.createElementNS(SVG_NS, 'line');
        line.setAttribute("x1", x1);
        line.setAttribute("y1", y1);
        // On considère que la référence est le coin inférieur gauche
        line.setAttribute("x2", x1 + size_x);
        line.setAttribute("y2", y1 - size_y);
        if (id)    line.setAttribute("id", id);
        if (color) {
            line.setAttribute("stroke", adapt_color(color));
        } else {
            line.setAttribute("stroke", 'black');
        }
        if (dash)  line.setAttribute("stroke-dasharray", dash);
        return line;
    }

    // Déplacement d'un élément à une coordonnée précise en fonction de son id
    function svg_move (id, x, y, type = false) {
        const element = document.getElementById(id);
        if (element) {
            if (type === 'circle') {
                element.setAttribute("cx", x);
                element.setAttribute("cy", y);
            } else {
                element.setAttribute("x", x);
                element.setAttribute("y", y);
            }
            return true;
        }
        return false;
    }

    // Création d'un graphique d'analyse des correspondances
    function createCAGraphic (xAxe, yAxe, mapType, width, height, fontItem = 10, fontType = 8, dotItem = 5, dotType = 4, interactive = false) {
        marginX = 60;
        marginY = 40;
        // Calcul des résolutions (différence de coordonnée par pixel)
        const xRes = (width - (marginX * 2)) / (limitsCoordCA['axe' + xAxe][mapType]['max'] - limitsCoordCA['axe' + xAxe][mapType]['min']);
        const yRes = (height - (marginY * 2)) / (limitsCoordCA['axe' + yAxe][mapType]['max'] - limitsCoordCA['axe' + yAxe][mapType]['min']);
        // Calcul des coordonnées du point 0, 0
        const xZero = ((0 - limitsCoordCA['axe' + xAxe][mapType]['min']) * xRes) + marginX;
        const yZero = (limitsCoordCA['axe' + yAxe][mapType]['max'] * yRes) + marginY;

        // On rajoute les lignes
        let coordLines = [];
        // Lignes de base
        coordLines.push(svg_line(0, yZero, width, 0));
        coordLines.push(svg_line(xZero, 0, 0, 0 - height));
        // Calcul des graduations optimales (on en veut 4 à 7)
            const availableGraduations = [0.10, 0.20, 0.40, 0.50, 1.0, 2.0];
            const amplX = limitsCoordCA['axe' + xAxe][mapType]['max'] - limitsCoordCA['axe' + xAxe][mapType]['min'];
            const amplY = limitsCoordCA['axe' + yAxe][mapType]['max'] - limitsCoordCA['axe' + yAxe][mapType]['min'];
            let gradX = 0.0;
            let gradY = 0.0;
            for (i = 5; i >= 0; i--) {
                const tested = availableGraduations[i]
                // Si l'amplitude est plus grande que 6 fois la valeur testée, on a notre graduation
                if (amplX > 6 * tested && gradX === 0.0) {
                    gradX = tested;
                }
                if (amplY > 6 * tested && gradY === 0.0) {
                    gradY = tested;
                }
            }
            // Valeurs minimales si nécessaire
            if (gradX === 0.0) gradX = 0.10;
            if (gradY === 0.0) gradY = 0.10;
        // Calcul de la première et dernière graduation (en numéro de graduation)
            const minGradX = Math.trunc(limitsCoordCA['axe' + xAxe][mapType]['min'] / gradX);
            const minGradY = Math.trunc(limitsCoordCA['axe' + yAxe][mapType]['min'] / gradY);
            const maxGradX = Math.trunc(limitsCoordCA['axe' + xAxe][mapType]['max'] / gradX);
            const maxGradY = Math.trunc(limitsCoordCA['axe' + yAxe][mapType]['max'] / gradY);
        // Établissement des graduations
            for (i = minGradX; i <= maxGradX; i++) {
                // Pas de graduation pour le 0
                if (i !== 0) {
                    // Calcul de la base de la graduation
                    const baseGradX = (gradX * i * xRes) + xZero;
                    // Création de la ligne
                    const lineGradX = svg_line(baseGradX, yZero, 0, -5);
                    // Création du texte
                    const gradText = gradX * i;
                    const textGradX = svg_text(baseGradX, yZero + 15, gradText.toFixed(1), 12, 'middle');
                    // On les ajoute au calque
                    coordLines.push(lineGradX);
                    coordLines.push(textGradX);
                }
            }
            for (i = minGradY; i <= maxGradY; i++) {
                // Pas de graduation pour le 0
                if (i !== 0) {
                    // Calcul de la base de la graduation
                    const baseGradY = yZero - (gradY * i * yRes);
                    // Création de la ligne
                    const lineGradY = svg_line(xZero, baseGradY, -5, 0);
                    // Création du texte
                    const gradText = gradY * i;
                    const textGradY = svg_text(xZero - 8, baseGradY + 6, gradText.toFixed(1), 12, 'end');
                    // On les ajoute au calque
                    coordLines.push(lineGradY);
                    coordLines.push(textGradY);
                }
            }

            
        // On rajoute les graduations
        // TODO
        // On intègre tout cela à un calque
        const groupCoords = svg_layer('ca-basis', coordLines);

        // Création des points des items (et des labels)
        let listDotsLabels = [];
        let listDots = [];
        Object.entries(tableResultsCA).forEach(([key, el]) => {
            const rawX  = el[mapType]['axe' + xAxe];
            const trueX = xZero + (rawX * xRes);
            const rawY  = el[mapType]['axe' + yAxe];
            const trueY = yZero - (rawY * yRes);
            const dot = svg_dot(trueX, trueY, el['color'], 'dot-item-' + el['site'] + '-' + el['code'], dotItem);
            const dotLabel = svg_text(Number(trueX) + Number(dotItem), trueY - dotItem, el['code'], fontItem, false, 'dot-item-label-' + el['site'] + '-' + el['code']);
            listDots.push(dot);
            listDotsLabels.push(dotLabel);
        });
        const groupDotsItems = svg_layer('ca-layer-items', listDots);
        const groupDotsItemsLabel = svg_layer('ca-layer-items-label', listDotsLabels);
        
        // Création des points des types (+ labels)
        listDotsLabels = [];
        listDots = [];
        Object.entries(typeGroupsInfoCA).forEach(([type, el]) => {
            const rawX  = el[mapType]['axe' + xAxe];
            const trueX = xZero + (rawX * xRes);
            const rawY  = el[mapType]['axe' + yAxe];
            const trueY = yZero - (rawY * yRes);
            const dot = svg_dot(trueX, trueY, "#a6b9e5ff", 'dot-type-' + type, dotType);
            const dotLabel = svg_text(Number(trueX) + Number(dotType), trueY - dotType, type, fontType, false, 'dot-type-label-' + type);
            listDots.push(dot);
            listDotsLabels.push(dotLabel);
        });
        const groupDotsTypes = svg_layer('ca-layer-types', listDots);
        const groupDotsTypesLabel = svg_layer('ca-layer-types-label', listDotsLabels);

        // Création du svg
        const svg = svg_container(width, height, 'ca-svg', [groupCoords, groupDotsTypes, groupDotsTypesLabel, groupDotsItems, groupDotsItemsLabel]);
        const graphicContainer = document.getElementById('graphic-result');
        graphicContainer.innerHTML = "";
        graphicContainer.appendChild(svg);

        // Vérification des calques
        const switchBasis = document.getElementById('ca-switch-basis');
        if (switchBasis) {
            if (!(switchBasis.checked)) document.getElementById('ca-basis').style.display = 'none';
        }
        const switchLayerItems = document.getElementById('ca-switch-layer-items');
        if (switchLayerItems) {
            if (!(switchLayerItems.checked)) document.getElementById('ca-layer-items').style.display = 'none';
        }
        const switchLayerItemsLabel = document.getElementById('ca-switch-layer-items-label');
        if (switchLayerItemsLabel) {
            if (!(switchLayerItemsLabel.checked)) document.getElementById('ca-layer-items-label').style.display = 'none';
        }
        const switchLayerTypes = document.getElementById('ca-switch-layer-types');
        if (switchLayerTypes) {
            if (!(switchLayerTypes.checked)) document.getElementById('ca-layer-types').style.display = 'none';
        }
        const switchLayerTypesLabel = document.getElementById('ca-switch-layer-types-label');
        if (switchLayerTypesLabel) {
            if (!(switchLayerTypesLabel.checked)) document.getElementById('ca-layer-types-label').style.display = 'none';
        }

    }

    // Fonction envoi des données configurées et récupère les données structurées + un tableau sérié par barycentres
    document.getElementById('btn-analyse').addEventListener('click', function() {
        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block';

        // Récupération des paramètres sélectionnés
        
        // 1. Données des phases et contextes
        // Préparation de la liste des items à intégrer
        let listItems = [];
        const mode = document.getElementById('mode-select').options[document.getElementById('mode-select').selectedIndex].value;
        if (mode === "phases") {
            // Récupération d'une liste de phases et couleurs
            // On parcourt l'ensemble des phases disponibles
            listInventoryData['phases'].forEach(el => {
                // On check s'il existe une phase qui correspond dans le DOM
                const phaseDiv = document.getElementById('selected-items-phase-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.code);
                if (phaseDiv) {
                    let phaseColor = phaseDiv.dataset.color;
                    if (phaseColor === undefined) {
                        phaseColor = phaseDiv.style.backgroundColor;
                    }
                    listItems.push({ site: el.site, code: el.code, color: phaseColor });
                }
            })
        } else if (mode === "contexts") {
            // Récupération d'une liste de contextes et couleurs
            // On parcourt l'ensemble des contextes disponibles
            listInventoryData['contexts'].forEach(el => {
                // On check s'il existe un contexte qui correspond dans le DOM
                const contextDiv = document.getElementById('selected-items-context-' + el.facies + '-' + el.horizon + '-' + el.site + '-' + el.phase + '-' + el.code);
                if (contextDiv) {
                    let contextColor = contextDiv.dataset.color;
                    if (contextColor === undefined) {
                        contextColor = contextDiv.style.backgroundColor;
                    }
                    listItems.push({ site: el.site, code: el.code, color: contextColor });
                }
            });
        }

        // 2. Données des types
        let usedTypesWithGroup = {};
        let groups = [];
        // Récupération de la liste des types en présence
        document.querySelectorAll('.handle-type').forEach(handle => {
            const code = handle.dataset.code;
            // On vérifie s'il y a un badge
            const badge = document.getElementById('badge-type-code-' + code);
            if (badge) {
                // On récupère le groupCard
                const groupCard = badge.closest(".group-card");
                const groupName = groupCard.id.replace("group-card-", "");
                // Si pas encore présent, on ajoute à la liste des groupes
                if (!groups.includes(groupName)) {
                    groups.push(groupName);
                }
                // On crée une clé type avec la valeur du groupe
                usedTypesWithGroup[code] = groupName;
            }
        });

        // 3. Méthode de comptage
        const countingMethod = document.getElementById('counting-select').value;
        const countingParts = Array.from(document.querySelectorAll("input[name='counting_parts[]']:checked"))
            .map(el => el.value);

        // Construction de l'objet à envoyer
        const payload = {
            function: "make_seriation",
            mode: mode,
            listItems: listItems,
            groups: groups,
            usedTypesWithGroup: usedTypesWithGroup,
            countingMethod: countingMethod,
            countingParts: countingParts,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }

        // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Sauvegarde de la table de résultat et des informations de groupes
            tableResults = data.tableResults;
            typeGroupsInfo = data.groupsInfo;
            // Injection du résultat
            const graphicContainer = document.getElementById('graphic-zone');
            graphicContainer.innerHTML = data.graphic || '';
            document.getElementById('table-result').innerHTML = data.tableHTML || '';

            // On montre les boutons avancés
            document.getElementById('buttons-results').hidden = false;
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            document.getElementById('graphic-zone').innerHTML = "<p class='text-danger'>" + ucfirst(thesaurus('analyze_error')) + ".</p>";
        });
    });

    // Fonction pour inverser la sériation par barycentres
    document.getElementById('btn-seriation-reverse').addEventListener('click', function() {
        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block';

        // Récupération des paramètres sélectionnés
        const mode = document.getElementById('mode-select').options[document.getElementById('mode-select').selectedIndex].value;

        // Construction de l'objet à envoyer
        const payload = {
            function: "seriation_reverse",
            mode: mode,
            tableItems: tableResults,
            groupsInfo: typeGroupsInfo,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }

        // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Intégration de la table de résultats au bon endroit
            tableResults = data.tableResults;
            typeGroupsInfo = data.groupsInfo;
            // Injection du résultat
            document.getElementById('table-result').innerHTML = data.tableHTML || '';

            // Ajouter le bouton de téléchargement
            /*if (data.graphic) {
                const downloadBtn = document.createElement('button');
                downloadBtn.className = 'btn btn-primary mt-3';
                downloadBtn.textContent = 'Télécharger le graphique (SVG)';
                downloadBtn.id = 'download-svg-btn';
                graphicContainer.appendChild(downloadBtn);
            }*/
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            document.getElementById('graphic-zone').innerHTML = "<p class='text-danger'>" + ucfirst(thesaurus("analyze_error")) + ".</p>";
        });
    });

    // Fonction envoi des données structurée, récupération des données pour un affichage d'AFC et premier paramétrage
    document.getElementById('btn-fa-calculation').addEventListener('click', function() {
        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block';

        // Récupération des paramètres sélectionnés
        const mode = document.getElementById('mode-select').options[document.getElementById('mode-select').selectedIndex].value;

        // Construction de l'objet à envoyer
        const payload = {
            function: "correspondence_analysis",
            tableItems: tableResults,
            groupsInfo: typeGroupsInfo,
            mode: mode,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        }

        // Envoi (et réception) AJAX
        fetch("/static/ajax/horizons_advanced.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Intégration des tables de résultats au bon endroit
            tableResultsCA       = data.tableResultsCA;
            typeGroupsInfoCA     = data.groupsInfoCA;
            limitsCoordCA        = data.limitsCoordCA;

            const modeTranslated = data.modeTranslated;
            const axeCount       = data.axeCount;
            const tableEigenVal  = data.tableEigenVal;

            const initialHeight  = 700;
            const initialWidth   = 800;

            // Création de la zone de graphique
            const graphicResult = document.createElement('div');
            graphicResult.classList.add('flex-grow-1', 'flex-basis-0', 'border', 'border-dark', 'm-1', 'table-responsive');
            graphicResult.id = 'graphic-result';

            // Création du premier paramètre : visualisation
            const paramsVisualizing = document.createElement('div');
            paramsVisualizing.classList.add('settings-block', 'flex-shrink-0', 'border', 'rounded', 'm-1', 'p-2');
            paramsVisualizing.style.flexBasis = '240px';
            paramsVisualizing.style.flex = "1 1 20%";
            paramsVisualizing.id = 'graphic-parameters';
                // Choix longueur et largeur
                const divSizeHeader = document.createElement('h6');
                divSizeHeader.textContent = ucfirst(thesaurus('graphic_size'));
                divSizeHeader.classList.add('mb-0');

                const heightLabel = document.createElement('label');
                heightLabel.classList.add('form-label', 'small');
                heightLabel.setAttribute('for', 'ca-height-input');
                heightLabel.textContent = ucfirst(thesaurus('height'));
                const heightInput = document.createElement('input');
                heightInput.classList.add('form-control', 'form-control-sm');
                heightInput.id = 'ca-height-input';
                heightInput.type = 'number';
                heightInput.placeholder = ucfirst(thesaurus('height')) + " (" + ucfirst(thesaurus('pixels')) + ")";
                heightInput.value = initialHeight;
                const divHeight = addToDiv([heightLabel, heightInput], 0);
                divHeight.classList.add('col-md-6', 'p-1');

                const widthLabel = document.createElement('label');
                widthLabel.classList.add('form-label', 'small');
                widthLabel.setAttribute('for', 'ca-width-input');
                widthLabel.textContent = ucfirst(thesaurus('width'));
                const widthInput = document.createElement('input');
                widthInput.classList.add('form-control', 'form-control-sm');
                widthInput.id = 'ca-width-input';
                widthInput.type = 'number';
                widthInput.placeholder = ucfirst(thesaurus('width')) + " (" + ucfirst(thesaurus('pixels')) + ")";
                widthInput.value = initialWidth;
                const divWidth = addToDiv([widthLabel, widthInput], 0);
                divWidth.classList.add('col-md-6', 'p-1');

                const divSize = addToDiv([divSizeHeader, divHeight, divWidth], 0);
                divSize.classList.add('row', 'p-2');
                paramsVisualizing.appendChild(divSize);

                // Taille des polices
                const divFontSizeHeader = document.createElement('h6');
                divFontSizeHeader.textContent = ucfirst(thesaurus('polices_size'));
                divFontSizeHeader.classList.add('mb-0');

                const itemSizeLabel = document.createElement('label');
                itemSizeLabel.classList.add('form-label', 'small');
                itemSizeLabel.setAttribute('for', 'ca-font-items-input');
                itemSizeLabel.textContent = modeTranslated;
                const itemSizeInput = document.createElement('input');
                itemSizeInput.classList.add('form-control', 'form-control-sm');
                itemSizeInput.id = 'ca-font-items-input';
                itemSizeInput.type = 'number';
                itemSizeInput.placeholder = ucfirst(thesaurus('police_size'));
                itemSizeInput.value = 10;
                const divItemSize = addToDiv([itemSizeLabel, itemSizeInput], 0);
                divItemSize.classList.add('col-md-6', 'p-1');

                const typeSizeLabel = document.createElement('label');
                typeSizeLabel.classList.add('form-label', 'small');
                typeSizeLabel.setAttribute('for', 'ca-font-types-input');
                typeSizeLabel.textContent = ucfirst(thesaurus('types'));
                const typeSizeInput = document.createElement('input');
                typeSizeInput.classList.add('form-control', 'form-control-sm');
                typeSizeInput.id = 'ca-font-types-input';
                typeSizeInput.type = 'number';
                typeSizeInput.placeholder = ucfirst(thesaurus('police_size'));
                typeSizeInput.value = 8;
                const divTypeSize = addToDiv([typeSizeLabel, typeSizeInput], 0);
                divTypeSize.classList.add('col-md-6', 'p-1');

                const divFontSize = addToDiv([divFontSizeHeader, divItemSize, divTypeSize], 0);
                divFontSize.classList.add('row', 'p-2');
                paramsVisualizing.appendChild(divFontSize);

                // Taille des points
                const divDotSizeHeader = document.createElement('h6');
                divDotSizeHeader.textContent = ucfirst(thesaurus('dots_size'));
                divDotSizeHeader.classList.add('mb-0');

                const itemSizeDotLabel = document.createElement('label');
                itemSizeDotLabel.classList.add('form-label', 'small');
                itemSizeDotLabel.setAttribute('for', 'ca-dot-items-input');
                itemSizeDotLabel.textContent = modeTranslated;
                const itemSizeDotInput = document.createElement('input');
                itemSizeDotInput.classList.add('form-control', 'form-control-sm');
                itemSizeDotInput.id = 'ca-dot-items-input';
                itemSizeDotInput.type = 'number';
                itemSizeDotInput.placeholder = ucfirst(thesaurus('dots_size'));
                itemSizeDotInput.value = 5;
                const divItemSizeDot = addToDiv([itemSizeDotLabel, itemSizeDotInput], 0);
                divItemSizeDot.classList.add('col-md-6', 'p-1');

                const typeSizeDotLabel = document.createElement('label');
                typeSizeDotLabel.classList.add('form-label', 'small');
                typeSizeDotLabel.setAttribute('for', 'ca-dot-types-input');
                typeSizeDotLabel.textContent = ucfirst(thesaurus('types'));
                const typeSizeDotInput = document.createElement('input');
                typeSizeDotInput.classList.add('form-control', 'form-control-sm');
                typeSizeDotInput.id = 'ca-dot-types-input';
                typeSizeDotInput.type = 'number';
                typeSizeDotInput.placeholder = ucfirst(thesaurus('dots_size'));
                typeSizeDotInput.value = 4;
                const divTypeSizeDot = addToDiv([typeSizeDotLabel, typeSizeDotInput], 0);
                divTypeSizeDot.classList.add('col-md-6', 'p-1');

                const divDotSize = addToDiv([divDotSizeHeader, divItemSizeDot, divTypeSizeDot], 0);
                divDotSize.classList.add('row', 'p-2');
                paramsVisualizing.appendChild(divDotSize);

                // Axes à afficher
                const divAxesHeader = document.createElement('h6');
                divAxesHeader.textContent = ucfirst(thesaurus('axes_choice'));
                divAxesHeader.classList.add('mb-0');

                const xAxeLabel = document.createElement('label');
                xAxeLabel.classList.add('form-label', 'small');
                xAxeLabel.setAttribute('for', 'ca-axe-x-select');
                xAxeLabel.textContent = ucfirst(thesaurus('x_axe'));
                const xAxeInput = document.createElement('select');
                xAxeInput.classList.add('form-select', 'form-select-sm');
                xAxeInput.id = 'ca-axe-x-select';
                for (i = 1; i <= axeCount; i++) {
                    const xAxeOpt = document.createElement('option');
                    xAxeOpt.value = i;
                    xAxeOpt.textContent = "Axe " + i;
                    if (i === 1) xAxeOpt.selected = true;
                    xAxeInput.appendChild(xAxeOpt);
                }
                const divXAxe = addToDiv([xAxeLabel, xAxeInput], 0);
                divXAxe.classList.add('col-md-6', 'p-1');

                const yAxeLabel = document.createElement('label');
                yAxeLabel.classList.add('form-label', 'small');
                yAxeLabel.setAttribute('for', 'ca-axe-y-select');
                yAxeLabel.textContent = ucfirst(thesaurus('y_axe'));
                const yAxeInput = document.createElement('select');
                yAxeInput.classList.add('form-select', 'form-select-sm');
                yAxeInput.id = 'ca-axe-y-select';
                for (i = 1; i <= axeCount; i++) {
                    const yAxeOpt = document.createElement('option');
                    yAxeOpt.value = i;
                    yAxeOpt.textContent = "Axe " + i;
                    if (i === 2) yAxeOpt.selected = true;
                    yAxeInput.appendChild(yAxeOpt);
                }
                const divYAxe = addToDiv([yAxeLabel, yAxeInput], 0);
                divYAxe.classList.add('col-md-6', 'p-1');

                const divAxes = addToDiv([divAxesHeader, divXAxe, divYAxe], 0);
                divAxes.classList.add('row', 'p-2');
                paramsVisualizing.appendChild(divAxes);

                // Type de carte
                const divMapTypeHeader = document.createElement('h6');
                divMapTypeHeader.textContent = ucfirst(thesaurus('projection_type'));
                divMapTypeHeader.classList.add('mb-0');

                const mapTypeOpt1 = document.createElement('option');
                mapTypeOpt1.value = 'coords_p';
                mapTypeOpt1.textContent = ucfirst(thesaurus('princ_unbar'));
                const mapTypeOpt2 = document.createElement('option');
                mapTypeOpt2.value = 'coords_sym';
                mapTypeOpt2.textContent = ucfirst(thesaurus('symetric'));
                /* On a enlevé, inutile
                const mapTypeOpt3 = document.createElement('option');
                mapTypeOpt3.value = 'coords_p_row';
                mapTypeOpt3.textContent = 'Principales lignes'; */
                const mapTypeOpt4 = document.createElement('option');
                mapTypeOpt4.value = 'coords_p_col';
                mapTypeOpt4.textContent = ucfirst(thesaurus('princ_col_def'));
                const mapTypeSelect = document.createElement('select');
                mapTypeSelect.classList.add('form-select', 'form-select-sm');
                mapTypeSelect.id = 'ca-map-type-select';
                const divMapTypeSelect = addToDiv(insertElement(mapTypeSelect, [mapTypeOpt4, mapTypeOpt2, mapTypeOpt1]), 0);
                divMapTypeSelect.classList.add('col-md-12', 'p-1');

                const divMapType = addToDiv([divMapTypeHeader, divMapTypeSelect], 0);
                divMapType.classList.add('row', 'p-2');
                paramsVisualizing.appendChild(divMapType);

                // Interactif : to do

                // Bouton validation
                const btnCAParams = document.createElement('button');
                btnCAParams.classList.add('btn', 'btn-secondary', 'btn-sm');
                btnCAParams.type = 'button';
                btnCAParams.addEventListener('click', () => {
                    const xAxe = document.getElementById('ca-axe-x-select').value;
                    const yAxe = document.getElementById('ca-axe-y-select').value;
                    const mapType = document.getElementById('ca-map-type-select').value;
                    const width = document.getElementById('ca-width-input').value;
                    const height = document.getElementById('ca-height-input').value;
                    const fontItem = document.getElementById('ca-font-items-input').value;
                    const fontType = document.getElementById('ca-font-types-input').value;
                    const dotItem = document.getElementById('ca-dot-items-input').value;
                    const dotType = document.getElementById('ca-dot-types-input').value; 
                    const interactive = false;
                    createCAGraphic(xAxe, yAxe, mapType, width, height, fontItem, fontType, dotItem, dotType, interactive)
                });
                btnCAParams.textContent = ucfirst(thesaurus('validate_changes'));
                const divBtnCAParams = addToDiv(btnCAParams, 0);
                divBtnCAParams.classList.add('m-2', 'row');
                paramsVisualizing.appendChild(divBtnCAParams);
                
                // Zones (calques) à afficher
                const divLayersHeader = document.createElement('h6');
                divLayersHeader.textContent = ucfirst(thesaurus('display'));
                divLayersHeader.classList.add('mb-2');

                function createSwitchButtonsForCA (label, id, target) {
                    const switchCALabel = document.createElement('label');
                    switchCALabel.classList.add('form-check-label');
                    switchCALabel.setAttribute('for', id);
                    switchCALabel.textContent = label;
                    const switchCABase = document.createElement('input');
                    switchCABase.classList.add('form-check-input');
                    switchCABase.type = 'checkbox';
                    switchCABase.id = id;
                    switchCABase.checked = true;
                    switchCABase.addEventListener('change', (event) => {
                        document.getElementById(target).style.display = event.target.checked ? 'inline' : 'none';
                    });
                    const divCASwitch = addToDiv([switchCABase, switchCALabel], 0);
                    divCASwitch.classList.add('form-check', 'form-switch');
                    return divCASwitch;
                }

                const divLayer = document.createElement('div');
                divLayer.classList.add('row', 'p-2');
                divLayer.appendChild(divLayersHeader);
                divLayer.appendChild(createSwitchButtonsForCA(ucfirst(thesaurus('coordinates')), 'ca-switch-basis', 'ca-basis'));
                divLayer.appendChild(createSwitchButtonsForCA(modeTranslated, 'ca-switch-layer-items', 'ca-layer-items'));
                divLayer.appendChild(createSwitchButtonsForCA(ucfirst(thesaurus('names')) + modeTranslated, 'ca-switch-layer-items-label', 'ca-layer-items-label'));
                divLayer.appendChild(createSwitchButtonsForCA(ucfirst(thesaurus('types')), 'ca-switch-layer-types', 'ca-layer-types'));
                divLayer.appendChild(createSwitchButtonsForCA(ucfirst(thesaurus('types_names')), 'ca-switch-layer-types-label', 'ca-layer-types-label'));

                paramsVisualizing.appendChild(divLayer);
                

            // Création du second paramètre : eigenvalue et % de représentativité + cumulée (plus horizontal)
            const paramsValues = document.createElement('div');
            paramsValues.classList.add('settings-block', 'border', 'rounded', 'm-1', 'p-2', 'flex-grow-1');
            paramsValues.style.minWidth = '0px';
            paramsValues.style.flex = "1 1 75%";
            paramsValues.innerHTML += tableEigenVal;
            
            // Ajout de cette zone dans la partie dédiée
            const graphicZone = document.getElementById('graphic-zone');
            graphicZone.innerHTML = "";
            graphicZone.append(graphicResult);
            graphicZone.append(paramsVisualizing);
            graphicZone.append(paramsValues);

            // Création du premier graphique
            createCAGraphic(1, 2, 'coords_p_col', initialWidth, initialHeight);

            // Cache le spinner
            spinner.style.display = 'none';
            // Injection du résultat
            //const graphicContainer = document.getElementById('graphic-result');
            //graphicContainer.innerHTML = data.dataGraphic || '';

            // Ajouter le bouton de téléchargement
            if (data.tableResultsCA) {
                if (!document.getElementById('download-svg-btn')) {
                    const downloadBtn = document.createElement('button');
                    downloadBtn.className = 'btn btn-primary';
                    downloadBtn.textContent = ucfirst(thesaurus('download_svg'));
                    downloadBtn.id = 'download-svg-btn';
                    document.getElementById('buttons-results').appendChild(downloadBtn);
                }
            }
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            document.getElementById('graphic-zone').innerHTML = "<p class='text-danger'>" + ucfirst(thesaurus('analyze_error')) + ".</p>";
        });
    });

    // Fonction de téléchargement du graphique
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'download-svg-btn') {
            const svgElement = document.querySelector('#graphic-result svg');
            if (!svgElement) return;

            // Récupérer le code SVG
            const svgData = new XMLSerializer().serializeToString(svgElement);

            // Créer un blob
            const blob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(blob);

            // Créer un lien de téléchargement temporaire
            const link = document.createElement('a');
            link.href = url;
            link.download = 'graphique.svg';
            document.body.appendChild(link);
            link.click();

            // Nettoyage
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }
    });
</script>

    </body>
</html>