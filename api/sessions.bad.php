<?php
include('db.php');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$sessions = $pdo->query('SELECT * FROM sessions');

$json = [];

while ($row = $sessions->fetch())
{
    array_push($json, $row);
}

$json = json_encode($json);

echo $json;

?>