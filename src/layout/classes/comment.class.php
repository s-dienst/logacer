<?php

/* Description de l'objet
** Fonctions statiques corrigées :
    find_by_data
*/
class Comment extends DatabaseObject {

    static protected $table_name = "comment";
    static protected $db_columns = ['id', 'class', 'id_object', 'privacy', 'respond_to', 'descr', 'descr_html', 'creator', 'date_creation', 'date_modification'];
    static protected $required = ['class', 'id_object', 'creator'];
    static protected $tables = ['Site' => 'site', 'Phase' => 'phase', 'Context' => 'context', 'ObjectTable' => 'object', 'Facies' => 'facies', 'Horizon' => 'horizon', 'Typology' => 'typology', 'Type' => 'type', 'Fabric' => 'fabric'];

    static public function find_by_class_element($class, $id) {
        $table = static::$tables[$class];
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE class = :table AND id_object = :id", ['table'=>$table, 'id'=>$id]);
    }

    static public function find_by_main_comment($id) {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE respond_to = :id", ['id'=>$id]);
    }

    /**
     * Affiche l'ensemble des commentaires.
    */
    static public function render_comments($class, $object_id) {
        $comments = Comment::find_by_class_element($class, $object_id);

        $html = '';
        if ($comments) {
            foreach ($comments as $comment) {
                $html .= $comment->render_comment();
            }
            $display = " style='display:none;'";
        } else {
            $display = '';
        }

        $html .= "<div id='comments_empty' class='text-muted text-center py-4'" . $display . ">
            <i class='bi bi-chat-square-text fs-3'></i><p class='mb-0 mt-2'>Aucun commentaire pour le moment.</p>
        </div>";

        return $html;
    }

    protected string $class;
    protected int    $id_object;
    protected int    $privacy;
    protected int    $respond_to;
    protected string $descr;
    protected string $descr_html;
    protected int    $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->class = $args['class'] ?? '';
        if (isset($args['id_object'])) { $this->id_object = intval($args['id_object']); } else { $this->id_object = 0; }
        if (isset($args['privacy'])) { $this->privacy = intval($args['privacy']); } else { $this->privacy = 0; }
        if (isset($args['respond_to'])) { $this->respond_to = intval($args['respond_to']); } else { $this->respond_to = 0; }
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function delete($url = false, $children = [], $reverse = false) {
        // Supprime le statut de réponse
        $request = static::$connexion->prepare("UPDATE comment SET respond_to = 0 WHERE respond_to = :id");
        $request->bindParam(':id', $this->id);
        $request->execute();
        parent::delete($url, $children, $reverse);
    }

    public function validate() {
        parent::validate();
        if (isset($this->privacy)) { $this->errors = add_error($this->errors, check_range($this->privacy, "the privacy", 0, 2)); }
        // Check si la classe est autorisée
        if (!isset(static::$tables[$this->class])) {
            $this->errors = add_error($this->errors, err_comment('unknown_class'));
        }
        // Check si l'objet existe
        $class = $this->class;
        if (!$class::find_by_id($this->id_object)) {
            $this->errors = add_error($this->errors, err_comment('no_object'));
        }
    }

    public function url($arg=false) {
        return $this->parent_object()->url($arg);
    }

    public function respond_to() {
        return Comment::find_by_id($this->respond_to);
    }

    public function privacy() {
        return $this->privacy;
    }

    public function parent_object() {
        $class = $this->class;
        return $class::find_by_id($this->id_object);
    }

    public function id_object() {
        return $this->id_object;
    }

    public function is_visible() {
        // Si privé, juste accessible au créateur
        if ($this->owner_rights()) {
            return true;
        } elseif ($this->privacy === 0) {
            return false;
        }

        // Si projet privé, pas d'accès
        if (PROJECT && !PROJECT->public() && !PROJECT->contributor_rights()) {
            return false;
        }

        // Si public et activé, accessible à tous
        if ((!PROJECT || PROJECT->setting_notes_pub()) && $this->privacy == 2) {
            return true;
        }

        // Si échange, on regarde les contributeurs
        $class = $this->class;
        $object = $this->parent_object();
        if ($object && $object->contributor_rights() && $this->privacy > 0) {
            return true;
        }

    }

    /**
     * Affiche le commentaire et ses éventuelles réponses.
     */
    public function render_comment() {

        if (!$this->is_visible()) {
            return '';
        }

        $id = $this->id;
        if ($this->respond_to > 0) {
            $class = ' ms-4 ms-md-5';
            $dcr = '1';
        } else {
            $class = '';
            $dcr = '0';
        }

        if ($this->privacy === 0) {
            $privacy_display = thesaurus('personal');
        } elseif ($this->privacy === 2 && (!PROJECT || PROJECT->seeting_notes_pub())) { 
            $privacy_display = thesaurus('private');
        } else {
            $privacy_display = thesaurus('public');
        } 

        $html = "<div class='comment-item border rounded p-3 mb-3" . $class . "' id='comment_" . $id . "' data-comment-id='" . $id . "' data-comment-reply='" . $dcr . "'>"
            . "<div class='d-flex justify-content-between align-items-start gap-2'>"
                . "<div>
                    <strong>" . User::find_by_id($this->creator)->codename() . "</strong> (" . $privacy_display . ")
                    <div class='text-muted small'>" . ucfirst(thesaurus("created on")) . " "
                        . date_located($this->date_creation) . ".";

                        if ($this->date_modification) {
                            $html .= "<span title='Commentaire modifié'> " . ucfirst(thesaurus('modified on')) . ' ' . date_located($this->date_modification) . ".</span>";
                        }

                    $html .= "</div>
                </div>";

                if ($this->owner_rights()) {
                    $html .= "<div class='dropdown'>
                        <button class='btn btn-sm btn-outline-secondary' type='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-three-dots'></i></button>
                        <ul class='dropdown-menu dropdown-menu-end'>
                            <li><button class='dropdown-item comment-edit' type='button' data-id='" . $id . "'>" . ucfirst(thesaurus("modify")) . "</button></li>
                            <li><button class='dropdown-item text-danger comment-delete' type='button' data-id='" . $id . "'>" . ucfirst(thesaurus("delete")) . "</button></li>
                        </ul>
                    </div>";
                }

            $html .= "</div>";

            $html .= "<div class='comment-description mt-3'>" . p(secure($this->descr_html, 1)) . "</div>";

            if (!$this->respond_to) {

                $html.= "<div class='mt-3'><button class='btn btn-sm btn-outline-primary comment-reply' type='button' data-id='" . $id . "'><i class='bi bi-reply'></i> " . ucfirst(thesaurus("respond_comment")) . "</button></div>
                <div class='comment-replies mt-3'>";

                foreach (Comment::find_by_main_comment($id) as $reply) {
                    $html .= $reply->render_comment();
                }

                $html .= "</div>";

            }

        $html .= "</div>";

        return $html;
    }

}

?>