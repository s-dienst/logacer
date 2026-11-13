<?php $return_list = "<p><a href='" . create_url(['']) . "'>Retourner à la page d'accueil</a></p>";
$tuto_button = ""; ?>
    <!-- Barre latérale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['']); ?>'>Retour à la page d'accueil</a></h6><br>
        <h4 class="px-3">Principes et navigation</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principes de base</h5></a>
        <a href="#navigation-generale"><h5 class="px-3">II. Navigation générale</h5></a>
            <a href="#projets">1. Projets</a>
            <a href="#typologies-globales">2. Typologies et groupes de pâtes</a>
            <a href="#espace-personnel">3. Espace personnel</a>
            <a href="#referentiels">4. Référentiels</a>
            <a href="#gestion-utilisateurs">5. Gestion des utilisateurs</a>
        <a href="#types-pâtes"><h5 class="px-3">III. Types et groupes de pâtes</h5></a>
            <a href="#typologies-types">1. Typologies et types</a>
            <ul>
                <li><a href="#liste-typologies">Liste des typologies</a></li>
                <li><a href="#typologie">Description de la typologie</a></li>
                <li><a href="#types">Description des types</a></li>
            </ul>
            <a href="#pâtes">2. Groupes de pâtes</a>
            <ul>
                <li><a href="#liste-groupes-pâtes">Liste des groupes de pâges</a></li>
                <li><a href="#groupes-pâtes">Description des groupes de pâtes</a></li>
            </ul>
        <a href="#bibliographie"><h5 class="px-3">IV. Bibliographie</h5></a>
            <a href="#liste-bibliographie">1. Liste des références</a>
            <a href="#consulter-bibliographie">2. Consulter une référence</a>
        <a href="#autres-éléments"><h5 class="px-3">V. Autres éléments</h5></a>
            <a href="#fichiers-génériques">1. Fichiers génériques</a>
            <a href="#citer-page">2. Citer une page</a>
            <a href="#a-propos">3. A propos du site web</a>
        <a href="#compte-utilisateur"><h5 class="px-3">VI. Comptes utilisateurs</h5></a>
            <a href="#enregistrement-connexion">1. Enregistrement et connexion</a>
            <a href="#gestion-compte">2. Gestion du compte</a>
    </nav>

    
  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutoriel : principes de base et navigation dans l'outil sans connexion</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principes de base</h2>

    <p>L’objectif central de LOGACer est de permettre la mise à disposition des inventaires d’objets (en particulier, de céramique), tout en permettant d’incorporer d’autres informations et d’exécuter des requêtes sur ces objets. Pour ce faire, LOGACer repose sur différents éléments :</p>
    <ul>
        <li>La mise en contexte de l’<b>objet</b> : c’est la partie centrale de LOGACer. L’objet fait partie d’un <b>contexte</b> (ou unité stratigraphique), elle-même liée à d’autres contextes contemporains (l’<b>horizon-site</b>), le tout ayant été récolté lors d’une <b>opération archéologique</b> ;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>La chronologie relative de l’objet : les horizons-sites peuvent être regroupés en <b>horizons régionaux</b>. Ceux-ci se succèdent au sein d’une région géographiques ; cette succession est regroupée via des <b>groupes d’horizons</b> ;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>La caractérisation de l’objet : la céramique est classée, selon le modèle conservé dans LOGACer, selon sa <b>catégorie</b>, sa <b>fonction</b>, son <b>type</b> et son <b>groupe de pâtes</b>. Les deux premiers critères de classification sont assez standardisés et limités. Les types en revanche sont beaucoup plus nombreux, regroupés en <b>typologies</b> ; il en va de même pour les groupes de pâtes, qui peuvent être hiérarchisés. La caractérisation des types et groupes de pâtes et la possibilité de faire des recherches sur ceux-ci est également important. Les catégories, fonctions, typologies et types sont largement liés à ONICer ;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>Les références : il est possible de compléter la caractérisation de ces différents éléments en référençant une <b>bibliographie</b> de référence ou en ajoutant des <b>fichiers</b>. Par ailleurs, ces éléments sont gérés par des <b>utilisateurs</b> (responsables ou contributeurs dans certains cas). Enfin, les objets peuvent s’accompagner d’<b>illustrations</b> comme des dessins, photographies ou agrandissements ;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>La collaboration : une équipe qui travaille sur différents de ces éléments (sites, horizons régionaux…) peuvent les retrouver rattachés au sein de <b>projets</b> permettant une meilleure gestion des droits de cette équipe.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>
   </section>


    <section id="navigation-generale" class="mb-5">
    <h2>II. Navigation générale</h2>
    <p>En dehors des espaces propres à chaque projet, LOGACer dispose d'un espace général permettant de consulter les projets disponibles, d'accéder aux référentiels communs et de gérer les éléments liés à l'ensemble de l'installation.</p>
    <p>La navigation s'organise autour de deux barres :</p>
    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_1.png" width="80%">Les deux barres de navigation de LOGACer : navigation générale (en haut) et espace personnel (en dessous).</div>-->
        <h3>1. Barre de navigation générale</h3>
        <p>La barre supérieure donne accès aux principales ressources communes à l'ensemble de l'installation LOGACer.</p>
            <h4>1.1. Projets</h4>
            <p>La rubrique « Projets » présente la liste des projets disponibles, accompagnés d'une courte description et d'un lien permettant d'accéder à leur espace respectif.</p>
            <p>Les projets publics sont accessibles à tous les visiteurs, qu'ils disposent ou non d'un compte utilisateur. Les projets privés ne sont pas affichés dans cette liste, sauf pour les utilisateurs qui y contribuent.</p>
            <h4>1.2. Typologies et groupes de pâtes</h4>
            <p>Les rubriques « Typologies » et « Groupes de pâtes » donnent accès aux référentiels généraux de LOGACer, indépendants des différents projets.</p>
            <p>Les pages descriptives des typologies et des groupes de pâtes fonctionnent de manière similaire à celles disponibles au sein des projets. Toutefois, les informations relatives aux objets archéologiques ne sont pas accessibles depuis cet espace général. En particulier, les pages des types et des groupes de pâtes ne présentent pas les distributions géographiques, les illustrations, les groupes de pâtes ou types associés, les inventaires et les correspondances disponibles dans les projets.</p>
            <h4>1.3. Annexes</h4>
            <p>La rubrique « Annexes » donne accès à deux ressources communes :</p>
            <ul>
                <li><b>Bibliographie :</b> liste des références bibliographiques enregistrées dans LOGACer. Leur consultation est décrite dans la section IV. Bibliographie ;</li>
                <li><b>Fichiers génériques :</b> liste des fichiers mis à disposition indépendamment d'un élément particulier de la base de données. Leur consultation est décrite dans la section V. Autres éléments.</li>
            </ul>
        <h3>2. Espace personnel</h3>
        <p>La seconde barre de navigation donne accès aux fonctionnalités liées au compte de l'utilisateur et à ses propres contributions dans LOGACer.</p>
            <h4>2.1. Mon espace personnel</h4>
            <p>Cette rubrique regroupe différentes informations et fonctionnalités relatives au compte de l'utilisateur. Les principales fonctionnalités sont également accessibles depuis d'autres pages de l'application.</p>
            <h4>2.2. Mes projets, mes types et mes groupes de pâtes</h4>
            <p>Ces rubriques permettent de retrouver les projets, types et groupes de pâtes pour lesquels l'utilisateur intervient en tant que créateur, responsable ou contributeur.</p>
            <p>Elles offrent ainsi un accès direct aux éléments auxquels l'utilisateur est associé, sans devoir parcourir les listes générales de LOGACer.</p>
            <h4>2.3. Référentiels</h4>
            <p>La rubrique « Référentiels » regroupe les listes de référence utilisées dans LOGACer :</p>
            <ul>
                <li><b>Pays et régions :</b> liste des pays et de leurs subdivisions régionales, avec leurs codes et noms officiels ;</li>
                <li><b>Catégories :</b> liste des catégories utilisées pour caractériser les objets. Le tableau indique leur code, leur abréviation, leur nom, leur éventuelle présence dans ONICer et leur créateur dans LOGACer ;</li>
                <li><b>Fonctions :</b> liste des fonctions utilisées pour caractériser les objets. Le tableau indique leur code, leur nom, leur éventuelle présence dans ONICer et leur créateur dans LOGACer ;</li>
                <li><b>Méthodes de comptage :</b> liste des méthodes de comptage prises en compte dans LOGACer.</li>
            </ul>
            <p>Les contributeurs et les administrateurs peuvent créer et gérer les référentiels généraux (à l'exception des méthodes de comptage). Les utilisateurs simples disposent uniquement d'un accès aux autres fonctionnalités qui leur sont autorisées.</p>
            <h4>2.4. Gérer les utilisateurs</h4>
            <p>Cette rubrique est réservée aux administrateurs de LOGACer. Elle permet de :</p>
            <ul>
                <li>Valider les nouvelles inscriptions ;</li>
                <li>Consulter la liste des utilisateurs enregistrés ;</li>
                <li>Modifier les droits généraux des utilisateurs dans LOGACer, en leur attribuant le statut d'administrateur, de contributeur ou d'utilisateur simple ;</li>
                <li>Supprimer un compte utilisateur lorsque cela est nécessaire.</li>
            </ul>
            <p>Ces droits généraux sont distincts des droits attribués aux utilisateurs au sein des différents projets.</p>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>III. Types et groupes de pâtes</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologies et types</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Liste des typologies</h4>
                <p>La liste est classée par catégorie à laquelle la typologie est rattachée. Certaines typologies sont rattachées à plusieurs catégories, et apparaissent pour chacune d’entre elles. Les typologies qui n’ont pas été rattachées à au moins une catégorie (et ne sont donc pas utilisables pour lier des objets) sont regroupées en fin de liste.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Description de la typologie</h4>
                <p>Quand vous cliquez sur une typologie, vous arrivez à sa page descriptive. Cette page contient en premier lieu des informations sur :</p>
                <ul>
                    <li>La personne qui a ajouté la typologie à LOGACer et les contributeurs qui peuvent alimenter la page ;</li>
                    <li>Un descriptif de la typologie, pouvant être de longueur et d’une organisation variable ;</li>
                    <li>Les références bibliographiques liées à la typologie ;</li>
                    <li>Les fichiers associés à la typologie ;</li>
                    <li>Les informations pour citer correctement la page.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>L’onglet « Catégories » dresse la liste des catégories pour lesquelles la typologie (et donc ses types) est utilisable.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>L’onglet « Types » liste, par ordre alphabétique des codes, la liste des types associés à la typologie. Si certains types ont des sous-types, ces derniers n’apparaissent pas ici.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Les types</h4>
                <p>Quand vous sélectionnez un type via une typologie, vous avez accès uniquement aux informations générales, à l'inverse d'une navigation au sein d'un projet :</p>
                    <ul>
                        <li>La typologie à laquelle appartient le type (et éventuellement le type principal du sous-type) ;</li>
                        <li>La personne qui a ajouté la typologie à LOGACer ainsi que celle qui a rajouté le type ;</li>
                        <li>Un descriptif du type, pouvant être de longueur et d’une organisation variable ;</li>
                        <li>Le cas échéant, les différents sous-types présents ;</li>
                        <li>Une datation (également sous forme libre) ;</li>
                        <li>La bibliographie ;</li>
                        <li>Les informations pour citer correctement la page.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_2.png" width="80%"></div>-->
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Groupes de pâtes</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Liste des groupes de pâtes</h4>
                <p>La liste n’est pour l’instant pas classée. Si certains groupes de pâtes ont des sous-groupes, ces derniers n’apparaissent pas ici.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Les groupes de pâtes</h4>
                <p>Quand vous sélectionnez un groupe de pâtes (via la liste des groupes ou depuis un inventaire), vous avez accès à diverses informations générales :</p>
                    <ul>
                        <li>Éventuellement le groupe principal du sous-groupe ;</li>
                        <li>La personne qui a ajouté le groupe de pâtes à LOGACer ;</li>
                        <li>Un descriptif du groupe de pâtes, pouvant être de longueur et d’une organisation variable ;</li>
                        <li>Le cas échéant, les différents sous-groupe présents ;</li>
                        <li>Une origine (également sous forme libre) ;</li>
                        <li>La bibliographie ;</li>
                        <li>Les informations pour citer correctement la page.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_3.png" width="80%"></div>-->
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>IV. Bibliographie</h2>
        <p>Comme indiqué ailleurs, il est possible d’indiquer des références bibliographiques pour une série d’éléments : opération archéologique, horizon-site, contexte, horizon régional, typologie, type ou groupe de pâtes. Celle-ci est assez sommaire, mais consultable dans LOGACer.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Liste des références bibliographiques</h3>
            <p>La liste des références bibliographiques est accessible via le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>Elle est classée par ordre alphabétique des abréviations.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Consulter une référence</h3>
            <p>Vous pouvez consulter une référence en cliquant dessus à l’endroit où elle est affichée. Vous pouvez ainsi voir la référence complète, ainsi que les éléments de la base de données qui sont liés.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>Dans certains cas, une numérotation de page a été indiquée. Elle est disponible sur la page de l’élément comme sur celle de la référence.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>V. Autres éléments</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Liste des fichiers téléchargeables</h3>
            <p>Une liste de fichiers téléchargeables est accessible via le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Y sont téléchargeables des fichiers qui ne sont pas liés à un élément en particulier (opération archéologique, horizon-site, contexte, horizon régional…) mais ont un caractère général et ont été jugés utiles à partager. Le téléchargement se fait simplement en cliquant dessus.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citer une page</h3>
            <p>Sous chaque page décrivant un élément de la base de donnée,s un modèle de citation est proposé pour faire référence à cet élément dans la bibliographie. De nombreux exemples sont indiqués ailleurs dans ce tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informations à propos du site web</h3>
            <p>Ces informations sont principalement disponibles via « Support et infos » dans le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Ces onglets comportent :</p>
            <ul>
                <li>Une présentation plus poussée de LOGACer dans « Présentation et contacts » ;</li>
                <li>Un formulaire de contact pour l’administrateur dans ce même onglet ;</li>
                <li>L’infrastructure dans laquelle s’inscrit LOGACer dans outils associés, notamment les développements complémentaires (comme ONICer et DBCer).</li>
            </ul>
            <p>D’autres pages sont accessibles en bas de chaque page :</p>
            <ul>
                <li>Les mentions légales et la politique de gestion des données, nécessaires pour chaque site web ;</li>
            </ul>
        </section>


    <section id="compte-utilisateur" class="mb-5">
    <h2>VI. Comptes utilisateurs</h2>
        <section id="enregistrement-connexion" class="mb-5">
        <h3>1. Enregistrement et connexion</h3>
            <h4>1.1. Créer un compte</h4>
            <p>Pour accéder aux fonctionnalités réservées aux utilisateurs enregistrés, il est nécessaire de disposer d'un compte LOGACer. La connexion est accessible depuis la barre de navigation générale, en cliquant sur « Se connecter ».</p>
            <p>Depuis la page de connexion, les nouveaux utilisateurs peuvent accéder au formulaire d'enregistrement en cliquant sur « Enregistrez-vous ici ! ».</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_4.png" width="80%">Page de connexion et accès au formulaire d'enregistrement.</div>-->
            <p>Le formulaire d'enregistrement demande les informations suivantes :</p>
            <ul>
                <li>Un identifiant ;</li>
                <li>Une adresse e-mail ;</li>
                <li>Un mot de passe, à confirmer ;</li>
                <li>Le prénom et le nom de famille (facultatifs).</li>
            </ul>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_5.png" width="80%">Formulaire d'enregistrement d'un nouvel utilisateur.</div>-->
            <p>Après validation du formulaire, le compte doit être approuvé par un administrateur de LOGACer avant de pouvoir être utilisé. L'utilisateur est informé de cette validation par courrier électronique. Pensez à vérifier votre dossier de courriers indésirables. Si la validation tarde, vous pouvez contacter l'administrateur de l'installation.</p>
            <h4>1.2. Première connexion</h4>
            <p>Une fois le compte validé, un courrier électronique fournit les informations nécessaires à son activation.</p>
            <p>Lors de la première connexion, il faut utiliser la clé d'activation reçue par courrier électronique à la place du mot de passe défini lors de l'inscription.</p>
            <p>Une fois cette première connexion effectuée, l'utilisateur peut accéder aux fonctionnalités de LOGACer correspondant à ses droits.</p>
            <p>Si vous vous trompez plusieurs fois de mot de passe, votre compte sera bloqué ; il vous faudra alors contacter l'administrateur pour débloquer votre compte, ce qui vous permettra de vous connecter avec une nouvelle clé d'activation et de définir un nouveau mot de passe.</p>
            </section>

        <section id="gestion-compte" class="mb-5">
        <h3>2. Gestion du compte</h3>
        <p>Lorsqu'un utilisateur est connecté, son nom apparaît dans la barre de navigation. Un menu déroulant permet notamment d'accéder à la gestion de son compte et de se déconnecter.</p>
            <h4>2.1. Mon compte</h4>
            <p>La rubrique « Mon compte » permet de consulter et de modifier ses informations personnelles :</p>
            <ul>
                <li>Identifiant ;</li>
                <li>Adresse e-mail ;</li>
                <li>Mot de passe ;</li>
                <li>Prénom et nom de famille.</li>
            </ul>
            <p>Pour modifier le mot de passe, il faut renseigner le nouveau mot de passe et le confirmer. Si aucun nouveau mot de passe n'est indiqué, le mot de passe actuel est conservé.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_6.png" width="80%">Page de gestion du compte personnel.</div>-->
            <p>Cette page permet également de personnaliser certains paramètres d'affichage :</p>
            <ul>
                <li><b>Méthodes de comptage :</b> choix des méthodes de comptage à afficher dans les inventaires, parmi celles utilisées dans les données consultées ;</li>
                <li><b>Mode simplifié :</b> activation d'un affichage proposant des aides contextuelles, notamment sous forme d'infobulles, pour faciliter la compréhension et l'utilisation de LOGACer.</li>
            </ul>
            <p>Les modifications doivent être enregistrées pour être prises en compte.</p>
            <h4>2.2. Se déconnecter</h4>
            <p>Pour terminer sa session, il suffit de sélectionner « Se déconnecter » dans le menu déroulant associé à son nom dans la barre de navigation.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
