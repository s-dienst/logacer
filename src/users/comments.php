
<?php
// Création d'un contexte sécurisé pour les requêtes AJAX
$comment_token = bin2hex(random_bytes(32));

if (!isset($_SESSION['comment_contexts'])) {
    $_SESSION['comment_contexts'] = [];
}

$_SESSION['comment_contexts'][$comment_token] = [
    'class' => $comment_class,
    'id' => $comment_id,
    'user' => $_SESSION['user']->id() ?? 0,
    'created' => time()
];

?>

<div id="comments_module"
     data-token="<?= htmlspecialchars($comment_token, ENT_QUOTES, 'UTF-8') ?>">

    <h4 class="mt-4 mb-3">
        <i class="bi bi-chat-left-text"></i> <?php echo ucfirst(thesaurus('comments')); ?>
    </h4>

    <div id="comments_list">
        <?php
        echo Comment::render_comments($comment_class, $comment_id);
        ?>
    </div>

    <hr class="my-4">

    <div id="comment_form_container">

    <!-- AJOUTER UN COMMENTAIRE (nécessite) -->

        <h5 id="comment_form_title"><?php echo ucfirst(thesaurus('add') . " " . thesaurus('a comment')); ?></h5>

        <form id="form">

            <input type="hidden" id="comment_action" value="create">
            <input type="hidden" id="comment_id" value="0">
            <input type="hidden" id="comment_parent" value="0">

            <div class="mb-3" id="comment_privacy_container">

                <label for="comment_privacy" class="form-label">
                    <?php echo ucfirst(thesaurus('privacy')); ?>
                </label>

                <select class="form-select" id="comment_privacy">
                    <option value="0"><?php echo ucfirst(thesaurus('me_only')); ?></option>
                    <option value="1"><?php echo ucfirst(thesaurus('me_and_contrib')); ?></option>
                    <option value="2"><?php echo ucfirst(thesaurus('all_users')); ?></option>
                </select>

            </div>

            <?php
            // Editeur WYSIWYG
            $new_comment = new Comment();
            echo $new_comment->input_text('descr', 'comment_descr');
            ?>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="comment_submit"><i class="bi bi-send"></i> <?php echo ucfirst(thesaurus('publish')); ?></button>
                <button type="button" class="btn btn-outline-secondary" id="comment_cancel" style="display:none;"><?php echo ucfirst(thesaurus('cancel')); ?></button>
            </div>

            <div id="comment_form_errors" class="mt-3" style="display:none;"></div>

        </form>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const module = document.getElementById("comments_module");

    if (!module) return;

    const token = module.dataset.token;

    const form = document.getElementById("form");
    const formContainer = document.getElementById("comment_form_container");
    const commentsList = document.getElementById("comments_list");

    const editor = document.getElementById("id_editor_descr_html");
    const hiddenContent = document.getElementById("id_descr_html");

    const actionInput = document.getElementById("comment_action");
    const idInput = document.getElementById("comment_id");
    const parentInput = document.getElementById("comment_parent");

    const privacyContainer = document.getElementById("comment_privacy_container");
    const privacyInput = document.getElementById("comment_privacy");

    const title = document.getElementById("comment_form_title");
    const submitButton = document.getElementById("comment_submit");
    const cancelButton = document.getElementById("comment_cancel");
    const errorsContainer = document.getElementById("comment_form_errors");

    // Emplacement original du formulaire
    const formPlaceholder = document.createComment("comment-form-placeholder");

    formContainer.parentNode.insertBefore(formPlaceholder, formContainer);


    // --------------------------------------------------
    // Réinitialisation du formulaire
    // --------------------------------------------------

    function resetForm() {

        formPlaceholder.parentNode.insertBefore(
            formContainer,
            formPlaceholder.nextSibling
        );

        actionInput.value = "create";
        idInput.value = "0";
        parentInput.value = "0";
        privacyInput.value = "0";
        privacyContainer.style.display = "";
        title.textContent = "<?php echo ucfirst(thesaurus('add'). " ". thesaurus('a comment')); ?>";
        submitButton.innerHTML = '<i class="bi bi-send"></i> <?php echo ucfirst(thesaurus('publish')); ?>';
        cancelButton.style.display = "none";
        editor.innerHTML = "";
        hiddenContent.value = "";
        errorsContainer.style.display = "none";
        errorsContainer.innerHTML = "";
        form.dataset.busy = "false";
    }


    // --------------------------------------------------
    // Affichage du formulaire sous un commentaire
    // --------------------------------------------------

    function moveForm(target) {
        target.appendChild(formContainer);
        editor.focus();
        form.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }


    // --------------------------------------------------
    // Création d'une réponse
    // --------------------------------------------------

    function replyTo(commentId) {

        resetForm();

        actionInput.value = "create";
        parentInput.value = commentId;
        title.textContent = "<?php echo ucfirst(thesaurus('respond_comment')); ?>";

        moveForm(
            document.querySelector(
                '#comment_' + commentId + ' > .comment-replies'
            ) || document.getElementById('comment_' + commentId)
        );
    }


    // --------------------------------------------------
    // Modification d'un commentaire
    // --------------------------------------------------

    function editComment(commentId) {

        const comment = document.getElementById(
            "comment_" + commentId
        );

        if (!comment) return;

        resetForm();
        actionInput.value = "edit";
        idInput.value = commentId;
        title.textContent = "<?php echo ucfirst(thesaurus('modify_comment')); ?>";
        submitButton.innerHTML = '<i class="bi bi-check-lg"></i> <?php echo ucfirst(thesaurus('validate_changes')); ?>';
        privacyContainer.style.display = "none";

        // Récupération du contenu HTML affiché
        const description = comment.querySelector(".comment-description");

        editor.innerHTML = description.innerHTML;
        moveForm(comment);
    }


    // --------------------------------------------------
    // Suppression d'un commentaire
    // --------------------------------------------------

    async function deleteComment(commentId) {

        if (!confirm(
            "<?php echo ucfirst(thesaurus('confirm_delete_comment')); ?>"
        )) {
            return;
        }

        await sendRequest({
            action: "delete",
            comment_id: commentId,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        });
    }


    // --------------------------------------------------
    // Affichage des erreurs
    // --------------------------------------------------

    function showErrors(data) {
        if (data.errors) {
            errorsContainer.innerHTML = data.errors;
            errorsContainer.style.display = "block";
        } else {
            errorsContainer.innerHTML = "";
            errorsContainer.style.display = "none";
        }
    }


    // --------------------------------------------------
    // Requête AJAX
    // --------------------------------------------------

