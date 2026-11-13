<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $typology = Typology::find_by_id($params['idtypology']);
        if ($typology) {
            if (isset($params['codetype'])) {
                /* Récupère les informations du type */
                $type = Type::find_by_code(dec_sl($params['codetype']));
                if (!($type && $type->typology() == $typology)) {
                    $error_message = 'no_type';
                } elseif (isset($_POST['object'])) {
                    $_POST['object']['typology'] = $typology->id();
                    $_POST['object']['id'] = $type->id();
                    $type = new Type($_POST['object']);
                    /* Initialise le site */
                    $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $type->codename();
                } else {
                    /* Initialise le site */
                    $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $type->codename();
                }
                
            } elseif (isset($_POST['object'])) {
                $_POST['object']['typology'] = $typology->id();
                $type = new Type($_POST['object']);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('type'));
            } else {
                if (isset($params['codesupertype'])) {
                    $supertype = Type::find_by_code(dec_sl($params['codesupertype']));
                    $args = ['typology'=>$typology->id(), 'supertype'=>$supertype->id()];
                } else { $args = ['typology'=>$typology->id()]; }
                $type = new Type($args);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('type'));
            }
        } else {
            $error_message = 'no_typology';
        }
        
    }

    if (!$error_message) {
        if (!$type->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $type->save();
        if ($success) {
            header('Location: ' . $type->url());
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
                $type->display_errors();
                
                echo h(2, $title);

                // Initiate form
                $type->form('begin');
                    echo '<br>';
                    echo '<h4>' . $type->input('code', 'type_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $type->input('name', 'type_name', false) . '</h4>';
                    echo p(ucfirst(thesaurus('typology')) . thesaurus(':') . ' ' . $typology->hyperlink() . ".");
                    $typology->owner(); $type->owner(); echo "<br><br>";
                    echo p($type->input('supertype', 'type_supertype'));
                    echo ($type->input_text('descr', 'type_descr'));
                    echo ($type->input_text('dating', 'type_dating'));
                    echo p($type->input_checkbox('onicer', 'type_onicer'));
                $type->form('end');
                // Add script
                echo ($type->input_text('descr', 'type_descr', true, false, true));
                echo ($type->input_text('dating', 'type_dating', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>