<!-- Add new fabric -->
<?php if (isset($_SESSION['user'])) { if ($_SESSION['user']->is_contributor()) {
    if (ISOLATED_WEBSITE) {
        button_new('fabric', ['fabrics', 'new']);
    } elseif (PROJECT) {
        button_new('fabric', [PROJECT->code(), 'fabrics', 'new']);
    } else {
        button_new('fabric', ['logacer', 'fabrics', 'new']);
    }
}}

// List of the fabrics
echo h(2, $title);

echo "<ul>";
foreach ($fabrics as $fabric) {
    if (PROJECT && !$fabric->project()) {
        echo li($fabric->hyperlink() . " (" . thesaurus("global_fabric") . ")");
    } else {
        echo li($fabric->hyperlink());
    }
}
echo "</ul>";
?>