<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Typology extends DatabaseObject {

    static protected $table_name = "typology";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'owner',
        'public', 'related_project', 'date_creation', 'date_modification'];
    static protected $links = ['bibliography'=>'bibliography', 'category'=>'category', 'project'=>'project', 'user'=>'contributor'];
    static protected $max_chars = ['code'=>64, 'name'=>255];
    static protected $required = ['code', 'name', 'owner'];
    static protected $uniques = ['code', 'name'];
    static protected $parent = 'related_project';
    static protected $bool = ['public'];

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected int $owner;
    protected int $public;
    protected int $related_project;

    static public function linked_with_project() {
        $all_typologies = Typology::find_all();
        $typologies = [];
        if (PROJECT) {
            $project_typologies = Typology::linked('typology', 'project', PROJECT->id(), true);
            foreach ($all_typologies as $typology) {
                if (ISOLATED_WEBSITE && ($typology->public() || $typology->contributor_rights())) {
                    $typologies[] = $typology;
                } elseif (!$typology->project() && in_array($typology, $project_typologies)) {
                    $typologies[] = $typology;
                } elseif ($typology->project() && $typology->project()->id() === PROJECT->id() && ($typology->contributor_rights() || $typology->public())) {
                    $typologies[] = $typology;
                }
            }
        } else {
            foreach ($all_typologies as $typology) {
                if (!$typology->project()) {
                    $typologies[] = $typology;
                }
            }
        }
        return $typologies;
    }

    static public function global_typologies() {
        $all_typologies = Typology::find_all();
        $typologies = [];
        foreach ($all_typologies as $t) {
            if (!$t->project()) {
                $typologies[] = $t;
            }
        }
        return $typologies;
    }

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        // Public : toujours 1 pour le moment
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        if (isset($args['related_project'])) { $this->related_project = intval($args['related_project']); } else { $this->related_project = 0; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function validate() {
        parent::validate();
        $this->errors = add_error($this->errors, check_exists($this->related_project, 'related_project'));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['typology', $this->id(), 'update']);
            } elseif ($arg == 'update_category') {
                return create_url(['typology', $this->id(), 'update_cat']);
            } elseif ($arg == 'new_type') {
                return create_url(['typology', $this->id(), 'new_type']);
            } elseif ($arg == 'new') {
                return create_url(['typology', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['mytypologies']);
            } else {
                return create_url(['typology', $this->id()]);
            }
        } else {
            if (PROJECT) {
                $project_url = PROJECT->code();
            } else {
                $project_url = "logacer";
            }
            $project_url = PROJECT->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'typology', $this->id(), 'update']);
            } elseif ($arg == 'update_category') {
                return create_url([$project_url, 'typology', $this->id(), 'update_cat']);
            } elseif ($arg == 'new_type') {
                return create_url([$project_url, 'typology', $this->id(), 'new_type']);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'typology', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'mytypologies']);
            } elseif ($arg == 'out_project') {
                return create_url(['logacer', 'typology', $this->id()]);
            } else {
                return create_url([$project_url, 'typology', $this->id()]);
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
            echo p(b(ucfirst(thesaurus('not_a_project_typology')) . hyperlink($this->codename(), ['logacer', 'typology', $this->id()])));
        }
    }

    public function link_cat($idcategory) {
        /*la méthode vérifie si il n'y a pas de types vec le nom des types
        de la typologie dans la catégorie ; s'il y en a, erreur 
        et return false ; sinon, return true */
        // Liste des types de la typologie
        $authorized = true;
        $types = Type::find_by_parent($this->id);
        foreach ($types as $type) {
            // Vérifie si déjà un type portant ce nom
            $request = static::$connexion->prepare("SELECT * FROM type
                LEFT JOIN typology ON typology.id = type.typology
                LEFT JOIN link_typology_category ON link_typology_category.typology = typology.id
                WHERE type.name = :typename AND link_typology_category.category = :idcategory");
            $t = $type->name();
            $request->bindParam(':typename', $t);
            $request->bindParam(':idcategory', $idcategory);
            $request->execute();
            if ($request->rowCount() > 0) {
                $authorized = false;
                // New error
                $this->errors = add_error($this->errors, err_typo_cat('link_cat', [$type->name(), Category::find_by_id($idcategory)->abbreviation()]));
            }  
        }
        if ($authorized) {
            // Link and return true
            $request = static::$connexion->query("INSERT INTO link_typology_category (typology, category) VALUES (" . $this->id . ", " . $idcategory . ")");
            return true;
        } else {
            return false;
        }
    }

    public function delink_cat($idcategory) {
        /* La méthode vérifie s'il y a des objets avec des types présents
        dans la typologie correspondant à la catégorie ; si oui, erreur
        et return false ; sinon, return true */
        /* OLD CODE
        $request = static::$connexion->prepare("SELECT * FROM object
            LEFT JOIN type ON type.id = object.type_link
            WHERE type.typology = :idtypology AND object.category_link = :idcategory");
        $request->bindParam(":idtypology", $this->id);
        $request->bindParam(":idcategory", $idcategory);
        $request->execute();
        */
        $category_abbr = Category::find_by_id($idcategory)->abbreviation();
        $request = static::$connexion->prepare("SELECT * FROM object
            LEFT JOIN type ON type.name = object.type_name
            WHERE type.typology = :idtypology AND object.category_abbr = :abbrcategory");
        $request->bindParam(":idtypology", $this->id);
        $request->bindParam(":abbrcategory", $category_abbr);
        $request->execute();
        if ($request->rowCount() > 0) {
            // New error
            $this->errors = add_error($this->errors, err_typo_cat('delink_cat', $category_abbr));
            return false;
        } else {
            // Delink and return true
            static::$connexion->query("DELETE FROM link_typology_category WHERE typology = " . $this->id . " AND category = " . $idcategory);
            return true;
        }
    }

}

?>