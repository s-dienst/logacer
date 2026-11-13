<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class FunctionTable extends DatabaseObject {

    static protected $table_name = "function_table";
    static protected $db_columns = ['id', 'code', 'name', 'onicer',
        'creator', 'date_creation', 'date_modification'];
    static protected $max_chars = ['code'=>16, 'name'=>128];
    static protected $required = ['code', 'name', 'creator'];
    static protected $uniques = ['code', 'name'];
    static protected $bool = ['onicer'];

    static public function find_by_name($name) {
        $object = static::find_by_sql("SELECT * FROM function_table WHERE name = :name", ['name'=>$name]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $name;
    protected int $onicer;
    protected int $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        if (isset($args['onicer'])) { if ($args['onicer']) { $this->onicer = 1; } else { $this->onicer = 0; } } else { $this->onicer = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function url($arg=false) {
        return create_url_proj(['functions']);
    }

    public function codename() {
        return $this->name();
    }

    public function code($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->code . "'>" . $this->code . "</td>";
        } else {
            return secure($this->code);
        }
    }

    public function name($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->name . "'>" . $this->name . "</td>";
        } else {
            return secure($this->name);
        }
    }

    public function onicer($arg="") {
        if ($arg == 'table') {
            if ($this->onicer) { $value = ucfirst(thesaurus("yes")); } else { $value = ucfirst(thesaurus('no')); }
            return "<td sort-text='" . $this->onicer . "'>" . $value . "</td>";
        }
    }

    public function owner($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . User::find_by_id($this->creator)->codename() . "'>" . User::find_by_id($this->creator)->codename() . "</td>";
        } else {
            return parent::owner($arg);
        }
    }

    public function modify($arg="") {
        if ($arg == 'table') {
            if (isset($_POST['typeaction'])) {
                return "<td></td>";
            } else {
                // avec bouton modifier et bouton supprimer ; contient l’ID de la fonction sous la forme object[id]
                $html = "<td><form action='" . $this->url() . "' method='post'>";
                $html .= "<button type='submit' class='btn btn-secondary btn-sm' name='typeaction' value='modifyfunction'>" . ucfirst(thesaurus('modify')) . "</button>";
                $html .= "<button type='submit' class='btn btn-danger btn-sm' name='typeaction' value='delete'>X</button>";
                $html .= "<input type='hidden' name='object[id]' value='" . $this->id . "'>";
                return $html . "</form></td>";
            }
        }
    }

}

?>