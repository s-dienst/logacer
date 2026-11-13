<?php if (ISOLATED_WEBSITE || PROJECT) { ?>
<!-- Basic navbar -->
        <nav class="bg-light border navbar navbar-expand-lg navbar-light sticky-top">
            <div class="container-fluid">
                <?php if (PROJECT) {
                    if (!ISOLATED_WEBSITE) {
                        serve_picture_public('Logo-logacer-1.png', true, BASE_URL, height: 64, class: 'navbar-brand py-0', blank: false);
                    }
                    PROJECT->image('band');
                } else {
                    serve_picture_public('Logo-logacer-3.png', true, BASE_URL, width: 200, class: 'navbar-brand py-0', blank: false);
                } ?>
                <button class="navbar-toggler" type="button" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" data-bs-target="#navbar" data-bs-toggle="collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav mt-2">
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['sites']); ?>"><?php echo ucfirst(thesaurus('finds')); ?></a></li>
                            <?php if (PROJECT && PROJECT->setting_horizon()): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['horizons']); ?>"><?php echo ucfirst(thesaurus('horizons')); ?></a></li>
                            <?php endif; ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus('public refs')); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class ="dropdown-item" href="<?php echo create_url_proj(['typologies']); ?>"><?php echo ucfirst(thesaurus('typologies')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['fabrics']); ?>"><?php echo ucfirst(thesaurus('fabrics')); ?></a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("files_and_biblio")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class ="dropdown-item" href="<?php echo create_url_proj(['files']); ?>"><?php echo ucfirst(thesaurus('downloads')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['bibliography']); ?>"><?php echo ucfirst(thesaurus('bibliography')); ?></a></li>
                                </ul>
                            </li>
                            
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("support_and_links")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class ="dropdown-item" href="<?php echo create_url_proj(['about_us']); ?>"><?php echo ucfirst(thesaurus('about')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['tutorials']); ?>"><?php echo ucfirst(thesaurus('list tutorials')); ?></a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("links")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['partnership']); ?>"><?php echo ucfirst(thesaurus('associated_tools')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['other_databases']); ?>"><?php echo ucfirst(thesaurus('other_databases')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['other_tools']); ?>"><?php echo ucfirst(thesaurus('other_tools')); ?></a></li>
                                </ul>
                            </li>
                            <?php if (isset($_SESSION['user'])) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $_SESSION['user']->codename(); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class ="dropdown-item" href="<?php echo create_url_proj(['myaccount'], false); ?>"><?php echo ucfirst(thesaurus('my account')); ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo create_url_proj(['logout'], false); ?>"><?php echo ucfirst(thesaurus('logout')); ?></a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['login'], false); ?>"><?php echo ucfirst(thesaurus('login')); ?></a></li>
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
                                        <?php if ($language_code !== $current_language && (!PROJECT || in_array($language_code, PROJECT->langs()))) { ?>
                                            <li>
                                                <form action="<?php echo create_url_proj(['change_language'], false); ?>" method="post">
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
                            <li class="nav-item"><button class="btn btn-secondary ms-2" id="searchbutton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button></li>
                        </ul>
                </div>
            </div>
        </nav>


        <!-- Search navbar -->
        <nav class="navbar navbar-expand-md navbar-light py-1" id="searchbar" style="display:none; background-color: #ebf5fe;">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" data-bs-target="#searchbar" data-bs-toggle="collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                        <ul class="navbar-nav ms-auto">
                            <form class="d-flex" role="search" action="<?php echo create_url_proj(['search', 'results']); ?>" method="post">
                                <div class="input-group input-group-sm ms-2">
                                <input class="form-control" type="search" placeholder='<?php echo ucfirst(thesaurus('search')); ?>...' name="query">
                                <select class="form-select form-select" name="element">
                                    <option selected><?php echo ucfirst(thesaurus('in')); ?>...</option>
                                    <option value="site"><?php echo ucfirst(thesaurus('sites')); ?></option>
                                    <option value="phase"><?php echo ucfirst(thesaurus('phases')); ?></option>
                                    <option value="context"><?php echo ucfirst(thesaurus('contexts')); ?></option>
                                    <option value="object"><?php echo ucfirst(thesaurus('objects')); ?></option>
                                </select>
                                </div>
                                <input class="btn btn-secondary ms-2 btn-sm" type="submit" value="<?php echo ucfirst(thesaurus('search')); ?>">
                            </form>
                        </ul>
                </div>
            </div>
        </nav>

        <!-- User navbar -->
        <?php if (isset($_SESSION['user'])): ?>
            <nav class="bg-dark border navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo create_url_proj(['homepage']); ?>"><?php echo ucfirst(thesaurus('homepage')); ?></a>
                    <button aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbar2" data-bs-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar2">
                        <ul class="navbar-nav mt-2">
                            <?php if (PROJECT && $_SESSION['user']->id() === PROJECT->owner('prop')): ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['project']); ?>"><?php echo ucfirst(thesaurus('manage') . ' ' . thesaurus('the project')); ?></a></li>
                            <?php endif; ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus('my data')); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['mysites']); ?>"><?php echo ucfirst(thesaurus('my sites')); ?></a></li>
                                    <?php if (PROJECT && PROJECT->setting_horizon()): ?>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['myhorizons']); ?>"><?php echo ucfirst(thesaurus('my horizons')); ?></a></li>
                                    <?php endif; ?>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['mytypologies']); ?>"><?php echo ucfirst(thesaurus('my types')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['myfabrics']); ?>"><?php echo ucfirst(thesaurus('my fabrics')); ?></a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['addelements']); ?>"><?php echo ucfirst(thesaurus('CSV_update')); ?></a></li>
                            <?php if (PROJECT && (PROJECT->setting_horizon_adv() || PROJECT->setting_graphs())) { ?>
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("analyze_tools")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (PROJECT->setting_horizon_adv()) { ?>
                                        <li><a class ="dropdown-item" href="<?php echo create_url_proj(['horizons', 'compare']); ?>"><?php echo ucfirst(thesaurus('comparing_horizons')); ?></a></li>
                                        <li><a class ="dropdown-item" href="<?php echo create_url_proj(['horizons', 'seriations']); ?>"><?php echo ucfirst(thesaurus('seriations_horizons')); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo ucfirst(thesaurus("refs")); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['geography']); ?>"><?php echo ucfirst(thesaurus('list of the countries and regions')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['categories']); ?>"><?php echo ucfirst(thesaurus('list of the categories')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['functions']); ?>"><?php echo ucfirst(thesaurus('list of the functions')); ?></a></li>
                                    <li><a class="dropdown-item" href="<?php echo create_url_proj(['counting']); ?>"><?php echo ucfirst(thesaurus('list of the countings')); ?></a></li>
                                </ul>
                            </li>
                            <?php if ($_SESSION['user']->is_staff()) { ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo create_url_proj(['manage_users']); ?>"><?php echo ucfirst(thesaurus('manage users')); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php endif; 
} else {
    require_once(__DIR__ . "/../logacer/navbars.php");
}
?>