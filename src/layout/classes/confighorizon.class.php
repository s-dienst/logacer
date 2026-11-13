<?php

/* Description de l'objet
** Fonctions statiques corrigées :
    find_by_id(), find_all() ;
*/
class ConfigHorizon extends DatabaseObject {

    static protected $table_name = "config_horizon";
    static protected $db_columns = ['id', 'name', 'type', 'owner', 'date_creation', 'date_modification'];
    static protected $links = ['user'=>'contributor'];
    static protected $max_chars = ['name'=>64, 'type'=>32];
    static protected $required = ['name', 'type', 'owner'];

    static public function find_by_type($type, $ordering=['name']) {
        return static::find_by_property('type', $type, $ordering);
    }

    protected string $name;
    protected string $type;
    protected int $owner;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->type = $args['type'] ?? '';
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function delete($url=false, $children = [], $reverse = false) {
        // Supprime les liens selon nécessité
        if ($this->type === 'phases') {
            $phases = Phase::linked('config_horizon', 'phase_or_context', $this->id);
            foreach ($phases as $phase) {
                static::delink('config_horizon', 'phase_or_context', $this->id, $phase->id());
            }
        } elseif ($this->type === 'contexts') {
            $contexts = Context::linked('config_horizon', 'phase_or_context', $this->id);
            foreach ($contexts as $context) {
                static::delink('config_horizon', 'phase_or_context', $this->id, $context->id());
            }
        } elseif ($this->type === 'types') {
            // On doit carrément supprimer les objets intermédiaires
            $groups = ConfigHorizonType::find_by_parent($this->id());
            foreach ($groups as $group) {
                $group->delete();
            }
        }
        parent::delete($url, $children, $reverse);
    }

    public function url($arg=false) {
        return false;
    }

    public function codename($arg=false) {
        $codename = secure($this->name);
        return $codename;
    }

    public function type($arg=false) {
        return $this->type;
    }

    // On récupère la couleur
    public function color($item_id) {
        $request = DatabaseObject::$connexion->prepare("SELECT color FROM link_config_horizon_phase_or_context WHERE config_horizon = :idconfig AND phase_or_context = :iditem");
        $request->bindParam(':idconfig', $this->id);
        $request->bindParam(':iditem', $item_id);
        $success = $request->execute();
        if ($success) {
            return $request->fetchColumn();
        } else {
            return false;
        }
    }

    // On met à jour la couleur
    public function update_color($item_id, $color) {
        if (empty($color) || (strlen(strval($color)) > 10)) {
            return false;
        }
        $color = (string) $color;
        $request = DatabaseObject::$connexion->prepare("UPDATE link_config_horizon_phase_or_context SET color = :color WHERE config_horizon = :idconfig AND phase_or_context = :iditem");
        $request->bindParam(':color', $color);
        $request->bindParam(':idconfig', $this->id);
        $request->bindParam(':iditem', $item_id);
        $success = $request->execute();
        if ($success) {
            return true;
        } else {
            return false;
        }
    }

    public function create_link($item_id, $args=false) {
        if (in_array($this->type, ['phases', 'contexts']) && !empty($args) && (strlen(strval($args)) < 11)) {
            $color = strval($args);
            $request = DatabaseObject::$connexion->prepare("INSERT INTO link_config_horizon_phase_or_context (config_horizon, phase_or_context, color) VALUES (:idconfig, :iditem, :color)");
            $request->bindParam(':idconfig', $this->id);
            $request->bindParam(':iditem', $item_id);
            $request->bindParam(':color', $color);
            $success = $request->execute();
            return $success;
        }
        return false;
    }

}

?>