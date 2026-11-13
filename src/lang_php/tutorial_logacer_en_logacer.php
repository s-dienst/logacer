<?php $return_list = "<p><a href='" . create_url(['']) . "'>Retourner à la page d'accueil</a></p>";
$tuto_button = ""; ?>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['']); ?>'>Back to the homepage</a></h6><br>
        <h4 class="px-3">Principles and navigation</h4>
        <a href="#principes-base"><h5 class="px-3">I. Basic principles</h5></a>
        <a href="#navigation-generale"><h5 class="px-3">II. General navigation</h5></a>
            <a href="#projets">1. Projects</a>
            <a href="#typologies-globales">2. Typologies and fabric groups</a>
            <a href="#espace-personnel">3. Personal workspace</a>
            <a href="#referentiels">4. Reference lists</a>
            <a href="#gestion-utilisateurs">5. User management</a>
        <a href="#types-pâtes"><h5 class="px-3">III. Types and fabric groups</h5></a>
            <a href="#typologies-types">1. Typologies and types</a>
            <ul>
                <li><a href="#liste-typologies">List of typologies</a></li>
                <li><a href="#typologie">Typology description</a></li>
                <li><a href="#types">Type descriptions</a></li>
            </ul>
            <a href="#pâtes">2. Fabric groups</a>
            <ul>
                <li><a href="#liste-groupes-pâtes">List of fabric groups</a></li>
                <li><a href="#groupes-pâtes">Fabric group descriptions</a></li>
            </ul>
        <a href="#bibliographie"><h5 class="px-3">IV. Bibliography</h5></a>
            <a href="#liste-bibliographie">1. List of references</a>
            <a href="#consulter-bibliographie">2. Viewing a reference</a>
        <a href="#autres-éléments"><h5 class="px-3">V. Other elements</h5></a>
            <a href="#fichiers-génériques">1. General files</a>
            <a href="#citer-page">2. Citing a page</a>
            <a href="#a-propos">3. About the website</a>
        <a href="#compte-utilisateur"><h5 class="px-3">VI. User accounts</h5></a>
            <a href="#enregistrement-connexion">1. Registration and login</a>
            <a href="#gestion-compte">2. Account management</a>
    </nav>

    
  <!-- Main content -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: basic principles and navigating the tool without logging in</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Basic principles</h2>

    <p>The main aim of LOGACer is to make object inventories (particularly ceramic objects) available, while also allowing additional information to be incorporated and queries to be run on these objects. To achieve this, LOGACer is based on several components:</p>
    <ul>
        <li>Placing the <b>object</b> in context: this is the central component of LOGACer. An object belongs to a <b>context</b> (or stratigraphic unit), which is itself linked to other contemporary contexts (the <b>site-horizon</b>). All of these were recovered during an <b>archaeological operation</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>The relative chronology of the object: site-horizons can be grouped into <b>regional horizons</b>. These follow one another within a geographical region; this sequence is organised into <b>horizon groups</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>Characterising the object: according to the model used in LOGACer, ceramics are classified by <b>category</b>, <b>function</b>, <b>type</b> and <b>fabric</b>. The first two classification criteria are relatively standardised and limited in number. Types, on the other hand, are much more numerous and are grouped into <b>typologies</b>. The same applies to fabrics, which can also be organised hierarchically. Characterising types and fabrics, and being able to search for them, is also important. Categories, functions, typologies and types are largely linked to ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>References: the characterisation of these various elements can be supplemented by citing a <b>bibliographic reference</b> or adding <b>files</b>. These elements are also managed by <b>users</b> (who may act as managers or contributors in certain cases). Finally, objects can be accompanied by <b>illustrations</b>, such as drawings, photographs or enlargements;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>Collaboration: teams working on different elements (sites, regional horizons, etc.) can bring them together within <b>projects</b>, allowing the team's access rights to be managed more effectively.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>
   </section>


    <section id="navigation-generale" class="mb-5">
    <h2>II. General navigation</h2>
    <p>In addition to the workspaces dedicated to individual projects, LOGACer provides a general area for browsing available projects, accessing shared reference lists and managing elements relating to the entire installation.</p>
    <p>Navigation is organised around two bars:</p>
    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_1.png" width="80%"></div>-->
        <h3>1. General navigation bar</h3>
        <p>The top bar provides access to the main resources shared across the entire LOGACer installation.</p>
            <h4>1.1. Projects</h4>
            <p>The "Projects" section displays a list of available projects, each accompanied by a short description and a link to its respective workspace.</p>
            <p>Public projects are accessible to all visitors, whether or not they have a user account. Private projects are not displayed in this list, except to users who contribute to them.</p>
            <h4>1.2. Typologies and fabric groups</h4>
            <p>The "Typologies" and "Fabric groups" sections provide access to LOGACer's general reference lists, independently of the individual projects.</p>
            <p>The descriptive pages for typologies and fabric groups work in much the same way as those available within projects. However, information relating to archaeological objects cannot be accessed from this general area. In particular, the pages for types and fabric groups do not display the geographical distributions, illustrations, associated fabric groups or types, inventories or correspondences available within projects.</p>
            <h4>1.3. Appendices</h4>
            <p>The "Appendices" section provides access to two shared resources:</p>
            <ul>
                <li><b>Bibliography:</b> a list of bibliographic references recorded in LOGACer. Instructions for viewing them are provided in section IV. Bibliography;</li>
                <li><b>General files:</b> a list of files made available independently of any particular element in the database. Instructions for accessing them are provided in section V. Other elements.</li>
            </ul>
        <h3>2. Personal workspace</h3>
        <p>The second navigation bar provides access to features relating to the user's account and their own contributions to LOGACer.</p>
            <h4>2.1. My personal workspace</h4>
            <p>This section brings together various items of information and features relating to the user's account. The main features are also accessible from other pages of the application.</p>
            <h4>2.2. My projects, my types and my fabric groups</h4>
            <p>These sections provide access to the projects, types and fabric groups in which the user is involved as a creator, manager or contributor.</p>
            <p>They therefore provide direct access to the elements associated with the user, without having to browse through LOGACer's general lists.</p>
            <h4>2.3. Reference lists</h4>
            <p>The "Reference lists" section brings together the reference lists used in LOGACer:</p>
            <ul>
                <li><b>Countries and regions:</b> a list of countries and their regional subdivisions, with their official codes and names;</li>
                <li><b>Categories:</b> a list of the categories used to characterise objects. The table shows their code, abbreviation, name, whether they are included in ONICer, where applicable, and their creator in LOGACer;</li>
                <li><b>Functions:</b> a list of the functions used to characterise objects. The table shows their code, name, whether they are included in ONICer, where applicable, and their creator in LOGACer;</li>
                <li><b>Counting methods:</b> a list of the counting methods supported by LOGACer.</li>
            </ul>
            <p>Contributors and administrators can create and manage the general reference lists (with the exception of counting methods). Standard users only have access to the other features for which they have been granted permission.</p>
            <h4>2.4. User management</h4>
            <p>This section is reserved for LOGACer administrators. It allows them to:</p>
            <ul>
                <li>Approve new registrations;</li>
                <li>View the list of registered users;</li>
                <li>Modify users' general permissions in LOGACer by assigning them administrator, contributor or standard user status;</li>
                <li>Delete a user account when necessary.</li>
            </ul>
            <p>These general permissions are separate from the permissions assigned to users within individual projects.</p>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>III. Types and fabric groups</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologies and types</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. List of typologies</h4>
                <p>The list is organised by the category to which each typology is assigned. Some typologies are assigned to several categories and therefore appear under each of them. Typologies that have not been assigned to at least one category (and therefore cannot be used to link objects) are grouped at the end of the list.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Typology description</h4>
                <p>When you click on a typology, you are taken to its descriptive page. This page first provides the following information:</p>
                <ul>
                    <li>The person who added the typology to LOGACer and the contributors who can add information to the page;</li>
                    <li>A description of the typology, which may vary in length and structure;</li>
                    <li>Bibliographic references associated with the typology;</li>
                    <li>Files associated with the typology;</li>
                    <li>Information on how to cite the page correctly.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>The "Categories" tab lists the categories for which the typology (and therefore its types) can be used.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>The "Types" tab lists the types associated with the typology in alphabetical order by code. If some types have subtypes, these do not appear here.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Types</h4>
                <p>When you select a type through a typology, you can access only general information, unlike when browsing within a project:</p>
                    <ul>
                        <li>The typology to which the type belongs (and, where applicable, the main type of the subtype);</li>
                        <li>The person who added the typology to LOGACer, as well as the person who added the type;</li>
                        <li>A description of the type, which may vary in length and structure;</li>
                        <li>Where applicable, the various existing subtypes;</li>
                        <li>A date or chronological attribution (which may also be entered as free text);</li>
                        <li>The bibliography;</li>
                        <li>Information on how to cite the page correctly.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_2.png" width="80%"></div>-->
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Fabric groups</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. List of fabric groups</h4>
                <p>The list is not currently organised into categories. If some fabric groups have subgroups, these do not appear here.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Fabric groups</h4>
                <p>When you select a fabric group (from the list of groups or from an inventory), you can access various items of general information:</p>
                    <ul>
                        <li>Where applicable, the parent group of the subgroup;</li>
                        <li>The person who added the fabric group to LOGACer;</li>
                        <li>A description of the fabric group, which may vary in length and structure;</li>
                        <li>Where applicable, the various existing subgroups;</li>
                        <li>An origin (which may also be entered as free text);</li>
                        <li>The bibliography;</li>
                        <li>Information on how to cite the page correctly.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_3.png" width="80%"></div>-->
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>IV. Bibliography</h2>
        <p>As mentioned elsewhere, bibliographic references can be provided for a range of elements: archaeological operation, site-horizon, context, regional horizon, typology, type or fabric group. The bibliography functionality is fairly basic, but references can be viewed in LOGACer.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. List of bibliographic references</h3>
            <p>The list of bibliographic references can be accessed from the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>It is organised alphabetically by abbreviation.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Viewing a reference</h3>
            <p>You can view a reference by clicking on it wherever it is displayed. This allows you to see the full reference, as well as the database elements linked to it.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In some cases, page numbers have been specified. They are available both on the page of the relevant element and on the reference page.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>V. Other elements</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. List of downloadable files</h3>
            <p>A list of downloadable files can be accessed from the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>These are files that are not linked to any particular element (archaeological operation, site-horizon, context, regional horizon, etc.), but are of a general nature and have been deemed useful to share. To download a file, simply click on it.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citing a page</h3>
            <p>Each page describing an element in the database includes a suggested citation format for referencing that element in the bibliography. Numerous examples are provided elsewhere in this tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Information about the website</h3>
            <p>This information is mainly available through "Support and information" in the top navigation bar.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>These tabs contain:</p>
            <ul>
                <li>A more detailed presentation of LOGACer under "Overview and contacts";</li>
                <li>A contact form for the administrator in the same tab;</li>
                <li>Information about the infrastructure of which LOGACer is part, under "Associated tools", including complementary developments such as ONICer and DBCer.</li>
            </ul>
            <p>Other pages can be accessed at the bottom of each page:</p>
            <ul>
                <li>Legal notices and the data management policy, which are required for every website;</li>
            </ul>
        </section>


    <section id="compte-utilisateur" class="mb-5">
    <h2>VI. User accounts</h2>
        <section id="enregistrement-connexion" class="mb-5">
        <h3>1. Registration and login</h3>
            <h4>1.1. Creating an account</h4>
            <p>To access features reserved for registered users, you need a LOGACer account. You can log in from the general navigation bar by clicking on "Log in".</p>
            <p>From the login page, new users can access the registration form by clicking on "Register here!".</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_4.png" width="80%"></div>-->
            <p>The registration form asks for the following information:</p>
            <ul>
                <li>A username;</li>
                <li>An email address;</li>
                <li>A password, which must be confirmed;</li>
                <li>First name and surname (optional).</li>
            </ul>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_5.png" width="80%"></div>-->
            <p>After the form has been submitted, the account must be approved by a LOGACer administrator before it can be used. Users are notified of this approval by email. Remember to check your spam folder. If approval is delayed, you can contact the installation administrator.</p>
            <h4>1.2. First login</h4>
            <p>Once the account has been approved, an email provides the information needed to activate it.</p>
            <p>For the first login, you must use the activation key received by email instead of the password set during registration.</p>
            <p>Once this first login has been completed, users can access the LOGACer features corresponding to their permissions.</p>
            <p>If you enter the wrong password several times, your account will be locked. You will then need to contact the administrator to have it unlocked. This will allow you to log in using a new activation key and set a new password.</p>
            </section>

        <section id="gestion-compte" class="mb-5">
        <h3>2. Account management</h3>
        <p>When a user is logged in, their name appears in the navigation bar. A drop-down menu provides access to account management and the option to log out.</p>
            <h4>2.1. My account</h4>
            <p>The "My account" section allows users to view and edit their personal information:</p>
            <ul>
                <li>Username;</li>
                <li>Email address;</li>
                <li>Password;</li>
                <li>First name and surname.</li>
            </ul>
            <p>To change the password, enter the new password and confirm it. If no new password is entered, the current password is retained.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_6.png" width="80%"></div>-->
            <p>This page also allows users to customise certain display settings:</p>
            <ul>
                <li><b>Counting methods:</b> selection of the counting methods to display in inventories, from among those used in the data being consulted;</li>
                <li><b>Simplified mode:</b> enables a display with contextual help, particularly in the form of tooltips, to make LOGACer easier to understand and use.</li>
            </ul>
            <p>Changes must be saved to take effect.</p>
            <h4>2.2. Logging out</h4>
            <p>To end a session, simply select "Log out" from the drop-down menu associated with your name in the navigation bar.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
