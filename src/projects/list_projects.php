<?php
    $title = ucfirst(thesaurus('list of the projects'));
    $projects = Project::find_all();
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not connected -->
            <?php if(isset($error_message)): ?>
                <br><div class="alert alert-danger"><?php echo $error_message ?></div><br>
            <?php else: ?>
                <h2><?php echo $title; ?></h2>

                    <!-- Add new project -->
                    <?php if (ISOLATED_WEBSITE) {
                        button_new('project', ['project', 'new']);
                    } else {
                        button_new('project', ['logacer', 'project', 'new']);
                    }

                    // List of projects
                    foreach ($projects as $project) {
                        if ($project->public()) {
                            echo h(3, $project->code());
                        } else {
                            echo h(3, $project->code() . ' (' . thesaurus('private') . ')');
                        }
                        echo h(5, $project->name());
                        echo $project->credits();
                        echo "<br>";
                        $project->image('logo');
                        $project->description('display');
                        echo "<p><a href='" . $project->url('main') . "'>" . ucfirst(thesaurus("click_project")) . "</a></p>";
                    }
                    ?>
            <?php endif ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>