            <h2>LOGACer: an open-source tool for the management and analysis of archaeological artefacts</h2>
            <br>
            <p>The <b>Logiciel Online pour la Gestion et l'Analyse de la Céramique</b> (Online Software for the Management and Analysis of Ceramics) was initially developed under the name DBCer as part of the PhD thesis “Étude chronologique, économique et culturelle de la vaisselle du <i>Piano della Civita</i> à Artena (Latium) depuis la République romaine jusqu’à l’Antiquité tardive” (S. Dienst, 2024 - available on <a href="https://hdl.handle.net/2268/318966">ORBi</a>). Its initial objective was to structure and share the data from this research in a format that could be fully exploited by the scientific community, following the principles of Open Science and Open Access.</p>
            <p>The classification and dissemination of archaeological data represent a major challenge. LOGACer not only makes it possible to share these data, but also to cross-reference information from different research teams collaborating on a common research question. We therefore aim to make this tool accessible to all researchers wishing to share their data on <i>instrumentum</i>, particularly pottery and glass.</p>
            <br>

            <h2>Implementation principles</h2>
            <br>
            <p>LOGACer is based on the following key principles:</p>
            <ul style="text-align:left;">
                <li><b>Collaboration and reviewing:</b> The software promotes collaboration between researchers working on common projects. In a later version, it will also allow users to comment on, and potentially propose corrections to, data published by others.</li>
                <li><b>Data confidentiality:</b> Although LOGACer encourages data sharing with a view to Open Access, it respects users’ need to keep their data private until they are finalised, published, or indefinitely. Different levels of confidentiality and sharing are available, particularly for archaeological operations, site-horizons and contexts, as well as for regional horizons.</li>
                <li><b>Chronology:</b> Chronology is determined at site level through phases or site-horizons, and different site-horizons can be grouped into regional horizons.</li>
                <li><b>Interoperability:</b> Data must be comparable and cross-referenced with one another. Searches by type, fabric or other relevant criteria are possible in order to query the entire dataset (either data made public or data accessible to the user).</li>
                <!--<li><b>Adaptability:</b> The methods and reference systems used by different researchers may vary. In addition, the publication of older data may rely on earlier reference systems. We aim to allow everyone to publish data in the way that best suits their needs, without restricting terminology. This principle is in tension with interoperability, and solutions are being sought to address this issue. These will include possibilities for customising the user experience.</li>-->
                <li><b>Ease of use:</b> Despite its technical complexity, LOGACer aims to remain accessible to beginners. The basics of its use should be learnable in less than an hour, with safeguards to prevent handling errors.</li>
            </ul>
            <br>

            <h2>Technical infrastructure</h2>
            <br>
            <p>An initial version of LOGACer (DBCer version 1) used the Django framework with an SQLite database. The current version is based on PHP and JavaScript (with AJAX), querying a MySQL database. The libraries used include Bootstrap for layout, Leaflet for mapping, Altorouter for routing, and PhpSpreadsheet for managing Excel files.</p>
            <p>The software consists of several parts or “modules”:</p>
            <ul style="text-align:left;">
                <li><b>Already available</b></li><ul>
                <li><b>Core structure:</b> management of archaeological operations or sites, site-horizons or phases, contexts and objects. Includes user management, the addition of illustrations, files and bibliographic references, as well as data browsing, import and export tools and basic mapping.</li>
                <li><b>Chronology by horizons:</b> Definition of regional horizons to which site-horizons are linked, with varying degrees of connection.</li>
                <li><b>Reference systems:</b> Integration of the concepts of category, fabric, function and type, which can be described and consulted, with logical constraints (e.g. links between types and categories).</li>
                <li><b>Literature review:</b> Possibility of clearly indicating when data have been taken from publications by other authors and subsequently reworked. Edited data relating to artefacts can be added in addition to the reworked data.</li>
                </ul><li><b>Currently being implemented</b></li><ul>
                <li><b>Advanced horizons:</b> Type of link between regional horizons and the types present, with seriation and correspondence analysis (CA) tools. Comparison between a phase/site-horizon/context and a horizon group.</li>
                </ul><li><b>Already planned</b></li><ul>
                <li><b>Advanced fabric analysis:</b> Addition of fabric studies directly within the database, with indication of protocols and simple statistical tools (PCA, dendrogram).</li>
                <li><b>Charts:</b> Display of charts useful for publication or data comparison (univariate or bivariate, by contexts/site-horizons/archaeological operations).</li>
                <li><b>Advanced mapping:</b> Improved map display, with visualisation of quantitative artefact distributions and filtering/distinction by criteria.</li>
                <li><b>Reference systems – standardisation:</b> Detection of similar elements and grouped modifications to assist in the standardisation of heterogeneous data.</li>
                <li><b>Other features:</b> Additional possibilities are planned regarding multilingualism, adding comments, bibliographic management, as well as data interoperability (with easy data entry and output points) for use with other, more specialised software... All of this will depend on users’ needs and the time available for development.</li>
            </ul></ul>          
            <br>

            <h2>Implementing LOGACer for your own project</h2>
            <br>
            <p>LOGACer is released under a CC BY-NC licence, which allows its code to be reused, modified and implemented by other teams. The source code is available upon request from the administrator (via the <a href="https://www.logacer.org/about_us#contact" target="_blank">contact form</a>).</p>
            <p>If you would like to deploy LOGACer for your project, we can:<p>
            <ul style="text-align:left;">
                <li>Provide you free of charge with the elements required for a local implementation by your IT department, without specific configuration (other than the name and presentation pages);</li>
                <li>Configure the tool or add features (in return for a financial contribution to support the project) for the implementation of the tool;</li>
                <li>Offer to implement the tool for your use on an external server (a financial contribution will also be required to cover installation and hosting costs).</li>
            </ul>
            <p>Whatever your situation, if LOGACer is of interest to you, please feel free to <a href="https://www.logacer.org/about_us#contact" target="_blank">contact us</a> to discuss it!</p>
