<?php

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "schoolbook";

$conn = new mysqli($db_server, $db_user, $db_pass);

if ($conn -> connect_error){
    die("Connection failed" . $conn -> connect_error);
}


$sql_create_tantargy = "CREATE TABLE `schoolbook`.`tantargy` (
    `tantargy_id` INT NOT NULL AUTO_INCREMENT,
    `tantargy` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`tantargy_id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_hungarian_ci;";

$conn->query($sql_create_tantargy);

$sql_create_tanulo = "CREATE TABLE `schoolbook`.`tanulo` (
    `diak_id` INT NULL AUTO_INCREMENT,
    `nev` VARCHAR(24) NOT NULL,
    `osztaly` INT NULL,
    `nem` INT NULL,
    PRIMARY KEY (`diak_id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_hungarian_ci;";
$conn->query($sql_create_tanulo);


$sql_create_osztaly = "CREATE TABLE `schoolbook`.`osztaly` (
    `osztaly_id` INT NULL AUTO_INCREMENT,
    `osztaly` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`osztaly_id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_hungarian_ci;";

$conn->query($sql_create_osztaly);


$sql_create_osztalyzatok = "CREATE TABLE `schoolbook`.`osztalyzatok` (
    `diak_id` INT NOT NULL,
    `tantargy_id` INT NULL,
    `jegyek` INT NULL,
    `datum` DATE NULL,
    PRIMARY KEY (`diak_id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_hungarian_ci;";

$conn->query($sql_create_osztalyzatok);

$conn -> close();