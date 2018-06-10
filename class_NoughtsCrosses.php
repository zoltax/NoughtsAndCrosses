<?php


class NoughtsCrosses
{

    private $games = [];

    private $db;

    private $game = null;

    private $results = [];

    public function __construct()
    {

        $this->db = new Db();

        $this->results['o'] = 0;
        $this->results['x'] = 0;
        $this->results['d'] = 0;
    }

    public function get_aggregate_results()
    {
        $results = $this->db->loadResults();

        foreach ($results as $type => $num ) {
            if ( $type == 'o') {
                echo sprintf("O wins: %d \n", $num);
            }
            if ( $type == 'x') {
                echo sprintf("X wins: %d \n", $num);
            }
            if ( $type == 'd') {
                echo sprintf("Draws: %d \n", $num);
            }
        }

    }

    public function calculate_winners($stream = STDIN)
    {

        $game = [];

        while ( $line = fgets($stream) ) {
            $line = trim($line);
            if ( strlen($line) == 3) {
                $game[] = $line;

                if (count($game) == 3) {
                    $playedGame = new Game($game);
                    if ($playedGame->isValid()) {
                        $this->games[] = $playedGame;
                    } else {
                    }
                    $game = [];
                }
            }
        }


    }

    public function get_results()
    {

        foreach ($this->games as $game) {
            $winner = $game->winner();
            if ($winner) {
                $this->results[$winner]++;
            }

        }

        $this->db->storeResults($this->games);


        echo sprintf("X Wins: %d\nO Wins: %d\nDraws: %d\n",$this->results['x'], $this->results['o'], $this->results['d']);
    }

}