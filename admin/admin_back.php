<?php
    //osszes ev osztalyok
    if (isset($_SESSION['evek'])) {
        $data_assoc = execQuery("SELECT DISTINCT year FROM classes c;");
        $tmp = array_column($data_assoc, 'year');
        $_SESSION['evek'] = $tmp;
        $years = $_SESSION['evek'];
    }
    else {
        $data_assoc = execQuery("SELECT DISTINCT year FROM classes c;");
        $tmp = array_column($data_assoc, 'year');
        $_SESSION['evek'] = $tmp;
        $evek = $_SESSION['evek']; 
    }

    //kivalasztott ev
    if (isset($_POST['ev'])){
        $_SESSION['ev'] = $_POST['ev'];
        $ev = $_SESSION['ev'];
    }
    else {
        $_SESSION['ev'] = $evek[0];
        $ev = $_SESSION['ev'];
    }
    
    //aktualis osztalyok
    if (isset($_SESSION['classes'])) {
        $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $ev;");
        $tmp = array_column($data_assoc, 'name');
        $_SESSION['classes'] = $tmp;
        $classes = $_SESSION['classes'];
    }
    else {
        $data_assoc = execQuery("SELECT DISTINCT name FROM classes c WHERE year = $ev;");
        $tmp = array_column($data_assoc, 'name');
        $_SESSION['classes'] = $tmp;
        $classes = $_SESSION['classes'];
    }
    
    //kivalasztott osztaly
    if (isset($_POST['class'])){
        $_SESSION['class'] = $_POST['class'];
        $class = $_SESSION['class'];
    }
    else {
        $_SESSION['class'] = '11a';
        $class = $_SESSION['class'];
    }


    if (isset($_POST['mainBtn'])){
        $_SESSION['mainBtn'] = $_POST['mainBtn'];
        $mainBtn = $_SESSION['mainBtn'];
        if ($_POST['mainBtn'] == "subj"){
            showSubjects();
        }
        if ($_POST['mainBtn'] == "oszt"){
            showClassHeader();
        }
    }
    else{
        $_SESSION['mainBtn'] = "subj";
        $mainBtn = $_SESSION['mainBtn'];
    }


function showSubjects(){
    $data = execQuery("SELECT name FROM subjects;");
    $array = array_column($data, 'name');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<h2>Tantárgyak</h2> <button class='add-subj-btn'>+</button>";
    echo "<tr class='tah'><th>Sorszám</th><th>Név</th></tr>";
    foreach ($array as $i => $v){
        echo "<tr><td>$i</td><td>$v</td></td></tr>";
    }
    echo "</table>";
    echo "</div>";
}


function showClassHeader()
{
    ?>
        <form action="admin.php" method="POST" class="cimkek">
        <input type="hidden" name="mainBtn" value="<?php print_r($_SESSION['mainBtn']); ?>">

        <label for="ev">Válassz évet:</label>
        <select name="ev" id="ev">
            <?php
                foreach ($_SESSION['evek'] as $v){
                    echo "<option value='$v' " . (($_POST['ev'] == $v) ? 'selected' : '') . ">$v</option>";
                }
            ?>
        </select>
        <button  type="submit" class="indito">Ev kivalasztasa</button>
    </form><br>
    <?php
    showClasses();
}
function showClasses(){
    $data = execQuery("SELECT name FROM classes;");
    $array = array_column($data, 'name');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<h2>Tantárgyak</h2><form><button name='add-class-btn' type='submit' class='add-class-btn'>+</button></form>";
    echo "<tr class='tah'><th>Sorszám</th><th>Osztály</th></tr>";
    foreach ($array as $i => $v){
        echo "<tr><td>$i</td><td>$v</td></td></tr>";
    }
    echo "</table>";
    echo "</div>";
}

function showStudentHeader()
{
    ?>
        <form action="admin.php" method="POST" class="cimkek">
        <input type="hidden" name="mainBtn" value="<?php print_r($_SESSION['mainBtn']); ?>">

        <label for="ev">Válassz évet:</label>
        <select name="ev" id="ev">
            <?php
                foreach ($_SESSION['evek'] as $v){
                    echo "<option value='$v' " . (($_POST['ev'] == $v) ? 'selected' : '') . ">$v</option>";
                }
            ?>
        </select>
        <button  type="submit" class="indito">Ev kivalasztasa</button>
    </form><br>
    <form action="admin.php" method="POST">
        <input type="hidden" name="mainBtn" value="<?php print_r($_SESSION['mainBtn']); ?>">
        <input type="hidden" name="ev" value="<?php print_r($_SESSION['ev']); ?>">
        <label for="oszt">Válassz osztályt:</label>
        <select name="oszt" id="oszt">
        <?php
            foreach ($_SESSION['classes'] as $v){
                echo "<option value='$v' " . (($_POST['class'] == $v) ? 'selected' : '') . ">$v</option>";
            }
        ?>
        </select>
        <button  type="submit" class="indito">Osztaly kivalasztasa</button>
    </form><br>

    <?php
}