<?php


class Db
{

    private $pdo;

    public function __construct()
    {
        $host = '127.0.0.1';
        $port = '33306';
        $db   = 'nac';
        $user = 'nac';
        $pass = 'nac';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public function storeResults($games)
    {

        foreach ($games as $game) {

            $winner = $game->getWinner();

            if ($winner) {
                $gameString = (string)$game;
                $sql = "INSERT INTO nac(game,winner) VALUES (:gameString, :winner)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':gameString' => $gameString, ':winner' => $winner]);
            }

        }

    }

    public function loadResults() {

        $sql = "SELECT winner,count(winner) as num FROM nac GROUP BY winner";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $res = [];

        foreach ($data as $winner) {
            $res[$winner['winner']] = $winner['num'];
        }

        return $res;
    }

}