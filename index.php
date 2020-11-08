<?php

require("db.php");
include("header.php");

session_start();
?>

<form action="insert_add.php" method="post" autocomplete="off">
    <table>
        <tr>
            <td><input type="date" name="event_date" autocomplete="off" id="datepicker"></td>
        </tr>
        <tr>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="nameAC" name="name" placeholder="produto" autofocus>
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="text" name="notes" placeholder="anotacoes" autocomplete="off"></td>
        </tr>
        <tr>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="storeAC" placeholder="loja" name="store">
                </div>
            </td>
        </tr>
        <tr>
            <td><input type="text" name="qty" placeholder="qtde" autocomplete="off"></td>
        </tr>
        <tr>
            <td>
                <select name="unit">
                    <option value="un" selected>un</option>
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="text" name="price" placeholder="preco" autocomplete="off"></td>
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

?>

<script>
    document.getElementById("datepicker").valueAsDate = new Date();
</script>
