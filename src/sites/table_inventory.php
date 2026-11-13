<?php
// Bouton pour chargement
if (isset($objects_count)) {
    if (!isset($params_objects)) {
        $params_objects=['mode' => false, 'loaded' => 999999];
    }
    if ($objects_count > $params_objects['loaded']) {
        echo "<br><p>";
        echo "<span class='objects-counter'>"
            . $params_objects['loaded'] . "/" . $objects_count
            . " " . thesaurus('objects loaded') . "</span> ";
        echo "<button type='button' class='btn btn-secondary btn-sm btn-load-more'
            data-params='" . json_encode($params_objects) . "'>"
            . ucfirst(thesaurus('load more')) . "</button>";
        echo "</p>";
    }
}

echo p(ucfirst(thesaurus('can sort by clicking headers')));

// Filtres etc.
if (isset($context)) { $biblio_review = ($context->biblio_review() || $context->related_phase()->biblio_review() || $context->related_phase()->related_site()->biblio_review()); } else { $biblio_review = false; }
filter_box($cols, 'inventory_table', $biblio_review);

// Table
if (isset($is_small)) {
    echo "<table class='table table-sm' id='inventory_table' style='font-size:small'><thead>";
} else {
    echo "<table class='table' id='inventory_table'><thead>";
}
    table_headers($cols, 'inventory_table');
echo "</thead><tbody>";
    foreach ($objects as $object) { echo '<tr>';
        foreach ($cols as $col) {
            echo $object->$col('table');
        }
    echo '</tr>'; }
echo "</tbody></table>";

// Bouton pour chargement
if (isset($objects_count)) {
    if (!isset($params_objects)) {
        $params_objects=['mode' => false, 'loaded' => 999999];
    }
    if ($objects_count > $params_objects['loaded']) {
        echo "<p>";
        echo "<span class='objects-counter'>"
            . $params_objects['loaded'] . "/" . $objects_count
            . " " . thesaurus('objects loaded') . "</span> ";
        echo "<button type='button' class='btn btn-secondary btn-sm btn-load-more'
            data-params='" . json_encode($params_objects) . "'>"
            . ucfirst(thesaurus('load more')) . "</button>";
        echo "</p>";
    }
}
?>

<script>
document.querySelectorAll('.btn-load-more').forEach(btn => {
    btn.addEventListener('click', async function () {
        let params = JSON.parse(btn.dataset.params);

        params.project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;

        btn.disabled = true;

        // Envoi en POST JSON
        const result = await fetch('/static/ajax/load_more_objects.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(params)
        });

        if (!result.ok) {
            console.error("Erreur serveur", result.status);
            return;
        }

        const data = await result.json();

        // Ajouter les nouvelles lignes dans le tableau
        document.querySelector('#inventory_table tbody')
            .insertAdjacentHTML('beforeend', data.html);

        // Mise à jour de l'offset
        params.offset = data.offset;
        params.loaded = data.loaded;
        // Mise à jour du compteur
        document.querySelectorAll('.objects-counter').forEach(span => {
            span.textContent = params.loaded + "/" + params.total + " objets chargés";
        });
        // Mise à jour du bouton
        document.querySelectorAll('.btn-load-more').forEach(b => {
            b.dataset.params = JSON.stringify(params);

            // Vérifier si on a atteint le total
            if (params.loaded >= params.total) {
                b.remove();
            } else {
                b.disabled = false
            }
        })
    })
})
</script>