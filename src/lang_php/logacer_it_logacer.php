            <h2>LOGACer: uno strumento open-source per la gestione e l'analisi dei reperti archeologici</h2>
            <br>
            <p>Il <b>Logiciel Online pour la Gestion et l'Analyse de la Céramique</b> (Software Online per la Gestione e l'Analisi della Ceramica) è stato concepito, con il nome di DBCer, nell'ambito della tesi « Étude chronologique, économique et culturelle de la vaisselle du <i>Piano della Civita</i> à Artena (Latium) depuis la République romaine jusqu’à l’Antiquité tardive » (S. Dienst, 2024 - disponibile su <a href="https://hdl.handle.net/2268/318966">ORBi</a>). Il suo obiettivo iniziale era strutturare e condividere i dati di questa ricerca in un formato pienamente utilizzabile dalla comunità scientifica, secondo i principi dell’Open Science e dell’Open Access.</p>
            <p>La classificazione e la messa a disposizione dei dati archeologici rappresentano una sfida importante. LOGACer consente non solo di condividere questi dati, ma anche di incrociare le informazioni provenienti da diverse équipe di ricerca che collaborano su una problematica comune. Desideriamo così rendere questo strumento accessibile a tutti i ricercatori che desiderano condividere i propri dati sull’<i>instrumentum</i>, in particolare sulla ceramica e sul vetro.</p>
            <br>

            <h2>Principi di implementazione</h2>
            <br>
            <p>LOGACer si basa sui seguenti principi fondamentali:</p>
            <ul style="text-align:left;">
                <li><b>Collaborazione e revisione:</b> Il software favorisce la collaborazione tra ricercatori nell'ambito di progetti comuni. In una versione successiva, consentirà inoltre agli utenti di commentare e persino proporre correzioni ai dati pubblicati da altri.</li>
                <li><b>Riservatezza dei dati:</b> Sebbene LOGACer incoraggi la condivisione dei dati in un'ottica di Open Access, rispetta la necessità degli utenti di mantenere privati i propri dati fino a quando non siano finalizzati, pubblicati o anche indefinitamente. Sono previsti diversi livelli di riservatezza e condivisione, in particolare per quanto riguarda le operazioni archeologiche, gli orizzonti-sito e i contesti, nonché gli orizzonti regionali.</li>
                <li><b>Cronologia:</b> La cronologia è determinata a livello dei siti mediante fasi o orizzonti-sito, e diversi orizzonti-sito possono essere raggruppati in orizzonti regionali.</li>
                <li><b>Interoperabilità:</b> I dati devono essere comparabili e poter essere incrociati tra loro. Sono possibili ricerche per tipi, impasti o altri criteri pertinenti, al fine di interrogare l'insieme dei dati (resi pubblici o accessibili all'utente).</li>
                <!--<li><b>Adattabilità:</b> I metodi e i repertori utilizzati dai diversi ricercatori possono variare. Inoltre, la messa online di dati più antichi può basarsi su repertori precedenti. Desideriamo consentire a tutti di pubblicare i dati nel modo che ritengono più appropriato, senza limitare le denominazioni utilizzate. Questo principio è in tensione con quello dell’interoperabilità e sono allo studio soluzioni per ovviare a questo problema. Queste passeranno attraverso possibilità di personalizzazione dell’esperienza utente. </li>-->
                <li><b>Facilità d'uso:</b> Nonostante la complessità tecnica, LOGACer cerca di rimanere accessibile anche a un utente alle prime armi. Le basi del suo utilizzo devono poter essere apprese in meno di un'ora, con meccanismi di protezione volti a evitare errori di utilizzo.</li>
            </ul>
            <br>

            <h2>Infrastruttura tecnica</h2>
            <br>
            <p>Una prima versione di LOGACer (DBCer versione 1) utilizzava il framework Django con un database SQLite. La versione attuale si basa su PHP e JavaScript (con AJAX) e interroga un database MySQL. Le librerie utilizzate includono Bootstrap per l'impaginazione, Leaflet per la cartografia, Altorouter per il routing e PhpSpreadsheet per la gestione dei file Excel.</p>
            <p>Il software è costituito da diverse parti o "moduli":</p>
            <ul style="text-align:left;">
                <li><b>Già disponibili</b></li><ul>
                <li><b>Struttura di base:</b> gestione delle operazioni archeologiche o dei siti, degli orizzonti-sito o delle fasi, dei contesti e degli oggetti. Include la gestione degli utenti, l'aggiunta di illustrazioni, file e bibliografia, nonché strumenti per la consultazione, l'importazione e l'esportazione dei dati e una cartografia di base.</li>
                <li><b>Cronologia per orizzonti:</b> Definizione degli orizzonti regionali ai quali sono collegati gli orizzonti-sito, con diversi gradi di connessione.</li>
                <li><b>Repertori:</b> Integrazione dei concetti di categoria, gruppo di impasti, funzione e tipo, descrivibili e consultabili, con vincoli logici (es.: collegamento tra tipi e categorie).</li>
                <li><b>Revisione della letteratura:</b> Possibilità di indicare chiaramente quando i dati sono ripresi da pubblicazioni di altri autori (e rielaborati). I dati pubblicati relativi ai reperti possono essere aggiunti oltre ai dati rielaborati.</li>
                </ul><li><b>In fase di implementazione</b></li><ul>
                <li><b>Orizzonti avanzati:</b> Tipo di collegamento tra gli orizzonti regionali e i tipi presenti, con strumenti di seriazione e analisi delle corrispondenze (AFC). Confronto tra una fase/orizzonte-sito/contesto e un gruppo di orizzonti.</li>
                </ul><li><b>Già previsti</b></li><ul>
                <li><b>Impasti avanzati:</b> Aggiunta di studi degli impasti direttamente nel database, con indicazione dei protocolli e strumenti per semplici analisi statistiche (ACP, dendrogramma).</li>
                <li><b>Grafici:</b> Visualizzazione di grafici utili per la pubblicazione o il confronto dei dati (uni- o bivariati, per contesti/orizzonti-sito/operazioni archeologiche).</li>
                <li><b>Cartografia avanzata:</b> Miglioramento della visualizzazione cartografica, con visualizzazione delle distribuzioni quantitative dei reperti e filtraggio/distinzione in base a criteri.</li>
                <li><b>Repertori - uniformazione:</b> Individuazione degli elementi simili e modifiche raggruppate per facilitare l'uniformazione dei dati eterogenei.</li>
                <li><b>Altre funzionalità:</b> È prevista l'aggiunta di funzionalità relative al multilinguismo, all'aggiunta di commenti, alla gestione della bibliografia, nonché all'operabilità dei dati (con punti di ingresso e uscita) per facilitarne l'utilizzo con altri software più specializzati... Il tutto in funzione delle esigenze degli utenti e del tempo disponibile per lo sviluppo.</li>
            </ul></ul>          
            <br>

            <h2>Implementare LOGACer per il proprio progetto</h2>
            <br>
            <p>LOGACer è protetto da una licenza CC BY-NC, che ne autorizza il riutilizzo del codice, la modifica e l'implementazione da parte di altre équipe. Il codice sorgente è disponibile previa richiesta all'amministratore (tramite il <a href="https://www.logacer.org/about_us#contact" target="_blank">modulo di contatto</a>).</p>
            <p>Se desiderate implementare LOGACer per il vostro progetto, possiamo:<p>
            <ul style="text-align:left;">
                <li>Fornirvi gratuitamente gli elementi necessari per un'implementazione locale da parte del vostro servizio informatico, senza configurazioni specifiche (ad eccezione del nome e delle pagine di presentazione);</li>
                <li>Configurare lo strumento o aggiungere funzionalità (dietro un contributo finanziario che permetta di sostenere il progetto) per l'implementazione dello strumento;</li>
                <li>Proporre l'implementazione dello strumento per il vostro utilizzo su un server esterno (sarà inoltre necessario un contributo finanziario per coprire i costi di installazione e di hosting).</li>
            </ul>
            <p>Qualunque sia la vostra situazione, se LOGACer vi interessa, non esitate a <a href="https://www.logacer.org/about_us#contact" target="_blank">contattarci</a> per discuterne!</p>
