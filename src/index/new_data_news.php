<?php
    $error_message = false;

    if (PROJECT) {
        $project_id = PROJECT->id();
    } else {
        $project_id = 0;
    }
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!PROJECT && !$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (PROJECT && !PROJECT->contributor_rights()) {
        $error_message = 'not_contributor';
    } elseif (isset($params['idnews'])) {
        /* Récupère les informations de la référence */
        $news = News::find_by_id($params['idnews']);
        if (!$news || (PROJECT && $news->project()->id() != $project_id) || (!PROJECT && $news->project())) {
            $error_message = 'no_news';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $news->id();
            $_POST['object']['project'] = $project_id;
            $news = new News($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $news->title();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $news->title();
        }
    } elseif (isset($_POST['object'])) {
        $_POST['object']['project'] = $project_id;
        $news = new News($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('news'));
    } else {
        $news = new News(['project'=>$project_id]);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('news'));
    }

    if (!$error_message) {
        if (!$news->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $news->save();
        if ($success) {
            header('Location: ' . $news->url());
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

                $news->display_errors();
                
                // Initiate form
                $news->form('begin');
                    echo '<br>';
                    echo h(4, $news->input('title', 'news_title'));
                    $news->owner(); echo "<br><br>";
                    echo ($news->input_text('content', 'news_content'));
                $news->form('end');
                // Add script
                echo ($news->input_text('content', 'news_content', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>