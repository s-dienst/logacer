<?php

/* Description de l'objet
** Fonctions statiques corrigées :
    find_by_id(), find_all() ;
*/
class Project extends DatabaseObject {

    static protected $table_name = "project";
    static protected $db_columns = ['id', 'code', 'name', 'descr', 'descr_html', 'owner', 'date_creation', 'date_modification',
        'public',
        'setting_horizon', 'setting_graphs', 'setting_litterature', 'setting_archaeometry', 'setting_notes', 'langs',
        'img_icon', 'img_band', 'img_logo', 'img_footer1', 'img_footer2', 'img_footer3', 'img_footer4', 'img_footer5',
        'link_footer1', 'link_footer2', 'link_footer3', 'link_footer4', 'link_footer5'];
    static protected $links = ['user'=>'contributor', 'file'=>'file', 'fabric'=>'fabric', 'typology'=>'typology'];
    static protected $max_chars = ['code'=>16, 'name'=>128, 'langs'=>64,
        'img_icon'=>255, 'img_band'=>255, 'img_logo'=>255, 'img_footer1'=>255, 'img_footer2'=>255, 'img_footer3'=>255, 'img_footer4'=>255, 'img_footer5'=>255,
        'link_footer1'=>255, 'link_footer2'=>255, 'link_footer3'=>255, 'link_footer4'=>255, 'link_footer5'=>255];
    static protected $required = ['code', 'name', 'owner', 'langs'];
    static protected $uniques = ['code'];
    static protected $bool = ['public', 'setting_graphs', 'setting_litterature', 'setting_archaeometry'];

    /*static public function find_all($ordering=[]) {
        if (isset($_SESSION['user'])) {
            if (count($ordering) > 0) {
                $projects = static::find_by_sql("SELECT * FROM project", [], $ordering);
            } else {
                $projects = static::find_by_sql("SELECT * FROM project ORDER BY name");
            }
            $result = [];
            foreach ($projects as $project) {
                if ($_SESSION['user']->id() == $project->owner || in_array(User::find_by_id($_SESSION['user']->id()), User::linked(static::$table_name, 'contributor', $project->id()))) {
                    array_push($result, $project);
                }
            }
            return $result;
        }
        return false;
    }*/

    static public function find_by_id($id) {
        if (isset($_SESSION['user']) && $id) {
            $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id = :id", ['id'=>$id]);
            if (!empty($object)) {
                $project = array_shift($object);
                if ($_SESSION['user']->id() == $project->owner || in_array(User::find_by_id($_SESSION['user']->id()), User::linked(static::$table_name, 'contributor', $project->id))) {
                    return $project;
                }
            }
        }
        return false;
    }

    static public function find_by_code($code) {
        $object = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE code = :code", ['code'=>$code]);
        if (!empty($object)) {
            return array_shift($object);
        }
    }

