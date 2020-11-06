<?php

require("db.php");

$dbh->exec("create table user (
  uid varchar(63) not null,
  username varchar(80) not null unique,
  password_hash varchar(255) not null,
  email varchar(255) not null unique,
  primary key (uid)
);");

