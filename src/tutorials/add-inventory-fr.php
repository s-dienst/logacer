
  <!-- Barre latérale -->
  <nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Retour : Liste des tutoriaux</a></h6><br>
    <h4 class="px-3">Intégration inventaire</h4>
    <a href="#introduction">Introduction</a>
    <h5 class="px-3">I. Depuis l'espace personnel</h5>
    <a href="#bugs-connus">Bugs connus</a>
    <a href="#telecharger-completer-templates">Télécharger et compléter les templates</a>
    <ul>
      <li><a href="#telecharger-template">Télécharger les templates</a></li>
      <li><a href="#contenu-templates">Contenu des templates</a></li>
      <li><a href="#ouvrir-templates">Ouvrir les templates</a></li>
      <li><a href="#completer-enregistrer">Compléter et enregistrer</a></li>
    </ul>
    <a href="#integrer">Intégrer les templates</a>
    <ul>
      <li><a href="#ajouter-template">Ajouter les templates</a></li>
      <li><a href="#ecran-ajout">Écran d'ajout</a></li>
      <li><a href="#corrections">Corrections</a></li>
      <li><a href="#validation">Validation ou abandon</a></li>
    </ul>
    <a href="#longues-integrations">Gérer les longues intégrations</a>
    <ul>
      <li><a href="#pause-integration">Stopper temporairement</a></li>
      <li><a href="#reprendre-upload">Reprendre l'upload</a></li>
    </ul>
    <h5 class="px-3">II. Au sein des pages</h5>
    <h5 class="px-3">III. Intégration manuelle</h5>
  </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutoriel : ajouter des opérations archéologiques, horizons-sites, contextes et de l'inventaire</h1>
    <section id="introduction" class="mb-5">
      <p>L’ajout (et la modification) de sites, phases, contextes et de l’inventaire peut se faire, dans <?php echo WEBSITE_NAME; ?> de plusieurs façons :</p>
      
      <ul>
        <li>Par l’ajout global de données via l’espace personnel ;</li>
        <li>Par l’ajout de données spécifiques à un projet, une opération archéologique ou un contexte dans les pages dédiées ;</li>
        <li>Par l’ajout, la modification et la suppression manuelle de données via les pages d’affichage desdites données.</li>
      </ul>

      <p>Ces différentes façons de procéder sont expliquées ci-dessous.</p>
    </section>

    <h2>I. Intégrer les données depuis l’espace personnel</h2>

      <section id="bugs-connus" class="mb-5">
        <h4>Bugs connus</h4>
        
        <p>Une série de bugs sont déjà identifiés et sont en cours de résolution. L'implémentation de ces fonctionnalités prend toutefois beaucoup de temps, de même que la résolution de certains bugs. N'hésitez pas à faire savoir à l'administrateur si vous constatez d'autres bugs.</p>
        <p>De façon générale, l'indication par une couleur d'une erreur peut rester malgré une correction. Il est conseillé de cliquer une seconde fois dans la cellule, puis sur "Enter", pour vérifier si c'est correct ou non.</p>
        <p>Concernant l'ajout de sites :</p>
        <ul>
          <li>Quand une région est indiquée dans le fichier importé mais n'existe pas, elle est juste enlevée du tableau.</li>
        </ul>
        <p>Concernant l'ajout de phases et contextes :</p>
        <ul>
          <li>Même si une erreur est indiquée, quand la première indication d'une nouvelle phase est incorrecte mais qu'une indication suivante est correcte, la phase est ajoutée à partir de ce moment et les contextes sont ajoutés à cette phase. Une phase erronée n'empêche pas l'importation du contexte</li>
          <li>Quand l'encodage de l'horizon régional est erroné, il est tout simplement enlevé, sans indiquer une erreur.</li>
        </ul>
        <p>Concernant l'ajout d'inventaire :</p>
        <ul>
          <li>La version courte doit être testée plus en détails, surtout avec les nombreux changements effectués. Il est probable qu'elle ne fonctionne pas correctement.</li>
          <li>La version longue n'est pas encore implémentée, car elle nécessite des changements dans la façon de fonctionner actuelle de <?php echo WEBSITE_NAME; ?>.</li>
        </ul>
      </section>


    <section id="telecharger-completer-templates" class="mb-5">
      <h3>1. Télécharger et compléter les templates</h3>
      <section id="telecharger-template" class="mb-5">
        <h4>1.1. Télécharger les templates</h4>
        
        <p>Les différentes templates sont téléchargeable dans l’espace personnel, dans l’onglet « templates ». Pour l’instant, il existe des templates pour l’ajout :</p>
        <ul>
          <li>d’opérations archéologiques ;</li>
          <li>de contextes (ainsi que leurs horizons-sites éventuels) ;</li>
          <li>d’inventaire.</li>
        </ul>

        <p>Vous devez sélectionner le template qui vous intéresse dans la liste fournie, puis cliquer sur « télécharger ».</p>
      </section>

      <section id="contenu-templates" class="mb-5">
        <h4>1.2. Contenu des templates</h4>

        <p>Ces templates sont à chaque fois prévus en une version courte et une version longue.</p>

        <h5>Sites – version courte</h5>
        <ul>
          <li><b>Id du projet (facultatif) :</b> Identifiant du projet doit être rattaché votre opération, si vous voulez la rattacher à un projet. L’identifiant est l’indicateur numérique visible dans l’URL en ouvrant votre projet : « …/project/1 », avec « 1 » comme identifiant.</li>
          <li><b>Responsable opération (facultatif) :</b> L’identifiant dans <?php echo WEBSITE_NAME; ?> (à ne pas confondre avec le nom et prénom) du responsable à indiquer pour l’opération. S’il s’agit de vous, vous pouvez le laisser vide. S’il s’agit de quelqu’un d’autre, il doit être inscrit dans <?php echo WEBSITE_NAME; ?> ; dans ce cas, vous serez automatiquement ajouté comme contributeur.</li>
          <li><b>Code opération archéologique (obligatoire) :</b> Code permettant d’identifier l’opération facilement. Le code doit être unique pour le responsable de l’opération et est obligatoire. Il est restreint à 32 caractères.</li>
          <li><b>Nom opération archéologique (obligatoire) :</b> Nom complet de l’opération archéologique. Le nom est retreint à 255 caractères. Il ne doit pas exister d’autres opérations archéologiques avec le même nom dans <?php echo WEBSITE_NAME; ?>.</li>
        </ul>

        <h5>Sites – version longue</h5>
        <p>Champs supplémentaires (tous facultatifs) :</p>
        <ul>
          <li><b>Coord. lat :</b> Coordonnées du site en latitude (sous forme décimale en utilisant un point, entre -90 et 90, les nombres positifs étant la latitude nord, les nombres négatifs la lattitude sud).</li>
          <li><b>Coord. long :</b> Coordonnées du site en longitude (sous forme décimale en utilisant un point, entre -180 et 180, les nombres positifs étant la longitude est, les nombres négatifs étant la longitude ouest).</li>
          <li><b>Code région :</b> Code régional. Les codes déjà intégrés <a href="<?php echo create_url(['geography']); ?>" target='_blank'>sont disponibles ici</a>. Si vous voulez ajouter une autre région, il vous faut contacter l'administrateur de <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Public (oui/non) :</b> Indication de, si oui ou non, vous voulez que l'opération archéologique soit consultable par tout le monde, ou uniquement par les responsables et contributeurs du projet et/ou de l'opération. Par défaut, l'opération archéologique n'est pas publique. Vous pouvez également la rendre publique mais cacher manuellement certains horizons-sites et contextes (hors ajout par tableau).</li>
          <li><b>Inédit (oui/non) :</b> Indication du caractère inédit ou non des données intégrées à <?php echo WEBSITE_NAME; ?>. Si non, vous devez ajouter la bibliographie manuellement, après l'ajout par fichier CSV. Par défaut, l'opération archéologique n'est pas considérée comme inédite. Vous pouvez également l'indiquer comme déjà publier mais indiquer manuellement comme inédits certains horizons-sites et contextes (hors ajout par tableau).</li>
          <li><b>Revue litt. (oui/non) :</b> Si cette opération archéologique n'a pas été publiée par vos soins mais que vous l'avez récupérée (avec ou sans modifications), vous devriez indiquer qu'il s'agit de données extraites (et vraisemblablement révisées) d'une publication. Vous pouvez régler ce paramètre plus finement pour les horizons-sites et contextes (hors ajout par tableau).</li>
          <li><b>Description :</b> Vous pouvez ajouter une description du site (texte libre).</li>
        </ul>

        <h5>Contextes – version courte</h5>
        <p>Il est obligatoire d'indiquer soit le responsable et le code de l'opération archéologique (combinaison unique), soit le nom (unique) de l'opération archéologique.</p>
        <ul>
          <li><b>Responsable opération :</b> L’identifiant dans <?php echo WEBSITE_NAME; ?> (à ne pas confondre avec le nom et prénom) du responsable de l'opération archéologique à laquelle vous voulez rajouter le contexte.</li>
          <li><b>Opération archéologique (code) :</b> Le code de l'opération archéologique à laquelle vous voulez rajouter le contexte.</li>
          <li><b>Opération archéologique (nom) (obligatoire) :</b> Le nom de l'opération archéologique à laquelle vous voulez rajouter le contexte.</li>
          <li><b>Code horizon-site (facultatif) :</b> Si vous souhaitez ajouter le contexte à un horizon-site, indiquez ici son code, permettant de l'identifier facilement. Il peut s'agir d'un nouvel horizon-site (code indiqué inexistant pour cette opération archéologique), d'un horizon-site existant ou d'un horizon-site rajouté pour un contexte importé plus haut dans le fichier CSV. Le code est restreint à 32 caractères.</li>
          <li><b>Nom horizon-site (facultatif sauf si nouveau) :</b> S'il s'agit d'un horizon-site introduit pour ce contexte, vous devez indiquer son nom. Sinon, ce champ sera ignoré. Le nom est restreint à 255 caractères.</li>
          <li><b>Code contexte (obligatoire) :</b> Code permettant d'identifier le contexxte facilement. Le code doit être unique pour l'opération archéologique (par exemple, US). Il est retreint à 32 caractères.</li>
          <li><b>Nom contexte (obligatoire) :</b> Nom complet du contexte (peut être équivalent au code). Le nom est retreint à 255 caractères.</li>
        </ul>

        <h5>Contextes – version longue</h5>
        <p>Champs supplémentaires (tous facultatifs) :</p>
        <ul>
          <li><b>Code groupe horizons régionaux (obligatoire si le champ suivant est complété) :</b> Si un nouvel horizon-site est introduit, il est possible de le relier à un horizon régional. Avant d'indiquer le code de ce dernier, il est nécessaire d'indiquer le code du groupe d'horizons auquel il appartient (par exemple, ROME pour les horizons de la région romaine). L'horizon régional doit déjà exister. Ce champ et les deux suivants ne sont pas pris en compte si l'horizon-site existe déjà ou a été introduit plus haut.</li>
          <li><b>Code horizon régional :</b> Si le nouvel horizon-site est lié à un horizon régional son code doit être indiqué dans cette colonne. L'horizon régional doit déjà exister.</li>
          <li><b>Type de lien (majeur = 1, mineur = 2, incertain = 3) :</b> Indique l'importance de l'horizon-site dans la définition de son horizon régional. Il doit s'agir d'un nombre entier entre 1 et 3. Peut être laissé vide si l'importance est inconnue.</li>
          <li><b>Description horizon-site :</b> Vous pouvez ajouter une description du nouvel horizon-site (texte libre).</li>
          <li><b>Description contexte :</b> Vous pouvez ajouter une description du contexte (texte libre).</li>
        </ul>

        <h5>Inventaire – version courte</h5>
        <p>Il s'agit pour l'instant de la seule possibilité d'ajout entièrement fonctionnelle. Il est obligatoire d'indiquer soit le responsable et le code de l'opération archéologique (combinaison unique), soit le nom (unique) de l'opération archéologique.</p>
        <ul>
          <li><b> Responsable opération :</b> L’identifiant dans <?php echo WEBSITE_NAME; ?> (à ne pas confondre avec le nom et prénom) du responsable de l'opération archéologique à laquelle appartient le contexte auquel vous voulez rajouter une ligne d'inventaire.</li>
          <li><b>Opération archéologique (code) :</b> Le code de l'opération archéologique à laquelle appartient le contexte auquel vous voulez rajouter une ligne d'inventaire.</li>
          <li><b>Opération archéologique (nom) :</b> Le nom de l'opération archéologique à laquelle appartient le contexte auquel vous voulez rajouter une ligne d'inventaire.</li>
          <li><b>Contexte (code) (obligatoire) :</b> Le code du contexte auquel vous voulez rajouter la ligne d'inventaire.</li>
          <li><b>Numéro d’inventaire (obligatoire) :</b> Numéro d'inventaire de l'objet que vous souhaitez ajouter, unique au sein du contexte. Le numéro d'inventaire est limité à 128 caractères.</li>

          <li><b>Catégorie (obligatoire) :</b> Abréviation de la catégorie à laquelle appartient l'objet (maximum 16 caractères). La catégorie n'a pas besoin d'avoir été rajoutée dans <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Fonction (obligatoire) :</b> Nom de la fonction à laquelle appartient l'objet (maximum 128 caractères). La fonction n'a pas besoin d'avoir été rajoutée dans <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Type (obligatoire) :</b> Nom du type auquel appartient l'objet (maximum 128 caractères). Le type n'a pas besoin d'avoir été rajouté dans <?php echo WEBSITE_NAME; ?>. </li>
          <li><b>var. (facultatif) :</b> S'il s'agit d'une variante du type, indiquez-le ici (préférablement avec l'indication "var.", maximum 8 caractères).</li>
          <li><b>doute (facultatif) :</b> S'il y a un doute sur l'identification du type, indiquez-le ici (préférablement avec la ponctuation "?", maximum 16 caractères).</li>
          <li><b>Pâte (facultatif) :</b> Code du groupe de pâtes auquel appartient l'objet (maximum 64 caractères). Le groupe de pâtes n'a pas besoin d'avoir été rajouté dans <?php echo WEBSITE_NAME; ?>.</li>

          <li><b>Diam. (facultatif) :</b> Indications sur le diamètre de l'objet (maximum 16 caractères).</li>
          <li><b>Estampilles (facultatif) :</b> S'il y a des estampilles pour l'objet, indiquez-le distinctement du type afin de faciliter les recherches sur ce dernier (maximum 255 caractères).</li>
          <li><b>Commentaire (facultatif) :</b> Commentaire ou description libre (maximum 255 caractères).</li>
          <li><b>Bords (facultatif) :</b> Nombre de bords (nombre entier >= 0).</li>
          <li><b>Fonds (facultatif) :</b> Nombre de fonds (nombre entier >= 0).</li>
          <li><b>Anses (facultatif) :</b> Nombre d'anses (nombre entier >= 0).</li>
          <li><b>Parois (facultatif) :</b> Nombre de parois (nombre entier >= 0).</li>
          <li><b>NMI (facultatif) :</b> Nombre minimum d'individus (strict, basé sur le bord seul) (nombre entier >= 0).</li>
          <li><b>NR (facultatif) :</b> Nombre de restes (ou fragments) (nombre entier >= 0).</li>
        </ul>


        <h5>Inventaire – version longue</h5>
        <p>La version longue est utile dans le cas de revues de la littérature (ou de la mise en ligne de contextes étudiés il y a un certain temps), car il permet de modifier dans la base de données les catégories, fonctions, types et groupes de pâte tout en rendant disponible l'information originellement publiée. <div style="color:#ff0000">L'intégration des inventaires sous cette forme n'est pas possible pour l'instant.</div> Les champs en question sont remplacés par :</p>
        <ul>
          <li><b>Catégorie (adaptée) (obligatoire) :</b> Équivalent de la Catégorie dans le template court.</li>
          <li><b>Catégorie (biblio) (facultatif) :</b> Catégorie mentionnée dans la bibliographie (fonctionnalité à rajouter).</li>
          <li><b>Fonction (adaptée) (obligatoire) :</b> Équivalent de la Fonction dans le template court.</li>
          <li><b>Fonction (biblio) (facultatif) :</b> Fonction mentionnée dans la bibliographie (fonctionnalité à rajouter).</li>
          <li><b>Type (adaptée) (obligatoire) :</b> Équivalent du Type dans le template court.</li>
          <li><b>Type (biblio) (facultatif) :</b> Type mentionné dans la bibliographie (fonctionnalité à rajouter).</li>
          <li><b>Pâte (adaptée) (facultatif) :</b> Équivalent du Groupe de pâtes dans le template court.</li>
          <li><b>Pâte (biblio) (facultatif) :</b> Groupe de pâtes mentionné dans la bibliographie (fonctionnalité à rajouter).</li>
        </ul>
      </section>

      <section id="ouvrir-templates" class="mb-5">
        <h4>1.3. Ouvrir les templates</h4>
        
        <p>Les templates ont été configurés pour utiliser des points-virgules comme séparateurs, ce qui est la configuration de base pour MS Excel dans sa version francophone. Il se peut néanmoins que le template s’affiche mal chez vous ; dans ce cas-là, n’hésitez pas à contacter l’administrateur du site pour trouver une solution.</p>
      </section>

      <section id="completer-enregistrer" class="mb-5">
        <h4>1.4. Compléter et enregistrer les templates</h4>
        <h5>Compléter le template</h5>
        <p>Une fois ouvert, vous pouvez compléter le template. Veillez à ne retirer aucun champ du template et à ne pas modifier l’ordre des colonnes. <?php echo WEBSITE_NAME; ?> gère normalement l’ajout de nouveaux champs (ignorés), la suppression des champs obligatoires et la modification de l’ordre, mais des bugs pourraient néanmoins apparaître.</p>
        <p>Laissez complètement vide les champs non utilisés et non obligatoires. Notez que les modifications de style (gras, italiques, souligné, polices…) ne sont pas conservées dans un fichier CSV. Les petites capitales sont transformées en capitales.</p>
        <p><b>La taille maximale des templates est actuellement d'environ 200 Mo, mais elle sera restreinte à 2 Mo (afin de les rendre gérables), soit approximativement 50.000 lignes d'inventaire. Veuillez ne pas dépasser ce chiffre.</b></p>

        <h5>Enregistrer le template</h5>
        <p>Le template doit toujours être enregistré en format CSV, en utilisant le point-virgule comme séparateur. Dans MS Excel configuré pour les utilisateurs francophones, cela devrait être le cas.</p>
        <p>Vous pouvez toutefois vérifier cela en ouvrant votre fichier CSV dans un bloc-notes (TextEdit) sur Mac et regarder si des points-virgules ou un autre séparateur (généralement, la virgule) est utilisé pour séparer les champs. Si c’est la virgule, et que vous êtes sûrs que vous n’avez pas utilisé de virgule pour compléter le template, vous pouvez faire un rechercher-remplacer pour remplacer les virgules par des points-virgules.</p>
      </section>
    </section>

    <section id="integrer" class="mb-5">
      <h3>2. Intégrer les templates</h3>
      <section id="ajouter-template" class="mb-5">
        <h4>2.1. Ajouter les templates et aller à l’écran d’ajout</h4>
        <p>Pour ajouter le template, retournez dans l’Espace personnel. Dans « Importer des données », vous devrez :</p>
        <ul>
          <li>Sélectionner une option dans la liste pour sélectionner le type de template que vous ajouterez (peu importe s’il s’agit du template long ou court) ;</li>
          <li>Ajouter le fichier complété ;</li>
          <li>Indiquer si vous voulez afficher ou non les données importées sans erreur. Par « sans erreur », est entendu la possibilité d’intégrer les données telles qu’elles ont été rentrées, sans modification de l’utilisateur. Il est à noter que l’absence de correspondance au niveau des catégories, fonctions, types et groupes de pâte n’est pas considéré comme une erreur. Si vous voulez faire ces vérifications, nous vous conseillons de ne pas cocher cette case. Ce choix ne peut pas être modifié par la suite. Si vous n’êtes pas sûr de votre choix, vous pouvez toujours faire un test, puis abandonner l’intégration des données et choisir de changer votre choix (voir plus bas).</li>
        </ul>
      </section>
      <section id="ecran-ajout" class="mb-5">
        <h4>2.2. Écran d’ajout des données</h4>
        <p>Vous arriverez ensuite à un écran permettant de valider l’ajout des données. Cet écran comporte deux parties : un résumé de l’intégration, et le tableau des données intégrées.</p>

        <h5>Données d’intégration</h5>
        <p>Il s’agit d’un récapitulatif des données ajoutées :</p>
        <ul>
          <li><b>Lignes :</b> Les lignes actuellement traitées au sein du CSV (afin de respecter le comptage dans Excel, la ligne de titre est considérée comme la ligne 1).</li>
          <li><b>Total des lignes :</b> Nombre de lignes que comprend le fichier uploadé (ligne de titre inclue).</li>
          <li><b>Lignes restantes :</b> Nombre de lignes encore non traitées.</li>
          <li><b>Lignes affichées :</b> Nombre de lignes affichées dans ce tableau.</li>
        </ul>

        <h5>Tableau de données</h5>
        <p>En-dessous de ces données, le tableau est affiché, soit avec toutes les données intégrées, soit avec uniquement les données erronées, selon le choix effectué pour l’intégration. <?php echo WEBSITE_NAME; ?> est configuré pour afficher 200 lignes maximum. Dans le cas où l’option « Afficher également les données importées sans erreur » n’a pas été cochée, <?php echo WEBSITE_NAME; ?> traitera au maximum 1000 lignes à la fois, peu importe s’il y a des erreurs ou non (et affichera maximum 200 lignes erronées).</p>
        <p>Les données correctement complétées sont complétées en noir. Les autres données sont affichées en différentes couleurs selon leur gravité.</p>

        <h5>Erreurs empêchant l’importation des données</h5>
        <p>Ces erreurs sont indiquées en rouge foncé. L’importation peut se faire dans certains cas, mais nous avons préféré les considérer comme des erreurs bloquantes, car il est probable que l’utilisateur veuille les corriger. En général :</p>
        <ul>
          <li><b>Format non valide :</b> Quand des données obligatoires sont absentes, n’ont pas le bon format (par exemple, lettres au lieu de nombre) ou que le nombre maximal de caractères est dépassé.</li>
        </ul>
        <p>Pour l’importation de sites :</p>
        <ul>
          <li><b>Projet :</b> Aucun projet ne correspond à cet identifiant, ou l’utilisateur n’est pas inclus dans le projet correspondant.</li>
          <li><b>Responsable de l'opération :</b> Le nom d’utilisateur n’existe pas. Le code du site ne peut pas être vérifié et est aussi considéré comme incorrect.</li>
          <li><b>Code :</b> Le code est absent, trop long ou existe déjà pour ce responsable.</li>
          <li><b>Nom :</b> Le nom est absent, trop long ou existe déjà dans <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Région :</b> Le code de la région mentionnée n’existe pas encore dans <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Coordonnées :</b> La latitude et/ou la longitude ne sont pas indiquées sous forme de nombre ou avec des valeurs impossibles (entre -90 et 90 pour la latitude, entre -180 et 180 pour la longitude).</li>
        </ul>
        <p>Pour l’importation des horizons-sites et contextes :</p>
        <ul>
          <li><b>Site :</b> Aucun site ne correspond à ce code, ou l'utilisateur n'est ni responsable, ni contributeur de ce site (le code du contexte est aussi considéré comme erroné, ne pouvant être vérifié).</li>
          <li><b>Code horizon-site :</b>Ce code est déjà attribué pour ce site (dans le cas où un autre nom que celui de l'horizon-site existant ou mentionné plus haut sous ce même code est différent pour cette ligne - <b>Règle à confirmer</b>).</li>
          <li><b>Type lien :</b> Le type de lien avec l'horizon régional doit être vide, ou un nombre entre 0 et 3 (majeur = 1, mineur = 2, incertain = 3, inconnu = 0) - <b>Il doit encore être précisé si c'est un problème bloquant ou non</b>.</li>
          <li><b>Code contexte :</b> Le code existe déjà pour ce site.</li>
        </ul>
        <p>Pour l’importation de l’inventaire :</p>
        <ul>
          <li><b>Site :</b> Aucun site ne correspond à ce code, ou l'utilisateur n'est ni responsable, ni contributeur de ce site (le code du contexte et le numéro d'inventaire sont aussi considérés comme erronés, ne pouvant être vérifiés).</li>
          <li><b>Contexte :</b> Le code mentionné pour le contexte n'existe pas pour ce site (le numéro d'inventaire est aussi considéré comme erroné, ne pouvant être vérifié).</li>
          <li><b>Numéro d'inventaire :</b> Le numéro doit être unique au sein du contexte (y-compris dans les données en ajout)</li>
          <li><b>Bords, fonds, anses, parois, NMI, NR :</b> Si ces colonnes sont complétées, il doit s'agit de nombres entiers positifs (ou 0)</li>
        </ul>

        <h5>Erreurs n’empêchant pas l’importation des données</h5>
        <p>Ces erreurs sont (normalement) affichés en grisé. Dans le cas de l'importation de l'inventaire, ce ne sont pas vraiment des erreurs mais plutôt l'ajout de données non reliées au niveau du référentiel.</p>
        <p>Pour l’importation de sites :</p>
        <ul>
          <li><b> Public, Inédit, Revue litt. :</b> Quand le format n’est pas bon (réponse autre que « oui » ou « non » ou une case vide). Les valeurs par défaut seront appliquées.</li>
        </ul>
        <p>Pour l’importation des horizons-sites et contextes :</p>
        <ul>
          <li><b>Groupe d'horizons (code) :</b> Aucun groupe d'horizons ne correspond à ce code, ou l'utilisateur n'est ni responsable, ni contributeur de ce groupe (le code de l'horizon est aussi considéré comme erroné, ne pouvant être vérifié).</li>
          <li><b>Horizon (code) :</b> Le code mentionné pour l'horizon régional n'existe pas pour ce groupe d'horizons.</li>
          <li><b>Type lien :</b> Si le type est indiqué, il doit s'agit d'un nombre entier entre 1 et 3</li>
        </ul>
        <p>Pour l’importation de l’inventaire :</p>
        <ul>
          <li><b>Catégorie, Fonction, Type et Groupe de pâtes :</b> Quand il n'existe pas d'élément dans le référentiel de <?php echo WEBSITE_NAME; ?> (pour le moment, non connecté à ONICer) qui peut être relié.</li>
        </ul>
      </section>

      <section id="corrections" class="mb-5">
        <h4>2.3. Corrections lors de l’intégration</h4>
        <p>Que ce soit en cas d’erreur ou pour tout autre type de correction, vous pouvez changer la valeur affichée en cliquant simplement sur la case que vous voulez modifier et corriger la valeur. Quand vous cliquez autre part, la valeur s’affiche en noir si elle est valide ou avec la couleur correspondante au type d’erreur.</p>
      </section>

      <section id="validation" class="mb-5">
        <h4>2.4. Valider ou abandonner l’intégration</h4>
        <p>Une fois que vous avez vérifié et appliqué toutes les modifications que vous vouliez, vous pouvez valider l’intégration. Deux cas de figure sont possibles :</p>
        <ul>
          <li><b>Importer les lignes valides et charger la suite :</b> Quand il reste encore des données qui n’ont pas été parcourues, vous intégrez les données valides et les données suivantes sont affichées.</li>
          <li><b>Importer les lignes valides et terminer l’upload :</b> Quand il y a peu de données à importer ou que vous êtes arrivé à la fin des données à importer, vous intégrez les données valides et vous êtes ensuite redirigés sur votre espace personnel.</li>
        </ul>
        <p>Les données non valides ne seront pas ajoutées (<b style="color:#ff0000">CLARIFIER</b>).</p>
        <p>Vous pouvez également abandonner l’upload. Les données déjà importées (lors d’affichages précédents) ne seront pas supprimées, mais les données affichées et toutes celles encore à traiter ne seront pas intégrées à <?php echo WEBSITE_NAME; ?>. Vous ne pouvez pas revenir en arrière. C’est une option utile si vous constatez beaucoup de problèmes dans votre fichier et que vous voulez le retravailler, ou que vous voulez changer l’option d’affichage des données erronées ou non. Si vous voulez simplement arrêter l’intégration pour l’instant, la mise en pause est plus adéquate (voir ci-dessous).</p>
      </section>
    </section>

    <section id="longues-integrations" class="mb-5">
      <h3>3. Gérer les longues intégrations</h3>
      <section id="pause-integration" class="mb-5">
        <h4>3.1. Stopper temporairement l’upload</h4>
        <p>Si vous devez vous arrêtez pendant que vous ajoutez des données, un bouton « Stopper temporairement l’upload » permet de mettre en pause l’intégration des données. À moins d’ajouter d’autres données entretemps, vous pourrez ensuite redémarrer l’ajout des données au point où vous en étiez. Vous pouvez aussi tout simplement quitter l’écran.</p>
        <p>Cela ne changera rien aux lignes déjà ajoutées à la base de données.</p>
      </section>

      <section id="reprendre-upload" class="mb-5">
        <h4>3.2. Reprendre l’upload</h4>
        <p>Pour reprendre un upload ainsi mis en pause, vous devez vous rendre dans votre espace personnel. Sous « Importer des données », un bouton vert permet de reprendre un upload mis en pause. Ce bouton ne s’affiche pas s’il n’y a pas d’upload qui a été mis en pause.</p> 
        <p>Pour l’instant, il n’est pas prévu de pouvoir mettre en pause et redémarrer plusieurs uploads pour un même utilisateur. Si vous démarrer un nouvel upload (de sites, contextes ou inventaire), cela supprimera l’upload mis en pause.</p>
      </section>
    </section>

    <h2>II. Intégrer les données depuis les pages des projets, sites et contextes</h2>
    <p>Cette possibilité n’est pas encore intégrée à <?php echo WEBSITE_NAME; ?>.</p>

    <h2>III. Intégrer manuellement les données</h2>
    <div style="color:#ff0000"><p>Partie en construction.</p></div>
  </div>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
