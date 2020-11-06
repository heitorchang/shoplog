<?php

require("db.php");
include("header.php");

session_start();
if (isset($_SESSION['uid'])) {
  $stmt = $dbh->prepare("select username from user where uid = :uid;");
  $stmt->execute([":uid" => $_SESSION['uid']]);
  $row = $stmt->fetch();
  $message = "Welcome back, ${row['username']}!";
} else {
  $message = "Please register.";
}


?>

<h3>NFF</h3>

<?= $message ?>
