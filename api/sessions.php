<?php
include('db.php');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

//Authorization ---------------------------
// include our OAuth2 Server object
require_once '../oauth/server.php';

// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}
//-----------------------------------------


$sessions = $pdo->query('SELECT * FROM sessions');

$json = [];

while ($row = $sessions->fetch())
{
    array_push($json, $row);
}

$json = json_encode($json);

echo $json;

?>