<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    typology()

** Variables supplémentaires :
    /
*/
class Type extends DatabaseObject {

    static protected $table_name = "type";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'dating', 'dating_html',
        'onicer', 'typology', 'supertype', 'owner', 'date_creation', 'date_modification'];
    static protected $links = ['bibliography'=>'bibliography', 'horizon'=>'horizon'];
    static protected $max_chars = ['code'=>255, 'name'=>128];
    static protected $required = ['code', 'name', 'typology', 'owner'];
    static protected $parent = 'typology';
    static protected $uniques = ['code'];
    static protected $bool = ['onicer'];

    // USAGE CATEGORIE : d'abord, vérifier si catégorie correspond bien à quelque chose d'existant ;
    // ensuite, vérifier si type COHERENT avec catégorie --> PAS ENCORE AJOUTÉ
    static public function find_by_code($code, $category=false) {
        $object = static::find_by_sql("SELECT * FROM type WHERE code = :code", ['code'=>rud($code)]);
        if (!empty($object)) {
            $type = array_shift($object);
            // Check la catégorie
            if ($category) {
                $category = Category::find_by_id($category);
                // Vérifie si l'ID est bien celui d'une catégorie
                if ($category) {
                    // Vérifie s'il y a des catégories liées à la typologie du type
                    $link_cat = Category::linked('typology', 'category', $type->typology()->id());
                    // S'il y a bien des catégories liées, la catégorie du type doit faire partie de celles de la typologie
                    // Si pas de catégorie liée ou fait bien partie des catégories, on peut continuer et rendre le type
                    if (count($link_cat) > 0) {
                        if (!in_array($category, $link_cat)) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
            }
            return $type;
        } else {
            return false;
        }
    }

    // TODO : USAGE CATEGORIE : d'abord, vérifier si catégorie correspond bien à quelque chose d'existant ;
    // ensuite, vérifier si nom EXISTE pour catégorie
    static public function find_by_name($name, $category=false) {

        $object = static::find_by_sql("SELECT * FROM type WHERE name = :name", ['name'=>$name]);
        // Si pas d'objet, on tente avec le code
        if (count($object) === 0) {
            return static::find_by_code($name, $category);
        } else {
            // Sinon, deux cas de figure : avec ou sans catégorie
            // Sans catégorie : si plusieurs objets, on affine avec le code ; sinon, c'est OK
            if ($category === false) {
                if (count($object) > 1) {
                    return static::find_by_code($name, $category);
                } else {
                    return array_shift($object);
                }
            } else {
                // Check la catégorie
                $category_obj = Category::find_by_id($category);
                // Vérifie si l'ID est bien celui d'une catégorie
                if ($category_obj) {
                    // Avec catégorie : on doit vérifier pour chaque nom s'il y en a un de cohérent avec la catégorie
                    // Liste de types cohérents
                    $type_true = [];
                    foreach ($object as $type) {
                        // Vérifie s'il y a des catégories liées à la typologie du type
                        $link_cat = Category::linked('typology', 'category', $type->typology()->id());
                        // S'il y a bien des catégories liées, la catégorie du type doit faire partie de celles de la typologie pour être rajoutée aux type_true
                        // Si fait bien partie des catégories, type possible
                        if (count($link_cat) > 0) {
                            if (in_array($category_obj, $link_cat)) {
                                $type_true[] = $type;
                            }
                        }
                    }
                    if (count($type_true) === 1) {
                        return array_shift($type_true);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected string $dating;
    protected string $dating_html;
    protected int $onicer;
    protected int $typology;
    protected int $supertype;
    protected int $owner;
    
    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->dating = $args['dating'] ?? '';
        $this->dating_html = $args['dating_html'] ?? '';
        if (isset($args['onicer'])) { if ($args['onicer']) { $this->onicer = 1; } else { $this->onicer = 0; } } else { $this->onicer = 0; }
        if (isset($args['typology'])) { $this->typology = intval($args['typology']); } else { $this->typology = 0; }
        if (isset($args['supertype'])) { $this->supertype = intval($args['supertype']); } else { $this->supertype = 0; }
        if (isset($args['owner'])) { $this->owner = $args['owner']; } elseif (isset($_SESSION['user'])) { $this->owner = $_SESSION['user']->id(); } else { $this->owner = 0; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function validate() {
        parent::validate();
        $this->errors = add_error($this->errors, check_exists($this->typology, 'typology'));
        $this->errors = add_error($this->errors, check_exists($this->supertype, 'type'));
        // Nom unique pour la typologie
        if (count(Type::find_by_properties(['typology'=>$this->typology, 'name'=>$this->name])) > 0) {
            if (Type::find_by_properties(['typology'=>$this->typology, 'name'=>$this->name])[0]->id() !== $this->id()) {
                $this->errors = add_error($this->errors, err_not_unique('type1', $this->typology()->name(), false));
            }
        }
        // Nom unique pour catégorie
        $cats = Category::linked('typology', 'category', $this->typology()->id());
        if (count($cats) > 0) {
            foreach ($cats as $cat) {
                $name = $this->name;
                $same_name = Type::find_by_sql("SELECT * FROM type
                    LEFT JOIN typology ON type.typology = typology.id
                    LEFT JOIN link_typology_category ON typology.id = link_typology_category.typology
                    WHERE type.name = :typename AND link_typology_category.category = " . $cat->id() .
                    " AND type.id != " . $this->id, ['typename'=>$name]);
                if (count($same_name) > 0) {
                    $this->errors = add_error($this->errors, err_typo_cat('link_cat', [$this->name, $cat->codename()]));
                }
            }
        }
        // Supertype ne peut pas être enfant de ce type
        if ($this->supertype()) { if ($this->supertype()->is_children($this)) {
            $this->errors = add_error($this->errors, err_typo_cat('children'));
        }}
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['typology', $this->typology()->id(), 'type', $this->code, 'update']);
            } elseif ($arg == 'new_subtype') {
                return create_url(['typology', $this->typology()->id(), 'new_type', $this->code]);
            } elseif ($arg == 'new') {
                return create_url(['typology', $this->typology()->id(), 'new_type']);
            } elseif ($arg == 'parent') {
                return create_url(['typology', $this->typology()->id()]);
            } else {
                return create_url(['typology', $this->typology()->id(), 'type', $this->code]);
            }
        } else {
            if (PROJECT) {
                $project_url = PROJECT->code();
            } else {
                $project_url = 'logacer';
            }
            if ($arg == 'update') {
                return create_url([$project_url, 'typology', $this->typology()->id(), 'type', $this->code, 'update']);
            } elseif ($arg == 'new_subtype') {
                return create_url([$project_url, 'typology', $this->typology()->id(), 'new_type', $this->code]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'typology', $this->typology()->id(), 'new_type']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'typology', $this->typology()->id()]);
            } elseif ($arg == 'out_project') {
                return create_url(['logacer', 'typology', $this->typology()->id(), 'type', $this->code]);
            } else {
                return create_url([$project_url, 'typology', $this->typology()->id(), 'type', $this->code]);
            }
        }
    }

    public function codename($arg="") {
        if ($arg == 'title') {
            echo h(2, $this->name);
        } else {
            return $this->name;
        }
    }

    public function typology() {
        return Typology::find_by_id($this->typology);
    }

    public function supertype() {
        if ($this->supertype) {
            return Type::find_by_id($this->supertype);
        } else {
            return false;
        }
    }

    public function subtypes() {
        return Type::find_by_property('supertype', $this->id);
    }

    // CHeck if this is a subtype of another type
    public function is_children($parent) {
        $children = false;
        $subtypes = $parent->subtypes();
        if (count($subtypes) > 0) {
            // Récursif
            foreach ($subtypes as $subtype) {
                if ($subtype->id() === $this->id()) {
                    return true;
                    break;
                } else {
                    $children = $this->is_children($subtype);
                    if ($children) { return true; }
                }
            }
        }
        return $children;
    }

    public function main_page_project() {
        if (!$this->typology()->project()) {
            echo p(b(ucfirst(thesaurus('not_a_project_type')) . hyperlink($this->codename(), ['logacer', 'typology', $this->typology()->id(), 'type', $this->code])));
        }
    }


    public function is_linked($horizon_id) {
        $request = self::$connexion->prepare("SELECT type_link FROM link_horizon_type WHERE horizon = :horizon AND type = :type");
        $request->bindParam(':horizon', $horizon_id);
        $request->bindParam(':type', $this->id);
        $request->execute();
        $check = $request->fetch();
        if ($check) {
            return $check['type_link'];
        } else {
            return false;
        }
    }

    public function change_link_horizon($horizon_id, $new_value) {
        $link = $this->is_linked($horizon_id);
        // Cas 1 : créer nouveau lien
        if ($link === false) {
            if ($new_value !== 'not_linked') {
                $request = self::$connexion->prepare("INSERT INTO link_horizon_type (horizon, type, type_link) VALUES (:horizon, :type, :type_link)");
                $request->bindParam(':horizon', $horizon_id);
                $request->bindParam(':type', $this->id);
                $request->bindParam(':type_link', $new_value);
                return $request->execute();
            } else {
                return true;
            }
        } else {
            // Cas 2 : on supprime le lien
            if ($new_value === 'not_linked') {
                $request = self::$connexion->prepare("DELETE FROM link_horizon_type WHERE horizon = :horizon AND type = :type LIMIT 1");
                $request->bindParam(':horizon', $horizon_id);
                $request->bindParam(':type', $this->id);
                return $request->execute();
            } else {
                // Cas 3 : on update le lien
                $request = self::$connexion->prepare("UPDATE link_horizon_type SET type_link = :type_link WHERE horizon = :horizon AND type = :type LIMIT 1");
                $request->bindParam(':type_link', $new_value);
                $request->bindParam(':horizon', $horizon_id);
                $request->bindParam(':type', $this->id);
                return $request->execute();
            }
        }
    }

    // Renvoie true si tous les objets de ce type sans variante ou doute appartiennent à l'horizon
    public function check_objects_context_horizon($context_id, $horizon_id, $var=false, $doubt=false) {
        // D'abord, liste des catégories liées
        $linked_categories = Category::linked('typology', 'category', $this->typology()->id());
        $category_abbr = [];
        foreach ($linked_categories as $c) {
            $category_abbr[] = $c->abbreviation();
        }
        // Liste de phases appartenant à cet horizon
        foreach (Phase::find_by_property('horizon', $horizon_id) as $p) {
            // Liste de contextes appartenant à la phase
            foreach (Context::find_by_parent($p->id()) as $c) {
                // On vérifie si le contexte n'est pas celui avec lequel on compare
                if (!($c->id() === $context_id)) {
                    // On check s'il y a des objets dans ce contexte avec ce nom de type
                    $objects = ObjectTable::find_by_properties(['type_name'=>$this->name(), 'related_context'=>$c->id()]);
                    foreach ($objects as $object) {
                        // Pour chacun d'entre eux, trois vérifications : si type_var, type_doubt et catégorie correspond
                        if (in_array($object->category('simple'), $category_abbr) && !($var || $object->type_var()) && !($doubt || $object->type_doubt())) {
                            // Dans ce cas, il y a au moins un objet de ce type d'un autre contexte dans l'horizon
                            return false;
                        }
                    }
                }
            }
        }
        // Si vérification passée sans un return, c'est qu'on est dans un cas où tous les objets de ce type sont de ce contexte;
        return true;
    }
}

?>