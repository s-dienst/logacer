<?php

/* Description de l'objet
** Fonctions statiques :
    find_by_phase_code()

** Fonctions supplémentaires :
    related_phase()

** Variables supplémentaires :
    /
*/
class Context extends DatabaseObject {

    static protected $table_name = "context";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'public',
        'unpublished', 'biblio_review', 'related_phase', 'creator', 'date_creation', 'date_modification'];
    static protected $links = ['bibliography'=>'bibliography', 'file'=>'file'];
    static protected $parent = 'related_phase';
    static protected $max_chars = ['code'=>32, 'name'=>255];
    static protected $required = ['code', 'name', 'related_phase', 'creator'];
    static protected $bool = ['public', 'unpublished', 'biblio_review'];

    static public function find_by_phase_code($idphase, $codecontext) {
        $object = static::find_by_sql("SELECT * FROM context WHERE related_phase = :idphase AND code = :codecontext", ['idphase'=>$idphase, 'codecontext'=>rud($codecontext)]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function find_by_site_code($idsite, $codecontext) {
        $object = static::find_by_sql("SELECT context.* FROM context
            INNER JOIN phase ON context.related_phase = phase.id WHERE phase.related_site = :idsite AND context.code = :codecontext", ['idsite'=>$idsite, 'codecontext'=>rud($codecontext)]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    // Display SQL parts for selection of accessible objects only
    static public function sql_public($part) {
        switch ($part) {
            case "join":
                $sql = " LEFT JOIN phase ON context.related_phase = phase.id
                LEFT JOIN site ON phase.related_site = site.id";
                if (isset($_SESSION['user'])) {
                    $sql .= " LEFT JOIN link_site_contributor ON site.id = link_site_contributor.site
                        LEFT JOIN project ON site.project = project.id
                        LEFT JOIN link_project_contributor ON project.id = link_project_contributor.project";
                }
                return $sql;
                break;
            case "where":
                $sql = '(context.public = 1 AND phase.public = 1 AND site.public = 1)';
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
    protected int $related_phase;
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
        if (isset($args['related_phase'])) { $this->related_phase = intval($args['related_phase']); } else { $this->related_phase = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant : related_phase :
        $this->errors = add_error($this->errors, check_exists($this->related_phase, 'phase'));
        // Check si code pas déjà présent pour site si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->related_site()) {
            if ($this->id) {
                if (Context::find_by_site_code($this->related_phase()->related_site()->id(), $this->code)) {
                    if (Context::find_by_site_code($this->related_phase()->related_site()->id(), $this->code)->id() != $this->id) {
                        $this->errors = add_error($this->errors, err_not_unique('context', $this->related_phase()->codename(), false));
                    }
                }
            } elseif (Context::find_by_site_code($this->related_phase()->related_site()->id(), $this->code)) {
                $this->errors = add_error($this->errors, err_not_unique('context', $this->related_phase()->codename(), false));
            }
        }
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['site', 'update', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'new_object') {
                return create_url(['site', 'new', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'update_objects') {
                return create_url(['site', 'update_objects', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'new') {
                return create_url(['site', 'new', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code()]);
            } elseif ($arg == 'parent') {
                return create_url(['site', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code()]);
            } else {
                return create_url(['site', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            }
        } else {
            $project_url = $this->related_phase()->related_site()->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'site', 'update', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'new_object') {
                return create_url([$project_url, 'site', 'new', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'update_objects') {
                return create_url([$project_url, 'site', 'update_objects', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'site', 'new', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code()]);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'site', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code()]);
            } else {
                return create_url([$project_url, 'site', $this->related_phase()->related_site()->owner('prop'), $this->related_phase()->related_site()->code(), $this->related_phase()->code(), $this->code]);
            }
        }

    }

    public function related_site() {
        $phase = Phase::find_by_id($this->related_phase);
        if ($phase) {
            return Site::find_by_id($phase->related_site()->id());
        }
    }

    public function related_phase() {
        return Phase::find_by_id($this->related_phase);
    }

    public function update_related_phase($idphase) {
        $this->related_phase = $idphase;
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
        return $this->public;
    }

    public function unpublished() {
        return $this->unpublished;
    }

    public function biblio_review($arg="") {
        if ($this->biblio_review || $this->related_phase()->biblio_review() || $this->related_phase()->related_site()->biblio_review()) {
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


    // Functions to add objects
    public function table_add($data_column='', $data_row=0) {
        echo "<td data-row='" . $data_row . "' data-column='" . $data_column . "'>";
        if ($data_column) {
            // Check s'il y a des erreurs associées
            if ($data_column === 'context_code' && in_array('code', $this->errors)) {
                if (strLen($this->code) > 0) {
                    echo "<div style='color:#B80000'>" . $this->code . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } elseif ($data_column === 'context_name' && in_array('name', $this->errors)) {
                if (strLen($this->name) > 0) {
                    echo "<div style='color:#B80000'>" . $this->name . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } elseif ($data_column === 'context_descr' && in_array('descr', $this->errors)) {
                if (strLen($this->descr) > 0) {
                    echo "<div style='color:#B80000'>" . $this->descr . "</div>";
                } else {
                    echo "<div style='color:#B80000'>ERROR</div>";
                }
            } else {
                // Sinon, affiche les données
                if ($data_column === 'context_code') {
                    echo $this->code;
                } elseif ($data_column === 'context_name') {
                    echo $this->name;
                } elseif ($data_column === 'context_descr') {
                    echo $this->descr;
                }
            }
        }
        echo '</td>';
    }

    // Lors de l'ajout de données par csv, check les erreurs, et ajoute les attributs problématiques à l'array errors
    public function check_errors_add($context_codes, $idsite) {
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
        $number = false;
        // Check si related_site
        if (!$idsite) {
            $this->errors[] = 'code';
            if (!in_array($this->code, $context_codes)) {
                $code = $this->code;
            }
        } else {
            // Check si code et phase pas déjà présent si nouveau ; check aussi dans les données déjà encodées
            if (Context::find_by_site_code($idsite, $this->code)) {
                if (err_not_unique('context', Site::find_by_id($idsite)->codename(), false)) { $this->errors[] = 'code'; }
            } elseif (in_array($this->code, $context_codes)) {
                $this->errors[] = 'code';
            } else {
                $code = $this->code;
            }
        }
        return $this->code;
    }
}

?>