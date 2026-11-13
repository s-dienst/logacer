            <h2>Mentions légales - <?php echo PROJECT->code(); ?></h2>
            <h5>Éditeur de LOGACer</h5>
            <p>
                Simon Dienst
                </br>Service d'histoire de l'art et archéologie de l'Antiquité gréco-romaine (SHAARAGR)
                </br>Département des sciences historiques
                </br>Faculté de Philosophie et lettres
                </br>Université de Liège
                </br>Place du 20-Août, 7
                </br>B-4000 Liège, Belgique
                </br>Email : Simon.Dienst@uliege.be
                </br>Site web : www.logacer.org
            </p>
            <h5>Hébergeur</h5>
            <p>
                Pour les informations concernant l'hébergeur, veuillez contacter le responsable de l'installation avec le <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulaire de contact</a>.
            </p>
            <h5>Responsable de la publication</h5>
            <p>Les données publiées sont sous la pleine responsabilité de <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?> et n'engagent en aucun cas la responsabilité de l'hébergeur.</p>
            <h5>Logiciel utilisé</h5>
            <p>La base de données est publiée en utilisant <a href="https://www.logacer.org">LOGACer - Logiciel Online de Gestion et d'Analyse de la Céramique</a>, un logiciel réalisé par Simon Dienst.</p>
            <h5>Propriété intellectuelle</h5>
            <p>Le contenu du site (textes, images, données scientifiques) est protégé par les réglementations sur les droits d’auteur. Les données scientifiques peuvent être de diverses provenances : données inédites, données éditées par l'auteur des notices ou données reprises et retravaillées par l'auteur des notices. Les contributeurs à la base de données sont tenus de différencier ces cas de figure. Les utilisateurs s’engagent à respecter les droits d'auteurs.</p>
            <h5>Conditions d'utilisation</h5>
            <p>L'utilisation de <?php echo PROJECT->code(); ?> est gratuite et destinée à un usage professionnel ou académique. Toute utilisation abusive ou frauduleuse est interdite. L'utilisation de données publiées dans LOGACer ou un de ses projets (données inédites ou retravaillées) doit être correctement sourcée.</p>
            <h5>Contact</h5>
            <p>Pour toute question : <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulaire de contact</a>.</p>