async function sendRequest(payload) {

    payload.token = token;

    try {
        const response = await fetch(
            "/static/ajax/manage_comments.php",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(payload)
            }
        );

        // Récupération de la réponse brute
        const rawResponse = await response.text();

        console.log("HTTP Status :", response.status);
        console.log("Content-Type :", response.headers.get("Content-Type"));
        console.log("Réponse brute du serveur :", rawResponse);

        // Tentative de décodage JSON
        let data;

        try {
            data = JSON.parse(rawResponse);
        } catch (error) {
            console.error("Réponse JSON invalide :", error);
            return false;
        }

        if (!response.ok || !data.success) {
            showErrors(data);
            return false;
        }

        resetForm();
        commentsList.innerHTML = data.html;
        return true;

    } catch (error) {
        console.error("Erreur AJAX :", error);
        return false;
    }
}

    async function sendRequestOld(payload) {

        payload.token = token;

        try {
            const response = await fetch(
                "/static/ajax/manage_comments.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify(payload)
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                showErrors(data);
                return false;
            }

            // Actualisation du bloc complet
            resetForm();
            commentsList.innerHTML = data.html;
            return true;

        } catch (error) {
            console.error("Erreur AJAX :", error);
            // showErrors({ message: "Impossible de communiquer avec le serveur." });
            return false;
        }
    }


    // --------------------------------------------------
    // Soumission du formulaire
    // --------------------------------------------------

    form.addEventListener("submit", async function (event) {

        event.preventDefault();

        if (form.dataset.busy === "true") return;

        form.dataset.busy = "true";

        // Synchronisation WYSIWYG
        hiddenContent.value = editor.innerHTML;

        const payload = {
            action: actionInput.value,
            comment_id: parseInt(idInput.value, 10),
            parent_id: parseInt(parentInput.value, 10),
            privacy: parseInt(privacyInput.value, 10),
            descr_html: hiddenContent.value,
            project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
        };

        submitButton.disabled = true;
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi...';
        const success = await sendRequest(payload);
        submitButton.disabled = false;

        if (!success) {
            submitButton.innerHTML = originalText;
            form.dataset.busy = "false";
        }

    });


    // --------------------------------------------------
    // Annulation
    // --------------------------------------------------

    cancelButton.addEventListener("click", function () {
        resetForm();
    });


    // --------------------------------------------------
    // Gestion des boutons par délégation
    // --------------------------------------------------

    commentsList.addEventListener("click", function (event) {

        const replyButton = event.target.closest(".comment-reply");
        const editButton = event.target.closest(".comment-edit");
        const deleteButton = event.target.closest(".comment-delete");

        if (replyButton) {
            replyTo(replyButton.dataset.id);
        }
        if (editButton) {
            editComment(editButton.dataset.id);
        }
        if (deleteButton) {
            deleteComment(deleteButton.dataset.id);
        }
    });

    // État initial
    resetForm();

});

</script>