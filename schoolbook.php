<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Creation</title>
</head>
<body>
    <form method="POST">
        <button id="a" name="sql" type="submit" value="create_db">Nyomja meg</button>
    </form>

    <?php 
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "schoolbook";

    // Kapcsolódás az adatbázis kiszolgálóhoz
    $conn = new mysqli($db_server, $db_user, $db_pass);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Csak akkor indítjuk el az adatbázis létrehozását, ha a gombra kattintottak
    if (isset($_POST['sql']) && $_POST['sql'] == 'create_db') {
        // Ellenőrizzük, hogy létezik-e már az adatbázis
        $result = $conn->query("SHOW DATABASES LIKE '$db_name'");
        if ($result->num_rows == 0) {
            // Adatbázis létrehozása
            $sql = "CREATE DATABASE $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci";
            if ($conn->query($sql) === TRUE) {
                echo "Database '$db_name' created successfully!<br>";
            } else {
                echo "Error creating database: " . $conn->error . "<br>";
            }
        } else {
            echo "Database '$db_name' already exists.<br>";
        }

        // Adatbázis használata
        $conn->select_db($db_name);

        // Subjects tábla létrehozása
        $sql_create_tantargy = "CREATE TABLE IF NOT EXISTS `subjects` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_hungarian_ci;";

        $conn->query($sql_create_tantargy);

        // Students tábla létrehozása
        $sql_create_tanulo = "CREATE TABLE IF NOT EXISTS `students` (
            `id` INT NULL AUTO_INCREMENT,
            `name` VARCHAR(24) NOT NULL,
            `class_id` INT NULL,
            PRIMARY KEY (`id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8
        COLLATE = utf8_hungarian_ci;";

        $conn->query($sql_create_tanulo);

        // Classes tábla létrehozása
        $sql_create_osztaly = "CREATE TABLE IF NOT EXISTS `classes` (
            `id` INT NULL AUTO_INCREMENT,
            `name` VARCHAR(45) NOT NULL,
            `year` INT(4),
            PRIMARY KEY (`id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_hungarian_ci;";

        $conn->query($sql_create_osztaly);

        // Marks tábla létrehozása
        $sql_create_osztalyzatok = "CREATE TABLE IF NOT EXISTS `marks` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `student_id` INT NULL,
            `mark` INT NULL,
            `date` DATE NULL,
            PRIMARY KEY (`id`))
        ENGINE = InnoDB
        DEFAULT CHARACTER SET = utf8mb4
        COLLATE = utf8mb4_hungarian_ci;";

        $conn->query($sql_create_osztalyzatok);

        // Kapcsolat lezárása
        $conn->close();
    }
    ?>

</body>
</html>
