<?php
    $title = "Accueil";
?>
<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="container-fluid py-5" style="max-width:1000px">
            <?php if (isset($_SESSION['flash_message_success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['flash_message_success'] . "</div>";
                unset($_SESSION['flash_message_success']);
            };
            long_translation("welcome"); ?>
            <div class="container mt-4">
                <?php echo h(2, ucfirst(thesaurus('newss'))); ?>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']->is_contributor()) {
                    echo "<a href='" . create_url(['news','new']) . "' class='btn btn-success mb-3'>" . ucfirst(thesaurus('new')) . ' ' . thesaurus('news') . "</a>";
                } ?>

                <?php 
                $all_news = News::find_all(['date_creation']);
                $news_list = [];
                foreach ($all_news as $n) {
                    if (PROJECT) {
                        if ($n->project()->id() === PROJECT->id()) {
                            array_unshift($news_list, $n);
                        }
                    } else {
                        if (!$n->project()) {
                            array_unshift($news_list, $n);
                        }
                    }
                }
                $count = 0;
                foreach ($news_list as $news) {
                    $count++;
                    // cacher les news au-delà des 5 premières
                    $hiddenClass = ($count > 5) ? "d-none older-news" : "";
                    echo "<div class='$hiddenClass'>";
                    $news->display_news();
                    echo "</div>";
                }
                ?>

                <?php if (count($news_list) > 5) {
                    echo "<button id='loadMoreBtn' class='btn btn-outline-secondary'>" . ucfirst(thesaurus("load more")) . "</button>";
                } ?>
            </div>
        </div>

            

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btn = document.getElementById("loadMoreBtn");
                if (btn) {
                    btn.addEventListener("click", function() {
                        document.querySelectorAll(".older-news").forEach(el => el.classList.remove("d-none"));
                        btn.style.display = "none"; // cacher le bouton après affichage
                    });
                }
            });
            </script>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>