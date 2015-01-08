<?php

/*
	Genetic Algorithm without evolution goal?
*/

require __DIR__ . '/../SimpleGeneticAlgorithm.php';

class CustomGeneticAlgorithm extends \SimpleGeneticAlgorithm\SimpleGeneticAlgorithm{
	
	// make it blank
	public function fitness_function(){ }
	
	// just random selection
	public function selection(){
		foreach($this->population as $k => $v){
			if(rand(0, 1) == 0){
				unset($this->population[$k]);
			}
		}
	}
	
	// just leave crossover to parents
	
	// make randrom mutation on 1 chromosome
	public function mutation(){
		$chars = str_split($this->options['seed']);
		foreach($this->population as $k => $v){
			$tmp = str_split($v['chromosome']);
			$key = array_rand($tmp);
			
			$tmp[$key] = $chars[rand(0, count($chars) - 1)];
			$this->population[$k]['chromosome'] = implode($tmp);
		}
	}
}

$ga = new CustomGeneticAlgorithm(array(
	'seed' => 'abcdefghijklmnopqrstuvwxyz',
	'goal' => 'aa',
	
	'delay' => 10, // ms, if debug is false, then delay forced to 0
	'debug' => true,
));

$ga->run(); // hmm hardly find a goal
