<?php

require("db.php");
session_start();


function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

$stmt = $dbh->prepare("update shoplog set name = :na, notes = :no, store = :st, event_date = :ev, qty = :qt, unit = :un, price = :pr where purchase_id = :id");
$stmt->execute([
    ":id" => $_POST['purchase_id'],
    ":na" => stripAccents($_POST['name']),
    ":no" => stripAccents($_POST['notes']),
    ":st" => stripAccents($_POST['store']),
    ":ev" => $_POST['event_date'],
    ":qt" => str_replace(",", ".", $_POST['qty']),
    ":un" => $_POST['unit'],
    ":pr" => str_replace(",", ".", $_POST['price'])
]);

header('Location: select.php');
