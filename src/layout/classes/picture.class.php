<?php

/* Description de l'objet
** Fonctions modifiées :
    form()

** Fonctions supplémentaires  :
    related_object();

** Variables supplémentaires :
    /
*/
class Picture extends DatabaseObject {

    static protected $table_name = "picture";
    static protected $db_columns = ['id', 'name', 'type_picture', 'height', 'width', 'comment', 'related_object',
        'biblio_reference', 'biblio_emplacement', 'storage', 'url_path', 'extension', 'creator', 'date_creation', 'date_modification'];
    static protected $max_chars = ['name'=>255, 'type_picture'=>64, 'comment'=>255, 'biblio_emplacement'=>128, 'storage'=>64, 'extension'=>8];
    static protected $parent = 'related_object';
    static protected $required = ['name', 'type_picture', 'related_object', 'creator'];

    static public function lightbox() {
        echo '    <div id="lightbox" class="lightbox">
            <span class="close">&times;</span>
            <a class="btn btn-success" id="contrib-link" href="#" target="_blank" style="display:none;">' . ucfirst(thesaurus('modify')) . '</a>
            <div class="lightbox-content">
                <img id="lightbox-img" src="" alt="">
                <div id="lightbox-caption" class="lightbox-caption"></div>
            </div>
            </div>';
    }

