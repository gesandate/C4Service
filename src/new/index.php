<?php
require_once '../game.php';
header("Content-Type: application/json");

if (!isset($_GET['strategy'])) {
    echo json_encode(["response" => false, "reason" => "Strategy not specified"]);
    exit();
}

$strategy = $_GET['strategy'];
if (!in_array($strategy, ["Smart", "Random"])) {
    echo json_encode(["response" => false, "reason" => "Unknown strategy"]);
    exit();
}

$pid = uniqid();
session_start();
$_SESSION[$pid] = new Game($strategy);

echo json_encode(["response" => true, "pid" => $pid]);
?>
