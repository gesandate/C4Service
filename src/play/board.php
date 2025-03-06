<?php
class Board {
    private $rows = 6;
    private $cols = 7;
    private $board;

    public function __construct() {
        $this->board = array_fill(0, $this->rows, array_fill(0, $this->cols, 0));
    }

    public function dropPiece($col, $player) {
        if ($col < 0 || $col >= $this->cols) return false;
        for ($row = $this->rows - 1; $row >= 0; $row--) {
            if ($this->board[$row][$col] == 0) {
                $this->board[$row][$col] = $player;
                return $row;
            }
        }
        return false; // Column is full
    }

    public function checkWin($player) {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->cols; $col++) {
                if ($this->checkDirection($row, $col, 0, 1, $player) || // Horizontal
                    $this->checkDirection($row, $col, 1, 0, $player)) { // Vertical
                    return true;
                }
            }
        }
        return false;
    }

    private function checkDirection($row, $col, $dr, $dc, $player) {
        $count = 0;
        for ($i = 0; $i < 4; $i++) {
            $r = ($row + $i * $dr) % $this->rows;
            $c = ($col + $i * $dc) % $this->cols;
            if ($this->board[$r][$c] == $player) {
                $count++;
                if ($count == 4) return true;
            } else {
                break;
            }
        }
        return false;
    }

    public function isFull() {
        foreach ($this->board[0] as $cell) {
            if ($cell === 0) return false;
        }
        return true;
    }

    public function getBoard() {
        return $this->board;
    }
}
?>