    protected string $name;
    protected string $type_picture;
    protected int $height;
    protected int $width;
    protected string $comment;
    protected int $related_object;
    protected int $biblio_reference;
    protected string $biblio_emplacement;
    protected string $storage;
    protected string $url_path;
    protected string $extension;
    protected int $creator;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->type_picture = $args['type_picture'] ?? '';
        if (isset($args['height'])) { $this->height = intval($args['height']); } else { $this->height = 0; }
        if (isset($args['width'])) { $this->width = intval($args['width']); } else { $this->width = 0; }
        $this->comment = $args['comment'] ?? '';
        if (isset($args['related_object'])) { $this->related_object = intval($args['related_object']); } else { $this->related_object = 0; }
        if (isset($args['biblio_reference'])) { $this->biblio_reference = intval($args['biblio_reference']); } else { $this->biblio_reference = 0; }
        $this->biblio_emplacement = $args['biblio_emplacement'] ?? '';
        $this->storage = $args['storage'] ?? '';
        $this->url_path = $args['url_path'] ?? '';
        $this->extension = $args['extension'] ?? '';
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function validate() {
        parent::validate();
        $this->errors = add_error($this->errors, check_exists($this->related_object, 'objectTable'));
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['object', $this->related_object()->id(), $this->id()]);
            } elseif ($arg == 'new') {
                return create_url(['object', $this->related_object()->id(), 'new_picture']);
            } elseif ($arg == 'parent') {
                return create_url(['object', $this->related_object()->id()]);
            } else {
                return create_url(['object', $this->related_object()->id(), $this->id()]);
            }
        } else {
            $project_url = $this->related_object()->related_context()->related_phase()->related_site()->project()->code();
            if ($arg == 'update') {
                return create_url([$project_url, 'object', $this->related_object()->id(), $this->id()]);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'object', $this->related_object()->id(), 'new_picture']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'object', $this->related_object()->id()]);
            } else {
                return create_url([$project_url, 'object', $this->related_object()->id(), $this->id()]);
            }
        }
    }

    public function codename($arg="") {
        $codename = secure($this->name . " (" . $this->related_object()->codename() . ")");
        if ($arg == 'title') {
            echo h(2, $codename);
        } else {
            return $codename;
        }
    }

    public function delete($url, $children = [], $reverse = false) {
        if ($this->delink_local_file()) {
            parent::delete($url, $children, $reverse);
        }  
    }

    public function related_object() {
        return ObjectTable::find_by_id($this->related_object);
    }

    public function set_storage($storage="", $url_path="", $extension="") {
        $this->storage = $storage;
        $this->url_path = $url_path;
        $this->extension = $extension;
    }

    public function update_file() {
        // Début du code pour uploader l'image
        if (count($this->errors) == 0) {
            if (isset($_FILES['file_to_upload'])) { if (!$_FILES['file_to_upload']['name'] == "") {
                $pursue = true;
                // Détruit le fichier précédent si cohérent
                $pursue = Picture::find_by_id($this->id())->delink_local_file();
                if (!$pursue) {
                    $this->errors[] = ucfirst(thesaurus("storage_not_clean"));
                    return false;
                } else {
                    $this->set_storage();
                    $target_dir = "static/pictures_objects/";
                    $corrected_name = rue($_FILES["file_to_upload"]["name"], true);
                    $target_file = $target_dir . basename($corrected_name);
                    $upload_ok = 1;
                    $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["file_to_upload"]["tmp_name"]);
                    if($check === false) {
                        $this->errors[] = ucfirst(thesaurus("not_image"));
                        $upload_ok = 0;
                    }
        
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $this->errors[] = ucfirst(thesaurus("file_exists"));;
                        $upload_ok = 0;
                    }
        
                    // Check file size
                    if ($_FILES["file_to_upload"]["size"] > MAX_SIZE_PICTURE) {
                        $size = MAX_SIZE_PICTURE / 1000;
                        $this->errors[] = ucfirst(thesaurus("file_too_big")) . $size . " Ko/Kb.";
                        $upload_ok = 0;
                    }
        
                    // Allow certain file formats
                    if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif" && $image_file_type != "svg" ) {
                        $this->errors[] = ucfirst(thesaurus("not_accepted_format_img"));
                        $upload_ok = 0;
                    }
        
                    // Check if $upload_ok is set to 0 by an error
                    if ($upload_ok == 0) {
                        return false;
                        // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file)) {
                            $url_path = substr($corrected_name, 0, strrpos($corrected_name, '.'));
                            $this->set_storage("local", $url_path, $image_file_type);
                            return true;
                        } else {
                            $this->errors[] = ucfirst(thesaurus("not_uploaded"));
                            return false;
                        }
                    }
                }
            } else {
                $this->set_url_path(Picture::find_by_id($this->id)->url_path());
                return true;
            }} else {return true; }
        } else { return false; }
    }

    // Pour le moment, uniquement extended ; ne gère pas les différents emplacements de stockage
    public function display($extended=false) {
        $html = "<div class='picture' type-picture='" . $this->type_picture . "'>
            <div class='thumb_picture'>
            <img class='object_picture' src='";
        // Gérer le chemin d'accès
        if ($this->storage == "online") {
            $html .= $this->url_path;
        } elseif ($this->storage == "local") {
            //$html .= create_url(['static', 'pictures_objects', $this->url_path]) . "." . rue($this->extension);
            $html .= create_url(['static', 'serve_picture']) . '.php?picture=' . $this->url_path . "." . rue($this->extension);
        }
        $html .= "' ";
        /*if ($this->height > 0) {
            $html .= "height='" . $this->height . "' ";
        }
        if ($this->width > 0) {
            $html .= "width='" . $this->width . "' ";
        }*/
        if ($this->comment) {
            $html .= "data-caption='" . $this->comment . "' ";
        }
        if ($this->contributor_rights()) {
            $html .= "data-link='" . $this->url() . "' ";
        }
        $html .= "></div>";
        if ($this->comment) {
            $html .= "<p class='caption'>" . $this->comment . "</p>";
        }
        $html .= "</div>";
        echo $html;
    }

    public function upload() {
        $html = ucfirst(thesaurus('upload_picture'));
        if ($this->url_path && $this->storage == 1) {
            $html .= " (" . thesaurus("change_file") . ")";
        }
        $html = b($html . thesaurus(":")) . " ";
        $html .= "<input class='form-control' type='file' name='file_to_upload' id='file_to_upload'>";
        return $html;
    }

    public function delink_local_file() {
        if ($this->url_path && $this->storage == 'local') {
            return unlink("static/pictures_objects/" . $this->url_path . "." . rue($this->extension));
        } else {
            return true;
        }
    }

    public function convert($conversion, $reverse=false) {
        if (!$reverse) {
            $this->$conversion = list_val($conversion, $this->$conversion, true);
        }
        else {
            $i = 0;
            while (list_val($conversion, $i, true) !== $this->$conversion && $i < 99) {
                $i++;
            }
            $this->$conversion = $i;
        }
    }

    public function url_path() {
        return secure($this->url_path);
    }
    public function set_url_path($url_path) {
        $this->url_path = $url_path;
    }

    public function storage() {
        return secure($this->storage);
    }

    public function biblio_emplacement() {
        return secure($this->biblio_emplacement);
    }

}

?>