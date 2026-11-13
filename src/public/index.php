<?php

require_once(__DIR__ . "/../variables.php");

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . "/../log/php-error.log");
if (ENVIRONMENT === "ULIEGE_PROD") {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
error_reporting(E_ALL);

$request_start = microtime(true);

require_once(__DIR__ . "/../layout/functions.php");
require_once(__DIR__ . "/../layout/functions_database.php");
require_once(__DIR__ . "/../layout/functions_html.php");
require_once(__DIR__ . "/../layout/errors.php");
require_once(__DIR__ . "/../layout/thesaurus.php");
require_once(__DIR__ . "/../extensions/altorouter/AltoRouter.php");
require_once(__DIR__ . "/../extensions/parsedown/Parsedown.php");

if (session_status() === PHP_SESSION_NONE && defined('STATUS_INSTALLATION') && STATUS_INSTALLATION === 'validated') {
    session_start();
} else {
    error_log(STATUS_INSTALLATION);
}

/* Amélioration logs :
    Ajout logs AJAX
    Ajout logs Javascript
    Log MySQL enregistré via PDO:ERRMODE_EXCEPTION
    Gestionnaire global d'exceptions PHP (avec par exemple set_exception_handler)
    Logs serveurs web
    Rotation des logs
    Permissions nécessaires : 750 pour le dossier, 640 pour le fichier log
*/

$uri = $_SERVER['REQUEST_URI'];

$router = new AltoRouter();
if (ENVIRONMENT === "OVH") {
    $router->setBasePath('/dbcer_php/public');
}

if (!defined('STATUS_INSTALLATION') || STATUS_INSTALLATION === 'uninstalled') {
    $router->map('GET|POST',    '/',                                    'logacer/installation');
    $router->map('GET|POST',    '/logacer/installation',                'logacer/installation');
} elseif (ISOLATED_WEBSITE) {
    $router->map('GET',         '/',                                    'index/index');
    //$router->map('GET',         '/tuto-user',                           'index/tutorial_user'); // TO DO
    $router->map('GET',         '/search',                              'index/search'); // TO DO
    $router->map('GET|POST',    '/search/results',                      'index/results'); // TO DO
    $router->map('GET',         '/bibliography',                        'index/bibliography_list');
    $router->map('GET|POST',    '/bibliography/[i:idbiblio]',           'index/bibliography');
    $router->map('GET|POST',    '/bibliography/new',                    'index/new_data_bibliography');
    $router->map('GET|POST',    '/bibliography/[i:idbiblio]/update',    'index/new_data_bibliography');
    $router->map('GET|POST',    '/about_us',                            'index/about_us');
    $router->map('GET|POST',    '/news/new',                            'index/new_data_news');
    $router->map('GET|POST',    '/news/update/[i:idnews]',              'index/new_data_news');
    $router->map('GET',         '/legals',                              'index/legals');
    $router->map('GET',         '/logacer',                             'index/logacer');
    $router->map('GET',         '/gdpr',                                'index/gdpr');
    $router->map('GET',         '/partnership',                         'index/partnership');
    $router->map('GET',         '/other_databases',                     'index/other_databases');
    $router->map('GET',         '/other_tools',                         'index/other_tools');
    $router->map('GET|POST',    '/language',                            'index/language');
    $router->map('POST',        '/change_language',                     'index/change_language');

    $router->map('GET',         '/sites',                                                                   'sites/all_sites');
    $router->map('GET',         '/mysites',                                                                 'sites/my_sites');
    $router->map('GET|POST',    '/site/[i:idowner]/[:codesite]',                                            'sites/site');
    $router->map('GET|POST',    '/site/[i:idowner]/[:codesite]/[:codephase]',                               'sites/phase');
    $router->map('GET|POST',    '/site/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',                'sites/context');
    $router->map('GET|POST',    '/object/[i:idobject]',                                                     'sites/object');
    $router->map('GET|POST',    '/sites/new',                                                               'sites/new_data_site');
    $router->map('GET|POST',    '/site/update/[i:idowner]/[:codesite]',                                     'sites/new_data_site');
    $router->map('GET|POST',    '/site/new/[i:idowner]/[:codesite]',                                        'sites/new_data_phase');
    $router->map('GET|POST',    '/site/update/[i:idowner]/[:codesite]/[:codephase]',                        'sites/new_data_phase');
    $router->map('GET|POST',    '/site/new/[i:idowner]/[:codesite]/[:codephase]',                           'sites/new_data_context');
    $router->map('GET|POST',    '/site/update/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',         'sites/new_data_context');
    $router->map('GET|POST',    '/site/new/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',            'sites/new_data_object');
    $router->map('GET|POST',    '/site/update_objects/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]', 'sites/new_data_objects');
    $router->map('GET|POST',    '/object/update/[i:idobject]',                                              'sites/new_data_object');
    $router->map('GET|POST',    '/object/[i:idobject]/new_picture',                                         'sites/new_data_picture');
    $router->map('GET|POST',    '/object/[i:idobject]/[i:idpicture]',                                       'sites/new_data_picture');


    $router->map('GET',         '/horizons',                                    'horizons/all_horizons');
    $router->map('GET',         '/myhorizons',                                  'horizons/my_horizons');
    $router->map('GET|POST',    '/horizons/[i:idfacies]',                       'horizons/facies');
    $router->map('GET|POST',    '/horizons/[i:idfacies]/[i:idhorizon]',         'horizons/horizon');
    $router->map('GET|POST',    '/horizons/new',                                'horizons/new_data_facies');
    $router->map('GET|POST',    '/horizons/update/[i:idfacies]',                'horizons/new_data_facies');
    $router->map('GET|POST',    '/horizons/new/[i:idfacies]',                   'horizons/new_data_horizon');
    $router->map('GET',         '/horizons/new/[i:idfacies]/[i:idsuperhorizon]','horizons/new_data_horizon');
    $router->map('GET|POST',    '/horizons/update/[i:idfacies]/[i:idhorizon]',  'horizons/new_data_horizon');

    $router->map('GET|POST',    '/horizons/compare',                            'horizons_advanced/comparizon_horizon_contexts');
    $router->map('GET|POST',    '/horizons/seriations',                         'horizons_advanced/seriations');

    $router->map('GET',         '/typologies',                                          'ref/all_typologies');
    $router->map('GET',         '/mytypologies',                                        'ref/my_typologies');
    $router->map('GET|POST',    '/typology/[i:idtypology]',                             'ref/typology');
    $router->map('GET|POST',    '/typology/[i:idtypology]/type/[:codetype]',            'ref/type');
    $router->map('GET',         '/fabrics',                                             'ref/all_fabrics');
    $router->map('GET',         '/myfabrics',                                           'ref/my_fabrics');
    $router->map('GET|POST',    '/fabric/[:codefabric]',                                'ref/fabric');
    $router->map('GET|POST',    '/typology/new',                                        'ref/new_data_typology');
    $router->map('GET|POST',    '/typology/[i:idtypology]/update_cat',                  'ref/new_data_typology_cat');
    $router->map('GET|POST',    '/typology/[i:idtypology]/update',                      'ref/new_data_typology');
    $router->map('GET|POST',    '/typology/[i:idtypology]/new_type',                    'ref/new_data_type');
    $router->map('GET|POST',    '/typology/[i:idtypology]/new_type/[:codesupertype]',   'ref/new_data_type');
    $router->map('GET|POST',    '/typology/[i:idtypology]/type/[:codetype]/update',     'ref/new_data_type');
    $router->map('GET|POST',    '/fabrics/new',                                         'ref/new_data_fabric');
    $router->map('GET|POST',    '/fabrics/new/[:codesuperfabric]',                      'ref/new_data_fabric');
    $router->map('GET|POST',    '/fabric/[:codefabric]/update',                         'ref/new_data_fabric');
    $router->map('GET',         '/local_fabric/[:fabric]',                              'ref/local_fabric');
    $router->map('GET',         '/local_type/[:type]',                                  'ref/local_type');
    $router->map('GET',         '/unify/categories',                                    'ref/list_categories_without_link'); // TO DO
    $router->map('GET',         '/unify/functions',                                     'ref/list_functions_without_link'); // TO DO
    $router->map('GET',         '/unify/types',                                         'ref/list_types_without_link'); // TO DO
    $router->map('GET',         '/unify/fabrics',                                       'ref/list_fabrics_without_link'); // TO DO
    $router->map('GET',         '/unify/categories/[:category]',                        'ref/unify_categories'); // TO DO
    $router->map('GET',         '/unify/functions/[:function]',                         'ref/unify_functions'); // TO DO
    $router->map('GET',         '/unify/types/[:type]',                                 'ref/unify_types'); // TO DO
    $router->map('GET',         '/unify/fabrics/[:fabric]',                             'ref/unify_fabrics'); // TO DO
    $router->map('GET|POST',    '/geography',                                           'ref/list_countries_regions'); // TO DO
    $router->map('GET|POST',    '/geography/country/[:code]',                           'ref/new_data_country'); // TO DO
    $router->map('GET|POST',    '/geography/new/country',                               'ref/new_data_country'); // TO DO
    $router->map('GET|POST',    '/geography/region/[:code]',                            'ref/new_data_region'); // TO DO
    $router->map('GET|POST',    '/geography/new/region',                                'ref/new_data_region'); // TO DO
    $router->map('GET|POST',    '/categories',                                          'ref/list_categories');
    $router->map('GET|POST',    '/functions',                                           'ref/list_functions');
    $router->map('GET',         '/counting',                                            'ref/counting_methods'); // TO DO
    $router->map('GET',         '/counting/new',                                        'ref/new_data_countings'); // TO DO

    $router->map('GET',         '/files',                                                               'files/files'); // TO DO
    $router->map('GET|POST',    '/files/addfile',                                                       'files/add_file'); // TO DO
    $router->map('GET',         '/files/download/[i:idfile]',                                           'files/download'); // TO DO
    $router->map('GET',         '/sites/download/[i:idowner]/[:codesite]',                              'files/csv_site'); // TO DO
    $router->map('GET',         '/sites/download/[i:idowner]/[:codesite]/[:codephase]',                 'files/csv_phase'); // TO DO
    $router->map('GET',         '/sites/download/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',  'files/csv_context'); // TO DO
    $router->map('GET',         '/inventory/download/q?[*:query]',                                      'ref/csv_inventory'); // TO DO
    $router->map('POST',        '/addelements',                                                         'ref/addelements'); // TO DO
    $router->map('POST',        '/check',                                                               'ref/checkelements'); // TO DO

    $router->map('GET|POST',    '/new_site',                'import/add_sites_check');
    $router->map('GET|POST',    '/new_context',             'import/add_contexts_check');
    $router->map('GET|POST',    '/new_inventory',           'import/add_inventory_check');
    $router->map('GET|POST',    '/new_site/[*:arg]',        'import/add_sites_check');
    $router->map('GET|POST',    '/new_context/[*:arg]',     'import/add_contexts_check');
    $router->map('GET|POST',    '/new_inventory/[*:arg]',   'import/add_inventory_check');

    $router->map('GET|POST',    '/login',                               'users/login');
    $router->map('GET',         '/logout',                              'users/logout');
    $router->map('GET|POST',    '/register',                            'users/register');
    $router->map('GET|POST',    '/homepage',                            'users/home'); // ONGOING
    $router->map('GET|POST',    '/myaccount',                           'users/my_account');
    $router->map('GET|POST',    '/project',                             'projects/project');
    $router->map('GET|POST',    '/project/new',                         'projects/new_data_project');
    //$router->map('GET|POST',    '/project/[i:idproject]/update',        'users/new_data_project');
    $router->map('GET|POST',    '/page/[:pagename]',                    'projects/text_page');
    $router->map('GET|POST',    '/page/[:pagename]/update/[:lang]',     'projects/modify_page');
    $router->map('GET|POST',    '/manage_users',                        'users/manage_users');

    $router->map('GET',         '/tutorials',               'tutorials/list_tutorials');
    $router->map('GET',         '/tutorials/[*:tutorial]',  'tutorials/tutorial_template');

    //$router->map('GET',         '/graphics',                'graphics/graphics');

} else {
    /* CHECKER AVANT MISE EN LIGNE
        Encore à faire :
            finaliser portabilité : sélection des fichiers et copie des bases de données
        Pas attendre pour publication version :
            Terminer infos other_databases
            Possibilité ajout images internes
            Recherche qui fonctionne
            Tutoriaux : améliorer ce qui existe et gestion des tutoriaux (selon option du projet)
            Templates : idem (not. tenir compte pas projet et cas _litt) (selon option du projet)
            Ajout d'un update possible pour l'installation (notamment, pages hors projet)
            Réparation de l'installation : mode avancé
            Possibilité de suppression des projets et récupération des données personnelles
    */
    $router->map('GET|POST',    '/[:project]/language',                             'index/language');
    $router->map('POST',        '/[:project]/change_language',                      'index/change_language');

    $router->map('GET',         '/',                                                'index/index'); // CHANGER
    //$router->map('GET',         '/logacer/tuto-user',                               'logacer/tutorial_logacer'); // TO DO

    $router->map('GET',         '/[:project]',                                      'index/index');
    $router->map('GET',         '/[:project]/search',                       'index/search'); // TO DO
    $router->map('GET|POST',    '/[:project]/search/results',               'index/results'); // TO DO
    $router->map('GET',         '/[:project]/bibliography',                         'index/bibliography_list');
    $router->map('GET|POST',    '/[:project]/bibliography/[i:idbiblio]',            'index/bibliography');
    $router->map('GET|POST',    '/[:project]/bibliography/new',                     'index/new_data_bibliography');
    $router->map('GET|POST',    '/[:project]/bibliography/[i:idbiblio]/update',     'index/new_data_bibliography');
    $router->map('GET|POST',    '/[:project]/about_us',                             'index/about_us');
    $router->map('GET|POST',    '/[:project]/news/new',                             'index/new_data_news');
    $router->map('GET|POST',    '/[:project]/news/update/[i:idnews]',               'index/new_data_news');
    $router->map('GET',         '/[:project]/legals',                               'index/legals');
    $router->map('GET',         '/[:project]/logacer',                              'index/logacer');
    $router->map('GET',         '/[:project]/gdpr',                                 'index/gdpr');
    $router->map('GET',         '/[:project]/partnership',                          'index/partnership');
    $router->map('GET',         '/[:project]/other_databases',                      'index/other_databases');
    $router->map('GET',         '/[:project]/other_tools',                          'index/other_tools');

    $router->map('GET',         '/[:project]/sites',                                                                    'sites/all_sites');
    $router->map('GET',         '/[:project]/mysites',                                                                  'sites/my_sites');
    $router->map('GET|POST',    '/[:project]/site/[i:idowner]/[:codesite]',                                             'sites/site');
    $router->map('GET|POST',    '/[:project]/site/[i:idowner]/[:codesite]/[:codephase]',                                'sites/phase');
    $router->map('GET|POST',    '/[:project]/site/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',                 'sites/context');
    $router->map('GET|POST',    '/[:project]/object/[i:idobject]',                                                      'sites/object');
    $router->map('GET|POST',    '/[:project]/sites/new',                                                                'sites/new_data_site');
    $router->map('GET|POST',    '/[:project]/site/update/[i:idowner]/[:codesite]',                                      'sites/new_data_site');
    $router->map('GET|POST',    '/[:project]/site/new/[i:idowner]/[:codesite]',                                         'sites/new_data_phase');
    $router->map('GET|POST',    '/[:project]/site/update/[i:idowner]/[:codesite]/[:codephase]',                         'sites/new_data_phase');
    $router->map('GET|POST',    '/[:project]/site/new/[i:idowner]/[:codesite]/[:codephase]',                            'sites/new_data_context');
    $router->map('GET|POST',    '/[:project]/site/update/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',          'sites/new_data_context');
    $router->map('GET|POST',    '/[:project]/site/new/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',             'sites/new_data_object');
    $router->map('GET|POST',    '/[:project]/site/update_objects/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]',  'sites/new_data_objects');
    $router->map('GET|POST',    '/[:project]/object/update/[i:idobject]',                                               'sites/new_data_object');
    $router->map('GET|POST',    '/[:project]/object/[i:idobject]/new_picture',                                          'sites/new_data_picture');
    $router->map('GET|POST',    '/[:project]/object/[i:idobject]/[i:idpicture]',                                        'sites/new_data_picture');

    $router->map('GET',         '/[:project]/horizons',                                     'horizons/all_horizons');
    $router->map('GET',         '/[:project]/myhorizons',                                   'horizons/my_horizons');
    $router->map('GET|POST',    '/[:project]/horizons/[i:idfacies]',                        'horizons/facies');
    $router->map('GET|POST',    '/[:project]/horizons/[i:idfacies]/[i:idhorizon]',          'horizons/horizon');
    $router->map('GET|POST',    '/[:project]/horizons/new',                                 'horizons/new_data_facies');
    $router->map('GET|POST',    '/[:project]/horizons/update/[i:idfacies]',                 'horizons/new_data_facies');
    $router->map('GET|POST',    '/[:project]/horizons/new/[i:idfacies]',                    'horizons/new_data_horizon');
    $router->map('GET',         '/[:project]/horizons/new/[i:idfacies]/[i:idsuperhorizon]', 'horizons/new_data_horizon');
    $router->map('GET|POST',    '/[:project]/horizons/update/[i:idfacies]/[i:idhorizon]',   'horizons/new_data_horizon');

    $router->map('GET|POST',    '/[:project]/horizons/compare', 'horizons_advanced/comparizon_horizon_contexts');
    $router->map('GET|POST',    '/[:project]/horizons/seriations', 'horizons_advanced/seriations');

    $router->map('GET',         '/[:project]/typologies',                                           'ref/all_typologies');
    $router->map('GET',         '/[:project]/mytypologies',                                         'ref/my_typologies');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]',                              'ref/typology');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/type/[:codetype]',             'ref/type');
    $router->map('GET',         '/[:project]/fabrics',                                              'ref/all_fabrics');
    $router->map('GET',         '/[:project]/myfabrics',                                            'ref/my_fabrics');
    $router->map('GET|POST',    '/[:project]/fabric/[:codefabric]',                                 'ref/fabric');
    $router->map('GET|POST',    '/[:project]/typology/new',                                         'ref/new_data_typology');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/update_cat',                   'ref/new_data_typology_cat');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/update',                       'ref/new_data_typology');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/new_type',                     'ref/new_data_type');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/new_type/[:codesupertype]',    'ref/new_data_type');
    $router->map('GET|POST',    '/[:project]/typology/[i:idtypology]/type/[:codetype]/update',      'ref/new_data_type');
    $router->map('GET|POST',    '/[:project]/fabrics/new',                                          'ref/new_data_fabric');
    $router->map('GET|POST',    '/[:project]/fabrics/new/[:codesuperfabric]',                       'ref/new_data_fabric');
    $router->map('GET|POST',    '/[:project]/fabric/[:codefabric]/update',                          'ref/new_data_fabric');
    $router->map('GET',         '/[:project]/local_fabric/[:fabric]',                               'ref/local_fabric');
    $router->map('GET',         '/[:project]/local_type/[:type]',                                   'ref/local_type');
    //$router->map('GET',         '/unify/categories', 'ref/list_categories_without_link'); // TO DO
    //$router->map('GET',         '/unify/functions', 'ref/list_functions_without_link'); // TO DO
    //$router->map('GET',         '/unify/types', 'ref/list_types_without_link'); // TO DO
    //$router->map('GET',         '/unify/fabrics', 'ref/list_fabrics_without_link'); // TO DO
    //$router->map('GET',         '/unify/categories/[:category]', 'ref/unify_categories'); // TO DO
    //$router->map('GET',         '/unify/functions/[:function]', 'ref/unify_functions'); // TO DO
    //$router->map('GET',         '/unify/types/[:type]', 'ref/unify_types'); // TO DO
    //$router->map('GET',         '/unify/fabrics/[:fabric]', 'ref/unify_fabrics'); // TO DO
    $router->map('GET|POST',    '/[:project]/geography',                                            'ref/list_countries_regions'); // TO DO
    $router->map('GET|POST',    '/[:project]/geography/country/[:code]',                            'ref/new_data_country'); // TO DO
    $router->map('GET|POST',    '/[:project]/geography/new/country',                                'ref/new_data_country'); // TO DO
    $router->map('GET|POST',    '/[:project]/geography/region/[:code]',                             'ref/new_data_region'); // TO DO
    $router->map('GET|POST',    '/[:project]/geography/new/region',                                 'ref/new_data_region'); // TO DO
    $router->map('GET|POST',    '/[:project]/categories',                                           'ref/list_categories');
    $router->map('GET|POST',    '/[:project]/functions',                                            'ref/list_functions');
    $router->map('GET',         '/[:project]/counting',                                             'ref/counting_methods'); // TO DO
    $router->map('GET',         '/[:project]/counting/new', 'ref/new_data_countings'); // TO DO

    $router->map('GET',         '/[:project]/files',                                                'files/files');
    $router->map('GET|POST',    '/[:project]/files/addfile',                                        'files/add_file');
    $router->map('GET',         '/[:project]/files/download/[i:idfile]',                            'files/download');
    $router->map('GET',         '/[:project]/sites/download/[i:idowner]/[:codesite]',               'files/csv_site');
    $router->map('GET',         '/[:project]/sites/download/[i:idowner]/[:codesite]/[:codephase]',  'files/csv_phase');
    $router->map('GET',         '/[:project]/sites/download/[i:idowner]/[:codesite]/[:codephase]/[:codecontext]', 'files/csv_context'); // TO DO
    //$router->map('GET',         '/[:project]/inventory/download/q?[*:query]', 'ref/csv_inventory'); // TO DO
    //$router->map('POST',        '/addelements', 'ref/addelements'); // TO DO
    //$router->map('POST',        '/check', 'ref/checkelements'); // TO DO

    $router->map('GET|POST',    '/new_site',                                    'import/add_sites_check');
    $router->map('GET|POST',    '/new_context',                                 'import/add_contexts_check');
    $router->map('GET|POST',    '/new_inventory',                               'import/add_inventory_check');
    $router->map('GET|POST',    '/new_site/[*:arg]',                            'import/add_sites_check');
    $router->map('GET|POST',    '/new_context/[*:arg]',                         'import/add_contexts_check');
    $router->map('GET|POST',    '/new_inventory/[*:arg]',                       'import/add_inventory_check');

    $router->map('GET|POST',    '/[:project]/login',                            'users/login');
    $router->map('GET',         '/[:project]/logout',                           'users/logout');
    $router->map('GET|POST',    '/[:project]/register',                         'users/register');
    $router->map('GET|POST',    '/[:project]/homepage',                         'users/home'); // ONGOING
    $router->map('GET|POST',    '/[:project]/myaccount',                        'users/my_account');
    $router->map('GET|POST',    '/logacer/projects',                            'projects/list_projects');
    $router->map('GET|POST',    '/logacer/myprojects',                          'projects/my_projects');
    $router->map('GET|POST',    '/[:project]/project',                          'projects/project');
    $router->map('GET|POST',    '/logacer/project/new',                         'projects/new_data_project');
    $router->map('GET|POST',    '/[:project]/page/[:pagename]',                 'projects/text_page');
    $router->map('GET|POST',    '/[:project]/page/[:pagename]/update/[:lang]',  'projects/modify_page');
    $router->map('GET|POST',    '/[:project]/manage_users',                     'users/manage_users');

    $router->map('GET',         '/[:project]/tutorials',                        'tutorials/list_tutorials'); // Ecrire tutorial pour LOGACer
    $router->map('GET',         '/[:project]/tutorials/[*:tutorial]',           'tutorials/tutorial_template');

    //$router->map('GET',         '/[:project]/graphics', 'graphics/graphics');

}

