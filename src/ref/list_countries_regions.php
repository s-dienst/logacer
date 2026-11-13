<?php
    $title = ucfirst(thesaurus('list of the countries and regions'));
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php
            // New country or region
            if (isset($_SESSION['user'])) { if ($_SESSION['user']->is_contributor()) {
                echo "<div class='btn-group'>";
                    echo "<a class='btn btn-outline-success' href='" . create_url_proj(['geography', 'new', 'country']) . "'>" . ucfirst(thesaurus('new')) . " " . thesaurus("country") . "</a>";
                    echo "<a class='btn btn-outline-success' href='" . create_url_proj(['geography', 'new', 'region']) . "'>" . ucfirst(thesaurus('new')) . " " . thesaurus("region") . "</a>";
                echo "</div>";
                echo "<br><br>";
            }}

            echo h(2, $title);
            $all_countries = Country::find_all();
            foreach ($all_countries as $single_country) {
                echo h(5, $single_country->codename() . $single_country->modify_contrib());
                $all_regions = Region::find_by_parent($single_country->id());
                echo "<ul>";
                foreach ($all_regions as $single_region) {
                    echo li($single_region->code() . " - " . $single_region->name() . $single_region->modify_contrib());
                }
                echo "</ul>";
            }
            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>