<?php

function err_max_char(int $n_char, string $name) {
    $name = ucfirst(thesaurus($name));
    switch(LANGUAGE) {
        case "fr":
            return "{$name} dépasse la taille maximale prévue (maximum {$n_char} caractères).";
            break;
        case "it":
            return "{$name} supera la lunghezza massima consentita (massimo {$n_char} caratteri).";
            break;
        case "de":
            return "{$name} überschreitet die maximal zulässige Länge (maximal {$n_char} Zeichen).";
            break;
        case "es":
            return "{$name} supera la longitud máxima permitida (máximo {$n_char} caracteres).";
            break;
        default:
            return "{$name} exceeds the maximum allowed length (maximum {$n_char} characters).";
    }
}

function err_min_char(int $n_char, string $name) {
    $name = ucfirst(thesaurus($name));
    switch(LANGUAGE) {
        case "fr":
            return "{$name} est trop petit (minimum {$n_char} caractères).";
            break;
        case "it":
            return "{$name} è troppo corto (minimo {$n_char} caratteri).";
            break;
        case "de":
            return "{$name} ist zu kurz (mindestens {$n_char} Zeichen).";
            break;
        case "es":
            return "{$name} es demasiado corto (mínimo {$n_char} caracteres).";
            break;
        default:
            return "{$name} is too short (minimum {$n_char} characters).";            
    }
}

function err_blank(string $name) {
    $name = thesaurus($name);
    switch(LANGUAGE) {
        case "fr":
            return "Vous devez indiquer {$name}.";
            break;
        case "it":
            return "È necessario indicare {$name}.";
            break;
        case "de":
            return "{$name} muss angegeben werden.";
            break;
        case "es":
            return "Debe indicar {$name}.";
            break;
        default:
            return "You must indicate {$name}.";            
    }
}

function err_owner(string $class, string $name) {
    $class = thesaurus($class);
    $name = thesaurus($name);
    switch(LANGUAGE) {
        case "fr":
            return "Votre {$class} doit avoir un {$name} faisant partie des utilisateurs de " . WEBSITE_NAME . ".";
            break;
        case "it":
            return "Il tuo {$class} deve avere un {$name} che sia un utente di " . WEBSITE_NAME . ".";
            break;
        case "de":
            return "Ihr {$class} muss einen {$name} haben, der ein Benutzer von " . WEBSITE_NAME . " ist.";
            break;
        case "es":
            return "Su {$class} debe tener un {$name} que sea usuario de " . WEBSITE_NAME . ".";
            break;
        default:
            return "Your {$class} must have a {$name} that is a " . WEBSITE_NAME . " user.";
    }
}

function err_min($min, string $name) {
    $name = ucfirst(thesaurus($name));
    switch(LANGUAGE) {
        case "fr":
            return "{$name} ne peut pas être en-dessous de " . $min . " caractères";
            break;
        case "it":
            return "{$name} non può essere inferiore a " . $min . " caratteri";
            break;
        case "de":
            return "{$name} darf nicht weniger als " . $min . " Zeichen umfassen";
            break;
        case "es":
            return "{$name} no puede tener menos de " . $min . " caracteres";
            break;
        default:
            return "{$name} cannot be less than " . $min . " characters.";            
    }
}

function err_max($max, string $name) {
    $name = ucfirst(thesaurus($name));
    switch(LANGUAGE) {
        case "fr":
            return "{$name} ne peut pas être au-dessus de " . $max . " caractères";
            break;
        case "it":
            return "{$name} non può superare " . $max . " caratteri";
            break;
        case "de":
            return "{$name} darf nicht mehr als " . $max . " Zeichen umfassen";
            break;
        case "es":
            return "{$name} no puede tener más de " . $max . " caracteres";
            break;
        default:
            return "{$name} cannot be more than " . $max . " characters.";            
    }
}

function err_exists(string $name) {
    $name = thesaurus($name);
    switch(LANGUAGE) {
        case "fr":
            return "Aucun(e) {$name} ne porte l&#39;identifiant encodé.";
            break;
        case "it":
            return "Nessun {$name} ha l'identificativo codificato.";
            break;
        case "de":
            return "Kein {$name} besitzt die codierte Kennung.";
            break;
        case "es":
            return "Ningún {$name} tiene el identificador codificado.";
            break;
        default:
            return "No {$name} has the encoded identifier.";
    }
}

