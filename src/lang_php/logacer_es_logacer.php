        <h2>LOGACer: una herramienta de código abierto para la gestión y el análisis del material arqueológico</h2>
        <br>
        <p>El <b>Logiciel Online pour la Gestion et l'Analyse de la Céramique</b> (Software en línea para la Gestión y el Análisis de la Cerámica) fue concebido, bajo el nombre de DBCer, en el marco de la tesis «Étude chronologique, économique et culturelle de la vaisselle du <i>Piano della Civita</i> à Artena (Latium) depuis la République romaine jusqu’à l’Antiquité tardive» (S. Dienst, 2024 - disponible en <a href="https://hdl.handle.net/2268/318966">ORBi</a>). Su objetivo inicial era estructurar y compartir los datos de esta investigación en un formato plenamente aprovechable por la comunidad científica, siguiendo los principios de la Ciencia Abierta y el Acceso Abierto.</p>
        <p>La clasificación y puesta a disposición de datos arqueológicos representa un desafío importante. LOGACer no solo permite compartir estos datos, sino también cruzar información procedente de diferentes equipos de investigación que colaboran en torno a una problemática común. De este modo, queremos poner esta herramienta a disposición de todos los investigadores que deseen compartir sus datos sobre el <i>instrumentum</i>, en particular sobre la cerámica y el vidrio.</p>
        <br>

        <h2>Principios de implementación</h2>
        <br>
        <p>LOGACer se basa en los siguientes principios fundamentales:</p>
        <ul style="text-align:left;">
            <li><b>Colaboración y revisión:</b> El software favorece la colaboración entre investigadores en proyectos comunes. En una versión posterior, también permitirá a los usuarios comentar e incluso proponer correcciones sobre los datos publicados por otros.</li>
            <li><b>Confidencialidad de los datos:</b> Aunque LOGACer fomenta el intercambio de datos con vistas al Acceso Abierto, respeta la necesidad de los usuarios de mantener sus datos privados hasta que estén finalizados, publicados o de forma indefinida. Existen diferentes niveles de confidencialidad y de compartición, especialmente para las operaciones arqueológicas, los horizontes-sitio y los contextos, así como para los horizontes regionales.</li>
            <li><b>Cronología:</b> La cronología se determina a nivel de los sitios mediante fases u horizontes-sitio, y diferentes horizontes-sitio pueden agruparse en horizontes regionales.</li>
            <li><b>Interoperabilidad:</b> Los datos deben ser comparables y poder cruzarse entre sí. Es posible realizar búsquedas por tipos, pastas u otros criterios pertinentes para consultar el conjunto de los datos (ya sean públicos o accesibles para el usuario).</li>
            <!--<li><b>Adaptabilidad:</b> Los métodos y repertorios utilizados por diferentes investigadores pueden variar. Asimismo, la puesta en línea de datos antiguos puede basarse en repertorios anteriores. Queremos permitir que cada persona pueda publicar los datos de la manera que considere más adecuada, sin restringir las denominaciones. Este principio entra en tensión con el de interoperabilidad, y se están buscando soluciones para resolver esta cuestión. Estas pasarán por posibilidades de personalización de la experiencia del usuario. </li>-->
            <li><b>Facilidad de uso:</b> A pesar de su complejidad técnica, LOGACer intenta seguir siendo accesible para un usuario principiante. Los fundamentos de su utilización deberían poder dominarse en menos de una hora, con mecanismos de protección para evitar errores de manipulación.</li>
        </ul>
        <br>

        <h2>Infraestructura técnica</h2>
        <br>
        <p>Una primera versión de LOGACer (DBCer versión 1) utilizaba el framework Django con una base de datos SQLite. La versión actual se basa en PHP y JavaScript (con AJAX), y consulta una base de datos MySQL. Las bibliotecas utilizadas incluyen Bootstrap para la maquetación, Leaflet para la cartografía, Altorouter para el enrutamiento y PhpSpreadsheet para la gestión de archivos Excel.</p>
        <p>El software está compuesto por varias partes o «módulos»:</p>
        <ul style="text-align:left;">
            <li><b>Ya disponibles</b></li><ul>
            <li><b>Estructura básica:</b> gestión de operaciones arqueológicas o sitios, horizontes-sitio o fases, contextos y objetos. Incluye la gestión de usuarios, la incorporación de ilustraciones, archivos y bibliografía, así como herramientas de consulta, importación y exportación de datos y una cartografía básica.</li>
            <li><b>Cronología por horizontes:</b> Definición de horizontes regionales a los que se vinculan horizontes-sitio, con diferentes grados de conexión.</li>
            <li><b>Repertorios:</b> Integración de los conceptos de categoría, grupo de pastas, función y tipo, que pueden describirse y consultarse, con restricciones lógicas (p. ej.: vínculo entre tipos y categorías).</li>
            <li><b>Revisión de la literatura:</b> Posibilidad de indicar claramente cuándo se han retomado datos de publicaciones de otros autores y se han reelaborado. Los datos publicados sobre el material pueden añadirse además de los datos reelaborados.</li>
            </ul><li><b>En proceso de implementación</b></li><ul>
            <li><b>Horizontes avanzados:</b> Tipo de vínculo entre horizontes regionales y tipos presentes, con herramientas de seriación y de análisis factorial de correspondencias (AFC). Comparación entre una fase/horizonte-sitio/contexto y un grupo de horizontes.</li>
            </ul><li><b>Ya previstos</b></li><ul>
            <li><b>Pastas avanzadas:</b> Incorporación de estudios de pastas directamente en la base de datos, con indicación de los protocolos y herramientas de estadística simple (ACP, dendrograma).</li>
            <li><b>Gráficos:</b> Visualización de gráficos útiles para la publicación o comparación de los datos (univariados o bivariados, por contextos/horizontes-sitio/operaciones arqueológicas).</li>
            <li><b>Cartografía avanzada:</b> Mejora de la visualización cartográfica, con representación de las distribuciones cuantitativas del material y filtrado/distinción según diferentes criterios.</li>
            <li><b>Repertorios - normalización:</b> Detección de elementos similares y modificaciones agrupadas para ayudar a normalizar datos heterogéneos.</li>
            <li><b>Otras funcionalidades:</b> Está previsto añadir funcionalidades relacionadas con el multilingüismo, la incorporación de comentarios, la gestión de la bibliografía, así como una mayor operabilidad de los datos (con puntos de entrada y salida) para facilitar su uso con otros programas más especializados... Todo ello dependerá de las necesidades de los usuarios y del tiempo disponible para el desarrollo.</li>
        </ul></ul>          
        <br>

        <h2>Implementar LOGACer para su propio proyecto</h2>
        <br>
        <p>LOGACer está protegido por una licencia CC BY-NC, que autoriza la reutilización de su código, su modificación y su implementación por otros equipos. El código fuente está disponible previa solicitud al administrador (a través del <a href="https://www.logacer.org/about_us#contact" target="_blank">formulario de contacto</a>).</p>
        <p>Si desea desplegar LOGACer para su proyecto, podemos:<p>
        <ul style="text-align:left;">
            <li>Proporcionarle gratuitamente los elementos necesarios para una implementación local por parte de su servicio informático, sin configuración específica (más allá del nombre y las páginas de presentación);</li>
            <li>Configurar la herramienta o añadir funcionalidades (mediante una contribución económica que permita mantener el proyecto) para la implementación de la herramienta;</li>
            <li>Proponer la implementación de la herramienta para su uso en un servidor externo (también será necesaria una contribución económica para financiar la instalación y los costes de alojamiento).</li>
        </ul>
        <p>Sea cual sea su situación, si LOGACer le interesa, ¡no dude en <a href="https://www.logacer.org/about_us#contact" target="_blank">contactarnos</a> para hablar de ello!</p>