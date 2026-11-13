    <!-- Barre latérale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Retour : Liste des tutoriaux</a></h6><br>
        <h4 class="px-3">Principes et navigation</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principes de base</h5></a>
        <a href="#opération-objet"><h5 class="px-3">II. De l'opération à l'objet</h5></a>
        <a href="#liste-opérations">1. Liste des opérations</a>
        <a href="#opération-archéologique">2. Opération archéologique</a>
        <a href="#horizon-site">3. Horizon-site</a>
        <a href="#contexte-inventaire">4. Contexte et inventaire</a>
        <a href="#objet-illustration">5. Objet et illustration(s)</a>
        <a href="#horizons-régionaux"><h5 class="px-3">III. Horizons régionaux</h5></a>
        <a href="#liste-groupes-horizons">1. Liste des groupes d'horizons</a>
        <a href="#groupe-horizons">2. Description du groupe d'horizons</a>
        <a href="#horizon-régional">3. Horizons régionaux et mobilier lié</a>
        <a href="#types-pâtes"><h5 class="px-3">IV. Types et groupes de pâtes</h5></a>
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
        <a href="#bibliographie"><h5 class="px-3">V. Bibliographie</h5></a>
        <a href="#liste-bibliographie">1. Liste des références</a>
        <a href="#consulter-bibliographie">2. Consulter une référence</a>
        <a href="#autres-éléments"><h5 class="px-3">VI. Autres éléments</h5></a>
        <a href="#fichiers-génériques">1. Fichiers génériques</a>
        <a href="#citer-page">2. Citer une page</a>
        <a href="#a-propos">3. A propos du site web</a>
        <a href="#recherche-simple">4. Recherche simple</a>
        <a href="#enregistrement-connexion">5. Enregistrement et connexion</a>
    </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutoriel : principes de base et navigation dans l'outil sans connexion</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principes de base</h2>

    <p>L’objectif central de LOGACer, utilisé par CeVICA est de permettre la mise à disposition des inventaires d’objets (en particulier, de céramique), tout en permettant d’incorporer d’autres informations et d’exécuter des requêtes sur ces objets. Pour ce faire, LOGACer repose sur différents éléments :</p>
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

    <p>La navigation est prévue pour privilégier l’approche contextuelle (de l’opération archéologique à l’objet), mais également pour tenir compte de ces divers liens : présentation des objets par horizons régionaux, types et groupes de pâtes (ainsi que leurs illustrations), présentation des horizons-sites par horizons régionaux (avec les catégories et types présents), éléments liés à une référence bibliographie ainsi que des requêtes plus élaborées.</p>
    </section>

    <section id="opération-object" class="mb-5">
    <h2>II. Navigation : de l’opération archéologique à l’objet</h2>
        <section id="liste-opérations" class="mb-5">
        <h3>1. Liste des opérations archéologiques</h3>

            <p>La liste des opérations archéologiques est accessible via le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_1.png" width="80%"></div>
            <p>Au sein de cette liste, l’opération qui vous intéresse peut être atteinte par une carte interactive ou par la liste des opérations archéologiques.

            <h4>1.1. Carte</h4>
                <p>Chaque opération archéologique est représentée par un marqueur au sein de la carte. En cliquant sur le marqueur, vous pouvez voir de quelle opération archéologique il s’agit. Vous pouvez y accéder en cliquant dessus.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2.png" width="80%"></div>
                <p>Si plusieurs opérations archéologiques ont les mêmes coordonnées, elles s’affichent sur le même marqueur.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_3.png" width="80%"></div>
                <p>Enfin, si une zone contient beaucoup d’opérations archéologiques, un disque de couleur apparaît à la place avec le nombre d’opérations présentes dans cette zone. En cliquant dessus, il est possible de zoomer et de subdiviser ce marqueur en plusieurs autres disques et/ou marqueurs individuels. Il est également possible de zoomer normalement.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2b.png" width="80%"></div>

            <h4>1.2. Liste des opérations archéologiques</h4>
                <p>En cliquant sur l’onglet correspondant, vous pouvez également accéder à un tableau synthétique des opérations archéologiques.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_4.png" width="80%"></div>
                <p>Le tableau est classé par pays, puis par région. Les opérations archéologiques sont affichées par ordre alphabétique de code. Celles n’ayant pas été ajoutées à une région sont regroupées en fin de liste. En cliquant sur les intitulés de colonnes, il est possible de trier ce tableau selon celle-ci (par ordre alphabétique croissant, puis décroissant en cliquant une seconde fois).</p>
                <p>Il est enfin possible de filtrer le tableau selon un ou plusieurs champs. Les filtres s’affichent en cliquant sur « Afficher les filtres du tableau ». Il suffit ensuite de rentrer une partie du contenu d’un champ pour filtrer le tableau.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
        </section>

        <section id="opération-archéologique" class="mb-5">
        <h3>2. Description de l’opération archéologique</h3>
            <p>Quand vous cliquez sur une opération archéologique, vous arrivez à sa page descriptive. Cette page contient des informations sur :</p>
            <ul>
                <li>La personne qui a ajouté l’opération à CeVICA et les contributeurs qui peuvent alimenter la page ;</li>
                <li>Les informations géographiques : région, latitude et longitude ;</li>
                <li>Un descriptif de l’opération archéologique, pouvant être de longueur et d’une organisation variable ;</li>
                <li>Les différents horizons-sites présents. Quand des contextes n’ont pas été ajoutés à un horizon-site, ils sont atteignables en cliquant sur « Contextes sans horizon-site » ;</li>
                <li>Les références bibliographiques liées à l’opération archéologique ;</li>
                <li>Les fichiers associés à l’opération archéologique ;</li>
                <li>Les informations pour citer correctement la page.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
            <p>Il est possible que certaines de ces parties soient absentes, en fonction de ce qui a été complété ou relié à l’opération archéologique. Pour la bibliographie, si l’opération archéologique (ou l’horizon-site ou le contexte) n’a jamais été publiée, cela est bien indiqué.</p>
            <p>L’un des fichiers, présent automatiquement, permet de télécharger l’ensemble de l’inventaire de l’opération archéologique. Il en va de même pour l’horizon-site et le contexte.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_6.png" width="80%"></div>
            <p>En fonction de ce qui a été indiqué lors de la complétion du site, le fond peut être différent et un cadre peut indiquer qu’il s’agit de données extraites d’une publication. Ces informations permettent de mettre en évidence les cas où l’auteur de la notice n’est pas l’un des chercheurs ayant travaillé sur l’opération archéologique, mais que les données ont été mises en ligne lors d’un travail plus large, dans le cadre d’une revue de la littérature.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_7.png" width="80%"></div>
        </section>

        <section id="horizon-site" class="mb-5">
        <h3>3. Description de l’horizon-site</h3>
            <p>En cliquant sur l’un des horizons-sites, on atteint une nouvelle fenêtre avec les informations suivantes :</p>
            <ul>
                <li>L’opération archéologique à laquelle appartient l’horizon-site ;</li>
                <li>La personne qui a ajouté l’opération à CeVICA ainsi que celle qui a rajouté l’horizon-site ;</li>
                <li>Les informations sur l’horizon régional si l’horizon-site est relié à un horizon régional ;</li>
                <li>Un descriptif de l’horizon-site, pouvant être de longueur et d’une organisation variable ;</li>
                <li>Les différents contextes présents ;</li>
                <li>Les références bibliographiques liées à l’horizon-site (généralement, les mêmes que pour l’opération archéologique, sauf changement explicite par l’auteur de la notice) ;</li>
                <li>Les fichiers associés à l’horizon-site ;</li>
                <li>Les informations pour citer correctement la page.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_8.png" width="80%"></div>
            <p>L’horizon régional est cliquable. L’importance de l’horizon-site pour la définition de l’horizon régional est spécifiée (majeur, mineur, incertain ou inconnu).</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_9.png" width="80%"></div>
        </section>

        <section id="contexte-inventaire" class="mb-5">
        <h3>4. Description du contexte et inventaire</h3>
            <p>En cliquant sur l’un des contextes, on atteint la fenêtre de celui-ci, avec l’inventaire. Les informations sont globalement similaires à celles de la phase, quand elles sont présentes. Un onglet permet de passer de la description à l’inventaire.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_10.png" width="80%"></div>
            <p>Quand il n’y a pas de description, l’inventaire est directement repris sans onglet. Il peut être exporté via le bouton bleu, tout comme au sein des fichiers associés.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11.png" width="80%"></div>
            <p>En cliquant sur le numéro d’inventaire, il est possible d’accéder aux détails de l’objet et à ses illustrations.</p>
            <p>Les catégories, fonctions, types et groupes de pâtes peuvent être répertoriés dans CeVICA. Dans ce cas, la catégorie et la fonction sont indiquées en noir, le type et le groupe de pâtes en bleu (ils est possible de cliquer dessus pour accéder à la notice correspondante). En passant sa souris au-dessus de la catégorie ou du groupe de pâtes, il est possible de voir la dénomination complète.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_12.png" width="80%"></div>
            <p>Si l’un de ces éléments est absent de la base de données, il est indiqué en gris et en plus petit.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13.png" width="80%"></div>
            <p>Il est possible de trier le tableau en cliquant sur les en-têtes de colonne. Il est à noter que les catégories, fonctions, types et groupes de pâtes sont triés en fonction de leur code et non de ce qui est affiché ; les éléments non référencés se retrouvent par ordre alphabétique en bas du classement.</p>
            <p>Il est également possible de filtrer le tableau en cliquant sur l’onglet de filtre, puis en entrant les expressions recherchées. Les catégories, fonctions, types et peuvent également être recherchés en fonction de leur code.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11b.png" width="80%"></div>
            <p>La présence d’une illustration est signalée par un « Oui » dans la case correspondante.</p>
            <p>Par défaut, seules les 200 premières lignes d’inventaire sont récupérées, à des fins de performance. Il est possible de récupérer les lignes supplémentaires (200 par 200) en cliquant sur « Charger plus ».</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13b.png" width="80%"></div>
        </section>

        <section id="objet-illustration" class="mb-5">
        <h3>5. Description de l’objet et illustration(s)</h3>
            <p>En cliquant sur l’objet, les mêmes informations que dans les contextes sont reprises sous la forme d’une liste.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_14.png" width="60%"></div>
            <p>Un onglet permet de consulter les illustrations, s’il y en a pour l’objet. Il est possible d’afficher ces illustrations en plus grand en cliquant dessus.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_15.png" width="80%"></div>
            <p>Une fois l’illustration affichée, il est possible de revenir à l’affichage de base en cliquant à côté ou sur la croix, en haut à droite.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_16.png" width="80%"></div>
        </section>
    </section>

    <section id="horizons-régionaux" class="mb-5">
    <h2>III. Horizons régionaux</h2>
        <section id="liste-groupes-horizons" class="mb-5">
        <h3>1. Liste des groupes d’horizons</h3>
            <p>La liste des horizons régionaux est accessible via le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_17.png" width="80%"></div>
            <p>La liste est classée par pays, puis par région. Les groupes d’horizons sont affichés par ordre alphabétique de code. Quand un groupe d’horizons s’étend sur plusieurs régions, il est présent plusieurs fois. Ceux n’ayant pas été ajoutés à une région sont regroupés en fin de liste.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_18.png" width="50%"></div>
          </section>

        <section id="groupe-horizons" class="mb-5">
        <h3>2. Description du groupe d’horizons</h3>
            <p>Quand vous cliquez sur un groupe d’horizons, vous arrivez à sa page descriptive. Cette page contient des informations sur :</p>
            <ul>
                <li>La personne qui a ajouté le groupe à CeVICA et les contributeurs qui peuvent alimenter la page ;</li>
                <li>Les régions concernées par les horizons ;</li>
                <li>Un descriptif du groupe d’horizons, pouvant être de longueur et d’une organisation variable ;</li>
                <li>Les différents horizons régionaux présents (certains pouvant être divisé, en interne, en sous-horizons) ;</li>
                <li>Les références bibliographiques liées ;</li>
                <li>Les fichiers associés ;</li>
                <li>Les informations pour citer correctement la page.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_19.png" width="80%"></div>
            <p>Il est possible que certaines de ces parties soient absentes, en fonction de ce qui a été complété ou relié à l’opération archéologique. Pour la bibliographie, si l’opération archéologique (ou l’horizon-site ou le contexte) n’a jamais été publiée, cela est bien indiqué.</p>
        </section>

        <section id="horizon-régional" class="mb-5">
        <h3>3. Les horizons régionaux et le mobilier lié</h3>
            <p>Quand vous sélectionnez un horizon (depuis le groupe, une phase ou un inventaire), vous avez accès à diverses informations, et plusieurs onglets.</p>
            <p><b>Important :</b> Quand un horizon a plusieurs sous-horizons, les informations présentes sont celles uniquement lié à l’horizon générique, et non aux sous-horizons.</p>

            <h4>3.1. Informations générales</h4>
                <p>Se retrouvent ici :</p>
                <ul>
                    <li>Le groupe auquel appartient l’horizon régional ;</li>
                    <li>La personne qui a ajouté le groupe d’horizons à CeVICA ainsi que celle qui a rajouté l’horizon régional ;</li>
                    <li>Le nombre d’objets répertoriés (lignes d’inventaire) pour cet horizon.</li>
                </ul>

            <h4>3.2. Description</h4>
                <p>La description comprend :</p>
                <ul>
                    <li>Un descriptif de l’horizon, pouvant être de longueur et d’une organisation variable ;</li>
                    <li>Le cas échéant, les différents sous-horizons présents ;</li>
                    <li>Une datation (également sous forme libre) ;</li>
                    <li>Les horizons-sites constituant l’horizon régional ainsi que leur degré d’importance pour l’horizon ;</li>
                    <li>Les fichiers associés ;</li>
                    <li>Les informations pour citer correctement la page.</li>
                </ul> 
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_20.png" width="80%"></div>

            <h4>3.3. Répartition</h4>
                <p>La répartition présente une carte des différents horizons-sites constituant l’horizon régional. En cliquant sur un marqueur, il est possible de voir le (ou les) horizon(s)-site(s) présents à cet endroit, ainsi que le nombre d’objets appartenant à cet horizon-site.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_21.png" width="80%"></div>

            <h4>3.4. Liste des types</h4>
                <p>Un tableau, qu’il est possible de trier, répertorie l’ensemble des types présents, par catégorie, au sein de l’horizon. Le nombre d’occurrences indique le nombre de lignes d’inventaires correspondant à ce type pour cet horizon.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_22.png" width="80%"></div>
                <p>Il est possible de faire un tri sur le tableau, en tenant compte que pour les catégories et types, c’est le code et non l’abréviation ou le nom qui sont utilisés pour le tri. Il est également possible de filtrer le tableau, avec le menu de filtres affichable en cliquant dessus.</p>

            <h4>3.5. Illustrations</h4>
                <p>Cet onglet contient l’ensemble des illustrations des objets présents dans l’horizon. Il est possible de les trier en fonction de leur type.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_23.png" width="80%"></div>
                <p>Il est possible d’afficher ces illustrations en plus grand en cliquant dessus. Une fois l’illustration affichée, il est possible de revenir à l’affichage de base en cliquant à côté ou sur la croix, en haut à droite.</p>

            <h4>3.6. Inventaire</h4>
                <p>Ce dernier onglet donne l’inventaire complet de l’horizon régional. Il fonctionne de la même façon que pour l’inventaire du contexte, avec en outre les codes des sites, horizons-sites et contextes. Il est possible de cliquer sur ces codes pour atteindre leur notice, ou simplement passer la souris dessus pour voir leur nom.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_24.png" width="80%"></div>
                <p>Le tableau peut être trié et filtré de la même façon que pour l’inventaire du contexte, et est également par défaut limité à 200 lignes d’inventaire.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_25.png" width="80%"></div>
                <p>Les aspects liés aux noms publiés des catégories, fonctions, types et groupes de pâtes quand ils diffèrent de ceux de CeVICA seront ajoutés plus tard (il s’agit d’une fonction pour l’instant inutilisée).</p>
        </section>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>IV. Types et groupes de pâtes</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Typologies et types</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Liste des typologies</h4>
                <p>La liste des typologies est accessible via le bandeau supérieur.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_26.png" width="80%"></div>
                <p>La liste est classée par catégorie à laquelle la typologie est rattachée. Certaines typologies sont rattachées à plusieurs catégories, et apparaissent pour chacune d’entre elles. Les typologies qui n’ont pas été rattachées à au moins une catégorie (et ne sont donc pas utilisables pour lier des objets) sont regroupées en fin de liste.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Description de la typologie</h4>
                <p>Quand vous cliquez sur une typologie, vous arrivez à sa page descriptive. Cette page contient en premier lieu des informations sur :</p>
                <ul>
                    <li>La personne qui a ajouté la typologie à CeVICA et les contributeurs qui peuvent alimenter la page ;</li>
                    <li>Un descriptif de la typologie, pouvant être de longueur et d’une organisation variable ;</li>
                    <li>Les références bibliographiques liées à l’opération archéologique ;</li>
                    <li>Les fichiers associés à l’opération archéologique ;</li>
                    <li>Les informations pour citer correctement la page.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>L’onglet « Catégories » dresse la liste des catégories pour lesquelles la typologie (et donc ses types) est utilisable.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>L’onglet « Types » liste, par ordre alphabétique des codes, la liste des types associés à la catégorie. Si certains types ont des sous-types, ces derniers n’apparaissent pas ici.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. Les types et leur mobilier lié</h4>
                <p>Quand vous sélectionnez un type (via une typologie ou depuis un inventaire), vous avez accès à diverses informations, et plusieurs onglets.</p>
                <p><b>Important :</b> Quand un type a plusieurs sous-types, les informations présentes sont celles uniquement lié au type générique, et non aux sous-types.</p>

                <h5>1.3.1. Informations générales</h5>
                    <p>Se retrouvent ici :</p>
                    <ul>
                        <li>La typologie à laquelle appartient le type (et éventuellement le type principal du sous-type) ;</li>
                        <li>La personne qui a ajouté la typologie à CeVICA ainsi que celle qui a rajouté le type ;</li>
                        <li>Le nombre d’objets répertoriés (lignes d’inventaire) pour ce type.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_31.png" width="80%"></div>

                <h5>1.3.2. Répartition</h5>
                    <p>La répartition est présentée par une carte interactive ou par la liste des opérations archéologiques comportant ce type.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_32.png" width="80%"></div>
                    <p>Tout comme pour la liste des opérations archéologiques, en cliquant sur un marqueur, il est possible de voir les opérations archéologiques ainsi que le nombre de lignes d’inventaire identifiées comme appartenant à ce type.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_33.png" width="80%"></div>
                    <p>La liste des opérations archéologique fonctionne sous forme de tableau, avec les mêmes données. Il est possible d’accéder à l’opération archéologique ou à l’inventaire croisé de l’opération archéologique et du type (en cliquant sur « voir »).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_34.png" width="80%"></div>
                    <p>Le tableau peut être également trié et filtré.</p>

                <h5>1.3.3. Description</h5>
                    <p>La description comprend :</p>
                    <ul>
                        <li>Un descriptif du type, pouvant être de longueur et d’une organisation variable ;</li>
                        <li>Le cas échéant, les différents sous-types présents ;</li>
                        <li>Une datation (également sous forme libre) ;</li>
                        <li>La bibliographie ;</li>
                        <li>Les informations pour citer correctement la page.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_35.png" width="80%"></div>

                <h5>1.3.4. Illustrations</h5>
                    <p>Cet onglet contient l’ensemble des illustrations des objets de ce type. Il est possible de les trier en fonction du type d’illustration.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_36.png" width="80%"></div>
                    <p>Il est possible d’afficher ces illustrations en plus grand en cliquant dessus. Une fois l’illustration affichée, il est possible de revenir à l’affichage de base en cliquant à côté ou sur la croix, en haut à droite.</p>

                <h5>1.3.5. Groupes de pâtes</h5>
                    <p>Cet onglet liste les groupes de pâtes recensés pour ce type. Il est possible de consulter ce groupe de pâtes, ou l’inventaire des objets correspondant au type et au groupe de pâtes sélectionné.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_37.png" width="80%"></div>

                <h5>1.3.6. Inventaire</h5>
                    <p>Ce dernier onglet donne l’inventaire complet du type. Il fonctionne de la même façon que pour l’inventaire du contexte, avec en outre les codes des sites, horizons-sites et contextes. Il est possible de cliquer sur ces codes pour atteindre leur notice, ou simplement passer la souris dessus pour voir leur nom.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_38.png" width="80%"></div>
                    <p>Le tableau peut être trié et filtré de la même façon que pour l’inventaire du contexte, et est également par défaut limité à 200 lignes d’inventaire.</p>

                <h5>1.3.7. Correspondances</h5>
                    <p>Cet onglet, lié aux noms publiés des types quand ils diffèrent de ceux de CeVICA sera décrit plus tard (il s’agit d’une fonction pour l’instant inutilisée).</p>
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Groupes de pâtes</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Liste des groupes de pâtes</h4>
                <p>La liste des groupes de pâtes est accessible via le bandeau supérieur.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_40.png" width="80%"></div>
                <p>La liste n’est pour l’instant pas classée. Si certains groupes de pâtes ont des sous-groupes, ces derniers n’apparaissent pas ici.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. Les groupes de pâtes et leur mobilier lié</h4>
                <p>Quand vous sélectionnez un groupe de pâtes (via la liste des groupes ou depuis un inventaire), vous avez accès à diverses informations, et plusieurs onglets.</p>
                <p><b>Important :</b> Quand un groupe de pâtes a plusieurs sous-groupes, les informations présentes sont celles uniquement lié au groupe générique, et non aux sous-groupes.</p>

                <h5>2.2.1. Informations générales</h5>
                    <p>Se retrouvent ici :</p>
                    <ul>
                        <li>Éventuellement le groupe principal du sous-groupe ;</li>
                        <li>La personne qui a ajouté le groupe de pâtes à CeVICA ;</li>
                        <li>Le nombre d’objets répertoriés (lignes d’inventaire) pour ce groupe de pâtes.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_42.png" width="70%"></div>

                <h5>2.2.2. Répartition</h5>
                    <p>La répartition est présentée par une carte interactive ou par la liste des opérations archéologiques comportant ce groupe de pâtes.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_43.png" width="80%"></div>
                    <p>Tout comme pour la liste des opérations archéologiques, en cliquant sur un marqueur, il est possible de voir les opérations archéologiques ainsi que le nombre de lignes d’inventaire identifiées comme appartenant à ce groupe de pâtes.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_44.png" width="80%"></div>
                    <p>La liste des opérations archéologique fonctionne sous forme de tableau, avec les mêmes données. Il est possible d’accéder à l’opération archéologique ou à l’inventaire croisé de l’opération archéologique et du groupe de pâtes (en cliquant sur « voir »).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_45.png" width="80%"></div>
                    <p>Le tableau peut être également trié et filtré.</p>

                <h5>2.2.3. Description</h5>
                    <p>La description comprend :</p>
                    <ul>
                        <li>Un descriptif du groupe de pâtes, pouvant être de longueur et d’une organisation variable ;
                        <li>Le cas échéant, les différents sous-groupe présents ;
                        <li>Une origine (également sous forme libre) ;
                        <li>La bibliographie ;
                        <li>Les informations pour citer correctement la page.
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_46.png" width="80%"></div>

                <h5>2.2.4. Illustrations</h5>
                    <p>Cet onglet contient l’ensemble des illustrations des objets de ce groupe de pâtes. Il est possible de les trier en fonction du type d’illustration.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_47.png" width="80%"></div>
                    <p>Il est possible d’afficher ces illustrations en plus grand en cliquant dessus. Une fois l’illustration affichée, il est possible de revenir à l’affichage de base en cliquant à côté ou sur la croix, en haut à droite.</p>

                <h5>2.2.5. Types</h5>
                    <p>Cet onglet liste les types recensés pour ce groupe de pâtes. Il est possible de consulter ce type, ou l’inventaire des objets correspondant au type et au groupe de pâtes sélectionné.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_48.png" width="80%"></div>

                <h5>2.2.6. Inventaire</h5>
                    <p>Ce dernier onglet donne l’inventaire complet du groupe de pâtes. Il fonctionne de la même façon que pour l’inventaire du contexte, avec en outre les codes des sites, horizons-sites et contextes. Il est possible de cliquer sur ces codes pour atteindre leur notice, ou simplement passer la souris dessus pour voir leur nom.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_49.png" width="80%"></div>
                    <p>Le tableau peut être trié et filtré de la même façon que pour l’inventaire du contexte, et est également par défaut limité à 200 lignes d’inventaire.</p>

                <h5>2.2.7. Correspondances</h5>
                    <p>Cet onglet, lié aux noms publiés des groupes de pâtes quand ils diffèrent de ceux de CeVICA sera décrit plus tard (il s’agit d’une fonction pour l’instant inutilisée).</p>
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>V. Bibliographie</h2>
        <p>Comme indiqué ailleurs, il est possible d’indiquer des références bibliographiques pour une série d’éléments : opération archéologique, horizon-site, contexte, horizon régional, typologie, type ou groupe de pâtes. Celle-ci est assez sommaire, mais consultable dans CeVICA.</p>

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
    <h2>VI. Autres éléments</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Liste des fichiers téléchargeables</h3>
            <p>Une liste de fichiers téléchargeables est accessible via le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Y sont téléchargeables des fichiers qui ne sont pas liés à un élément en particulier (opération archéologique, horizon-site, contexte, horizon régional…) mais ont un caractère général et ont été jugés utiles à partager. Le téléchargement se fait simplement en cliquant dessus.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citer une page</h3>
            <p>Sous chaque page décrivant un élément de la base de donnée, un modèle de citation est proposé pour faire référence à cet élément dans la bibliographie. De nombreux exemples sont indiqués ailleurs dans ce tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informations à propos du site web</h3>
            <p>Ces informations sont principalement disponibles via « Support et infos » dans le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Ces onglets comportent :</p>
            <ul>
                <li>Une présentation plus poussée de CeVICA dans « Présentation et contacts » ;</li>
                <li>Un formulaire de contact pour l’administrateur dans ce même onglet ;</li>
                <li>La liste des tutoriels disponibles dans « Aides à l’utilisation de CeVICA » ;</li>
                <li>L’infrastructure dans laquelle s’inscrit CeVICA dans outils associés : des développements complémentaires (comme ONICer et DBCer, l’outil LOGACer qu’utilise CeVICA), mais également des outils conseillés pour fonctionner en complément de ceux développés par les Universités de Liège et de Lille.</li>
            </ul>
            <p>D’autres pages sont accessibles en bas de chaque page :</p>
            <ul>
                <li>Les mentions légales et la politique de gestion des données, nécessaires pour chaque site web ;</li>
                <li>En cliquant sur le logo LOGACer, une description du logiciel.</li>
            </ul>
        </section>

        <section id="recherche-simple" class="mb-5">
        <h3>4. Effectuer des recherches</h3>
            <p>Pour le moment, l’outil de recherche est assez simple et consiste en une simple barre de recherche accessible en cliquant sur la loupe, à droite dans le bandeau supérieur.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_58.png" width="80%"></div>
            <p>Vous pouvez ensuite entrer des éléments descriptifs d’un type d’élément et sélectionner ce dernier parmi ceux déjà proposés.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_59.png" width="60%"></div>
            <p>Une liste ou un tableau d’éléments correspondants est enfin affiché.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_60.png" width="80%"></div>
        </section>

        <section id="enregistrement-connexion" class="mb-5">
        <h3>5. S’enregistrer et se connecter</h3>
            <p>L’enregistrement et la connexion seront décrit plus tard, lorsque les outils de collaboration seront entièrement opérationnels.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
