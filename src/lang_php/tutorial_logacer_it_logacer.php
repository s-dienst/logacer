<?php $return_list = "<p><a href='" . create_url(['']) . "'>Retourner à la page d'accueil</a></p>";
$tuto_button = ""; ?>
    <!-- Barra laterale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['']); ?>'>Torna alla pagina iniziale</a></h6><br>
        <h4 class="px-3">Principi e navigazione</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principi fondamentali</h5></a>
        <a href="#navigation-generale"><h5 class="px-3">II. Navigazione generale</h5></a>
            <a href="#projets">1. Progetti</a>
            <a href="#typologies-globales">2. Tipologie e gruppi di impasti</a>
            <a href="#espace-personnel">3. Area personale</a>
            <a href="#referentiels">4. Repertori di riferimento</a>
            <a href="#gestion-utilisateurs">5. Gestione degli utenti</a>
        <a href="#types-pâtes"><h5 class="px-3">III. Tipi e gruppi di impasti</h5></a>
            <a href="#typologies-types">1. Tipologie e tipi</a>
            <ul>
                <li><a href="#liste-typologies">Elenco delle tipologie</a></li>
                <li><a href="#typologie">Descrizione della tipologia</a></li>
                <li><a href="#types">Descrizione dei tipi</a></li>
            </ul>
            <a href="#pâtes">2. Gruppi di impasti</a>
            <ul>
                <li><a href="#liste-groupes-pâtes">Elenco dei gruppi di impasti</a></li>
                <li><a href="#groupes-pâtes">Descrizione dei gruppi di impasti</a></li>
            </ul>
        <a href="#bibliographie"><h5 class="px-3">IV. Bibliografia</h5></a>
            <a href="#liste-bibliographie">1. Elenco dei riferimenti bibliografici</a>
            <a href="#consulter-bibliographie">2. Consultare un riferimento bibliografico</a>
        <a href="#autres-éléments"><h5 class="px-3">V. Altri elementi</h5></a>
            <a href="#fichiers-génériques">1. File generici</a>
            <a href="#citer-page">2. Citare una pagina</a>
            <a href="#a-propos">3. Informazioni sul sito web</a>
        <a href="#compte-utilisateur"><h5 class="px-3">VI. Account utente</h5></a>
            <a href="#enregistrement-connexion">1. Registrazione e accesso</a>
            <a href="#gestion-compte">2. Gestione dell'account</a>
    </nav>

  <!-- Contenuto principale -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: principi fondamentali e navigazione nello strumento senza effettuare l'accesso</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principi fondamentali</h2>

    <p>L'obiettivo principale di LOGACer è rendere disponibili gli inventari degli oggetti (in particolare quelli ceramici), consentendo al tempo stesso di integrare altre informazioni e di effettuare interrogazioni su questi oggetti. A tal fine, LOGACer si basa su diversi elementi:</p>
    <ul>
        <li>La contestualizzazione dell'<b>oggetto</b>: è l'elemento centrale di LOGACer. L'oggetto appartiene a un <b>contesto</b> (o unità stratigrafica), a sua volta collegato ad altri contesti contemporanei (l'<b>orizzonte del sito</b>). Tutti questi elementi sono stati raccolti nel corso di un'<b>operazione archeologica</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>La cronologia relativa dell'oggetto: gli orizzonti dei siti possono essere raggruppati in <b>orizzonti regionali</b>. Questi si susseguono all'interno di una regione geografica; tale successione è organizzata attraverso <b>gruppi di orizzonti</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>
        <li>La caratterizzazione dell'oggetto: secondo il modello adottato in LOGACer, la ceramica è classificata in base alla <b>categoria</b>, alla <b>funzione</b>, al <b>tipo</b> e all'<b>impasto</b>. I primi due criteri di classificazione sono relativamente standardizzati e limitati nel numero. I tipi, invece, sono molto più numerosi e vengono raggruppati in <b>tipologie</b>. Lo stesso vale per gli impasti, che possono essere organizzati gerarchicamente. Anche la caratterizzazione dei tipi e degli impasti, così come la possibilità di effettuare ricerche su di essi, riveste una particolare importanza. Le categorie, le funzioni, le tipologie e i tipi sono in larga misura collegati a ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>
        <li>Riferimenti: la caratterizzazione dei diversi elementi può essere completata indicando riferimenti <b>bibliografici</b> o aggiungendo <b>file</b>. Inoltre, questi elementi sono gestiti dagli <b>utenti</b> (che in alcuni casi possono svolgere il ruolo di responsabili o collaboratori). Infine, gli oggetti possono essere corredati da <b>illustrazioni</b>, come disegni, fotografie o ingrandimenti;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>
        <li>Collaborazione: i gruppi di lavoro che operano su diversi elementi (siti, orizzonti regionali ecc.) possono riunirli all'interno di <b>progetti</b>, consentendo una gestione più efficace dei diritti di accesso del gruppo.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>
   </section>

    <section id="navigation-generale" class="mb-5">
    <h2>II. Navigazione generale</h2>
    <p>Oltre agli spazi dedicati ai singoli progetti, LOGACer dispone di un'area generale che permette di consultare i progetti disponibili, accedere ai repertori di riferimento condivisi e gestire gli elementi relativi all'intera installazione.</p>
    <p>La navigazione è organizzata attorno a due barre:</p>
    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_1.png" width="80%"></div>-->
        <h3>1. Barra di navigazione generale</h3>
        <p>La barra superiore dà accesso alle principali risorse condivise da tutta l'installazione LOGACer.</p>
            <h4>1.1. Progetti</h4>
            <p>La sezione «Progetti» presenta l'elenco dei progetti disponibili, ciascuno accompagnato da una breve descrizione e da un collegamento al relativo spazio.</p>
            <p>I progetti pubblici sono accessibili a tutti i visitatori, indipendentemente dal fatto che dispongano o meno di un account utente. I progetti privati non vengono visualizzati in questo elenco, ad eccezione degli utenti che vi collaborano.</p>
            <h4>1.2. Tipologie e gruppi di impasti</h4>
            <p>Le sezioni «Tipologie» e «Gruppi di impasti» consentono di accedere ai repertori generali di LOGACer, indipendenti dai singoli progetti.</p>
            <p>Le pagine descrittive delle tipologie e dei gruppi di impasti funzionano in modo analogo a quelle disponibili all'interno dei progetti. Tuttavia, le informazioni relative agli oggetti archeologici non sono accessibili da quest'area generale. In particolare, le pagine dei tipi e dei gruppi di impasti non presentano le distribuzioni geografiche, le illustrazioni, i gruppi di impasti o i tipi associati, gli inventari e le corrispondenze disponibili nei progetti.</p>
            <h4>1.3. Allegati</h4>
            <p>La sezione «Allegati» dà accesso a due risorse condivise:</p>
            <ul>
                <li><b>Bibliografia:</b> elenco dei riferimenti bibliografici registrati in LOGACer. Le modalità di consultazione sono descritte nella sezione IV. Bibliografia;</li>
                <li><b>File generici:</b> elenco dei file messi a disposizione indipendentemente da uno specifico elemento del database. Le modalità di consultazione sono descritte nella sezione V. Altri elementi.</li>
            </ul>
        <h3>2. Area personale</h3>
        <p>La seconda barra di navigazione dà accesso alle funzionalità relative all'account dell'utente e ai suoi contributi personali a LOGACer.</p>
            <h4>2.1. La mia area personale</h4>
            <p>Questa sezione riunisce diverse informazioni e funzionalità relative all'account dell'utente. Le principali funzionalità sono accessibili anche da altre pagine dell'applicazione.</p>
            <h4>2.2. I miei progetti, i miei tipi e i miei gruppi di impasti</h4>
            <p>Queste sezioni permettono di ritrovare i progetti, i tipi e i gruppi di impasti ai quali l'utente partecipa in qualità di creatore, responsabile o collaboratore.</p>
            <p>Offrono quindi un accesso diretto agli elementi associati all'utente, senza dover consultare gli elenchi generali di LOGACer.</p>
            <h4>2.3. Repertori di riferimento</h4>
            <p>La sezione «Repertori di riferimento» riunisce gli elenchi di riferimento utilizzati in LOGACer:</p>
            <ul>
                <li><b>Paesi e regioni:</b> elenco dei paesi e delle relative suddivisioni regionali, con i rispettivi codici e nomi ufficiali;</li>
                <li><b>Categorie:</b> elenco delle categorie utilizzate per caratterizzare gli oggetti. La tabella indica il codice, l'abbreviazione, il nome, l'eventuale presenza in ONICer e il creatore in LOGACer;</li>
                <li><b>Funzioni:</b> elenco delle funzioni utilizzate per caratterizzare gli oggetti. La tabella indica il codice, il nome, l'eventuale presenza in ONICer e il creatore in LOGACer;</li>
                <li><b>Metodi di conteggio:</b> elenco dei metodi di conteggio previsti in LOGACer.</li>
            </ul>
            <p>I collaboratori e gli amministratori possono creare e gestire i repertori generali (ad eccezione dei metodi di conteggio). Gli utenti standard dispongono esclusivamente dell'accesso alle altre funzionalità per le quali sono autorizzati.</p>
            <h4>2.4. Gestione degli utenti</h4>
            <p>Questa sezione è riservata agli amministratori di LOGACer. Consente di:</p>
            <ul>
                <li>Convalidare le nuove registrazioni;</li>
                <li>Consultare l'elenco degli utenti registrati;</li>
                <li>Modificare i diritti generali degli utenti in LOGACer, assegnando loro il ruolo di amministratore, collaboratore o utente standard;</li>
                <li>Eliminare un account utente quando necessario.</li>
            </ul>
            <p>Questi diritti generali sono distinti da quelli assegnati agli utenti all'interno dei singoli progetti.</p>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>III. Tipi e gruppi di impasti</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Tipologie e tipi</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Elenco delle tipologie</h4>
                <p>L'elenco è organizzato in base alla categoria a cui è associata ciascuna tipologia. Alcune tipologie sono associate a più categorie e compaiono quindi sotto ciascuna di esse. Le tipologie che non sono state associate ad almeno una categoria (e che pertanto non possono essere utilizzate per collegare gli oggetti) sono raggruppate alla fine dell'elenco.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Descrizione della tipologia</h4>
                <p>Quando si fa clic su una tipologia, si accede alla relativa pagina descrittiva. Questa pagina contiene innanzitutto le seguenti informazioni:</p>
                <ul>
                    <li>La persona che ha aggiunto la tipologia a LOGACer e i collaboratori che possono integrare informazioni nella pagina;</li>
                    <li>Una descrizione della tipologia, di lunghezza e struttura variabili;</li>
                    <li>I riferimenti bibliografici associati alla tipologia;</li>
                    <li>I file associati alla tipologia;</li>
                    <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>La scheda «Categorie» elenca le categorie per le quali la tipologia (e quindi i relativi tipi) può essere utilizzata.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>La scheda «Tipi» elenca i tipi associati alla tipologia, in ordine alfabetico in base ai rispettivi codici. Se alcuni tipi possiedono dei sottotipi, questi ultimi non vengono visualizzati in questa sezione.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. I tipi</h4>
                <p>Quando si seleziona un tipo attraverso una tipologia, si ha accesso soltanto alle informazioni generali, a differenza di quanto avviene navigando all'interno di un progetto:</p>
                    <ul>
                        <li>La tipologia a cui appartiene il tipo (e, se del caso, il tipo principale del sottotipo);</li>
                        <li>La persona che ha aggiunto la tipologia a LOGACer e quella che ha aggiunto il tipo;</li>
                        <li>Una descrizione del tipo, di lunghezza e struttura variabili;</li>
                        <li>Se presenti, i diversi sottotipi;</li>
                        <li>Una datazione (anche in forma di testo libero);</li>
                        <li>La bibliografia;</li>
                        <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_2.png" width="80%"></div>-->
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Gruppi di impasti</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Elenco dei gruppi di impasti</h4>
                <p>Al momento l'elenco non è ordinato secondo alcun criterio. Se alcuni gruppi di impasti possiedono dei sottogruppi, questi ultimi non vengono visualizzati in questa sezione.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. I gruppi di impasti</h4>
                <p>Quando si seleziona un gruppo di impasti (dall'elenco dei gruppi o da un inventario), si accede a diverse informazioni generali:</p>
                    <ul>
                        <li>Se presente, il gruppo principale del sottogruppo;</li>
                        <li>La persona che ha aggiunto il gruppo di impasti a LOGACer;</li>
                        <li>Una descrizione del gruppo di impasti, di lunghezza e struttura variabili;</li>
                        <li>Se presenti, i diversi sottogruppi;</li>
                        <li>Un'origine (anche in forma di testo libero);</li>
                        <li>La bibliografia;</li>
                        <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                    </ul>
                    <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_3.png" width="80%"></div>-->
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>IV. Bibliografia</h2>
        <p>Come indicato in altre sezioni, è possibile inserire riferimenti bibliografici per diversi elementi: operazione archeologica, orizzonte del sito, contesto, orizzonte regionale, tipologia, tipo o gruppo di impasti. La funzionalità bibliografica è piuttosto semplice, ma i riferimenti possono essere consultati in LOGACer.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Elenco dei riferimenti bibliografici</h3>
            <p>L'elenco dei riferimenti bibliografici è accessibile dalla barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>L'elenco è organizzato in ordine alfabetico in base alle abbreviazioni.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Consultare un riferimento bibliografico</h3>
            <p>È possibile consultare un riferimento facendo clic su di esso nel punto in cui viene visualizzato. In questo modo si possono visualizzare il riferimento completo e gli elementi del database a esso collegati.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In alcuni casi è stato indicato anche un numero di pagina. Questa informazione è disponibile sia nella pagina dell'elemento interessato sia in quella del riferimento bibliografico.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>V. Altri elementi</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Elenco dei file scaricabili</h3>
            <p>Un elenco di file scaricabili è accessibile dalla barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>Si tratta di file che non sono collegati a un elemento specifico (operazione archeologica, orizzonte del sito, contesto, orizzonte regionale ecc.), ma che hanno carattere generale e sono stati ritenuti utili da condividere. Per scaricarli è sufficiente fare clic sul file desiderato.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citare una pagina</h3>
            <p>In fondo a ogni pagina che descrive un elemento del database viene proposto un modello di citazione per fare riferimento a tale elemento nella bibliografia. Numerosi esempi sono riportati in altre sezioni di questo tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informazioni sul sito web</h3>
            <p>Queste informazioni sono disponibili principalmente nella sezione «Supporto e informazioni» della barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Le schede comprendono:</p>
            <ul>
                <li>Una presentazione più approfondita di LOGACer nella sezione «Presentazione e contatti»;</li>
                <li>Un modulo di contatto per l'amministratore, disponibile nella stessa scheda;</li>
                <li>Informazioni sull'infrastruttura di cui fa parte LOGACer nella sezione «Strumenti associati», in particolare sugli sviluppi complementari come ONICer e DBCer.</li>
            </ul>
            <p>Altre pagine sono accessibili nella parte inferiore di ogni pagina:</p>
            <ul>
                <li>Le note legali e l'informativa sulla gestione dei dati, necessarie per ogni sito web;</li>
            </ul>
        </section>

    <section id="compte-utilisateur" class="mb-5">
    <h2>VI. Account utente</h2>
        <section id="enregistrement-connexion" class="mb-5">
        <h3>1. Registrazione e accesso</h3>
            <h4>1.1. Creare un account</h4>
            <p>Per accedere alle funzionalità riservate agli utenti registrati è necessario disporre di un account LOGACer. È possibile accedere dalla barra di navigazione generale facendo clic su «Accedi».</p>
            <p>Dalla pagina di accesso, i nuovi utenti possono raggiungere il modulo di registrazione facendo clic su «Registrati qui!».</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_4.png" width="80%"></div>-->
            <p>Il modulo di registrazione richiede le seguenti informazioni:</p>
            <ul>
                <li>Un nome utente;</li>
                <li>Un indirizzo e-mail;</li>
                <li>Una password, da confermare;</li>
                <li>Nome e cognome (facoltativi).</li>
            </ul>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_5.png" width="80%"></div>-->
            <p>Dopo l'invio del modulo, l'account deve essere approvato da un amministratore di LOGACer prima di poter essere utilizzato. L'utente riceverà una comunicazione via e-mail relativa all'approvazione. Si consiglia di controllare anche la cartella della posta indesiderata. Se l'approvazione tarda ad arrivare, è possibile contattare l'amministratore dell'installazione.</p>
            <h4>1.2. Primo accesso</h4>
            <p>Una volta approvato l'account, un'e-mail fornisce le informazioni necessarie per attivarlo.</p>
            <p>Al primo accesso è necessario utilizzare la chiave di attivazione ricevuta via e-mail al posto della password impostata durante la registrazione.</p>
            <p>Una volta completato il primo accesso, l'utente può utilizzare le funzionalità di LOGACer corrispondenti ai propri diritti.</p>
            <p>Se si inserisce più volte una password errata, l'account verrà bloccato. Sarà quindi necessario contattare l'amministratore per sbloccarlo. In questo modo sarà possibile accedere utilizzando una nuova chiave di attivazione e impostare una nuova password.</p>
            </section>

        <section id="gestion-compte" class="mb-5">
        <h3>2. Gestione dell'account</h3>
        <p>Quando un utente ha effettuato l'accesso, il suo nome compare nella barra di navigazione. Un menu a discesa consente, tra le altre cose, di accedere alla gestione del proprio account e di disconnettersi.</p>
            <h4>2.1. Il mio account</h4>
            <p>La sezione «Il mio account» permette di consultare e modificare le proprie informazioni personali:</p>
            <ul>
                <li>Nome utente;</li>
                <li>Indirizzo e-mail;</li>
                <li>Password;</li>
                <li>Nome e cognome.</li>
            </ul>
            <p>Per modificare la password, è necessario inserire la nuova password e confermarla. Se non viene indicata una nuova password, quella attuale viene mantenuta.</p>
            <!--<div style="text-align: center; margin:15px"><img src="<?php //echo BASE_STATIC; ?>static/pictures_public/Tutorial_logacer_6.png" width="80%"></div>-->
            <p>Questa pagina consente inoltre di personalizzare alcune impostazioni di visualizzazione:</p>
            <ul>
                <li><b>Metodi di conteggio:</b> scelta dei metodi di conteggio da visualizzare negli inventari, tra quelli utilizzati nei dati consultati;</li>
                <li><b>Modalità semplificata:</b> attivazione di una modalità di visualizzazione che propone aiuti contestuali, in particolare sotto forma di suggerimenti a comparsa, per facilitare la comprensione e l'utilizzo di LOGACer.</li>
            </ul>
            <p>Le modifiche devono essere salvate affinché vengano applicate.</p>
            <h4>2.2. Disconnettersi</h4>
            <p>Per terminare la sessione, è sufficiente selezionare «Disconnetti» nel menu a discesa associato al proprio nome nella barra di navigazione.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
