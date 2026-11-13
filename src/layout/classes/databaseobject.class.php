<?php

/* Description de l'objet
** Variables statiques fixes :
    $connexion ; 
** Fonctions statiques fixes :
    connexion() ; set_databaset() ; instantiate() ; attributes() ;
    find_by_sql() ; find_all() ; find_by_id() ; find_by_parent()
    linked() ; delink()
** Variables communes :
    $id, $date_creation, $date_modification
    $errors
** Fonctions communes fixes :
    create() ; delete()
    id() ; name() ; owner() ; project() ; description() ;
    owner_rights() ; contributor_rights() ; no_contributor() ; check_post()
    manage_contributors() ; manage_bibliography()
    display_errors() ; buttons_contrib() ; hyperlink() ;


** Variables statiques dépendant de la classe :
    $table_name, $db_columns, $links, $max_chars, $required, $unique
    ($parent)

** Fonctions communes dépendant de la classe :
    url();
    __construct(), validate() ;
    codename() ;
*/
class DatabaseObject {

    static public $connexion;
    static public function connection() {
        return self::$connexion;
    }
    static protected $var_db = ['date_creation', 'date_modification'];
    static protected $table_name = "";
    static protected $db_columns = "";
    static protected $links = [];
    static protected $max_chars = [];
    static protected $required = [];
    static protected $uniques = [];
    static protected $bool = [];

    // Nécessaire pour les vérifications des installations
    static public function schema_definition(): array
    {
        return [
            'table' => static::$table_name,
            'columns' => static::$db_columns,
            'links' => static::$links
        ];
    }

    static public function set_database($connexion) {
        self::$connexion = $connexion;
    }

    static public function find_by_sql($sql, $binds=[], $ordering=[], int $limit=0, int $offset_or_id=0, bool $is_count=false) {
        // Si offset utilisé avec un ordering : nombre à passer, sinon : id
        if ($offset_or_id > 0 && count($ordering) === 0) {
            if (stripos($sql, 'WHERE') !== false) {
                $sql .= " AND ";
            } else {
                $sql .= " WHERE ";
            }
            $sql .= static::$table_name . ".id > " . (int) $offset_or_id;
        }
        if (count($ordering) > 0) {
            $sql .= " ORDER BY " . implode(", ", $ordering);
            if (!in_array('id', $ordering)) {
                $sql .= ", " . static::$table_name . ".id";
            }
        } elseif (!str_contains($sql, "ORDER BY")) {
            $sql .= " ORDER BY " . static::$table_name . ".id";
        }
        if ($limit > 0) {
            $sql .= " LIMIT " . (int) $limit;
        }
        if ($offset_or_id > 0 && count($ordering) > 0) {
            $sql .= " OFFSET " . (int) $offset_or_id;
        }
        // Query, according if bindings or not
        if (count($binds) > 0) {
            $request = self::$connexion->prepare(strtolower($sql));
            foreach ($binds as $key=>&$value) {
                $request->bindParam(':' . strtolower($key), $value);
            }
            $request->execute();
        } else {
            $request = self::$connexion->query(strtolower($sql));
        }

        if (!$request) {
            exit("Database query failed.");
        }

        // If count : result as int
        if ($is_count) {
            $result = (int) $request->fetchColumn();
        } else {
            // Else : results into objects
            $result = array();
            while($record = $request->fetch()) {
                $result[] = static::instantiate($record);
            }
        }

        return $result;
    }

    static public function find_all($ordering=[]) {
        if (count($ordering) == 0) {
            if (property_exists(get_called_class(), 'code')) {
                array_push($ordering, 'code');
            } if (property_exists(get_called_class(), 'name')) {
                array_push($ordering, 'name');
            }
        }
        return static::find_by_sql("SELECT * FROM " . static::$table_name, [], $ordering);
    }

    static public function find_by_id($id) {
        if (!$id) { return false; }
        $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id = :id", ['id'=>$id]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function find_by_parent($id, $ordering=[], $limit=0, $offset_or_id=0) {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . static::$parent . " = :id", ['id'=>$id], $ordering, $limit, $offset_or_id);
    }

    static public function count_by_parent($id) {
        return static::find_by_sql("SELECT COUNT(*) FROM " . static::$table_name . " WHERE " . static::$parent . " = :id", ['id'=>$id], [], 0, 0, true);
    }

