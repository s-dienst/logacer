            <h2>Aviso legal - <?php echo PROJECT->code(); ?></h2>
            <h5>Editor de LOGACer</h5>
            <p>
                Simon Dienst
                </br>Service d'histoire de l'art et archéologie de l'Antiquité gréco-romaine (SHAARAGR)
                </br>Département des sciences historiques
                </br>Faculté de Philosophie et lettres
                </br>Université de Liège
                </br>Place du 20-Août, 7
                </br>B-4000 Liège, Belgique
                </br>Email : Simon.Dienst@uliege.be
                </br>Site web : www.logacer.org
            </p>
            <h5>Alojamiento web</h5>
            <p>
                Para obtener información sobre el alojamiento web, póngase en contacto con el responsable de la instalación a través del <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulario de contacto</a>.
            </p>
            <h5>Responsable de la publicación</h5>
            <p>Los datos publicados son responsabilidad exclusiva de <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?> y en ningún caso comprometen la responsabilidad del proveedor de alojamiento web.</p>
            <h5>Software utilizado</h5>
            <p>La base de datos se publica utilizando <a href="https://www.logacer.org">LOGACer - Logiciel Online de Gestion et d'Analyse de la Céramique</a>, un software desarrollado por Simon Dienst.</p>
            <h5>Propiedad intelectual</h5>
            <p>El contenido del sitio web (textos, imágenes, datos científicos) está protegido por la normativa sobre derechos de autor. Los datos científicos pueden tener diversos orígenes: datos inéditos, datos publicados por el autor de las fichas o datos retomados y reelaborados por el autor de las fichas. Los colaboradores de la base de datos deben diferenciar estos distintos casos. Los usuarios se comprometen a respetar los derechos de autor.</p>
            <h5>Condiciones de uso</h5>
            <p>El uso de <?php echo PROJECT->code(); ?> es gratuito y está destinado a un uso profesional o académico. Se prohíbe cualquier uso abusivo o fraudulento. El uso de los datos publicados en LOGACer o en uno de sus proyectos (datos inéditos o reelaborados) debe incluir la correspondiente referencia a la fuente.</p>
            <h5>Contacto</h5>
            <p>Para cualquier consulta: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulario de contacto</a>.</p>
