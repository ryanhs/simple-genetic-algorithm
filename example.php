#!/usr/bin/php
<?php

require 'SimpleGeneticAlgorithm.php';

$ga = new SimpleGeneticAlgorithm\SimpleGeneticAlgorithm(array(
	
	//'population' => 20,
	//'selection' => 90, // percent
	'mutation' => 25, // 10%
	
	//'seed' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 1234567890\'.,',
	'goal' => 'astari ghaniarti',
	
	//'max_iteration' => 50000,
	'delay' => 50, // ms, if debug is false, then delay forced to 0
	'debug' => true,
	//'fitness_in_percent' => false, // usefull if chromosome more than 10 chars
));


//var_dump($ga->run());
$ga->run(); // just run because debug is true
