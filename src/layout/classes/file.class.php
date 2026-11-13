<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Variables supplémentaires :
    /
*/
class File extends DatabaseObject {

    static protected $table_name = "file";
    static protected $db_columns = ['id', 'name', 'type', 'descr', 'public',
        'path', 'owner', 'project', 'date_creation', 'date_modification'];
    static protected $links = ['site'=>'site', 'phase'=>'phase', 'context'=>'context', 'objecttable'=>'object', 'facies'=>'facies', 'horizon'=>'horizon', 'project'=>'project', 'bibliography'=>'bibliography'];
    static protected $max_chars = ['name'=>255, 'type'=>64];
    static protected $required = ['name', 'type', 'path', 'owner'];
    static protected $bool = ['public'];

    protected string $name;
    protected string $type;
    protected string $descr;
    protected int $public;
    protected string $path;
    protected int $project;
    protected int $owner;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->type = $args['type'] ?? '';
        $this->descr = $args['descr'] ?? '';
        if (isset($args['public'])) { if ($args['public']) { $this->public = 1; } else { $this->public = 0; } } else { $this->public = 0; }
        $this->path = $args['path'] ?? '';
        $this->project = $args['project'] ?? 0;
        $this->owner = $args['owner'] ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    public function url($arg=false) {
        if ($arg == 'parent') {
            return create_url_proj(['files']);
        } elseif ($arg == 'new') {
            return create_url_proj(['files', 'addfile']);
        }
        return create_url_proj(['files', 'download', $this->id]);
    }

    public function codename($arg="") {
        if ($arg == 'link') {
            if (ISOLATED_WEBSITE) {
                $result = hyperlink(secure($this->name), ['files', 'download', $this->id]);
            } elseif (PROJECT) {
                $result = hyperlink(secure($this->name), [PROJECT->id(), 'files', 'download', $this->id]);
            } else {
                $result = hyperlink(secure($this->name), ['logacer', 'files', 'download', $this->id]);
            }
            if (strlen($this->descr) > 0) {
                $result .= " <abbr title='" . $this->descr . "'><i class='bi bi-info-circle'></i></abbr>";
            }
        } else {
            $result = secure($this->name);
        }
        return $result;
    }

    public function descr_file() {
        if (strlen($this->descr) > 0) {
            return secure($this->descr);
        } else {
            return $this->codename();
        }
    }

    public function project() {
        return Project::find_by_id($this->project);
    }

    public function delete($url, $children = [], $reverse = true) {
        if ($this->delink_local_file()) {
            parent::delete($url, $children, $reverse);
        }  
    }

    // Update le fichier lié ; si fichier temporaire, donne un nom par défaut
    public function update_file($temporary=false, $accepted_types=false) {
        // Début du code pour uploader l'image
        if (count($this->errors) == 0) {
            if (isset($_FILES['file_to_upload'])) { if (!$_FILES['file_to_upload']['name'] == "") {
                $pursue = true;
                // Détruit le fichier précédent si cohérent
                if (!$temporary) {
                    // TO CHANGE !!
                    /* $pursue = Picture::find_by_id($this->id())->delink_local_file(); */
                    if (!$pursue) {
                        $this->errors[] = ucfirst(thesaurus("storage_not_clean"));
                        return false;
                    }
                }
                    // TO CHANGE $this->set_storage();
                    /* set_storage in pictures :
                    public function set_storage($storage="", $url_path="", $extension="") {
                        $this->storage = $storage;
                        $this->url_path = $url_path;
                        $this->extension = $extension;
                    }
                    */
                if ($temporary) {
                    $target_dir = "static/temp/";
                    $file_type = strtolower(pathinfo($_FILES["file_to_upload"]["name"],PATHINFO_EXTENSION));
                    $corrected_name = "temp" . $_SESSION['user']->id() . "." . $file_type;
                    $target_file = $target_dir . basename($corrected_name);
                } else {
                    $target_dir = "static/files/";
                    $corrected_name = rue($_FILES["file_to_upload"]["name"], true);
                    $target_file = $target_dir . basename($corrected_name);
                    $this->name = $corrected_name;
                    $file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                }
                //$target_file = $target_dir . basename($corrected_name);
                $upload_ok = 1;
            
                // Check si vrai fichier : pas encore implémenté
                /* Proposition copilot :
                $file = $_FILES["file_to_upload"]["tmp_name"];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file);
                finfo_close($finfo);

                switch ($mime_type) {
                    case 'application/pdf':
                        echo "Le fichier est un PDF.";
                        break;
                    case 'application/vnd.ms-excel':
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                        echo "Le fichier est un fichier Excel.";
                        break;
                    case 'application/msword':
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        echo "Le fichier est un document Word.";
                        break;
                    case 'text/csv':
                        echo "Le fichier est un CSV.";
                        break;
                    default:
                        echo "Type de fichier non reconnu.";
                }
                */
        
                // Check if file already exists
                if (!$temporary && file_exists($target_file)) {
                    $this->errors[] = ucfirst(thesaurus("file_exists"));;
                    $upload_ok = 0;
                }
        
                // Check file size
                if ($temporary) { $max_size = MAX_SIZE_TEMP; } else { $max_size = MAX_SIZE_FILE; }
                if ($_FILES["file_to_upload"]["size"] > $max_size) {
                    $size = $max_size / 1000;
                    $this->errors[] = ucfirst(thesaurus("file_too_big")) . $size . " Ko/Kb.";
                    $upload_ok = 0;
                }
        
                // Allow certain file formats
                if ($accepted_types) {
                    $auth_types = $accepted_types;
                } else {
                    $auth_types = ['csv', 'xls', 'xlsx', 'pdf', 'doc', 'docx'];
                }
                if(!in_array($file_type, $auth_types)) {
                    $this->errors[] = ucfirst(thesaurus("not_accepted_format")) . thesaurus(":") . ' ' . implode(', ', $auth_types) . '.';
                    $upload_ok = 0;
                }
        
                // Check if $upload_ok is set to 0 by an error
                if ($upload_ok == 0) {
                    return false;
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file)) {
                        $this->path = $target_file;
                        //$this->set_storage("local", $url_path, $imageFileType);
                        return secure($this->path);
                    } else {
                        $this->errors[] = ucfirst(thesaurus("not_uploaded"));
                        return false;
                    }
                }
            } else {
                return false;
            }}
        } else { return false; }
    }

    public function upload() {
        $html = ucfirst(thesaurus('upload_picture'));
        $html = b($html . thesaurus(":")) . " ";
        $html .= "<input class='form-control' type='file' name='file_to_upload' id='file_to_upload' required>";
        return $html;
    }

    public function delink_local_file() {
        if ($this->path) {
            return unlink($this->path);
        }
    }

    public function type() {
        return $this->type;
    }
    
    public function public() {
        return $this->public;
    }

    public function path() {
        return secure($this->path);
    }

}

?>