<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!ISOLATED_WEBSITE && !PROJECT && !$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (!ISOLATED_WEBSITE && PROJECT && !PROJECT->contributor_rights()) {
        $error_message = 'not_project_contributor';
    } elseif (isset($_POST['object'])) {
        // Add user as owner
        $_POST['object']['owner'] = $_SESSION['user']->id();
        if (PROJECT) {
            $_POST['object']['project'] = PROJECT->id();
        } else {
            $_POST['object']['project'] = 0;
        }
        // Create new file object with data (except file)
        $file = new File($_POST['object']);
        // Import file
        $file->update_file();
        $title = ucfirst(thesaurus('upload file'));
    } else {
        $file = new File();
        $title = ucfirst(thesaurus('upload file'));
    }

    if ($_POST && !$error_message) {
        $success = $file->save();
        if ($success) {
            header('Location: ' . create_url_proj(['files']));
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

                $file->display_errors();
                
                // Initiate form
                $file->form('begin', true);
                    echo '<br>';
                    echo p($file->input('type', 'file_type'));
                    // Add file
                    echo p($file->upload());
                    echo p($file->input_text('descr', 'file_descr', true, false, false, false));
                    echo p($file->input_checkbox('public', 'file_public', false));
                $file->form('end');
                // Add script
                echo ($file->input_text('descr', 'file_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>