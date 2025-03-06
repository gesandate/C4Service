<?php
require_once 'board.php';
require_once 'strategies.php';

class Game {
    private $board;
    private $strategy;

    public function __construct($strategyType) {
        $this->board = new Board();
        $this->strategy = ($strategyType === "Smart") ? new SmartStrategy() : new RandomStrategy();
    }

    public function makeMove($col, $player) {
        $row = $this->board->dropPiece($col, $player);
        if ($row === false) return ["status" => "invalid"];

        if ($this->board->checkWin($player)) {
            return ["status" => "win"];
        }
        if ($this->board->isFull()) {
            return ["status" => "draw"];
        }
        return ["status" => "continue"];
    }

    public function getComputerMove($player) {
        return $this->strategy->getNextMove($this->board, $player);
    }
}
?>
