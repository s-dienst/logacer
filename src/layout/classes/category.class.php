<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Category extends DatabaseObject {

    static protected $table_name = "category";
    static protected $db_columns = ['id', 'code', 'abbreviation', 'name', 'onicer',
        'creator', 'color', 'date_creation', 'date_modification'];
    static protected $links = ['typology'=>'typology'];
    static protected $max_chars = ['code'=>16, 'abbreviation'=>16, 'name'=>255, 'color'=>6];
    static protected $required = ['code', 'abbreviation', 'name', 'creator'];
    static protected $uniques = ['code', 'abbreviation', 'name'];
    static protected $bool = ['onicer'];

    static public function find_by_abbr($abbr) {
        $object = static::find_by_sql("SELECT * FROM category WHERE abbreviation = :abbr", ['abbr'=>$abbr]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function find_by_code($code) {
        $object = static::find_by_sql("SELECT * FROM category WHERE code = :code", ['code'=>$code]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $abbreviation;
    protected string $name;
    protected int $onicer;
    protected int $creator;
    protected string $color;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->abbreviation = $args['abbreviation'] ?? '';
        $this->name = $args['name'] ?? '';
        if (isset($args['onicer'])) { if ($args['onicer']) { $this->onicer = 1; } else { $this->onicer = 0; } } else { $this->onicer = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->color = $args['color'] ?? '';
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->object_count = $args['object_count'] ?? 0;
    }

    public function url($arg=false) {
        return create_url_proj(['categories']);
    }

    public function delete($url, $children=[], $reverse=false) {
        parent::delete($url, $children, true);
    }

    public function codename() {
        return "<abbr title='" . $this->name . "'>" . $this->abbreviation . "</abbr>";
    }

    public function code($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->code . "'>" . $this->code . "</td>";
        } elseif (is_array($arg)) { if ($arg[0] == 'button') {
            if (in_array($this, Category::linked('typology', 'category', $arg[1]))) {
                $checked = " checked ";
            } else { $checked = ""; }
            // ADD COLOR TO BUTTON
            /* DOES NOT WORK ; TO CORRECT
            if (strlen($this->color) > 0) {
                $color = '#' . $this->color;
            } else { $color = '#000000'; }
            echo "<td sort-text='" . $this->code . "'><input type='checkbox' class='btn-check' name='category[" . $this->code . "]' id='id_category_" . $this->code . "'
                value='True'" . $checked . " onchange=" . '"' . "toggleColor('{$color}', '{$this->code}'" . ')"' . ">
                <label class='btn btn-primary' for='id_category_" . $this->code . "'
                id='" . $this->code . "_label'>" . $this->abbreviation . "</label></td>";
            */
            // WITHOUT COLOR
            echo "<td sort-text='" . $this->code . "'><input type='checkbox' class='btn-check' name='category[" . $this->code . "]' id='id_category_" . $this->code . "'
                value='True'" . $checked . ">
                <label class='btn btn-outline-primary' for='id_category_" . $this->code . "'
                id='" . $this->code . "_label'>" . $this->abbreviation . "</label></td>";
            
        }} else {
            return secure($this->code);
        }
    }

    public function abbreviation($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->abbreviation . "'>" . $this->abbreviation . "</td>";
        } else {
            return secure($this->abbreviation);
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

    public function color($arg="") {
        if ($arg == 'table') {
            return "<td sort-text='" . $this->color . "'>" . $this->color . "</td>";
        }
    }

    public function modify($arg="") {
        if ($arg == 'table') {
            if (isset($_POST['typeaction'])) {
                return "<td></td>";
            } else {
                // avec bouton modifier et bouton supprimer ; contient l’ID de la catégorie sous la forme object[id]
                $html = "<td><form action='" . $this->url() . "' method='post'>";
                $html .= "<button type='submit' class='btn btn-secondary btn-sm' name='typeaction' value='modifycategory'>" . ucfirst(thesaurus('modify')) . "</button>";
                $html .= "<button type='submit' class='btn btn-danger btn-sm' name='typeaction' value='delete'>X</button>";
                $html .= "<input type='hidden' name='object[id]' value='" . $this->id . "'>";
                return $html . "</form></td>";
            }
        }
    }

}

?>