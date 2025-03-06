<?php
require_once 'board.php';

abstract class Strategy {
    abstract public function getNextMove(Board $board, $player);
}

class RandomStrategy extends Strategy {
    public function getNextMove(Board $board, $player) {
        $validMoves = [];
        for ($col = 0; $col < 7; $col++) {
            if ($board->dropPiece($col, $player) !== false) {
                $validMoves[] = $col;
            }
        }
        return empty($validMoves) ? false : $validMoves[array_rand($validMoves)];
    }
}

class SmartStrategy extends Strategy {
    public function getNextMove(Board $board, $player) {
        for ($col = 0; $col < 7; $col++) {
            $tempBoard = clone $board;
            if ($tempBoard->dropPiece($col, $player) !== false && $tempBoard->checkWin($player)) {
                return $col;
            }
        }
        $randomStrategy = new RandomStrategy();
        return $randomStrategy->getNextMove($board, $player);
    }
}
?>
