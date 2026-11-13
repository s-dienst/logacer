<?php
    echo "<select class='form-select' id='typePictureSelect'>";
    $default_val_pictures = list_val('type_picture', false, true);
    $name_val_pictures = list_val('type_picture');
    echo "<option value='all'>" . ucfirst(thesaurus('display all')) . "</option>";
    for ($i = 0; $i < count($default_val_pictures); $i++) {
        echo "<option value='" . $default_val_pictures[$i] . "'>" . ucfirst($name_val_pictures[$i]) . "</option>";
    }
    echo "</select>";

    echo "<div class='gallery'>";
    foreach ($objects as $object) {
        $pictures = Picture::find_by_parent($object->id(), ['type_picture']);
        foreach ($pictures as $picture) {
            $picture->display();
        }
    }
    echo "</div>";

    // Ajout cadre pour affichage image en grand
    Picture::lightbox();
?>

<script>
document.getElementById("typePictureSelect").addEventListener("change", function() {
    var selectedType = this.value;
    var pictures = document.querySelectorAll(".picture");
    
    pictures.forEach(function(picture) {
        if (selectedType === "all") {
            picture.style.display = "block";
        } else if (picture.getAttribute("type-picture") === selectedType) {
            picture.style.display = "block";
        } else {
            picture.style.display = "none";
        }
    });
});
</script>