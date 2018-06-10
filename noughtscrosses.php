<?php

require_once 'Game.php';
require_once 'Db.php';
require_once 'class_NoughtsCrosses.php';

$class = new NoughtsCrosses;

$param = $argv[1] ?? '';

if ($param == 'results') {
    echo $class->get_aggregate_results();
} else if ($param == 'calculate') {
    $class->calculate_winners(STDIN);
    echo $class->get_results();
} else {
    echo "Usage: noughtscrosses.php [ACTION]
    Actions:
        Results - Output all-time results from all games ever.
        Calculate - Calculate results from round of games provided via STDIN";
}