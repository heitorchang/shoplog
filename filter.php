<?php

require("db.php");
include("header.php");

session_start();

?>

<p>
    Search (default: last 45 days)
</p>

<form action="filter_select.php" method="get" autocomplete="off">
    <table>
        <tr>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="nameAC" name="name" placeholder="produto" autofocus>
                </div>
            </td>
        </tr>
        <tr>
            <td>From <input type="date" name="start_date" autocomplete="off" id="datepicker"></td>
        </tr>
        <tr>
            <td>To <input type="date" name="end_date" autocomplete="off" id="datepicker"></td>
        </tr>
        <tr>
            <td>
                Sort by
                <select name="sort">
                    <option value="p" selected>price/qty</option>
                    <option value="n">name</option>
                    <option value="d">date</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit">
</form>

<?php

include("autocomplete_filter.php");


