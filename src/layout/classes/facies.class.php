<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Facies extends DatabaseObject {

    static protected $table_name = "facies";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'public', 'unpublished', 'allow_graphs',
        'owner', 'project', 'date_creation', 'date_modification'];
    static protected $links = ['bibliography'=>'bibliography', 'user'=>'contributor', 'file'=>'file', 'region'=>'region'];
    static protected $parent = 'project';
    static protected $max_chars = ['code'=>32, 'name'=>255];
    static protected $required = ['code', 'name', 'owner', 'project'];
    static protected $uniques = ['code', 'name'];
    static protected $bool = ['public', 'unpublished', 'allow_graphs'];

    static public function display_by_loc($public = 1) {
        // create arrays of displayed facies
        $faciess = [];
        // create array of all facies with the region
            // Prepare SQL
        $list_columns = 'COALESCE(link_facies_region.region, 0) AS region';
        foreach (static::$db_columns as $column) {
            $list_columns .= ', facies.' . $column . ' AS ' . $column;
        }  
        $sql = "SELECT " . $list_columns . " FROM link_facies_region RIGHT JOIN facies ON link_facies_region.facies = facies.id";
        $binds = [];
        // Add project
        if (PROJECT) {
            $sql .= " WHERE facies.project = :idproject";
            $binds = ["idproject" => PROJECT->id()];
        }
            // Execute SQL
        $all_facies = Facies::find_by_sql($sql, [], ['region', 'code']);
        // check all facies
        if (isset($_SESSION['user'])) {
            foreach ($all_facies as $facies) {
                if ($facies->contributor_rights() || ($public && $facies->public())) {
                    $faciess[] = $facies;
                }
            }
        } else {
            foreach ($all_facies as $facies) {
                if ($public && $facies->public()) {
                    $faciess[] = $facies;
                }
            }
        }
        // arrays by regions
        $region = 0;
        $array_regions = [];
        $no_region = [];
        foreach ($faciess as $facies) {
            if ($facies->region === $region) {
                $array_regions[strval($region)][] = $facies;
            } elseif ($facies->region > 0) {
                $region = $facies->region;
                $array_regions[strval($region)] = [$facies];
            } else {
                array_push($array_regions['0'], $facies);
            }
        }
        
        // array of countries and regions
        $all_countries = Country::find_all(['name']);
        $countries = [];
        $no_region = [];
        foreach ($all_countries as $country) {
            $regions = Region::find_by_parent($country->id(), ['name']);
            foreach ($regions as $region) {
                if (isset($array_regions[strval($region->id())])) {
                    $countries[$country->name()][$region->name()] = $array_regions[strval($region->id())];
                }
            }
            if (isset($array_regions['0'])) {
                $no_region = $array_regions['0'];
            }
        }
        return [$countries, $no_region];
    }

    static public function find_by_id($id) {
        $facies = parent::find_by_id($id);
        if ($facies && PROJECT && $facies->project()->id() != PROJECT->id()) {
            return false;
        }
        return $facies;
    }

    static public function find_by_code($code) {
        if (!$code) { return false; }
        $object = static::find_by_sql("SELECT * FROM facies WHERE code = :code", ['code'=>$code]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected int $public;
    protected int $unpublished;
    protected int $allow_graphs;
    protected int $owner;
    protected int $project;

    private $region;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        if (isset($args['unpublished'])) { if ($args['unpublished']) { $this->unpublished = 1; } else { $this->unpublished = 0; } } else { $this->unpublished = 0; }
        if (isset($args['allow_graphs'])) { if ($args['allow_graphs']) { $this->allow_graphs = 1; } else { $this->allow_graphs = 0; } } else { $this->allow_graphs = 1; }
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        if (isset($args['project'])) { $this->project = intval($args['project']); } else { $this->project = 0; }
        $this->region = $args['region'] ?? '';
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant project :
        $this->errors = add_error($this->errors, check_exists($this->project, 'project'));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['horizons', 'update', $this->id()]);
            } elseif ($arg == 'new_horizon') {
                return create_url(['horizons', 'new', $this->id()]);
            } elseif ($arg == 'new') {
                return create_url(['horizons', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['myhorizons']);
            } else {
                return create_url(['horizons', $this->id()]);
            }
        } else {
            $project_url = $this->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'horizons', 'update', $this->id()]);
            } elseif ($arg == 'new_horizon') {
                return create_url([$project_url, 'horizons', 'new', $this->id()]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'horizons', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'myhorizons']);
            } else {
                return create_url([$project_url, 'horizons', $this->id()]);
            }
        }
    }

    public function codename($arg="") {
        $codename = secure($this->code . thesaurus(':') . ' ' . $this->name);
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    public function public() {
        return secure($this->public);
    }

    public function unpublished() {
        return secure($this->unpublished);
    }

    public function allow_graphs() {
        return secure($this->allow_graphs);
    }

    public function project() {
        return Project::find_by_id($this->project);
    }

    public function manage_regions($arg) {
        if ($arg == 'front') {
            if (in_array('region', static::$links)) {
                $regions = Region::linked(static::$table_name, 'region', $this->id);
                if (count($regions) > 0 || $this->contributor_rights()) {
                    $html = p(b(ucfirst(thesaurus('concerned regions') . thesaurus(':')))) . '<ul>';
                    $action = false;
                    if (isset($_POST['typeaction'])) { if (in_array($_POST['typeaction'], ['addregion', 'regionadded', 'deleteregion'])) { $action = $_POST['typeaction']; }}
                    
                    // Order list alphabetically according to country then region name
                    $list_regions = [];
                    foreach ($regions as $region) {
                        if ($this->contributor_rights() && !$action) {
                            $item = "<form action='" . $this->url() . "' method='post'>";
                            $item .= $region->codename();
                            $item .= button_delete_sm('region', $region->id());
                            $list_regions[] = li($item . "</form>");
                        } else {
                            $list_regions[] = li($region->codename());
                        }
                    }
                    sort($list_regions);
                    $html .= implode($list_regions);

                    if ($this->contributor_rights()) {
                        $html2 = "<form action='" . $this->url() . "' method='post'>";
                        if ($action === "addregion") {
                            $html2 .= "<label for='region'>" . ucfirst(thesaurus("select region") . thesaurus(':')) . "</label>";
                            $html2 .= "<select name='region' id='id_region'>";
                            $html2 .= opt('0', "-- " . thesaurus("select region") . " --");
                            $regions = $this->no_region();
                            foreach ($regions as $region) {
                                $html2 .= opt($region->id(), $region->codename());
                            }
                            $html2 .= "</select>";
                            $html2 .= buttons_validate_sm($this->url(), 'region');
                        } elseif (!$action) {
                            $html2 .= button_add_sm('a region', 'region');
                        }
                        $html2 .= "</form>";
                        $html .= li($html2);
                    }
                    $html .= '</ul>';
                    echo $html;
                }
            }
        } elseif ($arg == 'back') {
            if (in_array($_POST['typeaction'], ['regionadded', 'deleteregion'])) {
                $action = $_POST['typeaction'];
                if ($action == 'regionadded') {
                    /* Vérifie si utilisateur existe */
                    $new_region = Region::find_by_id($_POST['region']);
                    if (in_array($new_region, $this->no_region())) {
                        $request = static::$connexion->query("INSERT INTO link_" . static::$table_name . "_region (" . static::$table_name . ", region) VALUES (" . $this->id . ", " . $new_region->id() . ")");
                    }
                } elseif ($action == 'deleteregion') {
                    DatabaseObject::delink(static::$table_name, 'region', $this->id(), $_POST['region']);
                }
                header('Location: ' . $this->url());
                exit();
            }
        }
    }

    public function no_region() {
        if (in_array('region', static::$links)) {
            $regions = Region::linked(static::$table_name, 'region', $this->id);
            $all_regions = Region::find_all();
            $no_region = [];
            foreach ($all_regions as $region) {
                if (!in_array($region, $regions)) {
                    $no_region[] = $region;
                }
            }
            // Sorting :
            usort($no_region, function ($a, $b) {
                return $a->codename() <=> $b->codename();
            });
            return $no_region;
        }
    }

}

?>