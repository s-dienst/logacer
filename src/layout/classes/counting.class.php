<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Counting extends DatabaseObject {

    static protected $table_name = "counting";
    static protected $db_columns = ['id', 'name'];
    static protected $links = ['site'=>'site', 'user'=>'user'];
    static protected $max_chars = ['name'=>255];
    static protected $required = ['name'];
    static protected $uniques = ['name'];

    static public function manage($object) {
        $countings = Counting::find_all();
        $class = get_class($object);
        $class_countings = Counting::linked('counting', $class, $object->id(), true);
        foreach ($countings as $counting) {
            if (isset($_POST['counting'][$counting->id()])) {
                if (!in_array($counting, $class_countings)) {
                    $request = static::$connexion->query("INSERT INTO link_counting_{$class} (counting, {$class}) VALUES (" . $counting->id() . ", " . $object->id() . ")");
                }
            } elseif (in_array($counting, $class_countings)) {
                $request = static::$connexion->query("DELETE FROM link_counting_{$class} WHERE counting = " . $counting->id() . " AND {$class} = " . $object->id());
            }
        }
    }

    protected string $name;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
    }

    public function url($arg=false) {
        
    }

    public function codename() {
        return $this->name();
    }

}

?>