function err_not_unique(string $name, string $suppl="", bool $single=true) {
    switch(LANGUAGE) {
        case "fr":
            if ($single) {
                $name = ucfirst(thesaurus('this ' . $name));
                $suppl = thesaurus('another ' . $suppl);
                return "{$name} est déjà attribué à {$suppl}";
            }
            switch ($name) {
                case 'site':                return 'Le code est déjà utilisé par une autre opération archéologique de ' . secure($suppl) . "."; break;
                case 'phase':               return 'Le code est déjà utilisé pour un autre horizon-site de l&#39;opération archéologique ' . secure($suppl) . "."; break;
                case 'context':             return 'Le code est déjà utilisé pour un autre contexte de l&#39;horizon-site ' . secure($suppl) . "."; break;
                case 'object':              return 'Le numéro d&#39;inventaire est déjà utilisé pour un autre objet du contexte' . secure($suppl); break;
                case 'horizon':             return 'Le code est déjà utilisé pour un autre horizon du groupe ' . secure($suppl) . "."; break;
                case 'type1':               return 'Le nom est déjà utilisé pour un autre type de la typologie ' . secure($suppl) . "."; break;
            }
            break;
        case "it":
            if ($single) {
                $name = ucfirst(thesaurus('this ' . $name));
                $suppl = thesaurus('another ' . $suppl);
                return "{$name} è già attribuito a {$suppl}";
            }
            switch ($name) {
                case 'site':                return 'Il codice è già utilizzato da un\'altra operazione archeologica di ' . secure($suppl) . "."; break;
                case 'phase':               return 'Il codice è già utilizzato per un altro orizzonte-sito dell\'operazione archeologica ' . secure($suppl) . "."; break;
                case 'context':             return 'Il codice è già utilizzato per un altro contesto dell\'orizzonte-sito ' . secure($suppl) . "."; break;
                case 'object':              return 'Il numero di inventario è già utilizzato per un altro oggetto del contesto' . secure($suppl); break;
                case 'horizon':             return 'Il codice è già utilizzato per un altro orizzonte del gruppo ' . secure($suppl) . "."; break;
                case 'type1':               return 'Il nome è già utilizzato per un altro tipo della tipologia ' . secure($suppl) . "."; break;
            }
            break;
        case "de":
            if ($single) {
                $name = ucfirst(thesaurus('this ' . $name));
                $suppl = thesaurus('another ' . $suppl);
                return "{$name} ist bereits {$suppl} zugewiesen";
            }
            switch ($name) {
                case 'site':                return 'Der Code wird bereits von einem anderen archäologischen Vorgang von ' . secure($suppl) . " verwendet."; break;
                case 'phase':               return 'Der Code wird bereits für einen anderen Fundstellen-Horizont des archäologischen Vorgangs ' . secure($suppl) . " verwendet."; break;
                case 'context':             return 'Der Code wird bereits für einen anderen Kontext des Fundstellen-Horizonts ' . secure($suppl) . " verwendet."; break;
                case 'object':              return 'Die Inventarnummer wird bereits für ein anderes Objekt des Kontexts' . secure($suppl) . " verwendet."; break;
                case 'horizon':             return 'Der Code wird bereits für einen anderen Horizont der Gruppe ' . secure($suppl) . " verwendet."; break;
                case 'type1':               return 'Der Name wird bereits für einen anderen Typ der Typologie ' . secure($suppl) . " verwendet."; break;
            }
            break;
        case "es":
            if ($single) {
                $name = ucfirst(thesaurus('this ' . $name));
                $suppl = thesaurus('another ' . $suppl);
                return "{$name} ya está atribuido a {$suppl}";
            }
            switch ($name) {
                case 'site':                return 'El código ya está utilizado por otra operación arqueológica de ' . secure($suppl) . "."; break;
                case 'phase':               return 'El código ya está utilizado para otro horizonte-yacimiento de la operación arqueológica ' . secure($suppl) . "."; break;
                case 'context':             return 'El código ya está utilizado para otro contexto del horizonte-yacimiento ' . secure($suppl) . "."; break;
                case 'object':              return 'El número de inventario ya está utilizado para otro objeto del contexto' . secure($suppl); break;
                case 'horizon':             return 'El código ya está utilizado para otro horizonte del grupo ' . secure($suppl) . "."; break;
                case 'type1':               return 'El nombre ya está utilizado para otro tipo de la tipología ' . secure($suppl) . "."; break;
            }
            break;
        default:
            if ($single) {
                $name = ucfirst(thesaurus('this ' . $name));
                $suppl = thesaurus('another ' . $suppl);
                return "{$name} is already attributed to {$suppl}";
            }
            switch ($name) {
                case 'site':                return 'The code is already used by another archaeological operation of ' . secure($suppl) . "."; break;
                case 'phase':               return 'The code is already used for another site-horizon of the archaeological operation ' . secure($suppl) . "."; break;
                case 'context':             return 'The code is already used for another context of the site-horizon ' . secure($suppl) . "."; break;
                case 'object':              return 'The inventory number is already used for another artifact in the context' . secure($suppl); break;
                case 'horizon':             return 'The code is already used for another horizon in the group ' . secure($suppl) . "."; break;
                case 'type1':               return 'The name is already used for another type in the typology ' . secure($suppl) . "."; break;
            }
    }
}

function err_typo_cat($typeerror, $arg="") {
    switch(LANGUAGE) {
        case "fr":
            switch ($typeerror) {
                case 'link_cat':            return 'Un type porte déjà le nom "' . $arg[0] . '" pour la catégorie "' . $arg[1] . '".'; break;
                case 'delink_cat':          return 'Vous ne pouvez pas supprimer le lien avec la catégorie "' . $arg . '" tant que des objets sont liés à la fois à des types de la typologie et à cette catégorie'; break;
                case 'children':            return 'Le type parent sélectionné est un sous-type du type en cours de modification, ce qui n&#39;est pas autorisé.'; break;
            }
            break;
        case "it":
            switch ($typeerror) {
                case 'link_cat':            return 'Esiste già un tipo con il nome "' . $arg[0] . '" per la categoria "' . $arg[1] . '".'; break;
                case 'delink_cat':          return 'Non è possibile rimuovere il collegamento con la categoria "' . $arg . '" finché vi sono oggetti collegati sia a tipi della tipologia sia a questa categoria'; break;
                case 'children':            return 'Il tipo principale selezionato è un sottotipo del tipo attualmente in modifica, operazione non consentita.'; break;
            }
            break;
        case "de":
            switch ($typeerror) {
                case 'link_cat':            return 'Ein Typ mit dem Namen "' . $arg[0] . '" existiert bereits für die Kategorie "' . $arg[1] . '".'; break;
                case 'delink_cat':          return 'Die Verknüpfung mit der Kategorie "' . $arg . '" kann nicht entfernt werden, solange Objekte sowohl mit Typen der Typologie als auch mit dieser Kategorie verknüpft sind'; break;
                case 'children':            return 'Der ausgewählte Haupttyp ist ein Untertyp des derzeit bearbeiteten Typs, was nicht zulässig ist.'; break;
            }
            break;
        case "es":
            switch ($typeerror) {
                case 'link_cat':            return 'Ya existe un tipo con el nombre "' . $arg[0] . '" para la categoría "' . $arg[1] . '".'; break;
                case 'delink_cat':          return 'No puede eliminar el vínculo con la categoría "' . $arg . '" mientras haya objetos vinculados tanto a tipos de la tipología como a esta categoría'; break;
                case 'children':            return 'El tipo principal seleccionado es un subtipo del tipo que se está modificando, lo cual no está permitido.'; break;
            }
            break;
        default:
            switch ($typeerror) {
                case 'link_cat':            return 'A type with the name "' . $arg[0] . '" already exists for the category "' . $arg[1] . '".'; break;
                case 'delink_cat':          return 'You cannot remove the link to the category "' . $arg . '" as long as artifacts are linked both to types in the typology and to this category'; break;
                case 'children':            return 'The selected main type is a subtype of the type currently being edited, which is not allowed.'; break;
            }            
    }
}

