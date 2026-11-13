    <!-- Barre latérale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Volver: Lista de tutoriales</a></h6><br>
        <h4 class="px-3">Principios y navegación</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principios básicos</h5></a>
        <a href="#opération-objet"><h5 class="px-3">II. De la operación al objeto</h5></a>
        <a href="#liste-opérations">1. Lista de operaciones</a>
        <a href="#opération-archéologique">2. Operación arqueológica</a>
        <a href="#horizon-site">3. Horizonte-sitio</a>
        <a href="#contexte-inventaire">4. Contexto e inventario</a>
        <a href="#objet-illustration">5. Objeto e ilustración(es)</a>
        <a href="#horizons-régionaux"><h5 class="px-3">III. Horizontes regionales</h5></a>
        <a href="#liste-groupes-horizons">1. Lista de grupos de horizontes</a>
        <a href="#groupe-horizons">2. Descripción del grupo de horizontes</a>
        <a href="#horizon-régional">3. Horizontes regionales y material relacionado</a>
        <a href="#types-pâtes"><h5 class="px-3">IV. Tipos y grupos de pastas</h5></a>
        <a href="#typologies-types">1. Tipologías y tipos</a>
        <ul>
            <li><a href="#liste-typologies">Lista de tipologías</a></li>
            <li><a href="#typologie">Descripción de la tipología</a></li>
            <li><a href="#types">Descripción de los tipos</a></li>
        </ul>
        <a href="#pâtes">2. Grupos de pastas</a>
        <ul>
            <li><a href="#liste-groupes-pâtes">Lista de los grupos de pastas</a></li>
            <li><a href="#groupes-pâtes">Descripción de los grupos de pastas</a></li>
        </ul>
        <a href="#bibliographie"><h5 class="px-3">V. Bibliografía</h5></a>
        <a href="#liste-bibliographie">1. Lista de referencias</a>
        <a href="#consulter-bibliographie">2. Consultar una referencia</a>
        <a href="#autres-éléments"><h5 class="px-3">VI. Otros elementos</h5></a>
        <a href="#fichiers-génériques">1. Archivos genéricos</a>
        <a href="#citer-page">2. Citar una página</a>
        <a href="#a-propos">3. Acerca del sitio web</a>
        <a href="#recherche-simple">4. Búsqueda simple</a>
        <a href="#enregistrement-connexion">5. Registro y conexión</a>
    </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: principios básicos y navegación por la herramienta sin conexión</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principios básicos</h2>

    <p>El objetivo central de LOGACer, utilizado por CeVICA, es poner a disposición inventarios de objetos (en particular, de cerámica), al tiempo que permite incorporar otra información y realizar consultas sobre estos objetos. Para ello, LOGACer se basa en diferentes elementos:</p>
    <ul>
        <li>La contextualización del <b>objeto</b>: es la parte central de LOGACer. El objeto forma parte de un <b>contexto</b> (o unidad estratigráfica), que a su vez está relacionado con otros contextos contemporáneos (el <b>horizonte-sitio</b>), y todo ello ha sido documentado durante una <b>operación arqueológica</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>La cronología relativa del objeto: los horizontes-sitio pueden agruparse en <b>horizontes regionales</b>. Estos se suceden dentro de una región geográfica; esta sucesión se agrupa mediante <b>grupos de horizontes</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>La caracterización del objeto: la cerámica se clasifica, según el modelo conservado en LOGACer, en función de su <b>categoría</b>, su <b>función</b>, su <b>tipo</b> y su <b>grupo de pastas</b>. Los dos primeros criterios de clasificación están bastante estandarizados y son limitados. Los tipos, en cambio, son mucho más numerosos y se agrupan en <b>tipologías</b>; lo mismo ocurre con los grupos de pastas, que pueden organizarse jerárquicamente. La caracterización de los tipos y grupos de pastas, así como la posibilidad de realizar búsquedas sobre ellos, también es importante. Las categorías, funciones, tipologías y tipos están ampliamente vinculados a ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>Las referencias: es posible completar la caracterización de estos diferentes elementos haciendo referencia a una <b>bibliografía</b> de referencia o añadiendo <b>archivos</b>. Además, estos elementos son gestionados por <b>usuarios</b> (responsables o colaboradores en determinados casos). Por último, los objetos pueden ir acompañados de <b>ilustraciones</b>, como dibujos, fotografías o ampliaciones;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>La colaboración: un equipo que trabaja sobre diferentes elementos (sitios, horizontes regionales, etc.) puede encontrarlos agrupados dentro de <b>proyectos</b>, lo que permite una mejor gestión de los derechos de dicho equipo.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>

    <p>La navegación está diseñada para privilegiar un enfoque contextual (de la operación arqueológica al objeto), pero también para tener en cuenta estos diversos vínculos: presentación de los objetos por horizontes regionales, tipos y grupos de pastas (así como sus ilustraciones), presentación de los horizontes-sitio por horizontes regionales (con las categorías y tipos presentes), elementos vinculados a una referencia bibliográfica, así como consultas más elaboradas.</p>
    </section>

    <section id="opération-object" class="mb-5">
    <h2>II. Navegación: de la operación arqueológica al objeto</h2>
        <section id="liste-opérations" class="mb-5">
        <h3>1. Lista de las operaciones arqueológicas</h3>

            <p>La lista de las operaciones arqueológicas está disponible a través de la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_1.png" width="80%"></div>
            <p>Dentro de esta lista, se puede acceder a la operación que le interesa mediante un mapa interactivo o mediante la lista de operaciones arqueológicas.</p>

            <h4>1.1. Mapa</h4>
                <p>Cada operación arqueológica está representada por un marcador en el mapa. Al hacer clic en el marcador, puede ver de qué operación arqueológica se trata. Puede acceder a ella haciendo clic sobre el marcador.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2.png" width="80%"></div>
                <p>Si varias operaciones arqueológicas tienen las mismas coordenadas, se muestran en el mismo marcador.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_3.png" width="80%"></div>
                <p>Por último, si una zona contiene muchas operaciones arqueológicas, aparece un círculo de color en lugar de un marcador, con el número de operaciones presentes en esa zona. Al hacer clic sobre él, es posible ampliar el mapa y subdividir este marcador en varios círculos y/o marcadores individuales. También es posible ampliar el mapa normalmente.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2b.png" width="80%"></div>

            <h4>1.2. Lista de las operaciones arqueológicas</h4>
                <p>Al hacer clic en la pestaña correspondiente, también puede acceder a una tabla sintética de las operaciones arqueológicas.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_4.png" width="80%"></div>
                <p>La tabla está clasificada por país y, después, por región. Las operaciones arqueológicas se muestran por orden alfabético de código. Las que no han sido asociadas a una región se agrupan al final de la lista. Al hacer clic en los encabezados de las columnas, es posible ordenar esta tabla según dicha columna (por orden alfabético ascendente y, al hacer clic una segunda vez, descendente).</p>
                <p>También es posible filtrar la tabla según uno o varios campos. Los filtros se muestran al hacer clic en «Mostrar los filtros de la tabla». A continuación, basta con introducir una parte del contenido de un campo para filtrar la tabla.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
        </section>

        <section id="opération-archéologique" class="mb-5">
        <h3>2. Descripción de la operación arqueológica</h3>
            <p>Al hacer clic en una operación arqueológica, se accede a su página descriptiva. Esta página contiene información sobre:</p>
            <ul>
                <li>La persona que añadió la operación a CeVICA y los colaboradores que pueden alimentar la página;</li>
                <li>La información geográfica: región, latitud y longitud;</li>
                <li>Una descripción de la operación arqueológica, cuya extensión y organización pueden variar;</li>
                <li>Los diferentes horizontes-sitio presentes. Cuando algunos contextos no han sido asociados a un horizonte-sitio, se puede acceder a ellos haciendo clic en «Contextos sin horizonte-sitio»;</li>
                <li>Las referencias bibliográficas vinculadas a la operación arqueológica;</li>
                <li>Los archivos asociados a la operación arqueológica;</li>
                <li>La información necesaria para citar correctamente la página.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
            <p>Es posible que algunas de estas secciones no estén presentes, dependiendo de la información completada o vinculada a la operación arqueológica. En el caso de la bibliografía, si la operación arqueológica (o el horizonte-sitio o el contexto) nunca ha sido publicada, esto se indica claramente.</p>
            <p>Uno de los archivos, presente automáticamente, permite descargar el inventario completo de la operación arqueológica. Lo mismo ocurre con el horizonte-sitio y el contexto.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_6.png" width="80%"></div>
            <p>En función de lo indicado al completar el sitio, el fondo puede ser diferente y un marco puede indicar que se trata de datos extraídos de una publicación. Esta información permite poner de manifiesto los casos en los que el autor de la ficha no es uno de los investigadores que trabajaron en la operación arqueológica, sino que los datos se pusieron en línea como parte de un trabajo más amplio, en el marco de una revisión bibliográfica.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_7.png" width="80%"></div>
        </section>

        <section id="horizon-site" class="mb-5">
        <h3>3. Descripción del horizonte-sitio</h3>
            <p>Al hacer clic en uno de los horizontes-sitio, se accede a una nueva ventana con la siguiente información:</p>
            <ul>
                <li>La operación arqueológica a la que pertenece el horizonte-sitio;</li>
                <li>La persona que añadió la operación a CeVICA, así como la que añadió el horizonte-sitio;</li>
                <li>La información sobre el horizonte regional, si el horizonte-sitio está vinculado a un horizonte regional;</li>
                <li>Una descripción del horizonte-sitio, cuya extensión y organización pueden variar;</li>
                <li>Los diferentes contextos presentes;</li>
                <li>Las referencias bibliográficas vinculadas al horizonte-sitio (generalmente, las mismas que para la operación arqueológica, salvo modificación explícita por parte del autor de la ficha);</li>
                <li>Los archivos asociados al horizonte-sitio;</li>
                <li>La información necesaria para citar correctamente la página.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_8.png" width="80%"></div>
            <p>Se puede hacer clic en el horizonte regional. Se especifica la importancia del horizonte-sitio para la definición del horizonte regional (principal, secundario, incierto o desconocido).</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_9.png" width="80%"></div>
        </section>

        <section id="contexte-inventaire" class="mb-5">
        <h3>4. Descripción del contexto e inventario</h3>
            <p>Al hacer clic en uno de los contextos, se accede a su ventana, con el inventario. La información es, en términos generales, similar a la de la fase, cuando está disponible. Una pestaña permite pasar de la descripción al inventario.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_10.png" width="80%"></div>
            <p>Cuando no hay descripción, el inventario se muestra directamente, sin pestaña. Puede exportarse mediante el botón azul, al igual que desde los archivos asociados.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11.png" width="80%"></div>
            <p>Al hacer clic en el número de inventario, es posible acceder a los detalles del objeto y a sus ilustraciones.</p>
            <p>Las categorías, funciones, tipos y grupos de pastas pueden estar registrados en CeVICA. En ese caso, la categoría y la función se indican en negro, mientras que el tipo y el grupo de pastas aparecen en azul (se puede hacer clic sobre ellos para acceder a la ficha correspondiente). Al pasar el ratón por encima de la categoría o del grupo de pastas, es posible ver la denominación completa.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_12.png" width="80%"></div>
            <p>Si alguno de estos elementos no está presente en la base de datos, aparece indicado en gris y en un tamaño más pequeño.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13.png" width="80%"></div>
            <p>Es posible ordenar la tabla haciendo clic en los encabezados de las columnas. Cabe señalar que las categorías, funciones, tipos y grupos de pastas se ordenan según su código y no según lo que se muestra; los elementos no referenciados aparecen por orden alfabético al final de la clasificación.</p>
            <p>También es posible filtrar la tabla haciendo clic en la pestaña de filtros e introduciendo las expresiones buscadas. Las categorías, funciones y tipos también pueden buscarse según su código.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11b.png" width="80%"></div>
            <p>La presencia de una ilustración se indica mediante un «Sí» en la casilla correspondiente.</p>
            <p>Por defecto, solo se recuperan las 200 primeras líneas del inventario, por motivos de rendimiento. Es posible recuperar las líneas adicionales (200 cada vez) haciendo clic en «Cargar más».</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13b.png" width="80%"></div>
        </section>

        <section id="objet-illustration" class="mb-5">
        <h3>5. Descripción del objeto e ilustración(es)</h3>
            <p>Al hacer clic en el objeto, se recupera la misma información que en los contextos, presentada en forma de lista.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_14.png" width="60%"></div>
            <p>Una pestaña permite consultar las ilustraciones, si las hay para el objeto. Es posible mostrar estas ilustraciones en mayor tamaño haciendo clic sobre ellas.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_15.png" width="80%"></div>
            <p>Una vez mostrada la ilustración, es posible volver a la visualización inicial haciendo clic al lado de la imagen o en la cruz situada en la parte superior derecha.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_16.png" width="80%"></div>
        </section>
    </section>

    <section id="horizons-régionaux" class="mb-5">
    <h2>III. Horizontes regionales</h2>
        <section id="liste-groupes-horizons" class="mb-5">
        <h3>1. Lista de los grupos de horizontes</h3>
            <p>La lista de los horizontes regionales es accesible desde la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_17.png" width="80%"></div>
            <p>La lista está ordenada por país y, a continuación, por región. Los grupos de horizontes se muestran por orden alfabético según su código. Cuando un grupo de horizontes se extiende por varias regiones, aparece varias veces. Los que no han sido asignados a una región se agrupan al final de la lista.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_18.png" width="50%"></div>
          </section>

        <section id="groupe-horizons" class="mb-5">
        <h3>2. Descripción del grupo de horizontes</h3>
            <p>Al hacer clic en un grupo de horizontes, se accede a su página descriptiva. Esta página contiene información sobre:</p>
            <ul>
                <li>La persona que ha añadido el grupo a CeVICA y los colaboradores que pueden completar la página;</li>
                <li>Las regiones afectadas por los horizontes;</li>
                <li>Una descripción del grupo de horizontes, cuya extensión y estructura pueden variar;</li>
                <li>Los diferentes horizontes regionales presentes (algunos de los cuales pueden estar divididos internamente en subhorizontes);</li>
                <li>Las referencias bibliográficas asociadas;</li>
                <li>Los archivos asociados;</li>
                <li>La información necesaria para citar correctamente la página.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_19.png" width="80%"></div>
            <p>Es posible que algunas de estas partes no aparezcan, dependiendo de la información que se haya completado o asociado a la operación arqueológica. En cuanto a la bibliografía, si la operación arqueológica (o el horizonte-sitio o el contexto) nunca ha sido publicada, esto se indica claramente.</p>
        </section>

        <section id="horizon-régional" class="mb-5">
        <h3>3. Los horizontes regionales y el material arqueológico asociado</h3>
            <p>Al seleccionar un horizonte (desde el grupo, una fase o un inventario), se puede acceder a diversas informaciones y a varias pestañas.</p>
            <p><b>Importante:</b> Cuando un horizonte tiene varios subhorizontes, la información que aparece corresponde únicamente al horizonte genérico y no a los subhorizontes.</p>

            <h4>3.1. Información general</h4>
                <p>Aquí se encuentra:</p>
                <ul>
                    <li>El grupo al que pertenece el horizonte regional;</li>
                    <li>La persona que ha añadido el grupo de horizontes a CeVICA, así como la que ha añadido el horizonte regional;</li>
                    <li>El número de objetos registrados (líneas de inventario) correspondientes a este horizonte.</li>
                </ul>

            <h4>3.2. Descripción</h4>
                <p>La descripción incluye:</p>
                <ul>
                    <li>Una descripción del horizonte, cuya extensión y estructura pueden variar;</li>
                    <li>En su caso, los diferentes subhorizontes presentes;</li>
                    <li>Una datación (también en forma de texto libre);</li>
                    <li>Los horizontes-sitios que constituyen el horizonte regional, así como su grado de importancia para el horizonte;</li>
                    <li>Los archivos asociados;</li>
                    <li>La información necesaria para citar correctamente la página.</li>
                </ul> 
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_20.png" width="80%"></div>

            <h4>3.3. Distribución</h4>
                <p>La distribución presenta un mapa de los diferentes horizontes-sitios que constituyen el horizonte regional. Al hacer clic en un marcador, es posible ver el o los horizontes-sitios presentes en ese lugar, así como el número de objetos pertenecientes a ese horizonte-sitio.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_21.png" width="80%"></div>

            <h4>3.4. Lista de tipos</h4>
                <p>Una tabla, que se puede ordenar, registra todos los tipos presentes, por categoría, dentro del horizonte. El número de ocurrencias indica el número de líneas de inventario correspondientes a ese tipo para este horizonte.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_22.png" width="80%"></div>
                <p>Es posible ordenar la tabla teniendo en cuenta que, para las categorías y los tipos, se utiliza el código y no la abreviatura o el nombre para establecer el orden. También es posible filtrar la tabla mediante el menú de filtros, que se puede mostrar haciendo clic en él.</p>

            <h4>3.5. Ilustraciones</h4>
                <p>Esta pestaña contiene todas las ilustraciones de los objetos presentes en el horizonte. Es posible ordenarlas según su tipo.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_23.png" width="80%"></div>
                <p>Es posible mostrar estas ilustraciones en mayor tamaño haciendo clic sobre ellas. Una vez mostrada la ilustración, se puede volver a la visualización inicial haciendo clic fuera de ella o en la cruz situada en la esquina superior derecha.</p>

            <h4>3.6. Inventario</h4>
                <p>Esta última pestaña muestra el inventario completo del horizonte regional. Funciona de la misma manera que el inventario del contexto, incluyendo además los códigos de los sitios, horizontes-sitios y contextos. Es posible hacer clic en estos códigos para acceder a su ficha, o simplemente pasar el ratón por encima para ver su nombre.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_24.png" width="80%"></div>
                <p>La tabla puede ordenarse y filtrarse de la misma manera que el inventario del contexto y también está limitada por defecto a 200 líneas de inventario.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_25.png" width="80%"></div>
                <p>Los aspectos relacionados con los nombres publicados de las categorías, funciones, tipos y grupos de pastas cuando difieren de los de CeVICA se añadirán más adelante (se trata de una función que actualmente no se utiliza).</p>
        </section>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>IV. Tipos y grupos de pastas</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Tipologías y tipos</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Lista de las tipologías</h4>
                <p>La lista de las tipologías es accesible desde la barra superior.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_26.png" width="80%"></div>
                <p>La lista está ordenada según la categoría a la que está asociada la tipología. Algunas tipologías están asociadas a varias categorías y aparecen en cada una de ellas. Las tipologías que no han sido asociadas a ninguna categoría (y que, por tanto, no pueden utilizarse para vincular objetos) se agrupan al final de la lista.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Descripción de la tipología</h4>
                <p>Al hacer clic en una tipología, se accede a su página descriptiva. Esta página contiene, en primer lugar, información sobre:</p>
                <ul>
                    <li>La persona que ha añadido la tipología a CeVICA y los colaboradores que pueden completar la página;</li>
                    <li>Una descripción de la tipología, cuya extensión y estructura pueden variar;</li>
                    <li>Las referencias bibliográficas asociadas a la operación arqueológica;</li>
                    <li>Los archivos asociados a la operación arqueológica;</li>
                    <li>La información necesaria para citar correctamente la página.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>La pestaña «Categorías» muestra la lista de categorías para las que la tipología (y, por tanto, sus tipos) puede utilizarse.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>La pestaña «Tipos» muestra, por orden alfabético de los códigos, la lista de tipos asociados a la categoría. Si algunos tipos tienen subtipos, estos no aparecen aquí.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Los tipos y su material asociado</h4>
                <p>Al seleccionar un tipo (a través de una tipología o desde un inventario), se puede acceder a diversas informaciones y a varias pestañas.</p>
                <p><b>Importante:</b> Cuando un tipo tiene varios subtipos, la información que aparece corresponde únicamente al tipo genérico y no a los subtipos.</p>

                <h5>1.3.1. Información general</h5>
                    <p>Aquí se encuentra:</p>
                    <ul>
                        <li>La tipología a la que pertenece el tipo (y, eventualmente, el tipo principal del subtipo);</li>
                        <li>La persona que ha añadido la tipología a CeVICA, así como la que ha añadido el tipo;</li>
                        <li>El número de objetos registrados (líneas de inventario) correspondientes a este tipo.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_31.png" width="80%"></div>

                <h5>1.3.2. Distribución</h5>
                    <p>La distribución se presenta mediante un mapa interactivo o mediante la lista de las operaciones arqueológicas que contienen este tipo.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_32.png" width="80%"></div>
                    <p>Al igual que para la lista de las operaciones arqueológicas, al hacer clic en un marcador es posible ver las operaciones arqueológicas, así como el número de líneas de inventario identificadas como pertenecientes a este tipo.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_33.png" width="80%"></div>
                    <p>La lista de las operaciones arqueológicas funciona en forma de tabla, con los mismos datos. Es posible acceder a la operación arqueológica o al inventario cruzado de la operación arqueológica y del tipo (haciendo clic en «ver»).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_34.png" width="80%"></div>
                    <p>La tabla también puede ordenarse y filtrarse.</p>

                <h5>1.3.3. Descripción</h5>
                    <p>La descripción incluye:</p>
                    <ul>
                        <li>Una descripción del tipo, cuya extensión y estructura pueden variar;</li>
                        <li>En su caso, los diferentes subtipos presentes;</li>
                        <li>Una datación (también en forma de texto libre);</li>
                        <li>La bibliografía;</li>
                        <li>La información necesaria para citar correctamente la página.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_35.png" width="80%"></div>

                <h5>1.3.4. Ilustraciones</h5>
                    <p>Esta pestaña contiene todas las ilustraciones de los objetos de este tipo. Es posible ordenarlas según el tipo de ilustración.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_36.png" width="80%"></div>
                    <p>Es posible mostrar estas ilustraciones en mayor tamaño haciendo clic sobre ellas. Una vez mostrada la ilustración, se puede volver a la visualización inicial haciendo clic fuera de ella o en la cruz situada en la esquina superior derecha.</p>

                <h5>1.3.5. Grupos de pastas</h5>
                    <p>Esta pestaña muestra los grupos de pastas registrados para este tipo. Es posible consultar este grupo de pastas o el inventario de los objetos correspondientes al tipo y al grupo de pastas seleccionado.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_37.png" width="80%"></div>

                <h5>1.3.6. Inventario</h5>
                    <p>Esta última pestaña muestra el inventario completo del tipo. Funciona de la misma manera que el inventario del contexto, incluyendo además los códigos de los sitios, horizontes-sitios y contextos. Es posible hacer clic en estos códigos para acceder a su ficha, o simplemente pasar el ratón por encima para ver su nombre.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_38.png" width="80%"></div>
                    <p>La tabla puede ordenarse y filtrarse de la misma manera que el inventario del contexto y también está limitada por defecto a 200 líneas de inventario.</p>

                <h5>1.3.7. Correspondencias</h5>
                    <p>Esta pestaña, relacionada con los nombres publicados de los tipos cuando difieren de los utilizados en CeVICA, se describirá más adelante (se trata de una función que actualmente no se utiliza).</p>
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Grupos de pastas</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Lista de los grupos de pastas</h4>
                <p>La lista de los grupos de pastas es accesible desde la barra superior.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_40.png" width="80%"></div>
                <p>Por el momento, la lista no está ordenada. Si algunos grupos de pastas tienen subgrupos, estos no aparecen aquí.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Los grupos de pastas y su material asociado</h4>
                <p>Al seleccionar un grupo de pastas (desde la lista de grupos o desde un inventario), se puede acceder a diversas informaciones y a varias pestañas.</p>
                <p><b>Importante:</b> Cuando un grupo de pastas tiene varios subgrupos, la información que aparece corresponde únicamente al grupo genérico y no a los subgrupos.</p>

                <h5>2.2.1. Información general</h5>
                    <p>Aquí se encuentra:</p>
                    <ul>
                        <li>En su caso, el grupo principal del subgrupo;</li>
                        <li>La persona que ha añadido el grupo de pastas a CeVICA;</li>
                        <li>El número de objetos registrados (líneas de inventario) correspondientes a este grupo de pastas.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_42.png" width="70%"></div>

                <h5>2.2.2. Distribución</h5>
                    <p>La distribución se presenta mediante un mapa interactivo o mediante la lista de las operaciones arqueológicas que contienen este grupo de pastas.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_43.png" width="80%"></div>
                    <p>Al igual que para la lista de las operaciones arqueológicas, al hacer clic en un marcador es posible ver las operaciones arqueológicas, así como el número de líneas de inventario identificadas como pertenecientes a este grupo de pastas.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_44.png" width="80%"></div>
                    <p>La lista de las operaciones arqueológicas funciona en forma de tabla, con los mismos datos. Es posible acceder a la operación arqueológica o al inventario cruzado de la operación arqueológica y del grupo de pastas (haciendo clic en «ver»).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_45.png" width="80%"></div>
                    <p>La tabla también puede ordenarse y filtrarse.</p>

                <h5>2.2.3. Descripción</h5>
                    <p>La descripción incluye:</p>
                    <ul>
                        <li>Una descripción del grupo de pastas, cuya extensión y estructura pueden variar;</li>
                        <li>En su caso, los diferentes subgrupos presentes;</li>
                        <li>Un origen (también en forma de texto libre);</li>
                        <li>La bibliografía;</li>
                        <li>La información necesaria para citar correctamente la página.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_46.png" width="80%"></div>

                <h5>2.2.4. Ilustraciones</h5>
                    <p>Esta pestaña contiene todas las ilustraciones de los objetos de este grupo de pastas. Es posible ordenarlas según el tipo de ilustración.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_47.png" width="80%"></div>
                    <p>Es posible mostrar estas ilustraciones en mayor tamaño haciendo clic sobre ellas. Una vez mostrada la ilustración, se puede volver a la visualización inicial haciendo clic fuera de ella o en la cruz situada en la esquina superior derecha.</p>

                <h5>2.2.5. Tipos</h5>
                    <p>Esta pestaña muestra los tipos registrados para este grupo de pastas. Es posible consultar este tipo o el inventario de los objetos correspondientes al tipo y al grupo de pastas seleccionado.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_48.png" width="80%"></div>

                <h5>2.2.6. Inventario</h5>
                    <p>Esta última pestaña muestra el inventario completo del grupo de pastas. Funciona de la misma manera que el inventario del contexto, incluyendo además los códigos de los sitios, horizontes-sitios y contextos. Es posible hacer clic en estos códigos para acceder a su ficha, o simplemente pasar el ratón por encima para ver su nombre.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_49.png" width="80%"></div>
                    <p>La tabla puede ordenarse y filtrarse de la misma manera que el inventario del contexto y también está limitada por defecto a 200 líneas de inventario.</p>

                <h5>2.2.7. Correspondencias</h5>
                    <p>Esta pestaña, relacionada con los nombres publicados de los grupos de pastas cuando difieren de los utilizados en CeVICA, se describirá más adelante (se trata de una función que actualmente no se utiliza).</p>
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>V. Bibliografía</h2>
        <p>Como se ha indicado anteriormente, es posible indicar referencias bibliográficas para una serie de elementos: operación arqueológica, horizonte-sitio, contexto, horizonte regional, tipología, tipo o grupo de pastas. Esta funcionalidad es bastante básica, pero las referencias pueden consultarse en CeVICA.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Lista de referencias bibliográficas</h3>
            <p>La lista de referencias bibliográficas es accesible desde la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>Está ordenada alfabéticamente según las abreviaturas.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Consultar una referencia</h3>
            <p>Puede consultar una referencia haciendo clic sobre ella en el lugar donde aparece. De este modo, podrá ver la referencia completa, así como los elementos de la base de datos que están vinculados a ella.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>En algunos casos, se ha indicado una numeración de página. Esta está disponible tanto en la página del elemento como en la de la referencia.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>VI. Otros elementos</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Lista de archivos descargables</h3>
            <p>Se puede acceder a una lista de archivos descargables desde la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>En ella se pueden descargar archivos que no están vinculados a un elemento concreto (operación arqueológica, horizonte-sitio, contexto, horizonte regional, etc.), sino que tienen un carácter general y se han considerado útiles para compartir. La descarga se realiza simplemente haciendo clic sobre ellos.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citar una página</h3>
            <p>En cada página que describe un elemento de la base de datos se propone un modelo de cita para hacer referencia a dicho elemento en la bibliografía. En otras partes de este tutorial se indican numerosos ejemplos.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Información sobre el sitio web</h3>
            <p>Esta información está disponible principalmente a través de «Soporte e información» en la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Estas pestañas incluyen:</p>
            <ul>
                <li>Una presentación más detallada de CeVICA en «Presentación y contactos»;</li>
                <li>Un formulario de contacto para el administrador en esta misma pestaña;</li>
                <li>La lista de tutoriales disponibles en «Ayuda para el uso de CeVICA»;</li>
                <li>La infraestructura en la que se integra CeVICA, en «Herramientas asociadas»: desarrollos complementarios (como ONICer y DBCer, la herramienta LOGACer que utiliza CeVICA), así como herramientas recomendadas para utilizar conjuntamente con las desarrolladas por las Universidades de Lieja y Lille.</li>
            </ul>
            <p>También se puede acceder a otras páginas desde la parte inferior de cada página:</p>
            <ul>
                <li>Los avisos legales y la política de gestión de datos, necesarios para cualquier sitio web;</li>
                <li>Al hacer clic en el logotipo de LOGACer, una descripción del software.</li>
            </ul>
        </section>

        <section id="recherche-simple" class="mb-5">
        <h3>4. Realizar búsquedas</h3>
            <p>Por el momento, la herramienta de búsqueda es bastante sencilla y consiste en una simple barra de búsqueda a la que se puede acceder haciendo clic en la lupa, situada a la derecha de la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_58.png" width="80%"></div>
            <p>A continuación, puede introducir elementos descriptivos de un tipo de elemento y seleccionar este último entre los que ya se proponen.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_59.png" width="60%"></div>
            <p>Finalmente, se muestra una lista o una tabla con los elementos correspondientes.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_60.png" width="80%"></div>
        </section>

        <section id="enregistrement-connexion" class="mb-5">
        <h3>5. Registrarse e iniciar sesión</h3>
            <p>La creación de una cuenta y el inicio de sesión se describirán más adelante, cuando las herramientas de colaboración estén plenamente operativas.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
