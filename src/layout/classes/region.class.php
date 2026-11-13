<?php

/* Description de l'objet
** Fonctions statiques modifiées :
    find_all()

** Fonctions supplémentaires :
    country_region()

** Variables supplémentaires :
    /
*/
class Region extends DatabaseObject {

    static protected $table_name = "region";
    static protected $db_columns = ['id', 'code', 'name', 'country'];
    static protected $parent = 'country';
    static protected $links = ['facies'=>'facies'];
    static protected $max_chars = ['code'=>16, 'name'=>255];
    static protected $required = ['code', 'name', 'country'];
    static protected $uniques = ['code', 'name'];

    static public function find_all($ordering=[]) {
        return static::find_by_sql("SELECT region.id AS id, region.code AS code, region.name AS name, region.country AS country
            FROM region LEFT JOIN country ON region.country = country.id
            ORDER BY country.name, region.name");
    }

    static public function find_by_code($code) {
        $object = static::find_by_sql("SELECT * FROM region WHERE code = :code", ['code'=>$code]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $name;
    protected int $country;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->country = $args['country'] ?? 0;
    }

    public function validate() {
        parent::validate();
        $this->errors = add_error($this->errors, check_exists($this->country, 'country'));
    }

    public function url($arg=false) {
        if ($arg == 'update') {
            return create_url_proj(['geography', 'region', $this->code]);
        } elseif ($arg == 'new') {
            return create_url_proj(['geography', 'new', 'region']);
        } elseif ($arg == 'parent') {
            return create_url_proj(['geography']);
        } else {
            return create_url_proj(['geography']);
        }
    }

    public function codename() {
        return static::country_region();
    }

    public function country() {
        return Country::find_by_id($this->country);
    }

    public function country_region() {
        return secure(Country::find_by_id($this->country)->name() . ' - ' . $this->name);
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