require(__DIR__ . "/../users/catch_language.php");

if (!isset($match)) {
    $match = $router->match();
}

if (is_array($match)) {
    $params = $match['params'];

    // Vérifie état de la configuration
    switch (STATUS_INSTALLATION) {
        case 'uninstalled':
            if (defined('LANGUAGE')) {
                // Go installation
                require_once(__DIR__ . "/../logacer/installation.php");
            }
            break;
        case 'validated':
            // On poursuit
            // Initialise le projet, si présent
            if (ISOLATED_WEBSITE) {
                $project = Project::find_all();
                if ($project) {
                    $project_url = $project[0];
                } else {
                    $project_url = false;
                }
                
            } else {
                if (isset($params['project']) && strtolower($params['project']) !== "logacer") {
                    $project_url = Project::find_by_code($params['project']);
                    unset($params['project']);
                    if (!$project_url) {
                        http_response_code(404);
                        exit('404 NOT FOUND');
                    }
                } else {
                    $project_url = false;
                }
            }
            define("PROJECT", $project_url);

            if (PROJECT) {
                define("PROJECT_NAME", PROJECT->code());
            } elseif (defined('WEBSITE_NAME')) {
                define("PROJECT_NAME", WEBSITE_NAME);
            } else {
                define("PROJECT_NAME", "LOGACer");
            }

            $is_ok = true;
            // Vérifie si le projet est privé
            if (PROJECT && !PROJECT->public()) {
                if (isset($_SESSION['user'])) {
                    // On vérifie si l'utilisateur est contributeur
                    if ($_SESSION['user']) {
                        if (!PROJECT->is_contributor()) {
                            echo "403 FORBIDDEN - NOT PROJECT CONTRIBUTOR";
                            $is_ok = false;
                        }
                    } else {
                        // Si autre que login, logout, register : on renvoie à login
                        if (!in_array($match['target'], ['users/login', 'users/logou(', 'users/register'])) {
                            require_once(__DIR__ . "/../users/login.php");
                            $is_ok = false;
                        }
                    }
                }
            }

            if ($is_ok) {
                require_once(__DIR__ . "/../{$match['target']}.php");
            }
            break;
        case 'to_update':
            // ON DEMANDE D'UPDATER
        case 'broken':
            // ON DEMANDE DE REPARER
        default:
            // C'est le case broken
            // Pour l'instant : on refait une installation
            if (defined('LANGUAGE')) {
                // Go installation
                require_once(__DIR__ . "/../logacer/installation.php");
            }
    }

} else {
    echo "404 NOT FOUND";
}

if (isset($_SESSION['user'])) {
    log_page_access($uri, $_SESSION['user']->codename(), $request_start);
} else {
    log_page_access($uri, "", $request_start);
}
?>