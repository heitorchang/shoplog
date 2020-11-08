<?php

require("db.php");
include("header.php");

session_start();
?>

<p>
    Last: 
    
    <?php 
    $stmt = $dbh->query("select * from shoplog order by purchase_id desc limit 1");

    foreach ($stmt as $purchase) {
    ?>
        <?= $purchase['event_date'] ?>
        <?= $purchase['name'] ?>
        <?= $purchase['notes'] ?>
        <?= number_format($purchase['price'] / $purchase['qty'], 2) ?>

    <?php
    }
    ?>
</p>


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


<?php

include("autocomplete.php");

?>

<script>
 document.getElementById("datepicker").valueAsDate = new Date();
</script>
