<?php

/* Description de l'objet
** Fonctions statiques :
    find_by_abbr()

** Variables supplémentaires :
    pagination
*/
class Bibliography extends DatabaseObject {

    static protected $table_name = "bibliography";
    static protected $db_columns = ['id', 'abbreviation', 'reference', 'reference_html', 'onicer_link',
        'creator', 'date_creation', 'date_modification'];
    static protected $links = ['file'=>'file', 'site'=>'site', 'phase'=>'phase', 'context'=>'context', 'facies'=>'facies', 'typology'=>'typology', 'type'=>'type', 'fabric'=>'fabric'];
    static protected $max_chars = ['abbreviation'=>128];
    static protected $required = ['abbreviation', 'creator'];
    static protected $uniques = ['abbreviation'];

    static public function find_by_abbr($abbr) {
        $object = static::find_by_sql("SELECT * FROM bibliography WHERE abbreviation = :abbreviation", ['abbreviation'=>$abbr]);
        if (!empty($object)) {
            return array_shift($object);
        } else {
            return false;
        }
    }

    static public function find_by_project($projectid) {
        return static::find_by_sql("SELECT bibliography.* FROM bibliography
            JOIN (
                -- 1. Bibliographies liées à un context
                SELECT lb.bibliography AS bibliography_id
                FROM link_context_bibliography AS lb
                JOIN context AS c
                    ON c.id = lb.context
                JOIN phase AS p
                    ON p.id = c.related_phase
                JOIN site AS s
                    ON s.id = p.related_site
                WHERE s.project = :project_context

                UNION

                -- 2. Bibliographies liées à un fabric
                SELECT lb.bibliography
                FROM link_fabric_bibliography AS lb
                JOIN fabric AS f
                    ON f.id = lb.fabric
                WHERE f.related_project = :project_fabric

                UNION

                -- 3. Bibliographies liées à un facies
                SELECT lb.bibliography
                FROM link_facies_bibliography AS lb
                JOIN facies AS f
                    ON f.id = lb.facies
                WHERE f.project = :project_facies

                UNION

                -- 4. Bibliographies liées à une phase
                SELECT lb.bibliography
                FROM link_phase_bibliography AS lb
                JOIN phase AS p
                    ON p.id = lb.phase
                JOIN site AS s
                    ON s.id = p.related_site
                WHERE s.project = :project_phase

                UNION

                -- 5. Bibliographies liées à un site
                SELECT lb.bibliography
                FROM link_site_bibliography AS lb
                JOIN site AS s
                    ON s.id = lb.site
                WHERE s.project = :project_site

                UNION

                -- 6. Bibliographies liées à un type
                SELECT lb.bibliography
                FROM link_type_bibliography AS lb
                JOIN type AS t
                    ON t.id = lb.type
                JOIN typology AS ty
                    ON ty.id = t.typology
                WHERE ty.related_project = :project_type

                UNION

                -- 7. Bibliographies liées à une typology
                SELECT lb.bibliography
                FROM link_typology_bibliography AS lb
                JOIN typology AS ty
                    ON ty.id = lb.typology
                WHERE ty.related_project = :project_typology

            ) AS linked_bibliographies
                ON linked_bibliographies.bibliography_id = bibliography.id", [
                    'project_context'  => $projectid,
                    'project_fabric'   => $projectid,
                    'project_facies'   => $projectid,
                    'project_phase'    => $projectid,
                    'project_site'     => $projectid,
                    'project_type'     => $projectid,
                    'project_typology' => $projectid,
                ],
                ['abbreviation']);
    }

    protected string $abbreviation;
    protected string $reference;
    protected string $reference_html;
    protected string $onicer_link;
    protected int $creator;

    protected $pagination;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->abbreviation = $args['abbreviation'] ?? '';
        $this->reference = $args['reference'] ?? '';
        $this->reference_html = $args['reference_html'] ?? '';
        $this->onicer_link = $args['onicer_link'] ?? '';
        $this->creator = $args['creator'] ?? $_SESSION['user']->id() ?? 0;
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
        $this->pagination = $args['pagination'] ?? '';
    }

    public function url($arg=false) {
        if (ISOLATED_WEBSITE) {
            if ($arg == 'update') {
                return create_url(['bibliography', $this->id(), 'update']);
            } elseif ($arg == 'new') {
                return create_url(['bibliography', 'new']);
            } elseif ($arg == 'parent') {
                return create_url(['bibliography']);
            } else {
                return create_url(['bibliography', $this->id()]);
            }
        } else {
            if (PROJECT) {
                $project_url = PROJECT->code();
            } else {
                $project_url = 'logacer';
            }
            if ($arg == 'update') {
                return create_url([$project_url, 'bibliography', $this->id(), 'update']);
            } elseif ($arg == 'new') {
                return create_url([$project_url, 'bibliography', 'new']);
            } elseif ($arg == 'parent') {
                return create_url([$project_url, 'bibliography']);
            } else {
                return create_url([$project_url, 'bibliography', $this->id()]);
            }
        }
    }

    public function codename($arg="") {
        if ($arg == 'link') {
            $result = hyperlink(secure($this->abbreviation), ['bibliography', $this->id]);
        } elseif ($arg == 'not_secure') {
            $result = $this->abbreviation;
        } else {
            $result = secure($this->abbreviation);
        }
        if ($this->pagination) {
            $result .= ", " . secure($this->pagination);
        }
        return $result;
    }

    public function abbreviation() {
        return $this->abbreviation;
    }

    public function complete_ref($arg = "") {
        if ($arg = 'display') {
            echo p(b(ucfirst(thesaurus('reference')) . thesaurus(":") . " ") . secure($this->reference_html, 1));
        } else {
            return secure($this->reference_html, 1);
        }
    }

    public function onicer_link($arg = "") {
        if ($this->onicer_link) {
            $html = "<a href='https://heurist.huma-num.fr/heurist/Xavie_ONICerBib/view/" . secure($this->onicer_link) . "'>" . ucfirst(thesaurus('click here')) . "</a>";
            if ($arg = 'display') {
                echo p(b(ucfirst(thesaurus('onicer_link')) . thesaurus(":") . " ") . $html);
            } else {
                return $html;
            }
        } else {
            return false;
        }
        
    }

    public function pagination() {
        return $this->pagination;
    }
}

?>