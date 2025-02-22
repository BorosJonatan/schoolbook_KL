<?php
$sql_create_db = "CREATE DATABASE IF NOT EXISTS schoolbook CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci";
$sql_drop_db = "DROP DATABASE IF EXISTS schoolbook";

$sql_create_tantargy = "CREATE TABLE IF NOT EXISTS `subjects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;";


$sql_create_tanulo = "CREATE TABLE IF NOT EXISTS `students` (
  `id` INT NULL AUTO_INCREMENT,
  `name` VARCHAR(24) NOT NULL,
  `class_id` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_hungarian_ci;";


$sql_create_osztaly = "CREATE TABLE IF NOT EXISTS `classes` (
  `id` INT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `year` INT(4),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;";

$sql_create_osztalyzatok = "CREATE TABLE IF NOT EXISTS `marks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `student_id` INT NULL,
  `subject_id` INT NULL,
  `mark` INT NULL,
  `date` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_hungarian_ci;";


function execDB($sql, $host = 'localhost', $user = 'root', $pass = '', $dbname = 'schoolbook') {
  try {
      $conn = mysqli_connect($host, $user, $pass);
      if (!$conn) {
          throw new Exception("Connection failed: " . mysqli_connect_error());
      }
      
      if (stripos($sql, 'CREATE DATABASE') === 0) {
          if (mysqli_query($conn, $sql)) {
              //echo "Database created successfully.";
          } else {
              throw new Exception("Error creating database: " . mysqli_error($conn));
          }
      } elseif (stripos($sql, 'DROP DATABASE') === 0) {
        if (mysqli_query($conn, $sql)) {
            echo "Deleted database successfully.";
        } else {
            throw new Exception("Error creating database: " . mysqli_error($conn));
        }
    } elseif (stripos($sql, 'CREATE TABLE') === 0) {
          mysqli_select_db($conn, $dbname);
          if (mysqli_query($conn, $sql)) {
              //echo "Table created successfully.";
          } else {
              throw new Exception("Error creating table: " . mysqli_error($conn));
          }
      } else {
          throw new Exception("Invalid SQL command.");
      }
      mysqli_close($conn);
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }
}

function execQuery($sql, $host = 'localhost', $user = 'root', $pass = '', $dbname = 'schoolbook') {
  try {
      $conn = mysqli_connect($host, $user, $pass, $dbname);
      if (!$conn) {
          throw new Exception("Connection failed: " . mysqli_connect_error());
      }
      
      $result = mysqli_query($conn, $sql);
      if (!$result) {
          throw new Exception("Query failed: " . mysqli_error($conn));
      }
      $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      mysqli_close($conn);
      return $data;
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return false;
  }
}

function execSQL($sql, $host = 'localhost', $user = 'root', $pass = '', $dbname = 'schoolbook') {
  try {
      $conn = mysqli_connect($host, $user, $pass, $dbname);
      if (!$conn) {
          throw new Exception("Connection failed: " . mysqli_connect_error());
      }
      
      if (stripos($sql, 'INSERT') === 0 || stripos($sql, 'UPDATE') === 0 || stripos($sql, 'DELETE') === 0) {
          if (mysqli_query($conn, $sql)) {
              $affected_rows = mysqli_affected_rows($conn);
              mysqli_close($conn);
              return $affected_rows;
          } else {
              throw new Exception("Query execution failed: " . mysqli_error($conn));
          }
      } else {
          throw new Exception("Only INSERT, UPDATE, and DELETE queries are allowed.");
      }
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
      return false;
  }
}

function insertIfNot($table, $maxRecords, $insertSQL, $host = 'localhost', $user = 'root', $pass = '', $dbname = 'schoolbook') {
  $count = execQuery("SELECT COUNT(*) as count FROM `$table`", $host, $user, $pass, $dbname);
  if ($count && $count[0]['count'] <= $maxRecords) {
      return execSQL($insertSQL, $host, $user, $pass, $dbname);
  } else {
      return 0;
  }
}