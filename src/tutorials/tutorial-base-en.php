    <!-- Barre latérale -->
<nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Back: Tutorial list</a></h6><br>
    <h4 class="px-3">Principles and navigation</h4>
    <a href="#principes-base"><h5 class="px-3">I. Basic principles</h5></a>
    <a href="#opération-objet"><h5 class="px-3">II. From the archaeological operation to the object</h5></a>
    <a href="#liste-opérations">1. List of operations</a>
    <a href="#opération-archéologique">2. Archaeological operation</a>
    <a href="#horizon-site">3. Site-horizon</a>
    <a href="#contexte-inventaire">4. Context and inventory</a>
    <a href="#objet-illustration">5. Object and illustration(s)</a>
    <a href="#horizons-régionaux"><h5 class="px-3">III. Regional horizons</h5></a>
    <a href="#liste-groupes-horizons">1. List of horizon groups</a>
    <a href="#groupe-horizons">2. Description of the horizon group</a>
    <a href="#horizon-régional">3. Regional horizons and related finds</a>
    <a href="#types-pâtes"><h5 class="px-3">IV. Types and fabric groups</h5></a>
    <a href="#typologies-types">1. Typologies and types</a>
    <ul>
        <li><a href="#liste-typologies">List of typologies</a></li>
        <li><a href="#typologie">Description of the typology</a></li>
        <li><a href="#types">Description of the types</a></li>
    </ul>
    <a href="#pâtes">2. Fabric groups</a>
    <ul>
        <li><a href="#liste-groupes-pâtes">List of fabric groups</a></li>
        <li><a href="#groupes-pâtes">Description of the fabric groups</a></li>
    </ul>
    <a href="#bibliographie"><h5 class="px-3">V. Bibliography</h5></a>
    <a href="#liste-bibliographie">1. List of references</a>
    <a href="#consulter-bibliographie">2. Consulting a reference</a>
    <a href="#autres-éléments"><h5 class="px-3">VI. Other elements</h5></a>
    <a href="#fichiers-génériques">1. Generic files</a>
    <a href="#citer-page">2. Citing a page</a>
    <a href="#a-propos">3. About the website</a>
    <a href="#recherche-simple">4. Simple search</a>
    <a href="#enregistrement-connexion">5. Registration and login</a>
</nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: basic principles and navigation in the tool without logging in</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Basic principles</h2>

    <p>The central objective of LOGACer, used by CeVICA, is to make object inventories (in particular, ceramics) available, while also allowing other information to be incorporated and queries to be performed on these objects. To achieve this, LOGACer is based on several elements:</p>
    <ul>
        <li>Putting the <b>object</b> into context: this is the central part of LOGACer. The object belongs to a <b>context</b> (or stratigraphic unit), which is itself linked to other contemporary contexts (the <b>site-horizon</b>), all of which were recorded during an <b>archaeological operation</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>The relative chronology of the object: site-horizons can be grouped into <b>regional horizons</b>. These follow one another within a geographical region; this succession is grouped into <b>horizon groups</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>The characterization of the object: ceramics are classified, according to the model used in LOGACer, by their <b>category</b>, <b>function</b>, <b>type</b> and <b>fabric group</b>. The first two classification criteria are fairly standardized and limited. Types, on the other hand, are much more numerous and are grouped into <b>typologies</b>; the same applies to fabric groups, which can be hierarchically organized. The characterization of types and fabric groups, and the ability to search for them, is also important. Categories, functions, typologies and types are largely linked to ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>References: it is possible to supplement the characterization of these different elements by referencing a <b>bibliography</b> or by adding <b>files</b>. In addition, these elements are managed by <b>users</b> (owners or contributors in some cases). Finally, objects can be accompanied by <b>illustrations</b> such as drawings, photographs or enlargements;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>Collaboration: a team working on several of these elements (sites, regional horizons, etc.) can find them grouped within <b>projects</b>, allowing the team's access rights to be managed more effectively.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>

    <p>Navigation is designed to prioritize a contextual approach (from the archaeological operation to the object), while also taking these various links into account: presentation of objects by regional horizons, types and fabric groups (as well as their illustrations), presentation of site-horizons by regional horizons (with the categories and types present), elements linked to a bibliographic reference, as well as more advanced queries.</p>
    </section>

    <section id="opération-object" class="mb-5">
    <h2>II. Navigation: from the archaeological operation to the object</h2>
        <section id="liste-opérations" class="mb-5">
        <h3>1. List of archaeological operations</h3>

            <p>The list of archaeological operations is accessible via the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_1.png" width="80%"></div>
            <p>Within this list, the archaeological operation you are interested in can be reached either through an interactive map or through the list of archaeological operations.

            <h4>1.1. Map</h4>
                <p>Each archaeological operation is represented by a marker on the map. By clicking on the marker, you can see which archaeological operation it represents. You can access it by clicking on it.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2.png" width="80%"></div>
                <p>If several archaeological operations have the same coordinates, they are displayed on the same marker.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_3.png" width="80%"></div>
                <p>Finally, if an area contains many archaeological operations, a colored circle appears instead, showing the number of operations present in that area. By clicking on it, you can zoom in and split this marker into several other circles and/or individual markers. It is also possible to zoom normally.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2b.png" width="80%"></div>

            <h4>1.2. List of archaeological operations</h4>
                <p>By clicking on the corresponding tab, you can also access a summary table of the archaeological operations.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_4.png" width="80%"></div>
                <p>The table is organized by country, then by region. Archaeological operations are displayed in alphabetical order by code. Those that have not been assigned to a region are grouped at the end of the list. By clicking on the column headings, you can sort the table by that column (in ascending alphabetical order, then descending order by clicking a second time).</p>
                <p>It is also possible to filter the table by one or more fields. The filters are displayed by clicking on « Show table filters ». You then simply need to enter part of the content of a field to filter the table.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
        </section>

        <section id="opération-archéologique" class="mb-5">
        <h3>2. Description of the archaeological operation</h3>
            <p>When you click on an archaeological operation, you are taken to its descriptive page. This page contains information about:</p>
            <ul>
                <li>The person who added the operation to CeVICA and the contributors who can add content to the page;</li>
                <li>Geographical information: region, latitude and longitude;</li>
                <li>A description of the archaeological operation, which may vary in length and organization;</li>
                <li>The various site-horizons present. When contexts have not been added to a site-horizon, they can be accessed by clicking on « Contexts without a site-horizon »;</li>
                <li>The bibliographic references linked to the archaeological operation;</li>
                <li>The files associated with the archaeological operation;</li>
                <li>The information required to cite the page correctly.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
            <p>Some of these sections may be absent, depending on what has been completed or linked to the archaeological operation. Regarding the bibliography, if the archaeological operation (or the site-horizon or context) has never been published, this is clearly indicated.</p>
            <p>One of the files, which is automatically provided, allows you to download the entire inventory of the archaeological operation. The same applies to the site-horizon and context.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_6.png" width="80%"></div>
            <p>Depending on what was indicated when the site was completed, the background may be different and a frame may indicate that the data was extracted from a publication. This information helps highlight cases where the author of the record is not one of the researchers who worked on the archaeological operation, but the data was made available online as part of a broader project, within the framework of a literature review.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_7.png" width="80%"></div>
        </section>

        <section id="horizon-site" class="mb-5">
        <h3>3. Description of the site-horizon</h3>
            <p>By clicking on one of the site-horizons, you reach a new window containing the following information:</p>
            <ul>
                <li>The archaeological operation to which the site-horizon belongs;</li>
                <li>The person who added the operation to CeVICA, as well as the person who added the site-horizon;</li>
                <li>Information about the regional horizon if the site-horizon is linked to a regional horizon;</li>
                <li>A description of the site-horizon, which may vary in length and organization;</li>
                <li>The various contexts present;</li>
                <li>The bibliographic references linked to the site-horizon (generally the same as those for the archaeological operation, unless explicitly changed by the author of the record);</li>
                <li>The files associated with the site-horizon;</li>
                <li>The information required to cite the page correctly.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_8.png" width="80%"></div>
            <p>The regional horizon is clickable. The importance of the site-horizon in defining the regional horizon is specified (major, minor, uncertain or unknown).</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_9.png" width="80%"></div>
        </section>

        <section id="contexte-inventaire" class="mb-5">
        <h3>4. Description of the context and inventory</h3>
            <p>By clicking on one of the contexts, you reach its window, with the inventory. The information is broadly similar to that of the phase, when available. A tab allows you to switch from the description to the inventory.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_10.png" width="80%"></div>
            <p>When there is no description, the inventory is displayed directly without a tab. It can be exported using the blue button, just as it can from the associated files.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11.png" width="80%"></div>
            <p>By clicking on the inventory number, you can access the details of the object and its illustrations.</p>
            <p>Categories, functions, types and fabric groups can be listed in CeVICA. In this case, the category and function are displayed in black, while the type and fabric group are displayed in blue (they can be clicked to access the corresponding record). By hovering the mouse over the category or fabric group, you can see the full name.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_12.png" width="80%"></div>
            <p>If one of these elements is absent from the database, it is displayed in grey and in a smaller font.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13.png" width="80%"></div>
            <p>It is possible to sort the table by clicking on the column headers. Note that categories, functions, types and fabric groups are sorted according to their code and not according to what is displayed; unreferenced elements appear in alphabetical order at the bottom of the list.</p>
            <p>It is also possible to filter the table by clicking on the filter tab and then entering the search terms. Categories, functions and types can also be searched by their code.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11b.png" width="80%"></div>
            <p>The presence of an illustration is indicated by a « Yes » in the corresponding field.</p>
            <p>By default, only the first 200 inventory lines are retrieved, for performance reasons. It is possible to retrieve additional lines (200 at a time) by clicking on « Load more ».</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13b.png" width="80%"></div>
        </section>

        <section id="objet-illustration" class="mb-5">
        <h3>5. Description of the object and illustration(s)</h3>
            <p>By clicking on the object, the same information as in the contexts is displayed in the form of a list.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_14.png" width="60%"></div>
            <p>A tab allows you to view the illustrations, if there are any for the object. It is possible to display these illustrations at a larger size by clicking on them.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_15.png" width="80%"></div>
            <p>Once the illustration is displayed, you can return to the basic view by clicking beside it or on the cross in the upper-right corner.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_16.png" width="80%"></div>
        </section>
    </section>

    <section id="horizons-régionaux" class="mb-5">
    <h2>III. Regional horizons</h2>
        <section id="liste-groupes-horizons" class="mb-5">
        <h3>1. List of horizon groups</h3>
            <p>The list of regional horizons is accessible via the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_17.png" width="80%"></div>
            <p>The list is organized by country, then by region. Horizon groups are displayed in alphabetical order by code. When a horizon group extends across several regions, it is listed several times. Those that have not been assigned to a region are grouped at the end of the list.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_18.png" width="50%"></div>
        </section>

        <section id="groupe-horizons" class="mb-5">
        <h3>2. Description of the horizon group</h3>
            <p>When you click on a horizon group, you are taken to its descriptive page. This page contains information about:</p>
            <ul>
                <li>The person who added the group to CeVICA and the contributors who can add content to the page;</li>
                <li>The regions covered by the horizons;</li>
                <li>A description of the horizon group, which may vary in length and organization;</li>
                <li>The various regional horizons present (some of which may be internally divided into sub-horizons);</li>
                <li>The associated bibliographic references;</li>
                <li>The associated files;</li>
                <li>The information required to cite the page correctly.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_19.png" width="80%"></div>
            <p>Some of these sections may be absent, depending on what has been completed or linked to the archaeological operation. Regarding the bibliography, if the archaeological operation (or the site-horizon or context) has never been published, this is clearly indicated.</p>
        </section>

        <section id="horizon-régional" class="mb-5">
        <h3>3. Regional horizons and associated finds</h3>
            <p>When you select a horizon (from the group, a phase or an inventory), you have access to various pieces of information and several tabs.</p>
            <p><b>Important:</b> When a horizon has several sub-horizons, the information provided relates only to the generic horizon and not to the sub-horizons.</p>

            <h4>3.1. General information</h4>
                <p>This section contains:</p>
                <ul>
                    <li>The group to which the regional horizon belongs;</li>
                    <li>The person who added the horizon group to CeVICA as well as the person who added the regional horizon;</li>
                    <li>The number of recorded objects (inventory lines) for this horizon.</li>
                </ul>

            <h4>3.2. Description</h4>
                <p>The description includes:</p>
                <ul>
                    <li>A description of the horizon, which may vary in length and organization;</li>
                    <li>Where applicable, the various sub-horizons present;</li>
                    <li>A dating (also in free-text form);</li>
                    <li>The site-horizons making up the regional horizon, as well as their degree of importance for the horizon;</li>
                    <li>The associated files;</li>
                    <li>The information required to cite the page correctly.</li>
                </ul> 
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_20.png" width="80%"></div>

            <h4>3.3. Distribution</h4>
                <p>The distribution section displays a map of the various site-horizons making up the regional horizon. By clicking on a marker, you can see the site-horizon(s) present at that location, as well as the number of objects belonging to that site-horizon.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_21.png" width="80%"></div>

            <h4>3.4. List of types</h4>
                <p>A sortable table lists all the types present within the horizon, organized by category. The number of occurrences indicates the number of inventory lines corresponding to that type for this horizon.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_22.png" width="80%"></div>
                <p>It is possible to sort the table, bearing in mind that for categories and types, the code rather than the abbreviation or name is used for sorting. It is also possible to filter the table using the filter menu, which can be displayed by clicking on it.</p>

            <h4>3.5. Illustrations</h4>
                <p>This tab contains all the illustrations of the objects present in the horizon. They can be sorted according to their type.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_23.png" width="80%"></div>
                <p>It is possible to display these illustrations at a larger size by clicking on them. Once the illustration is displayed, you can return to the basic view by clicking beside it or on the cross in the upper-right corner.</p>

            <h4>3.6. Inventory</h4>
                <p>This final tab provides the complete inventory of the regional horizon. It works in the same way as the context inventory, with the addition of the codes for sites, site-horizons and contexts. You can click on these codes to access their record, or simply hover the mouse over them to see their name.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_24.png" width="80%"></div>
                <p>The table can be sorted and filtered in the same way as the context inventory, and is also limited to 200 inventory lines by default.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_25.png" width="80%"></div>
                <p>Aspects related to the published names of categories, functions, types and fabric groups when they differ from those in CeVICA will be added later (this is a feature that is currently unused).</p>
        </section>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>IV. Types and Fabric Groups</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologies and Types</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. List of Typologies</h4>
                <p>The list of typologies can be accessed via the top navigation bar.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_26.png" width="80%"></div>
                <p>The list is organized by the category to which each typology is linked. Some typologies are linked to several categories and therefore appear under each of them. Typologies that have not been linked to at least one category (and therefore cannot be used to link objects) are grouped at the end of the list.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Description of a Typology</h4>
                <p>When you click on a typology, you are taken to its description page. This page first contains information about:</p>
                <ul>
                    <li>The person who added the typology to CeVICA and the contributors who can add content to the page;</li>
                    <li>A description of the typology, which may vary in length and structure;</li>
                    <li>The bibliographic references linked to the archaeological operation;</li>
                    <li>The files associated with the archaeological operation;</li>
                    <li>The information required to cite the page correctly.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>The “Categories” tab lists the categories for which the typology (and therefore its types) can be used.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>The “Types” tab lists, in alphabetical order by code, the types associated with the category. If some types have subtypes, these do not appear here.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Types and Their Associated Finds</h4>
                <p>When you select a type (via a typology or from an inventory), you have access to various pieces of information and several tabs.</p>
                <p><b>Important:</b> When a type has several subtypes, the information displayed applies only to the generic type, and not to the subtypes.</p>

                <h5>1.3.1. General Information</h5>
                    <p>This section contains:</p>
                    <ul>
                        <li>The typology to which the type belongs (and, where applicable, the main type of the subtype);</li>
                        <li>The person who added the typology to CeVICA and the person who added the type;</li>
                        <li>The number of recorded objects (inventory lines) for this type.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_31.png" width="80%"></div>

                <h5>1.3.2. Distribution</h5>
                    <p>The distribution is presented either as an interactive map or as a list of archaeological operations containing this type.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_32.png" width="80%"></div>
                    <p>As with the list of archaeological operations, clicking on a marker allows you to see the archaeological operations and the number of inventory lines identified as belonging to this type.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_33.png" width="80%"></div>
                    <p>The list of archaeological operations is presented as a table containing the same information. It is possible to access the archaeological operation or the cross-inventory of the archaeological operation and the type by clicking on “view”.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_34.png" width="80%"></div>
                    <p>The table can also be sorted and filtered.</p>

                <h5>1.3.3. Description</h5>
                    <p>The description includes:</p>
                    <ul>
                        <li>A description of the type, which may vary in length and structure;</li>
                        <li>Where applicable, the different subtypes present;</li>
                        <li>A date or dating information (also in free-text form);</li>
                        <li>The bibliography;</li>
                        <li>The information required to cite the page correctly.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_35.png" width="80%"></div>

                <h5>1.3.4. Illustrations</h5>
                    <p>This tab contains all illustrations of objects of this type. They can be sorted according to the type of illustration.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_36.png" width="80%"></div>
                    <p>These illustrations can be displayed at a larger size by clicking on them. Once an illustration is displayed, you can return to the standard view by clicking outside it or on the cross in the upper-right corner.</p>

                <h5>1.3.5. Fabric Groups</h5>
                    <p>This tab lists the fabric groups recorded for this type. You can view the fabric group or the inventory of objects corresponding to the selected type and fabric group.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_37.png" width="80%"></div>

                <h5>1.3.6. Inventory</h5>
                    <p>This final tab provides the complete inventory for the type. It works in the same way as the context inventory, with the addition of the codes for sites, site-horizons and contexts. You can click on these codes to access their corresponding record, or simply hover over them to see their name.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_38.png" width="80%"></div>
                    <p>The table can be sorted and filtered in the same way as the context inventory, and is also limited to 200 inventory lines by default.</p>

                <h5>1.3.7. Correspondences</h5>
                    <p>This tab, which relates to published names of types when they differ from those used in CeVICA, will be described later (this feature is currently unused).</p>
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Fabric Groups</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. List of Fabric Groups</h4>
                <p>The list of fabric groups can be accessed via the top navigation bar.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_40.png" width="80%"></div>
                <p>The list is not currently sorted. If some fabric groups have subgroups, these do not appear here.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Fabric Groups and Their Associated Finds</h4>
                <p>When you select a fabric group (from the list of groups or from an inventory), you have access to various pieces of information and several tabs.</p>
                <p><b>Important:</b> When a fabric group has several subgroups, the information displayed applies only to the generic group, and not to the subgroups.</p>

                <h5>2.2.1. General Information</h5>
                    <p>This section contains:</p>
                    <ul>
                        <li>Where applicable, the main group of the subgroup;</li>
                        <li>The person who added the fabric group to CeVICA;</li>
                        <li>The number of recorded objects (inventory lines) for this fabric group.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_42.png" width="70%"></div>

                <h5>2.2.2. Distribution</h5>
                    <p>The distribution is presented either as an interactive map or as a list of archaeological operations containing this fabric group.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_43.png" width="80%"></div>
                    <p>As with the list of archaeological operations, clicking on a marker allows you to see the archaeological operations and the number of inventory lines identified as belonging to this fabric group.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_44.png" width="80%"></div>
                    <p>The list of archaeological operations is presented as a table containing the same information. It is possible to access the archaeological operation or the cross-inventory of the archaeological operation and the fabric group by clicking on “view”.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_45.png" width="80%"></div>
                    <p>The table can also be sorted and filtered.</p>

                <h5>2.2.3. Description</h5>
                    <p>The description includes:</p>
                    <ul>
                        <li>A description of the fabric group, which may vary in length and structure;</li>
                        <li>Where applicable, the different subgroups present;</li>
                        <li>An origin (also in free-text form);</li>
                        <li>The bibliography;</li>
                        <li>The information required to cite the page correctly.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_46.png" width="80%"></div>

                <h5>2.2.4. Illustrations</h5>
                    <p>This tab contains all illustrations of objects belonging to this fabric group. They can be sorted according to the type of illustration.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_47.png" width="80%"></div>
                    <p>These illustrations can be displayed at a larger size by clicking on them. Once an illustration is displayed, you can return to the standard view by clicking outside it or on the cross in the upper-right corner.</p>

                <h5>2.2.5. Types</h5>
                    <p>This tab lists the types recorded for this fabric group. You can view the type or the inventory of objects corresponding to the selected type and fabric group.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_48.png" width="80%"></div>

                <h5>2.2.6. Inventory</h5>
                    <p>This final tab provides the complete inventory for the fabric group. It works in the same way as the context inventory, with the addition of the codes for sites, site-horizons and contexts. You can click on these codes to access their corresponding record, or simply hover over them to see their name.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_49.png" width="80%"></div>
                    <p>The table can be sorted and filtered in the same way as the context inventory, and is also limited to 200 inventory lines by default.</p>

                <h5>2.2.7. Correspondences</h5>
                    <p>This tab, which relates to published names of fabric groups when they differ from those used in CeVICA, will be described later (this feature is currently unused).</p>
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>V. Bibliography</h2>
        <p>As indicated elsewhere, it is possible to provide bibliographic references for a range of elements: archaeological operation, site-horizon, context, regional horizon, typology, type, or fabric group. This information is fairly basic, but can be consulted in CeVICA.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. List of Bibliographic References</h3>
            <p>The list of bibliographic references can be accessed via the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>It is sorted alphabetically by abbreviation.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Viewing a Reference</h3>
            <p>You can view a reference by clicking on it wherever it is displayed. You can then see the full reference, as well as the database elements linked to it.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In some cases, a page number has been specified. It is available both on the element's page and on the reference's page.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>VI. Other Elements</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. List of Downloadable Files</h3>
            <p>A list of downloadable files can be accessed via the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>This section contains files that are not linked to a specific element (archaeological operation, site-horizon, context, regional horizon, etc.), but are of a general nature and have been deemed useful to share. Files can be downloaded simply by clicking on them.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citing a Page</h3>
            <p>Below each page describing an element of the database, a citation format is provided for referencing that element in a bibliography. Numerous examples are provided elsewhere in this tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Information About the Website</h3>
            <p>This information is mainly available via “Support and Information” in the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>These tabs contain:</p>
            <ul>
                <li>A more detailed presentation of CeVICA under “Presentation and Contacts”;</li>
                <li>A contact form for the administrator in the same tab;</li>
                <li>A list of available tutorials under “CeVICA User Guides”;</li>
                <li>The infrastructure in which CeVICA operates under “Associated Tools”: additional developments (such as ONICer and DBCer, the LOGACer tool used by CeVICA), as well as tools recommended for use alongside those developed by the Universities of Liège and Lille.</li>
            </ul>
            <p>Other pages can be accessed at the bottom of each page:</p>
            <ul>
                <li>The legal notices and data management policy, which are required for every website;</li>
                <li>By clicking on the LOGACer logo, a description of the software.</li>
            </ul>
        </section>

        <section id="recherche-simple" class="mb-5">
        <h3>4. Performing Searches</h3>
            <p>For the time being, the search tool is fairly simple and consists of a basic search bar that can be accessed by clicking on the magnifying glass on the right side of the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_58.png" width="80%"></div>
            <p>You can then enter descriptive information for a type of element and select the relevant element from those already available.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_59.png" width="60%"></div>
            <p>A list or table of matching elements is then displayed.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_60.png" width="80%"></div>
        </section>

        <section id="enregistrement-connexion" class="mb-5">
        <h3>5. Registering and Logging In</h3>
            <p>Registration and login will be described later, once the collaboration tools are fully operational.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
