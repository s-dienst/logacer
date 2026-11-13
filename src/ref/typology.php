<?php
    /* Récupère les données de la typologie */
    $error_message = false;
    $typology = Typology::find_by_id($params['idtypology']);
    if ($typology) {
        /* Initialise le titre */
        $title = $typology->codename();
        /* Check les catégories */
        $categories = Category::linked('typology', 'category', $typology->id());
        if (!$typology->public() && !typology->contributor_rights()) {
            $error_message = 'non_public_typology';
        } elseif (PROJECT) {
            if (!in_array($typology, Typology::linked_with_project())) {
                $error_message = 'no_typology';
            }
        } elseif ($typology->project()) {
            $error_message = 'not_global_typology';
        }
    } else {
        $error_message = 'no_typology';
    }

    if ($_POST && !$error_message) {

        $typology->check_post();

        $typology->manage_contributors('back');
        $typology->manage_bibliography('back');
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $typology->delete($typology->url('parent'), ['type']);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {

                // Buttons for the typology
                $typology->buttons_contrib();

                // Informations about the typology
                $typology->codename('title');
                $typology->owner();
                echo "<br><br>";
                $typology->display_errors();

                    // Show and manage contributors
                    $typology->manage_contributors('front');

                if (PROJECT && !$typology->project()) {
                    $typology->main_page_project();
                }

                // Navigation tabs
                $nav = [];
                $nav_tabs = 3;
                if ($typology->contributor_rights() || $typology->description() || count(Bibliography::linked('typology', 'bibliography', $typology->id())) > 0) {
                    $nav[] = 'description';
                    $nav_tabs = 1;
                }
                if (count($categories) > 0 || $typology->contributor_rights()) {
                    $nav[] = 'categories';
                    if ($nav_tabs == 3) {
                        $nav_tabs = 2;
                    }
                }
                $nav[] = 'types';
                
                if ($nav_tabs == 1) {
                    echo nav_tabs($nav);
                    echo "<div id='div_1' style='display:block'><br>";
                } else {
                    if ($nav_tabs == 2) {
                        echo nav_tabs($nav);
                    }
                    echo "<div id='div_1' style='display:none'><br>";
                }

                    // Informations about the typology
                    $typology->description('display');

                    // Show and manage bibliography
                    echo h(3, ucfirst(thesaurus("bibliography")));
                    $typology->manage_bibliography('front');

                echo "</div>";

                // Manage categories
                if ($nav_tabs == 2) {
                    echo "<div id='div_1' style='display:block'><br>";
                } elseif (count($categories) > 0 || $typology->contributor_rights()) {
                    echo "<div id='div_2' style='display:none'><br>";
                } else {
                    echo "<div style='display:none'><br>";
                }

                    // Button 'modify categories'
                    if ($typology->contributor_rights()) {
                        echo "<a class ='btn btn-outline-secondary' href='" . $typology->url('update_category') . "'>" . ucfirst(thesaurus('modify') . ' ' . thesaurus('the categories')) . "</a><br><br>";
                    }

                    echo h(3, ucfirst(thesaurus('linked categories')));


                    // List of categories
                    echo "<ul>";
                        foreach ($categories as $category) {
                            echo li($category->codename());
                        }
                    echo "</ul>";
    
                echo "</div>";

                // Display types
                if ($nav_tabs == 3) {
                    echo "<div id='div_" . count($nav) . "' style='display:block'><br>";
                } else {
                    echo "<div id='div_" . count($nav) . "' style='display:none'><br>";
                }
                
                // Manage types
                $types = Type::find_by_parent($typology->id(), ['code']);
                if (count($types) > 0 || $typology->contributor_rights()) {
                    echo h(3, ucfirst(thesaurus('the types'))) . "<ul>";
                    foreach ($types as $type) {
                        if (!$type->supertype()) {
                            echo li($type->hyperlink());
                        }
                    }
                    if ($typology->contributor_rights()) {
                        echo li("<a class ='btn btn-secondary btn-sm' href='" . $typology->url('new_type') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a type") . "</a>");
                    }
                    echo "</ol>";
                }

                echo "</div>";

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'Typology';
                    $comment_id = $typology->id();
                    require_once('../users/comments.php');
                }

                $typology->cite_page();
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>