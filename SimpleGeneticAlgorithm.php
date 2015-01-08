<?php

namespace SimpleGeneticAlgorithm;

require __DIR__ . '/interface/GeneticAlgorithm.php';

class SimpleGeneticAlgorithm implements GeneticAlgorithm{
	
	protected $options = array();
	protected $options_default = array(
		'population' => 20,
		'selection' => 90, // percent
		'mutation' => 1, // percent
		
		'seed' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 1234567890\'.,',
		'goal' => 'lorem ipsum',
		
		'max_iteration' => 50000,
		'delay' => 500, // ms, if debug is false, then delay forced to 0
		'debug' => true,
		'fitness_in_percent' => false, // usefull if chromosome more than 10 chars
	);
	
	protected $population = array();
	protected $best = '';
	
	public function init_population(){
		$chars = str_split($this->options['seed']);
		for($i = 0; $i < $this->options['population']; $i++){
			
			// make random seed
			$tmp = $chars[rand(0, count($chars) - 1)]
				 . $chars[rand(0, count($chars) - 1)]
				 . $chars[rand(0, count($chars) - 1)]
				 . $chars[rand(0, count($chars) - 1)]
				 . $chars[rand(0, count($chars) - 1)];
				 
			$this->population[$i] = array(
				'chromosome' => substr(str_repeat($tmp, 10), 0, strlen($this->options['goal'])),
				'fitness' => 0,
			);
		}
	}
	
	public function fitness_function(){
		for($i = 0; $i < $this->options['population']; $i++){
			$chromosome = $this->population[$i]['chromosome'];
			$chromosome = str_split($chromosome);
			
			$goal = str_split($this->options['goal']);
			
			$this->population[$i]['fitness'] = 0;
			for($j = 0; $j < count($chromosome) - 1; $j++){
				if($chromosome[$j] == $goal[$j])
					$this->population[$i]['fitness']++;
			}
			
			// make fitness in percent
			if($this->options['fitness_in_percent'])
				$this->population[$i]['fitness'] = $this->population[$i]['fitness'] / count($goal) * 100;
		}
	}
	
	public function selection(){
		// calculate max selection
		$max_selection = floor($this->options['selection'] / 100 * $this->options['population']);
		
		// get array of fitness
		$tmp_arr = array();
		foreach($this->population as $k => $v){
			$tmp_arr[$k] = $v['fitness'];
		}
		
		// sort & slice
		arsort($tmp_arr);
		$tmp_arr = array_slice($tmp_arr, 0, $max_selection, true);
		$tmp_arr = array_keys($tmp_arr);
		
		// natural selection
		foreach($this->population as $k => $v){
			if(!in_array($k, $tmp_arr)){
				unset($this->population[$k]);
			}
		}
	}
	
	// generate new population based on breeding (crossover)
	public function crossover(){
		$new_population = array();
		for($i = 0; $i < $this->options['population']; $i++){
			// get random parents
			$a = $this->population[array_rand($this->population, 1)]['chromosome'];
			$b = $this->population[array_rand($this->population, 1)]['chromosome'];
			
			$a = str_split($a);
			$b = str_split($b);
			
			// get random chromosome from parents
			$child = '';
			for($j = 0; $j < count($a); $j++){
				$child .= rand(0, 1) == 0 ? $a[$j] : $b[$j];
			}
			
			$new_population[] = array(
				'chromosome' => $child,
				'fitness' => 0,
			);
		}
		
		$this->population = $new_population;
	}
	
	// mutation to make every variant better
	public function mutation(){
		foreach($this->population as $k => $v){
			// get mutation chance
			$is_mutating = (rand(0, 1000) / 1000 * 100) <= $this->options['mutation'];
			if(!$is_mutating) continue;
			
			$tmp = str_split($v['chromosome']);
			$key = array_rand($tmp);
			
			$tmp[$key] = str_split($this->options['goal'])[$key];
			$this->population[$k]['chromosome'] = implode($tmp);
		}
	}
	
	public function get_best(){
		$this->fitness_function();
		$best_i = 0;
		$tmp = 0;
		foreach($this->population as $k => $v){
			if($v['fitness'] > $tmp){
				$tmp = $v['fitness'];
				$best_i = $k;
			}
		}
		
		return $this->best = $this->population[$best_i]['chromosome'];
	}
	
	public function run(){
		if($this->options['debug'])
			echo 'Goal: ' . $this->options['goal']. PHP_EOL . PHP_EOL;
		
		$this->clear_cache();
		$this->init_population();
		$best = '';
		
		$i = 0;
		while($i < $this->options['max_iteration'] && $this->best != $this->options['goal']){
			$i++;
			$best = $this->get_best();
			
			if($this->options['debug'])
				echo 'Generation #' . $i . ' - ' . $best . PHP_EOL;
			
			if($best == $this->options['goal']){
				$this->solution = $best;
				break;
			}
			
			$this->fitness_function();
			$this->selection();
			$this->crossover();
			$this->mutation();
			
			if($this->options['debug'])
				usleep($this->options['delay'] * 1000);
		}
		if($this->options['debug'])
			echo PHP_EOL . PHP_EOL . 'Solution "' . $this->best. '" on Generation ' . $i . PHP_EOL;
			
		return array(
			'Generation' => $i,
			'best' => $this->best,
		);
	}
	
	// $key is string or array of function
	// example: array('delay' => 100, 'debug' => true)
	public function set_option($key, $value = null){
		if(is_array($key)){
			$this->options = array_merge($this->options, $key);
			return true;
		}
		
		$this->options[$key] = $value;
	}
	
	public function get_option($key){
		return !empty($this->options[$key]) ? $this->options[$key] : null;
	}
	
	public function clear_cache(){
		$this->population = array();
		$this->best = '';
	}
	
	public function __construct($options = array()){
		$this->clear_cache();
		$this->options = array_merge($this->options_default, $options);
	}
		
}
