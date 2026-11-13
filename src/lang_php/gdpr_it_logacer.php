            <h2>Informativa sulla privacy - <?php echo WEBSITE_NAME; ?></h2>
            <h5>Dati personali raccolti</h5>
            <p>Per gli utenti registrati: cognome, nome, indirizzo e-mail, identificativo, password (crittografata), lingua di navigazione preferita.</p>
            <p>Per gli altri utenti: lingua di navigazione preferita.</p>
            <h5>Finalità della raccolta dei dati</h5>
            <p>I dati vengono utilizzati esclusivamente per la creazione e la gestione degli account utente, al fine di consentire l'accesso alle funzionalità di <?php echo WEBSITE_NAME; ?>, nonché per gestire la lingua di visualizzazione del sito web.</p>
            <h5>Base giuridica</h5>
            <p>Il trattamento dei dati si basa sul consenso dell'utente (registrazione volontaria).</p>
            <h5>Periodo di conservazione dei dati personali</h5>
            <p>I dati vengono conservati fino alla cancellazione dell'account da parte dell'utente (possibile su richiesta: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">modulo di contatto</a>), e per un anno per quanto riguarda la lingua preferita.</p>
            <h5>Diritti degli utenti</h5>
            <p>Accesso, rettifica, cancellazione, opposizione, portabilità. Per esercitare questi diritti: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">modulo di contatto</a>.</p>
            <h5>Sicurezza dei dati personali</h5>
            <p>I dati degli utenti sono protetti mediante misure tecniche (crittografia delle password, accesso sicuro alla banca dati). Il nome e il cognome (o, in mancanza, il nome utente) sono tuttavia accessibili agli altri utenti registrati. In caso di pubblicazione di dati scientifici, anche gli utenti non registrati avranno accesso a queste informazioni. Anche l'amministratore o gli amministratori della banca dati hanno accesso all'indirizzo e-mail utilizzato per la registrazione.</p>
            <h5>Condivisione dei dati personali</h5>
            <p>I dati non vengono e non verranno mai venduti. Non vengono condivisi con terze parti, salvo obblighi di legge.</p>
            <h5>Responsabile del trattamento</h5>
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
            <h5>Visibilità, utilizzo e trattamento dei dati non personali</h5>
            <p>Tutti i dati inseriti da un utente registrato su <?php echo WEBSITE_NAME; ?> sono pubblici, ad eccezione dei dati di progetto (accessibili esclusivamente ai relativi collaboratori), a meno che non sia possibile impostarne diversamente la riservatezza.
                I creatori dei dati sono considerati i loro autori principali. In alcuni casi, possono essere indicati dei collaboratori (interni a <?php echo WEBSITE_NAME; ?>). Spetta a questi ultimi garantire l'autenticità dei dati e il rispetto delle direttive relative al diritto d'autore e alla citazione dei dati scientifici.
                L'amministratore si riserva il diritto di eliminare l'account e i dati di chiunque non rispetti questo principio.</p>
