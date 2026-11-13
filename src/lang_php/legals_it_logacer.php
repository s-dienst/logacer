            <h2>Note legali - <?php echo WEBSITE_NAME; ?></h2>
            <h5>Editore di LOGACer</h5>
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
            <h5>Hosting</h5>
            <p>
                Per informazioni relative al servizio di hosting, si prega di contattare il responsabile dell'installazione tramite il <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">modulo di contatto</a>.
            </p>
            <h5>Responsabile della pubblicazione</h5>
            <p>I dati pubblicati sono sotto la piena responsabilità di 
                <?php
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
                ?>
                 e del/dei responsabile/i del progetto. Essi non comportano in alcun caso la responsabilità del fornitore del servizio di hosting.</p>
            <h5>Software utilizzato</h5>
            <p>La banca dati è pubblicata utilizzando <a href="https://www.logacer.org">LOGACer - Logiciel Online de Gestion et d'Analyse de la Céramique</a>, un software sviluppato da Simon Dienst.</p>
            <h5>Proprietà intellettuale</h5>
            <p>Il contenuto del sito (testi, immagini, dati scientifici) è protetto dalle normative sul diritto d'autore. I dati scientifici possono avere diverse provenienze: dati inediti, dati pubblicati dall'autore delle schede o dati ripresi e rielaborati dall'autore delle schede. I collaboratori della banca dati sono tenuti a distinguere questi diversi casi. Gli utenti si impegnano a rispettare i diritti d'autore.</p>
            <h5>Condizioni d'uso</h5>
            <p>L'utilizzo di <?php echo WEBSITE_NAME; ?> è gratuito ed è destinato a un uso professionale o accademico. Qualsiasi utilizzo improprio o fraudolento è vietato. L'utilizzo dei dati pubblicati in LOGACer o in uno dei suoi progetti (dati inediti o rielaborati) deve essere accompagnato da una corretta citazione della fonte.</p>
            <h5>Contatti</h5>
            <p>Per qualsiasi domanda: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">modulo di contatto</a>.</p>
