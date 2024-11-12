<?php
// Iniciar sesión
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a index con el mensaje
header("Location: index.php?mensaje=debe_iniciar_sesion");
exit();
?>
