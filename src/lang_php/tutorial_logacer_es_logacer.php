<?php $return_list = "<p><a href='" . create_url(['']) . "'>Retourner à la page d'accueil</a></p>";
$tuto_button = ""; ?>
    <!-- Barra lateral -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['']); ?>'>Volver a la página de inicio</a></h6><br>
        <h4 class="px-3">Principios y navegación</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principios básicos</h5></a>
        <a href="#navigation-generale"><h5 class="px-3">II. Navegación general</h5></a>
            <a href="#projets">1. Proyectos</a>
            <a href="#typologies-globales">2. Tipologías y grupos de pastas cerámicas</a>
            <a href="#espace-personnel">3. Espacio personal</a>
            <a href="#referentiels">4. Repertorios de referencia</a>
            <a href="#gestion-utilisateurs">5. Gestión de usuarios</a>
        <a href="#types-pâtes"><h5 class="px-3">III. Tipos y grupos de pastas cerámicas</h5></a>
            <a href="#typologies-types">1. Tipologías y tipos</a>
            <ul>
                <li><a href="#liste-typologies">Lista de tipologías</a></li>
                <li><a href="#typologie">Descripción de la tipología</a></li>
                <li><a href="#types">Descripción de los tipos</a></li>
            </ul>
            <a href="#pâtes">2. Grupos de pastas cerámicas</a>
            <ul>
                <li><a href="#liste-groupes-pâtes">Lista de grupos de pastas cerámicas</a></li>
                <li><a href="#groupes-pâtes">Descripción de los grupos de pastas cerámicas</a></li>
            </ul>
        <a href="#bibliographie"><h5 class="px-3">IV. Bibliografía</h5></a>
            <a href="#liste-bibliographie">1. Lista de referencias bibliográficas</a>
            <a href="#consulter-bibliographie">2. Consultar una referencia</a>
        <a href="#autres-éléments"><h5 class="px-3">V. Otros elementos</h5></a>
            <a href="#fichiers-génériques">1. Archivos generales</a>
            <a href="#citer-page">2. Citar una página</a>
            <a href="#a-propos">3. Información sobre el sitio web</a>
        <a href="#compte-utilisateur"><h5 class="px-3">VI. Cuentas de usuario</h5></a>
            <a href="#enregistrement-connexion">1. Registro e inicio de sesión</a>
            <a href="#gestion-compte">2. Gestión de la cuenta</a>
    </nav>

  <!-- Contenido principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: principios básicos y navegación por la herramienta sin iniciar sesión</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principios básicos</h2>

    <p>El objetivo principal de LOGACer es poner a disposición inventarios de objetos (especialmente cerámicos), permitiendo al mismo tiempo incorporar otra información y realizar consultas sobre dichos objetos. Para ello, LOGACer se basa en diferentes elementos:</p>
    <ul>
        <li>La contextualización del <b>objeto</b>: constituye el elemento central de LOGACer. El objeto forma parte de un <b>contexto</b> (o unidad estratigráfica), que a su vez está vinculado a otros contextos contemporáneos (el <b>horizonte de sitio</b>). Todos estos elementos fueron recuperados durante una <b>intervención arqueológica</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>La cronología relativa del objeto: los horizontes de sitio pueden agruparse en <b>horizontes regionales</b>. Estos se suceden dentro de una región geográfica; dicha sucesión se organiza mediante <b>grupos de horizontes</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>
        <li>La caracterización del objeto: según el modelo utilizado en LOGACer, la cerámica se clasifica en función de su <b>categoría</b>, su <b>función</b>, su <b>tipo</b> y su <b>pasta cerámica</b>. Los dos primeros criterios de clasificación están relativamente estandarizados y son limitados en número. Los tipos, en cambio, son mucho más numerosos y se agrupan en <b>tipologías</b>. Lo mismo ocurre con las pastas cerámicas, que también pueden organizarse jerárquicamente. La caracterización de los tipos y de las pastas cerámicas, así como la posibilidad de realizar búsquedas sobre ellos, también es importante. Las categorías, funciones, tipologías y tipos están ampliamente vinculados a ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>
        <li>Referencias: la caracterización de estos diferentes elementos puede completarse mediante referencias <b>bibliográficas</b> o añadiendo <b>archivos</b>. Además, estos elementos son gestionados por <b>usuarios</b> (que, en determinados casos, pueden actuar como responsables o colaboradores). Por último, los objetos pueden acompañarse de <b>ilustraciones</b>, como dibujos, fotografías o ampliaciones;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>
        <li>Colaboración: los equipos que trabajan con diferentes elementos (sitios, horizontes regionales, etc.) pueden reunirlos dentro de <b>proyectos</b>, lo que permite gestionar de forma más eficaz los permisos de acceso del equipo.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>
   </section>

    <section id="navigation-generale" class="mb-5">
    <h2>II. Navegación general</h2>
    <p>Además de los espacios específicos de cada proyecto, LOGACer dispone de un espacio general que permite consultar los proyectos disponibles, acceder a los repertorios de referencia comunes y gestionar los elementos relacionados con toda la instalación.</p>
    <p>La navegación se organiza en torno a dos barras:</p>
    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_1.png" width="80%"></div>-->
        <h3>1. Barra de navegación general</h3>
        <p>La barra superior da acceso a los principales recursos comunes a toda la instalación de LOGACer.</p>
            <h4>1.1. Proyectos</h4>
            <p>La sección «Proyectos» presenta una lista de los proyectos disponibles, acompañados de una breve descripción y de un enlace para acceder al espacio correspondiente a cada uno.</p>
            <p>Los proyectos públicos están disponibles para todos los visitantes, independientemente de que tengan o no una cuenta de usuario. Los proyectos privados no aparecen en esta lista, salvo para los usuarios que colaboran en ellos.</p>
            <h4>1.2. Tipologías y grupos de pastas cerámicas</h4>
            <p>Las secciones «Tipologías» y «Grupos de pastas cerámicas» permiten acceder a los repertorios generales de LOGACer, independientes de los distintos proyectos.</p>
            <p>Las páginas descriptivas de las tipologías y de los grupos de pastas cerámicas funcionan de manera similar a las disponibles dentro de los proyectos. Sin embargo, desde este espacio general no se puede acceder a la información relativa a los objetos arqueológicos. En particular, las páginas de los tipos y de los grupos de pastas cerámicas no muestran las distribuciones geográficas, las ilustraciones, los grupos de pastas cerámicas o tipos asociados, los inventarios ni las correspondencias disponibles en los proyectos.</p>
            <h4>1.3. Anexos</h4>
            <p>La sección «Anexos» da acceso a dos recursos comunes:</p>
            <ul>
                <li><b>Bibliografía:</b> lista de las referencias bibliográficas registradas en LOGACer. Su consulta se describe en la sección IV. Bibliografía;</li>
                <li><b>Archivos generales:</b> lista de los archivos disponibles independientemente de cualquier elemento concreto de la base de datos. Su consulta se describe en la sección V. Otros elementos.</li>
            </ul>
        <h3>2. Espacio personal</h3>
        <p>La segunda barra de navegación da acceso a las funcionalidades relacionadas con la cuenta del usuario y con sus propias contribuciones a LOGACer.</p>
            <h4>2.1. Mi espacio personal</h4>
            <p>Esta sección reúne diferentes informaciones y funcionalidades relacionadas con la cuenta del usuario. Las principales funcionalidades también están disponibles desde otras páginas de la aplicación.</p>
            <h4>2.2. Mis proyectos, mis tipos y mis grupos de pastas cerámicas</h4>
            <p>Estas secciones permiten encontrar los proyectos, tipos y grupos de pastas cerámicas en los que el usuario participa como creador, responsable o colaborador.</p>
            <p>De este modo, ofrecen un acceso directo a los elementos asociados al usuario, sin necesidad de recorrer las listas generales de LOGACer.</p>
            <h4>2.3. Repertorios de referencia</h4>
            <p>La sección «Repertorios de referencia» reúne las listas de referencia utilizadas en LOGACer:</p>
            <ul>
                <li><b>Países y regiones:</b> lista de países y de sus subdivisiones regionales, con sus códigos y denominaciones oficiales;</li>
                <li><b>Categorías:</b> lista de las categorías utilizadas para caracterizar los objetos. La tabla indica su código, abreviatura, nombre, su eventual presencia en ONICer y la persona que las creó en LOGACer;</li>
                <li><b>Funciones:</b> lista de las funciones utilizadas para caracterizar los objetos. La tabla indica su código, nombre, su eventual presencia en ONICer y la persona que las creó en LOGACer;</li>
                <li><b>Métodos de recuento:</b> lista de los métodos de recuento contemplados en LOGACer.</li>
            </ul>
            <p>Los colaboradores y los administradores pueden crear y gestionar los repertorios generales (a excepción de los métodos de recuento). Los usuarios estándar solo tienen acceso a las demás funcionalidades para las que disponen de autorización.</p>
            <h4>2.4. Gestión de usuarios</h4>
            <p>Esta sección está reservada a los administradores de LOGACer. Permite:</p>
            <ul>
                <li>Validar las nuevas solicitudes de registro;</li>
                <li>Consultar la lista de usuarios registrados;</li>
                <li>Modificar los permisos generales de los usuarios en LOGACer, asignándoles el estatus de administrador, colaborador o usuario estándar;</li>
                <li>Eliminar una cuenta de usuario cuando sea necesario.</li>
            </ul>
            <p>Estos permisos generales son distintos de los permisos asignados a los usuarios dentro de los diferentes proyectos.</p>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>III. Tipos y grupos de pastas cerámicas</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Tipologías y tipos</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Lista de tipologías</h4>
                <p>La lista está organizada según la categoría a la que pertenece cada tipología. Algunas tipologías están asociadas a varias categorías y aparecen, por tanto, en cada una de ellas. Las tipologías que no se han asociado a ninguna categoría (y que, por consiguiente, no pueden utilizarse para vincular objetos) se agrupan al final de la lista.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Descripción de la tipología</h4>
                <p>Al hacer clic en una tipología, se accede a su página descriptiva. Esta página contiene, en primer lugar, la siguiente información:</p>
                <ul>
                    <li>La persona que añadió la tipología a LOGACer y los colaboradores que pueden completar la información de la página;</li>
                    <li>Una descripción de la tipología, cuya extensión y estructura pueden variar;</li>
                    <li>Las referencias bibliográficas relacionadas con la tipología;</li>
                    <li>Los archivos asociados a la tipología;</li>
                    <li>La información necesaria para citar correctamente la página.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>La pestaña «Categorías» presenta una lista de las categorías para las que puede utilizarse la tipología (y, por tanto, sus tipos).</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>La pestaña «Tipos» presenta la lista de los tipos asociados a la tipología, ordenados alfabéticamente según sus códigos. Si algunos tipos tienen subtipos, estos no aparecen en esta sección.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Los tipos</h4>
                <p>Cuando se selecciona un tipo a través de una tipología, solo se puede acceder a la información general, a diferencia de lo que ocurre al navegar dentro de un proyecto:</p>
                    <ul>
                        <li>La tipología a la que pertenece el tipo (y, en su caso, el tipo principal del subtipo);</li>
                        <li>La persona que añadió la tipología a LOGACer y la que añadió el tipo;</li>
                        <li>Una descripción del tipo, cuya extensión y estructura pueden variar;</li>
                        <li>Si los hay, los diferentes subtipos existentes;</li>
                        <li>Una datación (también en forma de texto libre);</li>
                        <li>La bibliografía;</li>
                        <li>La información necesaria para citar correctamente la página.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_2.png" width="80%"></div>-->
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Grupos de pastas cerámicas</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Lista de grupos de pastas cerámicas</h4>
                <p>Por el momento, la lista no está organizada según ningún criterio. Si algunos grupos de pastas cerámicas tienen subgrupos, estos no aparecen en esta sección.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Los grupos de pastas cerámicas</h4>
                <p>Al seleccionar un grupo de pastas cerámicas (desde la lista de grupos o desde un inventario), se accede a diferentes informaciones generales:</p>
                    <ul>
                        <li>Si existe, el grupo principal al que pertenece el subgrupo;</li>
                        <li>La persona que añadió el grupo de pastas cerámicas a LOGACer;</li>
                        <li>Una descripción del grupo de pastas cerámicas, cuya extensión y estructura pueden variar;</li>
                        <li>Si los hay, los diferentes subgrupos existentes;</li>
                        <li>Un origen (también en forma de texto libre);</li>
                        <li>La bibliografía;</li>
                        <li>La información necesaria para citar correctamente la página.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_3.png" width="80%"></div>-->
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>IV. Bibliografía</h2>
        <p>Como se ha indicado en otras secciones, es posible asociar referencias bibliográficas a diferentes elementos: intervención arqueológica, horizonte de sitio, contexto, horizonte regional, tipología, tipo o grupo de pastas cerámicas. Esta funcionalidad es bastante sencilla, pero permite consultar las referencias en LOGACer.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Lista de referencias bibliográficas</h3>
            <p>La lista de referencias bibliográficas está disponible desde la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>Está organizada alfabéticamente según las abreviaturas.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Consultar una referencia</h3>
            <p>Se puede consultar una referencia haciendo clic sobre ella en el lugar donde aparece. De este modo, es posible visualizar la referencia completa y los elementos de la base de datos vinculados a ella.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>En algunos casos se ha indicado también la numeración de las páginas. Esta información está disponible tanto en la página del elemento correspondiente como en la página de la referencia bibliográfica.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>V. Otros elementos</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Lista de archivos descargables</h3>
            <p>Se puede acceder a una lista de archivos descargables desde la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Se trata de archivos que no están vinculados a ningún elemento concreto (intervención arqueológica, horizonte de sitio, contexto, horizonte regional, etc.), sino que tienen carácter general y se han considerado útiles para compartir. Para descargarlos, basta con hacer clic sobre ellos.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citar una página</h3>
            <p>En cada página que describe un elemento de la base de datos se propone un modelo de cita para hacer referencia a dicho elemento en la bibliografía. En otras secciones de este tutorial se incluyen numerosos ejemplos.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Información sobre el sitio web</h3>
            <p>Esta información está disponible principalmente a través de la sección «Soporte e información» de la barra superior.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Estas pestañas incluyen:</p>
            <ul>
                <li>Una presentación más detallada de LOGACer en la sección «Presentación y contactos»;</li>
                <li>Un formulario de contacto para el administrador en esa misma pestaña;</li>
                <li>Información sobre la infraestructura en la que se integra LOGACer, en la sección «Herramientas asociadas», especialmente sobre los desarrollos complementarios, como ONICer y DBCer.</li>
            </ul>
            <p>Otras páginas están disponibles en la parte inferior de cada página:</p>
            <ul>
                <li>Los avisos legales y la política de gestión de datos, necesarios para cualquier sitio web;</li>
            </ul>
        </section>

    <section id="compte-utilisateur" class="mb-5">
    <h2>VI. Cuentas de usuario</h2>
        <section id="enregistrement-connexion" class="mb-5">
        <h3>1. Registro e inicio de sesión</h3>
            <h4>1.1. Crear una cuenta</h4>
            <p>Para acceder a las funcionalidades reservadas a los usuarios registrados, es necesario disponer de una cuenta de LOGACer. Se puede iniciar sesión desde la barra de navegación general haciendo clic en «Iniciar sesión».</p>
            <p>Desde la página de inicio de sesión, los nuevos usuarios pueden acceder al formulario de registro haciendo clic en «¡Regístrese aquí!».</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_4.png" width="80%"></div>-->
            <p>El formulario de registro solicita la siguiente información:</p>
            <ul>
                <li>Un nombre de usuario;</li>
                <li>Una dirección de correo electrónico;</li>
                <li>Una contraseña, que debe confirmarse;</li>
                <li>Nombre y apellidos (opcionales).</li>
            </ul>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_5.png" width="80%"></div>-->
            <p>Una vez enviado el formulario, un administrador de LOGACer debe aprobar la cuenta antes de que pueda utilizarse. El usuario recibirá una notificación por correo electrónico cuando se haya aprobado. Se recomienda comprobar también la carpeta de correo no deseado. Si la aprobación tarda en llegar, puede ponerse en contacto con el administrador de la instalación.</p>
            <h4>1.2. Primer inicio de sesión</h4>
            <p>Una vez aprobada la cuenta, se envía un correo electrónico con la información necesaria para activarla.</p>
            <p>Para el primer inicio de sesión, debe utilizarse la clave de activación recibida por correo electrónico en lugar de la contraseña establecida durante el registro.</p>
            <p>Una vez realizado este primer inicio de sesión, el usuario podrá acceder a las funcionalidades de LOGACer correspondientes a sus permisos.</p>
            <p>Si se introduce una contraseña incorrecta varias veces, la cuenta quedará bloqueada. En ese caso, será necesario ponerse en contacto con el administrador para desbloquearla. Esto permitirá iniciar sesión con una nueva clave de activación y establecer una nueva contraseña.</p>
            </section>

        <section id="gestion-compte" class="mb-5">
        <h3>2. Gestión de la cuenta</h3>
        <p>Cuando un usuario ha iniciado sesión, su nombre aparece en la barra de navegación. Un menú desplegable permite, entre otras cosas, acceder a la gestión de la cuenta y cerrar la sesión.</p>
            <h4>2.1. Mi cuenta</h4>
            <p>La sección «Mi cuenta» permite consultar y modificar los datos personales:</p>
            <ul>
                <li>Nombre de usuario;</li>
                <li>Dirección de correo electrónico;</li>
                <li>Contraseña;</li>
                <li>Nombre y apellidos.</li>
            </ul>
            <p>Para cambiar la contraseña, es necesario introducir la nueva contraseña y confirmarla. Si no se indica ninguna contraseña nueva, se conserva la contraseña actual.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_6.png" width="80%"></div>-->
            <p>Esta página también permite personalizar algunos parámetros de visualización:</p>
            <ul>
                <li><b>Métodos de recuento:</b> selección de los métodos de recuento que se mostrarán en los inventarios, entre los utilizados en los datos consultados;</li>
                <li><b>Modo simplificado:</b> activación de una visualización que ofrece ayudas contextuales, especialmente en forma de mensajes emergentes, para facilitar la comprensión y el uso de LOGACer.</li>
            </ul>
            <p>Los cambios deben guardarse para que se apliquen.</p>
            <h4>2.2. Cerrar sesión</h4>
            <p>Para finalizar la sesión, basta con seleccionar «Cerrar sesión» en el menú desplegable asociado al nombre del usuario en la barra de navegación.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
