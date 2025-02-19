<?php
require_once('create_db.php');
require_once('insert.php');
require_once('schoolbook_html.php');

session_start();
//osszes ev osztalyok
if (isset($_SESSION['year'])) {
    $data_assoc = execQuery("SELECT DISTINCT year FROM classes c;");
    $tmp = array_column($data_assoc, 'year');
    $_SESSION['years'] = $tmp;
    $years = $_SESSION['years'];
}
else {
    $data_assoc = execQuery("SELECT DISTINCT year FROM classes c;");
    $tmp = array_column($data_assoc, 'year');
    $_SESSION['years'] = $tmp;
    $years = $_SESSION['years']; 
}

//kivlasztott ev
if (isset($_POST['year'])){
    $_SESSION['year'] = $_POST['year'];
    $year = $_SESSION['year'];
}
else {
    $_SESSION['year'] = $years[1];
    $year = $_SESSION['year'];
}

//aktualis osztalyok
if (isset($_SESSION['osztalyok'])) {
    $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $year;");
    $tmp = array_column($data_assoc, 'name');
    $_SESSION['osztalyok'] = $tmp;
    $osztalyok = $_SESSION['osztalyok'];
}
else {
    $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $year;");
    $tmp = array_column($data_assoc, 'name');
    $_SESSION['osztalyok'] = $tmp;
    $osztalyok = $_SESSION['osztalyok']; 
}

//kivalasztott osztaly
if (isset($_POST['oszt'])){
    $_SESSION['oszt'] = $_POST['oszt'];
    $oszt = $_SESSION['oszt'];
    showStudents($oszt);
}
else {
    $_SESSION['oszt'] = '11a';
    $oszt = $_SESSION['oszt'];
    showStudents($oszt);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Creation</title>
</head>
<body>
    <form method="POST">
        <button id="a" name="sql" type="submit" value="create_db">DB generálása</button>
        <button id="a" name="sql" type="submit" value="delete_db">DB törlése</button>
    </form>
    <form action="schoolbook.php" method="POST" class="cimkek">
        <label for="year">Válassz évet:</label>
        <select name="year" id="year">
            <?php
                foreach ($years as $v){
                    echo "<option value='$v' " . (($year == $v) ? 'selected' : '') . ">$v</option>";
                }
            ?>
        </select>
        <button  type="submit" class="indito">Ev kivalasztasa</button>
    </form>
    <form action="schoolbook.php" method="POST">
        <input type="hidden" name="year" value="<?php print_r($year); ?>">
        <label for="oszt">Válassz osztályt:</label>
        <select name="oszt" id="oszt">
        <?php
            foreach ($osztalyok as $v){
                echo "<option value='$v' " . (($oszt == $v) ? 'selected' : '') . ">$v</option>";
            }
        ?>
        </select>
        <button  type="submit" class="indito">Osztaly kivalasztasa</button>
    </form>
</body>
</html>
