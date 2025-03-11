<?php
require_once("../schoolbook_sql.php");

function showSubjects(){
    $data = execQuery("SELECT id,name FROM subjects;");
    $array = array_column($data, 'name');
    $array_id = array_column($data, 'id');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<h2>Tantárgyak</h2>";
    echo '<form method="POST">
            <button id="a" name="add-subj-btn" type="submit" value="">+</button>
        </form>';
    echo "<tr class='tah'><th>Sorszám</th><th>Név</th><th></th><th></th></tr>";
    foreach ($array as $i => $v){
        $id = $array_id[$i];
        echo "<tr><td>". $i+1 . "</td><td>$v</td><form method='POST'><td><button name='delete-subj' value='$id'>Delete</button></td></form><form method='POST'><td><button name='mod-subj' value='$id'>Modify</button></td></form></tr>";
    }
    echo "</table>";
    echo "</div>";
}


function showClassHeader($ev)
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
    showClasses($ev);
}
function showClasses($ev){
    if ($ev != null){
        $data = execQuery("SELECT id, name FROM classes WHERE year = $ev;");
    }
    $array = array_column($data, 'name');
    $array_id = array_column($data, 'id');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<h2>Osztályok</h2><form method='POST'><button name='add-class-btn' type='submit' class='add-class-btn'>+</button></form>";
    echo "<tr class='tah'><th>Sorszám</th><th>Osztály</th><th></th><th></th></tr>";
    foreach ($array as $i => $v){
        $index = $i +1;
        $id = $array_id[$i];
        echo "<tr><td>". $index . "</td><td>$v</td><form method='POST'><td><button name='delete-class' value='$id'>Delete</button></td></form><form method='POST'><td><button name='mod-class' value='$id'>Modify</button></td></form></tr>";
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
function showStudents(){
    $data = execQuery("SELECT name,id FROM students;");
    $array = array_column($data, 'name');
    $array_id = array_column($data, 'id');
    echo "<table>";
    echo "<h2>Diákok</h2><form method='POST'><button name='add-stu-btn' type='submit' class='add-stu-btn'>+</button></form>";
    echo "<tr class='tah'><th>Sorszám</th><th>Neve</th><th></th><th></th></tr>";
    foreach ($array as $i => $v){
        $index = $i +1;
        $id = $array_id[$i];
        echo "<tr><td>". $id . "</td><td>$v</td><form method='POST'><td><button name='delete-stu' value='$id'>Delete</button></td></form><form method='POST'><td><button name='mod-stu' value='$id'>Modify</button></td></form></tr>";
    }
    echo "</table>";
    echo "</div>";
}

function showNewSubj(){
    echo "<div class='table-div'>";
    echo "<table>";
    echo '<form action="admin.php"  id="classForm" method="POST">
        <tr>
            <td>Név</td><td><input name="newSubjName" required></td>
            <td colspan="2"><button type="submit" name="add-subj-btn">Hozzáadás</button></td>
        </tr>
    </form>';
    echo "</table>";
    echo "</div>";
}

function showNewClass() {
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<form action='admin.php'  id='classForm' method='POST'>
        <tr>
            <td>Név</td><td><input name='newClassName' required></td>
            <td>Év:</td><td><input name='newClassYear' required></td>
            <td colspan='2'><button type='submit' name='add-class-btn'>Hozzáadás</button></td>
        </tr>
    </form>";
    echo "</table>";
    echo "</div>";
}
function showNewStu(){
    echo "<div class='table-div'>";
    echo "<table>";
    echo '<form action="admin.php" method="POST">
        <tr>
            <td>Név</td><td><input name="newStuName" required></td>
            <td>Class-id</td><td><input name="newClassId" required></td>
            <td colspan="2"><button type="submit" name="add-stu-btn">Hozzáadás</button></td>
        </tr>
    </form>';
    echo "</table>";
    echo "</div>";
}
function modifySubj($id){
    $data = execQuery("SELECT name FROM subjects WHERE id = $id;");
    $array = array_column($data, 'name');
    $name = $array[0];
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<form action='admin.php' method='POST'>
        <tr>
            <td>Név</td><td><input name='newSubjName' value='$name' required></td>
            <input type='hidden' name='modId' value='$id'>
            <td colspan='2'><button type='submit' name='upd-subj-btn'>Mentés</button></td>
        </tr>
    </form>";

    echo "</table>";
    echo "</div>";
}
function modifyClass($id){
    $data = execQuery("SELECT name, year FROM classes WHERE id = $id;");
    $array = array_column($data, 'name');
    $array_year = array_column($data, 'year');
    $name = $array[0];
    $year = $array_year[0];
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<form action='admin.php' method='POST'>
        <tr>
            <td>Név</td><td><input name='newClassName' value='$name' required></td>
            <td>Év:</td><td><input name='newClassYear' value='$year' required></td>
            <input type='hidden' name='modId' value='$id'>
            <td colspan='2'><button type='submit' name='upd-class-btn'>Mentés</button></td>
        </tr>
    </form>";
    echo "</table>";
    echo "</div>";
}
function modifyStu($id){
    $data = execQuery("SELECT name, class_id FROM students WHERE id = $id;");
    $array = array_column($data, 'name');
    $array_class_id = array_column($data, 'class_id');
    $name = $array[0];
    $class_id = $array_class_id[0];
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<form action='admin.php' method='POST'>
        <tr>
            <td>Név</td><td><input name='newStuName' value='$name' required></td>
            <td>Év:</td><td><input name='newClassId' value='$class_id' required></td>
            <input type='hidden' name='modId' value='$id'>
            <td colspan='2'><button type='submit' name='upd-stu-btn'>Mentés</button></td>
        </tr>
    </form>";
    echo "</table>";
    echo "</div>";
}