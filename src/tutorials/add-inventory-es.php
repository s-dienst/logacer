
  <!-- Barre latérale -->
  <nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Volver: Lista de tutoriales</a></h6><br>
    <h4 class="px-3">Integración del inventario</h4>
    <a href="#introduction">Introducción</a>
    <h5 class="px-3">I. Desde el espacio personal</h5>
    <a href="#bugs-connus">Errores conocidos</a>
    <a href="#telecharger-completer-templates">Descargar y completar las plantillas</a>
    <ul>
      <li><a href="#telecharger-template">Descargar las plantillas</a></li>
      <li><a href="#contenu-templates">Contenido de las plantillas</a></li>
      <li><a href="#ouvrir-templates">Abrir las plantillas</a></li>
      <li><a href="#completer-enregistrer">Completar y guardar</a></li>
    </ul>
    <a href="#integrer">Integrar las plantillas</a>
    <ul>
      <li><a href="#ajouter-template">Añadir las plantillas</a></li>
      <li><a href="#ecran-ajout">Pantalla de adición</a></li>
      <li><a href="#corrections">Correcciones</a></li>
      <li><a href="#validation">Validación o cancelación</a></li>
    </ul>
    <a href="#longues-integrations">Gestionar las integraciones largas</a>
    <ul>
      <li><a href="#pause-integration">Detener temporalmente</a></li>
      <li><a href="#reprendre-upload">Reanudar la carga</a></li>
    </ul>
    <h5 class="px-3">II. Dentro de las páginas</h5>
    <h5 class="px-3">III. Integración manual</h5>
  </nav>

  <!-- Contenido principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: añadir operaciones arqueológicas, horizontes-sitio, contextos e inventario</h1>
    <section id="introduction" class="mb-5">
      <p>La adición (y modificación) de sitios, fases, contextos e inventario puede realizarse, en <?php echo WEBSITE_NAME; ?>, de varias maneras:</p>
      
      <ul>
        <li>Mediante la adición global de datos desde el espacio personal;</li>
        <li>Mediante la adición de datos específicos de un proyecto, una operación arqueológica o un contexto desde las páginas correspondientes;</li>
        <li>Mediante la adición, modificación y eliminación manual de datos desde las páginas de visualización de dichos datos.</li>
      </ul>

      <p>Estas diferentes formas de proceder se explican a continuación.</p>
    </section>

    <h2>I. Integrar los datos desde el espacio personal</h2>

      <section id="bugs-connus" class="mb-5">
        <h4>Errores conocidos</h4>
        
        <p>Ya se han identificado una serie de errores y se está trabajando para resolverlos. Sin embargo, la implementación de estas funcionalidades requiere mucho tiempo, al igual que la resolución de algunos errores. No dude en informar al administrador si detecta otros errores.</p>
        <p>En general, la indicación de un error mediante un color puede permanecer incluso después de haberlo corregido. Se recomienda hacer clic una segunda vez en la celda y, a continuación, pulsar "Enter" para comprobar si es correcto o no.</p>
        <p>En cuanto a la adición de sitios:</p>
        <ul>
          <li>Cuando se indica una región en el archivo importado pero esta no existe, simplemente se elimina de la tabla.</li>
        </ul>
        <p>En cuanto a la adición de fases y contextos:</p>
        <ul>
          <li>Aunque se indique un error, cuando la primera indicación de una nueva fase es incorrecta pero una indicación posterior es correcta, la fase se añade a partir de ese momento y los contextos se añaden a dicha fase. Una fase incorrecta no impide la importación del contexto</li>
          <li>Cuando la codificación del horizonte regional es incorrecta, simplemente se elimina, sin indicar un error.</li>
        </ul>
        <p>En cuanto a la adición de inventario:</p>
        <ul>
          <li>La versión corta debe probarse con más detalle, especialmente debido a los numerosos cambios realizados. Es probable que no funcione correctamente.</li>
          <li>La versión larga todavía no está implementada, ya que requiere cambios en el funcionamiento actual de <?php echo WEBSITE_NAME; ?>.</li>
        </ul>
      </section>


