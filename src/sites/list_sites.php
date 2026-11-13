<!-- Add new site -->
<?php if (ISOLATED_WEBSITE) {
    button_new('site', ['sites', 'new']);
} else {
    button_new('site', [PROJECT->code(), 'sites', 'new']);
}
 ?>

        <!-- Header of the map -->
        <div id="map_header" class="maindiv container" style="display:block"><br>
            <h2><?php echo $title; ?></h2>
        </div>

        <!-- Button to change between map and tab -->
        <div class="btn-group">
            <button class="btn btn-outline-secondary active" id="show_map"><?php echo ucfirst(thesaurus('map')); ?></button>
            <button class="btn btn-outline-secondary" id="show_list"><?php echo ucfirst(thesaurus('list of the sites')); ?></button>
        </div>

        <!-- Necessary for a good presentation of the map -->
        </div>

        <!-- Map and contents + script -->
        <?php
            $sites = $no_region;
            foreach ($countries as $country => $regions) {
                foreach ($regions as $region => $addsites) {
                    $sites = array_merge($sites, $addsites);
                }
            }
            require("../sites/map.php");
        ?>

        <!-- List of sites -->
        <div class="maindiv container">
        <div id="list" style="display:none"><br>
            <?php
            // Cols
            $cols = ['code', 'name', 'region', 'counting', 'public'];

            filter_box($cols, 'site_table');

            echo "<br>" . p(ucfirst(thesaurus('can sort by clicking headers')));


            // Initiate table
            echo "<table class='table table-sm' id='site_table' style='font-size:small'>";
            echo "<thead>";
                table_headers($cols, 'site_table');
            echo "</thead><tbody>";
                foreach ($countries as $country => $regions) {
                    foreach ($regions as $region => $sites) {
                        foreach ($sites as $site) { echo '<tr>';
                            foreach ($cols as $col) {
                                echo $site->$col('table');
                            }
                        echo '</tr>'; }
                    }
                }
                foreach ($no_region as $site) { echo '<tr>';
                    foreach ($cols as $col) {
                        echo $site->$col('table');
                    }
                echo '</tr>'; }
            echo "</tbody></table>";
    ?>