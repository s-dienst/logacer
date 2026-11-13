<?php

/* Description de l'objet
** Fonctions statiques :
    find_by_site_code()

** Fonctions supplémentaires :
    related_site() ; biblio_review()

** Variables supplémentaires :
    /
*/
class Phase extends DatabaseObject {

    static protected $table_name = "phase";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'public',
        'unpublished', 'biblio_review', 'related_site', 'horizon', 'horizon_strength', 'creator', 'date_creation', 'date_modification'];
    static protected $parent = 'related_site';
    static protected $links = ['bibliography'=>'bibliography', 'file'=>'file'];
    static protected $max_chars = ['code'=>32, 'name'=>255];
    static protected $required = ['code', 'name', 'related_site', 'creator'];
    static protected $bool = ['public', 'unpublished', 'biblio_review'];

    static public function find_by_site_code($idsite, $codephase) {
        $object = static::find_by_sql("SELECT * FROM phase WHERE related_site = :idsite AND code = :codephase", ['idsite'=>$idsite, 'codephase'=>rud($codephase)]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    // Display SQL parts for selection of accessible phases only
    static public function sql_public($part) {
        switch ($part) {
            case "join":
                $sql = " LEFT JOIN site ON phase.related_site = site.id";
                if (isset($_SESSION['user'])) {
                    $sql .= " LEFT JOIN link_site_contributor ON site.id = link_site_contributor.site
                        LEFT JOIN project ON site.project = project.id
                        LEFT JOIN link_project_contributor ON project.id = link_project_contributor.project";
                }
                return $sql;
                break;
            case "where":
                $sql = '(phase.public = 1 AND site.public = 1)';
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
    protected string $descr;
    protected string $descr_html;
    protected int $public;
    protected int $unpublished;
    protected int $biblio_review;
    protected int $related_site;
    protected int $horizon;
    protected int $horizon_strength;
    protected int $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        if (isset($args['unpublished'])) { if ($args['unpublished']) { $this->unpublished = 1; } else { $this->unpublished = 0; } } else { $this->unpublished = 0; }
        if (isset($args['biblio_review'])) { if ($args['biblio_review']) { $this->biblio_review = 1; } else { $this->biblio_review = 0; } } else { $this->biblio_review = 0; }
        if (isset($args['related_site'])) { $this->related_site = intval($args['related_site']); } else { $this->related_site = 0; }
        if (isset($args['horizon'])) { $this->horizon = intval($args['horizon']); } else { $this->horizon = 0; }
        if (isset($args['horizon_strength'])) { $this->horizon_strength = intval($args['horizon_strength']); } else { $this->horizon_strength = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant : related_site, horizon :
        $this->errors = add_error($this->errors, check_exists($this->related_site, 'site'));
        $this->errors = add_error($this->errors, check_exists($this->horizon, 'horizon'));
        // Check si code pas déjà présent pour site si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->related_site) {
            if ($this->id) {
                if (Phase::find_by_site_code($this->related_site, $this->code)) { if (Phase::find_by_site_code($this->related_site, $this->code)->id() != $this->id) {
                    $this->errors = add_error($this->errors, err_not_unique('phase', $this->related_site()->codename(), false));
                }}
            } elseif (Phase::find_by_site_code($this->related_site, $this->code)) {
                $this->errors = add_error($this->errors, err_not_unique('phase', $this->related_site()->codename(), false));
            }
        }
        // Check si l'horizon strength est dans un intervalle correct
        $this->errors = add_error($this->errors, check_range($this->horizon_strength, "the horizon_strength", 0, 3));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['site', 'update', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            } elseif ($arg == 'new_context') {
                return create_url(['site', 'new', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            } elseif ($arg == 'new') {
                return create_url(['site', 'new', $this->related_site()->owner('prop'), $this->related_site()->code()]);
            } elseif ($arg == 'parent') {
                return create_url(['site', $this->related_site()->owner('prop'), $this->related_site()->code()]);
            } else {
                return create_url(['site', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            }
        } else {
            $project_url = $this->related_site()->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'site', 'update', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            } elseif ($arg == 'new_context') {
                return create_url([$project_url, 'site', 'new', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'site', 'new', $this->related_site()->owner('prop'), $this->related_site()->code()]);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'site', $this->related_site()->owner('prop'), $this->related_site()->code()]);
            } else {
                return create_url([$project_url, 'site', $this->related_site()->owner('prop'), $this->related_site()->code(), $this->code]);
            }
        }
    }

    public function related_site() {
        return Site::find_by_id($this->related_site);
    }

    public function name($arg="") {
        if ($this->code === '00') {
            return ucfirst(thesaurus('default_phase_name'));
        } else {
            return secure($this->name);
        }
    }

    public function codename($arg=false) {
        if ($this->code === '00') {
            $codename = $this->name();
        } else {
            $codename = secure($this->code . thesaurus(':') . ' ' . $this->name());
        }
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    public function public() {
        return $this->public;
    }

    public function unpublished() {
        return $this->unpublished;
    }

    public function horizon_strength() {
        return $this->horizon_strength;
    }

    public function horizon($arg="") {
        if ($this->horizon) {
            $horizon = Horizon::find_by_id($this->horizon);
            if ($horizon) {
                if ($arg == 'display') {
                    $html = b(ucfirst(thesaurus('horizon') . thesaurus(':') . ' '));
                    $html .= $horizon->hyperlink() . ". ";
                    $html .= ucfirst(thesaurus('horizon_strength') . thesaurus(':') . ' ');
                    $html .= list_val('horizon_strength', $this->horizon_strength()) . '.';
                    echo p($html);
                } else {
                    return $horizon;
                }
            } else { return false; }
        } else { return false; }
    }

    public function biblio_review($arg="") {
        if ($this->biblio_review || Site::find_by_id($this->related_site)->biblio_review()) {
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

    public function coord_lat() {
        return $this->related_site()->coord_lat();
    }

    public function coord_long() {
        return $this->related_site()->coord_long();
    }



    // Functions to add objects
    public function table_add($data_column='', $data_row=0) {
        echo "<td data-row='" . $data_row . "' data-column='" . $data_column . "'>";
        if ($data_column) {
            // Check s'il y a des erreurs associées
            if (in_array($data_column, $this->errors)) {
                echo "<div style='color:#B80000'>" . $this->$data_column . "</div>";
            } elseif ($data_column === 'site' && in_array('related_site', $this->errors)) {
                echo "<div style='color:#B80000'>ERROR</div>";
            } elseif ($data_column === 'phase_code' && in_array('code', $this->errors)) {
                // D'abord, vérifier si pas phase par défaut
                if (strLen($this->code) === 0 && strLen($this->name) === 0 && $this->horizon === 0) {
                    echo $this->code;
                } elseif (strLen($this->code) > 0) {
                    echo "<div style='color:#B80000'>" . $this->code . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } elseif ($data_column === 'phase_name' && in_array('name', $this->errors)) {
                // D'abord, vérifier si pas phase par défaut
                if ((strLen($this->code) === 0 || $this->code === "00") && strLen($this->name) === 0 && $this->horizon === 0) {
                    echo $this->name;
                } elseif (strLen($this->name) > 0) {
                    echo "<div style='color:#B80000'>" . $this->name . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } elseif ($data_column === 'phase_descr' && in_array('descr', $this->errors)) {
                if (strLen($this->descr) > 0) {
                    echo "<div style='color:#B80000'>" . $this->descr . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } elseif ($data_column === 'horizon_strength' && in_array('horizon_strength', $this->errors)) {
                echo "<div style='color:#B80000'>" . $this->horizon_strength . "</div>";
            } else {
                // Sinon, affiche les données
                if (in_array($data_column, ['horizon_strength']) && (!PROJECT || PROJECT->setting_horizon())) {
                    echo $this->$data_column;
                } elseif (in_array($data_column, ['n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd'])) {
                    if ($this->$data_column > 0) {
                        echo $this->$data_column;
                    }
                } elseif ($data_column === 'site') {
                    if ($this->related_site()) {
                        echo $this->related_site()->name();
                    } else {
                        echo "<div style='color:#B80000'>ERROR</div>";
                    }
                } elseif ($data_column === 'facies' && (!PROJECT || PROJECT->setting_horizon())) {
                    if ($this->horizon > 0) {
                        $horizon = $this->horizon();
                        if ($horizon) {
                            echo $this->horizon()->facies()->code();
                        } else {
                            echo "<div style='color:#A9A9A9'>Error</div>";
                        }
                    }
                } elseif ($data_column === 'horizon_code') {
                    if ($this->horizon > 0) {
                        $horizon = $this->horizon();
                        if ($horizon) {
                            echo $this->horizon()->code();
                        } else {
                            echo "<div style='color:#A9A9A9'>" . $this->horizon . "</div>";
                        }
                    }
                } elseif ($data_column === 'horizon_strength') {
                    echo $this->horizon_strength;
                } elseif ($data_column === 'phase_code') {
                    echo $this->code;
                } elseif ($data_column === 'phase_name') {
                    echo $this->name;
                } elseif ($data_column === 'phase_descr') {
                    echo $this->descr;
                }
            }
        }
        echo '</td>';
    }

    // Lors de l'ajout de données par csv, check les erreurs, et ajoute les attributs problématiques à l'array errors
    public function check_errors_add($phase_codes) {
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
        // Check si related_site
        if (!$this->related_site) {
            $this->errors[] = 'related_site';
            $this->errors[] = 'code';
            if (!in_array($this->code, $phase_codes)) {
                $code = $this->code;
            }
        } else {
            // Check si code et site pas déjà présent si nouveau ; check aussi dans les données déjà encodées
            if (Phase::find_by_site_code($this->related_site, $this->code)) {
                if (err_not_unique('phase', $this->related_site()->codename(), false)) { $this->errors[] = 'code'; }
            } elseif (in_array($this->code, $phase_codes)) {
                $this->errors[] = 'code';
            } else {
                $code = $this->code;
            }
        }
        // Check si l'horizon strength est dans un intervalle correct
        if (check_range($this->horizon_strength, "the horizon_strength", 0, 3)) { $this->errors[] = 'horizon_strength'; }
        return $this->code;
    }
}

?>