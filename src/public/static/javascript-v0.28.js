// Const Site in prod : const url_site = "https://www.dbcer.org/"
const url_site = "http://localhost:8888/"

// Confirmation before deletion if id = delete and confirmation is used like a form
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#delete').onsubmit = () => {
        const validation = confirm("Attention : vous vous apprêtez à supprimer cet élément. Êtes-vous sûr de vouloir le faire ? Une fois supprimé, l'action est irréversible.");
        if (validation == true) {
            return true;
        }
        else {
            return false;
        }
    }
});


// Confirmation before deletion if class = delete and confirmation is used like a form
document.addEventListener('DOMContentLoaded', function () {
    const deleteInput = document.querySelectorAll("input.delete");
    deleteInput.forEach((element) => {
        element.onclick = () => {
            const validation = confirm("Attention : vous vous apprêtez à supprimer cet élément. Êtes-vous sûr de vouloir le faire ? Une fois supprimé, l'action est irréversible.");
            if (validation == true) {
                return true;
            }
            else {
                return false;
            }
        };
    });
});

// Confirmation before separation if class = delete2 and confirmation is used like a form
document.addEventListener('DOMContentLoaded', function () {
    const deleteInput = document.querySelectorAll("input.delete2");
    deleteInput.forEach((element) => {
        element.onclick = () => {
            const validation = confirm("Attention : vous vous apprêtez à supprimer le lien avec cet élément. Êtes-vous sûr de vouloir le faire ? Une fois supprimé, l'action est irréversible.");
            if (validation == true) {
                return true;
            }
            else {
                return false;
            }
        };
    });
});

// Confirmation before upload new file if id = drop_upload and confirmation is used like a form
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#drop_upload').addEventListener('click', function (event) {
        const validation = confirm("Attention : vous vous apprêtez à abandonner un upload en cours. Êtes-vous sûr de vouloir le faire ? Une fois abandonné, l'action est irréversible.");
        if (!validation) {
            event.preventDefault();
        }
    });
});

// Display or undisplay Div with buttons (not in use now)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#b_mod').onclick = function() {
        document.querySelector('#modify').style.display = 'block';
        document.querySelector('#display').style.display = 'none';
    }
    document.querySelector('#b_display').onclick = function() {
        document.querySelector('#display').style.display = 'block';
        document.querySelector('#modify').style.display = 'none';
    }
});

// Display or undisplay Search bar
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('searchbutton').onclick = function() {
        if (document.getElementById('searchbar').style.display == 'block') {
            document.getElementById('searchbar').style.display = 'none';
        }
        else {
            document.getElementById('searchbar').style.display = 'block';
        }
    };
});

// Display or undisplay Div with buttons
document.addEventListener('DOMContentLoaded', function () {
    let max = 10;
    if (document.getElementById('b_map')) {
        document.getElementById('b_map').onclick = function() {
            document.getElementById('b_map').classList.add('active');
            if (document.getElementById('map')) {
                document.getElementById('map').style.display = 'block';
            }
            if (document.getElementById('map_header')) {
                document.getElementById('map_header').style.display = 'block';
            }
            for (let j = 1; j <= max; j++) {
                let div = 'div_' + j;
                let button = 'b_' + j;
                if (document.getElementById(div)) {
                    document.getElementById(div).style.display = 'none';
                    document.getElementById(button).classList.remove('active');
                }
            }
        }}
    for (let i = 1; i <= max; i++) {
        let abutton = 'b_' + i;
        if (document.getElementById(abutton)) {
            document.getElementById(abutton).onclick = function() {
                document.getElementById(abutton).classList.add('active');
                if (document.getElementById('map')) {
                    document.getElementById('map').style.display = 'none';
                    document.getElementById('b_map').classList.remove('active');
                }
                if (document.getElementById('map_header')) {
                    document.getElementById('map_header').style.display = 'none';
                }
                if (document.getElementById('list')) {
                    document.getElementById('list').style.display = 'none';
                }
                for (let j = 1; j <= max; j++) {
                    let button = 'b_' + j;
                    let div = 'div_' + j;
                    if (i === j) {
                        document.getElementById(div).style.display = 'block';
                    } else {
                        if (document.getElementById(div)) {
                            document.getElementById(div).style.display = 'none';
                            document.getElementById(button).classList.remove('active');
                        }        
                    }
                }
            }
        }
    }
});


