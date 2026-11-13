            <h2>Privacy Policy - <?php echo PROJECT->code(); ?></h2>
            <h5>Personal data collected</h5>
            <p>For registered users: surname, first name, email address, username, password (encrypted), preferred browsing language.</p>
            <p>For other users: preferred browsing language.</p>
            <h5>Purpose of data collection</h5>
            <p>The data is used solely for the creation and management of user accounts, in order to access the features of <?php echo PROJECT->code(); ?>, as well as to manage the website's display language.</p>
            <h5>Legal basis</h5>
            <p>Data processing is based on the user's consent (voluntary registration).</p>
            <h5>Retention period for personal data</h5>
            <p>The data is retained until the user deletes their account (which can be requested via the <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">contact form</a>), and for one year in the case of the preferred language.</p>
            <h5>User rights</h5>
            <p>Access, rectification, erasure, objection, data portability. To exercise these rights: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">contact form</a>.</p>
            <h5>Security of personal data</h5>
            <p>User data is protected by technical measures (password encryption, secure access to the database). However, first and last names (or, failing that, usernames) are accessible to other registered users. In the case of scientific data publication, non-registered users will also have access to this information. The database administrator(s) also have access to the email address used for registration.</p>
            <h5>Sharing of personal data</h5>
            <p>Data is not and will never be sold. It is not shared with third parties, except where required by law.</p>
            <h5>Data controller</h5>
            <p><?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>.</p>
            <h5>Visibility, use and processing of non-personal data</h5>
            <p>All data added by a registered user to <?php echo PROJECT->code(); ?> is public, with the exception of project data (accessible only to project contributors), unless it is possible to configure its confidentiality differently.
                The creators of the data are considered its primary authors. In some cases, contributors (internal to <?php echo PROJECT->code(); ?>) may also be identified. They are responsible for ensuring the authenticity of this data and compliance with the guidelines concerning copyright and the citation of scientific data.
                The administrator reserves the right to delete the account and data of anyone who violates this principle.</p>
