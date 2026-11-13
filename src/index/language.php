<?php
    if ($_POST) {
        $language = $_POST['language'];
        setcookie(
            'logacer_language',
            $language,
            [
                'expires'  => time() + 365 * 24 * 60 * 60,
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        $return_url = $_SESSION['language_return_url'] ?? '/';
        unset($_SESSION['language_return_url']);
        // Petite sécurité : on n'autorise ici qu'une URL locale.
        if (
            !str_starts_with($return_url, '/') ||
            str_starts_with($return_url, '//')
        ) {
            $return_url = '/';
        }
        header('Location: ' . $return_url);
        exit;
    }

    $suggested_language = get_browser_language();
    $selected = $suggested_language;
    if (!$suggested_language) {
        $suggested_language = 'en';
    }

    $title = ucfirst(thesaurus("choose_language"));
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container" style="text-align:center">

            <h1><?php echo ucfirst(thesaurus("choose_language")); ?></h1>

            <?php if (STATUS_INSTALLATION === 'validated') { ?>
                <form action="<?php echo create_url(['language']); ?>" method="post">
            <?php } else { ?>
                <form action="" method="post">
            <?php } ?>

                <?php
                if (defined('SUPPORTED_LANGUAGES')) {
                    $all_langs = SUPPORTED_LANGUAGES;
                } else {
                    $all_langs = ALL_LANGUAGES;
                }
                foreach ($all_langs as $name => $code) {
                    if ($code === $selected) {
                        $checked = " btn-secondary";
                    } else {
                        $checked = "btn-outline-secondary";
                    }
                    echo "<p><button class='btn " . $checked . "' name='language' type='submit' value='" . $code . "' style ='width:300px; height:50px;'>" . $name . "</button></p>";
                } ?>
            </form>

        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>