// Display or undisplay Div with buttons for maps and lists
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('show_map')) {
        document.getElementById('show_map').onclick = function() {
            document.getElementById('show_map').classList.add('active');
            if (document.getElementById('map')) {
                document.getElementById('map').style.display = 'block';
            }
            if (document.getElementById('list')) {
                document.getElementById('list').style.display = 'none';
                document.getElementById('show_list').classList.remove('active');
            }
        }}
    if (document.getElementById('show_list')) {
        document.getElementById('show_list').onclick = function() {
            document.getElementById('show_list').classList.add('active');
            if (document.getElementById('map')) {
                document.getElementById('map').style.display = 'none';
                document.getElementById('show_map').classList.remove('active');
            }
            if (document.getElementById('list')) {
                document.getElementById('list').style.display = 'block';
            }
        }}
});

// Filtering
document.addEventListener('DOMContentLoaded', function() {

});

function sortTable(n, tablename) {
    var table = document.getElementById(tablename);
    var rows = Array.from(table.rows).slice(1); // ignorer l'en-tête
    var dir = table.getAttribute("data-sort-dir") === "asc" ? "desc" : "asc";

    rows.sort(function(rowA, rowB) {
        var x = rowA.cells[n];
        var y = rowB.cells[n];
        var valX, valY;

        if (x.hasAttribute("sort-text")) {
            valX = x.getAttribute("sort-text").toLowerCase();
            valY = y.getAttribute("sort-text").toLowerCase();
        } else if (x.hasAttribute("sort-number")) {
            valX = Number(x.getAttribute("sort-number"));
            valY = Number(y.getAttribute("sort-number"));
        } else {
            valX = x.textContent.toLowerCase();
            valY = y.textContent.toLowerCase();
        }

        if (valX < valY) return dir === "asc" ? -1 : 1;
        if (valX > valY) return dir === "asc" ? 1 : -1;
        return 0;
    });

    // Réinsérer les lignes triées
    var tbody = table.tBodies[0];
    rows.forEach(row => tbody.appendChild(row));

    // Mémoriser la direction pour le prochain clic
    table.setAttribute("data-sort-dir", dir);
}

// WYSIWYG functions
// Apply simple style (B/I/U/Titles)
function applyStyle(style) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return;

    const range = selection.getRangeAt(0);
    let container = selection.focusNode;

    // Go to an element
    while (container && container.nodeType === 3) {
        container = container.parentNode;
    }

    if (container && container.nodeName.toLowerCase() === style) {
        // if in style -> "unwrap"
        const parent = container.parentNode;
        while (container.firstChild) {
        parent.insertBefore(container.firstChild, container);
        }
        parent.removeChild(container);
    } else {
        // if not, style applied
        const content = range.extractContents();
        const el = document.createElement(style);
        el.appendChild(content);
        range.insertNode(el);
    }
}

// Create a list
function applyList(type) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return;

    const range = selection.getRangeAt(0);
    let container = selection.focusNode;

    // On remonte jusqu'à un élément
    while (container && container.nodeType === 3) {
        container = container.parentNode;
    }

    // --- Cas 1 : déjà dans une liste du type demandé → on supprime la liste
    if (container && container.closest(type)) {
        const list = container.closest(type);
        const parent = list.parentNode;

        // On remplace chaque <li> par son contenu brut + <br>
        while (list.firstChild) {
        if (list.firstChild.nodeName === "LI") {
            while (list.firstChild.firstChild) {
            parent.insertBefore(list.firstChild.firstChild, list);
            }
            parent.insertBefore(document.createElement("br"), list);
            list.removeChild(list.firstChild);
        } else {
            parent.insertBefore(list.firstChild, list);
        }
        }
        parent.removeChild(list);
        return;
    }

    // --- Cas 2 : pas encore de liste → on en crée une
    const content = range.extractContents();
    const text = content.textContent.trim();

    // Découpe par retour à la ligne
    const lines = text.split(/\r?\n/).filter(line => line.trim() !== "");

    const list = document.createElement(type);
    lines.forEach(line => {
        const li = document.createElement("li");
        li.textContent = line;
        list.appendChild(li);
    });

    range.insertNode(list);
}


// Create an URL
function applyLink() {
    const selection = window.getSelection();
    if (!selection.rangeCount) return;

    const range = selection.getRangeAt(0);
    let container = selection.focusNode;

    // On remonte jusqu'à un élément
    while (container && container.nodeType === 3) {
        container = container.parentNode;
    }

    // Cas 1 : déjà dans un lien → on "unwrap"
    if (container && container.closest('a')) {
        const link = container.closest('a');
        const parent = link.parentNode;
        while (link.firstChild) {
        parent.insertBefore(link.firstChild, link);
        }
        parent.removeChild(link);
        return;
    }

    // Cas 2 : pas encore de lien → on en crée un
    const url = prompt("Entrez l'URL :", "http://");
    if (!url) return;

    const content = range.extractContents();
    const a = document.createElement('a');
    a.href = url;
    a.target = "_blank";
    a.appendChild(content);

    range.insertNode(a);
}

