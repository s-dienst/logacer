<?php

/*function db_connect() {
    $db = "mysql:host=". DB_SERVER . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
    try {
        $connexion = new PDO($db, DB_LOGIN, DB_PASS);
    } catch (PDOException $e) {
        echo 'Echec de la connexion : ' . $e -> getMessage();
    }
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connexion;
}*/

function check_max_char(string $string, int $n_char, string $name) {
    if (strlen($string) > $n_char) {
        return err_max_char($n_char, $name);
    }
}

/**
 * Check caractères minimums et retourne une erreur si c'est le cas (string), false si c'est OK
 * 
 * @param $name must be a name with defined article
 */
function check_min_char(string $string, int $_char, string $name) {
    if (strlen($string) < $n_char) {
        return err_min_char($n_char, $name);
    }
}

/**
 * Check si complété, retoure une erreur si c'est blanc (string), false si c'est OK
 * 
 * @param $name must be a name with undefined article
 */
function check_blank(string $string, string $name) {
    if (strlen(trim($string)) === 0) {
        return err_blank($name);
    }
}

function check_range($number, string $name, $min=false, $max=false) {
    if ($min !== false) { if($number < $min) {
        return err_min($min, $name);
    }}
    if ($max !== false) { if ($number > $max) {
        return err_max($max, $name);
    }}
}

function check_exists(int $id, string $classname) {
    if ($id) {
        if (!ucfirst($classname)::find_by_id($id)) {
            return err_exists($classname);
        }
    }
}

function check_forbidden(string $verified, string $property, array $forbidden_names) {
    if (in_array(strtolower($verified), $forbidden_names)) {
        return err_forbidden($verified, $property);
    }
}

function check_characters(string $verified, string $property, string $preg) {
    if (!preg_match($preg, $verified)) {
        return err_characters($property);
    }
}

function add_error($array, $error) {
    if ($error) {
        $array[] = $error;
    }
    return $array;
}

function display_fatal_error(string $fatal_error, array $suppl_args = array()) {
    if (strlen($fatal_error) > 0) {
        $html = '<br><div class="alert alert-danger">';
        $html .= err_fatal($fatal_error, $suppl_args);
        $html .= '</div><br>';
        echo $html;
    } else {
        return false;
    }
}

// Crée les marqueurs pour la carte
function mapmarkers($sites, $typemarker = 'site') {
    // Prepare variables
    $markers = [];
    $sites_grouped = [];
    $long_min = 180.0;
    $long_max = -180.0;
    $lat_min = 90.0;
    $lat_max = -90.0;
    foreach ($sites as $site) {
        // Gère les bords de la carte
        if ($site->coord_lat() && $site->coord_long()) {
            if ($site->coord_long() < $long_min) {
                $long_min = $site->coord_long();
            }
            if ($site->coord_long() > $long_max) {
                $long_max = $site->coord_long();
            }
            if ($site->coord_lat() < $lat_min) {
                $lat_min = $site->coord_lat();
            }
            if ($site->coord_lat() > $lat_max) {
                $lat_max = $site->coord_lat();
            }
        }
        // Regroupe les sites avec les mêmes coordonnées
        $key = $site->coord_lat() . ', ' . $site->coord_long();
        if (!isset($sites_grouped[$key])) {
            $sites_grouped[$key] = [];
        }
        $sites_grouped[$key][] = $site;
    }
    // Crée la liste de sites
    foreach ($sites_grouped as $key=>$site) {
        $sites_list = [];
        foreach ($site as $c) {
            // Calcul du nom en fonction du type d'objet
            if ($typemarker === 'phase') {
                $name = $c->related_site()->name() . ' - ' . $c->name();
            } else {
                $name = $c->name();
            }
            // Gestion différente si il y a un compte d'objets
            if ($c->object_count() === 0) {
                $sites_list[] = ['id'=>$c->id(), 'url'=>$c->url(), 'name'=>$name];
            } else {
                $sites_list[] = ['id'=>$c->id(), 'url'=>$c->url(), 'name'=>$name, 'count'=>$c->object_count()];
            }
            // Ajoute à une liste pour assurer qu'un site soit pas compté plusieurs fois
            $doubles[] = $c->id();
        }
        // Ajouter aux marqueurs
        $markers[] = ['sites'=>$sites_list, 'lat'=>$site[0]->coord_lat(), 'long'=>$site[0]->coord_long()];
    }
    $boundaries = [[$lat_min, $long_min], [$lat_max, $long_max]];
    return [$markers, $boundaries];
}


/**
 * Établit une connexion à un serveur MySQL/MariaDB.
 *
 * @param array $config Paramètres de connexion.
 * @param bool $select_database Indique si une base doit être sélectionnée.
 *
 * @return PDO
 * @throws PDOException En cas d'échec de connexion.
 * @throws RuntimeException En cas de configuration TLS invalide.
 */
