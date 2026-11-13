            <h2>Política de privacidad - <?php echo PROJECT->code(); ?></h2>
            <h5>Datos personales recopilados</h5>
            <p>Para los usuarios registrados: apellidos, nombre, dirección de correo electrónico, identificador, contraseña (cifrada), idioma de navegación preferido.</p>
            <p>Para los demás usuarios: idioma de navegación preferido.</p>
            <h5>Finalidad de la recopilación de datos</h5>
            <p>Los datos se utilizan exclusivamente para la creación y gestión de las cuentas de usuario, con el fin de acceder a las funcionalidades de <?php echo PROJECT->code(); ?>, así como para gestionar el idioma de visualización del sitio web.</p>
            <h5>Base jurídica</h5>
            <p>El tratamiento de los datos se basa en el consentimiento del usuario (registro voluntario).</p>
            <h5>Plazo de conservación de los datos personales</h5>
            <p>Los datos se conservan hasta que el usuario elimina su cuenta (posible previa solicitud: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulario de contacto</a>), y durante un año en el caso del idioma preferido.</p>
            <h5>Derechos de los usuarios</h5>
            <p>Acceso, rectificación, supresión, oposición, portabilidad. Para ejercer estos derechos: <a href="<?php echo create_url_proj(["about_us"]) . "#contact"; ?>">formulario de contacto</a>.</p>
            <h5>Seguridad de los datos personales</h5>
            <p>Los datos de los usuarios están protegidos mediante medidas técnicas (cifrado de las contraseñas, acceso seguro a la base de datos). Sin embargo, el nombre y los apellidos (o, en su defecto, el nombre de usuario) son accesibles para los demás usuarios registrados. En caso de publicación de datos científicos, los usuarios no registrados también tendrán acceso a esta información. El administrador o los administradores de la base de datos también tienen acceso a la dirección de correo electrónico utilizada para el registro.</p>
            <h5>Compartición de los datos personales</h5>
            <p>Los datos no se venden ni se venderán nunca. No se comparten con terceros, salvo obligación legal.</p>
            <h5>Responsable del tratamiento</h5>
            <p><?php echo User::find_by_id(PROJECT->owner('prop'))->codename(); ?>.</p>
            <h5>Visibilidad, uso y tratamiento de los datos no personales</h5>
            <p>Todos los datos incorporados por un usuario registrado en <?php echo PROJECT->code(); ?> son públicos, a excepción de los datos de proyectos (accesibles únicamente a sus colaboradores), salvo que sea posible configurar su confidencialidad de otra manera.
                Se considera que los creadores de los datos son sus autores principales. En algunos casos, pueden indicarse colaboradores (internos de <?php echo PROJECT->code(); ?>). Corresponde a estos garantizar la autenticidad de dichos datos, así como el cumplimiento de las directrices relativas a los derechos de autor y a la citación de datos científicos.
                El administrador se reserva el derecho de eliminar la cuenta y los datos de cualquier persona que incumpla este principio.</p>