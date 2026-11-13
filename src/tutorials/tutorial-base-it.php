    <!-- Barre latérale -->
    <nav id="sidebarMenu" class="sidebar">
        <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Indietro: Elenco dei tutorial</a></h6><br>
        <h4 class="px-3">Principi e navigazione</h4>
        <a href="#principes-base"><h5 class="px-3">I. Principi di base</h5></a>
        <a href="#opération-objet"><h5 class="px-3">II. Dall'operazione all'oggetto</h5></a>
        <a href="#liste-opérations">1. Elenco delle operazioni</a>
        <a href="#opération-archéologique">2. Operazione archeologica</a>
        <a href="#horizon-site">3. Orizzonte-sito</a>
        <a href="#contexte-inventaire">4. Contesto e inventario</a>
        <a href="#objet-illustration">5. Oggetto e illustrazione/i</a>
        <a href="#horizons-régionaux"><h5 class="px-3">III. Orizzonti regionali</h5></a>
        <a href="#liste-groupes-horizons">1. Elenco dei gruppi di orizzonti</a>
        <a href="#groupe-horizons">2. Descrizione del gruppo di orizzonti</a>
        <a href="#horizon-régional">3. Orizzonti regionali e reperti associati</a>
        <a href="#types-pâtes"><h5 class="px-3">IV. Tipi e gruppi di impasti</h5></a>
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
        <a href="#bibliographie"><h5 class="px-3">V. Bibliografia</h5></a>
        <a href="#liste-bibliographie">1. Elenco dei riferimenti</a>
        <a href="#consulter-bibliographie">2. Consultare un riferimento</a>
        <a href="#autres-éléments"><h5 class="px-3">VI. Altri elementi</h5></a>
        <a href="#fichiers-génériques">1. File generici</a>
        <a href="#citer-page">2. Citare una pagina</a>
        <a href="#a-propos">3. Informazioni sul sito web</a>
        <a href="#recherche-simple">4. Ricerca semplice</a>
        <a href="#enregistrement-connexion">5. Registrazione e accesso</a>
    </nav>

  <!-- Contenu principal -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: principi di base e navigazione nello strumento senza effettuare l'accesso</h1>
    <section id="introduction" class="mb-5">

    <section id="principes-base" class="mb-5">
    <h2>I. Principi di base</h2>

    <p>L'obiettivo centrale di LOGACer, utilizzato da CeVICA, è consentire la messa a disposizione degli inventari degli oggetti (in particolare della ceramica), permettendo al contempo di incorporare altre informazioni e di eseguire interrogazioni su tali oggetti. A questo scopo, LOGACer si basa su diversi elementi:</p>
    <ul>
        <li>La contestualizzazione dell'<b>oggetto</b>: è la parte centrale di LOGACer. L'oggetto fa parte di un <b>contesto</b> (o unità stratigrafica), a sua volta collegato ad altri contesti contemporanei (l'<b>orizzonte-sito</b>), il tutto essendo stato raccolto durante un'<b>operazione archeologica</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Site.png" style="max-width:127px"></div>
        <li>La cronologia relativa dell'oggetto: gli orizzonti-sito possono essere raggruppati in <b>orizzonti regionali</b>. Questi si susseguono all'interno di una regione geografica; tale successione è raggruppata attraverso <b>gruppi di orizzonti</b>;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Chronologie.png" style="max-width:304px"></div>        
        <li>La caratterizzazione dell'oggetto: la ceramica è classificata, secondo il modello conservato in LOGACer, in base alla sua <b>categoria</b>, alla sua <b>funzione</b>, al suo <b>tipo</b> e al suo <b>gruppo di impasti</b>. I primi due criteri di classificazione sono abbastanza standardizzati e limitati. I tipi, invece, sono molto più numerosi e raggruppati in <b>tipologie</b>; lo stesso vale per i gruppi di impasti, che possono essere gerarchizzati. La caratterizzazione dei tipi e dei gruppi di impasti e la possibilità di effettuare ricerche su di essi sono anch'esse importanti. Le categorie, le funzioni, le tipologie e i tipi sono ampiamente collegati a ONICer;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Classification.png" style="max-width:686px"></div>        
        <li>I riferimenti: è possibile completare la caratterizzazione di questi diversi elementi facendo riferimento a una <b>bibliografia</b> di riferimento o aggiungendo <b>file</b>. Inoltre, questi elementi sono gestiti da <b>utenti</b> (responsabili o collaboratori in alcuni casi). Infine, gli oggetti possono essere corredati da <b>illustrazioni</b>, come disegni, fotografie o ingrandimenti;</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_References.png" style="max-width:837px"></div>        
        <li>La collaborazione: un'équipe che lavora su diversi di questi elementi (siti, orizzonti regionali...) può ritrovarli riuniti all'interno di <b>progetti</b>, consentendo una migliore gestione dei diritti di tale équipe.</li>
        <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Modele_Projet.png" style="max-width:837px"></div>
    </ul>

    <p>La navigazione è stata concepita per privilegiare l'approccio contestuale (dall'operazione archeologica all'oggetto), tenendo conto al contempo dei diversi collegamenti: presentazione degli oggetti per orizzonti regionali, tipi e gruppi di impasti (nonché delle relative illustrazioni), presentazione degli orizzonti-sito per orizzonti regionali (con le categorie e i tipi presenti), elementi collegati a un riferimento bibliografico, nonché interrogazioni più elaborate.</p>
    </section>

    <section id="opération-object" class="mb-5">
    <h2>II. Navigazione: dall'operazione archeologica all'oggetto</h2>
        <section id="liste-opérations" class="mb-5">
        <h3>1. Elenco delle operazioni archeologiche</h3>

            <p>L'elenco delle operazioni archeologiche è accessibile tramite la barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_1.png" width="80%"></div>
            <p>All'interno di questo elenco, è possibile raggiungere l'operazione che interessa tramite una mappa interattiva oppure tramite l'elenco delle operazioni archeologiche.</p>

            <h4>1.1. Mappa</h4>
                <p>Ogni operazione archeologica è rappresentata da un indicatore sulla mappa. Cliccando sull'indicatore, è possibile vedere a quale operazione archeologica corrisponde. È possibile accedervi cliccando su di esso.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2.png" width="80%"></div>
                <p>Se più operazioni archeologiche hanno le stesse coordinate, vengono visualizzate sullo stesso indicatore.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_3.png" width="80%"></div>
                <p>Infine, se una zona contiene molte operazioni archeologiche, al loro posto appare un disco colorato con il numero di operazioni presenti in quella zona. Cliccandovi sopra, è possibile effettuare uno zoom e suddividere questo indicatore in diversi altri dischi e/o indicatori individuali. È inoltre possibile effettuare normalmente lo zoom.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_2b.png" width="80%"></div>

            <h4>1.2. Elenco delle operazioni archeologiche</h4>
                <p>Cliccando sulla scheda corrispondente, è inoltre possibile accedere a una tabella riepilogativa delle operazioni archeologiche.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_4.png" width="80%"></div>
                <p>La tabella è organizzata per paese e poi per regione. Le operazioni archeologiche sono visualizzate in ordine alfabetico secondo il codice. Quelle che non sono state associate a una regione sono raggruppate alla fine dell'elenco. Cliccando sulle intestazioni delle colonne, è possibile ordinare la tabella in base alla colonna corrispondente (in ordine alfabetico crescente, poi decrescente cliccando una seconda volta).</p>
                <p>È infine possibile filtrare la tabella in base a uno o più campi. I filtri vengono visualizzati cliccando su «Visualizza i filtri della tabella». È quindi sufficiente inserire una parte del contenuto di un campo per filtrare la tabella.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
        </section>

        <section id="opération-archéologique" class="mb-5">
        <h3>2. Descrizione dell'operazione archeologica</h3>
            <p>Quando si clicca su un'operazione archeologica, si accede alla sua pagina descrittiva. Questa pagina contiene informazioni su:</p>
            <ul>
                <li>La persona che ha aggiunto l'operazione a CeVICA e i collaboratori che possono alimentare la pagina;</li>
                <li>Le informazioni geografiche: regione, latitudine e longitudine;</li>
                <li>Una descrizione dell'operazione archeologica, che può avere lunghezza e struttura variabili;</li>
                <li>I diversi orizzonti-sito presenti. Quando alcuni contesti non sono stati associati a un orizzonte-sito, è possibile raggiungerli cliccando su «Contesti senza orizzonte-sito»;</li>
                <li>I riferimenti bibliografici associati all'operazione archeologica;</li>
                <li>I file associati all'operazione archeologica;</li>
                <li>Le informazioni necessarie per citare correttamente la pagina.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_5.png" width="80%"></div>
            <p>È possibile che alcune di queste sezioni siano assenti, a seconda di quanto è stato compilato o associato all'operazione archeologica. Per quanto riguarda la bibliografia, se l'operazione archeologica (o l'orizzonte-sito o il contesto) non è mai stata pubblicata, ciò viene indicato chiaramente.</p>
            <p>Uno dei file, presente automaticamente, consente di scaricare l'intero inventario dell'operazione archeologica. Lo stesso vale per l'orizzonte-sito e il contesto.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_6.png" width="80%"></div>
            <p>A seconda di quanto indicato durante la compilazione del sito, lo sfondo può essere diverso e un riquadro può indicare che si tratta di dati estratti da una pubblicazione. Queste informazioni permettono di evidenziare i casi in cui l'autore della scheda non è uno dei ricercatori che hanno lavorato sull'operazione archeologica, ma i dati sono stati messi online nell'ambito di un lavoro più ampio, come parte di una revisione della letteratura.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_7.png" width="80%"></div>
        </section>

        <section id="horizon-site" class="mb-5">
        <h3>3. Descrizione dell'orizzonte-sito</h3>
            <p>Cliccando su uno degli orizzonti-sito, si apre una nuova finestra con le seguenti informazioni:</p>
            <ul>
                <li>L'operazione archeologica alla quale appartiene l'orizzonte-sito;</li>
                <li>La persona che ha aggiunto l'operazione a CeVICA e quella che ha aggiunto l'orizzonte-sito;</li>
                <li>Le informazioni sull'orizzonte regionale, se l'orizzonte-sito è associato a un orizzonte regionale;</li>
                <li>Una descrizione dell'orizzonte-sito, che può avere lunghezza e struttura variabili;</li>
                <li>I diversi contesti presenti;</li>
                <li>I riferimenti bibliografici associati all'orizzonte-sito (generalmente gli stessi dell'operazione archeologica, salvo modifica esplicita da parte dell'autore della scheda);</li>
                <li>I file associati all'orizzonte-sito;</li>
                <li>Le informazioni necessarie per citare correttamente la pagina.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_8.png" width="80%"></div>
            <p>L'orizzonte regionale è cliccabile. Viene specificata l'importanza dell'orizzonte-sito nella definizione dell'orizzonte regionale (maggiore, minore, incerta o sconosciuta).</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_9.png" width="80%"></div>
        </section>

        <section id="contexte-inventaire" class="mb-5">
        <h3>4. Descrizione del contesto e inventario</h3>
            <p>Facendo clic su uno dei contesti, si accede alla relativa finestra, con l’inventario. Le informazioni sono nel complesso simili a quelle della fase, quando presenti. Una scheda permette di passare dalla descrizione all’inventario.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_10.png" width="80%"></div>
            <p>Quando non è presente una descrizione, l’inventario viene visualizzato direttamente senza scheda. Può essere esportato tramite il pulsante blu, così come dalla sezione dei file associati.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11.png" width="80%"></div>
            <p>Facendo clic sul numero di inventario, è possibile accedere ai dettagli dell’oggetto e alle relative illustrazioni.</p>
            <p>Le categorie, le funzioni, i tipi e i gruppi di paste possono essere repertoriati in CeVICA. In questo caso, la categoria e la funzione sono indicate in nero, mentre il tipo e il gruppo di paste sono indicati in blu (è possibile fare clic su di essi per accedere alla relativa scheda). Passando il mouse sulla categoria o sul gruppo di paste, è possibile visualizzarne la denominazione completa.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_12.png" width="80%"></div>
            <p>Se uno di questi elementi è assente dal database, viene indicato in grigio e con caratteri più piccoli.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13.png" width="80%"></div>
            <p>È possibile ordinare la tabella facendo clic sulle intestazioni delle colonne. Si noti che le categorie, le funzioni, i tipi e i gruppi di paste sono ordinati in base al loro codice e non a quanto visualizzato; gli elementi non repertoriati vengono riportati in ordine alfabetico alla fine dell’elenco.</p>
            <p>È inoltre possibile filtrare la tabella facendo clic sulla scheda dei filtri e inserendo quindi i termini di ricerca. Le categorie, le funzioni e i tipi possono essere cercati anche in base al loro codice.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_11b.png" width="80%"></div>
            <p>La presenza di un’illustrazione è indicata da un « Sì » nella casella corrispondente.</p>
            <p>Per impostazione predefinita, vengono recuperate solo le prime 200 righe dell’inventario, per motivi di prestazioni. È possibile recuperare le righe aggiuntive (200 alla volta) facendo clic su « Carica altro ».</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_13b.png" width="80%"></div>
        </section>

        <section id="objet-illustration" class="mb-5">
        <h3>5. Descrizione dell’oggetto e illustrazione/i</h3>
            <p>Facendo clic sull’oggetto, vengono riprese le stesse informazioni presenti nei contesti, sotto forma di elenco.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_14.png" width="60%"></div>
            <p>Una scheda permette di consultare le illustrazioni, se presenti per l’oggetto. È possibile visualizzare le illustrazioni in formato più grande facendo clic su di esse.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_15.png" width="80%"></div>
            <p>Una volta visualizzata l’illustrazione, è possibile tornare alla visualizzazione di base facendo clic accanto all’immagine o sulla croce, in alto a destra.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_16.png" width="80%"></div>
        </section>
    </section>

    <section id="horizons-régionaux" class="mb-5">
    <h2>III. Orizzonti regionali</h2>
        <section id="liste-groupes-horizons" class="mb-5">
        <h3>1. Elenco dei gruppi di orizzonti</h3>
            <p>L’elenco degli orizzonti regionali è accessibile tramite la barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_17.png" width="80%"></div>
            <p>L’elenco è organizzato per paese e quindi per regione. I gruppi di orizzonti sono visualizzati in ordine alfabetico in base al codice. Quando un gruppo di orizzonti si estende su più regioni, è presente più volte. Quelli che non sono stati associati a una regione sono raggruppati alla fine dell’elenco.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_18.png" width="50%"></div>
        </section>

        <section id="groupe-horizons" class="mb-5">
        <h3>2. Descrizione del gruppo di orizzonti</h3>
            <p>Facendo clic su un gruppo di orizzonti, si accede alla relativa pagina descrittiva. Questa pagina contiene informazioni su:</p>
            <ul>
                <li>La persona che ha aggiunto il gruppo a CeVICA e i collaboratori che possono alimentare la pagina;</li>
                <li>Le regioni interessate dagli orizzonti;</li>
                <li>Una descrizione del gruppo di orizzonti, la cui lunghezza e organizzazione possono variare;</li>
                <li>I diversi orizzonti regionali presenti (alcuni dei quali possono essere suddivisi internamente in sotto-orizzonti);</li>
                <li>Le relative referenze bibliografiche;</li>
                <li>I file associati;</li>
                <li>Le informazioni necessarie per citare correttamente la pagina.</li>
            </ul>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_19.png" width="80%"></div>
            <p>Alcune di queste sezioni possono essere assenti, a seconda delle informazioni inserite o collegate all’operazione archeologica. Per quanto riguarda la bibliografia, se l’operazione archeologica (o l’orizzonte-sito o il contesto) non è mai stata pubblicata, ciò viene chiaramente indicato.</p>
        </section>

        <section id="horizon-régional" class="mb-5">
        <h3>3. Gli orizzonti regionali e il materiale associato</h3>
            <p>Quando si seleziona un orizzonte (dal gruppo, da una fase o da un inventario), si ha accesso a diverse informazioni e a più schede.</p>
            <p><b>Importante:</b> Quando un orizzonte presenta più sotto-orizzonti, le informazioni visualizzate riguardano esclusivamente l’orizzonte generico e non i sotto-orizzonti.</p>

            <h4>3.1. Informazioni generali</h4>
                <p>Sono riportati qui:</p>
                <ul>
                    <li>Il gruppo a cui appartiene l’orizzonte regionale;</li>
                    <li>La persona che ha aggiunto il gruppo di orizzonti a CeVICA e quella che ha aggiunto l’orizzonte regionale;</li>
                    <li>Il numero di oggetti repertoriati (righe di inventario) per questo orizzonte.</li>
                </ul>

            <h4>3.2. Descrizione</h4>
                <p>La descrizione comprende:</p>
                <ul>
                    <li>Una descrizione dell’orizzonte, la cui lunghezza e organizzazione possono variare;</li>
                    <li>Se del caso, i diversi sotto-orizzonti presenti;</li>
                    <li>Una datazione (anche in forma libera);</li>
                    <li>Gli orizzonti-sito che costituiscono l’orizzonte regionale, nonché il loro grado di importanza per l’orizzonte;</li>
                    <li>I file associati;</li>
                    <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                </ul> 
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_20.png" width="80%"></div>

            <h4>3.3. Distribuzione</h4>
                <p>La distribuzione presenta una mappa dei diversi orizzonti-sito che costituiscono l’orizzonte regionale. Facendo clic su un indicatore, è possibile vedere l’orizzonte-sito (o gli orizzonti-sito) presenti in quel punto, nonché il numero di oggetti appartenenti a tale orizzonte-sito.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_21.png" width="80%"></div>

            <h4>3.4. Elenco dei tipi</h4>
                <p>Una tabella, che può essere ordinata, elenca tutti i tipi presenti, per categoria, all’interno dell’orizzonte. Il numero di occorrenze indica il numero di righe di inventario corrispondenti a questo tipo per tale orizzonte.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_22.png" width="80%"></div>
                <p>È possibile ordinare la tabella, tenendo conto del fatto che per le categorie e i tipi viene utilizzato il codice e non l’abbreviazione o il nome. È inoltre possibile filtrare la tabella tramite il menu dei filtri, visualizzabile facendo clic su di esso.</p>

            <h4>3.5. Illustrazioni</h4>
                <p>Questa scheda contiene tutte le illustrazioni degli oggetti presenti nell’orizzonte. È possibile ordinarle in base al loro tipo.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_23.png" width="80%"></div>
                <p>È possibile visualizzare queste illustrazioni in formato più grande facendo clic su di esse. Una volta visualizzata l’illustrazione, è possibile tornare alla visualizzazione di base facendo clic accanto all’immagine o sulla croce, in alto a destra.</p>

            <h4>3.6. Inventario</h4>
                <p>Quest’ultima scheda fornisce l’inventario completo dell’orizzonte regionale. Funziona allo stesso modo dell’inventario del contesto, con in più i codici dei siti, degli orizzonti-sito e dei contesti. È possibile fare clic su questi codici per accedere alla relativa scheda, oppure semplicemente passarvi sopra con il mouse per visualizzarne il nome.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_24.png" width="80%"></div>
                <p>La tabella può essere ordinata e filtrata nello stesso modo dell’inventario del contesto ed è anch’essa limitata per impostazione predefinita a 200 righe di inventario.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_25.png" width="80%"></div>
                <p>Gli aspetti relativi ai nomi pubblicati delle categorie, delle funzioni, dei tipi e dei gruppi di paste, quando differiscono da quelli di CeVICA, saranno aggiunti in seguito (si tratta al momento di una funzione non utilizzata).</p>
        </section>
    </section>

    <section id="types-pâtes" class="mb-5">
    <h2>IV. Tipi e gruppi di paste</h2>
        <section id="typologies-types" class="mb-5">
        <h3>1. Tipologie e tipi</h3>
            <section id="liste-typologies" class="mb-5">
            <h4>1.1. Elenco delle tipologie</h4>
                <p>L’elenco delle tipologie è accessibile tramite la barra superiore.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_26.png" width="80%"></div>
                <p>L’elenco è organizzato in base alla categoria a cui è associata la tipologia. Alcune tipologie sono associate a più categorie e compaiono quindi per ciascuna di esse. Le tipologie che non sono state associate ad almeno una categoria (e che quindi non possono essere utilizzate per collegare gli oggetti) sono raggruppate alla fine dell’elenco.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_27.png" width="60%"></div>
            </section>

            <section id="typologie" class="mb-5">
            <h4>1.2. Descrizione della tipologia</h4>
                <p>Facendo clic su una tipologia, si accede alla relativa pagina descrittiva. Questa pagina contiene innanzitutto informazioni su:</p>
                <ul>
                    <li>La persona che ha aggiunto la tipologia a CeVICA e i collaboratori che possono alimentare la pagina;</li>
                    <li>Una descrizione della tipologia, la cui lunghezza e organizzazione possono variare;</li>
                    <li>Le referenze bibliografiche associate all’operazione archeologica;</li>
                    <li>I file associati all’operazione archeologica;</li>
                    <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                </ul>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_28.png" width="80%"></div>
                <p>La scheda « Categorie » elenca le categorie per le quali la tipologia (e quindi i suoi tipi) può essere utilizzata.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_29.png" width="70%"></div>
                <p>La scheda « Tipi » elenca, in ordine alfabetico dei codici, i tipi associati alla categoria. Se alcuni tipi presentano dei sottotipi, questi ultimi non vengono visualizzati qui.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_30.png" width="50%"></div>
            </section>

            <section id="types" class="mb-5">
            <h4>1.3. I tipi e il materiale associato</h4>
                <p>Quando si seleziona un tipo (tramite una tipologia o da un inventario), si ha accesso a diverse informazioni e a più schede.</p>
                <p><b>Importante:</b> Quando un tipo presenta più sottotipi, le informazioni visualizzate riguardano esclusivamente il tipo generico e non i sottotipi.</p>

                <h5>1.3.1. Informazioni generali</h5>
                    <p>Sono riportati qui:</p>
                    <ul>
                        <li>La tipologia a cui appartiene il tipo (ed eventualmente il tipo principale del sottotipo);</li>
                        <li>La persona che ha aggiunto la tipologia a CeVICA e quella che ha aggiunto il tipo;</li>
                        <li>Il numero di oggetti repertoriati (righe di inventario) per questo tipo.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_31.png" width="80%"></div>

                <h5>1.3.2. Distribuzione</h5>
                    <p>La distribuzione è presentata tramite una mappa interattiva oppure tramite l’elenco delle operazioni archeologiche che comprendono questo tipo.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_32.png" width="80%"></div>
                    <p>Come per l’elenco delle operazioni archeologiche, facendo clic su un indicatore è possibile visualizzare le operazioni archeologiche e il numero di righe di inventario identificate come appartenenti a questo tipo.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_33.png" width="80%"></div>
                    <p>L’elenco delle operazioni archeologiche è presentato sotto forma di tabella, con gli stessi dati. È possibile accedere all’operazione archeologica o all’inventario incrociato dell’operazione archeologica e del tipo (facendo clic su « visualizza »).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_34.png" width="80%"></div>
                    <p>La tabella può inoltre essere ordinata e filtrata.</p>

                <h5>1.3.3. Descrizione</h5>
                    <p>La descrizione comprende:</p>
                    <ul>
                        <li>Una descrizione del tipo, la cui lunghezza e organizzazione possono variare;</li>
                        <li>Se del caso, i diversi sottotipi presenti;</li>
                        <li>Una datazione (anche in forma libera);</li>
                        <li>La bibliografia;</li>
                        <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_35.png" width="80%"></div>

                <h5>1.3.4. Illustrazioni</h5>
                    <p>Questa scheda contiene tutte le illustrazioni degli oggetti di questo tipo. È possibile ordinarle in base al tipo di illustrazione.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_36.png" width="80%"></div>
                    <p>È possibile visualizzare queste illustrazioni in formato più grande facendo clic su di esse. Una volta visualizzata l’illustrazione, è possibile tornare alla visualizzazione di base facendo clic accanto all’immagine o sulla croce, in alto a destra.</p>

                <h5>1.3.5. Gruppi di paste</h5>
                    <p>Questa scheda elenca i gruppi di paste repertoriati per questo tipo. È possibile consultare il gruppo di paste oppure l’inventario degli oggetti corrispondenti al tipo e al gruppo di paste selezionato.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_37.png" width="80%"></div>

                <h5>1.3.6. Inventario</h5>
                    <p>Quest’ultima scheda fornisce l’inventario completo del tipo. Funziona allo stesso modo dell’inventario del contesto, con in più i codici dei siti, degli orizzonti-sito e dei contesti. È possibile fare clic su questi codici per accedere alla relativa scheda, oppure semplicemente passarvi sopra con il mouse per visualizzarne il nome.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_38.png" width="80%"></div>
                    <p>La tabella può essere ordinata e filtrata nello stesso modo dell’inventario del contesto ed è anch’essa limitata per impostazione predefinita a 200 righe di inventario.</p>

                <h5>1.3.7. Corrispondenze</h5>
                    <p>Questa scheda, relativa ai nomi pubblicati dei tipi quando differiscono da quelli di CeVICA, sarà descritta in seguito (si tratta al momento di una funzione non utilizzata).</p>
            </section>
        </section>

        <section id="pâtes" class="mb-5">
        <h3>2. Gruppi di impasti</h3>
            <section id="liste-groupes-pâtes" class="mb-5">
            <h4>2.1. Elenco dei gruppi di impasti</h4>
                <p>L’elenco dei gruppi di impasti è accessibile tramite la barra superiore.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_40.png" width="80%"></div>
                <p>Al momento l’elenco non è ordinato. Se alcuni gruppi di impasti hanno dei sottogruppi, questi ultimi non compaiono qui.</p>
                <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_41.png" width="50%"></div>
            </section>

            <section id="groupes-pâtes" class="mb-5">
            <h4>2.2. I gruppi di impasti e i materiali ad essi associati</h4>
                <p>Quando si seleziona un gruppo di impasti (tramite l’elenco dei gruppi o da un inventario), si ha accesso a diverse informazioni e a più schede.</p>
                <p><b>Importante:</b> Quando un gruppo di impasti ha più sottogruppi, le informazioni presenti riguardano esclusivamente il gruppo generico e non i sottogruppi.</p>

                <h5>2.2.1. Informazioni generali</h5>
                    <p>Qui sono riportati:</p>
                    <ul>
                        <li>Eventualmente, il gruppo principale del sottogruppo;</li>
                        <li>La persona che ha aggiunto il gruppo di impasti a CeVICA;</li>
                        <li>Il numero di oggetti censiti (righe di inventario) per questo gruppo di impasti.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_42.png" width="70%"></div>

                <h5>2.2.2. Distribuzione</h5>
                    <p>La distribuzione è presentata tramite una mappa interattiva oppure tramite l’elenco delle operazioni archeologiche che comprendono questo gruppo di impasti.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_43.png" width="80%"></div>
                    <p>Come per l’elenco delle operazioni archeologiche, facendo clic su un indicatore è possibile visualizzare le operazioni archeologiche e il numero di righe di inventario identificate come appartenenti a questo gruppo di impasti.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_44.png" width="80%"></div>
                    <p>L’elenco delle operazioni archeologiche è presentato sotto forma di tabella, con gli stessi dati. È possibile accedere all’operazione archeologica oppure all’inventario incrociato dell’operazione archeologica e del gruppo di impasti (facendo clic su « vedere »).</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_45.png" width="80%"></div>
                    <p>La tabella può inoltre essere ordinata e filtrata.</p>

                <h5>2.2.3. Descrizione</h5>
                    <p>La descrizione comprende:</p>
                    <ul>
                        <li>Una descrizione del gruppo di impasti, che può avere lunghezza e struttura variabili;</li>
                        <li>Se del caso, i diversi sottogruppi presenti;</li>
                        <li>Un’origine (anch’essa in forma libera);</li>
                        <li>La bibliografia;</li>
                        <li>Le informazioni necessarie per citare correttamente la pagina.</li>
                    </ul>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_46.png" width="80%"></div>

                <h5>2.2.4. Illustrazioni</h5>
                    <p>Questa scheda contiene tutte le illustrazioni degli oggetti appartenenti a questo gruppo di impasti. È possibile ordinarle in base al tipo di illustrazione.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_47.png" width="80%"></div>
                    <p>È possibile visualizzare queste illustrazioni in formato più grande facendo clic su di esse. Una volta visualizzata l’illustrazione, è possibile tornare alla visualizzazione di base facendo clic accanto all’immagine o sulla croce in alto a destra.</p>

                <h5>2.2.5. Tipi</h5>
                    <p>Questa scheda elenca i tipi censiti per questo gruppo di impasti. È possibile consultare il tipo oppure l’inventario degli oggetti corrispondenti al tipo e al gruppo di impasti selezionato.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_48.png" width="80%"></div>

                <h5>2.2.6. Inventario</h5>
                    <p>Quest’ultima scheda presenta l’inventario completo del gruppo di impasti. Funziona nello stesso modo dell’inventario del contesto, con in più i codici dei siti, degli orizzonti-sito e dei contesti. È possibile fare clic su questi codici per raggiungere la relativa scheda, oppure semplicemente passare il mouse sopra di essi per visualizzarne il nome.</p>
                    <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_49.png" width="80%"></div>
                    <p>La tabella può essere ordinata e filtrata nello stesso modo dell’inventario del contesto ed è inoltre limitata per impostazione predefinita a 200 righe di inventario.</p>

                <h5>2.2.7. Corrispondenze</h5>
                    <p>Questa scheda, relativa ai nomi pubblicati dei gruppi di impasti quando differiscono da quelli di CeVICA, sarà descritta in seguito (si tratta di una funzionalità attualmente non utilizzata).</p>
            </section>
        </section>
    </section>

    <section id="bibliographie" class="mb-5">
    <h2>V. Bibliografia</h2>
        <p>Come indicato altrove, è possibile indicare riferimenti bibliografici per una serie di elementi: operazione archeologica, orizzonte-sito, contesto, orizzonte regionale, tipologia, tipo o gruppo di impasti. Questa funzionalità è piuttosto sommaria, ma i riferimenti sono consultabili in CeVICA.</p>

        <section id="liste-bibliographie" class="mb-5">
        <h3>1. Elenco dei riferimenti bibliografici</h3>
            <p>L’elenco dei riferimenti bibliografici è accessibile tramite la barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_53.png" width="80%"></div>
            <p>È ordinato alfabeticamente in base alle abbreviazioni.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_54.png" width="50%"></div>
        </section>

        <section id="consulter-bibliographie" class="mb-5">
        <h3>2. Consultare un riferimento</h3>
            <p>È possibile consultare un riferimento facendo clic su di esso nel punto in cui viene visualizzato. È quindi possibile visualizzare il riferimento completo, nonché gli elementi della base di dati ad esso collegati.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_55.png" width="60%"></div>
            <p>In alcuni casi è stato indicato un numero di pagina. Questo è disponibile sia nella pagina dell’elemento sia in quella del riferimento.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_56.png" width="50%"></div>
        </section>
    </section>

    <section id="autres-éléments" class="mb-5">
    <h2>VI. Altri elementi</h2>
        <section id="fichiers-génériques" class="mb-5">
        <h3>1. Elenco dei file scaricabili</h3>
            <p>Un elenco di file scaricabili è accessibile tramite la barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_51.png" width="80%"></div>
            <p>È possibile scaricare file che non sono collegati a un elemento specifico (operazione archeologica, orizzonte-sito, contesto, orizzonte regionale…) ma che hanno carattere generale e sono stati ritenuti utili da condividere. Il download avviene semplicemente facendo clic sul file desiderato.</p>
        </section>

        <section id="citer-page" class="mb-5">
        <h3>2. Citare una pagina</h3>
            <p>Sotto ogni pagina che descrive un elemento della base di dati viene proposto un modello di citazione per fare riferimento a tale elemento nella bibliografia. Numerosi esempi sono riportati altrove in questo tutorial.</p>
        </section>

        <section id="a-propos" class="mb-5">
        <h3>3. Informazioni sul sito web</h3>
            <p>Queste informazioni sono disponibili principalmente tramite « Supporto e informazioni » nella barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_57.png" width="80%"></div>
            <p>Queste schede comprendono:</p>
            <ul>
                <li>Una presentazione più approfondita di CeVICA nella sezione « Presentazione e contatti »;</li>
                <li>Un modulo di contatto per l’amministratore nella stessa sezione;</li>
                <li>L’elenco dei tutorial disponibili nella sezione « Guide all’utilizzo di CeVICA »;</li>
                <li>L’infrastruttura nella quale si inserisce CeVICA, nella sezione « Strumenti associati »: sviluppi complementari (come ONICer e DBCer, lo strumento LOGACer utilizzato da CeVICA), ma anche strumenti consigliati per funzionare in combinazione con quelli sviluppati dalle Università di Liegi e di Lille.</li>
            </ul>
            <p>Altre pagine sono accessibili in fondo a ogni pagina:</p>
            <ul>
                <li>Le note legali e la politica di gestione dei dati, necessarie per ogni sito web;</li>
                <li>Facendo clic sul logo LOGACer, una descrizione del software.</li>
            </ul>
        </section>

        <section id="recherche-simple" class="mb-5">
        <h3>4. Effettuare ricerche</h3>
            <p>Al momento, lo strumento di ricerca è piuttosto semplice e consiste in una barra di ricerca accessibile facendo clic sulla lente d’ingrandimento, a destra nella barra superiore.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_58.png" width="80%"></div>
            <p>È quindi possibile inserire elementi descrittivi di un tipo di elemento e selezionare quest’ultimo tra quelli già proposti.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_59.png" width="60%"></div>
            <p>Viene infine visualizzato un elenco o una tabella degli elementi corrispondenti.</p>
            <div style="text-align: center; margin:15px"><img src="<?php echo BASE_STATIC; ?>static/pictures_public/Principes_de_base_Navigation_Standard_60.png" width="80%"></div>
        </section>

        <section id="enregistrement-connexion" class="mb-5">
        <h3>5. Registrarsi e accedere</h3>
            <p>La registrazione e l’accesso saranno descritti in seguito, quando gli strumenti di collaborazione saranno pienamente operativi.</p>
        </section>
    </section>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
