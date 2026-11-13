        <!-- Copyright -->
        <div style="text-align:center"><p><small><?php echo thesaurus('logacer_version') . VERSION . ". "; ?></small>© <small><?php echo date("Y") . " " . thesaurus("footer_copyright") . "."; ?>
        <?php long_translation("footer"); ?>
        </small>
        </br><?php serve_picture_public("Logo-logacer-3.png", true, 'https://www.logacer.org', false, 60); ?>
    </br></br></p>
    </div>
    </div>

    <script>
        // Appel du filtre (spécifique)
document.querySelectorAll('.filter-inventory_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('inventory_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-table_types').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('table_types');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-type_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('type_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-fabric_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('fabric_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-site_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('site_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-category_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('category_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-function_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('function_table');
    });
});

// Appel du filtre (spécifique)
document.querySelectorAll('.filter-context_table').forEach(input => {
    input.addEventListener('input', function () {
        applyAllFilters('context_table');
    });
});

// Fonctions de gestion des contributeurs
// Partie contributeurs. Contributors doit être une array avec dedans le nom (name) à afficher et l'identifiant (id)
function showContribs (contributors, typeObject, idObject, isOwner) {
    // Si pas de contributeur et pas owner, on peut rien faire, on a pas ça
    if (contributors.length === 0 && !isOwner) {
        return null;
    }
    // Sinon, création du contenu du div
    // En premier, le titre
    const titleContrib = document.createElement('h6');
    titleContrib.innerHTML = ucfirst(thesaurus('contributors') + thesaurus(':'));
    // Ensuite la liste des contributeurs
    const listContrib = document.createElement('ul');
    listContrib.id = 'ul-contrib-' + typeObject + '-' + idObject;
    contributors.forEach(contributor => {
        const contrib = document.createElement('li');
        contrib.id = 'li-contrib-' + typeObject + '-' + idObject + '-' + contributor.id;
        contrib.innerHTML = contributor.name;
        // Si owner, bouton suppression
        if (isOwner) {
            contrib.innerHTML += ' ';
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.classList.add('btn', 'btn-light', 'btn-sm');
            deleteBtn.textContent = ucfirst(thesaurus('delete'));
            deleteBtn.addEventListener('click', () => {
                deleteContrib(typeObject, idObject, contributor.id, contributors);
            });
            contrib.appendChild(deleteBtn);
        }
        listContrib.appendChild(contrib);
    });
    // Enfin, le bouton (et la zone) d'ajouts
    if (isOwner) {
        const addBtn = document.createElement('button');
        addBtn.type = 'button';
        addBtn.classList.add('btn', 'btn-secondary', 'btn-sm');
        addBtn.textContent = ucfirst(thesaurus('add')) + ' ' + thesaurus('a contributor');
        addBtn.addEventListener('click', () => {
            addContribForm(typeObject, idObject, contributors);
        })
        const addContrib = document.createElement('div');
        addContrib.id = 'div-add-contrib-' + typeObject + '-' + idObject;
        addContrib.appendChild(addBtn);
        return addToDiv([titleContrib, listContrib, addContrib]);
    }
    return addToDiv([titleContrib, listContrib]);
}

// Supprime le contributeur
function deleteContrib (typeObject, idObject, idContributor, contributors) {
    // On envoie la demande de suppression en AJAX et on récupère la réponse
    const payload = {
        action:         'delete_contrib',
        typeObject:     typeObject,
        idObject:       idObject,
        idContributor:  idContributor,
        project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
    };
    // Envoi formule et réception information succès
    fetch("/static/ajax/manage_subelements.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            const success = data.success;
            if (success) {
                document.getElementById('li-contrib-' + typeObject + '-' + idObject + '-' + idContributor).remove();
                let index = contributors.findIndex(c => c.id === idContributor);
                if (index !== -1) {
                    contributors.splice(index, 1);
                }
                return true;
            } else {
                return false;
            }
        })
        .catch(error => {
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
        });
    // Enfin, on supprime le contributeur de la liste
    
}

