<?php

/*
	this example show how we can tweak crossover to choose only the best chromosome
*/

require __DIR__ . '/../vendor/autoload.php'; // composer autoload

class CustomGeneticAlgorithm extends \SimpleGeneticAlgorithm\SimpleGeneticAlgorithm{
	
	public function crossover(){
		$new_population = array();
		for($i = 0; $i < $this->options['population']; $i++){
			// get random parents
			$a = $this->population[array_rand($this->population, 1)]['chromosome'];
			$b = $this->population[array_rand($this->population, 1)]['chromosome'];
			$goal = $this->options['goal'];
			
			$a = str_split($a);
			$b = str_split($b);
			$goal = str_split($goal);
			
			// get the best chromosome otherwise random from parents
			$child = '';
			for($j = 0; $j < count($a); $j++){
				if($a[$j] == $goal[$j])
					$child .= $a[$j];
				elseif($b[$j] == $goal[$j])
					$child .= $b[$j];
				else
					$child .= rand(0, 1) == 0 ? $a[$j] : $b[$j];
			}
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
	'goal' => 'lorem ipsum',
	
	'delay' => 50, // ms, if debug is false, then delay forced to 0
	'debug' => true,
));

$ga->run();
