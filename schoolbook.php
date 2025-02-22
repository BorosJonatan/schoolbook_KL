<?php
session_start();
require_once('create_db.php');
require_once('schoolbook_html.php');

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

    <?php
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
        $_SESSION['year'] = $years[0];
        $year = $_SESSION['year'];
    }
    
    //aktualis osztalyok
    if (isset($_SESSION['osztalyok'])) {
        $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $year;");
        $tmp = array_column($data_assoc, 'name');
        $_SESSION['osztalyok'] = $tmp;
        $osztalyok = $_SESSION['osztalyok'];
        print_r($osztalyok);
    }
    else {
        $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $year;");
        $tmp = array_column($data_assoc, 'name');
        $_SESSION['osztalyok'] = $tmp;
        $osztalyok = $_SESSION['osztalyok'];
        print_r($osztalyok);
    }
    
    //kivalasztott osztaly
    if (isset($_POST['oszt'])){
        $_SESSION['oszt'] = $_POST['oszt'];
        $oszt = $_SESSION['oszt'];
        print_r($oszt);
    }
    else {
        $_SESSION['oszt'] = '11a';
        $oszt = $_SESSION['oszt'];
        print_r($oszt);
    }

    //atlagok
    if (isset($_POST['mode'])){
        $_SESSION['mode'] = $_POST['mode'];
        $mode = $_SESSION['mode'];
    }
    else {
        $_SESSION['mode'] = "names";
        $mode = $_SESSION['mode'];
    }
    
    ?>
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
    <form action="schoolbook.php" method="POST" class="cimkek">
        <input type="hidden" name="year" value="<?php print_r($year); ?>">
        <input type="hidden" name="oszt" value="<?php print_r($oszt); ?>">
        <label for="mode">Válassz évet:</label>
        <select name="mode" id="mode">
            <option value="names" <?= ($mode == "names") ? 'selected' : '' ?>>Osztályok</option>

            <option value="Classavg" <?= ($mode == "Classavg") ? 'selected' : '' ?>>Osztály Átlaga</option>
        </select>
        <button  type="submit" class="indito">Ev kivalasztasa</button>
    </form>
</body>
</html>

<?php
if (isset($_POST['mode'])){
    if ($_POST['mode'] == "Classavg"){
        getCLassAVG($oszt);
    }
    if ($_POST['mode'] == "names"){
        showStudents($oszt);
    }
}