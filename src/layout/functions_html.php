<?php
    function create_url(array $array) {
        return BASE_URL . implode("/", array_map('rue', str_replace('/', '~', $array)));
    }

    function create_url_proj(array $array) {
        if (!ISOLATED_WEBSITE) {
            if (PROJECT) {
                array_unshift($array, secure(PROJECT->code()));
            } else {
                array_unshift($array, "logacer");
            }
        }
        return create_url($array);
    }

    function hyperlink(string $content, array $array_url, $blank=false) {
        $url_blank = "";
        if ($blank) { $url_blank = " target='_blank'"; }
        return "<a href='" . create_url($array_url) . "'" . $url_blank . ">" . $content . "</a>";
    }

    function serve_picture_public($picture, $local = ALLOW_LOCAL_PICTURES, $link = false, $width = false, $height = false, $icon = false, $class=false, $blank=true) {
        // Par défaut, external URL, sauf si local OK et que pas reconnu comme tel
        $external_url = true;
        if ($local && filter_var($picture, FILTER_VALIDATE_URL) == false && !in_array(strtolower((string) parse_url($picture, PHP_URL_SCHEME)), ['http', 'https'], true)) {
            $external_url = false;
        }

        // Création du lien vers l'image
        if ($external_url) {
            $src = $picture;
        } else {
            $src = BASE_STATIC . 'static/pictures_public/' . $picture;
        }

        // Redimensionnement si nécessaire
        $styles = "";
        if ($width) {
            $styles = " style='width: " . $width . "px";
        }
        if ($height) {
            if (strlen($styles) > 0) {
                $styles .= "; ";
            } else {
                $styles = " style='";
            }
            $styles .= "max-height: " . $height . "px'";
        } elseif (strlen($styles) > 0) {
            $styles .= "'";
        }

        // Échappement des attributs HTML.
        $src_escaped = htmlspecialchars($src, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        // Si icone, particulier
        if ($icon) {
            echo "<link rel='icon' type='image/png' href='" . $src_escaped . "'>";
            return true;
        }

        // Création de l'image
        $img = "<img src='" . $src_escaped . "'" . $styles . ">";

        // Lien, si ajouté
        if ($link) {
            $link_escaped = htmlspecialchars($link, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            if ($blank) {
                $blank = " target='_blank'";
            } else {
                $blank = "";
            }
            if ($class) {
                $class = " class='" . $class . "'";
            } else {
                $class = "";
            }
            echo "<a" . $class . " href='" . $link_escaped . "'" . $blank . ">" . $img . "</a>";
        } else {
            echo $img;
        }
    }

    function dec_sl($expression) {
        return str_replace('~', '/', $expression);
    }

    function p(string $content, $class='') {
        if (strlen($class) > 0) {
            $class = " class='" . $class . "'";
        }
        return "<p" . $class . ">" . $content . "</p>";
    }

    function b(string $content, string $escape = "") {
        return "<b>" . $content . "</b>" . $escape;
    }

    function h($num, string $content) {
        if ($num > 0 && $num <= 6) {
            return "<h" . $num . ">" . $content . "</h" . $num . ">";
        }
    }

    function li(string $content) {
        return "<li>" . $content . "</li>";
    }

    function opt (string $value, string $content="", $selected=false) {
        if ($selected) {
            return "<option value='" . secure($value) . "' selected='selected'>" . secure($content) . "</option>";
        } else {
            return "<option value='" . secure($value) . "'>" . secure($content) . "</option>";
        }
    }

    function label($label, $id='') {
        if (strlen($id) > 0) {
            $id = " for='" . $id . "'";
        }
        return "<label" . $id . " class='form-label'>" . $label . "</label>";
    }

    function select ($label, $content, $id, $name=false, $style='', $class='form-select') {
        if ($label) {
            $label = label($label, $id);
        } else {
            $label = "";
        }
        if ($name) {
            $name = " name='" . $name . "'";
        } else {
            $name = "";
        }
        if (strlen($style) > 0) {
            $style = " style='" . $style . "'";
        }
        return $label . "<select id='" . $id . "'" . $name . " class='" . $class . "'" . $style . ">"
            . $content .
            "</select>";
    }

    function input($type='text', $id='', $placeholder='', $enabled=true) {
        if (strlen($id) > 0) {
            $id = " id='" . $id . "'";
        }
        if (strlen($placeholder) > 0) {
            $placeholder = " placeholder='" . $placeholder . "'";
        }
        if ($enabled) {
            $disabled = '';
        } else { $disabled = ' disabled'; }
        return "<input type='" . $type . "'" . $id . " class='form-control'" . $placeholder . $disabled . ">";
    }

    // Crée une carte
    function card ($header, $content, $id=false) {
        if (is_array($header)) {
            $c = $header['content'];
            $style = isset($header['style']) ? (' ' . $header['style']) : '';
            $head = "<div class='card-header" . $style . "'>" . $c . "</div>";
        } else {
            $head = "<div class='card-header'>" . $header . "</div>";
        }
        if (is_array($content)) {
            $c = $content['content'];
            $style = isset($content['style']) ? (' ' . $content['style']) : '';
            $cont = "<div class='card-body" . $style . "'>" . $c . "</div>";
        } else {
            $cont = "<div class='card-body'>" . $content . "</div>";
        }
        if (!$id) { $id = ''; } else { $id = " id='" . $id . "'"; }
        return "<div class='card mb-3'" . $id . ">" . $head . $cont . "</div>";
    }

    // Crée un bloc, avec marge haute et basse
    function bloc ($content, $margin_bottom=3, $margin_top=0, $id='', $class='') {
        if ($margin_top > 0) {
            $margin_top = 'mt-' . $margin_top;
        } else {
            $margin_top = '';
        }
        if ($margin_bottom > 0) {
            $margin_bottom = ' mb-' . $margin_bottom . ' ';
        } else {
            $margin_bottom = ' ';
        }
        if (strlen($id) > 0) {
            $id = " id='" . $id . "'";
        }
        $class = trim($margin_top . $margin_bottom . $class);
        if (strlen($class) > 0) {
            $class = " class='" . $class . "'";
        }
        return "<div" . $id . $class . ">" . $content . "</div>";
    }

    function modal ($id, $header, $content, $buttons) {
        return "<div class='modal fade' id='" . $id . "' tabindex='-1' aria-labelledby='" . $id . "_label' aria-hidden='true'>
            <div class='modal-header'>
                <h5 class='modal-title' id='" . $id . "_label'>" . $header . "</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='" . ucfirst(thesaurus('close')) ."'></button>
            </div>
            <div class='modal-body'>" . $content . "</div>
            <div class='modal-footer'>" . $buttons . "</div>
        </div>";
    }

    // Permet d'afficher les données sous formes de multiples colonnes. $content est une array,
    // qui peut avoir des clés. Si oui, ce sont les ID
    function in_columns(array $content, $column_number=2, $margin_bottom=3, $margin_top=0, $id='') {
        switch ($column_number) {
            case 1:
                $class = 'col-md-12'; break;
            case 2:
                $class = 'col-md-6';  break;
            case 3:
                $class = 'col-md-4';  break;
            case 4:
                $class = 'col-md-3';  break;
            case 6:
                $class = 'col-md-2';  break;
            case 12:
                $class = 'col-md-1';  break;
            default:
                $class = 'col-md-6';
        }
        $global_content = '';
        foreach ($content as $key=>$value) {
            if (gettype($key) === 'integer') {
                $key = '';
            }
            $global_content .= bloc($value, 0, 0, $key, $class);
        }
        return bloc($global_content, $margin_bottom, $margin_top, $id, 'row');
    }


    function todo() {
        return "<b><div style='color:red'>(des changements sont à faire dans cette fonction, cf. remarques dans les fichiers de classe)</div></b>";
    }

    function button_new(string $content, array $url) {
        if (isset($_SESSION['user'])) {
            echo p("<a class ='btn btn-outline-success' href='" . create_url($url) . "'>" . ucfirst(thesaurus('new')) . ' ' . thesaurus($content) . "</a>");
        }
    }

    function button_delete_sm($name, $id) {
        $html = "<input type='submit' class='btn btn-light btn-sm delete2' value='" . ucfirst(thesaurus("delete")) . "'>";
        $html .= "<input type='hidden' name='typeaction' value='delete" . secure($name) . "'>";
        $html .= "<input type='hidden' name='" . secure($name) ."' value='" . secure($id) . "'>";
        return $html;
    }

    function buttons_validate_sm($url, $type) {
        $html = "<div class='btn-group' role='group'>";
        $html .= "<input class='btn btn-success btn-sm' type='submit' value='" . ucfirst(thesaurus("validate")) . "'>";
        $html .= "<a class ='btn btn-secondary btn-sm' href='" . $url . "'>" . ucfirst(thesaurus("cancel")) . "</a>";
        if ($type == 'biblio') {
            $html .= "<a class='btn btn-info btn-sm' href='" . create_url(['bibliography']) . "' target='_blank'>" . ucfirst(thesaurus("see biblio")) . "</a>";
        }
        $html .= "</div>";
        $html .= "<input type='hidden' name='typeaction' value='" . $type . "added'>";
        return $html;
    }

    function button_add_sm($deffullname, $value) {
        $html = "<input class='btn btn-secondary btn-sm' type='submit' value='" . ucfirst(thesaurus('add')) . ' ' . thesaurus($deffullname) . "'>";
        $html .= "<input type='hidden' name='typeaction' value='add" . $value . "'>";
        return $html;
    }

    function nav_tabs(array $titles, int $active=1, $map=-1) {
        $html = "<ul class='nav nav-tabs'>";
        for ($i = 1 ; $i <= count($titles) ; $i++) {
            $html2 = "<li class='nav-item'><button class='nav-link";
            if ($active === $i) { $html2 .= " active"; }
            if ($i == $map) {
                $number = 'map';
            } else { $number = $i; }
            $html2 .= "' id='b_" . $number . "'>" . ucfirst(thesaurus($titles[$i-1]));
            $html2 .= "</button></li>";
            $html .= $html2;
        }
        return $html . '</ul>';
    }

    function table(string $value, $num, $table_name) {
        echo '<th onclick="sortTable(' . $num . ", '" . $table_name . "'" . ')">' .
            "" . filter_labels($value, "label") . " <abbr title='" . filter_labels($value, "descr") . "'><i class='bi bi-info-circle'></i></abbr>
        </th>";
    }

    function table_headers(array $headers, $table_name) {
        $num = 0;
        foreach ($headers as $header) {
            table($header, $num, $table_name);
            $num++;
        }
        return true;
    }

    function toolbar_wysiwyg() {
        return "<div class='toolbar btn-group mb-2' role='group' style='background: #f8f9fa';'>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyStyle('strong')" . '"' . "><i class='bi bi-type-bold'></i></button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyStyle('em')" . '"' . "><i class='bi bi-type-italic'></i></button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyStyle('u')" . '"' . "><i class='bi bi-type-underline'></i></button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyStyle('h4')" . '"' . "><i class='bi bi-text-paragraph'></i> T1</button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyStyle('h6')" . '"' . "><i class='bi bi-text-paragraph'></i> T2</button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyList('ul')" . '"' . "><i class='bi bi-list-ul'></i></button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyList('ol')" . '"' . "><i class='bi bi-list-ol'></i></button>
                <button type='button' class='btn btn-outline-secondary' onclick=" . '"' . "applyLink()" . '"' . "><i class='bi bi-link-45deg'></i></button>
            </div>";
    }

    function filter_box($cols, $tablename, $biblio_review = false, $min_width = 120) {
        if ($biblio_review) {
            $background1 = " style='background-color:#fad370; color:inherit;'";
            $background2 = " style='background-color:#f4e9cd'";
        } else {
            $background1 = "";
            $background2 = "";
        }
        // Préparation de l'accordéon
        echo "<div class='accordion' id='filters-" . $tablename . "'>
            <div class='accordion-item'>
                <h2 class='accordion-header'>
                    <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse-one' aria-expanded='true' aria-controls='collapse-one'" . $background1 . ">"
                    . ucfirst(thesaurus("filters table")) .
                    "</button>
                </h2>
                <div id='collapse-one' class='accordion-collapse collapse' data-bs-parent='#filters-" . $tablename . "'>
                    <div class='accordion-body'" . $background2 . ">";
                    // Filtre général
                    echo "<div class='row g-2 mb-2'><div class='col-12 d-flex align-items-center'>
                        <label for='filter-all' class='form-label me-2 mb-0' style='min-width:" . $min_width ."px;'><b>" . filter_labels('all', "label") . thesaurus(":") . "</b></label>
                        <input type='text' id='filter-all' class='form-control form-control-sm flex-grow-1 filter-" . $tablename . "' data-col='all' placeholder='" . filter_labels('all', "ph") . "'>
                        </div></div>";
                    // Filtres personnalisés
                    echo "<div class='row g-2'>";
                    $column = 0;
                    foreach ($cols as $col) {
                        if (!in_array($col , ['descr', 'inventory', 'n_rim', 'n_bottom', 'n_handle', 'n_wall', 'n_mni', 'n_sherd', 'number_of_objects'])) {
                            echo "<div class='col-md-6 d-flex align-items-center'>
                                <label for='" . $tablename . "-" . $col . "' class='form-label me-2 mb-0' style='min-width:" . $min_width . "px;'>" . filter_labels($col, "label") . thesaurus(":") . "</label>
                                <input type='text' id='" . $tablename . "-" . $col . "' class='form-control form-control-sm filter-" . $tablename . "' data-col='" . $column . "' placeholder='" . filter_labels($col, "ph") . "'>
                                </div>";                            
                        }
                        $column++;
                    }
                    echo "</div>";
                    echo "</div>
                </div>
            </div>
        </div>";
    }

?>