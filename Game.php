<?php


class Game
{

    private $game = [];
    private $flatArray = [];

    private $boardByType = [
        'x' => [],
        'o' => [],
    ];

    private $winningCombinations = [
        [0,1,2],
        [3,4,5],
        [6,7,8],
        [0,3,6],
        [1,4,7],
        [2,5,8],
        [0,4,8],
        [2,4,6],
    ];

    private $winner = "";

    public function __construct($game)
    {
        $this->game = $game;
    }

    public function isValid() {

        if (empty($this->game)) {
            return false;
        }

        $gameString = array_reduce($this->game, function ($a, $b) { return $a . $b;});

        $this->flatArray = str_split($gameString);

        $validCharactersCount = count(array_filter(str_split($gameString), function ($char) { return $char == 'o' || $char == 'x';}));

        if ($validCharactersCount != 9) {
            return false;
        }

        return true;
    }

    public function winner() {


        foreach ($this->flatArray as $key => $item) {
            $this->boardByType[$item][] = $key;
        }

        $winningO = 0;
        $winningX = 0;

        foreach ($this->winningCombinations as $winningCombination) {
            $commonPositions = array_intersect($this->boardByType['o'],$winningCombination);
            if (count($commonPositions) == 3) {
                $winningO++;
            }

            $commonPositions = array_intersect($this->boardByType['x'],$winningCombination);
            if (count($commonPositions) == 3) {
                $winningX++;
            }
        }


        if ($winningO == 1) {
            $this->winner =  "o";
        }

        if ($winningX == 1) {
            $this->winner = "x";
        }

        // if ( $winningO == 0 && $winningX == 0), but shorter :)
        if ( $winningX + $winningO == 0) {
            $this->winner = 'd';
        }

        if ( $winningO > 1 || $winningX > 1) {
            $this->winner = false;
            return false;
        }

        return $this->winner;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function __toString()
    {
        return implode('',$this->flatArray);
    }



}