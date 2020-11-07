<?php

require("db.php");
include("header.php");

session_start();
?>

<form action="insert_add.php" method="post" autocomplete="off">
    <table>
        <tr>
            <td>Data</td>
            <td><input type="date" name="event_date" autocomplete="off" id="datepicker"></td>
        </tr>
        <tr>
            <td>Produto</td>           
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="nameAC" name="name" autofocus>
                </div>
            </td>
        </tr>
        <tr>
            <td>Anotacoes</td>
            <td><input type="text" name="notes" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Loja</td>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="storeAC" name="store">
                </div>
            </td>
        </tr>
        <tr>
            <td>Qtde</td>
            <td><input type="text" name="qty" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Unidade</td>
            <td>
                <select name="unit">
                    <option value="un" selected>un</option>
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Preco</td>
            <td><input type="text" name="price" autocomplete="off"></td>
        </tr>
    </table>
    <input type="submit">
</form>

<p>
    Ultima compra
</p>

<?php 
$stmt = $dbh->query("select * from shoplog order by purchase_id desc limit 1");

foreach ($stmt as $purchase) {
?>
    <tr>
        <td>
            <?= $purchase['event_date'] ?>
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
            <?= $purchase['price'] ?>
        </td>
        <td style="text-align: right;">
            <?= number_format($purchase['price'] / $purchase['qty'], 2) ?>
        </td>            
    </tr>        
<?php
}

include("autocomplete.php");


