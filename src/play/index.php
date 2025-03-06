<?php
require_once '../game.php';
header("Content-Type: application/json");

if (!isset($_GET['pid']) || !isset($_GET['move'])) {
    echo json_encode(["response" => false, "reason" => "Missing parameters"]);
    exit();
}

$pid = $_GET['pid'];
$move = intval($_GET['move']);

session_start();
if (!isset($_SESSION[$pid])) {
    echo json_encode(["response" => false, "reason" => "Invalid game ID"]);
    exit();
}

$game = $_SESSION[$pid];
$result = $game->makeMove($move, 1);
if ($result["status"] !== "continue") {
    echo json_encode(["response" => true, "ack_move" => ["slot" => $move, "isWin" => ($result["status"] === "win"), "isDraw" => ($result["status"] === "draw")]]);
    exit();
}

$computerMove = $game->getComputerMove(2);
if ($computerMove !== false) {
    $compResult = $game->makeMove($computerMove, 2);
    echo json_encode(["response" => true, "ack_move" => ["slot" => $move], "move" => ["slot" => $computerMove, "isWin" => ($compResult["status"] === "win"), "isDraw" => ($compResult["status"] === "draw")]]);
} else {
    echo json_encode(["response" => false, "reason" => "No valid moves left"]);
}
?>