// Remplace le bouton d'ajout par un form
function addContribForm (typeObject, idObject, contributors) {
    const formDiv = document.getElementById('div-add-contrib-' + typeObject + '-' + idObject);
    // D'abord, on supprime le bouton, en le sauvegardant avant :
    const addBtn = formDiv.querySelector('button');
    formDiv.innerHTML = '';
    // Ensuite, on ajoute le formulaire
    // Label
    const label = document.createElement('label');
    label.setAttribute('for', 'select-contrib-' + typeObject + '-' + idObject);
    label.textContent = ucfirst(thesaurus("select user") + thesaurus (":"));
    // Select de base
    const select = document.createElement('select');
    select.name = 'select-contrib-' + typeObject + '-' + idObject;
    select.id = select.name;
    const defaultOpt = document.createElement('option');
    defaultOpt.value = '';
    defaultOpt.textContent = "-- " + thesaurus("select user") + " --";
    select.appendChild(defaultOpt);
    // Boutons
    const btnDiv = document.createElement('div');
    btnDiv.classList.add('btn-group');
    btnDiv.role = 'group';
    // Bouton de validation
    const validBtn = document.createElement('button');
    validBtn.type = 'button';
    validBtn.classList.add('btn', 'btn-success', 'btn-sm');
    validBtn.textContent = ucfirst(thesaurus("validate"));
    validBtn.addEventListener('click', () => {
        // Récupération de l'identifiant du contributeur
        let idContributor = 0
        if (document.getElementById('select-contrib-' + typeObject + '-' + idObject).value !== '') {
            idContributor = parseInt(document.getElementById('select-contrib-' + typeObject + '-' + idObject).value);
        }
        const success = addContrib(typeObject, idObject, idContributor, contributors);

        formDiv.innerHTML = '';
        formDiv.appendChild(addBtn);
    })
    // Bouton d'annulation
    const cancelBtn = document.createElement('button');
    cancelBtn.type = 'button';
    cancelBtn.classList.add('btn', 'btn-secondary', 'btn-sm');
    cancelBtn.textContent = ucfirst(thesaurus("cancel"));
    cancelBtn.addEventListener('click', () => {
        // Fonction : enlève ce code, et remet le bouton qui lance la fonction
        formDiv.innerHTML = '';
        formDiv.appendChild(addBtn);
    })
    btnDiv.append(validBtn, cancelBtn);
    // Création autres options : besoin de récupérer les utilisateurs par formule AJAX
    // Création payload pour formule
    const payload = {
        action:     "selection_contributors",
        typeObject: typeObject,
        idObject:   idObject,
        project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
    };
    // Envoi/réception formule
    fetch("/static/ajax/manage_subelements.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify(payload)
        }).then(response => response.json())
        .then(data => {
            // Injection du résultat avec les options par utilisateurs
            data.users.forEach(user => {
                const opt = document.createElement('option');
                opt.value = user.id;
                opt.textContent = user.name;
                select.appendChild(opt);
            });
            // Maintenant, on ajoute les éléments à formDiv
            formDiv.append(label, select, btnDiv);
        })
        .catch(error => {
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
        });
}

function addContrib (typeObject, idObject, idContributor, contributors) {
    // On envoie la demande d'ajout en AJAX et on récupère la réponse
    const payload = {
        action:         'add_contrib',
        typeObject:     typeObject,
        idObject:       idObject,
        idContributor:  idContributor,
        project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
    };
    // Envoi formule et réception information succès
    fetch("/static/ajax/manage_subelements.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            const success = data.success;
            const contributor = data.contributor;
            // Enfin, on ajoute le contributeur à la liste
            if (success) {
                const listContrib = document.getElementById('ul-contrib-' + typeObject + '-' + idObject);
                const contrib = document.createElement('li');
                contrib.id = 'li-contrib-' + typeObject + '-' + idObject + '-' + contributor.id;
                contrib.innerHTML = contributor.name + ' ';
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.classList.add('btn', 'btn-light', 'btn-sm');
                deleteBtn.textContent = ucfirst(thesaurus('delete'));
                deleteBtn.addEventListener('click', () => {
                    deleteContrib(typeObject, idObject, contributor.id, contributors);
                });
                contrib.appendChild(deleteBtn);
                listContrib.appendChild(contrib);
                // On ajoute aussi à la liste globale pour référence future
                contributors.push({'name': contributor.name, 'id': contributor.id});
                return true;
            } else {
                return false;
            }
        })
        .catch(error => {
            // Affiche l'erreur
            console.error("Erreur AJAX:", error);
        });
    
}

    const TRANSLATIONS = <?php echo json_encode(
        TRANSLATIONS,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) ?>;

    const LANGUAGE = <?php echo json_encode(LANGUAGE) ?>;

    const WEBSITE_NAME = <?php echo json_encode(WEBSITE_NAME) ?>;

    function thesaurus(name) {
        const key = String(name).toLowerCase();

        if (
            TRANSLATIONS &&
            TRANSLATIONS.thesaurus &&
            Object.prototype.hasOwnProperty.call(
                TRANSLATIONS.thesaurus,
                key
            )
        ) {
            return TRANSLATIONS.thesaurus[key]
                .replaceAll("WEBSITE_NAME", WEBSITE_NAME);
        }

        return name.replaceAll("WEBSITE_NAME", WEBSITE_NAME);
    }

    function ucfirst(expression) {
        expression = String(expression);
        return expression.charAt(0).toUpperCase() + expression.slice(1);
    }
</script>