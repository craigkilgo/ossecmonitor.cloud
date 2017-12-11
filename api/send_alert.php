<?php
include('db.php');
//Authorization ---------------------------
// include our OAuth2 Server object
require_once '../oauth/server.php';


// Handle a request to a resource and authenticate the access token
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    $server->getResponse()->send();
    die;
}
//-----------------------------------------
/**/

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);


//$id = $_POST['id'];

$rule_id = $_POST['rule_id'];
$src_ip = $_POST['src_ip'];
$dest_ip = $_POST['dest_ip'];
$src_port = $_POST['src_port'];
$dest_port = $_POST['dest_port'];
$full_log = $_POST['full_log'];
$timestamp = time();

$stmt = $pdo->prepare('INSERT into alert (server_id, rule_id, timestamp, src_ip,dst_ip,src_port,dst_port,full_log) VALUES (2,?,?,?,?,?,?,?)');
$stmt->execute([$rule_id,$timestamp,$src_ip,$dest_ip,$src_port,$dest_port,$full_log]);
$run = $stmt->fetch();

echo "Success";

//var_dump($_POST);

?>