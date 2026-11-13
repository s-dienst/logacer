            <h5>Welcome to the database of <?php echo PROJECT->code() . ' - ' . PROJECT->name(); ?></h5>
            <p><?php echo PROJECT->credits(); ?></p>
            <?php if (PROJECT->description("", 'descr_html')) {
                echo p(secure(PROJECT->description("", 'descr_html')));
            } elseif (PROJECT->description()) {
                echo p(PROJECT->description());
            }?>
            <p>This database is powered by <a href='<?php echo create_url_proj(['logacer']); ?>'>LOGACer</a> (online software for managing and analysing data on archaeological pottery). The relational structure of the database enables advanced queries and cross-site analyses.
            <h5>Contact us</h5>
            <p><a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">Contact us</a> to share your questions, suggestions or comments, or find out more about the project on the <a href="<?php echo create_url_proj(["about_us"]); ?>">Overview and contacts</a> page.
            <p>Enjoy exploring!</p>
