<?php

/* Description de l'objet
** Fonctions statiques corrigées :
    find_by_data
*/
class AppText extends DatabaseObject {

    static protected $table_name = "app_text";
    static protected $db_columns = ['id', 'project', 'lang', 'format', 'page', 'content', 'creator', 'date_creation', 'date_modification'];
    static protected $max_chars = ['lang'=>3, 'format'=>16, 'page'=>32];
    static protected $required = ['project', 'lang', 'format', 'page', 'creator'];

    static public function find_by_data($page, $project=0) {
        return static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE page = :page AND project = :project", ['page'=>$page, 'project'=>$project]);
    }

    static public function find_lang($page, $lang='fr', $project=0) {
        $lang = strtolower($lang);
        $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE page = :page AND lang = :lang AND project = :project", ['page'=>$page, 'lang'=>$lang, 'project'=>$project]);
        if (!empty($object)) {
            return array_shift($object);
        }
    }

    protected int    $project;
    protected string $lang;
    protected string $format;
    protected string $page;
    protected string $content;
    protected int    $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        if (isset($args['project'])) { $this->project = intval($args['project']); } else { $this->project = 0; }
        $this->lang = $args['lang'] ?? 'fr';
        $this->format = $args['format'] ?? 'html';
        $this->page = $args['page'] ?? '';
        $this->content = $args['content'] ?? '';
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'new') {
                return create_url(['page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'delete') {
                return create_url(['page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'parent') {
                return create_url(['page', $this->page]);
            } else {
                return create_url(['page', $this->page, 'update', $this->lang]);
            }
        } else {
            if ($this->project == 0) {
                $project_url = 'logacer';
            } else {
                $project_url = Project::find_by_id($this->project)->code();
            }
            if ($arg == 'update') {
                return create_url([$project_url, 'page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'delete') {
                return create_url([$project_url, 'page', $this->page, 'update', $this->lang]);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'page', $this->page]);
            } else {
                return create_url([$project_url, 'page', $this->page]);
            }
        }
    }

    public function format() {
        return $this->format;
    }

    public function display() {
        if ($this->format === 'html') {
            echo p(secure($this->content, 1));
        } elseif ($this->format === 'markdown') {
            $parsedown = new Parsedown();
            $parsedown->setSafeMode(true);
            echo $parsedown->text($this->content);
        }
    }


}

?>