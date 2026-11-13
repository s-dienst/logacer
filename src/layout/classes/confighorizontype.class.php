<?php

/* Description de l'objet
*/

class ConfigHorizonType extends DatabaseObject {

    static protected $table_name = "config_horizon_type";
    static protected $db_columns = ['id', 'name', 'config_horizon', 'creator', 'date_creation', 'date_modification'];
    static protected $parent = "config_horizon";
    static protected $links = ['type'=>'type'];
    static protected $max_chars = ['name'=>128];
    static protected $required = ['name', 'creator'];

    static public function find_by_config_name($config_id, $name, $ordering=['name']) {
        $object = static::find_by_sql("SELECT * FROM config_horizon_type WHERE config_horizon = :idconfig AND name = :name", ['idconfig'=>$config_id, 'name'=>rud($name)]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $name;
    protected int $config_horizon;
    protected int $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        if (isset($args['config_horizon'])) { $this->config_horizon = intval($args['config_horizon']); } else { $this->config_horizon = 0; }
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function delete($url = false, $children = [], $reverse = false) {
        // Supprime les liens selon nécessité
        $types = Type::linked('config_horizon_type', 'type', $this->id);
        foreach ($types as $type) {
            static::delink('config_horizon_type', 'type', $this->id, $type->id());
        }
        parent::delete($url, $children, $reverse);
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant : config_horizon :
        $this->errors = add_error($this->errors, check_exists($this->config_horizon, 'site', 'configHorizon'));
        // Check si name pas déjà présent pour config_horizon si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->config_horizon) {
            if ($this->id) {
                if (ConfigHorizonType::find_by_config_name($this->config_horizon, $this->name)) { if (ConfigHorizonType::find_by_config_name($this->config_horizon, $this->name)->id() != $this->id) {
                    $this->errors = add_error($this->errors, err_not_unique('config_horizon_type', $this->config_horizon()->codename(), false));
                }}
            } elseif (ConfigHorizonType::find_by_config_name($this->config_horizon, $this->name)) {
                $this->errors = add_error($this->errors, err_not_unique('config_horizon_type', $this->config_horizon()->codename(), false));
            }
        }
    }

    public function url($arg=false) {
        return false;
    }

    public function config_horizon() {
        return ConfigHorizon::find_by_id($this->config_horizon);
    }

    public function codename($arg=false) {
        $codename = secure($this->name);
        return $codename;
    }

    public function create_link($type_id, $args=false) {
        $type = Type::find_by_id($type_id);
        if ($type) {
            $request = DatabaseObject::$connexion->prepare("INSERT INTO link_config_horizon_type_type (config_horizon_type, type) VALUES (:idconfig, :idtype)");
            $request->bindParam(':idconfig', $this->id);
            $request->bindParam(':idtype', $type_id);
            $success = $request->execute();
            return $success;
        }
        return false;
    }

}

?>