    protected string $code;
    protected string $name;
    protected string $descr;
    protected string $descr_html;
    protected int $owner;
    protected int $public;
    protected int $setting_horizon;
    protected int $setting_graphs;
    protected int $setting_litterature;
    protected int $setting_archaeometry;
    protected int $setting_notes;
    protected string $langs;
    protected string $img_icon;
    protected string $img_band;
    protected string $img_logo;
    protected string $img_footer1;
    protected string $img_footer2;
    protected string $img_footer3;
    protected string $img_footer4;
    protected string $img_footer5;
    protected string $link_footer1;
    protected string $link_footer2;
    protected string $link_footer3;
    protected string $link_footer4;
    protected string $link_footer5;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->code = $args['code'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->descr = $args['descr'] ?? '';
        $this->descr_html = $args['descr_html'] ?? '';
        $this->owner = $args['owner'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        if (isset($args['public'])) { $this->public = intval($args['public']); } else { $this->public = 1; }
        if (isset($args['setting_horizon'])) { $this->setting_horizon = intval($args['setting_horizon']); } else { $this->setting_horizon = 0; }
        if (isset($args['setting_graphs'])) { if ($args['setting_graphs']) { $this->setting_graphs = 1; } else { $this->setting_graphs = 0; } } else { $this->setting_graphs = 0; }
        if (isset($args['setting_litterature'])) { if ($args['setting_litterature']) { $this->setting_litterature = 1; } else { $this->setting_litterature = 0; } } else { $this->setting_litterature = 0; }
        if (isset($args['setting_archaeometry'])) { if ($args['setting_archaeometry']) { $this->setting_archaeometry = 1; } else { $this->setting_archaeometry = 0; } } else { $this->setting_archaeometry = 0; }
        if (isset($args['setting_notes'])) { $this->setting_notes = intval($args['setting_notes']); } else { $this->setting_notes = 0; }
        $this->langs = $args['langs'] ?? 'en';
        $this->img_icon = $args['img_icon'] ?? '';
        $this->img_band = $args['img_band'] ?? '';
        $this->img_logo = $args['img_logo'] ?? '';
        $this->img_footer1 = $args['img_footer1'] ?? '';
        $this->img_footer2 = $args['img_footer2'] ?? '';
        $this->img_footer3 = $args['img_footer3'] ?? '';
        $this->img_footer4 = $args['img_footer4'] ?? '';
        $this->img_footer5 = $args['img_footer5'] ?? '';
        $this->link_footer1 = $args['link_footer1'] ?? '';
        $this->link_footer2 = $args['link_footer2'] ?? '';
        $this->link_footer3 = $args['link_footer3'] ?? '';
        $this->link_footer4 = $args['link_footer4'] ?? '';
        $this->link_footer5 = $args['link_footer5'] ?? '';
    }

    public function validate() {
        parent::validate();
        // Check si les settings sont dans les intervalles corrects
        $this->errors = add_error($this->errors, check_range($this->setting_horizon, "the setting_horizon", 0, 2));
        $this->errors = add_error($this->errors, check_range($this->setting_notes, "the setting_notes", 0, 2));
        // Check le code du project :
        $this->errors = add_error($this->errors, check_forbidden($this->code, 'code', ['logacer']));
        $this->errors = add_error($this->errors, check_characters($this->code, 'code', '/\A[a-zA-Z0-9_-]+\z/'));
    }

    public function delete($url, $children = [], $reverse = false) {
        foreach (['site', 'facies'] as $table) {
            $request = static::$connexion->prepare("UPDATE " . $table . " SET project = NULL WHERE project = :idproject");
            $request->bindParam(':idproject', $this->id);
            $request->execute();
        }
        foreach (['typology', 'fabric'] as $table) {
            $request = static::$connexion->prepare("UPDATE " . $table . " SET related_project = NULL WHERE related_project = :idproject");
            $request->bindParam(':idproject', $this->id);
            $request->execute();
        }
        parent::delete($url, $children, $reverse);
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['project']);
            } elseif ($arg == 'new_site') {
                return create_url(['sites', 'new']); // Obsolète (?)
            } elseif ($arg == 'new_facies') {
                return create_url(['horizons', 'new']);
            } elseif ($arg == 'new_typology') {
                return create_url(['typology', 'new']);
            } elseif ($arg == 'new_fabric') {
                return create_url(['fabrics', 'new']);
            } elseif ($arg == 'new') {
                return create_url(['project', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['project', 'new']);
            } else {
                return create_url(['project']);
            }
        } else {
            if ($arg == 'update') {
                return create_url([$this->code(), 'project']);
            } elseif ($arg == 'new_site') {
                return create_url([$this->code(), 'sites', 'new']);
            } elseif ($arg == 'new_facies') {
                return create_url([$this->code(), 'horizons', 'new']);
            } elseif ($arg == 'new_typology') {
                return create_url([$this->code(), 'typology', 'new']);
            } elseif ($arg == 'new_fabric') {
                return create_url([$this->code(), 'fabrics', 'new']);
            } elseif ($arg == 'new') {
                return create_url(['logacer', 'project', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([]);
            } elseif ($arg == 'main') {
                return create_url([$this->code()]);
            } else {
                return create_url([$this->code(), 'project']);
            }
        }
    }


    public function credits() {
        $html = ucfirst(thesaurus("by")) . " <b>" . User::find_by_id($this->owner)->codename() . "</b>";
        $contributors = User::linked('project', 'contributor', $this->id);
        if (count($contributors) > 0) {
            $html .= ", " . thesaurus("with contributions of") . " ";
            $already = 0;
            foreach ($contributors as $contrib) {
                if ($already > 0) {
                    if (($already + 1) === count($contributors)) {
                        $html .= " " . thesaurus("and") . " ";
                    } else {
                        $html .= ", ";
                    }
                }
                $html .= $contrib->codename();
                $already++;
            }
        }
        $html .= ".";
        return $html;
    }

    public function codename($arg=false) {
        $codename = secure($this->name . " (" . User::find_by_id($this->owner)->codename() . ")");
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    // NOUVELLES DONNEES PROJET

    public function public() {
        return $this->public;
    }

    // 0 : pas d'horizon (phases = phases) ; 1 : horizons mais pas avancé (phases = horizons-sites) ; 2 : horizons avancés
    public function setting_horizon() {
        return $this->setting_horizon;
    }

    public function setting_horizon_adv() {
        if ($this->setting_horizon == 2) { return true; }
    }

    public function setting_graphs() {
        return $this->setting_graphs;
    }

    public function setting_litterature() {
        return $this->setting_litterature;
    }

    public function setting_archaeometry() {
        return $this->setting_archaeometry;
    }

    // 0 : pas de notes ; 1 : notes privées ; 2 : notes publiques
    public function setting_notes() {
        return $this->setting_notes;
    }

    public function setting_notes_pub() {
        if ($this->setting_notes == 2) { return true; }
    }

    public function langs() {
        return explode(';', $this->langs);
    }

    public function image($type, $display=true, $icon=true) {
        $prop = 'img_' . $type;
        if ($display) {
            if (in_array($type, ['footer1', 'footer2', 'footer3', 'footer4', 'footer5'])) {
                if (strlen($this->$prop) > 0) {
                    $prop_l = 'link_' . $type;
                    // Serve picture
                    serve_picture_public($this->$prop, ALLOW_LOCAL_PICTURES, $this->$prop_l, false, 50);
                }
            } elseif ($type === 'icon') {
                if (strlen($this->$prop) > 0) {
                    // Serve picture
                    serve_picture_public($this->$prop, icon: $icon, height: 64);
                } else {
                    // Logacer picture
                    serve_picture_public("Logo-logacer-2.png", true, icon: $icon, height: 64);
                }
            } elseif ($type === 'band') {
                if (strlen($this->$prop) > 0) {
                    serve_picture_public($this->$prop, ALLOW_LOCAL_PICTURES, $this->url('main'), height: 64, class: "navbar-brand py-0", blank: false);
                } else {
                    echo "<a class='navbar-brand py-0' href='" . $this->url('main') . "'>" . PROJECT->code() . "</a>";
                }
            } elseif ($type === 'logo') {
                if (strlen($this->$prop) > 0) {
                    serve_picture_public($this->$prop, ALLOW_LOCAL_PICTURES, $this->url('main'), false, 80);
                }
            }
        } else {
            return $this->$prop;
        }
    }

    public function img_link($type) {
        if (in_array($type, ['footer1', 'footer2', 'footer3', 'footer4', 'footer5'])) {
            $prop = 'link_' . $type;
            return $this->$prop;
        }
    }

    public function complete($type_form) {
        $old = Project::find_by_id($this->id);
        if ($type_form === 'base') {
            // Modifie le code, le nom et la description
            $this->owner = $old->owner('prop');
            $this->setting_horizon = $old->setting_horizon();
            $this->setting_graphs = $old->setting_graphs();
            $this->setting_litterature = $old->setting_litterature();
            $this->setting_archaeometry = $old->setting_archaeometry();
            $this->setting_notes = $old->setting_notes();
            $this->langs = implode(';', $old->langs());
            $this->img_icon = $old->image('icon', false);
            $this->img_band = $old->image('band', false);
            $this->img_logo = $old->image('logo', false);
            $this->img_footer1 = $old->image('footer1', false);
            $this->img_footer2 = $old->image('footer2', false);
            $this->img_footer3 = $old->image('footer3', false);
            $this->img_footer4 = $old->image('footer4', false);
            $this->img_footer5 = $old->image('footer5', false);
            $this->link_footer1 = $old->img_link('footer1');
            $this->link_footer2 = $old->img_link('footer2');
            $this->link_footer3 = $old->img_link('footer3');
            $this->link_footer4 = $old->img_link('footer4');
            $this->link_footer5 = $old->img_link('footer5');
        } elseif ($type_form === 'parameters') {
            $this->code = $old->code();
            $this->name = $old->name();
            $this->descr = $old->description();
            $this->descr_html = $old->description("", 'descr_html');
            $this->owner = $old->owner('prop');
            $this->img_icon = $old->image('icon', false);
            $this->img_band = $old->image('band', false);
            $this->img_logo = $old->image('logo', false);
            $this->img_footer1 = $old->image('footer1', false);
            $this->img_footer2 = $old->image('footer2', false);
            $this->img_footer3 = $old->image('footer3', false);
            $this->img_footer4 = $old->image('footer4', false);
            $this->img_footer5 = $old->image('footer5', false);
            $this->link_footer1 = $old->img_link('footer1');
            $this->link_footer2 = $old->img_link('footer2');
            $this->link_footer3 = $old->img_link('footer3');
            $this->link_footer4 = $old->img_link('footer4');
            $this->link_footer5 = $old->img_link('footer5');
        } elseif ($type_form === 'pictures') {
            $this->code = $old->code();
            $this->name = $old->name();
            $this->descr = $old->description();
            $this->descr_html = $old->description("", 'descr_html');
            $this->owner = $old->owner('prop');
            $this->setting_horizon = $old->setting_horizon();
            $this->setting_graphs = $old->setting_graphs();
            $this->setting_litterature = $old->setting_litterature();
            $this->setting_archaeometry = $old->setting_archaeometry();
            $this->setting_notes = $old->setting_notes();
            $this->langs = implode(';', $old->langs());
        }
    }
}

?>