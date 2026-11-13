<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Fabric extends DatabaseObject {

    static protected $table_name = "fabric";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'origin', 'origin_html',
        'superfabric', 'owner', 'public', 'related_project', 'date_creation', 'date_modification'];
    static protected $links = ['bibliography'=>'bibliography', 'project'=>'project', 'user'=>'contributor'];
    static protected $parent = 'related_project';
    static protected $max_chars = ['code'=>64, 'name'=>255];
    static protected $required = ['code', 'name', 'owner'];
    static protected $uniques = ['code'];
    static protected $bool = ['public'];

    static public function find_by_code($code) {
        $object = static::find_by_sql("SELECT * FROM fabric WHERE code = :code", ['code'=>$code]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function linked_with_project() {
        $all_fabrics = Fabric::find_all();
        $fabrics = [];
        if (PROJECT) {
            $project_fabrics = Fabric::linked('fabric', 'project', PROJECT->id(), true);
            foreach ($all_fabrics as $fabric) {
                if (ISOLATED_WEBSITE && ($fabric->public() || $fabric->contributor_rights())) {
                    $fabrics[] = $fabric;
                }
                // AJOUTER UN LIEN link_fabric_project (si link_site_counting au lieu de link_counting_site, rajouter un true dans la fonction qui suit)
                if (!$fabric->project() && in_array($fabric, $project_fabrics)) {
                    $fabrics[] = $fabric;
                } elseif ($fabric->project() && $fabric->project()->id() === PROJECT->id() && ($fabric->contributor_rights() || $fabric->public())) {
                    $fabrics[] = $fabric;
                }
            }
        } else {
            foreach ($all_fabrics as $fabric) {
                if (!$fabric->project()) {
                    $fabrics[] = $fabric;
                }
            }
        }
        return $fabrics;
    }

    static public function global_fabrics() {
        $all_fabrics = Fabric::find_all();
        $fabrics = [];
        foreach ($all_fabrics as $f) {
            if (!$f->project()) {
                $fabrics[] = $f;
            }
        }
        return $fabrics;
    }

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected string $origin;
    protected string $origin_html;
    protected int $superfabric;
    protected int $public;
    protected int $related_project;
    protected int $owner;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->origin = $args['origin'] ?? '';
        $this->origin_html = $args['origin_html'] ?? '';
        $this->superfabric = $args['superfabric'] ?? 0;
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 1; } } else { $this->public = 1; }
        $this->related_project = $args['related_project'] ?? 0;
        if (isset($args['owner'])) {
            $this->owner = $args['owner'];
        } elseif (isset($_SESSION['user'])) {
            $this->owner = $_SESSION['user']->id();
        } else { $this->owner = 0; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function validate() {
        parent::validate();
        $this->errors = add_error($this->errors, check_exists($this->superfabric, 'fabric'));
        $this->errors = add_error($this->errors, check_exists($this->related_project, 'related_project'));
        // GARDER IDEE LIEN CATEGORIE ET UNIQUE
        // Superfabric ne peut pas être enfant de ce groupe de pâtes
        if ($this->superfabric()) { if ($this->superfabric()->is_children($this)) {
            $this->errors = add_error($this->errors, err_fabric('children'));
        }}    
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['fabric', $this->code, 'update']);
            } elseif ($arg == 'new_subfabric') {
                return create_url(['fabrics', 'new', $this->code]);
            } elseif ($arg == 'new') {
                return create_url(['fabrics', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['myfabrics']);
            } else {
                return create_url(['fabric', $this->code]);
            }
        } else {
            if (PROJECT) {
                $project_url = PROJECT->code();
            } else {
                $project_url = 'logacer';
            }
            if ($arg == 'update') {
                return create_url([$project_url, 'fabric', $this->code, 'update']);
            } elseif ($arg == 'new_subfabric') {
                return create_url([$project_url, 'fabrics', 'new', $this->code]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'fabrics', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'myfabrics']);
            } elseif ($arg == 'out_project') {
                return create_url(['logacer', 'fabric', $this->code]);
            } else {
                return create_url([$project_url, 'fabric', $this->code]);
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

    public function superfabric() {
        if ($this->superfabric) {
            return Fabric::find_by_id($this->superfabric);
        } else {
            return false;
        }
    }

    public function subfabrics() {
        return Fabric::find_by_property('superfabric', $this->id);
    }

    public function public() {
        if ($this->public) {
            return true;
        } else {
            return false;
        }
    }

    public function project() {
        if (!$this->related_project) {
            return false;
        }
        return Project::find_by_id($this->related_project);
    }

    public function main_page_project() {
        if (!$this->project()) {
            echo p(b(ucfirst(thesaurus('not_a_project_fabric')) . hyperlink($this->codename(), ['logacer', 'fabric', $this->code])));
        }
    }

    public function is_children($parent) {
        $children = false;
        $subfabrics = $parent->subfabrics();
        if (count($subfabrics) > 0) {
            // Récursif
            foreach ($subfabrics as $subfabric) {
                if ($subfabric->id() === $this->id()) {
                    return true;
                    break;
                } else {
                    $children = $this->is_children($subfabric);
                    if ($children) { return true; }
                }
            }
        }
        return $children;
    }

}

?>