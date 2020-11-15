<?php

require("db.php");
session_start();

function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

if ($_POST['name'] == '' || $_POST['price'] == '') {
  $redirect_page = "insert_error.php";
} else {
  $stmt = $dbh->prepare("insert into shoplog (name, notes, store, event_date, qty, unit, price) values (:na, :no, :st, :ev, :qt, :un, :pr)");
  $stmt->execute([":na" => stripAccents($_POST['name']),
                  ":no" => stripAccents($_POST['notes']),
                  ":st" => stripAccents($_POST['store']),
                  ":ev" => $_POST['event_date'],
                  ":qt" => str_replace(",", ".", $_POST['qty']),
                  ":un" => $_POST['unit'],
                  ":pr" => str_replace(",", ".", $_POST['price'])
  ]);
  $redirect_page = "index.php";
}

header('Location: ' . $redirect_page);
