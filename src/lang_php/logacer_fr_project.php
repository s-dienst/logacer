            <h2>LOGACer : un outil open-source pour la gestion et l'analyse du mobilier archéologique</h2>
            <br>
            <p>Le <b>Logiciel Online pour la Gestion et l'Analyse de la Céramique</b> a été conçu, sous le nom de DBCer, dans le cadre de la thèse « Étude chronologique, économique et culturelle de la vaisselle du <i>Piano della Civita</i> à Artena (Latium) depuis la République romaine jusqu’à l’Antiquité tardive » (S. Dienst, 2024 - disponible sur <a href="https://hdl.handle.net/2268/318966">ORBi</a>). Son objectif initial était de structurer et partager les données de cette recherche sous un format pleinement exploitable par la communauté scientifique, dans un principe d’Open Science et Open Access.</p>
            <p>La classification et la mise à disposition de données archéologiques représente un enjeu majeur. LOGACer permet non seulement de partager ces données, mais également de croiser les informations issues de différentes équipes de recherche collaborant autour d'une problématique commune. Nous souhaitons ainsi rendre cet outil accessible à tous les chercheurs souhaitant partager leurs données sur l’<i>instrumentum</i>, en particulier la céramique et le verre.</p>
            <br>

            <h2>Principes de mise en oeuvre</h2>
            <br>
            <p>LOGACer repose sur les principes clés suivants :</p>
            <ul style="text-align:left;">
                <li><b>Collaboration et reviewing :</b> Le logiciel favorise la collaboration entre chercheurs sur des projets communs. Dans une version ultérieure, il permettra également aux utilisateurs de commenter, voire de proposer des corrections sur les données publiées par d'autres.</li>
                <li><b>Confidentialité des données :</b> Bien que LOGACer encourage le partage des données dans une optique d’Open Access, il respecte le besoin des utilisateurs de garder leurs données privées jusqu'à ce qu'elles soient finalisées, publiées ou indéfiniment. Différents niveaux de confidentialité et de partage sont présents notamment sur les opérations archéologiques, horizons-sites et contextes ainsi que concernant les horizons régionaux.</li>
                <li><b>Chronologie :</b> La chronologie est déterminée au niveau des sites par des phases ou horizons-sites, et différents horizons-sites peuvent être regroupés en horizons régionaux.</li>
                <li><b>Interopérabilité :</b> Les données doivent être comparables et pouvoir être croisées entre elles. Les recherches par types, pâtes ou d'autres critères pertinents sont possibles afin d'interroger l’ensemble des données (soit rendues publiques ou accessibles à l'utilisateur).</li>
                <!--<li><b>Adaptativité :</b> Les méthodes et référentiels utilisés par différents chercheurs peuvent varier. Par ailleurs, la mise en ligne d’anciennes données peut s’appuyer sur des référentiels antérieurs. Nous souhaitons permettre à tout le monde de pouvoir publier les données de la meilleure façon qu’il souhaite, sans restreindre les appellations. Ce principe est en tension avec celui d’interopérabilité, et des solutions sont recherchées pour pallier ce souci. Elles passeront par des possibilités de personnalisation de l’expérience utilisateur. </li>-->
                <li><b>Facilité d’utilisation :</b> Malgré la complexité technique, LOGACer tente de rester accessible à un utilisateur débutant. Les bases de son utilisation doivent pouvoir être maîtrisées en moins d'une heure, avec des garde-fous pour évviter des erreurs de manipulation.</li>
            </ul>
            <br>

            <h2>Infrastructure technique</h2>
            <br>
            <p>Une première version de LOGACer (DBCer version 1) utilisait le framework Django avec une base de données SQLite. La version actuelle repose sur PHP et JavaScript (avec AJAX), interrogeant une base de données MySQL. Les bibliothèques utilisées incluent Bootstrap pour la mise en page, Leaflet pour la cartographie, Altorouter pour le routing et PhpSpreadsheet pour la gestion des fichiers Excel.</p>
            <p>Le logiciel est constitué de plusieurs parties ou "modules" :</p>
            <ul style="text-align:left;">
                <li><b>Déjà disponibles</b></li><ul>
                <li><b>Structure de base :</b> gestion des opérations archéologiques ou sites, des horizons-sites ou phases, des contextes et des objets. Inclut la gestion des utilisateurs, l'ajout d'illustration, de fichiers et de bibliographie, ainsi que des outils de consultation, d'importation et d'exportation de données et une cartographie basique.</li>
                <li><b>Chronologie par horizons :</b> Définition des horizons régionaux auxquels sont reliés des horizons-sites, avec des degrés de connexion variable.</li>
                <li><b>Référentiels :</b> Intégration des concepts de catégorie, groupe de pâtes, fonction et type, descriptibles et consultables, avec des contraintes logiques (ex. : lien entre types et catégories).</li>
                <li><b>Revue de la littérature :</b> Possibilité d'indiquer clairement quand des données reprises de publications d'autres auteurs (et retravaillées). Les données éditées du mobilier peuvent être ajoutées en plus des données retravaillées.</li>
                </ul><li><b>En cours d'implémentation</b></li><ul>
                <li><b>Horizons avancés :</b> Type de lien entre horizons régionaux et types présents, avec des outils de sériation et d'analyse factorielle des correspondances (AFC). Comparaison entre une phase/horizon-site/contexte et un groupe d'horizons.</li>
                </ul><li><b>Déjà prévus</b></li><ul>
                <li><b>Pâtes avancé :</b> Ajout d'études de pâtes directement dans la base, avec indication des protocoles et outils de statistiques simples (ACP, dendrogramme).</li>
                <li><b>Graphiques :</b> Affichage de graphiques utiles pour la publication ou la comparaison des données (uni- ou bi-variés, par contextes/horizons-sites/opérations archéologiques).</li>
                <li><b>Cartographie avancée :</b> Amélioration de l'affichage cartographique, avec visualisation des distributions quantitatives de mobilier et filtrage/distinction par critères.</li>
                <li><b>Référentiels - uniformisation :</b> Détection des éléments similaires et modifications groupées pour aider à l'uniformisation des données hétérogènes.</li>
                <li><b>Autre fonctionnalités :</b> Il est prévu de rajouter des possibilités en ce qui concerne le multilinguisme, l'ajout de commentaires, gestion de la bibliographique, ainsi que l'opérabilité (avec des points d'entrée et sorties) des données aisées pour l'usage d'autres logiciels plus spécialisés... Tout cela en fonction des besoins des utilisateurs et du temps disponible pour le développement.</li>
            </ul></ul>          
            <br>

            <h2>Implémenter LOGACer pour votre propre projet</h2>
            <br>
            <p>LOGACer est protégé par une licence CC BY-NC, qui autorise la réutilisation de son code, sa modification et son implémentation par d'autres équipes. Le code-source est disponible moyennant une demande à l'administrateur (via le <a href="https://www.logacer.org/about_us#contact" target="_blank">formulaire de contact</a>).</p>
            <p>Si vous souhaitez déployer LOGACer pour votre projet, nous pouvons :<p>
            <ul style="text-align:left;">
                <li>Vous fournir gratuitement les éléments nécessaires pour une implémentation locale par votre service informatique, sans paramétrage spécifique (autre que le nom et les pages de présentation) ;</li>
                <li>Paramétrer l'outil ou ajouter des fonctionnalités (moyennant une participation financière permettant de faire vivre le projet) pour l'implémentation de l'outil ;</li>
                <li>Proposer l'implémentation de l'outil pour votre usage sur un serveur externe (une participation financière sera également nécessaire pour financer l'installation et les coûts d'hébergement).</li>
            </ul>
            <p>Peu importe votre situation, si LOGACer vous intéresse, n'hésitez pas à nous <a href="https://www.logacer.org/about_us#contact" target="_blank">contacter</a> pour en discuter !</p>
