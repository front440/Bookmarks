<?php
include("Model/Marcador.php");

// Creamos una instancia del objeto palabra
$mark = Marcador::getInstancia();

//PROBAMOS EL CREATE O SET
 $mark->setDescripcion("enlace pagina deportes");
 $mark->setEnlace("http://www.marca.es/");
 $mark->setIdUsuario(1);
 $mark->set();

 $mark->setDescripcion("enlace pagina deportes");
 $mark->setEnlace("http://www.as.es");
 $mark->setIdUsuario(1);
 $mark->set();
