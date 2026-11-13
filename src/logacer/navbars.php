<!-- Basic navbar -->
        <nav class="bg-light border navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container-fluid">
                <?php serve_picture_public('Logo-logacer-3.png', true, BASE_URL, width: 200, class: 'navbar-brand py-0', blank: false); ?>
                <button class="navbar-toggler" type="button" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" data-bs-target="#navbar" data-bs-toggle="collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav mt-2">
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'projects']); ?>"><?php echo ucfirst(thesaurus('projects')); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'typologies']); ?>"><?php echo ucfirst(thesaurus('typologies')); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'fabrics']); ?>"><?php echo ucfirst(thesaurus('fabrics')); ?></a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("files_and_biblio")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class ="dropdown-item" href="<?php echo create_url(['logacer', 'files']); ?>"><?php echo ucfirst(thesaurus('downloads')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'bibliography']); ?>"><?php echo ucfirst(thesaurus('bibliography')); ?></a></li>
                                </ul>
                            </li>
                            
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("support_and_links")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class ="dropdown-item" href="<?php echo create_url(['logacer', 'about_us']); ?>"><?php echo ucfirst(thesaurus('about')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'tutorials']); ?>"><?php echo ucfirst(thesaurus('tutorial')); ?></a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("links")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'partnership']); ?>"><?php echo ucfirst(thesaurus('associated_tools')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'other_databases']); ?>"><?php echo ucfirst(thesaurus('other_databases')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'other_tools']); ?>"><?php echo ucfirst(thesaurus('other_tools')); ?></a></li>
                                </ul>
                            </li>
                            <?php if (isset($_SESSION['user'])) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $_SESSION['user']->codename(); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class ="dropdown-item" href="<?php echo create_url(['logacer', 'myaccount']); ?>"><?php echo ucfirst(thesaurus('my account')); ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'logout']); ?>"><?php echo ucfirst(thesaurus('logout')); ?></a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'login']); ?>"><?php echo ucfirst(thesaurus('login')); ?></a></li>
                            <?php } ?>                            
                            <li class="nav-item dropdown">
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $current_language = $_SESSION['user']->language();
                                } elseif (isset($_COOKIE['logacer_language'])) {
                                    $current_language = $_COOKIE['logacer_language'];
                                } else {
                                    $current_language = 'en';
                                }

                                // Trouver le nom de la langue actuelle
                                $current_language_name = array_search($current_language, SUPPORTED_LANGUAGES);

                                // Sécurité au cas où la langue actuelle ne serait pas supportée
                                if ($current_language_name === false) {
                                    $current_language = 'en';
                                    $current_language_name = 'English';
                                }
                                ?>

                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo strtoupper($current_language); ?>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <?php foreach (SUPPORTED_LANGUAGES as $language_name => $language_code) { ?>
                                        <?php if ($language_code !== $current_language) { ?>
                                            <li>
                                                <form action="<?php echo create_url(['logacer', 'change_language']); ?>" method="post">
                                                    <input type="hidden" name="language" value="<?php echo htmlspecialchars($language_code); ?>">
                                                    <input type="hidden" name="return_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                    <button type="submit" class="dropdown-item">
                                                        <?php echo htmlspecialchars($language_name); ?>
                                                    </button>
                                                </form>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                </div>
            </div>
        </nav>

        <!-- User navbar -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->is_contributor()): ?>
            <nav class="bg-dark border navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo create_url(['logacer', 'homepage']); ?>"><?php echo ucfirst(thesaurus('homepage')); ?></a>
                    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbar2" data-bs-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar2">
                        <ul class="navbar-nav mt-2">
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'myprojects']); ?>"><?php echo ucfirst(thesaurus('my projects')); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'mytypologies']); ?>"><?php echo ucfirst(thesaurus('my types')); ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'myfabrics']); ?>"><?php echo ucfirst(thesaurus('my fabrics')); ?></a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("refs")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'geography']); ?>"><?php echo ucfirst(thesaurus('list of the countries and regions')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'categories']); ?>"><?php echo ucfirst(thesaurus('list of the categories')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'functions']); ?>"><?php echo ucfirst(thesaurus('list of the functions')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url(['logacer', 'counting']); ?>"><?php echo ucfirst(thesaurus('list of the countings')); ?></a></li>
                                </ul>
                            </li>
                            <?php if ($_SESSION['user']->is_staff()) { ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo create_url(['logacer', 'manage_users']); ?>"><?php echo ucfirst(thesaurus('manage users')); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php endif ?>