<?php
/* Description de l'objet
** Fonctions statiques :
    display_by_loc() ; find_by_owner_code()

** Fonctions supplémentaires :
    public() ; unpublished()
    owner_id() ; code() --> DEVRAIENT DISPARAITRE ?
    location() ; biblio_review()

** Variables supplémentaires :
    /
*/
class Site extends DatabaseObject {

    static protected $table_name = "site";
    static protected $db_columns = ['id', 'code', 'name', 'coord_lat', 'coord_long', 'descr', 'descr_html', 'public',
        'unpublished', 'biblio_review', 'allow_graphs', 'owner', 'region', 'project', 'date_creation', 'date_modification'];
    static protected $links = ['user'=>'contributor', 'bibliography'=>'bibliography', 'file'=>'file'];
    static protected $parent = 'project';
    static protected $max_chars = ['code'=>32, 'name'=>255];
    static protected $required = ['code', 'name', 'owner', 'project'];
    static protected $bool = ['public', 'unpublished', 'biblio_review', 'allow_graphs'];
    static protected $uniques = ['name'];

    static public function display_by_loc($public = 1) {
        // create arrays of displayed sites
        $sites = [];
        // create array of all sites
        if (PROJECT) {
            $all_sites = Site::find_by_parent(PROJECT->id(), ['region', 'code']);
        } else {
            $all_sites = [];
            //$all_sites = Site::find_all(['region', 'code']);
        }
        // check all sites
        if (isset($_SESSION['user'])) {
            foreach ($all_sites as $site) {
                if ($site->contributor_rights() || ($public && $site->public())) {
                    $sites[] = $site;
                }
            }
        } else {
            foreach ($all_sites as $site) {
                if ($public && $site->public()) {
                    $sites[] = $site;
                }
            }
        }
        // arrays by regions
        $region = 0;
        $array_regions = [];
        $no_region = [];
        foreach ($sites as $site) {
            if ($site->region === $region) {
                $array_regions[strval($region)][] = $site;
            } elseif ($site->region > 0) {
                $region = $site->region;
                $array_regions[strval($region)] = [$site];
            } else {
                array_push($array_regions['0'], $site);
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

    static public function find_by_owner_code($idowner, $codesite) {
        if (!PROJECT) {
            return false;
        }
        $object = static::find_by_sql("SELECT * FROM site WHERE project = :idproject AND owner = :idowner AND code = :codesite", ['idproject'=>PROJECT->id(), 'idowner'=>$idowner, 'codesite'=>rud($codesite)]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function find_by_name($name) {
        if (!$name || !PROJECT) { return false; }
        $object = static::find_by_sql("SELECT * FROM site WHERE project = :idproject AND name = :name", ['idproject'=>PROJECT->id(), 'name'=>$name]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    // Display SQL parts for selection of accessible sites only
    static public function sql_public($part) {
        switch ($part) {
            case "join":
                $sql = "";
                if (isset($_SESSION['user'])) {
                    $sql .= " LEFT JOIN link_site_contributor ON site.id = link_site_contributor.site
                        LEFT JOIN project ON site.project = project.id
                        LEFT JOIN link_project_contributor ON project.id = link_project_contributor.project";
                }
                return $sql;
                break;
            case "where":
                $sql = '(site.public = 1)';
                if (isset($_SESSION['user'])) {
                    $id = $_SESSION['user']->id();
                    $sql = '(' . $sql . 'OR site.owner = ' . $id . ' OR link_site_contributor.contributor = ' . $id
                    . ' OR project.owner = ' . $id . ' OR link_project_contributor.contributor = ' . $id . ')';
                }
                return ' WHERE ' . $sql;
                break;
        }
    }

    protected string $code;
    protected string $name;
    protected float $coord_lat;
    protected float $coord_long;
    protected string $descr;
    protected string $descr_html;
    protected int $public;
    protected int $unpublished;
    protected int $biblio_review;
    protected int $allow_graphs;
    protected int $owner;
    protected int $region;
    protected int $project;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        if (isset($args['coord_lat'])) { $this->coord_lat = floatval($args['coord_lat']); }
        if (isset($args['coord_long'])) { $this->coord_long = floatval($args['coord_long']); }
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        if (isset($args['unpublished'])) { if ($args['unpublished']) { $this->unpublished = 1; } else { $this->unpublished = 0; } } else { $this->unpublished = 0; }
        if (isset($args['biblio_review'])) { if ($args['biblio_review']) { $this->biblio_review = 1; } else { $this->biblio_review = 0; } } else { $this->biblio_review = 0; }
        if (isset($args['allow_graphs'])) { if ($args['allow_graphs']) { $this->allow_graphs = 1; } else { $this->allow_graphs = 0; } } else { $this->allow_graphs = 1; }
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        if (isset($args['region'])) { $this->region = intval($args['region']); } else { $this->region = 0; }
        if (isset($args['project'])) { $this->project = intval($args['project']); } else { $this->project = 0; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function validate() {
        parent::validate();
        // Check si code et owner pas déjà présent si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->id) {
            if (Site::find_by_owner_code($this->owner, $this->code)) { if (Site::find_by_owner_code($this->owner, $this->code)->id() != $this->id) {
                $this->errors = add_error($this->errors, err_not_unique('site', User::find_by_id($this->owner)->codename(), false));
            }}
        } elseif (Site::find_by_owner_code($this->owner, $this->code)) {
            $this->errors = add_error($this->errors, err_not_unique('site', User::find_by_id($this->owner)->codename(), false));
        }
        // Check si la latitude et la longitude sont dans les intervalles correctes
        if (isset($this->coord_lat)) { $this->errors = add_error($this->errors, check_range($this->coord_lat, "the coord_lat", -90, 90)); }
        if (isset($this->coord_long)) { $this->errors = add_error($this->errors, check_range($this->coord_long, "the coord_long", -180, 180)); }
        // Check si les chiffres correspondent à quelque chose d'existant region, project :
        $this->errors = add_error($this->errors, check_exists($this->region, 'region'));
        $this->errors = add_error($this->errors, check_exists($this->project, 'project'));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['site', 'update', $this->owner, $this->code]);
            } elseif ($arg == 'new_phase') {
                return create_url(['site', 'new', $this->owner, $this->code]);
            } elseif ($arg == 'new') {
                return create_url(['sites', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['mysites']);
            } else {
                return create_url(['site', $this->owner, $this->code]);
            }
        } else {
            $project_url = $this->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'site', 'update', $this->owner, $this->code]);
            } elseif ($arg == 'new_phase') {
                return create_url([$project_url, 'site', 'new', $this->owner, $this->code]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'sites', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'mysites']);
            } else {
                return create_url([$project_url, 'site', $this->owner, $this->code]);
            }
        }
    }

    public function code($args="") {
        if ($args == 'table') {
            if (ISOLATED_WEBSITE) {
                $hyperlink = hyperlink($this->code, ['site', $this->owner, $this->code]);
            } else {
                $hyperlink = hyperlink($this->code, [$this->project()->code(), 'site', $this->owner, $this->code]);
            }
            return "<td sort-text='" . $this->code . "'>" .
                $hyperlink
                . "</td>";
        } else {
            return secure($this->code);
        }
    }

    public function name($args="") {
        if ($args == 'table') {
            return "<td sort-text='" . $this->name . "'>" .
                $this->name
                . "</td>";
        } else {
            return secure($this->name);
        }
    }

    public function codename($arg=false) {
        $codename = secure($this->code . thesaurus(':') . ' ' . $this->name);
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    public function public($args="") {
        if ($args == 'table') {
            if ($this->public) {
                $public = ucfirst(thesaurus('public'));
            } else {
                $public = ucfirst(thesaurus('private'));
            }
            return "<td sort-text='" . $public . "'>" .
                $public
                . "</td>";
        } else {
            return $this->public;
        }
    }

    public function unpublished() {
        return $this->unpublished;
    }

    public function allow_graphs() {
        return secure($this->allow_graphs);
    }

    public function region($args="") {
        if (!empty($this->region)) {
            $region = Region::find_by_id($this->region)->country_region();
            if ($args == 'table') {
                return "<td sort-text='" . $region . "'>" .
                    $region
                    . "</td>";
            } else {
                return $region;
            }
        } elseif ($args == 'table') {
            return "<td sort-text='ZZZ'>/</td>";
        }
    }

    public function coord_lat() {
        if (isset($this->coord_lat)) {
            return $this->coord_lat;
        } else {
            return false;
        }
    }

    public function coord_long() {
        if (isset($this->coord_long)) {
            return $this->coord_long;
        } else {
            return false;
        }
    }

    public function project() {
        return Project::find_by_id($this->project);
    }

    // Display text in mode "Location: Country - Region (xx ° north, yy ° east)."
    public function location() {
        if (!empty($this->region) || (isset($this->coord_lat) && isset($this->coord_long))) {
            $html = b(ucfirst(thesaurus('location:')), " ");
            if (empty($this->region)) { $html .= thesaurus("no region"); } else { $html .= Region::find_by_id($this->region)->country_region(); }
            if (isset($this->coord_lat) && isset($this->coord_long)) {
                if ($this->coord_lat < 0) { $lat = "south"; $absolute_lat = 0 - $this->coord_lat; } else { $lat = "north"; $absolute_lat = $this->coord_lat; }
                if ($this->coord_long < 0) { $long = "west"; $absolute_long = 0 - $this->coord_long; } else { $long = "east"; $absolute_long = $this->coord_long; }
                $html .= " (" . $absolute_lat . "° " . thesaurus($lat) . ", " . $absolute_long . "° " . thesaurus($long) . ")."; } else { $html .= ".";
            }
            echo p($html);
        }
    }

    public function counting($args="") {
        $countings = Counting::linked('counting', 'site', $this->id, true);
        if ($args == 'table') {
            $count = "";
            foreach ($countings as $counting) {
                if (strlen($count) > 0) {
                    $count .= ", ";
                }
                $count .= $counting->name();
            }
            return "<td sort-text='" . $count . "'>" .
                $count
                . "</td>";
        }
    }

    public function n_mni($args="") {
        $countings = Counting::linked('counting', 'site', $this->id, true);
        $counting_mni = false;
        foreach ($countings as $counting) {
            if ($counting->id() === 2) {
                $counting_mni = true;
            }
        }
        if ($counting_mni) {
            $n_mni = $this->sum_countings("n_mni");
        } else {
            $n_mni = "-";
        }
        if ($args == 'table') {
            return "<td sort-text='" . $n_mni . "'>" .
                $n_mni
                . "</td>";
        } else {
            return $n_mni;
        }
    }

    public function n_sherd($args="") {
        $countings = Counting::linked('counting', 'site', $this->id, true);
        $counting_nsherds = false;
        $counting_bfpa = false;
        foreach ($countings as $counting) {
            switch ($counting->id()) {
                case 1:
                    $counting_bfpa = true;
                    break;
                case 2:
                    break;
                case 3:
                    $counting_nsherds = true;
                    break;
            }
        }
        if ($counting_nsherds) {
            $n_sherd = $this->sum_countings("n_sherd");
        } elseif ($counting_bfpa) {
            $n_sherd = $this->sum_countings("n_rim") + $this->sum_countings("n_bottom") + $this->sum_countings("n_handle") + $this->sum_countings("n_wall");
        } else {
            $n_sherd = "-";
        }
        if ($args == 'table') {
            return "<td sort-text='" . $n_sherd . "'>" .
                $n_sherd
                . "</td>";
        } else {
            return $n_sherd;
        }
    }

    public function biblio_review($arg="") {
        if ($this->biblio_review) {
            if ($arg == 'body') {
                echo "<body style='background-color:#f4e9cd'>";
            } elseif ($arg == 'message') {
                echo "<br><div class='alert' style='text-align:center; background-color:#fad370'>"
                        . h(4, thesaurus('biblio_review_title'))
                        . thesaurus('biblio_review_message') . "</div>";
            } else {
                return $this->biblio_review;
            }
        } elseif ($arg == 'body') {
            echo '<body>';
        } else {
            return $this->biblio_review;
        }
    }

    public function owner_id() {
        return $this->owner;
    }

    // Functions to add objects
    public function table_add($data_column='', $data_row=0) {
        echo "<td data-row='" . $data_row . "' data-column='" . $data_column . "'>";
        if ($data_column) {
            // Check s'il y a des erreurs associées
            if (in_array($data_column, $this->errors)) {
                if ($data_column === 'owner') {
                    echo "<div style='color:darkgray'>" . $_SESSION['user']->username() . "</div>";
                } else {
                    echo "<div style='color:#B80000'>" . $this->$data_column . "</div>";
                }
            } else {
                // Sinon, affiche les données
                if ($data_column === 'project') {
                    if ($this->$data_column > 0) {
                        echo $this->$data_column;
                    }
                } elseif (in_array($data_column, ['code', 'name', 'descr'])) {
                    echo $this->$data_column;
                } elseif ($data_column === 'owner') {
                    echo User::find_by_id($this->owner)->username();
                } elseif (in_array($data_column, ['coord_lat', 'coord_long'])) {
                    // Si ce sont ces coordonnées, et que l'une d'entre elles est égale à 0, erreur
                    if (isset($this->coord_lat) && isset($this->coord_long)) {
                        if ($this->coord_lat && $this->coord_long) {
                            echo $this->$data_column;
                        } elseif ($this->coord_lat || $this->coord_long) {
                            echo "<div style='color:#B80000'>ERROR</div>";
                        }
                    }
                } elseif ($data_column === 'region') {
                    if ($this->$data_column > 0) {
                        echo Region::find_by_id($this->region)->code();
                    }
                } elseif (in_array($data_column, ['public', 'unpublished', 'biblio_review'])) {
                    if ($this->$data_column === 0) {
                        echo ucfirst(thesaurus('no'));
                    } else {
                        echo ucfirst(thesaurus('yes'));
                    }
                }
            }
        }
        echo '</td>';
    }

    // Lors de l'ajout de données par csv, check les erreurs, et ajoute les attributs problématiques à l'array errors
    public function check_errors_add($site_codes, $site_names) {
        // Vérifie les caractères maximaux
        foreach(static::$max_chars as $name=>$max) {
            if (check_max_char($this->$name, $max, "the " . $name)) { $this->errors[] = $name; }
        }
        // Vérifie les champs obligatoires
        foreach(static::$required as $name) {
            if (check_blank($this->$name, "a " . $name)) { $this->errors[] = $name; }
        }
        // Vérifie si l'owner ou le créateur existe
        if (property_exists(get_called_class(), 'owner')) { $name = 'owner'; }
        elseif (property_exists(get_called_class(), 'creator')) { $name = 'creator'; }
        if (property_exists(get_called_class(), 'owner') || property_exists(get_called_class(), 'creator')) {
            $owner = User::find_by_id($this->$name);
            $users = User::find_all();
            if (!in_array($owner, $users)) {
                if (err_owner(get_called_class(), $name)) { $this->errors[] = $name; }
            }
        }
        // Vérifie les champs uniques
        foreach (static::$uniques as $unique) {
            $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . $unique . " = :attachment OR " . $unique . " = :attachment2", ['attachment'=>$this->$unique, 'attachment2'=>rud($this->$unique)]);
            if (!empty($object)) {
                if (!$this->id) {
                    if (err_not_unique($unique, get_called_class())) { $this->errors[] = $unique; }
                } elseif (array_shift($object)->id() != $this->id) {
                    if (err_not_unique($unique, get_called_class())) { $this->errors[] = $unique; }
                }
            }
        }
        $code = false;
        $name = false;
        // Check si owner
        if (!$this->owner) {
            $this->errors[] = 'owner';
            $this->errors[] = 'code';
            if (!in_array($this->code, $site_codes)) {
                $code = $this->code;
            }
        } else {
            // Check si code et owner pas déjà présent si nouveau ; check aussi dans les données déjà encodées
            if (Site::find_by_owner_code($this->owner, $this->code)) {
                if (err_not_unique('site', User::find_by_id($this->owner)->username(), false)) { $this->errors[] = 'code'; }
            } elseif (in_array($this->code, $site_codes)) {
                $this->errors[] = 'code';
            } else {
                $code = $this->code;
            }
        }
        // Check si a bien les droits comme contributeur du projet
        if ($this->project) {
            $project = Project::find_by_id($this->project);
            if ($project) {
                if (!$project->contributor_rights()) {
                    $this->errors[] = 'project';
                }
            } else {
                $this->errors[] = 'project';
            }
        }
        // Check si nom est bien unique
        if (Site::find_by_name($this->name)) {
            $this->errors[] = 'name';
        } else {
            $name = $this->name;
        }
        // Check si la latitude et la longitude sont dans les intervalles corrects
        if (isset($this->coord_lat)) {
            if (check_range($this->coord_lat, "the coord_lat", -90, 90)) { $this->errors[] = 'coord_lat'; }
        }
        if (isset($this->coord_long)) {
            if (check_range($this->coord_long, "the coord_long", -180, 180)) { $this->errors[] = 'coord_long'; }
        }
        return [$this->code, $this->name];
    }
}

?>