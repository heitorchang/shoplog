<?php

require("db.php");
include("header.php");

session_start();

if (isset($_GET['sort'])) {
    if ($_GET['sort'] == "n") {
        $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by name, store");
    } elseif ($_GET['sort'] == "l") {
        $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by store, name");
    } elseif ($_GET['sort'] == "pr") {
        $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by price desc");
    } elseif ($_GET['sort'] == "p") {
        $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by price / qty desc");
    } else {
        $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by event_date desc, name");
    }
} else {
    $stmt = $dbh->query("select * from shoplog where event_date >= '2020-01-01' order by event_date desc, name");
}
?>
<p>
    Purchases since 2020-01-01
</p>
<table>
    <tr>
        <td>
            <a href="select.php">Data</a>
        </td>
        <td>
            <a href="select.php?sort=n">Produto</a>
        </td>
        <td style="text-align: right;">
            <a href="select.php?sort=pr">Pr</a>
        </td>
        <td style="text-align: right;">
            <a href="select.php?sort=p">Pr/un</a>
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
            <a href="select.php?sort=l">Loja</a>
        </td>
    </tr>        

    <?php
    foreach ($stmt as $purchase) {
        $dt = $purchase['event_date'];
    ?>
        <tr class="tlist">
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
    

