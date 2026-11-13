            <h4>Para utilizar la herramienta, puede consultar la <a href='<?php echo create_url_proj(['tutorials']); ?>'>lista de tutoriales</a>.</h4><br>
            <h2>Presentación de la base de datos <?php echo PROJECT->code(); ?></h2>
            <br>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <h2>Responsable y colaboradores del proyecto</h2>
            <br>
            <p>El proyecto está gestionado por <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>. <?php
            $contributors = User::linked('project', 'contributor', PROJECT->id());
            if (count($contributors) > 0) {
                echo "Colaboradores del proyecto: ";
                $already = 0;
                foreach ($contributors as $contrib) {
                    if ($already > 0) {
                        if (($already + 1) === count($contributors)) {
                            echo " " . thesaurus("and") . " ";
                        } else {
                            echo ", ";
                        }
                    }
                    echo $contrib->codename();
                    $already++;
                }
            } ?>.</p>
            <h2>Propiedad intelectual y protección de datos</h2>
            <br>
            <ul>
                <li><b>Responsabilidad de los usuarios:</b> Cada colaborador es responsable de la propiedad intelectual de los datos que deposita. Los datos inéditos pertenecen a sus autores, salvo que se indique lo contrario.</li>
                <li><b>Confidencialidad:</b> Ningún dato está cifrado (excepto las contraseñas). El administrador de la base de datos se compromete a no consultar ni utilizar los datos marcados como privados sin autorización.</li>
                <li><b>Mejoras en curso:</b> Para cualquier pregunta o sugerencia relacionada con la protección de datos, utilice el formulario de contacto disponible en <a href="https://www.logacer.org/about_us#contact" target="_blank">esta dirección</a>.</li>
            </ul>
            <br>

            <h2>Arquitectura de software</h2>
            <br>
            <p>Para obtener más información sobre la infraestructura técnica, consulte la página dedicada a <a href='<?php echo create_url_proj(['logacer']); ?>'><?php serve_picture_public("Logo-logacer-2.png", true, false, 20); ?> LOGACer</a>.</p>
            <br>
