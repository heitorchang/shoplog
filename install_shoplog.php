<?php

require("db.php");

$dbh->exec("create table shoplog (
  purchase_id int not null auto_increment,
  name varchar(63) not null,
  notes varchar(63),
  store varchar(63),
  event_date date not null,
  qty real not null,
  unit varchar(15) not null,
  price real not null,
  primary key (purchase_id)
);");
