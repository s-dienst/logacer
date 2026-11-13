<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Variables supplémentaires :
    /
*/
class News extends DatabaseObject {

    static protected $table_name = "news";
    static protected $db_columns = ['id', 'title', 'content', 'content_html', 'project', 'creator', 'date_creation', 'date_modification'];
    static protected $max_chars = ['title'=>255];
    static protected $required = ['title'];

    protected string $title;
    protected string $content;
    protected string $content_html;
    protected int $project;
    protected int $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->title = $args['title'] ?? '';
        $this->content = $args['content'] ?? '';
        $this->content_html = $args['content_html'] ?? '';
        $this->project = $args['project'] ?? 0;
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function url($arg=false) {
        if ($arg == 'update') {
            return create_url(['news', 'update', $this->id]);
        } elseif ($arg == 'new') {
            return create_url(['news', 'new']);
        } else {
            return create_url([]);
        }
    }

    public function title() {
        return $this->title;
    }

    public function display_news() {
        echo "<div class='news-item mb-4'>";
        // Titre
        echo h(4, $this->title);
        // Sous-titre
        echo "<small class='text-muted'>";
        echo ucfirst(thesaurus('from')) . ' ' . User::find_by_id($this->creator)->codename() . ' - '
            . date_located($this->date_creation);
        if ($this->date_modification) {
            echo " - " . ucfirst(thesaurus('modified on')) . ' ' . date_located($this->date_modification);
        }
        echo "</small>";
        // Contenu
        echo "<div class='mt-2'>";
        echo secure($this->content_html, 1);
        echo "</div>";
        if (isset($_SESSION['user']) && ($_SESSION['user']->id() === $this->creator || $_SESSION['user']->is_staff())) {
            echo "<a href='" . $this->url('update') . "' class='btn btn-sm btn-outline-primary mt-2'>" . ucfirst(thesaurus('modify')) . "</a>";
        }
        echo "<hr></div>";
    }

    public function project() {
        return Project::find_by_id($this->project);
    }
}

?>