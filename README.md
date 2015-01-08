# SimpleGeneticAlgorithm
simple genetic algorithm in php,
this package i create just for example how we can implement Genetic Algorithm in PHP
if you inteserted just email me at mr.ryansilalahi@gmail.com :-)

see interface/GeneticAlgorithm.php

# Example
in example dir you can see:
-------
* example1.php
* example2.php
* example3.php

#### example 1
<pre><code>
require '/vendor/autoload.php'; // composer autoload

$ga = new \SimpleGeneticAlgorithm\SimpleGeneticAlgorithm(array(
	'mutation' => 25, // 25%
	'goal' => 'Astari Ghaniarti',
	
	'delay' => 50, // ms, if debug is false, then delay forced to 0
	'debug' => true,
));

$ga->run(); // just run because debug is true
</code></pre>

# License
MIT License
			
