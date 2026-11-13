<!-- Add new typology -->
<?php if (isset($_SESSION['user'])) { if ($_SESSION['user']->is_contributor()) {
    if (ISOLATED_WEBSITE) {
        button_new('typology', ['typology', 'new']);
    } elseif (PROJECT) {
        button_new('typology', [PROJECT->code(), 'typology', 'new']);
    } else {
        button_new('typology', ['logacer', 'typology', 'new']);
    }
}}

// List of the typologies
echo h(2, $title);

foreach ($categories as $category=>$typologies) {
    if ($category != "ZZZZZ") {
        echo h(3, Category::find_by_code($category)->codename());
    } else {
        echo h(3, ucfirst(thesaurus('without category')));
    }
    echo "<ul>";
    foreach ($typologies as $typology) {
        if (PROJECT && !$typology->project()) {
            echo li($typology->hyperlink() . " (" . thesaurus("global_typology") . ")");
        } else {
            echo li($typology->hyperlink());
        }
    }
    echo "</ul>";
}
?>