<?php

/*
	this example show how we can override one or more method to make more suitable genetic algorithm
*/

require __DIR__ . '/../SimpleGeneticAlgorithm.php';

class CustomGeneticAlgorithm extends \SimpleGeneticAlgorithm\SimpleGeneticAlgorithm{
	
	public function crossover(){
		$new_population = array();
		for($i = 0; $i < $this->options['population']; $i++){
			// get random parents
			$a = $this->population[array_rand($this->population, 1)]['chromosome'];
			$b = $this->population[array_rand($this->population, 1)]['chromosome'];
			
			
			// make separator from a & b
			$sp = rand(0, strlen($a) - 1);
			
			// get some part from a, and some part from b
			$child = substr($a, 0, $sp) . substr($b, $sp, strlen($b));
			
			$new_population[] = array(
				'chromosome' => $child,
				'fitness' => 0,
			);
		}
		
		$this->population = $new_population;
	}
	
}

$ga = new CustomGeneticAlgorithm(array(
	'mutation' => 25, // 25%
	'goal' => 'Astari Ghaniarti',
	
	'delay' => 50, // ms, if debug is false, then delay forced to 0
	'debug' => true,
));

$ga->run();
