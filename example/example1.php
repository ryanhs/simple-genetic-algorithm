<?php

/*
	this example show how we use SimpleGeneticAlgorithm
*/

require __DIR__ . '/../vendor/autoload.php'; // composer autoload

$ga = new \SimpleGeneticAlgorithm\SimpleGeneticAlgorithm(array(
	
	//'population' => 20,
	//'selection' => 90, // 90%
	'mutation' => 25, // 25%
	
	//'seed' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 1234567890\'.,',
	'goal' => 'Astari Ghaniarti',
	
	//'max_iteration' => 50000,
	'delay' => 50, // ms, if debug is false, then delay forced to 0
	'debug' => true,
	//'fitness_in_percent' => false, // usefull if chromosome more than 10 chars
));


//var_dump($ga->run());
$ga->run(); // just run because debug is true