function err_fabric($typeerror) {
    switch(LANGUAGE) {
        case "fr":
            switch ($typeerror) {
                case 'children':            return 'Le groupe de pâtes parent sélectionné est un sous-groupe du groupe de pâtes en cours de modification, ce qui n&#39;est pas autorisé.'; break;
            }
            break;
        case "it":
            switch ($typeerror) {
                case 'children':            return 'Il gruppo di impasti principale selezionato è un sottogruppo del gruppo di impasti attualmente in modifica, operazione non consentita.'; break;
            }
            break;
        case "de":
            switch ($typeerror) {
                case 'children':            return 'Die ausgewählte Hauptwarengruppe ist eine Untergruppe der derzeit bearbeiteten Warengruppe, was nicht zulässig ist.'; break;
            }
            break;
        case "es":
            switch ($typeerror) {
                case 'children':            return 'El grupo de pastas principal seleccionado es un subgrupo del grupo de pastas que se está modificando, lo cual no está permitido.'; break;
            }
            break;
        default:
            switch ($typeerror) {
                case 'children':            return 'The selected main fabric is a subfabric of the fabric currently being edited, which is not allowed.'; break;
            }            
    }
}

function err_forbidden($verified, $property) {
    switch(LANGUAGE) {
        case "fr":
            return "Le {$property} ne peut pas être '{$verified}'.";
            break;
        case "it":
            return "Il {$property} non può essere '{$verified}'.";
            break;
        case "de":
            return "{$property} darf nicht '{$verified}' sein.";
            break;
        case "es":
            return "El {$property} no puede ser '{$verified}'.";
            break;
        default:
            return "The {$property} cannot be '{$verified}'.";
    }
}

function err_characters($property) {
    switch(LANGUAGE) {
        case "fr":
            return "Le {$property} encodé contient des caractères interdits.";
            break;
        case "it":
            return "Il {$property} codificato contiene caratteri non consentiti.";
            break;
        case "de":
            return "Der eingegebene Wert für {$property} enthält unzulässige Zeichen.";
            break;
        case "es":
            return "El {$property} codificado contiene caracteres no permitidos.";
            break;
        default:
            return "The encoded {$property} contains forbidden characters.";
    }
}

function err_comment($typeerror) {
    switch(LANGUAGE) {
        case "fr":
            switch ($typeerror) {
                case 'unknown_class':       return 'Le type d&#39;élément auquel est lié le commentaire semble ne pas exister.'; break;
                case 'no_object':           return 'L&#39;élément auquel est lié le commentaire semble ne pas exister.'; break;
            }
            break;
        case "it":
            switch ($typeerror) {
                case 'unknown_class':       return 'Il tipo di elemento a cui è associato il commento sembra non esistere.'; break;
                case 'no_object':           return 'L’elemento a cui è associato il commento sembra non esistere.'; break;
            }
            break;
        case "de":
            switch ($typeerror) {
                case 'unknown_class':       return 'Der Typ des Elements, mit dem der Kommentar verknüpft ist, scheint nicht zu existieren.'; break;
                case 'no_object':           return 'Das Element, mit dem der Kommentar verknüpft ist, scheint nicht zu existieren.'; break;
            }
            break;
        case "es":
            switch ($typeerror) {
                case 'unknown_class':       return 'El tipo de elemento al que está asociado el comentario parece no existir.'; break;
                case 'no_object':           return 'El elemento al que está asociado el comentario parece no existir.'; break;
            }
            break;
        default:
            switch ($typeerror) {
                case 'unknown_class':       return 'The type of item to which the comment is linked does not seem to exist.'; break;
                case 'no_object':           return 'The item to which the comment is linked does not seem to exist.'; break;
            }            
    }
}

