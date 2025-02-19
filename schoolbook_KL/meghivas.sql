CREATE SCHEMA `schoolbook` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;

CREATE TABLE `schoolbook`.`tanulo` (
  `diak_id` INT NULL AUTO_INCREMENT,
  `nev` VARCHAR(24) NOT NULL,
  `osztaly` INT NULL,
  `nem` INT NULL,
  PRIMARY KEY (`diak_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_hungarian_ci;

CREATE TABLE `schoolbook`.`osztaly` (
  `osztaly_id` INT NULL AUTO_INCREMENT,
  `osztaly` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`osztaly_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;

CREATE TABLE `schoolbook`.`tantargy` (
  `tantargy_id` INT NOT NULL AUTO_INCREMENT,
  `tantargy` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tantargy_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;


CREATE TABLE `schoolbook`.`osztalyzatok` (
  `diak_id` INT NOT NULL,
  `tantargy_id` INT NULL,
  `jegyek` INT NULL,
  `datum` DATE NULL,
  PRIMARY KEY (`diak_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;
