<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (isset($params['idproject'])) {
        /* Récupère les informations du projet */
        $project = Project::find_by_id($params['idproject']);
        if (!$project) {
            $error_message = 'no_project';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $project->id();
            $project = new Project($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $project->name();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $project->name();
        }
    } elseif (isset($_POST['object'])) {
        $project = new Project($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('project'));
    } else {
        $project = new Project();
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('project'));
    }

    if (!$error_message) {
        if (!$project->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $project->save();
        if ($success) {
            header('Location: ' . $project->url());
            exit();
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
                
                echo h(2, $title);

                $project->display_errors();
                
                // Initiate form
                $project->form('begin');
                    echo '<br>';
                    echo h(4, $project->input('code', 'project_code'));
                    echo h(4, $project->input('name', 'project_name'));
                    $project->owner(); echo "<br><br>";
                    echo ($project->input_text('descr', 'project_descr'));
                $project->form('end');
                // Add script
                echo ($project->input_text('descr', 'project_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>