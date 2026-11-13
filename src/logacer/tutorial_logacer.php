<?php
    $title = "Mode d'emploi";
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>

    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <main class="container-fluid py-5">
            <h1 style="font-color:red">UNDER REWRITING</h1>
            <h2>S'identifier</h2>
            <p>L'identification se fait à l'adresse <a href="https://www.dbcer.org/login">Login</a>. Elle n'est pour le moment pas ajoutée à la barre principale, mais elle le sera une fois l'outil entièrement opérationnel.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalYl7PhTJo0DHCUFA?e=qS1nEP"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121720&authkey=%21AESBVSr61159t0k&width=660" width="660" height="auto" /></a>
            <p>D'autres utilisateurs peuvent être créés par un utilisateur enregistré à l'adresse <a href="<?php echo BASE_URL . 'register' ?>">Créer un nouvel utilisateur</a>. Il n'est pour l'instant pas possible de modifier le mot de passe. Les autres données d'utilisateurs peuvent pour l'instant uniquement être modifiées par l'administrateur.</p>
            <p>Une fois identifié, une nouvelle barre d'outil est visible sous la barre principale (en foncé). Il est aussi possible de se déconnecter (Logout). Pour l'instant, deux types de données sont éditables : les données concernant les sites (et leur inventaire), et celles sur les horizons.</p>
            <p><b>La "Mise à jour via CSV" ne correspond plus à la structure de la base et a donc été désactivée.</b></p>


            <h2>Ajouter et modifier les informations sur les sites, phases, contextes</h2>
            <p>En cliquant sur "Mes sites", on arrive à la liste des sites ajoutés par soi-même, organisés par région. Une navigation via une carte est prévue dans le futur. Les sites indiqués comme "Non publiés" ne sont visibles que par vous.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalZl4ykqZbXjMotqw?e=KzUeh8"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121721&authkey=%21AI23EhNWx4oNmrY&width=660" width="660" height="auto" /></a>

            <h4>Ajouter un site</h4>
            <p>Un bouton dans "Mes sites", tout en bas des sites ajoutés, permet de rajouter un nouveau site.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalVVrZjeooevaFq0A?e=yP66iS"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121717&authkey=%21AJIjzQN2XAs9WqQ&width=660" width="660" height="auto" /></a>
            <p>Une série de données concernant le site peuvent être ajoutées. <b>Quelques limitations existent actuellement :</b></p>
            <ol>
                <li>Le <b>code doit être unique</b> pour l'utilisateur. Plusieurs utilisateurs peuvent utiliser un même code de site.</li>
                <li>Le <b>"texte formaté"</b> permet d'afficher les données selon un format plus agréable à la lecture (paragraphe, italiques, éventuellement sous-sections...). Pour le moment, il n'est possible d'ajouter les données dans cette case que sous un format HTML (ce qui n'est pas optimal). Il est prévu d'améliorer cela en autorisant le language <a href="https://fr.wikipedia.org/wiki/Markdown">Markdown</a>. Un éditeur de texte plus développé pourra aussi être prévu, s'il s'avère réellement utile.</li>
                <li>Le texte formaté apparaît en priorité par rapport au texte non formaté.</li>
                <li>Seul le nom des éléments ajoutés ou modifiés (site, phase, contexte...) ne peut être vide.</li>
                <li>Concernant les <b>régions</b>, il est nécessaire d'en choisir une qui s'affiche avec l'auto-complétion. Pour le moment, seules 4 régions sont ajoutées, et il n'est pas possible d'en rajouter de nouvelles pour l'instant.</li>
                <li><b>Il est essentiel, pour l'instant, de ne pas rendre le site public !</b> Il est possible par la suite de modifier la confidentialité.</li>
                <li>Si le site est indiqué comme <b>inédit</b>, la bibliographie qui y est liée ne s'affichera pas. Il en est de même pour les phases, contextes... Quand la bibliographie est héritée du site.</li>
            </ol>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalgwIgv_zbbQIqGMQ?e=OoDJFV"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121728&authkey=%21AE9cn-aZ7J4q_YU&height=660" width="auto" height="660" /></a>
            <p>Une fois les informations complétées, vous pouvez cliquer sur "Créer un nouveau site", ou "Annuler" si vous ne souhaitez pas poursuivre l'ajout.</p>

            <h4>Ajouter une phase</h4>
            <p>L'ajout d'une phase se fait directement depuis la page du site, via le bouton "Ajouter une phase".</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalWhuVRxd-tQGDrsg?e=3qNBoU"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121718&authkey=%21AHa8w9vkcKcAyug&width=660" width="660" height="auto" /></a>
            <p>Le fonctionnement est similaire à celui pour l'ajout d'un site (notamment les points 2 à 4 et 7), à l'exception de la possibilité de rattacher la phase à un <b>horizon régional</b>, en indiquant le degré d'importance de la phase pour la caractérisation dudit horizon. Le <b>Code doit être unique</b> pour le site en question.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalkNizpHUp_Ra-1VA?e=EcWfPA"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121732&authkey=%21AI13ARnFlwspGdA&width=660" width="660" height="auto" /></a>

            <h4>Ajouter un contexte</h4>
            <p>L'ajout d'un contexte se fait de la même façon que pour une phase, et la complétion est similaire à celle pour les sites et phases. <b>Le code doit être unique</b> pour la phase en question.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalSGe2p42RoRcoSsQ?e=4iqXoh"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121714&authkey=%21AAV5rv1sNggnlCE&width=660" width="660" height="auto" /></a>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalfLg4oJhenktw9hA?e=eBt7eU"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121727&authkey=%21AKMASxFjupiAUQI&width=660" width="660" height="auto" /></a>

            <h4>Modifier un site, une phase, un contexte</h4>
            <p>La modification d'un site, d'une phase, d'un contexte et même d'un groupe d'horizon ou d'un horizon se fait via un bouton en bas de la page de l'élément à modifier.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgale8oy5ij5339jCgA?e=Debv51"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121726&authkey=%21AJUryBtz_0DyfJM&width=660" width="660" height="auto" /></a>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalbj2o39u9LOnOg2g?e=cNzYZe"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121723&authkey=%21ACJM1rBML1w8DBk&width=660" width="660" height="auto" /></a>
            <p>L'apparence de la page de modification est similaire à celle d'ajout, mais les informations sont déjà pré-complétées.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalnU6vW3uE2iZ1ftA?e=uygIx2"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121735&authkey=%21AIw1A2FhzzkyKq0&width=660" width="660" height="auto" /></a>
            <p>Si le contenu d'un champ complété au préalable est vide au moment de la validation des modifications, ce contenu sera supprimé de la base de données, sauf s'il s'agit d'une donnée obligatoire.</p>

            <h4>Supprimer un site, phase, contexte</h4>
            <p>La suppression est possible :</p>
            <ul>
                <li>Pour un site auquel plus aucune phase n'est rattachée ;</li>
                <li>Pour une phase à laquelle plus aucun contexte n'est rattaché ;</li>
                <li>Pour un contexte à laquelle plus aucun objet n'est rattaché.</li>
            </ul>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalm1BV8UD4BNwp9TQ?e=NEKEj1"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121734&authkey=%21AKV8EsZKl_fxfYI&width=660" width="660" height="auto" /></a>

            <h4>Modifier les liens entre sites, phases, contextes</h4>
            <p>Ce n'est pas possible et l'ajout de cette fonctionnalité n'est pas prévue.</p>


            <h2>Ajouter et modifier les informations sur les objets</h2>
            <p>L'ajout et la modification d'objets se font directement au sein de la fiche du contexte auxquels ils appartiennent. Pour l'instant, l'ajout d'objet ne peut se faire qu'une par une, manuellement, tandis que la modification se fait pour l'ensemble des objets du contexte. La modification isolée d'un objet, ainsi que l'insertion d'objets par CSV (avec un format similaire à celui utilisé pour ONICer), est prévue pour plus tard.</p>
            <p>Il est à noter que l'affichage des objets au sein des contextes se fait pour le moment sans tenir compte du nombre de parties du vase et du NMI, sauf pour Artena (n'ayant pas de réelles informations pour les autres sites de ma thèse). Il est prévu de modifier cela à l'avenir, afin d'avoir un affichage plus dynamique selon les données complétées. Cette information reste présente dans les CSV téléchargés et dans le détail de chaque objet, accessible en cliquant sur le numéro d'inventaire.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalag8a1a9VprK7CGQ?e=5hIev6"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121722&authkey=%21AAYkjUVgKN_ioIE&width=660" width="660" height="auto" /></a>

            <h4>Ajouter un nouvel objet</h4>
            <p>L'ajout d'un objet se fait via la page du contexte.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalU9lHwPcRM-px49A?e=xYA9lr"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121716&authkey=%21AFpofOfsxXJ_bNQ&width=660" width="660" height="auto" /></a>
            <p>Les données à compléter sont assez similaires à celles d'ONICer, si ce n'est l'ajout possible d'estampilles. Seules les données de type "Nombre de" doivent être remplies en nombres.</p>
            <p>Les informations sur les catégories, fonctions, types et pâtes sont des textes libres pour le moment. L'ajout de liens avec les catégories et fonctions d'ONICer, ainsi que la possibilité de relier les types et pâtes à des fiches de description des types et pâtes est en cours.</p>
            <p>Les numéro d'inventaire (unique au contexte), catégorie, fonction, type et pâte sont les seules à devoir être absolument remplies.</p>
            <p>Il est possible que l'objet ne soit pas validé si les données complétées dans certains champs sont trop longues. Des améliorations sont prévues sur le long terme pour régler ce problème.</p>
            <p>Une fois les informations complétées, il est possible de retourner au contexte, ou de compléter un nouvel objet. Il est prévu d'ajouter un bouton pour aller directement sur la page de l'objet.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalhU04F36xWwkbhZA?e=XcgGqb"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121729&authkey=%21ABYVbSRf4WSD9jQ&width=660" width="660" height="auto" /></a>

            <h4>Modifier les objets existants</h4>
            <p>La modification se fait via le bouton "Modifier l'inventaire du contexte"</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalcQybQAZ1vaH2_ZA?e=m3gmry"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121724&authkey=%21AJCaNYGIgfWcfnQ&width=660" width="660" height="auto" /></a>
            <p>La modification se fait sur l'ensemble des objets. <b>Soyez attentif à ne pas supprimer ou modifier une information par mégarde !</b> Il est comme pour le reste possible d'abandonner les modifications en cours.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgaldqSwfVcI8DjYJ8A?e=fbEpx2"></a>

            <h4>Supprimer un objet</h4>
            <p>Quand vous êtes connectés, vous pouvez supprimer les objets appartenant à vos contextes. Pour cela, il faut cliquer sur le bouton "X" à l'extrémité du tableau.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalld4Ynsc7dTMM7tQ?e=u5hXkf"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121733&authkey=%21ABNUyvoUQ_Tm4XE&width=660" width="660" height="auto" /></a>

            <h4>Ajouter une illustration à un objet</h4>
            <p>L'ajout d'illustration à l'objet se fait via la fiche de l'objet, accessible en cliquant sur son numéro d'inventaire depuis le contexte.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalag8a1a9VprK7CGQ?e=5hIev6"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121722&authkey=%21AAYkjUVgKN_ioIE&width=660" width="660" height="auto" />
            <p>Il faut ensuite cliquer sur "Ajouter une illustration"</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalTfRjRTXZvDg2Geg?e=6hCPyQ"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121715&authkey=%21AMksmSgA9BgN4hc&width=660" width="660" height="auto" /></a>
            <p>Les options d'ajout sont plutôt restreintes pour le moment. Il est prévu de pouvoir héberger les images légères sur le serveur de DBCer (la capacité totale de stockage étant limitée à 1Go, cette possibilité sera donnée aux images de moins de 10ko, ce qui est aisément atteignable avec une grande qualité avec le format .svg pour le dessin vectoriel). En attendant, les fichiers d'images doivent être hébergées ailleurs.</p>
            <p>Le type d'illustration, actuellement restreint, est important à prendre en compte. En effet :</p>
            <ul>
                <li>Seuls les dessins sont, pour le moment, montrés sur les pages des types (un affichage distinct des photos est prévu par la suite).</li>
                <li>Seules les photos de pâtes seront montrées sur les pages des groupes de pâtes, avec une distinction selon le type de photographie.</li>
            </ul>
            <p>Pour l'adresse URL, les clouds proposent souvent de générer une adresse URL pour une image qui y est stockée. Par exemple, <a href="<?php echo BASE_URL ?>">AJOUTER</a> pour OneDrive ou <a href="<?php echo BASE_URL ?>">AJOUTER</a> pour DropBox. Nous conseillons d'utiliser l'image de la plus haute qualité, puis de modifier la taille affichée dans les champs, afin de conserver une image de qualité mais une taille affichée raisonnable.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalj6TTgdJjvSnp-Eg?e=8p3xtd"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121731&authkey=%21AFIqFA4FPO6xdLc&width=660" width="660" height="auto" /></a>


            <h2>Relier des informations bibliographiques</h2>
            <p>Il est possible d'ajouter des informations bibliographiques pour les sites, phases, contextes et groupes d'horizons, à condition qu'ils n'aient pas été indiqués comme "Inédits". Si c'est le cas, il faut d'abord décocher cette case en modifiant l'élément.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalR09XLMgXB18rQ6Q?e=yhv98y"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121713&authkey=%21AEa1_2W6ZbTNp5c&width=660" width="660" height="auto" /></a>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalQU6770Zgjb-q37A?e=9X2kbT"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121712&authkey=%21ANTsv2e3S1LfRRU&width=660" width="660" height="auto" /></a>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalPettwS76CK0QKjw?e=OI8832"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121711&authkey=%21AP9Y-Xbj8BHqzOU&width=660" width="660" height="auto" /></a>
            <p>Le lien avec les informations bibliographiques se fait au sein de la page du site/phase/contexte/groupe, avec une autocomplétion. <b>Il est nécessaire de choisir une abréviation au sein de celles proposées.</b></p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalivEIHj6RJqexEuA?e=hzGUBw"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121730&authkey=%21AOyNM3GCWiBBZAU&width=660" width="660" height="auto" /></a>
            <p>La possibilité d'ajouter de nouvelles références bibliographiques sera mise en place plus tard.</p>
            <p>Si aucun élément bibliographique n'a été ajouté pour une phase, la bibliographie du site sera affichée à la place (sauf si la phase est inédite). Pour le contexte, la base de données va d'abord vérifier s'il existe des références bibliographiques pour la phase, puis pour le site.</p>
            <a href="https://1drv.ms/i/s!Av5pNAa5Jv3xgalX8aEFmZ0ESyaCgA?e=05TyX5"><img class="object_picture" src="https://onedrive.live.com/embed?resid=F1FD26B9063469FE%2121719&authkey=%21AAG0NKM5q-oQet4&width=660" width="660" height="auto" /></a>
            <p>Il est possible de supprimer un lien avec la bibliographie via le bouton "Supprimer", à droite de la référence. Cela n'est pas possible, par exemple, quand on est au sein d'une phase et qu'on essaie de supprimer le lien qui a été fait au niveau du site.</p>

            <h2>Gérer, ajouter et modifier les horizons régionaux</h2>
            <p>Encore à compléter, mais normalement à ce niveau vous avez compris comment cela fonctionne. En gros, il y a des "Groupes d'horizons", concernant une région (ou plusieurs, il est possible d'en indiquer différentes), puis différents horizons successifs. Des sur- et sous-horizons existent dans le modèle, mais leur gestion n'est pas encore intégrée à la base.</p>

            <h2>Éléments en cours d'ajout</h2>
            <p>Pour l'instant, outre la complétion et correction de certaines données, je suis en train de travailler sur l'ajout d'informations de Catégories et Fonctions depuis ONICer, ainsi que des informations de Types et de Pâtes, dans une perspective d'abord de classification des inventaires affichés, puis afin de pouvoir faciliter la compréhension, la navigation et intégrer ce genre de données. Beaucoup de travail serait encore à prévoir, et une priorisation est nécessaire. N'hésitez donc pas à me faire savoir ce qui vous semble le plus urgent ! Sachant aussi que ce qui vous semble simple peut parfois être compliqué de mon côté, et vice-versa.</p>
        </main>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>