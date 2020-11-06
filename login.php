<?php

require("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $stmt = $dbh->prepare("select uid, password_hash from user where username = :username;");
  $stmt->execute([":username" => $_POST['username']]);
  $row = $stmt->fetch();

  if ($row) {
    if (password_verify($_POST['password'], $row['password_hash'])) {
      session_start();
      $_SESSION['uid'] = $row['uid'];
      header('Location: index.php');
    } else {
      $error = "Invalid username and password combination.";
    }
  } else {
    $error = "Invalid username and password combination.";
  } 
}

include("header.php");

?>

<h3>Login</h3>

<?= $error ?>

<form method="POST">
    <table>
        <tr>
            <td>Username</td>
            <td><input name="username" autofocus></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="password" type="password"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit"></td>
        </tr>
    </table>
</form>

