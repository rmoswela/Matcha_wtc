<?php

//$username = stripslashes(htmlspecialchars($_GET['username']));

require_once "connection.php";

$conn->query("
    USE chat;
");
$sql = $conn->query("
    SELECT messages_tbl.messages, users_tbl.username FROM messages_tbl INNER JOIN users_tbl ON messages_tbl.user_id = users_tbl.id;
");

$results = $sql->fetchAll();

foreach ($results as $r) {
	echo $r["username"];
	echo "\\";
	echo $r["messages"];
	echo "\n";
}
/*
require "connection.php";

$conn->query("
    USE chat;
");
$sql = $conn->query("
    SELECT * FROM messages_tbl;
");

$results = $sql->fetchAll();
print_r($results);
*/