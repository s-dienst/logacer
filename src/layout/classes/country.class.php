<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Variables supplémentaires :
    /
*/
class Country extends DatabaseObject {

    static protected $table_name = "country";
    static protected $db_columns = ['id', 'code', 'name'];
    static protected $parent = 'country';
    static protected $max_chars = ['code'=>16, 'name'=>255];
    static protected $required = ['code', 'name'];
    static protected $uniques = ['code', 'name'];

    static public function find_by_code($code) {
        $object = static::find_by_property('code', $code);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $name;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
    }

    public function url($arg=false) {
        if ($arg == 'update') {
            return create_url_proj(['geography', 'country', $this->code]);
        } elseif ($arg == 'new') {
            return create_url_proj(['geography', 'new', 'country']);
        } elseif ($arg == 'parent') {
            return create_url_proj(['geography']);
        } else {
            return create_url_proj(['geography']);
        }
    }

    public function codename() {
        return $this->code . " - " . $this->name();
    }

    public function modify_contrib() {
        if (isset($_SESSION['user'])) {
            if (User::find_by_id($_SESSION['user']->id())->is_contributor()) {
                return " <a class='btn btn-secondary btn-sm' href='" . $this->url('update') . "'>" . ucfirst(thesaurus("modify")) . "</a>";
            }
        }
    }

}

?>