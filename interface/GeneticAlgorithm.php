<?php

namespace SimpleGeneticAlgorithm;

interface GeneticAlgorithm{

	// main genetic algorithm method
	public function init_population();
	public function fitness_function();
	public function selection();
	public function crossover();
	public function mutation();
	
	// addtional method
	public function get_best();
	public function run();
}