// Cleaning function
// CSS conseillé pour afficher les retours à la ligne
// div[contenteditable] { white-space: pre-wrap; }

document.addEventListener('paste', function(e) {
    const target = e.target;
    if (!(target instanceof Element)) return;

    // Vérifie si on est dans un contenteditable
    if (!target.closest('[contenteditable="true"]')) return;

    e.preventDefault();

    const cd = e.clipboardData || window.clipboardData;
    let text = cd ? cd.getData('text/plain') : '';

    // Normalise les retours à la ligne
    text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');

    const sel = window.getSelection();
    if (!sel || !sel.rangeCount) return;
    const range = sel.getRangeAt(0);
    range.deleteContents();

    // Insère le texte brut (les \n seront visibles grâce à pre-wrap)
    const textNode = document.createTextNode(text);
    range.insertNode(textNode);

    // Replace le curseur après le texte inséré
    range.setStartAfter(textNode);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
});


document.addEventListener("DOMContentLoaded", function() {
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightbox-img");
  const lightboxCaption = document.getElementById("lightbox-caption");
  const closeBtn = document.querySelector(".lightbox .close");
  const contribLink = document.getElementById("contrib-link"); // NEW

  document.querySelectorAll(".object_picture").forEach(img => {
    img.addEventListener("click", function(e) {
      // Always prevent navigation if the image is wrapped in <a>
      if (this.closest("a")) e.preventDefault();

      lightbox.style.display = "block";
      lightboxImg.src = this.src;

      // caption
      const captionFromData = this.dataset.caption && this.dataset.caption.trim();
      let captionFromDom = "";
      const picture = this.closest(".picture");
      if (picture) {
        const p = picture.querySelector(".caption");
        if (p) captionFromDom = p.textContent.trim();
      }
      lightboxCaption.textContent = captionFromData || captionFromDom || "";

      // contributor link handling
      if (this.dataset.link) {
        contribLink.style.display = "block";
        contribLink.href = this.dataset.link;
      } else {
        contribLink.style.display = "none";
        contribLink.removeAttribute("href");
      }
    });
  });

  closeBtn.onclick = function() {
    lightbox.style.display = "none";
  };
  lightbox.onclick = function(e) {
    if (e.target === lightbox) lightbox.style.display = "none";
  };
});

// Fonction de filtre (générique)
function applyAllFilters(tableId) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    const filters = [];

    // Récupérer tous les filtres actifs
    document.querySelectorAll(`.filter-${tableId}`).forEach(input => {
        const val = input.value.trim().toLowerCase();
        if (val !== '') {
            filters.push({ col: input.dataset.col, value: val });
        }
    });

    rows.forEach(row => {
        let visible = true;

        // Vérifier chaque filtre
        for (const filter of filters) {
            if (filter.col === 'all') {
                // Recherche globale
                let match = false;
                Array.from(row.cells).forEach(cell => {
                    const sortText = (cell.getAttribute('sort-text') || '').toLowerCase();
                    const cellText = cell.textContent.toLowerCase();
                    if (sortText.includes(filter.value) || cellText.includes(filter.value)) {
                        match = true;
                    }
                });
                if (!match) {
                    visible = false;
                    break;
                }
            } else {
                // Filtre par colonne
                const colIndex = parseInt(filter.col);
                const cell = row.cells[colIndex];
                if (!cell) {
                    visible = false;
                    break;
                }
                const sortText = (cell.getAttribute('sort-text') || '').toLowerCase();
                const cellText = cell.textContent.toLowerCase();
                if (!(sortText.includes(filter.value) || cellText.includes(filter.value))) {
                    visible = false;
                    break;
                }
            }
        }
        row.style.display = visible ? '' : 'none';
    });
}

// Check le type de contenu, et ajoute dans un élément du DOM en fonction
// Le contenu peut être un objet, une array d'objets, ou un string.
function insertElement (domElement, content) {
    if (!content) {
        return domElement;
    }
    if (Array.isArray(content)) {
        content.forEach(el => {
            if (el) {
                domElement.appendChild(el);
            }
        });
    } else if (content instanceof Element) {
        domElement.appendChild(content);
    } else {
        domElement.innerHTML = content;
    }
    return domElement;
}

