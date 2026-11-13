
  <!-- Barre latérale -->
  <nav id="sidebarMenu" class="sidebar">
    <h6 class="px-3"><a href='<?php echo create_url(['tutorials']); ?>'>Indietro: Elenco dei tutorial</a></h6><br>
    <h4 class="px-3">Integrazione dell'inventario</h4>
    <a href="#introduction">Introduzione</a>
    <h5 class="px-3">I. Dall'area personale</h5>
    <a href="#bugs-connus">Problemi noti</a>
    <a href="#telecharger-completer-templates">Scaricare e compilare i template</a>
    <ul>
      <li><a href="#telecharger-template">Scaricare i template</a></li>
      <li><a href="#contenu-templates">Contenuto dei template</a></li>
      <li><a href="#ouvrir-templates">Aprire i template</a></li>
      <li><a href="#completer-enregistrer">Compilare e salvare</a></li>
    </ul>
    <a href="#integrer">Integrare i template</a>
    <ul>
      <li><a href="#ajouter-template">Aggiungere i template</a></li>
      <li><a href="#ecran-ajout">Schermata di aggiunta</a></li>
      <li><a href="#corrections">Correzioni</a></li>
      <li><a href="#validation">Convalida o annullamento</a></li>
    </ul>
    <a href="#longues-integrations">Gestire le integrazioni lunghe</a>
    <ul>
      <li><a href="#pause-integration">Interrompere temporaneamente</a></li>
      <li><a href="#reprendre-upload">Riprendere il caricamento</a></li>
    </ul>
    <h5 class="px-3">II. All'interno delle pagine</h5>
    <h5 class="px-3">III. Integrazione manuale</h5>
  </nav>

  <!-- Contenuto principale -->
  <div class="content_tutorial">
    <?php echo $tuto_button . $return_list; ?>
    <h1 class="mb-4">Tutorial: aggiungere operazioni archeologiche, orizzonti-sito, contesti e inventari</h1>
    <section id="introduction" class="mb-5">
      <p>L'aggiunta (e la modifica) di siti, fasi, contesti e inventari può essere effettuata, all'interno di <?php echo WEBSITE_NAME; ?>, in diversi modi:</p>
      
      <ul>
        <li>Tramite l'aggiunta globale di dati dall'area personale;</li>
        <li>Tramite l'aggiunta di dati specifici a un progetto, un'operazione archeologica o un contesto nelle pagine dedicate;</li>
        <li>Tramite l'aggiunta, la modifica e la cancellazione manuale dei dati attraverso le pagine di visualizzazione dei dati stessi.</li>
      </ul>

      <p>Questi diversi metodi sono illustrati di seguito.</p>
    </section>

    <h2>I. Integrare i dati dall'area personale</h2>

      <section id="bugs-connus" class="mb-5">
        <h4>Problemi noti</h4>
        
        <p>Sono già stati identificati diversi problemi, la cui risoluzione è in corso. L'implementazione di queste funzionalità richiede tuttavia molto tempo, così come la risoluzione di alcuni problemi. Non esitate a informare l'amministratore qualora riscontriate altri problemi.</p>
        <p>In generale, l'indicazione di un errore tramite un colore può rimanere visibile anche dopo la correzione. Si consiglia di fare nuovamente clic sulla cella e poi premere "Enter", per verificare se il problema è stato effettivamente risolto.</p>
        <p>Per quanto riguarda l'aggiunta dei siti:</p>
        <ul>
          <li>Quando nel file importato è indicata una regione che non esiste, questa viene semplicemente rimossa dalla tabella.</li>
        </ul>
        <p>Per quanto riguarda l'aggiunta di fasi e contesti:</p>
        <ul>
          <li>Anche se viene indicato un errore, quando la prima indicazione di una nuova fase è errata ma un'indicazione successiva è corretta, la fase viene aggiunta a partire da quel momento e i contesti vengono aggiunti a questa fase. Una fase errata non impedisce l'importazione del contesto.</li>
          <li>Quando la codifica dell'orizzonte regionale è errata, viene semplicemente rimossa, senza indicare un errore.</li>
        </ul>
        <p>Per quanto riguarda l'aggiunta degli inventari:</p>
        <ul>
          <li>La versione breve deve essere testata più approfonditamente, soprattutto a causa delle numerose modifiche apportate. È probabile che non funzioni correttamente.</li>
          <li>La versione lunga non è ancora implementata, poiché richiede modifiche al funzionamento attuale di <?php echo WEBSITE_NAME; ?>.</li>
        </ul>
      </section>


    <section id="telecharger-completer-templates" class="mb-5">
      <h3>1. Scaricare e compilare i template</h3>
      <section id="telecharger-template" class="mb-5">
        <h4>1.1. Scaricare i template</h4>
        
        <p>I diversi template possono essere scaricati dall'area personale, nella scheda « template ». Attualmente esistono template per l'aggiunta:</p>
        <ul>
          <li>di operazioni archeologiche;</li>
          <li>di contesti (e degli eventuali orizzonti-sito associati);</li>
          <li>di inventari.</li>
        </ul>

        <p>È necessario selezionare dall'elenco fornito il template desiderato, quindi fare clic su « scarica ».</p>
      </section>

      <section id="contenu-templates" class="mb-5">
        <h4>1.2. Contenuto dei template</h4>

        <p>Ogni template è disponibile in una versione breve e in una versione lunga.</p>

        <h5>Siti – versione breve</h5>
        <ul>
          <li><b>ID del progetto (facoltativo):</b> Identificativo del progetto al quale deve essere associata l'operazione, se si desidera collegarla a un progetto. L'identificativo è il numero visibile nell'URL quando si apre il proprio progetto: « …/project/1 », dove « 1 » è l'identificativo.</li>
          <li><b>Responsabile dell'operazione (facoltativo):</b> L'identificativo in <?php echo WEBSITE_NAME; ?> (da non confondere con nome e cognome) del responsabile da indicare per l'operazione. Se si tratta di voi, potete lasciare il campo vuoto. Se si tratta di un'altra persona, questa deve essere registrata in <?php echo WEBSITE_NAME; ?>; in questo caso, sarete automaticamente aggiunti come contributori.</li>
          <li><b>Codice dell'operazione archeologica (obbligatorio):</b> Codice che consente di identificare facilmente l'operazione. Il codice deve essere univoco per il responsabile dell'operazione ed è obbligatorio. È limitato a 32 caratteri.</li>
          <li><b>Nome dell'operazione archeologica (obbligatorio):</b> Nome completo dell'operazione archeologica. Il nome è limitato a 255 caratteri. Non devono esistere altre operazioni archeologiche con lo stesso nome in <?php echo WEBSITE_NAME; ?>.</li>
        </ul>

        <h5>Siti – versione lunga</h5>
        <p>Campi aggiuntivi (tutti facoltativi):</p>
        <ul>
          <li><b>Coord. lat:</b> Coordinate del sito in latitudine (in forma decimale utilizzando un punto, tra -90 e 90; i numeri positivi indicano la latitudine nord, quelli negativi la latitudine sud).</li>
          <li><b>Coord. long:</b> Coordinate del sito in longitudine (in forma decimale utilizzando un punto, tra -180 e 180; i numeri positivi indicano la longitudine est, quelli negativi la longitudine ovest).</li>
          <li><b>Codice regione:</b> Codice regionale. I codici già integrati <a href="<?php echo create_url(['geography']); ?>" target='_blank'>sono disponibili qui</a>. Se desiderate aggiungere un'altra regione, dovete contattare l'amministratore di <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Pubblico (sì/no):</b> Indicazione relativa al fatto che si desideri rendere l'operazione archeologica consultabile da tutti oppure esclusivamente dai responsabili e dai contributori del progetto e/o dell'operazione. Per impostazione predefinita, l'operazione archeologica non è pubblica. È inoltre possibile renderla pubblica, nascondendo manualmente alcuni orizzonti-sito e contesti (ad eccezione dell'aggiunta tramite tabella).</li>
          <li><b>Inedito (sì/no):</b> Indicazione del carattere inedito o meno dei dati integrati in <?php echo WEBSITE_NAME; ?>. Se no, è necessario aggiungere manualmente la bibliografia dopo l'aggiunta tramite file CSV. Per impostazione predefinita, l'operazione archeologica non è considerata inedita. È inoltre possibile indicarla come già pubblicata, ma segnalare manualmente come inediti alcuni orizzonti-sito e contesti (ad eccezione dell'aggiunta tramite tabella).</li>
          <li><b>Revisione lett. (sì/no):</b> Se questa operazione archeologica non è stata pubblicata da voi, ma ne avete recuperato i dati (con o senza modifiche), dovreste indicare che si tratta di dati estratti (e presumibilmente revisionati) da una pubblicazione. È possibile impostare questo parametro in modo più dettagliato per gli orizzonti-sito e i contesti (ad eccezione dell'aggiunta tramite tabella).</li>
          <li><b>Descrizione:</b> È possibile aggiungere una descrizione del sito (testo libero).</li>
        </ul>

        <h5>Contesti – versione breve</h5>
        <p>È obbligatorio indicare alternativamente il responsabile e il codice dell'operazione archeologica (combinazione univoca), oppure il nome (univoco) dell'operazione archeologica.</p>
        <ul>
          <li><b>Responsabile dell'operazione:</b> L'identificativo in <?php echo WEBSITE_NAME; ?> (da non confondere con nome e cognome) del responsabile dell'operazione archeologica alla quale si desidera aggiungere il contesto.</li>
          <li><b>Operazione archeologica (codice):</b> Il codice dell'operazione archeologica alla quale si desidera aggiungere il contesto.</li>
          <li><b>Operazione archeologica (nome) (obbligatorio):</b> Il nome dell'operazione archeologica alla quale si desidera aggiungere il contesto.</li>
          <li><b>Codice orizzonte-sito (facoltativo):</b> Se si desidera aggiungere il contesto a un orizzonte-sito, indicarne qui il codice, che ne consente una facile identificazione. Può trattarsi di un nuovo orizzonte-sito (codice indicato come inesistente per questa operazione archeologica), di un orizzonte-sito esistente oppure di un orizzonte-sito aggiunto per un contesto importato precedentemente nel file CSV. Il codice è limitato a 32 caratteri.</li>
          <li><b>Nome orizzonte-sito (facoltativo, salvo se nuovo):</b> Se si tratta di un orizzonte-sito introdotto per questo contesto, è necessario indicarne il nome. Altrimenti, questo campo verrà ignorato. Il nome è limitato a 255 caratteri.</li>
          <li><b>Codice contesto (obbligatorio):</b> Codice che consente di identificare facilmente il contesto. Il codice deve essere univoco per l'operazione archeologica (ad esempio, US). È limitato a 32 caratteri.</li>
          <li><b>Nome contesto (obbligatorio):</b> Nome completo del contesto (può essere equivalente al codice). Il nome è limitato a 255 caratteri.</li>
        </ul>

        <h5>Contesti – versione lunga</h5>
        <p>Campi aggiuntivi (tutti facoltativi):</p>
        <ul>
          <li><b>Codice gruppo degli orizzonti regionali (obbligatorio se viene compilato il campo successivo):</b> Se viene introdotto un nuovo orizzonte-sito, è possibile collegarlo a un orizzonte regionale. Prima di indicare il codice di quest'ultimo, è necessario indicare il codice del gruppo di orizzonti al quale appartiene (ad esempio, ROME per gli orizzonti della regione romana). L'orizzonte regionale deve già esistere. Questo campo e i due successivi non vengono presi in considerazione se l'orizzonte-sito esiste già o è stato introdotto precedentemente.</li>
          <li><b>Codice orizzonte regionale:</b> Se il nuovo orizzonte-sito è collegato a un orizzonte regionale, il suo codice deve essere indicato in questa colonna. L'orizzonte regionale deve già esistere.</li>
          <li><b>Tipo di collegamento (maggiore = 1, minore = 2, incerto = 3):</b> Indica l'importanza dell'orizzonte-sito nella definizione del proprio orizzonte regionale. Deve essere un numero intero compreso tra 1 e 3. Può essere lasciato vuoto se l'importanza è sconosciuta.</li>
          <li><b>Descrizione orizzonte-sito:</b> È possibile aggiungere una descrizione del nuovo orizzonte-sito (testo libero).</li>
          <li><b>Descrizione contesto:</b> È possibile aggiungere una descrizione del contesto (testo libero).</li>
        </ul>

        <h5>Inventario – versione breve</h5>
        <p>Si tratta per il momento dell'unica possibilità di aggiunta completamente funzionante. È obbligatorio indicare o il responsabile e il codice dell'operazione archeologica (combinazione univoca), oppure il nome (univoco) dell'operazione archeologica.</p>
        <ul>
          <li><b>Responsabile dell'operazione:</b> L’identificativo in <?php echo WEBSITE_NAME; ?> (da non confondere con il nome e cognome) del responsabile dell'operazione archeologica a cui appartiene il contesto al quale si desidera aggiungere una riga di inventario.</li>
          <li><b>Operazione archeologica (codice):</b> Il codice dell'operazione archeologica a cui appartiene il contesto al quale si desidera aggiungere una riga di inventario.</li>
          <li><b>Operazione archeologica (nome):</b> Il nome dell'operazione archeologica a cui appartiene il contesto al quale si desidera aggiungere una riga di inventario.</li>
          <li><b>Contesto (codice) (obbligatorio):</b> Il codice del contesto al quale si desidera aggiungere la riga di inventario.</li>
          <li><b>Numero d'inventario (obbligatorio):</b> Numero d'inventario dell'oggetto che si desidera aggiungere, univoco all'interno del contesto. Il numero d'inventario è limitato a 128 caratteri.</li>

          <li><b>Categoria (obbligatorio):</b> Abbreviazione della categoria a cui appartiene l'oggetto (massimo 16 caratteri). Non è necessario che la categoria sia già stata aggiunta in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Funzione (obbligatorio):</b> Nome della funzione a cui appartiene l'oggetto (massimo 128 caratteri). Non è necessario che la funzione sia già stata aggiunta in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Tipo (obbligatorio):</b> Nome del tipo a cui appartiene l'oggetto (massimo 128 caratteri). Non è necessario che il tipo sia già stato aggiunto in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>var. (facoltativo):</b> Se si tratta di una variante del tipo, indicarla qui (preferibilmente con l'indicazione « var. », massimo 8 caratteri).</li>
          <li><b>dubbio (facoltativo):</b> In caso di dubbio sull'identificazione del tipo, indicarlo qui (preferibilmente con il segno di punteggiatura « ? », massimo 16 caratteri).</li>
          <li><b>Impasto (facoltativo):</b> Codice del gruppo di impasti a cui appartiene l'oggetto (massimo 64 caratteri). Non è necessario che il gruppo di impasti sia già stato aggiunto in <?php echo WEBSITE_NAME; ?>.</li>

          <li><b>Diam. (facoltativo):</b> Indicazioni sul diametro dell'oggetto (massimo 16 caratteri).</li>
          <li><b>Stampigliature (facoltativo):</b> Se sono presenti stampigliature sull'oggetto, indicarle separatamente dal tipo, in modo da facilitare le ricerche su quest'ultimo (massimo 255 caratteri).</li>
          <li><b>Commento (facoltativo):</b> Commento o descrizione libera (massimo 255 caratteri).</li>
          <li><b>Orli (facoltativo):</b> Numero di orli (numero intero >= 0).</li>
          <li><b>Fondi (facoltativo):</b> Numero di fondi (numero intero >= 0).</li>
          <li><b>Anse (facoltativo):</b> Numero di anse (numero intero >= 0).</li>
          <li><b>Pareti (facoltativo):</b> Numero di pareti (numero intero >= 0).</li>
          <li><b>NMI (facoltativo):</b> Numero minimo di individui (rigoroso, basato esclusivamente sull'orlo) (numero intero >= 0).</li>
          <li><b>NR (facoltativo):</b> Numero di resti (o frammenti) (numero intero >= 0).</li>
        </ul>

        <h5>Inventario – versione estesa</h5>
        <p>La versione estesa è utile nel caso di revisioni della letteratura (o della messa online di contesti studiati da tempo), poiché consente di modificare nel database le categorie, le funzioni, i tipi e i gruppi di impasti, rendendo al contempo disponibile l'informazione originariamente pubblicata. <span style="color:#ff0000">L'integrazione degli inventari in questa forma non è attualmente possibile.</span> I campi in questione sono sostituiti da:</p>
        <ul>
          <li><b>Categoria (adattata) (obbligatorio):</b> Equivalente della Categoria nel template breve.</li>
          <li><b>Categoria (bibliografia) (facoltativo):</b> Categoria menzionata nella bibliografia (funzionalità da aggiungere).</li>
          <li><b>Funzione (adattata) (obbligatorio):</b> Equivalente della Funzione nel template breve.</li>
          <li><b>Funzione (bibliografia) (facoltativo):</b> Funzione menzionata nella bibliografia (funzionalità da aggiungere).</li>
          <li><b>Tipo (adattato) (obbligatorio):</b> Equivalente del Tipo nel template breve.</li>
          <li><b>Tipo (bibliografia) (facoltativo):</b> Tipo menzionato nella bibliografia (funzionalità da aggiungere).</li>
          <li><b>Impasto (adattato) (facoltativo):</b> Equivalente del Gruppo di impasti nel template breve.</li>
          <li><b>Impasto (bibliografia) (facoltativo):</b> Gruppo di impasti menzionato nella bibliografia (funzionalità da aggiungere).</li>
        </ul>
      </section>

      <section id="ouvrir-templates" class="mb-5">
        <h4>1.3. Aprire i template</h4>
        
        <p>I template sono stati configurati per utilizzare il punto e virgola come separatore, che costituisce la configurazione predefinita di MS Excel nella versione francofona. È tuttavia possibile che il template venga visualizzato in modo errato; in tal caso, non esitate a contattare l'amministratore del sito per trovare una soluzione.</p>
      </section>

      <section id="completer-enregistrer" class="mb-5">
        <h4>1.4. Compilare e salvare i template</h4>

        <h5>Compilare il template</h5>
        <p>Una volta aperto, è possibile compilare il template. Assicuratevi di non rimuovere alcun campo dal template e di non modificare l'ordine delle colonne. <?php echo WEBSITE_NAME; ?> gestisce normalmente l'aggiunta di nuovi campi (che vengono ignorati), la rimozione dei campi obbligatori e la modifica dell'ordine, ma potrebbero comunque verificarsi dei bug.</p>
        <p>Lasciate completamente vuoti i campi non utilizzati e non obbligatori. Si noti che le modifiche di stile (grassetto, corsivo, sottolineato, caratteri…) non vengono conservate in un file CSV. Le maiuscolette vengono trasformate in maiuscole.</p>
        <p><b>La dimensione massima dei template è attualmente di circa 200 MB, ma sarà limitata a 2 MB (per renderli più gestibili), pari a circa 50.000 righe di inventario. Si prega di non superare questo limite.</b></p>

        <h5>Salvare il template</h5>
        <p>Il template deve essere sempre salvato in formato CSV, utilizzando il punto e virgola come separatore. In MS Excel configurato per gli utenti francofoni, questo dovrebbe essere il caso.</p>
        <p>È tuttavia possibile verificare questa impostazione aprendo il file CSV con un editor di testo (TextEdit su Mac) e controllando se i campi sono separati da punti e virgola o da un altro separatore (generalmente la virgola). Se viene utilizzata la virgola e si è sicuri di non aver utilizzato virgole per compilare il template, è possibile utilizzare la funzione cerca e sostituisci per sostituire le virgole con punti e virgola.</p>
      </section>
    </section>

    <section id="integrer" class="mb-5">
      <h3>2. Integrare i template</h3>
      <section id="ajouter-template" class="mb-5">
        <h4>2.1. Aggiungere i template e accedere alla schermata di aggiunta</h4>
        <p>Per aggiungere il template, tornate nell'Area personale. Nella sezione « Importare dati », dovrete:</p>
        <ul>
          <li>Selezionare un'opzione dall'elenco per scegliere il tipo di template che si desidera aggiungere (indipendentemente dal fatto che si tratti del template esteso o breve);</li>
          <li>Aggiungere il file compilato;</li>
          <li>Indicare se si desidera visualizzare o meno i dati importati senza errori. Per « senza errori » si intende la possibilità di integrare i dati così come sono stati inseriti, senza modifiche da parte dell'utente. Si noti che l'assenza di corrispondenza a livello di categorie, funzioni, tipi e gruppi di impasti non è considerata un errore. Se si desidera effettuare questi controlli, si consiglia di non selezionare questa casella. Questa scelta non può essere modificata in seguito. Se non si è sicuri della scelta, è sempre possibile effettuare un test, quindi annullare l'integrazione dei dati e scegliere di modificare la propria scelta (vedi più avanti).</li>
        </ul>
      </section>
      <section id="ecran-ajout" class="mb-5">
        <h4>2.2. Schermata di aggiunta dei dati</h4>
        <p>Successivamente si accederà a una schermata che consente di convalidare l'aggiunta dei dati. Questa schermata comprende due parti: un riepilogo dell'integrazione e la tabella dei dati integrati.</p>

        <h5>Dati di integrazione</h5>
        <p>Si tratta di un riepilogo dei dati aggiunti:</p>
        <ul>
          <li><b>Righe:</b> Le righe attualmente elaborate all'interno del CSV (per rispettare la numerazione utilizzata da Excel, la riga dell'intestazione è considerata come riga 1).</li>
          <li><b>Totale delle righe:</b> Numero di righe contenute nel file caricato (riga dell'intestazione inclusa).</li>
          <li><b>Righe rimanenti:</b> Numero di righe non ancora elaborate.</li>
          <li><b>Righe visualizzate:</b> Numero di righe visualizzate in questa tabella.</li>
        </ul>

        <h5>Tabella dei dati</h5>
        <p>Al di sotto di questi dati viene visualizzata la tabella, contenente tutti i dati integrati oppure esclusivamente i dati errati, a seconda della scelta effettuata al momento dell'integrazione. <?php echo WEBSITE_NAME; ?> è configurato per visualizzare un massimo di 200 righe. Se l'opzione « Visualizzare anche i dati importati senza errori » non è stata selezionata, <?php echo WEBSITE_NAME; ?> elaborerà al massimo 1000 righe alla volta, indipendentemente dalla presenza o meno di errori (e visualizzerà al massimo 200 righe errate).</p>
        <p>I dati compilati correttamente sono visualizzati in nero. Gli altri dati sono visualizzati in colori diversi a seconda della loro gravità.</p>

        <h5>Errori che impediscono l'importazione dei dati</h5>
        <p>Questi errori sono indicati in rosso scuro. In alcuni casi l'importazione può comunque essere effettuata, ma abbiamo preferito considerarli errori bloccanti, poiché è probabile che l'utente desideri correggerli. In generale:</p>
        <ul>
          <li><b>Formato non valido:</b> Quando mancano dati obbligatori, questi non hanno il formato corretto (ad esempio, lettere al posto di numeri) oppure è stato superato il numero massimo di caratteri.</li>
        </ul>
        <p>Per l'importazione dei siti:</p>
        <ul>
          <li><b>Progetto:</b> Nessun progetto corrisponde a questo identificativo, oppure l'utente non è incluso nel progetto corrispondente.</li>
          <li><b>Responsabile dell'operazione:</b> Il nome utente non esiste. Il codice del sito non può essere verificato ed è quindi anch'esso considerato errato.</li>
          <li><b>Codice:</b> Il codice è assente, troppo lungo oppure esiste già per questo responsabile.</li>
          <li><b>Nome:</b> Il nome è assente, troppo lungo oppure esiste già in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Regione:</b> Il codice della regione indicata non esiste ancora in <?php echo WEBSITE_NAME; ?>.</li>
          <li><b>Coordinate:</b> La latitudine e/o la longitudine non sono indicate sotto forma di numero oppure presentano valori impossibili (tra -90 e 90 per la latitudine, tra -180 e 180 per la longitudine).</li>
        </ul>
        <p>Per l'importazione degli orizzonti-sito e dei contesti:</p>
        <ul>
          <li><b>Sito:</b> Nessun sito corrisponde a questo codice, oppure l'utente non è né responsabile né collaboratore di questo sito (anche il codice del contesto è considerato errato, poiché non può essere verificato).</li>
          <li><b>Codice orizzonte-sito:</b> Questo codice è già assegnato a questo sito (nel caso in cui, per questa riga, venga indicato un nome diverso da quello dell'orizzonte-sito esistente o precedentemente indicato con lo stesso codice - <b>Regola da confermare</b>).</li>
          <li><b>Tipo di collegamento:</b> Il tipo di collegamento con l'orizzonte regionale deve essere vuoto oppure un numero compreso tra 0 e 3 (maggiore = 1, minore = 2, incerto = 3, sconosciuto = 0) - <b>Deve ancora essere precisato se si tratta o meno di un problema bloccante</b>.</li>
          <li><b>Codice contesto:</b> Il codice esiste già per questo sito.</li>
        </ul>
        <p>Per l'importazione dell'inventario:</p>
        <ul>
          <li><b>Sito:</b> Nessun sito corrisponde a questo codice, oppure l'utente non è né responsabile né collaboratore di questo sito (anche il codice del contesto e il numero d'inventario sono considerati errati, poiché non possono essere verificati).</li>
          <li><b>Contesto:</b> Il codice indicato per il contesto non esiste per questo sito (anche il numero d'inventario è considerato errato, poiché non può essere verificato).</li>
          <li><b>Numero d'inventario:</b> Il numero deve essere univoco all'interno del contesto (compresi i dati in fase di aggiunta).</li>
          <li><b>Orli, fondi, anse, pareti, NMI, NR:</b> Se queste colonne sono compilate, devono contenere numeri interi positivi (o 0).</li>
        </ul>

        <h5>Errori che non impediscono l'importazione dei dati</h5>
        <p>Questi errori sono (normalmente) visualizzati in grigio. Nel caso dell'importazione dell'inventario, non si tratta propriamente di errori, ma piuttosto dell'aggiunta di dati non collegati a livello del repertorio.</p>
        <p>Per l'importazione dei siti:</p>
        <ul>
          <li><b>Pubblico, Inedito, Revisione bibliografica:</b> Quando il formato non è corretto (risposta diversa da « sì » o « no », oppure campo vuoto). Verranno applicati i valori predefiniti.</li>
        </ul>
        <p>Per l'importazione degli orizzonti-sito e dei contesti:</p>
        <ul>
          <li><b>Gruppo di orizzonti (codice):</b> Nessun gruppo di orizzonti corrisponde a questo codice, oppure l'utente non è né responsabile né collaboratore di questo gruppo (anche il codice dell'orizzonte è considerato errato, poiché non può essere verificato).</li>
          <li><b>Orizzonte (codice):</b> Il codice indicato per l'orizzonte regionale non esiste per questo gruppo di orizzonti.</li>
          <li><b>Tipo di collegamento:</b> Se il tipo è indicato, deve essere un numero intero compreso tra 1 e 3.</li>
        </ul>
        <p>Per l'importazione dell'inventario:</p>
        <ul>
          <li><b>Categoria, Funzione, Tipo e Gruppo di impasti:</b> Quando non esiste nel repertorio di <?php echo WEBSITE_NAME; ?> (attualmente non collegato a ONICer) alcun elemento a cui sia possibile collegare il dato.</li>
        </ul>
      </section>

      <section id="corrections" class="mb-5">
        <h4>2.3. Correzioni durante l'integrazione</h4>
        <p>In caso di errore o per qualsiasi altro tipo di correzione, è possibile modificare il valore visualizzato semplicemente facendo clic sulla cella che si desidera modificare e correggendo il valore. Quando si fa clic altrove, il valore viene visualizzato in nero se è valido oppure con il colore corrispondente al tipo di errore.</p>
      </section>

      <section id="validation" class="mb-5">
        <h4>2.4. Convalidare o annullare l'integrazione</h4>
        <p>Una volta verificate e applicate tutte le modifiche desiderate, è possibile convalidare l'integrazione. Sono possibili due casi:</p>
        <ul>
          <li><b>Importare le righe valide e caricare il seguito:</b> Quando rimangono ancora dati che non sono stati esaminati, vengono integrati i dati validi e vengono visualizzati i dati successivi.</li>
          <li><b>Importare le righe valide e terminare l'upload:</b> Quando ci sono pochi dati da importare o si è arrivati alla fine dei dati da importare, vengono integrati i dati validi e si viene successivamente reindirizzati alla propria area personale.</li>
        </ul>
        <p>I dati non validi non verranno aggiunti (<b style="color:#ff0000">DA CHIARIRE</b>).</p>
        <p>È inoltre possibile annullare l'upload. I dati già importati (durante le visualizzazioni precedenti) non verranno eliminati, ma i dati visualizzati e tutti quelli ancora da elaborare non verranno integrati in <?php echo WEBSITE_NAME; ?>. Non è possibile tornare indietro. Questa opzione è utile se si riscontrano numerosi problemi nel proprio file e si desidera rielaborarlo, oppure se si desidera modificare l'opzione relativa alla visualizzazione o meno dei dati errati. Se si desidera semplicemente interrompere temporaneamente l'integrazione, è più appropriato mettere in pausa l'upload (vedi sotto).</p>
      </section>
    </section>

    <section id="longues-integrations" class="mb-5">
      <h3>3. Gestire le integrazioni lunghe</h3>
      <section id="pause-integration" class="mb-5">
        <h4>3.1. Interrompere temporaneamente l'upload</h4>
        <p>Se è necessario interrompere temporaneamente l'operazione mentre si aggiungono i dati, un pulsante « Interrompere temporaneamente l'upload » consente di mettere in pausa l'integrazione dei dati. A meno che nel frattempo non vengano aggiunti altri dati, sarà quindi possibile riprendere l'aggiunta dei dati dal punto in cui era stata interrotta. È anche possibile semplicemente uscire dalla schermata.</p>
        <p>Ciò non modificherà in alcun modo le righe già aggiunte al database.</p>
      </section>

      <section id="reprendre-upload" class="mb-5">
        <h4>3.2. Riprendere l'upload</h4>
        <p>Per riprendere un upload messo in pausa in questo modo, è necessario accedere alla propria area personale. Nella sezione « Importare dati », un pulsante verde consente di riprendere un upload messo in pausa. Questo pulsante non viene visualizzato se non è presente alcun upload in pausa.</p> 
        <p>Per il momento, non è previsto che sia possibile mettere in pausa e riavviare più upload per lo stesso utente. Se si avvia un nuovo upload (di siti, contesti o inventario), l'upload messo in pausa verrà eliminato.</p>
      </section>
    </section>

    <h2>II. Integrare i dati dalle pagine dei progetti, dei siti e dei contesti</h2>
    <p>Questa possibilità non è ancora integrata in <?php echo WEBSITE_NAME; ?>.</p>

    <h2>III. Integrare manualmente i dati</h2>
    <div style="color:#ff0000"><p>Sezione in costruzione.</p></div>
  </div>

  <!-- Bootstrap JS -->
  <script crossorigin="anonymous" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"></script>