function err_fatal(string $fatal_error, array $suppl_args = array()) {
    switch(LANGUAGE) {
        case "fr":
            switch ($fatal_error) {
                case 'no_site':             return 'Il n&#39;existe aucune opération archéologique correspondant à cet utilisateur et à ce code.'; break;
                case 'no_phase':            return 'Il n&#39;existe aucun horizon-site correspondant à cette opération archéologique.'; break;
                case 'no_context':          return 'Il n&#39;existe aucun contexte correspondant à cet horizon-site.'; break;
                case 'no_object':           return 'Il n&#39;existe aucun objet portant cet identifiant'; break;
                case 'no_picture':          return 'Il n&#39;existe aucune illustration portant cet identifiant'; break;        
                case 'no_project':          return 'Il n&#39;existe aucun projet portant cet identifiant'; break;
                case 'no_facies':           return 'Il n&#39;existe aucun groupe d&#39;horizons portant cet identifiant'; break;
                case 'no_horizon':          return 'Il n&#39;existe aucun horizon portant cet identifiant'; break;
                case 'no_reference':        return 'Il n&#39;existe aucune référence bibliographique avec cet identifiant.'; break;
                case 'no_news':             return 'Il n&#39;existe aucune actualité avec cet identifiant.'; break;
                case 'no_typology':         return 'Il n&#39;existe aucune typologie correspondant à cet identifiant.'; break;
                case 'no_type':             return 'Il n&#39;existe aucun type correspondant à ce code pour cette typologie.'; break;
                case 'no_fabric':           return 'Il n&#39;existe aucun groupe de pâtes correspondant à ce code.'; break;
                case 'no_country':          return 'Il n&#39;existe aucun pays correspondant à ce code.'; break;
                case 'no_region':           return 'Il n&#39;existe aucune région correspondant à ce code.'; break;
                case 'non_public_site':     return 'Les informations concernant cette opération archéologique n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_phase':    return 'Les informations concernant cet horizon-site n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_context':  return 'Les informations concernant ce contexte n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_object':   return 'Les informations concernant cet objet n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_facies':   return 'Les informations concernant ce groupe d&#39;horizons n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_horizon':  return 'Les informations concernant cet horizon n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_typology': return 'Les informations concernant cette typologie n&#39;ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'non_public_fabric':   return 'Les informations concernant ce groupe de pâtes n&#;39ont pas été rendues publiques et elles ne vous sont pas accessibles.'; break;
                case 'no_connexion':        return 'Vous n&#39;êtes pas connecté et n&#39;avez pas accès à cette page.'; break;
                case 'not_contributor':     return 'Vous n&#39;êtes pas le responsable, créateur ou contributeur de l&#39;élément que vous souhaitez modifier.'; break;
                case 'not_staff':           return 'Vous ne pouvez pas modifier la liste des catégories car vous n&#39;êtes pas administrateur de ' . WEBSITE_NAME . '. Si vous souhaitez le devenir, contactez l&#39un des administrateurs actuels.'; break;
                case 'no_contributor_rights':return 'Vous ne pouvez pas modifier cette liste car vous n&#39;êtes pas contributeur de ' . WEBSITE_NAME . '. Si vous souhaitez le devenir, contactez l&#39un des administrateurs.'; break;
                case 'not_project_contributor':return 'Vous n&#39;êtes pas associé à ce projet et vous n&#39;avez donc pas accès à cette page.'; break;
                case 'already_logged':      return 'Vous êtes déjà connecté. Si vous voulez vous connecter à un autre compte, veuillez d&#39;abord vous déconnecter'; break;
                case 'research not correct':return 'La recherche que vous avez tenté de faire n&#39;a pas la bonne syntaxe et ne peut être exécutée.'; break;
                case 'add_data_file':       return 'Il y a eu un problème avec le téléchargement de votre fichier. Nous vous conseillons de limiter la taille à 50.000 lignes ou moins (< 2 Mo). Si cela perdure, contactez l&#39;administrateur du site.'; break;
                case 'add_data_template':   return 'Il y a eu un problème avec votre template :'; break;
                case 'add_objects_no_site': return 'Vous devez avoir une colonne pour le code de l&#;opération archéologique et le nom d&#39;utilisateur, ou pour le nom complet de l&#39;opération archéologique, formatée telle que dans le template téléchargeable.'; break;
                case 'add_objects_no_context':return 'Vous devez avoir une colonne pour le code du contexte, formatée telle que dans le template téléchargeable.'; break;
                case 'add_objects_no_number':return 'Vous devez avoir une colonne pour le numéro d&#39;inventaire, formatée telle que dans le template téléchargeable.'; break;
                case 'add_objects_no_category_abbr':return 'Vous devez avoir une colonne pour l&#39;abbréviation de la catégorie, formatée telle que dans le template téléchargeable.'; break;
                case 'add_objects_no_function_name':return 'Vous devez avoir une colonne pour le nom de la fonction, formatée telle que dans le template téléchargeable.'; break;
                case 'add_objects_no_type_name':return 'Vous devez avoir une colonne pour le nom du type, formatée telle que dans le template téléchargeable.'; break;
                case 'add_sites_no_code':   return 'Vous devez avoir une colonne pour le code de l&#39;opération archéologique, formatée telle que dans le template téléchargeable.'; break;
                case 'add_sites_no_name':   return 'Vous devez avoir une colonne pour le nom de l&#39;opération archéologique, formatée telle que dans le template téléchargeable.'; break;
                case 'add_contexts_no_context_code':return 'Vous devez avoir une colonne pour le code du contexte, formatée telle que dans le template téléchargeable.'; break;
                case 'add_contexts_no_context_name':return 'Vous devez avoir une colonne pour le code du contexte, formatée telle que dans le template téléchargeable.'; break;
                case 'no_tutorial':         return 'Il n&#39;y a aucun tutorial à cette adresse'; break;
                case 'contexts_in_default_phase':return 'Il reste des contextes (avec ou sans horizon site) ; vous devez les supprimer avant de pouvoir supprimer l&#39;opération archéologique.'; break;
                case 'not_content_project': return 'Vous essayez d&#39;accéder à un élément qui ne fait pas partie du projet dans lequel vous naviguez.'; break;
                case 'not_in_project':      return 'Votre projet n&#39;inclut pas cette option.'; break;
                case 'not_global_typology': return 'Il s&#39;agit d&#39;une typologie spécifique à un projet, elle doit être consultée au sein de ce projet.'; break;
                case 'not_global_fabric':   return 'Il s&#39;agit d&#39;un groupe de pâtes spécifique à un projet, il doit être consulté au sein de ce projet.'; break;
                case 'not_existing_page':   return 'Cette page n&#39;existe pas dans cette version de LOGACer'; break;
                case 'not_project_language':return 'Cette langue n&#39;est pas prise en compte pour ce projet.'; break;
                default:                    return 'Erreur non définie';
            }
            break;
        case "it":
            switch ($fatal_error) {
                case 'no_site':             return 'Non esiste alcuna operazione archeologica corrispondente a questo utente e a questo codice.'; break;
                case 'no_phase':            return 'Non esiste alcun orizzonte-sito corrispondente a questa operazione archeologica.'; break;
                case 'no_context':          return 'Non esiste alcun contesto corrispondente a questo orizzonte-sito.'; break;
                case 'no_object':           return 'Non esiste alcun reperto con questo identificativo.'; break;
                case 'no_picture':          return 'Non esiste alcuna illustrazione con questo identificativo.'; break;
                case 'no_project':          return 'Non esiste alcun progetto con questo identificativo.'; break;
                case 'no_facies':           return 'Non esiste alcun gruppo di orizzonti con questo identificativo.'; break;
                case 'no_horizon':          return 'Non esiste alcun orizzonte con questo identificativo.'; break;
                case 'no_reference':        return 'Non esiste alcun riferimento bibliografico con questo identificativo.'; break;
                case 'no_news':             return 'Non esiste alcuna notizia con questo identificativo.'; break;
                case 'no_typology':         return 'Non esiste alcuna tipologia corrispondente a questo identificativo.'; break;
                case 'no_type':             return 'Non esiste alcun tipo corrispondente a questo codice in questa tipologia.'; break;
                case 'no_fabric':           return 'Non esiste alcun gruppo di impasti corrispondente a questo codice.'; break;
                case 'no_country':          return 'Non esiste alcun paese corrispondente a questo codice.'; break;
                case 'no_region':           return 'Non esiste alcuna regione corrispondente a questo codice.'; break;
                case 'non_public_site':     return 'Le informazioni relative a questa operazione archeologica non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_phase':    return 'Le informazioni relative a questo orizzonte-sito non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_context':  return 'Le informazioni relative a questo contesto non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_object':   return 'Le informazioni relative a questo reperto non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_facies':   return 'Le informazioni relative a questo gruppo di orizzonti non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_horizon':  return 'Le informazioni relative a questo orizzonte non sono state rese pubbliche e non vi hai accesso.'; break;
                case 'non_public_typology': return 'Le informazioni relative a questa tipologia non sono state rese pubbliche e non sono accessibili.'; break;
                case 'non_public_fabric':   return 'Le informazioni relative a questo gruppo di impasti ceramici non sono state rese pubbliche e non sono accessibili.'; break;
                case 'no_connexion':        return 'Non hai effettuato l&#39;accesso e non hai accesso a questa pagina.'; break;
                case 'not_contributor':     return 'Non sei il responsabile, il creatore o un collaboratore dell&#39;elemento che desideri modificare.'; break;
                case 'not_staff':           return 'Non puoi modificare l&#39;elenco delle categorie perché non sei un amministratore di ' . WEBSITE_NAME . '. Se desideri diventarlo, contatta uno degli amministratori attuali.'; break;
                case 'no_contributor_rights':return 'Non puoi modificare questo elenco perché non sei un collaboratore di ' . WEBSITE_NAME . '. Se desideri diventarlo, contatta uno degli amministratori.'; break;
                case 'not_project_contributor':return 'Non sei associato a questo progetto e pertanto non hai accesso a questa pagina.'; break;
                case 'already_logged':      return 'Hai già effettuato l&#39;accesso. Se desideri accedere a un altro account, effettua prima il logout.'; break;
                case 'research not correct':return 'La ricerca che hai tentato di effettuare non ha una sintassi corretta e non può essere eseguita.'; break;
                case 'add_data_file':       return 'Si è verificato un problema durante il caricamento del file. Ti consigliamo di limitare le dimensioni del file a 50.000 righe o meno (< 2 MB). Se il problema persiste, contatta l&#39;amministratore del sito.'; break;
                case 'add_data_template':   return 'Si è verificato un problema con il tuo template:'; break;
                case 'add_objects_no_site': return 'Devi avere una colonna per il codice dell&#39;operazione archeologica e il nome utente, oppure per il nome completo dell&#39;operazione archeologica, formattata come nel template scaricabile.'; break;
                case 'add_objects_no_context':return 'Devi avere una colonna per il codice del contesto, formattata come nel template scaricabile.'; break;
                case 'add_objects_no_number':return 'Devi avere una colonna per il numero di inventario, formattata come nel template scaricabile.'; break;
                case 'add_objects_no_category_abbr':return 'Devi avere una colonna per l&#39;abbreviazione della categoria, formattata come nel template scaricabile.'; break;
                case 'add_objects_no_function_name':return 'Devi avere una colonna per il nome della funzione, formattata come nel template scaricabile.'; break;
                case 'add_objects_no_type_name':return 'Devi avere una colonna per il nome del tipo, formattata come nel template scaricabile.'; break;
                case 'add_sites_no_code':   return 'Devi avere una colonna per il codice dell&#39;operazione archeologica, formattata come nel template scaricabile.'; break;
                case 'add_sites_no_name':   return 'Devi avere una colonna per il nome dell&#39;operazione archeologica, formattata come nel template scaricabile.'; break;
                case 'add_contexts_no_context_code':return 'Devi avere una colonna per il codice del contesto, formattata come nel template scaricabile.'; break;
                case 'add_contexts_no_context_name':return 'Devi avere una colonna per il codice del contesto, formattata come nel template scaricabile.'; break;
                case 'no_tutorial':         return 'Non esiste alcun tutorial a questo indirizzo.'; break;
                case 'contexts_in_default_phase':return 'Sono ancora presenti alcuni contesti (con o senza orizzonti-sito); devi eliminarli prima di poter eliminare l&#39;operazione archeologica.'; break;
                case 'not_content_project': return 'Si sta tentando di accedere a un elemento che non fa parte del progetto in cui si sta navigando.'; break;
                case 'not_in_project':      return 'Il progetto non include questa opzione.'; break;
                case 'not_global_typology': return 'Si tratta di una tipologia specifica di un progetto e deve essere consultata all’interno di tale progetto.'; break;
                case 'not_global_fabric':   return 'Si tratta di un gruppo di impasti ceramici specifico di un progetto e deve essere consultato all’interno di tale progetto.'; break;
                case 'not_existing_page':   return 'Questa pagina non esiste in questa versione di LOGACer.'; break;
                case 'not_project_language':return 'Questa lingua non è supportata per questo progetto.'; break;
                default:                    return 'Errore non definito';
            }
            break;
        case "de":
            switch ($fatal_error) {
                case 'no_site':             return 'Es gibt keine archäologische Untersuchung, die diesem Benutzer und diesem Code entspricht.'; break;
                case 'no_phase':            return 'Es gibt keinen Standort-Horizont, der dieser archäologischen Untersuchung entspricht.'; break;
                case 'no_context':          return 'Es gibt keinen Kontext, der diesem Standort-Horizont entspricht.'; break;
                case 'no_object':           return 'Es gibt kein Objekt mit dieser Kennung.'; break;
                case 'no_picture':          return 'Es gibt keine Abbildung mit dieser Kennung.'; break;
                case 'no_project':          return 'Es gibt kein Projekt mit dieser Kennung.'; break;
                case 'no_facies':           return 'Es gibt keine Gruppe von Horizonten mit dieser Kennung.'; break;
                case 'no_horizon':          return 'Es gibt keinen Horizont mit dieser Kennung.'; break;
                case 'no_reference':        return 'Es gibt keine bibliografische Referenz mit dieser Kennung.'; break;
                case 'no_news':             return 'Es gibt keine Nachricht mit dieser Kennung.'; break;
                case 'no_typology':         return 'Es gibt keine Typologie, die dieser Kennung entspricht.'; break;
                case 'no_type':             return 'Es gibt keinen Typ, der diesem Code in dieser Typologie entspricht.'; break;
                case 'no_fabric':           return 'Es gibt keine Gruppe von Keramikscherben, die diesem Code entspricht.'; break;
                case 'no_country':          return 'Es gibt kein Land, das diesem Code entspricht.'; break;
                case 'no_region':           return 'Es gibt keine Region, die diesem Code entspricht.'; break;
                case 'non_public_site':     return 'Die Informationen zu dieser archäologischen Untersuchung wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_phase':    return 'Die Informationen zu diesem Standort-Horizont wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_context':  return 'Die Informationen zu diesem Kontext wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_object':   return 'Die Informationen zu diesem Objekt wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_facies':   return 'Die Informationen zu dieser Gruppe von Horizonten wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_horizon':  return 'Die Informationen zu diesem Horizont wurden nicht veröffentlicht und Sie haben keinen Zugriff darauf.'; break;
                case 'non_public_typology': return 'Die Informationen zu dieser Typologie wurden nicht veröffentlicht und sind für Sie nicht zugänglich.'; break;
                case 'non_public_fabric':   return 'Die Informationen zu dieser Warengruppe wurden nicht veröffentlicht und sind für Sie nicht zugänglich.'; break;
                case 'no_connexion':        return 'Sie sind nicht angemeldet und haben keinen Zugriff auf diese Seite.'; break;
                case 'not_contributor':     return 'Sie sind weder für das Element verantwortlich noch dessen Ersteller oder Mitwirkender und können es daher nicht bearbeiten.'; break;
                case 'not_staff':           return 'Sie können die Kategorienliste nicht bearbeiten, da Sie kein Administrator von ' . WEBSITE_NAME . ' sind. Wenn Sie Administrator werden möchten, wenden Sie sich an einen der derzeitigen Administratoren.'; break;
                case 'no_contributor_rights':return 'Sie können diese Liste nicht bearbeiten, da Sie kein Mitwirkender von ' . WEBSITE_NAME . ' sind. Wenn Sie Mitwirkender werden möchten, wenden Sie sich an einen Administrator.'; break;
                case 'not_project_contributor':return 'Sie sind diesem Projekt nicht zugeordnet und haben daher keinen Zugriff auf diese Seite.'; break;
                case 'already_logged':      return 'Sie sind bereits angemeldet. Wenn Sie sich bei einem anderen Konto anmelden möchten, melden Sie sich bitte zuerst ab.'; break;
                case 'research not correct':return 'Die von Ihnen durchgeführte Suche hat nicht die richtige Syntax und kann nicht ausgeführt werden.'; break;
                case 'add_data_file':       return 'Beim Hochladen Ihrer Datei ist ein Problem aufgetreten. Wir empfehlen, die Dateigröße auf 50.000 Zeilen oder weniger zu begrenzen (< 2 MB). Wenn das Problem weiterhin besteht, wenden Sie sich an den Administrator der Website.'; break;
                case 'add_data_template':   return 'Es gibt ein Problem mit Ihrem Template:'; break;
                case 'add_objects_no_site': return 'Sie müssen eine Spalte für den Code der archäologischen Untersuchung und den Benutzernamen oder für den vollständigen Namen der archäologischen Untersuchung haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_objects_no_context':return 'Sie müssen eine Spalte für den Kontextcode haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_objects_no_number':return 'Sie müssen eine Spalte für die Inventarnummer haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_objects_no_category_abbr':return 'Sie müssen eine Spalte für die Abkürzung der Kategorie haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_objects_no_function_name':return 'Sie müssen eine Spalte für den Funktionsnamen haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_objects_no_type_name':return 'Sie müssen eine Spalte für den Typnamen haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_sites_no_code':   return 'Sie müssen eine Spalte für den Code der archäologischen Untersuchung haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_sites_no_name':   return 'Sie müssen eine Spalte für den Namen der archäologischen Untersuchung haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_contexts_no_context_code':return 'Sie müssen eine Spalte für den Kontextcode haben, formatiert wie im herunterladbaren Template.'; break;
                case 'add_contexts_no_context_name':return 'Sie müssen eine Spalte für den Kontextcode haben, formatiert wie im herunterladbaren Template.'; break;
                case 'no_tutorial':         return 'Unter dieser Adresse gibt es kein Tutorial.'; break;
                case 'contexts_in_default_phase':return 'Es sind noch Kontexte (mit oder ohne Standort-Horizonte) vorhanden; Sie müssen diese löschen, bevor Sie die archäologische Untersuchung löschen können.'; break;
                case 'not_content_project': return 'Sie versuchen, auf ein Element zuzugreifen, das nicht zu dem Projekt gehört, in dem Sie gerade navigieren.'; break;
                case 'not_in_project':      return 'Ihr Projekt umfasst diese Option nicht.'; break;
                case 'not_global_typology': return 'Es handelt sich um eine projektspezifische Typologie, auf die innerhalb des entsprechenden Projekts zugegriffen werden muss.'; break;
                case 'not_global_fabric':   return 'Es handelt sich um eine projektspezifische Warengruppe, auf die innerhalb des entsprechenden Projekts zugegriffen werden muss.'; break;
                case 'not_existing_page':   return 'Diese Seite existiert in dieser Version von LOGACer nicht.'; break;
                case 'not_project_language':return 'Diese Sprache wird für dieses Projekt nicht unterstützt.'; break;
                default:                    return 'Nicht definierter Fehler';
            }
            break;
        case "es":
            switch ($fatal_error) {
                case 'no_site':             return 'No existe ninguna operación arqueológica que corresponda a este usuario y a este código.'; break;
                case 'no_phase':            return 'No existe ningún horizonte-sitio correspondiente a esta operación arqueológica.'; break;
                case 'no_context':          return 'No existe ningún contexto correspondiente a este horizonte-sitio.'; break;
                case 'no_object':           return 'No existe ningún objeto con este identificador.'; break;
                case 'no_picture':          return 'No existe ninguna ilustración con este identificador.'; break;
                case 'no_project':          return 'No existe ningún proyecto con este identificador.'; break;
                case 'no_facies':           return 'No existe ningún grupo de horizontes con este identificador.'; break;
                case 'no_horizon':          return 'No existe ningún horizonte con este identificador.'; break;
                case 'no_reference':        return 'No existe ninguna referencia bibliográfica con este identificador.'; break;
                case 'no_news':             return 'No existe ninguna noticia con este identificador.'; break;
                case 'no_typology':         return 'No existe ninguna tipología correspondiente a este identificador.'; break;
                case 'no_type':             return 'No existe ningún tipo correspondiente a este código en esta tipología.'; break;
                case 'no_fabric':           return 'No existe ningún grupo de pastas correspondiente a este código.'; break;
                case 'no_country':          return 'No existe ningún país correspondiente a este código.'; break;
                case 'no_region':           return 'No existe ninguna región correspondiente a este código.'; break;
                case 'non_public_site':     return 'La información relativa a esta operación arqueológica no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_phase':    return 'La información relativa a este horizonte-sitio no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_context':  return 'La información relativa a este contexto no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_object':   return 'La información relativa a este objeto no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_facies':   return 'La información relativa a este grupo de horizontes no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_horizon':  return 'La información relativa a este horizonte no se ha hecho pública y usted no tiene acceso a ella.'; break;
                case 'non_public_typology': return 'La información relativa a esta tipología no se ha hecho pública y no está disponible para usted.'; break;
                case 'non_public_fabric':   return 'La información relativa a este grupo de pastas cerámicas no se ha hecho pública y no está disponible para usted.'; break;
                case 'no_connexion':        return 'No ha iniciado sesión y no tiene acceso a esta página.'; break;
                case 'not_contributor':     return 'Usted no es el responsable, creador ni colaborador del elemento que desea modificar.'; break;
                case 'not_staff':           return 'No puede modificar la lista de categorías porque no es administrador de ' . WEBSITE_NAME . '. Si desea serlo, póngase en contacto con uno de los administradores actuales.'; break;
                case 'no_contributor_rights':return 'No puede modificar esta lista porque no es colaborador de ' . WEBSITE_NAME . '. Si desea serlo, póngase en contacto con uno de los administradores.'; break;
                case 'not_project_contributor':return 'No está asociado a este proyecto y, por lo tanto, no tiene acceso a esta página.'; break;
                case 'already_logged':      return 'Ya ha iniciado sesión. Si desea iniciar sesión con otra cuenta, cierre primero la sesión actual.'; break;
                case 'research not correct':return 'La búsqueda que ha intentado realizar no tiene la sintaxis correcta y no puede ejecutarse.'; break;
                case 'add_data_file':       return 'Se ha producido un problema al cargar su archivo. Le recomendamos limitar el tamaño del archivo a 50.000 filas o menos (< 2 MB). Si el problema persiste, póngase en contacto con el administrador del sitio.'; break;
                case 'add_data_template':   return 'Hay un problema con su plantilla:'; break;
                case 'add_objects_no_site': return 'Debe tener una columna para el código de la operación arqueológica y el nombre de usuario, o para el nombre completo de la operación arqueológica, con el formato del modelo descargable.'; break;
                case 'add_objects_no_context':return 'Debe tener una columna para el código del contexto, con el formato del modelo descargable.'; break;
                case 'add_objects_no_number':return 'Debe tener una columna para el número de inventario, con el formato del modelo descargable.'; break;
                case 'add_objects_no_category_abbr':return 'Debe tener una columna para la abreviatura de la categoría, con el formato del modelo descargable.'; break;
                case 'add_objects_no_function_name':return 'Debe tener una columna para el nombre de la función, con el formato del modelo descargable.'; break;
                case 'add_objects_no_type_name':return 'Debe tener una columna para el nombre del tipo, con el formato del modelo descargable.'; break;
                case 'add_sites_no_code':   return 'Debe tener una columna para el código de la operación arqueológica, con el formato del modelo descargable.'; break;
                case 'add_sites_no_name':   return 'Debe tener una columna para el nombre de la operación arqueológica, con el formato del modelo descargable.'; break;
                case 'add_contexts_no_context_code':return 'Debe tener una columna para el código del contexto, con el formato del modelo descargable.'; break;
                case 'add_contexts_no_context_name':return 'Debe tener una columna para el código del contexto, con el formato del modelo descargable.'; break;
                case 'no_tutorial':         return 'No hay ningún tutorial en esta dirección.'; break;
                case 'contexts_in_default_phase':return 'Todavía existen algunos contextos (con o sin horizontes-sitio); debe eliminarlos antes de poder eliminar la operación arqueológica.'; break;
                case 'not_content_project': return 'Está intentando acceder a un elemento que no forma parte del proyecto que está consultando.'; break;
                case 'not_in_project':      return 'Su proyecto no incluye esta opción.'; break;
                case 'not_global_typology': return 'Se trata de una tipología específica de un proyecto y debe consultarse dentro de ese proyecto.'; break;
                case 'not_global_fabric':   return 'Se trata de un grupo de pastas cerámicas específico de un proyecto y debe consultarse dentro de ese proyecto.'; break;
                case 'not_existing_page':   return 'Esta página no existe en esta versión de LOGACer.'; break;
                case 'not_project_language':return 'Este idioma no está disponible para este proyecto.'; break;
                default:                    return 'Error no definido';
            }
            break;
        default:
            switch ($fatal_error) {
                case 'no_site':             return 'There is no archaeological operation matching this user and code.'; break;
                case 'no_phase':            return 'There is no site-horizon corresponding to this archaeological operation.'; break;
                case 'no_context':          return 'There is no context corresponding to this site-horizon.'; break;
                case 'no_object':           return 'There is no artifact with this identifier.'; break;
                case 'no_picture':          return 'There is no illustration with this identifier.'; break;
                case 'no_project':          return 'There is no project with this identifier.'; break;
                case 'no_facies':           return 'There is no group of horizons with this identifier.'; break;
                case 'no_horizon':          return 'There is no horizon with this identifier.'; break;
                case 'no_reference':        return 'There is no bibliographic reference with this identifier.'; break;
                case 'no_news':             return 'There is no news with this identifier.'; break;
                case 'no_typology':         return 'There is no typology corresponding to this identifier.'; break;
                case 'no_type':             return 'There is no type corresponding to this code in this typology.'; break;
                case 'no_fabric':           return 'There is no fabric corresponding to this code.'; break;
                case 'no_country':          return 'There is no country corresponding to this code.'; break;
                case 'no_region':           return 'There is no region corresponding to this code.'; break;
                case 'non_public_site':     return 'The information concerning this archaeological operation has not been made public and you do not have access to it.'; break;
                case 'non_public_phase':    return 'The information concerning this site-horizon has not been made public and you do not have access to it.'; break;
                case 'non_public_context':  return 'The information concerning this context has not been made public and you do not have access to it.'; break;
                case 'non_public_object':   return 'The information concerning this artifact has not been made public and you do not have access to it.'; break;
                case 'non_public_facies':   return 'The information concerning this group of horizons has not been made public and you do not have access to it.'; break;
                case 'non_public_horizon':  return 'The information concerning this horizon has not been made public and you do not have access to it.'; break;
                case 'non_public_typology': return 'The information concerning this typology has not been made public and is not accessible to you.'; break;
                case 'non_public_fabric':   return 'The information concerning this fabric group has not been made public and is not accessible to you.'; break;
                case 'no_connexion':        return 'You are not logged in and do not have access to this page.'; break;
                case 'not_contributor':     return 'You are not the manager of, creator of, or a contributor to the item you wish to modify.'; break;
                case 'not_staff':           return 'You cannot modify the category list as you are not a ' . WEBSITE_NAME . ' admin. If you want to join the administration, contact one of the current admin.'; break;
                case 'no_contributor_rights':return 'You cannot modify this list as you are not a ' . WEBSITE_NAME . ' contributor. If you want to be a contributor, contact an admin.'; break;
                case 'not_project_contributor':return 'You are not associated with this project and therefore do not have access to this page.'; break;
                case 'already_logged':      return 'You are already logged in. If you want to log in to another account, please log out first.'; break;
                case 'research not correct':return 'The search you attempted to perform does not have the correct syntax and cannot be executed.'; break;
                case 'add_data_file':       return 'There was a problem uploading your file. We recommend limiting the file size to 50,000 rows or fewer (< 2 MB). If the problem persists, please contact the admin.'; break;
                case 'add_data_template':   return 'There is a problem with your template:'; break;
                case 'add_objects_no_site': return 'You must have a column for the archaeological operation code and the username, or for the full name of the archaeological operation, formatted as in the downloadable template.'; break;
                case 'add_objects_no_context':return 'You must have a column for the context code, formatted as in the downloadable template.'; break;
                case 'add_objects_no_number':return 'You must have a column for the inventory number, formatted as in the downloadable template.'; break;
                case 'add_objects_no_category_abbr':return 'You must have a column for the category abbreviation, formatted as in the downloadable template.'; break;
                case 'add_objects_no_function_name':return 'You must have a column for the function name, formatted as in the downloadable template.'; break;
                case 'add_objects_no_type_name':return 'You must have a column for the type name, formatted as in the downloadable template.'; break;
                case 'add_sites_no_code':   return 'You must have a column for the archaeological operation code, formatted as in the downloadable template.'; break;
                case 'add_sites_no_name':   return 'You must have a column for the archaeological operation name, formatted as in the downloadable template.'; break;
                case 'add_contexts_no_context_code':return 'You must have a column for the context code, formatted as in the downloadable template.'; break;
                case 'add_contexts_no_context_name':return 'You must have a column for the context code, formatted as in the downloadable template.'; break;
                case 'no_tutorial':         return 'There is no tutorial at this address.'; break;
                case 'contexts_in_default_phase':return 'Some contexts (with or without site-horizons) are still existing; you must delete them before you can delete the archaeological operation.'; break;
                case 'not_content_project': return 'You are trying to access an item that does not belong to the project you are currently browsing.'; break;
                case 'not_in_project':      return 'Your project does not include this option.'; break;
                case 'not_global_typology': return 'This is a project-specific typology and must be accessed within that project.'; break;
                case 'not_global_fabric':   return 'This is a project-specific fabric group and must be accessed within that project.'; break;
                case 'not_existing_page':   return 'This page does not exist in this version of LOGACer.'; break;
                case 'not_project_language':return 'This language is not supported for this project.'; break;
                default:                    return 'Undefined error';
            }
    }
}

?>