// Fonction création du bloc
// Le contenu peut être un objet, une array d'objets, ou un string.
function addToDiv(content, mb = 3, id=null) {
    const div = document.createElement('div');
    if (mb > 0) {
        div.classList.add('mb-' + mb);
    }
    if (id) {
        div.id = id;
    }
    return insertElement(div, content);
}

// Fonction pour enlever le modal précédent et ajouter le nouveau modal
function addModal(modal) {
    // Récupère l'emplacement du modal
    const divModal = document.getElementById('div-modal');
    // Supprime l'ancien modal
    divModal.innerHTML = '';

    // Ajoute le nouveau modal
    divModal.appendChild(modal);

    // Création de la logique modal de bootstrap
    const bsModal = new bootstrap.Modal(modal);

    // Ouverture du modal
    bsModal.show();
}

// Ferme le modal, si nécessaire après l'accomplissement d'une fonction
function closeModal (modalId) {
    const divModal = document.getElementById(modalId);
    const modal = bootstrap.Modal.getInstance(divModal);
    modal.hide();
}

// Création de modal
function createModal (id, header, content, buttons) {
    const item = document.createElement('div');
    item.classList.add('modal', 'fade');
    item.id = id;
    item.tabIndex = -1;
    item.setAttribute('aria-labelledby', id + '_label');
    item.setAttribute('aria-hidden', 'true');

    const modalDialog = document.createElement('div');
    modalDialog.classList.add('modal-dialog', 'modal-lg');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const headerDiv = document.createElement('div');
    headerDiv.classList.add('modal-header');
    const title = document.createElement('h5');
    title.classList.add('modal-title');
    title.id = id + '_label';
    title.innerHTML = header;
    const titleBtn = document.createElement('button');
    titleBtn.type = 'button';
    titleBtn.classList.add('btn-close');
    titleBtn.setAttribute('data-bs-dismiss', 'modal');
    titleBtn.setAttribute('aria-label', 'Close');
    headerDiv.append(title, titleBtn);

    let contentDiv = document.createElement('div');
    contentDiv.classList.add('modal-body');
    contentDiv = insertElement(contentDiv, content);

    let btnDiv = document.createElement('div');
    btnDiv.classList.add('modal-footer');
    btnDiv = insertElement(btnDiv, buttons)

    modalContent.append(headerDiv, contentDiv, btnDiv);
    modalDialog.append(modalContent);
    item.append(modalDialog);

    return item;
}

function loadingSpinner (id) {
    const div1 = document.createElement('div');
    div1.id = id;
    div1.classList.add('text-center', 'my-3');
    div1.style.display = 'none';
    const div2 = document.createElement('div');
    div2.classList.add('spinner-border', 'text-primary');
    div2.role = 'status';
    const span = document.createElement('span');
    span.classList.add('visually-hidden');
    span.textContent = 'Loading...';
    div2.appendChild(span);
    div1.appendChild(div2);
    return div1;
}

function accordionItem (title, content, id, accordionId, collapsed = false) {
    const header = document.createElement('h2');
    header.classList.add('accordion-header');
    const titleBtn = document.createElement('button');
    titleBtn.classList.add('accordion-button');
    if (collapsed) {
        titleBtn.classList.add('collapsed');
        titleBtn.setAttribute('aria-expanded', 'false');
    } else {
        titleBtn.setAttribute('aria-expanded', 'true');
    }
    titleBtn.type = 'button';
    titleBtn.setAttribute('data-bs-toggle', 'collapse');
    titleBtn.setAttribute('data-bs-target', '#' + id + '-collapse');
    titleBtn.setAttribute('aria-controls', id + '-collapse');
    titleBtn.textContent = title;
    header.appendChild(titleBtn);
    const collapseDiv = document.createElement('div');
    collapseDiv.id = id + '-collapse';
    collapseDiv.classList.add('accordion-collapse', 'collapse');
    if (!collapsed) {
        collapseDiv.classList.add('show');
    }
    collapseDiv.setAttribute('data-bs-parent', '#' + accordionId);
    let contentDiv = document.createElement('div');
    contentDiv.classList.add('accordion-body');
    contentDiv.id = id;
    if (content) {
        contentDiv = insertElement(contentDiv, content); 
    }
    collapseDiv.appendChild(contentDiv);
    const itemDiv = addToDiv([header, collapseDiv], 0);
    itemDiv.classList.add('accordion-item');
    itemDiv.id = 'accordion-' + id;
    return itemDiv;
}

function accordion (id, content) {
    const div = addToDiv(content, 3, id);
    div.classList.add('accordion');
    return div;
}