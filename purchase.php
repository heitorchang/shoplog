<?php

require("db.php");
include("header.php");

session_start();

$stmt = $dbh->prepare("select * from shoplog where purchase_id = :id");
$stmt->execute([":id" => $_GET['id']]);

$row = $stmt->fetch();

?>

<form action="update_add.php" method="post" autocomplete="off">
    <input type="hidden" name="purchase_id" value="<?= $row['purchase_id'] ?>">
    <table>
        <tr>
            <td>Data</td>
            <td><input type="date" name="event_date" autocomplete="off" id="datepicker" value="<?= $row['event_date'] ?>"></td>
        </tr>
        <tr>
            <td>Produto</td>           
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="nameAC" name="name" value="<?= $row['name'] ?>"autofocus>
                </div>
            </td>
        </tr>
        <tr>
            <td>Anotacoes</td>
            <td><input type="text" name="notes" value="<?= $row['notes'] ?>" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Loja</td>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="storeAC" name="store" value="<?= $row['store'] ?>">
                </div>
            </td>
        </tr>
        <tr>
            <td>Qtde</td>
            <td><input type="text" name="qty" value="<?= $row['qty'] ?>" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Unidade</td>
            <td>
                <select name="unit" id="unitSelect">
                    <option value="un">un</option>
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Preco</td>
            <td><input type="text" name="price" value="<?= $row['price'] ?>" autocomplete="off"></td>
        </tr>
    </table>
    <input type="submit">
</form>

<br><br><br>

<a href="delete_confirm.php?id=<?= $row['purchase_id'] ?>" style="margin-left: 20em;">Delete</a>

<script>
 // select correct unit
 var sel = document.getElementById('unitSelect');
 var opts = sel.options;
 for (var opt, j = 0; opt = opts[j]; j++) {
     if (opt.value == "<?= $row['unit'] ?>") {
         sel.selectedIndex = j;
         break;
     }
 }
</script>

<?php

include("autocomplete.php");
