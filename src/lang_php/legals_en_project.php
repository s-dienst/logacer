            <h2>Legal Notice - <?php echo PROJECT->code(); ?></h2>
            <h5>Publisher of LOGACer</h5>
            <p>
                Simon Dienst
                </br>Service d'histoire de l'art et archéologie de l'Antiquité gréco-romaine (SHAARAGR)
                </br>Département des sciences historiques
                </br>Faculté de Philosophie et lettres
                </br>Université de Liège
                </br>Place du 20-Août, 7
                </br>B-4000 Liège, Belgique
                </br>Mail: Simon.Dienst@uliege.be
                </br>Website: www.logacer.org
            </p>
            <h5>Hosting provider</h5>
            <p>
                For information regarding the hosting provider, please contact the person responsible for the installation via the <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">contact form</a>.
            </p>
            <h5>Person responsible for publication</h5>
            <p>The published data is the sole responsibility of <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?> and under no circumstances does this imply any liability on the part of the hosting provider.</p>
            <h5>Software used</h5>
            <p>The database is published using <a href="https://www.logacer.org">LOGACer - Logiciel Online de Gestion et d'Analyse de la Céramique</a>, software developed by Simon Dienst.</p>
            <h5>Intellectual property</h5>
            <p>The content of the website (texts, images, scientific data) is protected by copyright regulations. Scientific data may come from various sources: unpublished data, data published by the author of the records, or data reused and reworked by the author of the records. Database contributors are required to distinguish between these different cases. Users undertake to respect copyright.</p>
            <h5>Terms of use</h5>
            <p>Use of <?php echo PROJECT->code(); ?> is free of charge and intended for professional or academic purposes. Any abusive or fraudulent use is prohibited. Any use of data published in LOGACer or one of its projects (unpublished or reworked data) must be properly cited.</p>
            <h5>Contact</h5>
            <p>For any questions: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">contact form</a>.</p>
