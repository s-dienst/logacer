            <h4>To use the tool, you can refer to the <a href='<?php echo create_url_proj(['tutorials']); ?>'>list of tutorials</a>.</h4><br>
            <h2>Presentation of the <?php echo PROJECT->code(); ?>database</h2>
            <br>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <h2>Project manager and contributors</h2>
            <br>
            <p>The project is managed by <?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>. <?php
            $contributors = User::linked('project', 'contributor', PROJECT->id());
            if (count($contributors) > 0) {
                echo "Project contributors: ";
                $already = 0;
                foreach ($contributors as $contrib) {
                    if ($already > 0) {
                        if (($already + 1) === count($contributors)) {
                            echo " " . thesaurus("and") . " ";
                        } else {
                            echo ", ";
                        }
                    }
                    echo $contrib->codename();
                    $already++;
                }
            } ?>.</p>
            <h2>Intellectual property and data protection</h2>
            <br>
            <ul>
                <li><b>User responsibilities:</b> Each contributor is responsible for the intellectual property rights of the data they upload. Unpublished data remains the property of its authors, unless otherwise stated.</li>
                <li><b>Confidentiality:</b> No data is encrypted (except passwords). The database manager undertakes not to access or use data marked as private without authorisation.</li>
                <li><b>Ongoing improvements:</b> For any questions or suggestions regarding data protection, please use the contact form available <a href="https://www.logacer.org/about_us#contact" target="_blank">at this address</a>.</li>
            </ul>
            <br>

            <h2>Software architecture</h2>
            <br>
            <p>To find out more about the technical infrastructure, please visit the page dedicated to <a href='<?php echo create_url_proj(['logacer']); ?>'><?php serve_picture_public("Logo-logacer-2.png", true, false, 20); ?> LOGACer</a>.</p>
            <br>
