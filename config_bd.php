<?php

use Illuminate\Database\Capsule\Manager as Capsule;

//Creamos un objeto de tipo Capsule
$capsule = new Capsule;

//Datos de configuración de la BD
$capsule->addConnection([
	'driver' 		=> 'mysql',
	'host' 			=> 'localhost',
	'database' 		=> 'bd_ptp',
	'username' 		=> 'uLaravel',
	'password' 		=> '123',
	'charset' 		=> 'utf8',
	'collation' 	=> 'utf8_unicode_ci',
	'prefix' 		=> '',
]);

//Iniciar Eloquent
$capsule->bootEloquent();