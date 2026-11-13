<?php
    /**
     * Enregistre la configuration dans un fichier JSON.
     *
     * @param array  $config Configuration à enregistrer.
     * @param string $file   Chemin du fichier.
     *
     * @return array Liste des erreurs.
     */
    function save_configuration(array $config, string $file): array
    {
        $errors = [];

        // Vérification du répertoire
        $directory = dirname($file);

        if (!is_dir($directory) || !is_writable($directory)) {
            return ["unwrite_config_dir"];
        }

        // Encodage JSON
        $json = json_encode(
            $config,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            return [['error'=>'invalid_json', 'arg'=>json_last_error_msg()]];
        }

        // Fichier temporaire dans le même répertoire
        $temporary_file = $file . '.tmp';

        // Écriture
        if (file_put_contents($temporary_file, $json, LOCK_EX) === false) {
            return ['error_write_json'];
        }

        // Permissions restrictives
        chmod($temporary_file, 0600);

        // Remplacement du fichier définitif
        if (!rename($temporary_file, $file)) {

            unlink($temporary_file);

            return ['error_convert_json_temp'];
        }

        return $errors;
    }

    
    /**
     * Charge la configuration depuis un fichier JSON.
     *
     * Vérifie son intégrité, compare sa version avec la version
     * actuelle et définit les constantes applicatives.
     *
     * @param string $file Chemin du fichier de configuration.
     *
     * @return array Liste des erreurs.
     */
    function load_configuration(string $file): array
    {
        $errors = [];


        // 1. Vérification de l'existence du fichier
        if (!is_file($file)) {
            define('STATUS_INSTALLATION', 'uninstalled');
            return $errors;
        }

        // 2. Lecture du fichier
        $json = file_get_contents($file);

        if ($json === false) {
            define('STATUS_INSTALLATION', 'broken');

            return ["error_read_json"];
        }

        // 3. Décodage JSON
        $config = json_decode($json, true);

        if (!is_array($config) || json_last_error() !== JSON_ERROR_NONE) {
            define('STATUS_INSTALLATION', 'broken');
            return ['error'=>'error_invalid_json', 'arg'=>json_last_error_msg()];
        }

        // 4. Vérification de la version
        if (!isset($config['version']) || !is_string($config['version'])) {
            define('STATUS_INSTALLATION', 'broken');
            $errors[] = "error_config_version";
        } elseif ($config['version'] !== VERSION) {
            define('STATUS_INSTALLATION', 'to_update');

            $errors[] = "error_config_update";
        }

        // 5. Vérification des paramètres obligatoires
        foreach ([
            'db_server'         => 'DB_SERVER',
            'db_login'          => 'DB_LOGIN',
            'db_pass'           => 'DB_PASS',
            'db_name'           => 'DB_NAME',
            'base_url'          => 'BASE_URL',
            'webmaster_mail'    => 'WEBMASTER_MAIL',
            'smtp_host'         => 'SMTP_HOST',
            'smtp_security'     => 'SMTP_SECURITY',
            'smtp_user'         => 'SMTP_USER',
            'smtp_password'     => 'SMTP_PASSWORD'
        ] as $key=>$const) {
            // Strings
            if (!isset($config[$key])) {
                $errors[] = ['error'=>'not_in_config', 'arg'=>$key];
            } elseif (!is_string($config[$key])) {
                $errors[] = ['error'=>'not_string_config', 'arg'=>$key];
            } elseif (strlen($config[$key]) === 0) {
                $errors[] = ['error'=>'empty_string_config', 'arg'=>$key];
            } else {
                if ($key === 'base_url') {
                    if (substr($config[$key], -1) !== '/') {
                        $config[$key] .= '/';
                    }
                }
                define($const, $config[$key]);
            }
        }

        if (defined('BASE_URL')) {
            define('BASE_STATIC', BASE_URL);
        }

        foreach ([
            'db_tls_ssl'=>'DB_TLS_SSL',
            'isolated_website'=>'ISOLATED_WEBSITE',
            'allow_local_pictures'=>'ALLOW_LOCAL_PICTURES'
        ] as $key=>$const) {
            // Booléens
            if (isset($config[$key])) {
                if ($config[$key]) {
                    define($const, true);
                } else {
                    define($const, false);
                }
            } else {
                $errors[] = ['error'=>'not_in_config', 'arg'=>$key];
            }
        }

        // 6. Vérification des données SSL, si pertinent
        if (DB_TLS_SSL) {
            foreach ([
                'db_ssl_ca'=>'DB_SSL_CA',
                'db_ssl_cert' => 'DB_SSL_CERT',
                'db_ssl_key' => 'DB_SSL_KEY'
            ] as $key=>$const) {
                if (isset($config[$key])) {
                    if ($config[$key] && !is_string($config[$key])) {
                        $errors[] = ['error'=>'not_string_config', 'arg'=>$key];
                    } elseif (strlen($config[$key]) > 0) {
                        define($const, $config[$key]);
                    }
                }
            }
        }

        // 7. Vérification des données facultatives ou avec valeurs par défaut
        if (isset($config['website_name']) && is_string($config['website_name']) && strlen($config['website_name']) > 0) {
            define('WEBSITE_NAME', $config['website_name']);
        } else {
            define('WEBSITE_NAME', 'LOGACer');
        }

        if (isset($config['supported_languages']) && is_array($config['supported_languages']) && count($config['supported_languages']) > 0) {
            $langs = [];
            foreach ($config['supported_languages'] as $name=>$abbr) {
                if (in_array($abbr, ALL_LANGUAGES)) {
                    $langs[$name] = $abbr;
                }
            }
            if (count($langs) > 0) {
                define('SUPPORTED_LANGUAGES', $langs);
            } else {
                define('SUPPORTED_LANGUAGES', ['English' => 'en']);
            }
        } else {
            define('SUPPORTED_LANGUAGES', ['English' => 'en']);
        }

        if (isset($config['smtp_from']) && is_array($config['smtp_from']) && count($config['smtp_from']) > 0) {
            define('SMTP_FROM', $config['smtp_from']);
        } elseif (defined('SMTP_USER')) {
            define('SMTP_FROM', SMTP_USER);
        }

        if (isset($config['smtp_from_name']) && is_array($config['smtp_from_name']) && count($config['smtp_from_name']) > 0) {
            define('SMTP_FROM_NAME', $config['smtp_from_name']);
        } else {
            define('SMTP_FROM_NAME', WEBSITE_NAME);
        }

        $default_values_config = ['max_size_picture'=>500000, 'max_size_file'=>20000000,
            'max_loaded_objects'=>500, 'rows_per_page'=>200, 'db_port'=>3306, 'smtp_port'=>587];
        foreach ([
            'max_size_picture'      => 'MAX_SIZE_PICTURE',
            'max_size_file'         => 'MAX_SIZE_FILE',
            'max_loaded_objects'    => 'MAX_LOADED_OBJECTS',
            'rows_per_page'         => 'ROWS_PER_PAGE',
            'db_port'               => 'DB_PORT',
            'smtp_port'             => 'SMTP_PORT'
        ] as $key => $const) {
            if (isset($config[$key]) && is_int($config[$key]) && $config[$key] > 0) {
                define($const, $config[$key]);
            } else {
                define($const, $default_values_config[$key]);
            }
        }

        // 7. Détermination du statut final
        if (!defined('STATUS_INSTALLATION')) {
            if (!empty($errors)) {
                define('STATUS_INSTALLATION', 'broken');
            } else {
                define('STATUS_INSTALLATION', 'validated');
            }
        } elseif (STATUS_INSTALLATION === 'to_update') {
            // En attendant l'implémentation du système de mise à jour,
            // une configuration ancienne reste inutilisable normalement.
        }

        return $errors;
    }

    define("ENVIRONMENT", "local");
    define("MAX_SIZE_TEMP", 200000000);
    define("ALL_LANGUAGES", [
        'English' => 'en',
        'Français' => 'fr',
        'Italiano' => 'it',
        'Deutsch' => 'de',
        'Español' => 'es']);

    define("VERSION", "2.0");

    define('DATABASE_OBJECTS', [
        AppText::class,
        Bibliography::class,
        Category::class,
        Comment::class,
        ConfigHorizon::class,
        ConfigHorizonType::class,
        Context::class,
        Counting::class,
        Country::class,
        Fabric::class,
        Facies::class,
        File::class,
        FunctionTable::class,
        Horizon::class,
        Modifications::class,
        News::class,
        ObjectTable::class,
        Phase::class,
        Picture::class,
        Project::class,
        Region::class,
        Site::class,
        Type::class,
        Typology::class,
        User::class
    ]);

    // Chargement des paramètres
    $errors = load_configuration(__DIR__ . '/config/configuration.json');

    if (!defined('STATUS_INSTALLATION')) {
        define('STATUS_INSTALLATION', 'broken');
    }

    $action = FALSE;
    $page = $_GET['page'] ?? '404';

    // Changements à effectuer dans CEVICA PROD :
    // Fabric : project->related_project et ajout du champ public
    // Typology : project->related_project
    // app_text : ajout
    // Project : changer complètement
    // News : ajout du champ project
    // File : ajout du champ project
    // Site : project obligatoire ; ajout allow_graphs
    // Facies : project obligatoire ; ajout allow_graphs
    // Comment : ajout
?>