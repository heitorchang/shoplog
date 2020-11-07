<?php

require("db.php");
include("header.php");

session_start();

$stmt = $dbh->query("select * from shoplog order by purchase_id desc");
       ?>

<table>
    <tr>
        <td>
            Data
        </td>
        <td>
            Produto
        </td>
        <td>
            Anot.
        </td>
        <td>
            Loja
        </td>
        <td style="text-align: right;">
            Qtde
        </td>
        <td>
            Unidade
        </td>
        <td style="text-align: right;">
            Preco
        </td>
        <td style="text-align: right;">
            Preco por unid
        </td>
    </tr>        

    <?php
    foreach ($stmt as $purchase) {
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
            <td>
                <?= $purchase['notes'] ?>
            </td>
            <td>
                <?= $purchase['store'] ?>
            </td>
            <td style="text-align: right;">
                <?= $purchase['qty'] ?>
            </td>
            <td>
                <?= $purchase['unit'] ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($purchase['price'], 2) ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($purchase['price'] / $purchase['qty'], 2) ?>
            </td>            
        </tr>        
    <?php
    }
    ?>
    
</table>
    

