            <h2>Politique de confidentialité - <?php echo WEBSITE_NAME; ?></h2>
            <h5>Données personnelles collectées</h5>
            <p>Pour les utilisateurs inscrits : nom, prénom, adresse e-mail, identifiant, mot de passe (encrypté), langue de navigation de préférence.</p>
            <p>Pour les autres utilisateurs : langue de navigation de préférence.</p>
            <h5>Finalité de la collecte des données</h5>
            <p>Les données sont utilisées uniquement pour la création et la gestion des comptes utilisateurs, afin d’accéder aux fonctionnalités de <?php echo WEBSITE_NAME; ?>, ainsi que pour gérer la langue d'affichage du site web.</p>
            <h5>Base légale</h5>
            <p>Le traitement des données est basé sur le consentement de l’utilisateur (inscription volontaire).</p>
            <h5>Durée de conservation des données personnelles</h5>
            <p>Les données sont conservées jusqu’à la suppression du compte par l’utilisateur (possible sous demande : <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulaire de contact</a>), et durant un an pour la langue de préférence.</p>
            <h5>Droits des utilisateurs</h5>
            <p>Accès, rectification, suppression, opposition, portabilité. Pour exercer ces droits : <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulaire de contact</a>.</p>
            <h5>Sécurité des données personnelles</h5>
            <p>Les données utilisateurs sont protégées par des mesures techniques (encryption des mots de passe, accès sécurisé à la base de données). Le prénom et nom (ou, à défaut, le nom d'utilisateur) est toutefois accessible par les autres utilisateurs inscrits. Dans le cas de publication de données scientifiques, les utilisateurs non inscrits auront également accès à ces informations. Le(s) administrateur(s) de la base de données a/ont également accès à l'adresse mail utilisée pour l'inscription.</p>
            <h5>Partage des données personnelles</h5>
            <p>Les données ne sont et ne seront jamais vendues. Elles ne sont pas partagées avec des tiers, sauf obligation légale.</p>
            <h5>Responsable du traitement</h5>
            <p><?php
            $users = User::find_all();
            $already = 0;
            foreach ($users as $user) {
                if ($user->is_staff()) {
                    if ($already > 0) {
                        echo ", ";
                    }
                    echo $user->codename();
                    $already++;
                }
            }
            ?>.</p>
            <h5>Visibilité, usage et traitement des données non personnelles</h5>
            <p>Toute donnée intégrée par un utilisateur inscrit à <?php echo WEBSITE_NAME; ?> est publique, à l'exception des données de projet (uniquement accessibles à leurs contributeurs), à moins qu'il ne soit possible d'en régler autrement la confidentialité.
                Les créateurs des données en sont considérés comme les auteurs principaux. Dans certains cas, des contributeurs (internes à <?php echo WEBSITE_NAME; ?>) peuvent être indiqués. Il leur appartient de veiller à l'authenticité de ces données ainsi qu'au respect des directives concernant le droit d'auteur et la citation des données scientifiques.
                L'administrateur se réserve le droit de supprimer le compte et les données de tout contrevenant à ce principe.</p>
