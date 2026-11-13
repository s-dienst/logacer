<h2><?php echo $title; ?></h2>

<!-- Add new facies -->
<?php if (ISOLATED_WEBSITE) {
    button_new('facies', ['horizons', 'new']);
} else {
    button_new('facies', [PROJECT->code(), 'horizons', 'new']);
}

// List of facies
foreach ($countries as $country => $regions) {
    echo h(3, $country);
    foreach ($regions as $region => $faciess) {
        echo h(5, $region);
        echo '<ul>';
        foreach ($faciess as $facies) {
            $html = $facies->hyperlink($facies->codename());
            if (!$facies->public()) {
                $html .= ' (' . b(thesaurus('non_public')) . ')';
            }
            echo li($html);
        }
        echo '</ul>';
    }
}
echo h(3, ucfirst(thesaurus('no country')));
echo h(5, ucfirst(thesaurus('no region')));
echo '<ul>';
    foreach ($no_region as $facies) {
        $html = $facies->hyperlink($facies->codename());
        if (!$facies->public()) {
            $html .= ' (' . b(thesaurus('non_public')) . ')';
        }
        echo li($html);
    }
echo '</ul>';
?>