    static public function find_by_property($property, $value, $ordering=[]) {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . $property . " = :property", ['property'=>$value], $ordering);
    }

    static public function find_by_properties(array $properties, $ordering=[]) {
        $search = [];
        foreach($properties as $property=>$value) {
            $search[] = $property . ' = :' . $property;
        }
        $search = implode(' AND ', $search);
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . $search, $properties, $ordering);
    }

    // Find with object count ; Base for category, function, fabric, type now
    static public function find_woc($idvalue, $conditions=false, $left_join = false, $ordering=[], $conditions_ns=[]) {
        // Crée le début de la formule pour les catégories, fonctions, types, groupes de pâtes
        /* if (in_array(get_called_class(), ['Category', 'FunctionTable', 'Type', 'Fabric'])) {
            $sql = "SELECT " . static::$table_name . ".*, COUNT(DISTINCT object.id) AS object_count FROM object
            LEFT JOIN " . static::$table_name . " ON " . static::$table_name . ".id = object." . static::$table_name . "_link" .
            ObjectTable::sql_public('join');*/
        if (get_called_class() === 'Category') {
            $sql = "SELECT " . static::$table_name . ".*, COUNT(DISTINCT object.id) AS object_count FROM object
            LEFT JOIN " . static::$table_name . " ON " . static::$table_name . ".abbreviation = object." . static::$table_name . "_abbr" .
            ObjectTable::sql_public('join');
        } elseif (in_array(get_called_class(), ['FunctionTable', 'Type'])) {
            $sql = "SELECT " . static::$table_name . ".*, COUNT(DISTINCT object.id) AS object_count FROM object
            LEFT JOIN " . static::$table_name . " ON " . static::$table_name . ".name = object." . static::$table_name . "_name" .
            ObjectTable::sql_public('join');
        } elseif (get_called_class() === 'Fabric') {
            $sql = "SELECT " . static::$table_name . ".*, COUNT(DISTINCT object.id) AS object_count FROM object
            LEFT JOIN " . static::$table_name . " ON " . static::$table_name . ".code = object." . static::$table_name . "_code" .
            ObjectTable::sql_public('join');
        } elseif (in_array(get_called_class(), ['Site', 'Phase', 'Context'])) {
            $sql = "SELECT " . static::$table_name . ".*, COUNT(DISTINCT object.id) AS object_count FROM object" .
            ObjectTable::sql_public('join');
        }
        // Ajoute le "left join' si nécessaire pour les conditions
        if ($left_join) {
            $sql .= ' ' . $left_join . ' ';
        }
        // Ajoute les "WHERE" de base pour le public
        $sql .= ObjectTable::sql_public('where');
        // Vérifie si on a une valeur d'ID, si pas de valeur (dans ce cas, tous ce qui correspond aux conditions)
        if (!is_array($idvalue)) {
            if ($idvalue > 0) {
                // Il y a une valeur d'ID et donc un seul objet récupéré
                $sql .= ' AND ' . static::$table_name . ".id = " . $idvalue;
                $one_value = true;
            } else {
                // Il n'y a pas de valeur
                $one_value = false;
            }
        } else {
            // Array de valeurs à prendre en compte
            $idvalue = implode(', ', $idvalue);
            $sql .= ' AND ' . static::$table_name . '.id IN (' . $idvalue . ')';
        }
        // Ajoute d'autres conditions (si pas object : nécessaire de faire table.champ)
        $binds = [];
        $increment = 1;
        if ($conditions) {
            foreach ($conditions as $property=>$value) {
                if (is_array($value)) {
                    if ($value[0]) {
                        $sql .= ' AND ' . $property . " IN ('" . implode("', '", $value[1]) . "')";
                    } else {
                        $sql .= ' AND ' . $property . " NOT IN ('" . implode("', '", $value[1]) . "')";
                    }
                } elseif ($value === 'IS NULL') {
                    $sql .= ' AND ' . $property . ' IS NULL';
                } else {
                    $sql .= ' AND ' . $property . ' = :valuewoc' . $increment;
                    $binds['valuewoc' . $increment] = $value;
                    $increment++;    
                }
            }
        }
        // Ajoute des conditions à un format non standardisé
        if ($conditions_ns) {
            foreach ($conditions_ns as $condition) {
                $sql .= ' AND (' . $condition . ')';
            }
        }
        // Ajoute le groupement
        $sql .= ' GROUP BY ' . static::$table_name . ".id";
        $result = static::find_by_sql($sql, $binds, $ordering);
        if ($one_value) {
            if (!empty($result)) {
                return array_shift($result);
            } else {
                return false;
            }    
        } else {
            return $result;
        }
    }

    // Display SQL parts for selection of accessible objects only
    static public function sql_public($part) {
        switch ($part) {
            case "join":
                return "";
                break;
            case "where":
                return "";
                break;
        }
    }

    // Find public elements ; Base for category, function, fabric, type now
    static public function find_public($conditions=false, $left_join = false, $binds=[], $ordering=[], $conditions_ns= false, $limit=0, $offset_or_id=0) {
        // Crée le début de la formule pour les catégories, fonctions, types, groupes de pâtes
        $sql = "SELECT DISTINCT " . static::$table_name . ".* FROM " . static::$table_name .
        static::sql_public('join');
        // Ajoute le "left join' si nécessaire pour les conditions
        if ($left_join) {
            $sql .= ' ' . $left_join . ' ';
        }
        // Ajoute les "WHERE" de base pour le public
        $sql .= static::sql_public('where');
        // Ajoute d'autres conditions (si pas objet : nécessaire de faire table.champ)
        if ($conditions) {
            foreach ($conditions as $property=>$value) {
                if (is_string($value)) {
                    $sql .= ' AND ' . $property . " = '" . $value . "'";
                } else {
                    $sql .= ' AND ' . $property . " = " . $value;
                }
            }
        }
        // Ajoute des conditions à un format non standardisé
        if ($conditions_ns) {
            foreach ($conditions_ns as $condition) {
                $sql .= ' AND (' . $condition . ')';
            }
        }
        return static::find_by_sql($sql, $binds, $ordering, $limit, $offset_or_id);
    }

    static protected function instantiate($record) {
        $object = new static ($record);
        /* foreach($record as $property => $value) {
            if(property_exists($object, $property)) {
                $object->$property = $value;
            }
        } */
        return $object;
    }

    // This function, called in a Database Class, return all the records from the class that have a many-to-many relationship
    // typed as link_$link_name1_$link_name2, with $link_name1 and $link_name2 as identifiers from the classes.
    // If not reverse, the records are the ones from link_name2 and id from link_name1 ; if reverse, the opposite
    static public function linked($link_name1, $link_name2, $object_id, $reverse = false, $suppl = true) {
        $changes = [];
        foreach (static::$db_columns as $column) {
            $changes[] = static::$table_name . "." . $column . " AS " . $column;
        }
        if (!$reverse) {
            $first = $link_name2 . " = " . static::$table_name;
            $second = $link_name1;
        } else {
            $first = $link_name1 . " = " . static::$table_name;
            $second = $link_name2;
        }
        if ($link_name2 == 'bibliography' && $suppl) {
            $changes[] = "link_" . $link_name1 . "_bibliography.pagination AS pagination"; 
        }
        return static::find_by_sql("SELECT " . implode(", ", $changes) . " FROM " . static::$table_name . " INNER JOIN link_"
            . $link_name1 . "_" . $link_name2 . " ON link_" . $link_name1 . "_" . $link_name2 . "." . $first
            . ".id WHERE link_" . $link_name1 . "_" . $link_name2 . "." . $second . " = :" . $second, [$second=>$object_id]);
    }

    // This function, called in a Database Class, delete a record from the class that have a many-to-many relationship
    // typed as link_$link_name1_$link_name2, with $link_name1 and $link_name2 as identifiers from the classes.
    // The two identifiers refers to the respective classes
    static public function delink($link_name1, $link_name2, $object_id1, $object_id2) {
        $request = static::$connexion->prepare("DELETE FROM link_" . $link_name1 . "_" . $link_name2
            . " WHERE " . $link_name1 . " = :name1 AND " . $link_name2 . " = :name2");
        $request->bindParam(':name1', $object_id1);
        $request->bindParam(':name2', $object_id2);
        return $request->execute();
    }

    protected array $errors = [];

    protected int $id;
    protected $date_creation;
    protected $date_modification;
    
    protected int $object_count;

    // Check par défaut les caractères maximaux, les blancs et l'owner ou le créateur
    public function validate() {
        foreach(static::$max_chars as $name=>$max) {
            $this->errors = add_error($this->errors, check_max_char($this->$name, $max, "the " . $name));
        }
        foreach(static::$required as $name) {
            $this->errors = add_error($this->errors, check_blank($this->$name, "a " . $name));
        }
        if (property_exists(get_called_class(), 'owner')) { $name = 'owner'; }
        elseif (property_exists(get_called_class(), 'creator')) { $name = 'creator'; }
        if (property_exists(get_called_class(), 'owner') || property_exists(get_called_class(), 'creator')) {
            $owner = User::find_by_id($this->$name);
            $users = User::find_all();
            if (!in_array($owner, $users)) {
                $this->errors = add_error($this->errors, err_owner(get_called_class(), $name));
            }
        }
        foreach (static::$uniques as $unique) {
            $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE " . $unique . " = :attachment OR " . $unique . " = :attachment2", ['attachment'=>$this->$unique, 'attachment2'=>rud($this->$unique)]);
            if (!empty($object)) {
                if (!$this->id) {
                    $this->errors = add_error($this->errors, err_not_unique($unique, get_called_class()));
                } elseif (array_shift($object)->id() != $this->id) {
                    $this->errors = add_error($this->errors, err_not_unique($unique, get_called_class()));
                }
            }
        }
    }

    protected function create() {
        $this->validate();
        if(!empty($this->errors)) { return false; }

        $attributes = $this->attributes();
        $sql = "INSERT INTO " . static::$table_name . " (";
        // Prochaines lignes : adaptation de la formule pour ne tenir compte que des attributs initialisés (sinon, problème avec les valeurs numériques)
        foreach ($attributes as $key=>&$value) { if ($value || $value === false) { $columns[] = $key; }}
        $sql .= join(', ', $columns);
        // $sql .= join(', ', static::$db_columns);
        $sql .= ") VALUES (";
        // Idem
        $sql .= join(', ', array_map(function($col){ return ":" . $col; }, $columns));
        // $sql .= join(', ', array_map(function($col){ return ":" . $col; }, static::$db_columns));
        $sql .= ")";
        $request = self::$connexion->prepare($sql);
        foreach ($attributes as $key=>&$value) {
            if ($value || $value === false) { 
                $request->bindParam(':' . $key, $value);
            }
        }
        $request->execute();
        if($request) {
            $this->id = self::$connexion->lastInsertId();
        }
        return $request;
    }

    protected function update() {
        $this->validate();
        if (!empty($this->errors)) { return false; }

        $attributes = $this->attributes();
        $attribute_pairs = [];
        foreach ($attributes as $key=>&$value) {
            if ($value || $value === false) { $attribute_pairs[] = "{$key} = :{$key}";
            } elseif (in_array($key, static::$bool)) {
                $attribute_pairs[] = "{$key} = 0";
            } elseif (!in_array($key, static::$var_db)) {
                $attribute_pairs[] = "{$key} = NULL";
            }
            // $attribute_pairs[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(', ', $attribute_pairs);
        $sql .= " WHERE id = :id LIMIT 1";
        $request = self::$connexion->prepare($sql);
        foreach ($attributes as $key=>&$value) {
            if ($value || $value === false) { 
                $request->bindParam(':' . $key, $value);
            }
        }
        $request->bindParam(':id', $this->id);
        $request->execute();
        return $request;
    }

    protected function update_html() {
        foreach (static::$db_columns as $column) {
            if (str_contains($column, '_html')) {
                // TODO : Intégrer suppression des balises
                $new_column = substr($column, 0, -5);
                $content = $this->$column;
                $delete = array('&lt;b&gt;', '&lt;/b&gt;', '&lt;strong&gt;', '&lt;/strong&gt;',
                '&lt;i&gt;', '&lt;/i&gt;', '&lt;em&gt;', '&lt;/em&gt;',
                '&lt;h3&gt;', '&lt;/h3&gt;', '&lt;h4&gt;', '&lt;/h4&gt;', '&lt;h5&gt;', '&lt;/h5&gt;', '&lt;h6&gt;', '&lt;/h6&gt;',
                '&lt;p&gt;', '&lt;/p&gt;', '&lt;br&gt;', '&lt;br/&gt;',
                '&lt;ol&gt;', '&lt;/ol&gt;', '&lt;ul&gt;', '&lt;/ul&gt;', '&lt;li&gt;', '&lt;/li&gt;',
                '<b>', '</b>', '<strong>', '</strong>',
                '<i>', '</i>', '<em>', '</em>',
                '<h3>', '</h3>', '<h4>', '</h4>', '<h5>', '</h5>', '<h6>', '</h6>',
                '<p>', '</p>', '<br>', '<br/>',
                '<ol>', '</ol>', '<ul>', '</ul>', '<li>', '</li>');
                foreach ($delete as $balise) {
                    $content = str_replace($balise, "", $content);
                }
                $this->$new_column = $content;
            }
        }
    }

    public function save() {
        $this->update_html();
        if ($this->id) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    public function attributes() {
        foreach (static::$db_columns as $column) {
            if ($column == 'id') { continue; }
            if (isset($this->$column)) {
                $attributes[$column] = $this->$column;
            }
        }
        return $attributes;
    }

    // Reverse true useful for files, bibliography. Children : name of the classes depending of this classe
    public function delete($url, $children = [], $reverse = false) {
        if ($this->owner_rights()) {
            $have_children = false;
            foreach ($children as $child) {
                $child = ucfirst($child);
                // If static is site, and child is phase, there is by default one phase to delete
                if (strtolower(get_called_class()) == 'site' && strtolower($child) == 'phase') { $min = 1; } else { $min = 0; }
                if (count($child::find_by_parent($this->id)) > $min) {
                    $this->errors = add_error($this->errors, ucfirst(thesaurus("cannot_delete_children")) . thesaurus($child) . ".");
                    $have_children = true;
                }
            }
            if (!$have_children) {
                // Delete default phase if site
                if (get_called_class() == 'site') {
                    $phase = Phase::find_by_site_code($this->id, '00');
                    $phase->delete(false, ['context']);
                }
                // Delete counting links if user
                if (get_called_class() == 'user') {
                    $countings = Counting::linked('counting', 'user', $this->id, true);
                    foreach ($countings as $counting) {
                        DatabaseObject::delink('counting', 'user', $counting->id(), $this->id);
                    }
                }
                // Delete all links
                foreach (static::$links as $key=>$link) {
                    if (!$reverse || (static::$table_name == 'bibliography' && $link == 'file')) {
                        $objects = $key::linked(static::$table_name, $link, $this->id);
                        foreach ($objects as $object) {
                            DatabaseObject::delink(static::$table_name, $link, $this->id, $object->id());
                        }
                    } else {
                        $objects = $key::linked($link, static::$table_name, $this->id, true);
                        foreach ($objects as $object) {
                            DatabaseObject::delink($link, static::$table_name, $object->id(), $this->id);
                        }
                    }
                }
                // Delete object
                $request = static::$connexion->prepare("DELETE FROM " . static::$table_name . " WHERE id = :id LIMIT 1");
                $request->bindParam(':id', $this->id);
                $request->execute();
                // Si suppression de la phase, on ne doit pas faire de redirection de suite
                if (!isset($phase) && $url) {
                    header('Location: ' . $url);
                    exit();
                }
            }
        } else {
            $this->errors = add_error($this->errors, ucfirst(thesaurus('not_owner')) . ' ' . thesaurus('this ' . get_called_class()) . ' ' . thesaurus('cannot_delete'));
        }
    }

    public function url($arg=false) {
        return BASE_URL;
    }

    public function hyperlink($content="") {
        if (!$content) { $content = $this->codename(); }
        return "<a href='" . $this->url() . "'>" . $content . "</a>";
    }

    public function id() {
        return $this->id;
    }

    public function code($arg="") {
        return secure($this->code);
    }

    public function name($arg="") {
        return secure($this->name);
    }

    // Check of owner rights, = is creator/owner, or creator/owner of a parent
    public function owner_rights() {
        $rights = false;
        if (isset($_SESSION['user'])) {
            if (property_exists(get_called_class(), 'owner')) {
                if ($this->owner == $_SESSION['user']->id) { return true; }
            } elseif (property_exists(get_called_class(), 'creator')) {
                if ($this->creator == $_SESSION['user']->id) { return true; }
            }
            if (property_exists(get_called_class(), 'parent')) {
                $parent = static::$parent;
                if ($this->$parent()) {
                    $rights = $this->$parent()->owner_rights();
                }
            }
        }
        return $rights;
    }

    // Check of contributor rights, = has owner or is creator/contributor of a parent
    public function contributor_rights() {
        if ($this->owner_rights()) { return true; }
        $rights = false;
        if (isset($_SESSION['user'])) {
            if (property_exists(get_called_class(), 'parent')) {
                $parent = static::$parent;
                if ($this->$parent()) {
                    $rights = $this->$parent()->contributor_rights();
                }
            }
            if (!$rights) {
                if (in_array('contributor', static::$links)) {
                    $contributors = User::linked(static::$table_name, 'contributor', $this->id);
                    foreach($contributors as $contributor) {
                        if ($contributor->id() == $_SESSION['user']->id) {
                            $rights = true;
                        }
                    }
                }
            }
        }
        return $rights;
    }

    // Check and display owner or creator, if exists. If not, do nothing.
    public function owner($arg=false) {
        if (property_exists(get_called_class(), 'owner')) {
            if ($this->owner) {
                $owner = User::find_by_id($this->owner);
            } elseif (isset($_SESSION['user'])) {
                $owner = User::find_by_id($_SESSION['user']->id());
            }
            if (isset($owner)) {
                if ($arg == 'prop') { return $owner->id(); } else {
                    echo ucfirst(thesaurus(get_called_class())) . ' ' . thesaurus('managed by') . ' ' . b($owner->codename()) . ". ";
                }
            }
        } elseif (property_exists(get_called_class(), 'creator')) {
            if ($this->creator) {
                $creator = User::find_by_id($this->creator);
            } elseif (isset($_SESSION['user'])) {
                $creator = User::find_by_id($_SESSION['user']->id());
            }
            if (isset($creator)) {
                if ($arg == 'prop') { return $creator->id(); } else {
                    echo ucfirst(thesaurus(get_called_class())) . ' ' . thesaurus('created by') . ' ' . b($creator->codename()) . ". ";
                }
            }
        }
    }

    // TODO : sécuriser le texte ; pour le moment, pas le html
    public function description($arg="", $name='descr') {
        $name_html = $name . '_html';
        if (property_exists(get_called_class(), $name)) {
            if ($arg == 'display') {
                if (!empty($this->$name)) {
                    $html = h(3, ucfirst(thesaurus($name)));
                    $html .= p(secure($this->$name_html, 1));
                    echo $html;
                }
            } else {
                return $this->$name;
            }
        }
    }

    public function object_count() {
        return $this->object_count;
    }

    public function no_contributor() {
        if (in_array('contributor', static::$links)) {
            $contributors = User::linked(static::$table_name, 'contributor', $this->id);
            $users = User::find_all();
            $no_contributor = [];
            foreach ($users as $user) {
                if (!in_array($user, $contributors) && $this->owner != $user->id()) {
                    $no_contributor[] = $user;
                }
            }
            return $no_contributor;
        }
    }

    public function manage_contributors($arg) {
        if ($arg == 'front') {
            if (in_array('contributor', static::$links)) {
                $contributors = User::linked(static::$table_name, 'contributor', $this->id);
                if (count($contributors) > 0 || $this->owner_rights()) {
                    $html = p(b(ucfirst(thesaurus('contributors') . thesaurus(':')))) . '<ul>';
                    $action = false;
                    if (isset($_POST['typeaction'])) { if (in_array($_POST['typeaction'], ['addcontrib', 'contribadded', 'deletecontrib'])) { $action = $_POST['typeaction']; }}
                    foreach ($contributors as $contributor) {
                        if ($this->owner_rights() && !$action) {
                            $html2 = "<form action='" . $this->url() . "' method='post'>";
                            $html2 .= $contributor->codename();
                            $html2 .= button_delete_sm('contrib', $contributor->id());
                            $html .= li($html2 . "</form>");
                        } else {
                            $html .= li($contributor->codename());
                        }
                    }
                    if ($this->owner_rights()) {
                        $html2 = "<form action='" . $this->url() . "' method='post'>";
                        if ($action === "addcontrib") {
                            $html2 .= "<label for='contrib'>" . ucfirst(thesaurus("select user") . thesaurus(":")) . "</label>";
                            $html2 .= "<select name='contrib' id='id_contrib'>";
                            $html2 .= opt('0', "-- " . thesaurus("select user") . " --");
                            $users = $this->no_contributor();
                            foreach ($users as $user) {
                                $html2 .= opt($user->id(), $user->codename());
                            }
                            $html2 .= "</select>";
                            $html2 .= buttons_validate_sm($this->url(), 'contrib');
                        } elseif (!$action) {
                            $html2 .= button_add_sm('a contributor', 'contrib');
                        }
                        $html2 .= "</form>";
                        $html .= li($html2);
                    }
                    $html .= '</ul>';
                    echo $html;
                }
            }
        } elseif ($arg == 'back') {
            if (in_array($_POST['typeaction'], ['contribadded', 'deletecontrib'])) {
                $action = $_POST['typeaction'];
                if ($action == 'contribadded') {
                    /* Vérifie si utilisateur existe */
                    $new_contrib = User::find_by_id($_POST['contrib']);
                    if (in_array($new_contrib, $this->no_contributor())) {
                        $request = static::$connexion->query("INSERT INTO link_" . static::$table_name . "_contributor (" . static::$table_name . ", contributor) VALUES (" . $this->id . ", " . $new_contrib->id() . ")");
                    }
                } elseif ($action == 'deletecontrib') {
                    DatabaseObject::delink(static::$table_name, 'contributor', $this->id(), $_POST['contrib']);
                }
                header('Location: ' . $this->url());
                exit();
            }
        }
    }

    public function manage_bibliography($arg, $legacy = false) {
        if ($arg == 'front') {
            if (in_array('bibliography', static::$links)) {
                $references = Bibliography::linked(static::$table_name, 'bibliography', $this->id);
                if (count($references) > 0 || $this->contributor_rights()) {
                    // Ajout paragraphe si hérité
                    if ($legacy === 'site') {
                        $html = '<p>' . ucfirst(thesaurus('biblio_site')) . '</p>';
                    } else if ($legacy === 'phase') {
                        $html = '<p>' . ucfirst(thesaurus('biblio_phase')) . '</p>';
                    } else {
                        $html = '';
                    }
                    $html .= '<ul>';
                    $action = false;
                    if (isset($_POST['typeaction'])) {
                        if (in_array($_POST['typeaction'], ['addbiblio', 'biblioadded', 'deletebiblio'])) { $action = $_POST['typeaction']; }
                    }
                    foreach ($references as $reference) {
                        if ($this->contributor_rights() && !$action) {
                            $html2 = "<form action='" . $this->url() . "' method='post'>";
                            $html2 .= $reference->codename('link');
                            $html2 .= button_delete_sm('biblio', $reference->id());
                            $html .= li($html2 . "</form>");
                        } else {
                            $html .= li($reference->codename('link'));
                        }
                    }
                    if ($this->contributor_rights()) {
                        $html2 = "<form action='" . $this->url() . "' method='post'>";
                        if ($action === "addbiblio") {
                            $html2 .= "<input type='text' name='reference' list='bibliography' placeholder='" . ucfirst(thesaurus("reference")) . "'>";
                            $html2 .= "<datalist id='bibliography'>";
                            $bibliography = Bibliography::find_all();
                            foreach ($bibliography as $item) {
                                $html2 .= opt($item->codename('not_secure'));
                            }
                            $html2 .= "</datalist>";
                            $html2 .= "<input type='text', name='pagination', maxlength='50', id='id_pagination', placeholder='" . ucfirst(thesaurus('optional: pagination')) . "'>";
                            $html2 .= buttons_validate_sm($this->url(), 'biblio');
                        } elseif (!$action) {
                            $html2 .= button_add_sm('a reference', 'biblio');
                        }
                        $html2 .= "</form>";
                        $html .= li($html2);
                    }
                    $html .= '</ul>';
                } else if (static::$table_name === 'phase' && !$this->unpublished) {
                    // Héritage possible du site
                    $html = $this->related_site()->manage_bibliography($arg, 'site');
                } else if (static::$table_name === 'context' && !$this->unpublished) {
                    // Héritage possible du site ou de la phase
                    $html = $this->related_phase()->manage_bibliography($arg, 'phase');
                } else {
                    $html = "<ul><li class='no-info'>" . ucfirst(thesaurus('no_reference_yet')) . "</li></ul>";
                }
                echo $html;
            }
        } elseif ($arg == 'back' && $this->contributor_rights() && isset($_POST['typeaction'])) {
            if (in_array($_POST['typeaction'], ['biblioadded', 'deletebiblio'])) {
                $action = $_POST['typeaction'];
                if ($action == 'biblioadded') {
                    /* Vérifie si référence existe */
                    $new_reference = Bibliography::find_by_abbr($_POST['reference']);
                    /* Check si la pagination fait moins de 50 caractères, et la diminue si nécessaire */
                    if (isset($_POST['pagination'])) {
                        $pagination = secure($_POST['pagination']);
                        if (strlen($pagination) > 50) { $pagination = substr($pagination, 0, 50); }
                    } else { $pagination = ""; }
                    if ($new_reference && !in_array($new_reference, Bibliography::linked(static::$table_name, 'bibliography', $this->id, false, false))) {
                        $request = static::$connexion->prepare("INSERT INTO link_" . static::$table_name . "_bibliography (" . static::$table_name . ", bibliography, pagination) VALUES (" . $this->id . ", " . $new_reference->id() . ", :pagination)");
                        $request->bindParam(':pagination', $_POST['pagination']);
                        $request->execute();
                    } elseif (!$new_reference) {
                        $_POST['typeaction'] = 'addbiblio';
                        $this->errors = add_error($this->errors, thesaurus("biblio don't exist"));
                    } else {
                        $_POST['typeaction'] = 'addbiblio';
                        $this->errors = add_error($this->errors, thesaurus("biblio already linked"));
                    }
                } elseif ($action == 'deletebiblio') {
                    Bibliography::delink(static::$table_name, 'bibliography', $this->id(), $_POST['biblio']);
                }
                if (!$this->errors) {
                    header('Location: ' . $this->url());
                    exit();
                }
            }
        }
    }

    public function manage_files($arg) {
        // Montrer les fichiers
        if ($arg == 'front') {
            if (in_array('file', static::$links)) {
                // D'abord : si un fichier existe d'office pour l'inventaire
                $inventory_file = false;
                if (ISOLATED_WEBSITE) {
                    if (static::$table_name === 'site') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('site_inventory')) . ' ' . $this->codename(), ['sites', 'download', $this->owner_id(), $this->code()]));
                    } elseif (static::$table_name === 'phase') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('phase_inventory')) . ' ' . $this->related_site()->codename(), ['sites', 'download', $this->related_site()->owner_id(), $this->related_site()->code(), $this->code()]));
                    }   elseif (static::$table_name === 'context') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('context_inventory')) . ' ' . $this->codename(), ['sites', 'download', $this->related_site()->owner_id(), $this->related_site()->code(), $this->related_phase()->code(), $this->code()]));
                    }
                } else {
                    if (static::$table_name === 'site') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('site_inventory')) . ' ' . $this->codename(), [$this->project()->code(), 'sites', 'download', $this->owner_id(), $this->code()]));
                    } elseif (static::$table_name === 'phase') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('phase_inventory')) . ' ' . $this->related_site()->codename(), [$this->related_site()->project()->code(), 'sites', 'download', $this->related_site()->owner_id(), $this->related_site()->code(), $this->code()]));
                    }   elseif (static::$table_name === 'context') {
                        $inventory_file = li(hyperlink(ucfirst(thesaurus('context_inventory')) . ' ' . $this->codename(), [$this->related_site()->project()->code(), 'sites', 'download', $this->related_site()->owner_id(), $this->related_site()->code(), $this->related_phase()->code(), $this->code()]));
                    }
                }
                // Ensuite, les fichiers
                $files = File::linked(static::$table_name, 'file', $this->id);
                if ($inventory_file || count($files) > 0 || $this->contributor_rights()) {
                    $html = h(3, ucfirst(thesaurus('associated files'))) . '<ul>';
                    if ($inventory_file) {
                        $html .= $inventory_file;
                    }
                    $action = false;
                    if (isset($_POST['typeaction'])) { if (in_array($_POST['typeaction'], ['addfile', 'fileadded', 'deletefile'])) { $action = $_POST['typeaction']; }}
                    foreach ($files as $file) {
                        if ($this->contributor_rights() && !$action) {
                            $html2 = "<form action='" . $this->url() . "' method='post'>";
                            $html2 .= $file->codename('link');
                            $html2 .= button_delete_sm('file', $file->id());
                            $html .= li($html2 . "</form>");
                        } else {
                            $html .= li($file->codename('link'));
                        }
                    }
                    if ($this->contributor_rights()) {
                        $html2 = "<form action='" . $this->url() . "' method='post'>";
                        if ($action === "addfile") {
                            $html2 .= "<label for='file'>" . ucfirst(thesaurus("select file")) . thesaurus(":") . "</label>";
                            $html2 .= "<select name='file' id='id_file'>";
                            $html2 .= opt('0', "-- " . thesaurus("select file") . thesaurus(":") . " --");
                            $all_files = File::find_all();
                            foreach ($all_files as $file) {
                                $available = false;
                                if ($file->public()) {
                                    $available = true;
                                } elseif ($file->contributor_rights()) {
                                    $available = true;
                                }
                                if ($available && in_array($file->type(), ['specific', 'both'])) {
                                    // Un peu lourd, vérifie si pas déjà dedans
                                    foreach ($files as $check) {
                                        if ($check->id() === $file->id()) {
                                            $available = false;
                                        }
                                    }
                                    if ($available) {
                                        $html2 .= opt($file->id(), $file->name());
                                    }
                                }
                            }
                            $html2 .= "</select>";
                            $html2 .= buttons_validate_sm($this->url(), 'file');
                        } elseif (!$action) {
                            $html2 .= button_add_sm('a file', 'file');
                        }
                        $html2 .= "</form>";
                        $html .= li($html2);
                    }
                    $html .= '</ul>';
                    echo $html;
                }
            }
        } elseif ($arg == 'back') {
            if (in_array($_POST['typeaction'], ['fileadded', 'deletefile'])) {
                $action = $_POST['typeaction'];
                if ($action == 'fileadded') {
                    /* Vérifie que le fichier peut être lié */
                    $new_file = File::find_by_id($_POST['file']);
                    $linked_files = File::linked(static::$table_name, 'file', $this->id);
                    $available = false;
                    if ($new_file->public()) {
                        $available = true;
                    } elseif ($new_file->contributor_rights()) {
                        $available = true;
                    }
                    if ($available) {
                        // Un peu lourd, vérifie si pas déjà dedans
                        $linked_files = File::linked(static::$table_name, 'file', $this->id);
                        foreach ($linked_files as $file) {
                            if ($new_file->id() === $file->id()) {
                                $available = false;
                            }
                        }
                        if ($available) {
                            $request = static::$connexion->query("INSERT INTO link_" . static::$table_name . "_file (" . static::$table_name . ", file) VALUES (" . $this->id . ", " . $new_file->id() . ")");
                        }
                    }
                } elseif ($action == 'deletefile') {
                    DatabaseObject::delink(static::$table_name, 'file', $this->id(), $_POST['file']);
                }
                header('Location: ' . $this->url());
                exit();
            }
        }
    }

    public function check_post() {
        if (!isset($_SESSION['user'])) {
            $this->errors = add_error($this->errors, ucfirst(thesaurus('not_connected')));
            unset($_POST['typeaction']);
            return false;
        } elseif (!$this->contributor_rights()) {
            $this->errors = add_error($this->errors, ucfirst(thesaurus('not_contributor')));
            unset($_POST['typeaction']);
            return false;
        } else {
            return true;
        }
    }

    public function display_errors($add = false) {
        if (count($this->errors) > 0) {
            if ($add) {
                // Si c'est dans le cadre d'un ajout structuré de données
                return $this->errors;
            } else {
                // Si c'est dans le cadre d'ajout ou de modifications simples
                $message =  "<div class='alert alert-danger'>"
                    . thesaurus('base_error') . "<ul>";
                foreach ($this->errors as $error) { $message .= "<li>" . $error . "</li>"; }
                $message .= "</ul></div>";
                echo $message;
            }
        }
    }
    
    public function buttons_contrib() {
        if ($this->contributor_rights() && !isset($_POST['typeaction'])) {
            $html = "<br><div class='btn-group' role='group'>";
            $html .= "<a class='btn btn-outline-secondary' href='" . $this->url('update') . "'>" . ucfirst(thesaurus('modify')) . "</a>";
            if ($this->owner_rights()) {
                $html .= "<button class='btn btn-outline-danger' type='submit' form='delete'>" . ucfirst(thesaurus('delete')) . "</button></div>";
                $html .= "<form action='" . $this->url('delete') ."' id='delete' method='post'>";
                $html .= "<input type='hidden' name='typeaction' value='delete'></form>";
            } else { $html .= '</div>'; }
            $html .= "<br><br>";
            echo $html;
        }
    }

    public function form($part='end', $file=false) {
        if ($part == 'begin') {
            if ($this->id()) { $url = $this->url('update'); } else { $url = $this->url('new'); }
            // ADD PICTURE FORM AS VARIANT
            if ($file) {
                echo "<form action='" . $url . "' method='post' enctype='multipart/form-data' id='form' name='form'>"; // Ajout enctype
            } else {
                echo "<form action='" . $url . "' method='post' id='form' name='form'>";
            }
        } else {
            if ($this->id()) {
                $value = ucfirst(thesaurus('modify'));
                $return = ucfirst(thesaurus('cancel'));
                $url = $this->url();
            } else {
                $value = ucfirst(thesaurus('create'));
                $return = ucfirst(thesaurus('give up'));
                $url = $this->url('parent');
            }
            $html = "<div class='btn-group' role='group'>";
            $html .= "<input class='btn btn-success' type='submit' value='{$value}'>";
            $html .= "<a class ='btn btn-secondary' href='" . $url . "'>{$return}</a>";
            $html .= "</div><br><br></form>";
            echo $html;
        }
    }

    public function input($name, $abbr, $label=true, $name_object=false, $need_id=false) {
        // Check if not a special name object (used for inventory tables)
        if (!$name_object) {
            if ($need_id) {
                $name_object = "object[" . $this->id . "][" . $name . "]";
            } else {
                $name_object = "object[" . $name . "]";
            }
        }
        // If links with bibliography, labels for ref must remain generic
        if (in_array($name, ['category_abbr', 'function_name', 'type_name', 'fabric_code']) /*&& !$_SESSION['user']->links_complex()*/) {
            $label_name = str_replace(['_abbr', '_name', '_code'], '', $name);
            $abbr = str_replace(['_abbr', '_name', '_code'], '', $abbr);
        } else { $label_name = $name; }
        
        // Add label if needed
        if ($label || ($_SESSION['user']->is_beginner() && $name_object ==  "object[" . $name . "]" && $abbr)) {
            if (!in_array($name, static::$required)) { $optionnal = " (" . thesaurus('optionnal') . ")" . thesaurus(':') . " "; } else { $optionnal = thesaurus(':') . " "; }
            $html = b(ucfirst(thesaurus($label_name)) . $optionnal);
            $html .= " ";
        } else { $html = ""; }

        // Create list of options for different names
        if (in_array($name, ['project', 'region', 'horizon', 'horizon_strength', 'related_phase', 'type_picture', 'storage', 'superhorizon', 'supertype', 'superfabric', 'country'])) {
            if ($need_id) {
                $html .= "<select name='{$name_object}' id='id_" . $this->id . "_" . $name . "'>";
            } else {
                $html .= "<select name='{$name_object}' id='id_" . $name . "'>";
            }
            if (empty($this->$name)) { $selected = true; } else { $selected = false; }
            $html .= opt('0', "-- " . thesaurus("no parent " . $name) . " --", $selected);
            if (in_array($name, ['horizon_strength', 'type_picture', 'storage'])) {
                $items = list_val($name);
                for ($i = 1; $i < count($items) ; $i++) {
                    if ($this->$name == $i) { $selected = true; } else { $selected = false; }
                    $html .= opt($i, ucfirst($items[$i]), $selected);
                }
            } else {
                if ($name == "superhorizon") {
                    if (count(Horizon::find_by_sql("SELECT * FROM horizon WHERE superhorizon = " . $this->id())) === 0) {
                        $items = Horizon::find_by_sql("SELECT * FROM horizon WHERE facies = " . $this->facies . " AND superhorizon IS NULL AND id != " . $this->id);
                    } else {
                        $items = [];
                    }
                } elseif ($name == "supertype") {
                    $check = Type::find_by_sql("SELECT * FROM type WHERE typology = " . $this->typology . " AND id != " . $this->id);
                    $items = [];
                    foreach ($check as $item) {
                        if (!$item->is_children($this)) {
                            $items[] = $item;
                        }
                    }
                } elseif ($name == "superfabric") {
                    $check = Fabric::find_all();
                    $items = [];
                    foreach ($check as $item) {
                        if (!($item->is_children($this) || $item->id() === $this->id()) && $item->contributor_rights()) {
                            $items[] = $item;
                        }
                    }
                } elseif ($name == "country") {
                    $items = Country::find_all();
                } elseif ($name == "related_phase") {
                    $items = Phase::find_by_parent($this->related_phase()->related_site()->id(), ['code']);
                    $items = array_filter($items, function($item) {
                        return $item->code() !== '00';
                    });
                    $items = array_values($items);
                } else {
                    $class = ucfirst($name);
                    $items = $class::find_all();
                }
                if ($items) {
                    foreach ($items as $item) {
                        if ($this->$name == $item->id()) { $selected = true; } else { $selected = false; }
                        $html .= opt($item->id(), $item->codename(), $selected);
                    }
                }
            }
            $html .= "</select>";
            if ($name == 'project' && $_SESSION['user']->is_beginner()) {
                $html = "<div style='display:none'>" . $html . "</div>";
            }
            // Type file
        } elseif ($name == "type" && static::$table_name == "file") {
            $html .= "<select name='{$name_object}' id='id_" . $name . "'>";
            if (ISOLATED_WEBSITE) {
                if ($_SESSION['user']->is_contributor()) {
                    $items = ['generic', 'specific', 'both', 'tutorial', 'template_import'];
                } else {
                    $items = ['generic', 'specific', 'both'];
                }
            } elseif (PROJECT) {
                if (PROJECT->contributor_rights()) {
                    $items = ['generic', 'specific', 'both', 'tutorial', 'template_import'];
                } else {
                    $items = ['generic', 'specific', 'both'];
                }
            } else {
                if ($_SESSION['user']->is_contributor()) {
                    $items = ['generic'];
                }
            }

            foreach ($items as $item) {
                if ($item === 'specific') { $selected = true; } else { $selected = false; }
                $html .= opt($item, ucfirst(thesaurus('filetype_' . $item)), $selected);
            }
            $html .= "</select>";

        // If _link, change the value to show string instead of key
        /*} elseif (in_array($name, ['category_l', 'function_l', 'type_l', 'fabric_l'])) {
            $max_chars = ['category_l'=>16, 'function_l'=>255, 'type_l'=>255, 'fabric_l'=>64];
            $link = $name . 'ink';
            if (!$this->$link) { $value = ""; } else {
                switch($name) {
                    case 'category_l': $value = Category::find_by_id($this->$link)->abbreviation(); break;
                    case 'function_l': $value = FunctionTable::find_by_id($this->$link)->name(); break;
                    case 'type_l'    : $value = Type::find_by_id($this->$link, $this->category_link)->code(); break;
                    case 'fabric_l'  : $value = Fabric::find_by_id($this->$link)->code(); break;
                }
            }
            $html .= "<input type='text' name='{$name_object}' maxlength ='" . $max_chars[$name] . "' ";
            $html .= "id='id_" . $name . "' placeholder='" . ucfirst(thesaurus('enter')) . " " . thesaurus('a ' . $label_name);
            $html .= "' value='" . $value . "'>";*/
        
        // Normal code (except for biblio_reference)
        } else {
            $max_chars = static::$max_chars[$name] ?? 255;
            $html .= "<input type='text' name='{$name_object}' maxlength ='" . "' ";
            if (in_array($name, static::$required)) { $html .= "required "; }
            /* Next line = add possibility to a data list */
            if ($name === 'biblio_reference') { $html .= " list='bibliography'"; }
            if ($need_id) {
                $html .= "id='id_" . $this->id . "_" . $name . "' placeholder='" . ucfirst(thesaurus('enter')) . " " . thesaurus('a ' . $label_name);
            } else {
                $html .= "id='id_" . $name . "' placeholder='" . ucfirst(thesaurus('enter')) . " " . thesaurus('a ' . $label_name);
            }
            if (isset($required)) { $html .= ' (' . thesaurus('mandatory') . ')'; }
            /* Next line = change value to have the abbreviation */
            if ($name === 'biblio_reference') {
                if ($this->$name) { $html .= "' value='" . Bibliography::find_by_id($this->$name)->abbreviation() . "'>"; } else { $html .= "'>"; }
            } else {
                $html .= "' value='" . $this->$name . "'>";
            }
        }
        if (/*$_SESSION['user']->is_beginner() &&*/ !str_contains($html, "display:none") && !$need_id) {
                $html .= " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>";
        }
        return $html;
    }

    public function input_number($name, $abbr, $min="", $max="", $step="", $label=true, $name_object=false, $need_id=false) {
        if (!$name_object) {
            if ($need_id) {
                $name_object = "object[" . $this->id . "][" . $name . "]";
            } else {
                $name_object = "object[" . $name . "]";
            }
        }
        if ($label || ($_SESSION['user']->is_beginner() && $name_object ==  "object[" . $name . "]" && $abbr)) {
            if (!in_array($name, static::$required)) { $optionnal = " (" . thesaurus('optionnal') . ")" . thesaurus(':') . " "; } else { $optionnal = thesaurus(':') . " "; }
            $html = b(ucfirst(thesaurus($name)) . $optionnal);
            $html .= " ";
        } else { $html = ""; }
        if ($min) { $min = " min='" . $min . "'"; }
        if ($max) { $max = " max='" . $max . "'"; }
        if ($step) { $step = " step='" . $step . "'"; }
        $html .= "<input type='number' name='{$name_object}'" . $min . $max . $step;
        if (in_array($name, static::$required)) { $html .= " required"; }
        $value = "";
        if (isset($this->$name)) { if ($this->$name) { $value = secure($this->$name); }}
        if ($need_id) {
            $html .= " id='id_" . $this->id . "_" . $name . "' value='" . $value . "'>";
        } else {
            $html .= " id='id_" . $name . "' value='" . $value . "'>";
            $html .= " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>";
        }
        return $html;
    }

    public function input_text($name, $abbr, $label=true, $name_object=false, $script=false, $wysiwyg=true) {
        if (property_exists(get_called_class(), $name . "_html")) { $name .= "_html"; $name_object = "object[" . $name . "]"; }
        elseif (!$name_object) { $name_object = "object[" . $name . "]"; }
        if ($script) {
            return "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const form_{$name} = document.getElementById('form');
                form_{$name}.addEventListener('submit', function() {
                    document.getElementById('id_{$name}').value =
                        document.getElementById('id_editor_{$name}').innerHTML;
                });
            });
            </script>";
        }
        if ($label || ($_SESSION['user']->is_beginner() && $name_object ==  "object[" . $name . "]" && $abbr)) {
            if (!in_array($name, static::$required)) { $optionnal = " (" . thesaurus('optionnal') . ")"; } else { $optionnal = ""; }
            $html = h(4, ucfirst(thesaurus($name)) . $optionnal . " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>");
            /*if ($_SESSION['user']->is_beginner()) {
                $html .= " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>";
            } */
            $html .= " ";
        } else { $html = ""; }
        /* Ajoute :
        * Les boutons (TODO)
        * Le div éditable
        * L'input caché où intégrer le contenu à la fin
        * Le script javascript qui intègre le contenu doit être après le form
        */
        if ($wysiwyg) {
            // D'abord, les boutons
            $html .= toolbar_wysiwyg();            
        }
        // Ensuite, le div et l'input
        $html .= "<div contenteditable='true' class='border p-2 w-100'
                style='min-height:100px; resize:both; overflow:auto;'
                name='editor_{$name_object}'
                id='id_editor_{$name}'>"
                . secure($this->$name, 1) .
            "</div>
            <input type='hidden' 
                name='{$name_object}' 
                id='id_{$name}'>";
        return $html;
    }

    public function input_checkbox($name, $abbr, $label=true, $name_object=false) {
        if (!$name_object) { $name_object = "object[" . $name . "]"; }
        if ($label || (/*$_SESSION['user']->is_beginner() &&*/ $name_object ==  "object[" . $name . "]")) {
            $html = ucfirst(thesaurus($name));
            //if ($_SESSION['user']->is_beginner()) {
                $html .= " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>";
            //}
            $html = " " . $html;
        } else { $html = ""; }
        if (in_array($name, ['setting_horizon_adv', 'setting_notes_pub'])) {
            if ($this->$name()) { $checked = " checked"; } else { $checked = ""; }
        } else {
            if ($this->$name) { $checked = " checked"; } else { $checked = ""; }
        }
        if ($name_object ==  "object[" . $name . "]") {
            return "<input type='checkbox' name='{$name_object}' id = 'id_" . $name . "'" . $checked . ">" . $html;
        } else {
            // Code à écrire si se trouve dans cette situation
        }
    }

    public function input_counting($abbr, $label=true) {
        if ($label === true || $_SESSION['user']->is_beginner()) {
            $html = h(3, ucfirst(thesaurus('counting')));
            //if ($_SESSION['user']->is_beginner()) {
                $html .= " <abbr title='" . tutorial($abbr) . "'><i class='bi bi-info-circle'></i></abbr>";
            //}
            $html .= " ";
        } else { $html = ""; }
        $countings = Counting::find_all();
        foreach ($countings as $counting) {
            if ($this->id()) {
                if (in_array($counting, Counting::linked('counting', static::$table_name, $this->id, true))) { $checked = " checked"; } else { $checked = ""; }
            } elseif (isset($_POST['counting'])) {
                foreach ($_POST['counting'] as $post_count) {
                    if ($counting == $post_count) { $checked = " checked "; } else { $checked = ""; }
                }
            } else { $checked = ""; }
            $html .= "<div class='form-check form-switch'>";
            $html .= "<input class='form-check-input' type='checkbox' name='counting[" . $counting->id() ."]' id='id_counting[" . $counting->id() . "]' value='True'" . $checked . ">";
            $html .= "<label class='form-check-label' for='id_counting[" . $counting->id() . "]'>" . $counting->name() . "</label>";
            $html .= "</div>";
        }
        return $html;
    }

    // Informations pour citer la page
    public function cite_page($onicer=false) {
        $intro = b(ucfirst(thesaurus("cite this page")) . thesaurus(":"), " ");
        $owners = User::find_by_id($this->owner("prop"))->codename();
        if (in_array('contributor', static::$links)) {
            $contributors = User::linked(static::$table_name, 'contributor', $this->id);
            foreach($contributors as $contributor) {
                $owners .= ", " . $contributor->codename();
            }
        }
        $creation_date = date_located($this->date_creation);
        if ($this->date_modification) { 
            $modification_date = " (" . thesaurus("updated on") . " " . date_located($this->date_modification) . ")";
        } else {
            $modification_date = "";
        }
        if ($onicer) { $site = "ONICer"; } else { $site = PROJECT_NAME; }
        $object_type = ucfirst(thesaurus(static::$table_name));
        $page_name = $this->codename();
        $viewing_time = date_located(date('Y-m-d H:i:s'));
        $url = $this->url();
        $html = "<p>" . $intro . $owners . ", " . $creation_date . $modification_date . ", <i>" . $site . " - " . $object_type . " " . $page_name
            . "</i> (" . thesaurus("see on") . " " . $viewing_time . "), &lt;" . $url . "&gt;.";
        echo $html;
    }

    public function date_creation() {
        return $this->date_creation;
    }

    public function sum_countings($type) {
        if (property_exists('ObjectTable', $type)) {
            switch (static::$table_name) {
                case "site":
                    $request = self::$connexion->prepare(
                        "SELECT SUM(COALESCE(object. " . $type . ", 0)) FROM object
                        JOIN context ON object.related_context = context.id
                        JOIN phase ON context.related_phase = phase.id
                        WHERE phase.related_site = :id"
                    );
                    $request->bindParam(':id', $this->id);
                    $request->execute();
                    break;
                case "phase":
                    $request = self::$connexion->prepare(
                        "SELECT SUM(COALESCE(object. " . $type . ", 0)) FROM object
                        JOIN context ON object.related_context = context.id
                        WHERE context.related_phase = :id"
                    );
                    $request->bindParam(':id', $this->id);
                    $request->execute();
                    break;
                case "context":
                    $request = self::$connexion->prepare(
                        "SELECT SUM(COALESCE(" . $type . ", 0)) FROM object
                        WHERE related_context = :id"
                    );
                    $request->bindParam(':id', $this->id);
                    $request->execute();
                    break;
            }
            if ($request) {
                return $request->fetchColumn();
            } else {
                return "-";
            }
        } else {
            return "error";
        }
    }

}

if (STATUS_INSTALLATION === 'validated') {
    $connexion = db_connect();
    DatabaseObject::set_database($connexion);
}
?>