<?php

require("db.php");
include("header.php");

session_start();

$stmt = $dbh->prepare("delete from shoplog where purchase_id = :id");
$stmt->execute([":id" => $_GET["id"]]);

header('Location: select.php');
