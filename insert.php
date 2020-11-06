<?php

require("db.php");
include("header.php");

session_start();
?>

<p>
    Use portugues, singular, letras minusculas, e sem acentos
</p>

<form action="insert_add.php" method="post">
    <table>
        <tr>
            <td>Data</td>
            <td><input type="date" name="event_date" id="datepicker"></td>
        </tr>
        <tr>
            <td>Produto (AC)</td>
            <td><input type="text" name="name" autofocus></td>
        </tr>
        <tr>
            <td>Anotacoes</td>
            <td><input type="text" name="notes"></td>
        </tr>
        <tr>
            <td>Loja (AC)</td>
            <td><input type="text" name="store"></td>
        </tr>
        <tr>
            <td>Qtde</td>
            <td><input type="text" name="qty"></td>
        </tr>
        <tr>
            <td>un, kg, l</td>
            <td><input type="text" name="unit"></td>
        </tr>
        <tr>
            <td>Preco</td>
            <td><input type="text" name="price"></td>
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
?>

<script>
 document.getElementById("datepicker").valueAsDate = new Date();
</script>
