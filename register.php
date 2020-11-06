<?php

require("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $stmt = $dbh->prepare("insert into user
    (uid, username, password_hash, email) values
    (:uid, :username, :password_hash, :email);");
  $stmt->execute([":uid" => uniqid() . bin2hex(random_bytes(4)),
                  ":username" => $_POST['username'],
                  ":password_hash" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                  ":email" => $_POST['email']]);

  // retrieve uid
  $stmt = $dbh->prepare("select uid from user where username = :username");
  $stmt->execute([":username" => $_POST['username']]);
  $row = $stmt->fetch();

  session_start();
  $_SESSION['uid'] = $row['uid'];
  
  header('Location: index.php');
}

include("header.php");

?>

<h3>Register</h3>
    
<form method="POST">
    <table>
        <tr>
            <td>Username</td>
            <td><input name="username"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input name="email"></td>
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

