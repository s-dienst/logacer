<?php

/* Description de l'objet
** Fonctions statiques :
    find_by_context_number()

** Fonctions supplémentaires :
    related_context()

** Variables supplémentaires :
    /
*/
class ObjectTable extends DatabaseObject {

    static protected $table_name = "object";
    static protected $db_columns = ['id', 'number',
        'category_abbr', 'category_litt', 'function_name', 'function_litt',
        'type_name', 'type_var', 'type_doubt', 'type_litt', 'fabric_code', 'fabric_litt',
        'stamp', 'diameter', 'comment', 'related_context', 'creator', 'date_creation', 'date_modification',
        'n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd'];
    static protected $links = ['file'=>'file'];
    static protected $parent = 'related_context';
    static public $max_chars = ['number'=>128, 'category_abbr'=>16, 'category_litt'=>128, 'function_name'=>128, 'function_litt'=>128, 'type_name'=>128, 'type_var'=>8, 'type_doubt'=>16, 'type_litt'=>128, 'fabric_code'=>64, 'fabric_litt'=>128, 'stamp'=>255, 'diameter'=>16, 'comment'=>255];
    static public $required = ['number', 'category_abbr', 'function_name', 'type_name', 'related_context', 'creator'];

    static public function find_by_context_number($idcontext, $number) {
        $object = static::find_by_sql("SELECT * FROM object WHERE related_context = :idcontext AND number = :number", ['idcontext'=>$idcontext, 'number'=>$number]);
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
                $sql = " LEFT JOIN context ON object.related_context = context.id
                LEFT JOIN phase ON context.related_phase = phase.id
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

    // Find public objects ; Base for category, function, fabric, type now
    static public function find_public($conditions=false, $left_join = false, $binds=[], $ordering=[], $conditions_ns= false, $limit=0, $offset_or_id=0) {
        // Crée le début de la formule pour les catégories, fonctions, types, groupes de pâtes
        $sql = "SELECT DISTINCT object.* FROM object" .
        static::sql_public('join');
        // Ajoute le "left join' si nécessaire pour les conditions
        if ($left_join) {
            $sql .= ' ' . $left_join . ' ';
        }
        // Ajoute les "WHERE" de base pour le public
        $sql .= static::sql_public('where');
        // Ajoute d'autres conditions (si pas objet : nécessaire de faire table.champ)
        if ($conditions) {
            $index = 0;
            foreach ($conditions as $property=>$value) {
                $sql .= ' AND ' . $property . " = :new_bind" . $index; 
                /*if (is_string($value)) {
                    $sql .= ' AND ' . $property . " = '" . $value . "'";
                } else {
                    $sql .= ' AND ' . $property . " = " . $value;
                }*/
                $binds['new_bind' . $index] = $value;
                $index++;
            }
        }
        // Ajoute des conditions à un format non standardisé
        if ($conditions_ns) {
            foreach ($conditions_ns as $condition) {
                $sql .= ' AND (' . $condition . ')';
            }
        }
        return static::find_by_sql($sql, $binds, $ordering, $limit, $offset_or_id);
    }

    // Find public objects ; Base for category, function, fabric, type now
    static public function count_public($conditions=false, $left_join = false, $binds=[], $ordering=[], $conditions_ns= false) {
        // Crée le début de la formule pour les catégories, fonctions, types, groupes de pâtes
        $sql = "SELECT COUNT(DISTINCT object.id) FROM object" .
        static::sql_public('join');
        // Ajoute le "left join' si nécessaire pour les conditions
        if ($left_join) {
            $sql .= ' ' . $left_join . ' ';
        }
        // Ajoute les "WHERE" de base pour le public
        $sql .= static::sql_public('where');
        // Ajoute d'autres conditions (si pas objet : nécessaire de faire table.champ)
        if ($conditions) {
            $index = 0;
            foreach ($conditions as $property=>$value) {
                $sql .= ' AND ' . $property . " = :new_bind" . $index; 
                /*if (is_string($value)) {
                    $sql .= ' AND ' . $property . " = '" . $value . "'";
                } else {
                    $sql .= ' AND ' . $property . " = " . $value;
                }*/
                $binds['new_bind' . $index] = $value;
                $index++;
            }
        }
        // Ajoute des conditions à un format non standardisé
        if ($conditions_ns) {
            foreach ($conditions_ns as $condition) {
                $sql .= ' AND (' . $condition . ')';
            }
        }
        return static::find_by_sql($sql, $binds, $ordering, 0, 0, true);
    }

    protected string $number;
    protected string $category_abbr;
    protected int $category_link;
    protected string $category_litt;
    protected string $function_name;
    protected int $function_link;
    protected string $function_litt;
    protected string $type_name;
    protected int $type_link;
    protected string $type_var;
    protected string $type_doubt;
    protected string $type_litt;
    protected string $fabric_code;
    protected int $fabric_link;
    protected string $fabric_litt;
    protected string $stamp;
    protected string $diameter;
    protected string $comment;
    protected int $related_context;
    protected int $creator;
    protected int $n_rim;
    protected int $n_bottom;
    protected int $n_handle;
    protected int $n_wall;
    protected int $n_mni;
    protected int $n_sherd;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->number = $args['number'] ?? '';
        $this->category_abbr = $args['category_abbr'] ?? '';
        $this->category_litt = $args['category_litt'] ?? '';
        $this->function_name = $args['function_name'] ?? '';
        $this->function_litt = $args['function_litt'] ?? '';
        $this->type_name = $args['type_name'] ?? '';
        $this->type_var = $args['type_var'] ?? '';
        $this->type_doubt = $args['type_doubt'] ?? '';
        $this->type_litt = $args['type_litt'] ?? '';
        $this->fabric_code = $args['fabric_code'] ?? '';
        $this->fabric_litt = $args['fabric_litt'] ?? '';
        $this->stamp = $args['stamp'] ?? '';
        $this->diameter = $args['diameter'] ?? '';
        $this->comment = $args['comment'] ?? '';
        if (isset($args['related_context'])) { $this->related_context = intval($args['related_context']); } else { $this->related_context = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        if (isset($args['n_rim'])) { $this->n_rim = intval($args['n_rim']); } else { $this->n_rim = 0; }
        if (isset($args['n_bottom'])) { $this->n_bottom = intval($args['n_bottom']); } else { $this->n_bottom = 0; }
        if (isset($args['n_handle'])) { $this->n_handle = intval($args['n_handle']); } else { $this->n_handle = 0; }
        if (isset($args['n_wall'])) { $this->n_wall = intval($args['n_wall']); } else { $this->n_wall = 0; }
        if (isset($args['n_mni'])) { $this->n_mni = intval($args['n_mni']); } else { $this->n_mni = 0; }
        if (isset($args['n_sherd'])) { $this->n_sherd = intval($args['n_sherd']); } else { $this->n_sherd = 0; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        // Construction des liens via les informations
        // Category : si abbréviation
        $cat = Category::find_by_abbr($this->category_abbr);
        if ($cat) {
            $this->category_link = $cat->id();
        } else { $this->category_link = 0; }
        // Function : si nom
        $func = FunctionTable::find_by_name($this->function_name);
        if ($func) {
            $this->function_link = $func->id();
        } else { $this->function_link = 0; }
        // Type : si nom (check par catégorie, si présente, déjà effectué)
        $typ = Type::find_by_name($this->type_name, $this->category_link);
        if ($typ) {
            $this->type_link = $typ->id();
        } else { $this->type_link = 0; }
        // Fabric : si code (vérifie si fabric présente)
        if (strlen($this->fabric_code) > 0) {
            $fab = Fabric::find_by_code($this->fabric_code);
            if ($fab) {
                $this->fabric_link = $fab->id();
            } else { $this->fabric_link = 0; }
        } else { $this->fabric_link = 0; }
    }

    public function validate() {
        parent::validate();
        // Check si number et context pas déjà présent si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->id) {
            if (ObjectTable::find_by_context_number($this->related_context, $this->number)) { if (ObjectTable::find_by_context_number($this->related_context, $this->number)->id() != $this->id) {
                $this->errors = add_error($this->errors, err_not_unique('object', $this->related_context()->codename(), false));
            }}
        } elseif (ObjectTable::find_by_context_number($this->related_context, $this->number)) {
            $this->errors = add_error($this->errors, err_not_unique('object', $this->related_context()->codename(), false));
        }
        // Check si les comptages sont supérieurs ou égaux à 0
        $this->errors = add_error($this->errors, check_range($this->n_rim, 0, false, "the n_rim"));
        $this->errors = add_error($this->errors, check_range($this->n_bottom, 0, false, "the n_bottom"));
        $this->errors = add_error($this->errors, check_range($this->n_handle, 0, false, "the n_handle"));
        $this->errors = add_error($this->errors, check_range($this->n_wall, 0, false, "the n_wall"));
        $this->errors = add_error($this->errors, check_range($this->n_mni, 0, false, "the n_mni"));
        $this->errors = add_error($this->errors, check_range($this->n_sherd, 0, false, "the n_sherd"));
        // Check si les chiffres correspondent à quelque chose d'existant pour related_context :
        $this->errors = add_error($this->errors, check_exists($this->related_context, 'context'));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['object', 'update', $this->id()]);
            } elseif ($arg == 'new_picture') {
                return create_url(['object', $this->id(), 'new_picture']);
            } elseif ($arg == 'new') {
                return create_url(['site', 'new', $this->related_context()->related_phase()->related_site()->owner('prop'), $this->related_context()->related_phase()->related_site()->code(), $this->related_context()->related_phase()->code(), $this->related_context()->code()]);
            } elseif ($arg == 'parent') {
                return create_url(['site', $this->related_context()->related_phase()->related_site()->owner('prop'), $this->related_context()->related_phase()->related_site()->code(), $this->related_context()->related_phase()->code(), $this->related_context()->code()]);
            } else {
                return create_url(['object', $this->id()]);
            }
        } else {
            $project_url = $this->related_context()->related_phase()->related_site()->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'object', 'update', $this->id()]);
            } elseif ($arg == 'new_picture') {
                return create_url([$project_url, 'object', $this->id(), 'new_picture']);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'site', 'new', $this->related_context()->related_phase()->related_site()->owner('prop'), $this->related_context()->related_phase()->related_site()->code(), $this->related_context()->related_phase()->code(), $this->related_context()->code()]);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'site', $this->related_context()->related_phase()->related_site()->owner('prop'), $this->related_context()->related_phase()->related_site()->code(), $this->related_context()->related_phase()->code(), $this->related_context()->code()]);
            } else {
                return create_url([$project_url, 'object', $this->id()]);
            }
        }
    }

    public function codename($arg="") {
        $codename = secure($this->related_context()->code() . thesaurus(':') . ' ' . $this->number . ' (' . $this->category_abbr . ')');
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    public function related_context() {
        return Context::find_by_id($this->related_context);
    }


    // Functions for tables
    public function site($arg="", $label=false) {
        if ($arg == 'table') {
            $site = $this->related_context()->related_phase()->related_site();
            return "<td sort-text='" . $site->code() . "'>" .
                $site->hyperlink("<abbr title='" . $site->name() . "'>" . $site->code() . "</abbr>") . "</td>";
        } else {
            $html = $this->related_context()->related_phase()->related_site()->hyperlink();
            if ($label) {
                return b(ucfirst(thesaurus('site') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function phase($arg="", $label=false) {
        if ($arg == 'table') {
            $phase = $this->related_context()->related_phase();
            return "<td sort-text='" . $phase->code() . "'>" .
                $phase->hyperlink("<abbr title='" . $phase->name() . "'>" . $phase->code() . "</abbr>") . "</td>";
        } else {
            $html = $this->related_context()->related_phase()->hyperlink();
            if ($label) {
                return b(ucfirst(thesaurus('phase') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; } 
        }
    }
    public function context($arg="", $label=false) {
        if ($arg == 'table') {
            $context = $this->related_context();
            return "<td sort-text='" . $context->code() . "'>" .
                $context->hyperlink("<abbr title='" . $context->name() . "'>" . $context->code() . "</abbr>") . "</td>";
        } else {
            $html = $this->related_context()->hyperlink();
            if ($label) {
                return b(ucfirst(thesaurus('context') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function horizon($arg="", $label=false) {
        if (PROJECT && !PROJECT->setting_horizon()) {
            return false;
        }
        // Check if horizon
        if ($this->related_context()->related_phase()->horizon()) {
            $horizon = $this->related_context()->related_phase()->horizon();
            // Check if horizon accessible
            if ($horizon->contributor_rights() || ($horizon->public() && $horizon->facies()->public())) {
                if ($arg == 'table') {
                    $result = true;
                    return "<td sort-text='" . $horizon->code() . "'>" .
                        $horizon->hyperlink("<abbr title='" . $horizon->name() . "'>" . $horizon->code() . "</abbr>") . "</td>";
                } else {
                    $html = $this->related_context()->related_phase()->horizon()->hyperlink();
                    if ($label) {
                        return b(ucfirst(thesaurus('horizon') . thesaurus(':'))) . ' ' . $html;
                    } else { return $html; }                
                }
            } else { $result = false; }
        } else { $result = false; }
        if (!$result) {
            if ($arg == 'table') {
                return "<td sort-text='~~'>/</td>";
            } else { return $result; }
        }
    }

    public function number($arg="", $label=false) {
        $html = $this->hyperlink($this->number);
        if ($arg == 'table') {
            return "<td sort-text='" . $this->number. "'>" . $html . "</td>";
        } elseif ($arg == 'simple') {
            return $this->number;
        } else {
            if ($label) {
                return b(ucfirst(thesaurus('number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function category($arg="", $label=false) {
        // Icone pour category_litt
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature() && $this->category_litt && $this->category_litt !== $this->category_abbr) {
            $icon_litt = " <i class='bi bi-book text-muted' title='" . ucfirst(thesaurus('origin category')) . thesaurus(':') . " " . $this->category_litt . "'></i>";
        } else {
            $icon_litt = "";
        }
        if ($arg == 'table') {
            if ($this->category_link) {
                $category = Category::find_by_id($this->category_link);
                $begin = "<td sort-text='" . $category->code() . "'>";
                return $begin . "<abbr title='" . $category->name() . "'>" . $category->abbreviation() . "</abbr>" . $icon_litt . "</td>";
            } else {
                return "<td sort-text='~" . $this->category_abbr . "'><div class='no-info'>" . $this->category_abbr . "</div>" . $icon_litt . "</td>";
            }
        } elseif ($arg == 'simple') {
            return $this->category_abbr;
        } else {
            if ($this->category_link) {
                $category = Category::find_by_id($this->category_link);
                $html = "<abbr title='" . $category->name() . "'>" . $category->abbreviation() . "</abbr>" . $icon_litt;
            } else {
                $html = "<i>" . $this->category_abbr . "</i>" . $icon_litt;
            }
            if ($label) {
                return b(ucfirst(thesaurus('category') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function category_link() {
        if ($this->category_link) {
            return $category = Category::find_by_id($this->category_link);
        } else {
            return false;
        }
    }

    public function category_litt() {
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature()) {
            return secure($this->category_litt);
        }
        return false;
    }

    public function function($arg="", $label=false) {
        // Icone pour function_litt
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature() && $this->function_litt && $this->function_litt !== $this->function_name) {
            $icon_litt = " <i class='bi bi-book text-muted' title='" . ucfirst(thesaurus('origin function')) . thesaurus(':') . " " . $this->function_litt . "'></i>";
        } else {
            $icon_litt = "";
        }
        if ($arg == 'table') {
            if ($this->function_link) {
                $function = FunctionTable::find_by_id($this->function_link);
                $begin = "<td sort-text='" . $function->code() . "'>";
                return $begin . $function->name() . $icon_litt . "</td>";
            } else {
                return "<td sort-text='~" . $this->function_name . "'><div class='no-info'>" . $this->function_name . "</div>" . $icon_litt . "</td>";
            }
        } elseif ($arg == 'simple') {
            return $this->function_name;
        } else {
            if ($this->function_link) {
                $function = FunctionTable::find_by_id($this->function_link);
                $html = $function->name() . $icon_litt;
            } else {
                $html = "<i>" . $this->function_name . "</i>" . $icon_litt;
            }
            if ($label) {
                return b(ucfirst(thesaurus('function') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function function_link() {
        if ($this->function_link) {
            return $category = FunctionTable::find_by_id($this->function_link);
        } else {
            return false;
        }
    }

    public function function_litt() {
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature()) {
            return secure($this->function_litt);
        } else {
            return false;
        }
    }

    public function type($arg="", $label=false) {
        // Icone pour type_litt
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature() && $this->type_litt && $this->type_litt !== $this->type_name) {
            $icon_litt = " <i class='bi bi-book text-muted' title='" . ucfirst(thesaurus('origin type')) . thesaurus(':') . " " . $this->type_litt . "'></i>";
        } else {
            $icon_litt = "";
        }
        if ($arg == 'table') {
            if ($this->type_link) {
                $type = Type::find_by_id($this->type_link);
                $html = "<td sort-text='" . $type->code() . "'>";
                $html .= $type->hyperlink($type->name());
            } else {
                if (ISOLATED_WEBSITE) {
                    $url_content = ['local_type', $this->type_name];
                } else {
                    $url_content = [PROJECT->code(), 'local_type', $this->type_name];
                }
                $html = "<td sort-text='~" . $this->type_name . "'>" . hyperlink("<div class='no-info'><abbr title='" . thesaurus('absent_type') . "'>" . $this->type_name . "</abbr></div>", $url_content);
            }
            if (!empty($this->type_var)) { $html .= ' ' . $this->type_var; }
            if (!empty($this->type_doubt)) { $html .= $this->type_doubt; }
            return $html . $icon_litt . "</td>";
        } elseif ($arg == 'simple') {
            $type = $this->type_name;
            if (strlen($this->type_var) > 0) { $type .= " " . $this->type_var; }
            if (strlen($this->type_doubt) > 0) { $type .= " " . $this->type_doubt; }
            return $type;
        } else {
            if ($this->type_link) {
                $type = Type::find_by_id($this->type_link);
                $html = $type->hyperlink($type->name());
            } else {
                if (ISOLATED_WEBSITE) {
                    $url_content = ['local_type', $this->type_name];
                } else {
                    $url_content = [PROJECT->code(), 'local_type', $this->type_name];
                }
                $html = hyperlink("<i><abbr title='" . thesaurus('absent_type') . "' style='color:black;'>" . $this->type_name . "</abbr></i>", $url_content);
            }
            if (!empty($this->type_var)) { $html .= ' ' . $this->type_var; }
            if (!empty($this->type_doubt)) { $html .= $this->type_doubt; }
            if ($label) {
                return b(ucfirst(thesaurus('type') . thesaurus(':'))) . ' ' . $html . $icon_litt;
            } else { return $html . $icon_litt; }
        }
    }

    public function type_link() {
        if ($this->type_link) {
            return Type::find_by_id($this->type_link);
        } else {
            return false;
        }
    }

    public function type_var() {
        if (strlen($this->type_var) > 0) {
            return $this->type_var;
        } else {
            return false;
        }
    }

    public function type_doubt() {
        if (strlen($this->type_doubt) > 0) {
            return $this->type_doubt;
        } else {
            return false;
        }
    }

    public function type_litt() {
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature()) {
            return secure($this->type_litt);
        } else {
            return false;
        }
    }

    public function fabric($arg="", $label=false) {
        // Icone pour fabric_litt
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature() && $this->fabric_litt && $this->fabric_litt !== $this->fabric_code) {
            $icon_litt = " <i class='bi bi-book text-muted' title='" . ucfirst(thesaurus('origin fabric')) . thesaurus(':') . " " . $this->fabric_litt . "'></i>";
        } else {
            $icon_litt = "";
        }
        if ($arg == 'table') {
            if ($this->fabric_link) {
                $fabric = Fabric::find_by_id($this->fabric_link);
                $html = "<td sort-text='" . $fabric->code() . "'>";
                $content = "<abbr title='" . $fabric->name() . "'>" . $fabric->code() . "</abbr>";
                $html .= $fabric->hyperlink($content);
            } else {
                if (!empty($this->fabric_code)) {
                    if (ISOLATED_WEBSITE) {
                    $url_content = ['local_fabric', $this->fabric_code];
                    } else {
                        $url_content = [PROJECT->code(), 'local_fabric', $this->fabric_code];
                    }
                    $html = "<td sort-text='~" . $this->fabric_code . "'>" . hyperlink("<div class='no-info'><abbr title='" . thesaurus('absent_fabric') . "'>" . $this->fabric_code . "</abbr></div>", $url_content);
                } else {
                    $html = "<td sort-text='~~'>";
                }
            }
            return $html . $icon_litt . "</td>";
        } elseif ($arg == 'simple') {
            return $this->fabric_code;
        } else {
            if ($this->fabric_link) {
                $fabric = Fabric::find_by_id($this->fabric_link);
                $html = $fabric->hyperlink("<abbr title='" . $fabric->name() . "'>" . $fabric->code() . "</abbr>");
            } else {
                if (!empty($this->fabric_code)) {
                    if (ISOLATED_WEBSITE) {
                        $url_content = ['local_fabric', $this->fabric_code];
                    } else {
                        $url_content = [PROJECT->code(), 'local_fabric', $this->fabric_code];
                    }
                    $html = hyperlink("<i><abbr title='" . thesaurus('absent_fabric') . "'>" . $this->fabric_code . "</abbr></i>", $url_content);
                } else { $html = "/"; }
            }
            if ($label) {
                return b(ucfirst(thesaurus('fabric') . thesaurus(':'))) . ' ' . $html . $icon_litt;
            } else { return $html . $icon_litt; }
        }
    }

    public function fabric_litt() {
        if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature()) {
            return secure($this->fabric_litt);
        } else {
            return false;
        }
    }

    public function n_rim($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_rim . "'>";
            if ($this->n_rim) { $html .= $this->n_rim; }
            return $html . "</td>";
        } else {
            $html = $this->n_rim;
            if ($label) {
                return b(ucfirst(thesaurus('rim_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function n_bottom($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_bottom . "'>";
            if ($this->n_bottom) { $html .= $this->n_bottom; }
            return $html . "</td>";
        } else {
            $html = $this->n_bottom;
            if ($label) {
                return b(ucfirst(thesaurus('bottom_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function n_handle($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_handle . "'>";
            if ($this->n_handle) { $html .= $this->n_handle; }
            return $html . "</td>";
        } else {
            $html = $this->n_handle;
            if ($label) {
                return b(ucfirst(thesaurus('handle_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function n_wall($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_wall . "'>";
            if ($this->n_wall) { $html .= $this->n_wall; }
            return $html . "</td>";
        } else {
            $html = $this->n_wall;
            if ($label) {
                return b(ucfirst(thesaurus('wall_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function n_mni($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_mni . "'>";
            if ($this->n_mni) { $html .= $this->n_mni; }
            return $html . "</td>";
        } else {
            $html = $this->n_mni;
            if ($label) {
                return b(ucfirst(thesaurus('mni_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function n_sherd($arg="", $label=false) {
        if ($arg == 'table') {
            $html = "<td sort-number='" . $this->n_sherd . "'>";
            if ($this->n_sherd) { $html .= $this->n_sherd; }
            return $html . "</td>";
        } else {
            $html = $this->n_sherd;
            if ($label) {
                return b(ucfirst(thesaurus('sherd_number') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function diameter($arg="", $label=false) {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->diameter . "'>" . $this->diameter . '</td>';
        } else {
            $html = $this->diameter;
            if ($label) {
                return b(ucfirst(thesaurus('diameter') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function stamp($arg="", $label=false) {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->stamp . "'>" . $this->stamp . '</td>';
        } else {
            $html = $this->stamp;
            if ($label) {
                return b(ucfirst(thesaurus('stamp') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function comment($arg="", $label=false) {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->comment . "'>" . $this->comment . '</td>';
        } else {
            $html = $this->comment;
            if ($label) {
                return b(ucfirst(thesaurus('comment') . thesaurus(':'))) . ' ' . $html;
            } else { return $html; }
        }
    }

    public function picture($arg="") {
        if ($arg == 'table') {
            if (Picture::find_by_parent($this->id())) {
                $html = "<td sort-number='1'>" . ucfirst(thesaurus('yes'));
            } else {
                $html = "<td sort-number='0'>";
            }
            return $html . "</td>";
        }
    }

    public function del_obj($arg="") {
        if ($arg == 'table') {
            $html = '<td>';
            if ($this->owner_rights()) {
                $html .= "<button type='submit' class='btn btn-light btn-sm' name='delete_object' value='" . $this->id() . "'>X</button>";
            }
            return $html . '</td>';
        }
    }

    // Functions to add objects
    public function table_add($data_column='', $data_row=0) {
        echo "<td data-row='" . $data_row . "' data-column='" . $data_column . "'>";
        if ($data_column) {
            // Check s'il y a des erreurs associées
            if (in_array($data_column, $this->errors)) {
                echo "<div style='color:#B80000'>" . $this->$data_column . "</div>";
            } elseif ($data_column === 'site' && in_array('related_context', $this->errors)) {
                echo "<div style='color:#B80000'>ERROR</div>";
            } elseif ($data_column === 'context' && in_array('related_context', $this->errors)) {
                echo "<div style='color:#B80000'>" . $this->related_context . "</div>";
            } else {
                // Sinon, affiche les données
                if ($this->related_context()->related_phase()->related_site()->project()->setting_litterature()) {
                    $cmp_array = ['number', 'diameter', 'stamp', 'comment', 'type_var', 'type_doubt', 'category_litt', 'function_litt', 'type_litt', 'fabric_litt'];
                } else {
                    $cmp_array = ['number', 'diameter', 'stamp', 'comment', 'type_var', 'type_doubt'];
                }
                if (in_array($data_column, $cmp_array)) {
                    echo $this->$data_column;
                } elseif (in_array($data_column, ['n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd'])) {
                    if ($this->$data_column > 0) {
                        echo $this->$data_column;
                    }
                } elseif ($data_column === 'site') {
                    echo $this->related_context()->related_phase()->related_site()->name();
                } elseif ($data_column === 'context') {
                    echo $this->related_context()->code();
                } elseif ($data_column === 'category_abbr') {
                    if ($this->category_link) {
                        echo $this->category_abbr;
                    } else {
                        echo "<div style='color:darkgray'>" . $this->category_abbr . "</div>";
                    }
                } elseif ($data_column === 'function_name') {
                    if ($this->function_link) {
                        echo $this->function_name;
                    } else {
                        echo "<div style='color:darkgray'>" . $this->function_name . "</div>";
                    }
                } elseif ($data_column === 'type_name') {
                    if ($this->type_link) {
                        echo $this->type_name;
                    } else {
                        echo "<div style='color:darkgray'>" . $this->type_name . "</div>";
                    }
                } elseif ($data_column === 'fabric_code') {
                    if ($this->fabric_link) {
                        echo $this->fabric_code;
                    } else {
                        echo "<div style='color:darkgray'>" . $this->fabric_code . "</div>";
                    }
                }
            }
        }
        echo '</td>';
    }

    // Lors de l'ajout de données par csv, check les erreurs, et ajoute les attributs problématiques à l'array errors
    public function check_errors_add($inventory_numbers) {
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
        // Check si related_context mentionné
        if (!$this->related_context) {
            $this->errors[] = 'related_context';
            $this->errors[] = 'number';
            if (!in_array($this->number, $inventory_numbers)) {
                $number = $this->number;
            }
        } else {
            // Check si number et context pas déjà présent si nouveau ; check aussi dans les données déjà encodées
            if (ObjectTable::find_by_context_number($this->related_context, $this->number)) {
                if (err_not_unique('object', $this->related_context()->codename(), false)) { $this->errors[] = 'number'; }
            } elseif (in_array($this->number, $inventory_numbers)) {
                $this->errors[] = 'number';
            } else {
                $number = $this->number;
            }
        }
        // Check si les comptages sont supérieurs ou égaux à 0
        if (check_range($this->n_rim, 0, false, "the n_rim")) { $this->errors[] = 'n_rim'; }
        if (check_range($this->n_bottom, 0, false, "the n_bottom")) { $this->errors[] = 'n_bottom'; }
        if (check_range($this->n_handle, 0, false, "the n_handle")) { $this->errors[] = 'n_handle'; }
        if (check_range($this->n_wall, 0, false, "the n_wall")) { $this->errors[] = 'n_wall'; }
        if (check_range($this->n_mni, 0, false, "the n_mni")) { $this->errors[] = 'n_mni'; }
        if (check_range($this->n_sherd, 0, false, "the n_sherd")) { $this->errors[] = 'n_sherd'; }
        // Vérifie si le related_context existe bel et bien
        if (check_exists($this->related_context, 'context')) { $this->errors[] = 'related_context'; }
        return $this->number;
    }
}

?>