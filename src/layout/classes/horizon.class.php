<?php

/* Description de l'objet
** Fonctions statiques :
    find_by_facies_code()

** Fonctions supplémentaires :
    facies()

** Variables supplémentaires :
    /
*/
class Horizon extends DatabaseObject {

    static protected $table_name = "horizon";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'dating', 'dating_html',
        'public', 'facies', 'superhorizon', 'owner', 'date_creation', 'date_modification'];
    static protected $links = ['file'=>'file', 'type'=>'type'];
    static protected $parent = 'facies';
    static protected $max_chars = ['code'=>32, 'name'=>255];
    static protected $required = ['code', 'name', 'facies', 'owner'];
    static protected $bool = ['public'];

    static public function find_by_facies_code($idfacies, $codehorizon) {
        $object = static::find_by_sql("SELECT * FROM horizon WHERE facies = :idfacies AND code = :codehorizon", ['idfacies'=>$idfacies, 'codehorizon'=>$codehorizon]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected string $dating;
    protected string $dating_html;
    protected int $public;
    protected int $facies;
    protected int $superhorizon;
    protected int $owner;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->dating = $args['dating'] ?? '';
        $this->dating_html = $args['dating_html'] ?? '';
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        if (isset($args['facies'])) { $this->facies = intval($args['facies']); } else { $this->facies = 0; }
        if (isset($args['superhorizon'])) { $this->superhorizon = intval($args['superhorizon']); } else { $this->superhorizon = 0; }
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant : facies, superhorizon :
        $this->errors = add_error($this->errors, check_exists($this->facies, 'facies'));
        $this->errors = add_error($this->errors, check_exists($this->superhorizon, 'horizon'));
        // Check si code pas déjà présent pour facies si nouveau ; si existant, check s'il y a d'autres objets que celui connu qui s'affiche
        if ($this->facies) {
            if ($this->id) {
                if (Horizon::find_by_facies_code($this->facies, $this->code)) { if (Horizon::find_by_facies_code($this->facies, $this->code)->id() != $this->id) {
                    $this->errors = add_error($this->errors, err_not_unique('horizon', $this->facies()->codename(), false));
                }}
            } elseif (Horizon::find_by_facies_code($this->facies, $this->code)) {
                $this->errors = add_error($this->errors, err_not_unique('horizon', $this->facies()->codename(), false));
            }
        }
    }

    public function delete($url, $children = [], $reverse = false) {
        $request = static::$connexion->prepare("UPDATE phase SET horizon = NULL WHERE horizon = :idhorizon");
        $request->bindParam(':idhorizon', $this->id);
        $request->execute();
        $request = static::$connexion->prepare("UPDATE horizon SET superhorizon = NULL WHERE superhorizon = :idhorizon");
        $request->bindParam(':idhorizon', $this->id);
        $request->execute();
        parent::delete($url, $children, $reverse);
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['horizons', 'update', $this->facies()->id(), $this->id()]);
            } elseif ($arg == 'new_subhorizon') {
                return create_url(['horizons', 'new', $this->facies()->id(), $this->id()]);
            } elseif ($arg == 'new') {
                return create_url(['horizons', 'new', $this->facies()->id()]);
            } elseif ($arg == 'parent') {
                return create_url(['horizons', $this->facies()->id()]);
            } else {
                return create_url(['horizons', $this->facies()->id(), $this->id()]);
            }
        } else {
            $project_url = $this->facies()->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'horizons', 'update', $this->facies()->id(), $this->id()]);
            } elseif ($arg == 'new_subhorizon') {
                return create_url([$project_url, 'horizons', 'new', $this->facies()->id(), $this->id()]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'horizons', 'new', $this->facies()->id()]);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'horizons', $this->facies()->id()]);
            } else {
                return create_url([$project_url, 'horizons', $this->facies()->id(), $this->id()]);
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

    public function facies() {
        return Facies::find_by_id($this->facies);
    }

    public function public() {
        return secure($this->public);
    }

    public function unpublished() {
        return secure($this->facies()->unpublished());
    }

    public function superhorizon() {
        if ($this->superhorizon) {
            return Horizon::find_by_id($this->superhorizon);
        } else {
            return false;
        }
    }

    public function subhorizons() {
        return Horizon::find_by_property('superhorizon', $this->id);
    }

    public function phases() {
        return Phase::find_by_property('horizon', $this->id);
    }

}

?>