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
                    foreach ($projects as $p) {
                        if ($p->contributor_rights()) {
                            echo h(3, $p->code());
                            echo h(5, $p->name());
                            echo $p->credits();
                            echo "<br>";
                            $p->image('logo');
                            $p->description('display');
                            echo "<p><a href='" . $p->url('main') . "'>" . ucfirst(thesaurus("click_project")) . "</a></p>";
                        }
                    }
                    ?>
            <?php endif ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>