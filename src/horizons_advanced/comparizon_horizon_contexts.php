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
        // Check si un $_POST présent. Il aura un 'type_object' et un 'id_object'
        if (isset($_POST)) {
            if (isset($_POST['type_object'])) {
                switch ($_POST['type_object']) {
                    case 'facies':
                        $preselected_facies = Facies::find_by_id($_POST['id_object']);
                        break;
                    case 'phase':
                        $check_object = Phase::find_by_id($_POST['id_object']);
                        if ($check_object->contributor_rights()) {
                            $preselected_phase = $check_object;
                        }
                        break;
                    case 'context':
                        $check_object = Context::find_by_id($_POST['id_object']);
                        if ($check_object->contributor_rights()) {
                            $preselected_context = $check_object;
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        // Recherche des faciès
        $all_facies = Facies::find_all(['code']);
        $facies = [];
        $my_facies = [];
        $horizons = [];
        foreach ($all_facies as $af) {
            if ($af->contributor_rights() || ($af->public() && $af->allow_graphs())) {
                $facies[] = $af;
                $my_facies[] = $af->code();
                // Liste des horizons
                $add_horizons = [];
                foreach (Horizon::find_by_parent($af->id(), ['code']) as $h) {
                    $superhorizon = $h->superhorizon();
                    if ($superhorizon) {
                        $superhorizon = $superhorizon->code();
                    }
                    $add_horizons[] = ['code'=>$h->code(), 'name'=>$h->codename(), 'superhorizon'=>$superhorizon];
                }
                $horizons[$af->code()] = $add_horizons;
            } /*elseif ($af->public()) {
                $facies[] = $af;
            }*/
        }

        // Recherche des phases et contextes
        $phases = [];
        $contexts = [];
        $my_phases = [];
        $my_contexts = [];
        $sites = Site::find_all(['code']);
        foreach ($sites as $s) {
            if ($s->contributor_rights() || ($s->public() && $s->allow_graphs())) {
                $add_phases = Phase::find_by_parent($s->id());
                foreach ($add_phases as $ph) {
                    $phase_item = ['site'=>$s->name(), 'code'=>$ph->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $ph->codename())];
                    array_push($phases, $phase_item);
                    array_push($my_phases, $phase_item);
                    $add_contexts = Context::find_by_parent($ph->id());
                    foreach ($add_contexts as $c) {
                        $context_item = ['site'=>$s->name(), 'code'=>$c->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $c->codename())];
                        array_push($contexts, $context_item);
                        array_push($my_contexts, $context_item);
                    }
                }
            }/* elseif ($s->public()) {
                $add_phases = Phase::find_by_parent($s->id());
                foreach ($add_phases as $ph) {
                    $phase_item = ['site'=>$s->name(), 'code'=>$ph->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $ph->codename())];
                    array_push($phases, $phase_item);
                    $add_contexts = Context::find_by_parent($ph->id());
                    foreach ($add_contexts as $c) {
                        $context_item = ['site'=>$s->name(), 'code'=>$c->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $s->code() . " - " . $c->codename())];
                        array_push($contexts, $context_item);
                    }
                }
            }*/
        }

        // Recherche des méthodes de comptage
        $countings_methods = Counting::find_all();

        // Titre
        $title = ucfirst(thesaurus("comparing_with_horizons"));
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

            // Affichages en colonne
            echo "<div class='container'><div class='row'>";
            // Colonne de gauche
            echo "<div class='col-md-6'>";

            /* Paramètres */
            // Facies
            // Menu déroulant du facies
            $title_facies = "1. " . ucfirst(thesaurus('select_facies_horizons'));
                $choices_facies = opt("", "-- " . thesaurus('select facies') . " --");
                foreach ($facies as $f) {
                    $choices_facies .= opt($f->code(), $f->codename());
                }
            $html_facies = bloc(select(ucfirst(thesaurus('select_facies_horizons')) . thesaurus(':'), $choices_facies, 'facies-select', 'facies')); "<div class='mb-3'>";
            // Horizons à cocher
            $html_facies .= bloc(p(thesaurus('need_select_facies'), 'text-muted'), 0, 3, 'horizons-zone');
            echo card($title_facies, $html_facies);

            // Phases or contexts
            echo "<div class='card mb-3'>
                <div class='card-header'>2. " . ucfirst(thesaurus('phases')) . ' ' . thesaurus('or') . ' ' . thesaurus('contexts') . "</div>
                <div class='card-body'>";
                    // Choix du mode
                    echo "<div class='mb-3'>
                        <label for='mode-select' class='form-label'>" . ucfirst(thesaurus('working_with')) . thesaurus(':') . "</label>
                        <select id='mode-select' class='form-select'>
                            <option value=''>-- " . thesaurus('select mode') . " --</option>
                            <option value='phases'>" . ucfirst(thesaurus('phases')) . "</option>
                            <option value='contexts'>" . ucfirst(thesaurus('contexts')) . "</option>
                        </select>
                    </div>";
                    // Zone de saisie avec recherche
                    echo "<div class='mb-3'>";
                        echo "<label for='search-input' class='form-label'>" . ucfirst(thesaurus('search')) . thesaurus(':') . "</label>
                        <input type='text' id='search-input' class='form-control' placeholder='" . ucfirst(thesaurus('type_for_research')) . "' disabled>";
                        // Présentation des résultats de la recherche
                        echo "<div id='search-results' class='list-group mt-2'></div>";
                    echo "</div>";

                    // Liste des éléments sélectionnés
                    echo "<div>
                        " . h(6, ucfirst(thesaurus('selected_items')) . thesaurus(':')) . "
                        <div id='selected-items' class='d-flex flex-wrap'></div>
                    </div>";
                echo "</div>
            </div>";

            // Colonne de droite
            echo "</div><div class='col-md-6'>";

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

            // Type_links
            echo "<div class='card mb-3 horizons-advanced-comp-links'>
                <div class='card-header'>4. " . ucfirst(thesaurus('links_parameters')) . "</div>
                <div class='card-body'>";
                    echo "<table class='table table-bordered align-middle'>
                        <thead><tr>";
                        echo "<th>" . ucfirst(thesaurus('type_link')) . "</th>";
                        echo "<th>" . ucfirst(thesaurus('color')) . "</th>";
                        echo "<th>" . ucfirst(thesaurus('curve?')) . "<abbr title='" . thesaurus('curve_explanations') . "'><i class='bi bi-info-circle'></i></abbr></th>";
                    echo "</tr></thead><tbody>";
                    foreach (LINKS_HOR_TYPE as $key => $val) {
                        // Label
                        if ($key === 'not_linked') {
                            $label_link = ucfirst(th_h_a_link_type($key));
                        } else {
                            $label_link = ucfirst(thesaurus('type')) . " " . th_h_a_link_type($key);
                        }
                        echo "<tr>";
                            echo "<td>" . $label_link . "</td>";
                            // Sélecteur de couleurs
                            echo "<td>"; 
                                echo "<div class='d-flex flex-wrap'>";
                                // Crée un bouton par couleur intégrée
                                foreach (COLORS_HORIZONS_ADVANCED_1 as $num => $color) {
                                    // Vérifie si présélectionné
                                    $checked = $val['color'] == $num ? 'checked' : '';
                                    // Crée le bouton
                                    echo "<input type='radio' class='btn-check' name='link_color[" . $key . "]' id='color-" . $key . "-" . $num . "'
                                        value='" . $num . "' " . $checked . ">
                                        <label class='btn me-1 mb-1' for='color-" . $key . "-" . $num . "'
                                        style='background-color:" . $color['rgb'] . "; width: 30px; height: 30px; border: 2px solid #xxx;'></label>";
                                }
                                // Option aucune couleur
                                    $checked = $val['color'] == 0 ? 'checked' : '';
                                    echo "<input type='radio' class='btn-check' name='link_color[" . $key . "]' id='color-" . $key . "-none'
                                        value='0' " . $checked . ">
                                        <label class='btn btn-sm btn-outline-secondary me-1 mb-1' for='color-" . $key . "-none'>Ø</label>";
                                echo "</div>";
                            echo "</td>";
                            // Checkbox courbe cumulative
                            echo "<td class='text-center'>
                                <input class='form-check-input' type='checkbox' name='link_include[" . $key . "]' value='1' " . ($val['cumul'] ? 'checked' : '') . ">
                                </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                echo "</div>
            </div>";

            // Fin des colonnes
            echo "</div></div></div>";

            /* Bouton de lancement */
            echo "<div class='text-center my-4'>
                <button id='btn-analyse' class='btn btn-primary btn-lg'>" . ucfirst(thesaurus('launch_analysis')) . "</button>
            </div>";

            /* Résultats */
            echo "<div class='card mb-3'>
                <div class='card-header'>" . ucfirst(thesaurus("results_single")) . "</div>
                <div class='card-body'>";
                // Spinner
                echo "<div id='loading-spinner' class='text-center my-3' style='display:none;'>
                    <div class='spinner-border text-primary' role='status'>
                        <span class='visually-hidden'>" . ucfirst(thesaurus("loading")) . "...</span>
                    </div>
                </div>";
                echo "<div id='graphic-result' class='mb-4'>";
                    // Graphique généré via AJAX -->
                echo "</div>
                <div id='table-result'>";
                    // Tableau généré via AJAX -->
                echo "</div>
                </div>
            </div>
        </div>";

        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

<script>
    // Récupération des présélections, si présentes
    let preselectedFacies   = <?php echo isset($preselected_facies)   ? json_encode($preselected_facies->code()) : 'null'; ?>;
    let preselectedPhase    = <?php echo isset($preselected_phase)    ? json_encode(['site'=>$preselected_phase->related_site()->name(), 'code'=>$preselected_phase->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $preselected_phase->related_site()->code() . " - " . $preselected_phase->codename())]) : 'null'; ?>;
    let preselectedContext  = <?php echo isset($preselected_context)  ? json_encode(['site'=>$preselected_context->related_phase()->related_site()->name(), 'code'=>$preselected_context->code(), 'name'=>(ucfirst(thesaurus("site")) . " " . $preselected_context->related_phase()->related_site()->code() . " - " . $preselected_context->codename())]) : 'null'; ?>;

    // Encodage des horizons
    const horizonsData = <?php echo json_encode($horizons); ?>;
    const myFaciesCodes = <?php echo json_encode($my_facies); ?>;
    let currentFacies = null;
    let currentMode = null;

    // Variables pour les phases et contextes
    const modeSelect = document.getElementById('mode-select');
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    const selectedItems = document.getElementById('selected-items');

    let currentData = []; // phases ou contextes selon le cas
    let selectedList = []; // liste des éléments choisis

    // Déclenchement des logiques si présélections
    window.addEventListener('DOMContentLoaded', () => {
        if (preselectedFacies) {
            const faciesSelect = document.getElementById('facies-select');
            faciesSelect.value = preselectedFacies;
            faciesSelect.dispatchEvent(new Event('change'));
        }
        if (preselectedPhase) {
            modeSelect.value = "phases";
            modeSelect.dispatchEvent(new Event('change'));
            addItem(preselectedPhase); // Ajoute le badge nécessaire
        }
        if (preselectedContext) {
            modeSelect.value = "contexts";
            modeSelect.dispatchEvent(new Event('change'));
            addItem(preselectedContext); // Ajoute le badge nécessaire
        }
    });

    // Fonction de sélection des horizons à charger + choix du type de phase/contexte
    document.getElementById('facies-select').addEventListener('change', function() {
        // Sélection doit être supprimée si on avait un de ses facies et qu'on en a plus ensuite
        if (myFaciesCodes.includes(currentFacies) && !myFaciesCodes.includes(this.value)) {
            // Si il y a présélection, ne change pas la première fois, mais annule pour pouvoir utiliser ça après
            if (!preselectedPhase && !preselectedContext) {
                resetSelection();
            }
        }
        currentFacies = this.value;

        const zone = document.getElementById('horizons-zone');
        zone.innerHTML = ''; // D'abord, on supprime tout ce qu'il y a dedans

        // On vérifie s'il y a bien un facies sélectionné, et s'il est repris dans les horizons
        if (currentFacies && horizonsData[currentFacies]) {
            // On enable si phase/contexte aussi OK
            if (modeSelect.value) {
                searchInput.disabled = false;
                // Appel à la fonction permettant de choisir quelle liste proposer pour les phases et contextes
                updateData();
            }
            const list = document.createElement('div');

            // Regroupements par parents
            const mainHorizon = {};
            horizonsData[currentFacies].forEach(h => {
                // Récupération du code et du nom
                const code = h['code'];
                const name = h['name'];
                const superh = h['superhorizon'];

                if (!superh) {
                    // horizon parent
                    if (!mainHorizon[code]) {
                        mainHorizon[code] = { data: h, children: [] };
                    } else {
                        mainHorizon[code].data = h;
                    }
                } else {
                    // horizon enfant
                    if (!mainHorizon[superh]) {
                        mainHorizon[superh] = { data: null, children: [] };
                    }
                    mainHorizon[superh].children.push(h);
                }
            });

            // Affichage
            Object.values(mainHorizon).forEach(group => {
                if (group.data) {
                    const main = group.data;
                    list.appendChild(createHorizonButton(main['code'], main['name'], false));
                }
                group.children.forEach(child => {
                    list.appendChild(createHorizonButton(child['code'], child['name'], true));
                });
            });

            // Ajout des checkboxes à l'endroit prévu
            zone.appendChild(list);
        } else {
            zone.innerHTML = "<p class='text-muted'>" + ucfirst(thesaurus("no_horizon_facies")) + "</p>";
            searchInput.disabled = true;
        }

        // Fonction création bouton
        function createHorizonButton(code, name, isChild) {
            // Création du conteneur de la checkbox
            const item = document.createElement('div');
            item.classList.add('mb-2');

            const indentClass = isChild ? 'ms-4' : '';

            // Création de la checkbox
            item.innerHTML = `
                <input class="btn-check" type="checkbox"
                    name="horizons[]" value="${code}" id="h-${code}" checked autocomplete="off">
                <label class="btn btn-outline-primary btn-sm ${indentClass}" for="h-${code}">
                    ${name}
                </label>
            `;
            // Ajout de la checkbox à la liste des checkbox existentes
            return item;
        }

    });

    // Gère le changement de mode (phases/contextes)
    modeSelect.addEventListener('change', function() {
        resetSelection();
        // Si phase ou contexte sélectionné, recherche possible.
        if (this.value && currentFacies) {
            searchInput.disabled = false;
            // Appel à la fonction permettant de choisir quelle liste proposer pour les phases et contextes
            updateData();
        } else {
            searchInput.disabled = true;
        }
    });

    // Encodage des phases et contextes
    const phasesData = <?php echo json_encode($phases); ?>;
    const contextsData = <?php echo json_encode($contexts); ?>;
    const myPhasesData = <?php echo json_encode($my_phases); ?>;
    const myContextsData = <?php echo json_encode($my_contexts); ?>;

    // En fonction du faciès et du mode choisi, change ce qui est disponible entre contextes et phases.
    function updateData() {
        const useStandard = myFaciesCodes.includes(currentFacies);
        if        (modeSelect.value === 'phases'  ) {
            comparisonOptions = useStandard ? phasesData   : myPhasesData;
        } else if (modeSelect.value === 'contexts') {
            comparisonOptions = useStandard ? contextsData : myContextsData;
        } else {
            comparisonOptions = [];
        }
    }

    // Recherche dynamique dans les phases et contextes
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        searchResults.innerHTML = '';
        if (!query) return;
        
        // Récupère les 10 premiers éléments concordants
        const matches = comparisonOptions.filter(item => item.name.toLowerCase().includes(query)).slice(0, 10);
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

    // Ajouter l'élément sélectionné (badge contexte ou phase)
    function addItem(item) {
        // Check si déjà présent, pour éviter les doublons
        if (selectedList.find(i => i.code === item.code)) return;
        selectedList.push(item);

        // Crée l'élément sous forme de badge (avec un bouton de retrait via removeItem)
        const badge = document.createElement('span');
        badge.classList.add('badge', 'bg-primary', 'text-wrap', 'me-2', 'mb-2');
        badge.textContent = item.name;
        badge.style.cursor = 'pointer';
        badge.onclick = () => removeItem(item.code, badge);
        // Ajoute le badge aux éléments sélectionnés
        selectedItems.appendChild(badge);
        // Nettoie le champ de recherche et la liste des propositions
        searchResults.innerHTML = '';
        searchInput.value = '';
        // Reset la présélection
        preselectedPhase   = null;
        preselectedContext = null;
    }

    // Retirer un élément (badge contexte ou phase)
    function removeItem(code, badge) {
        selectedList = selectedList.filter(i => i.code !== code);
        badge.remove();
    }

    // Réinitialiser la sélection
    function resetSelection() {
        selectedList = [];
        selectedItems.innerHTML = '';
        searchInput.value = '';
        searchResults.innerHTML = '';
    }

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

    // Fonction AJAX
    document.getElementById('btn-analyse').addEventListener('click', function() {
        // Fonction d'extraction de clé non buggée
        function extractKey(name) {
            const start = name.indexOf('[');
            const end   = name.indexOf(']', start + 1);
            if (start === -1 || end === -1) return null;
            return name.slice(start + 1, end);
        }

        // Affichage d'un spinner de chargement
        const spinner = document.getElementById('loading-spinner');
        spinner.style.display = 'block';

        // Récupération des paramètres sélectionnés
        
        // 1. Faciès et horizons cochés
        const facies = document.getElementById('facies-select').value;
        const horizons = Array.from(document.querySelectorAll("input[name='horizons[]']:checked"))
            .map(el => el.value);

        // 2. Phases / Contextes
        const mode = document.getElementById('mode-select').value;
        const selectedItemsList = selectedList
            .map(el => ({ 'site': el.site, 'code': el.code }));

        // 3. Méthode de comptage
        const countingMethod = document.getElementById('counting-select').value;
        const countingParts = Array.from(document.querySelectorAll("input[name='counting_parts[]']:checked"))
            .map(el => el.value);
        
        // 4. Paramètres des liens
        const linkParams = {};
        // D'abord, couleur (prend tous les éléments commençant par 'link_color')
        document.querySelectorAll("input[name^='link_color']")
            .forEach(el => {
                if (el.checked) {
                    const key = extractKey(el.name); // extrait la clé
                    // L'inclus
                    linkParams[key] = { color: el.value };
                }
            });
        // Ensuite, valeur (prend tous les éléments commençant par 'link_include')
        document.querySelectorAll("input[name^='link_include']")
            .forEach(el => {
                const key = extractKey(el.name); // extrait la clé
                // Si pas de couleur, crée tout de même la clé
                if (!linkParams[key]) linkParams[key] = {};
                linkParams[key].include = el.checked;
            });

        // Construction de l'objet à envoyer
        const payload = {
            function: "comparison_with_horizon",
            facies: facies,
            horizons: horizons,
            mode: mode,
            selectedItems: selectedItemsList,
            countingMethod: countingMethod,
            countingParts: countingParts,
            linkParams: linkParams,
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
            // Injection du résultat
            const graphicContainer = document.getElementById('graphic-result');
            graphicContainer.innerHTML = data.graphic || '';
            document.getElementById('table-result').innerHTML = data.table || '';

            // Ajouter le bouton de téléchargement
            if (data.graphic) {
                const downloadBtn = document.createElement('button');
                downloadBtn.className = 'btn btn-primary mt-3';
                downloadBtn.textContent = ucfirst(thesaurus('download_svg'));
                downloadBtn.id = 'download-svg-btn';
                graphicContainer.appendChild(downloadBtn);
            }
        })
        .catch(error => {
            // Cache le spinner
            spinner.style.display = 'none';
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
            document.getElementById('graphic-result').innerHTML = "<p class='text-danger'>" + ucfirst(thesaurus("analyze_error")) + ".</p>";
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