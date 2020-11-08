<?php

require("db.php");
include("header.php");

session_start();

function stripAll($str) {
    $str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    $str = preg_replace("/[^[:alnum:][:space:]-]/u", '', $str);
    return $str;
}

$sql = "select * from shoplog ";

$cond = [];

if ($_GET['name'] !== "") {
    $strippedName = stripAll($_GET['name']);
    $cond[] = "name like '${strippedName}%'";
}

if ($_GET['start_date'] !== "") {
    $strippedStartDate = stripAll($_GET['start_date']);
    $cond[] = "event_date >= '${strippedStartDate}'";
} else {
    $cond[] = "event_date >= now() - interval 45 day ";
}

if ($_GET['end_date'] !== "") {
    $strippedEndDate = stripAll($_GET['end_date']);
    $cond[] = "event_date <= '${strippedEndDate}'";
}

if (count($cond) > 0) {
    $sql .= "where " . implode(" and ", $cond) . " ";
}


if ($_GET['sort'] == "n") {
    $sql .= "order by name, store";
} elseif ($_GET['sort'] == "p") {
    $sql .= "order by price / qty desc";
} elseif ($_GET['sort'] == "pr") {
    $sql .= "order by price desc";
} elseif ($_GET['sort'] == "d") {
    $sql .= "order by event_date desc, name";
}

$stmt = $dbh->query($sql);

$grandTotal = 0;

?>

<br><br>
<table>
    <tr>
        <td>
            Data
        </td>
        <td>
            Produto
        </td>
        <td style="text-align: right;">
            Pr
        </td>
        <td style="text-align: right;">
            Pr/un
        </td>
        <td style="text-align: right;">
            Qtde
        </td>
        <td>
            Unidade
        </td>
        <td>
            Anot.
        </td>
        <td>
            Loja
        </td>
    </tr>        

    <?php
    $rawRows = [];
    
    foreach ($stmt as $purchase) {
        $rawRows[] = $purchase;
    }

    foreach ($rawRows as $purchase) {
        $grandTotal += $purchase['price'];
    }
    ?>
    
    <p>
        <strong>Grand total:</strong> <?= number_format($grandTotal, 2) ?>
    </p>

    <?php
    foreach ($rawRows as $purchase) {
        $dt = $purchase['event_date'];
    ?>
        <tr>
            <td>
                <a href="purchase.php?id=<?= $purchase['purchase_id'] ?>">
                    <?= substr($dt, 8, 2) . '/' . substr($dt, 5, 2) ?>
                </a>
            </td>
            <td>
                <?= $purchase['name'] ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($purchase['price'], 2) ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($purchase['price'] / $purchase['qty'], 2) ?>
            </td>            
            <td style="text-align: right;">
                <?= $purchase['qty'] ?>
            </td>
            <td>
                <?= $purchase['unit'] ?>
            </td>
            <td>
                <?= $purchase['notes'] ?>
            </td>
            <td>
                <?= $purchase['store'] ?>
            </td>
        </tr>        
    <?php
    }
    ?>
</table>




