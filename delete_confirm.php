<?php

require("db.php");
include("header.php");

session_start();

?>

<p>
    Confirm deletion?
</p>


<a href="delete.php?id=<?= $_GET['id'] ?>" style="margin-left: 2em;">Yes</a>

<a href="select.php" style="margin-left: 20em;">No, go back</a>

