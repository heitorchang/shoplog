<?php

require("db.php");
session_start();

$stmt = $dbh->prepare("insert into shoplog (name, notes, store, event_date, qty, unit, price) values (:na, :no, :st, :ev, :qt, :un, :pr)");
$stmt->execute([":na" => $_POST['name'],
                ":no" => $_POST['notes'],
                ":st" => $_POST['store'],
                ":ev" => $_POST['event_date'],
                ":qt" => $_POST['qty'],
                ":un" => $_POST['unit'],
                ":pr" => str_replace(",", ".", $_POST['price'])
]);

header('Location: insert.php');