function db_connect(array $config = [], bool $select_database = false): PDO
{
    if (empty($config) && STATUS_INSTALLATION !== 'validated') {
        error_log(
            'DB_CONNECT WITHOUT CONFIG : ' .
            print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3), true)
        );
    }
    if (STATUS_INSTALLATION === 'validated') {
        $host = DB_SERVER;
        $port = DB_PORT;
        $database = DB_NAME;
    } else {
        $host = $config['db_server'];
        $port = (int) $config['db_port'];
        $database = $select_database ? $config['db_name'] : null;
    }

    // Construction du DSN
    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";

    if ($database !== null) {
        $dsn .= ";dbname={$database}";
    }

    // Options PDO
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ];

    // Paramètres TLS/SSL
    if (STATUS_INSTALLATION === 'validated') {
        if (DB_TLS_SSL) {

            // Vérification de la disponibilité du support SSL
            if (!defined('PDO::MYSQL_ATTR_SSL_CA')) {
                throw new RuntimeException(
                    "invalid_ssl_pilot"
                );
            }

            // Certificat de l'autorité de certification
            if (defined('DB_SSL_CA')) {
                if (!is_readable(DB_SSL_CA)) {
                    throw new RuntimeException(
                        "invalid_ssl_ca"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_CA] = DB_SSL_CA;
            }

            // Certificat client
            if (defined('DB_SSL_CERT')) {
                if (!is_readable(DB_SSL_CERT)) {
                    throw new RuntimeException(
                        "invalid_ssl_cert"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_CERT] = DB_SSL_CERT;
            }

            // Clé privée du certificat client
            if (defined('DB_SSL_KEY')) {
                if (!is_readable(DB_SSL_KEY)) {
                    throw new RuntimeException(
                        "invalid_ssl_key"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_KEY] = DB_SSL_KEY;
            }

            // Vérification du certificat présenté par le serveur
            if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }
        }

        // Connexion
        return new PDO(
            $dsn,
            DB_LOGIN,
            DB_PASS,
            $options
        );

    } else {
        if (!empty($config['db_tls_ssl'])) {

            // Vérification de la disponibilité du support SSL
            if (!defined('PDO::MYSQL_ATTR_SSL_CA')) {
                throw new RuntimeException(
                    "invalid_ssl_pilot"
                );
            }

            // Certificat de l'autorité de certification
            if (!empty($config['db_ssl_ca'])) {
                if (!is_readable($config['db_ssl_ca'])) {
                    throw new RuntimeException(
                        "invalid_ssl_ca"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_CA] = $config['db_ssl_ca'];
            }

            // Certificat client
            if (!empty($config['db_ssl_cert'])) {
                if (!is_readable($config['db_ssl_cert'])) {
                    throw new RuntimeException(
                        "invalid_ssl_cert"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_CERT] = $config['db_ssl_cert'];
            }

            // Clé privée du certificat client
            if (!empty($config['db_ssl_key'])) {
                if (!is_readable($config['db_ssl_key'])) {
                    throw new RuntimeException(
                        "invalid_ssl_key"
                    );
                }

                $options[PDO::MYSQL_ATTR_SSL_KEY] = $config['db_ssl_key'];
            }

            // Vérification du certificat présenté par le serveur
            if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }
        }

        // Connexion
        return new PDO(
            $dsn,
            $config['db_login'],
            $config['db_pass'],
            $options
        );

    }
}


/**
 * Crée une base de données MySQL/MariaDB.
 *
 * @param PDO   $pdo_server Connexion au serveur sans base sélectionnée.
 * @param array $config     Configuration de connexion.
 *
 * @return void
 *
 * @throws RuntimeException En cas de configuration invalide.
 * @throws PDOException En cas d'erreur SQL.
 */
function create_sql_database(PDO $pdo_server, array $config)
{
    $errors = [];

    $database = $config['db_name'];

    // Vérification du nom de la base
    // On limite volontairement les caractères autorisés.
    if (!preg_match('/^[a-zA-Z0-9_]{1,64}$/', $database)) {
        $errors[] = "invalid_db_name";
        return $errors;
    }
    

    // Vérification de l'existence de la base
    $query = $pdo_server->prepare("
        SELECT COUNT(*)
        FROM information_schema.schemata
        WHERE schema_name = :database
    ");

    $query->execute([
        'database' => $database
    ]);

    if ((int) $query->fetchColumn() > 0) {
        $errors[] = ['error'=>'existing_db_name', 'arg'=>$database];
        return $errors;
    }
    

    // Création de la base
    // Le nom ne peut pas être transmis comme paramètre PDO :
    // il est donc encadré par des backticks après validation.

    $pdo_server->exec("
        CREATE DATABASE `$database`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci
    ");

    return $errors;
}


/**
 * Importe un fichier SQL dans une base de données.
 *
 * @param PDO    $pdo      Connexion à la base.
 * @param string $sql_file Chemin du fichier SQL.
 *
 * @return array Liste des erreurs rencontrées.
 */
function import_sql_schema(PDO $pdo, string $sql_file): array
{
    $errors = [];

    // Vérification du fichier
    if (!is_file($sql_file) || !is_readable($sql_file)) {
        return ["sql_install"];
    }

    // Lecture du fichier
    $sql = file_get_contents($sql_file);

    if ($sql === false || trim($sql) === '') {
        return ["sql_install_read"];
    }

    // Suppression des commentaires SQL simples
    $sql = preg_replace('/^\s*--.*$/m', '', $sql);

    // Découpage des instructions
    $queries = array_filter(
        array_map('trim', explode(';', $sql))
    );

    // Exécution des instructions
    foreach ($queries as $index => $query) {

        try {

            $pdo->exec($query);

        } catch (PDOException $e) {

            $errors[] = ['error'=>'execute_sql', 'arg'=>['number'=>($index + 1), 'error'=>$e->getMessage()]];

            // On poursuit pour éventuellement identifier
            // d'autres problèmes dans le fichier.
        }
    }

    return $errors;
}

// Vérification du schéma SQL pour l'installation

function verify_sql_schema(PDO $pdo): array
{
    $errors = [];

    // Vérification de la base sélectionnée
    $database = $pdo->query('SELECT DATABASE()')->fetchColumn();

    if (!$database) {
        return [
            ['database_not_selected']
        ];
    }

    // Requêtes de vérification
    $table_request = $pdo->prepare("
        SELECT COUNT(*)
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = :database
        AND TABLE_NAME = :table
        AND TABLE_TYPE = 'BASE TABLE'
    ");

    $columns_request = $pdo->prepare("
        SELECT COLUMN_NAME
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = :database
        AND TABLE_NAME = :table
    ");

    // Cache des tables et de leurs colonnes
    $table_cache = [];

    $get_table_columns = function (string $table) use ($database, $table_request, $columns_request, &$table_cache) {
        if (isset($table_cache[$table])) {
            return $table_cache[$table];
        }

        $table_request->execute([':database' => $database, ':table' => $table]);

        if (!(bool) $table_request->fetchColumn()) {
            $table_cache[$table] = false;
            return false;
        }

        $columns_request->execute([':database' => $database, ':table' => $table]);

        $columns = $columns_request->fetchAll(PDO::FETCH_COLUMN);

        $table_cache[$table] = array_flip($columns);

        return $table_cache[$table];
    };

    // Tables de liaison déjà vérifiées
    $checked_links = [];

    // Parcours des classes DatabaseObject
    foreach (DATABASE_OBJECTS as $class) {

        if (!class_exists($class) || !is_subclass_of($class, DatabaseObject::class)) {
            $errors[] = ['error' => 'invalid_database_object_class','arg' => $class];
            continue;
        }

        $definition = $class::schema_definition();

        $table = $definition['table'];
        $columns = $definition['columns'];
        $links = $definition['links'];

        // Vérification de l'existence de la table
        $actual_columns = $get_table_columns($table);

        if ($actual_columns === false) {
            $errors[] = ['error' => 'missing_table', 'arg' => $table];
        } else {
            // Vérification des colonnes
            foreach ($columns as $column) {
                if (!isset($actual_columns[$column])) {
                    $errors[] = ['error' => 'missing_column', 'arg' => ['table' => $table, 'column' => $column]];
                }
            }
        }

        // Vérification des tables de liaison : pour l'instant, peut poser des soucis
        /*foreach ($links as $linked_table => $link_column) {

            // Noms possibles de la table de liaison
            $candidates = ['link_' . $table . '_' . $link_column, 'link_' . $link_column . '_' . $table];

            // Suppression des doublons éventuels
            $candidates = array_unique($candidates);

            // Identification unique de cette relation
            $link_key = $candidates;
            sort($link_key);
            $link_key = implode('|', $link_key);

            if (isset($checked_links[$link_key])) {
                continue;
            }

            $checked_links[$link_key] = true;

            // Recherche de la table de liaison
            $existing_links = [];

            foreach ($candidates as $candidate) {
                if ($get_table_columns($candidate) !== false) {
                    $existing_links[] = $candidate;
                }
            }

            if (count($existing_links) === 0) {
                $errors[] = ['error' => 'missing_link_table', 'arg' => $candidates];
                continue;
            }

            // Les deux conventions ne devraient pas coexister
            if (count($existing_links) > 1) {
                $errors[] = ['error' => 'ambiguous_link_table', 'arg' => $existing_links];
                continue;
            }

            // Vérification des colonnes de la table de liaison
            $link_table = $existing_links[0];
            $link_columns = $get_table_columns($link_table);

            foreach ([$table, $link_column] as $column) {

                if (!isset($link_columns[$column])) {
                    $errors[] = ['error' => 'missing_link_column', 'arg' => ['table' => $link_table, 'column' => $column]
                    ];
                }
            }
        }*/
    }

    return $errors;
}
?>