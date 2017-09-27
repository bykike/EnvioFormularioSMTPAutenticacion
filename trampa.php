<?php

// * Auto bloqueo de bots viciosos*
// * Funciona con PHP 4.0+ & 5.x+ *

$ip_visita = $_SERVER['REMOTE_ADDR'];		// Captura el IP del visitante.
$bloquea = "deny from $ip_visita\n";			// Lo que se escribira en el archivo .htaccess si es que el IP debe ser bloqueado.
$archivo_ht = ".htaccess";					// Si es que Apache en tu servidor cambio el nombre de .htaccess a algun otro nombre por seguridad, coloca ese nombre aqui.
$preparar = file_get_contents($archivo_ht);		// Prepara el archivo .htaccess juntando todos los datos en el archivo.
$verificar = strpos($preparar, $ip_visita);		//  Verifica que en el archivo .htaccess que el IP del visitante actual no este listado.

// La siguiente parte del script verifica si el IP ya fue bloqueado o no.
// Si el IP aun no esta listado en el archivo .htaccess, sera agregado, mostrara el mensaje de bloqueo al usuario, y alertara por email al webmaster.
// Si el IP ya esta en el archivo .htaccess, el script deja de ejecutarse y muestra un mensaje.

if ($verificar === FALSE) {

$open = @fopen($archivo_ht, "a");			// Abre el archivo .htaccess e inicia modo escribir.
$write = @fputs($open, $bloquea);			// Escribe el IP a bloquear en el archivo .htaccess (Ejemplo: deny from 123.123.123.123)

// Envia un email alertando bloqueo al webmaster o administrador.
// Asegurate de cambiar/agregar tu correo.
@mail('mi_correo@yahoo.com','IP bloqueado en paginaweb.com '.$_SERVER['REMOTE_ADDR'].'','
Banned IP: '.$_SERVER['REMOTE_ADDR'].'
Request URI: '.$_SERVER['REQUEST_URI'].'
User Agent: '.$_SERVER['HTTP_USER_AGENT']);

// El IP no esta bloqueado. Hay que modificar el archivo .htaccess.
// Muestra el mensaje de error al visitante. (Cambia el texto a tu gusto)
	echo '<html><head><title>IP '.$ip_visita.' - Bloqueado!</title>
</head><body bgcolor="#FF000000" text="#FFFFFF" oncontextmenu="return false;"><center><font face="Verdana, Arial"><h1>GRACIAS - NO VUELVAS A REGRESAR!</h1><b>El IP '.$ip_visita.' ha sido bloqueado!<br />Contacta al administrador de este web si el bloqueo es un error.<p />Saludos!</b></font></center></body></html>';

// Cierra el archivo .htaccess. Eso es todo.
// Close the .htaccess file - all done.
@fclose($open);
} else {

// IP ya esta bloqueado. No hay que modificar el archivo .htaccess
// Muestra el mensaje de error al visitante. (Cambia el texto a tu gusto)
	echo '<html><head><title>IP '.$ip_visita.' - Bloqueado!</title>
</head><body bgcolor="#FF000000" text="#FFFFFF" oncontextmenu="return false;"><center><font face="Verdana, Arial"><h1>GRACIAS - NO VUELVAS A REGRESAR!</h1><b>El IP '.$ip_visita.' ha sido bloqueado!<br />Contacta al administrador de este web si el bloqueo es un error.<p />Saludos!</b></font></center></body></html>';
}

// Aqui acaba el archivo/Script;
exit;
?>