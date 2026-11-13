<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    /

** Variables supplémentaires :
    /
*/
class Modifications extends DatabaseObject {

    static protected $table_name = "modifications";
    static protected $db_columns = ['id', 'model', 'previous_name', 'new_name',
        'impacted', 'date_creation'];
    static protected $max_chars = ['model'=>255, 'previous_name'=>255, 'new_name'=>255];
    static protected $required = ['model', 'previous_name', 'new_name', 'impacted'];

    protected string $model;
    protected string $previous_name;
    protected string $new_name;
    protected int $impacted;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->model = $args['model'] ?? '';
        $this->previous_name = $args['previous_name'] ?? '';
        $this->new_name = $args['new_name'] ?? '';
        $this->impacted = $args['impacted'] ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
    }

    public function validate() {
        parent::validate();
        // Check si les chiffres correspondent à quelque chose d'existant :
            $this->errors = add_error($this->errors, check_exists($this->impacted, 'user'));
    }

    public function url($arg=false) {
        
    }

    public function codename() {

    }

}

?>