<section id="telecharger-completer-templates" class="mb-5">
      <h3>1. Descargar y completar las plantillas</h3>
      <section id="telecharger-template" class="mb-5">
        <h4>1.1. Descargar las plantillas</h4>
        
        <p>Las diferentes plantillas se pueden descargar en el espacio personal, en la pestaña «plantillas». Por el momento, existen plantillas para la incorporación de:</p>
        <ul>
          <li>operaciones arqueológicas;</li>
          <li>contextos (así como sus posibles horizontes-sitio);</li>
          <li>inventarios.</li>
        </ul>

        <p>Debe seleccionar la plantilla que le interese de la lista proporcionada y, a continuación, hacer clic en «descargar».</p>
      </section>

      <section id="contenu-templates" class="mb-5">
        <h4>1.2. Contenido de las plantillas</h4>

        <p>Estas plantillas están disponibles en una versión corta y una versión larga.</p>

        <h5>Sitios – versión corta</h5>
        <ul>
          <li><b>ID del proyecto (opcional):</b> Identificador del proyecto al que debe vincularse su operación, si desea asociarla a un proyecto. El identificador es el indicador numérico visible en la URL al abrir su proyecto: «…/project/1», donde «1» es el identificador.</li>
          <li><b>Responsable de la operación (opcional):</b> Identificador en <?php echo WEBSITE_NAME; ?> (que no debe confundirse con el nombre y apellido) del responsable que debe indicarse para la operación. Si se trata de usted, puede dejarlo vacío. Si se trata de otra persona, esta debe estar registrada en <?php echo WEBSITE_NAME; ?>; en ese caso, usted será añadido automáticamente como colaborador.</li>
          <li><b>Código de operación arqueológica (obligatorio):</b> Código que permite identificar fácilmente la operación. El código debe ser único para el responsable de la operación y es obligatorio. Está limitado a 32 caracteres.</li>
          <li><b>Nombre de la operación arqueológica (obligatorio):</b> Nombre completo de la operación arqueológica. El nombre está limitado a 255 caracteres. No debe existir ninguna otra operación arqueológica con el mismo nombre en <?php echo WEBSITE_NAME; ?>.</li>
        </ul>

        <h5>Sitios – versión larga</h5>
        <p>Campos adicionales (todos opcionales):</p>
        <ul>
          <li><b>Coord. lat.:</b> Coordenadas del sitio en latitud (en formato decimal utilizando un punto, entre -90 y 90; los números positivos corresponden a la latitud norte y los números negativos a la latitud sur).</li>
          <li><b>Coord. long.:</b> Coordenadas del sitio en longitud (en formato decimal utilizando un punto, entre -180 y 180; los números positivos corresponden a la longitud este y los números negativos a la longitud oeste).</li>
          <li><b>Código regional:</b> Código regional. Los códigos ya integrados <a href="<?php echo create_url(['geography']); ?>" target='_blank'>están disponibles aquí</a>. Si desea añadir otra región, debe ponerse en contacto con el administrador de <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Público (sí/no):</b> Indicación de si desea que la operación arqueológica sea consultable por todo el mundo, o únicamente por los responsables y colaboradores del proyecto y/o de la operación. Por defecto, la operación arqueológica no es pública. También puede hacerla pública y ocultar manualmente determinados horizontes-sitio y contextos (excepto mediante la incorporación por tabla).</li>
          <li><b>Inédito (sí/no):</b> Indicación del carácter inédito o no de los datos incorporados a <?php echo WEBSITE_NAME; ?>. Si no lo son, deberá añadir la bibliografía manualmente después de la incorporación mediante archivo CSV. Por defecto, la operación arqueológica no se considera inédita. También puede indicarla como ya publicada, pero señalar manualmente determinados horizontes-sitio y contextos como inéditos (excepto mediante la incorporación por tabla).</li>
          <li><b>Revisión bibliográfica (sí/no):</b> Si esta operación arqueológica no ha sido publicada por usted, sino que la ha recuperado (con o sin modificaciones), debería indicar que se trata de datos extraídos (y probablemente revisados) de una publicación. Puede configurar este parámetro de forma más precisa para los horizontes-sitio y contextos (excepto mediante la incorporación por tabla).</li>
          <li><b>Descripción:</b> Puede añadir una descripción del sitio (texto libre).</li>
        </ul>

        <h5>Contextos – versión corta</h5>
        <p>Es obligatorio indicar bien el responsable y el código de la operación arqueológica (combinación única), bien el nombre (único) de la operación arqueológica.</p>
        <ul>
          <li><b>Responsable de la operación:</b> Identificador en <?php echo WEBSITE_NAME; ?> (que no debe confundirse con el nombre y apellido) del responsable de la operación arqueológica a la que desea añadir el contexto.</li>
          <li><b>Operación arqueológica (código):</b> Código de la operación arqueológica a la que desea añadir el contexto.</li>
          <li><b>Operación arqueológica (nombre) (obligatorio):</b> Nombre de la operación arqueológica a la que desea añadir el contexto.</li>
          <li><b>Código del horizonte-sitio (opcional):</b> Si desea añadir el contexto a un horizonte-sitio, indique aquí su código, que permite identificarlo fácilmente. Puede tratarse de un nuevo horizonte-sitio (código indicado como inexistente para esta operación arqueológica), de un horizonte-sitio existente o de un horizonte-sitio añadido para un contexto importado anteriormente en el archivo CSV. El código está limitado a 32 caracteres.</li>
          <li><b>Nombre del horizonte-sitio (opcional salvo si es nuevo):</b> Si se trata de un horizonte-sitio introducido para este contexto, debe indicar su nombre. En caso contrario, este campo será ignorado. El nombre está limitado a 255 caracteres.</li>
          <li><b>Código del contexto (obligatorio):</b> Código que permite identificar fácilmente el contexto. El código debe ser único para la operación arqueológica (por ejemplo, US). Está limitado a 32 caracteres.</li>
          <li><b>Nombre del contexto (obligatorio):</b> Nombre completo del contexto (puede ser equivalente al código). El nombre está limitado a 255 caracteres.</li>
        </ul>

        <h5>Contextos – versión larga</h5>
        <p>Campos adicionales (todos opcionales):</p>
        <ul>
          <li><b>Código del grupo de horizontes regionales (obligatorio si se completa el campo siguiente):</b> Si se introduce un nuevo horizonte-sitio, es posible vincularlo a un horizonte regional. Antes de indicar el código de este último, es necesario indicar el código del grupo de horizontes al que pertenece (por ejemplo, ROME para los horizontes de la región romana). El horizonte regional ya debe existir. Este campo y los dos siguientes no se tienen en cuenta si el horizonte-sitio ya existe o ha sido introducido anteriormente.</li>
          <li><b>Código del horizonte regional:</b> Si el nuevo horizonte-sitio está vinculado a un horizonte regional, su código debe indicarse en esta columna. El horizonte regional ya debe existir.</li>
          <li><b>Tipo de vínculo (mayor = 1, menor = 2, incierto = 3):</b> Indica la importancia del horizonte-sitio en la definición de su horizonte regional. Debe ser un número entero entre 1 y 3. Puede dejarse vacío si se desconoce la importancia.</li>
          <li><b>Descripción del horizonte-sitio:</b> Puede añadir una descripción del nuevo horizonte-sitio (texto libre).</li>
          <li><b>Descripción del contexto:</b> Puede añadir una descripción del contexto (texto libre).</li>
        </ul>

        <h5>Inventario – versión corta</h5>
        <p>Por el momento, esta es la única posibilidad de incorporación plenamente funcional. Es obligatorio indicar bien el responsable y el código de la operación arqueológica (combinación única), bien el nombre (único) de la operación arqueológica.</p>
        <ul>
          <li><b> Responsable de la operación:</b> Identificador en <?php echo WEBSITE_NAME; ?> (que no debe confundirse con el nombre y apellido) del responsable de la operación arqueológica a la que pertenece el contexto al que desea añadir una línea de inventario.</li>
          <li><b>Operación arqueológica (código):</b> Código de la operación arqueológica a la que pertenece el contexto al que desea añadir una línea de inventario.</li>
          <li><b>Operación arqueológica (nombre):</b> Nombre de la operación arqueológica a la que pertenece el contexto al que desea añadir una línea de inventario.</li>
          <li><b>Contexto (código) (obligatorio):</b> Código del contexto al que desea añadir la línea de inventario.</li>
          <li><b>Número de inventario (obligatorio):</b> Número de inventario del objeto que desea añadir, único dentro del contexto. El número de inventario está limitado a 128 caracteres.</li>

          <li><b>Categoría (obligatorio):</b> Abreviatura de la categoría a la que pertenece el objeto (máximo 16 caracteres). No es necesario que la categoría haya sido añadida previamente a <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Función (obligatorio):</b> Nombre de la función a la que pertenece el objeto (máximo 128 caracteres). No es necesario que la función haya sido añadida previamente a <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Tipo (obligatorio):</b> Nombre del tipo al que pertenece el objeto (máximo 128 caracteres). No es necesario que el tipo haya sido añadido previamente a <?php echo WEBSITE_NAME; ?>. </li>
          <li><b>var. (opcional):</b> Si se trata de una variante del tipo, indíquelo aquí (preferiblemente mediante la indicación «var.», máximo 8 caracteres).</li>
          <li><b>duda (opcional):</b> Si existe alguna duda sobre la identificación del tipo, indíquelo aquí (preferiblemente mediante el signo de puntuación «?», máximo 16 caracteres).</li>
          <li><b>Pasta (opcional):</b> Código del grupo de pastas al que pertenece el objeto (máximo 64 caracteres). No es necesario que el grupo de pastas haya sido añadido previamente a <?php echo WEBSITE_NAME; ?>.</li>

          <li><b>Diám. (opcional):</b> Indicaciones sobre el diámetro del objeto (máximo 16 caracteres).</li>
          <li><b>Estampillas (opcional):</b> Si existen estampillas para el objeto, indíquelo de forma independiente del tipo para facilitar las búsquedas sobre este último (máximo 255 caracteres).</li>
          <li><b>Comentario (opcional):</b> Comentario o descripción libre (máximo 255 caracteres).</li>
          <li><b>Bordes (opcional):</b> Número de bordes (número entero >= 0).</li>
          <li><b>Fondos (opcional):</b> Número de fondos (número entero >= 0).</li>
          <li><b>Asas (opcional):</b> Número de asas (número entero >= 0).</li>
          <li><b>Paredes (opcional):</b> Número de paredes (número entero >= 0).</li>
          <li><b>NMI (opcional):</b> Número mínimo de individuos (estricto, basado únicamente en el borde) (número entero >= 0).</li>
          <li><b>NR (opcional):</b> Número de restos (o fragmentos) (número entero >= 0).</li>
        </ul>


        <h5>Inventario – versión larga</h5>
        <p>La versión larga es útil en el caso de revisiones bibliográficas (o de la puesta en línea de contextos estudiados hace cierto tiempo), ya que permite modificar en la base de datos las categorías, funciones, tipos y grupos de pasta, al tiempo que se mantiene disponible la información publicada originalmente. <div style="color:#ff0000">Por el momento, no es posible incorporar los inventarios en esta forma.</div> Los campos en cuestión se sustituyen por:</p>
        <ul>
          <li><b>Categoría (adaptada) (obligatorio):</b> Equivalente de la Categoría en la plantilla corta.</li>
          <li><b>Categoría (bibliográfica) (opcional):</b> Categoría mencionada en la bibliografía (funcionalidad pendiente de añadir).</li>
          <li><b>Función (adaptada) (obligatorio):</b> Equivalente de la Función en la plantilla corta.</li>
          <li><b>Función (bibliográfica) (opcional):</b> Función mencionada en la bibliografía (funcionalidad pendiente de añadir).</li>
          <li><b>Tipo (adaptado) (obligatorio):</b> Equivalente del Tipo en la plantilla corta.</li>
          <li><b>Tipo (bibliográfico) (opcional):</b> Tipo mencionado en la bibliografía (funcionalidad pendiente de añadir).</li>
          <li><b>Pasta (adaptada) (opcional):</b> Equivalente del Grupo de pastas en la plantilla corta.</li>
          <li><b>Pasta (bibliográfica) (opcional):</b> Grupo de pastas mencionado en la bibliografía (funcionalidad pendiente de añadir).</li>
        </ul>
      </section>

      <section id="ouvrir-templates" class="mb-5">
        <h4>1.3. Abrir las plantillas</h4>
        
        <p>Las plantillas están configuradas para utilizar puntos y comas como separadores, que es la configuración predeterminada de MS Excel en su versión en francés. No obstante, es posible que la plantilla no se muestre correctamente en su equipo; en ese caso, no dude en ponerse en contacto con el administrador del sitio para encontrar una solución.</p>
      </section>

      <section id="completer-enregistrer" class="mb-5">
        <h4>1.4. Completar y guardar las plantillas</h4>
        <h5>Completar la plantilla</h5>
        <p>Una vez abierta, puede completar la plantilla. Procure no eliminar ningún campo de la plantilla y no modificar el orden de las columnas. <?php echo WEBSITE_NAME; ?> gestiona normalmente la adición de nuevos campos (que serán ignorados), la eliminación de campos obligatorios y la modificación del orden, pero aun así podrían producirse errores.</p>
        <p>Deje completamente vacíos los campos no utilizados y no obligatorios. Tenga en cuenta que las modificaciones de estilo (negrita, cursiva, subrayado, fuentes, etc.) no se conservan en un archivo CSV. Las versalitas se transforman en mayúsculas.</p>
        <p><b>El tamaño máximo de las plantillas es actualmente de aproximadamente 200 MB, pero se limitará a 2 MB (para facilitar su gestión), es decir, aproximadamente 50.000 líneas de inventario. No supere esta cantidad.</b></p>

        <h5>Guardar la plantilla</h5>
        <p>La plantilla debe guardarse siempre en formato CSV, utilizando el punto y coma como separador. En MS Excel configurado para usuarios francófonos, este debería ser el caso.</p>
        <p>No obstante, puede comprobarlo abriendo el archivo CSV en un editor de texto (TextEdit en Mac) y comprobando si se utilizan puntos y comas u otro separador (generalmente, una coma) para separar los campos. Si se utilizan comas y está seguro de que no ha utilizado ninguna coma al completar la plantilla, puede utilizar la función de buscar y reemplazar para sustituir las comas por puntos y comas.</p>
      </section>
    </section>

    <section id="integrer" class="mb-5">
      <h3>2. Integrar las plantillas</h3>
      <section id="ajouter-template" class="mb-5">
        <h4>2.1. Añadir las plantillas y acceder a la pantalla de importación de datos</h4>
        <p>Para añadir la plantilla, vuelva al Espacio personal. En «Importar datos», deberá:</p>
        <ul>
          <li>Seleccionar una opción de la lista para elegir el tipo de plantilla que va a añadir (no importa si se trata de la plantilla larga o corta);</li>
          <li>Añadir el archivo completado;</li>
          <li>Indicar si desea mostrar o no los datos importados sin errores. Por «sin errores» se entiende que los datos pueden integrarse tal como han sido introducidos, sin ninguna modificación por parte del usuario. Tenga en cuenta que la ausencia de correspondencia en las categorías, funciones, tipos y grupos de pastas no se considera un error. Si desea realizar estas comprobaciones, le recomendamos que no marque esta casilla. Esta elección no puede modificarse posteriormente. Si no está seguro de su elección, siempre puede realizar una prueba, abandonar posteriormente la integración de los datos y cambiar su elección (véase más adelante).</li>
        </ul>
      </section>
      <section id="ecran-ajout" class="mb-5">
        <h4>2.2. Pantalla de importación de datos</h4>
        <p>A continuación, accederá a una pantalla que permite validar la incorporación de los datos. Esta pantalla consta de dos partes: un resumen de la integración y la tabla de los datos importados.</p>

        <h5>Datos de integración</h5>
        <p>Se trata de un resumen de los datos añadidos:</p>
        <ul>
          <li><b>Filas:</b> Las filas que se están procesando actualmente dentro del CSV (para respetar la numeración utilizada en Excel, la fila de encabezado se considera la fila 1).</li>
          <li><b>Total de filas:</b> Número de filas que contiene el archivo cargado (incluida la fila de encabezado).</li>
          <li><b>Filas restantes:</b> Número de filas que aún no han sido procesadas.</li>
          <li><b>Filas mostradas:</b> Número de filas mostradas en esta tabla.</li>
        </ul>

        <h5>Tabla de datos</h5>
        <p>Debajo de estos datos se muestra la tabla, ya sea con todos los datos importados o únicamente con los datos erróneos, según la opción seleccionada para la importación. <?php echo WEBSITE_NAME; ?> está configurado para mostrar un máximo de 200 filas. Si no se ha marcado la opción «Mostrar también los datos importados sin errores», <?php echo WEBSITE_NAME; ?> procesará un máximo de 1.000 filas cada vez, independientemente de que haya errores o no (y mostrará un máximo de 200 filas erróneas).</p>
        <p>Los datos correctamente completados se muestran en negro. Los demás datos se muestran en diferentes colores según su gravedad.</p>

        <h5>Errores que impiden la importación de los datos</h5>
        <p>Estos errores se indican en rojo oscuro. En algunos casos, la importación puede realizarse, pero hemos preferido considerarlos como errores bloqueantes, ya que es probable que el usuario quiera corregirlos. En general:</p>
        <ul>
          <li><b>Formato no válido:</b> Cuando faltan datos obligatorios, estos no tienen el formato correcto (por ejemplo, letras en lugar de números) o se supera el número máximo de caracteres.</li>
        </ul>
        <p>Para la importación de operaciones arqueológicas:</p>
        <ul>
          <li><b>Proyecto:</b> Ningún proyecto corresponde a este identificador, o el usuario no está incluido en el proyecto correspondiente.</li>
          <li><b>Responsable de la operación:</b> El nombre de usuario no existe. El código de la operación no puede verificarse y también se considera incorrecto.</li>
          <li><b>Código:</b> El código falta, es demasiado largo o ya existe para este responsable.</li>
          <li><b>Nombre:</b> El nombre falta, es demasiado largo o ya existe en <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Región:</b> El código de la región indicada todavía no existe en <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Coordenadas:</b> La latitud y/o la longitud no se indican como números o contienen valores imposibles (entre -90 y 90 para la latitud, y entre -180 y 180 para la longitud).</li>
        </ul>
        <p>Para la importación de horizontes-sitio y contextos:</p>
        <ul>
          <li><b>Sitio:</b> Ningún sitio corresponde a este código, o el usuario no es ni responsable ni colaborador de este sitio (el código del contexto también se considera incorrecto, ya que no puede verificarse).</li>
          <li><b>Código del horizonte-sitio:</b> Este código ya está asignado a este sitio (en el caso de que, para esta fila, se indique un nombre diferente del horizonte-sitio existente o del horizonte-sitio mencionado anteriormente con este mismo código - <b>Regla por confirmar</b>).</li>
          <li><b>Tipo de vínculo:</b> El tipo de vínculo con el horizonte regional debe estar vacío o ser un número entre 0 y 3 (mayor = 1, menor = 2, incierto = 3, desconocido = 0) - <b>Todavía debe precisarse si se trata de un problema bloqueante o no</b>.</li>
          <li><b>Código del contexto:</b> El código ya existe para este sitio.</li>
        </ul>
        <p>Para la importación del inventario:</p>
        <ul>
          <li><b>Sitio:</b> Ningún sitio corresponde a este código, o el usuario no es ni responsable ni colaborador de este sitio (el código del contexto y el número de inventario también se consideran incorrectos, ya que no pueden verificarse).</li>
          <li><b>Contexto:</b> El código indicado para el contexto no existe para este sitio (el número de inventario también se considera incorrecto, ya que no puede verificarse).</li>
          <li><b>Número de inventario:</b> El número debe ser único dentro del contexto (incluidos los datos que se están añadiendo).</li>
          <li><b>Bordes, fondos, asas, paredes, NMI, NR:</b> Si estas columnas están completadas, deben contener números enteros positivos (o 0).</li>
        </ul>

        <h5>Errores que no impiden la importación de los datos</h5>
        <p>Estos errores aparecen (normalmente) en gris. En el caso de la importación del inventario, no se trata realmente de errores, sino más bien de la adición de datos que no están vinculados a nivel del sistema de referencia.</p>
        <p>Para la importación de operaciones arqueológicas:</p>
        <ul>
          <li><b> Público, Inédito, Revisión bibliográfica:</b> Cuando el formato no es correcto (respuesta distinta de «sí» o «no», o una celda vacía). Se aplicarán los valores predeterminados.</li>
        </ul>
        <p>Para la importación de horizontes-sitio y contextos:</p>
        <ul>
          <li><b>Grupo de horizontes (código):</b> Ningún grupo de horizontes corresponde a este código, o el usuario no es ni responsable ni colaborador de este grupo (el código del horizonte también se considera incorrecto, ya que no puede verificarse).</li>
          <li><b>Horizonte (código):</b> El código indicado para el horizonte regional no existe para este grupo de horizontes.</li>
          <li><b>Tipo de vínculo:</b> Si se indica el tipo, debe tratarse de un número entero entre 1 y 3.</li>
        </ul>
        <p>Para la importación del inventario:</p>
        <ul>
          <li><b>Categoría, Función, Tipo y Grupo de pastas:</b> Cuando no existe ningún elemento en el sistema de referencia de <?php echo WEBSITE_NAME; ?> (por el momento, no conectado a ONICer) que pueda vincularse.</li>
        </ul>
      </section>

      <section id="corrections" class="mb-5">
        <h4>2.3. Correcciones durante la integración</h4>
        <p>Tanto en caso de error como para cualquier otro tipo de corrección, puede cambiar el valor mostrado simplemente haciendo clic en la celda que desea modificar y corrigiendo el valor. Cuando haga clic en otro lugar, el valor aparecerá en negro si es válido o con el color correspondiente al tipo de error.</p>
      </section>

      <section id="validation" class="mb-5">
        <h4>2.4. Validar o cancelar la integración</h4>
        <p>Una vez que haya comprobado y aplicado todas las modificaciones que quería realizar, puede validar la integración. Hay dos posibilidades:</p>
        <ul>
          <li><b>Importar las filas válidas y cargar la siguiente parte:</b> Cuando todavía quedan datos que no se han revisado, se integran los datos válidos y se muestran los datos siguientes.</li>
          <li><b>Importar las filas válidas y finalizar la carga:</b> Cuando quedan pocos datos por importar o se ha llegado al final de los datos que deben importarse, se integran los datos válidos y, a continuación, se le redirige a su espacio personal.</li>
        </ul>
        <p>Los datos no válidos no se añadirán (<b style="color:#ff0000">ACLARAR</b>).</p>
        <p>También puede cancelar la carga. Los datos que ya hayan sido importados (durante visualizaciones anteriores) no se eliminarán, pero los datos mostrados y todos los que aún estén pendientes de procesamiento no se integrarán en <?php echo WEBSITE_NAME; ?>. No podrá deshacer esta acción. Es una opción útil si detecta muchos problemas en su archivo y desea modificarlo, o si quiere cambiar la opción de mostrar o no los datos erróneos. Si simplemente quiere detener la integración por el momento, es más adecuado ponerla en pausa (véase más abajo).</p>
      </section>
    </section>

    <section id="longues-integrations" class="mb-5">
      <h3>3. Gestionar integraciones largas</h3>
      <section id="pause-integration" class="mb-5">
        <h4>3.1. Detener temporalmente la carga</h4>
        <p>Si necesita detenerse mientras añade datos, un botón «Detener temporalmente la carga» permite poner en pausa la integración de los datos. A menos que añada otros datos entretanto, posteriormente podrá reanudar la incorporación de los datos desde el punto en el que se encontraba. También puede simplemente salir de la pantalla.</p>
        <p>Esto no cambiará nada en las filas que ya hayan sido añadidas a la base de datos.</p>
      </section>

      <section id="reprendre-upload" class="mb-5">
        <h4>3.2. Reanudar la carga</h4>
        <p>Para reanudar una carga que se haya puesto en pausa de este modo, debe acceder a su espacio personal. En «Importar datos», un botón verde permite reanudar una carga pausada. Este botón no se muestra si no hay ninguna carga que haya sido puesta en pausa.</p> 
        <p>Por el momento, no está previsto poder poner en pausa y reiniciar varias cargas para un mismo usuario. Si inicia una nueva carga (de operaciones arqueológicas, contextos o inventario), se eliminará la carga que estaba en pausa.</p>
      </section>
    </section>

    <h2>II. Integrar los datos desde las páginas de proyectos, sitios y contextos</h2>
    <p>Esta posibilidad todavía no está integrada en <?php echo WEBSITE_NAME; ?>.</p>

    <h2>III. Integrar manualmente los datos</h2>
    <div style="color:#ff0000"><p>Sección en construcción.</p></div>
  </div>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
