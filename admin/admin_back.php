<?php
require_once("admin_html.php");
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
        showClasses($ev);
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
            showSubjects($ev);
        }
        if ($_POST['mainBtn'] == "oszt"){
            showClassHeader($ev);
        }
        if ($_POST['mainBtn'] == "diak"){
            showStudents($ev);
        }
    }
    else{
        $_SESSION['mainBtn'] = "subj";
        $mainBtn = $_SESSION['mainBtn'];
    }

if (isset($_POST['add-class-btn'])){
    showNewClass();
    if (isset($_POST['newClassName']) && isset($_POST['newClassYear'])){
        $newClassName = $_POST["newClassName"];
        $newClassYear = $_POST["newClassYear"];
        execSQL("INSERT INTO `classes`(name, year) VALUES ('$newClassName', $newClassYear)");
    }
}
if (isset($_POST['add-subj-btn'])){
    showNewSubj();
    if (isset($_POST['newSubjName'])){
        $newSubjName = $_POST["newSubjName"];
        execSQL("INSERT INTO `subjects`(name) VALUES ('$newSubjName')");
    }
}
if (isset($_POST['add-stu-btn'])){
    showNewStu();
    if (isset($_POST['newStuName']) && isset($_POST['newClassId'])){
        $newStuName = $_POST["newStuName"];
        $newClassId = $_POST["newClassId"];
        execSQL("INSERT INTO `students`(name, class_id) VALUES ('$newStuName', $newClassId)");
    }
}
//subjects
if (isset($_POST['delete-subj'])){
    $deleteId = $_POST['delete-subj'];
    execSQL("DELETE FROM subjects WHERE id = $deleteId;");
}
if (isset($_POST['mod-subj'])){
    $modId = $_POST['mod-subj'];
    modifySubj($modId);
}
if (isset($_POST['upd-subj-btn'])){
    $newSubjName = $_POST["newSubjName"];
    $modId = (int) $_POST["modId"];
    execSQL("UPDATE subjects SET name = '$newSubjName' WHERE id = '$modId';");
}
//classes
if (isset($_POST['delete-class'])){
    $deleteId = $_POST['delete-class'];
    execSQL("DELETE FROM classes WHERE id = $deleteId;");
}
if (isset($_POST['mod-class'])){
    $modId = $_POST['mod-class'];
    modifyClass($modId);
}
if (isset($_POST['upd-class-btn'])){
    $newClassName = $_POST["newClassName"];
    $newClassYear = $_POST["newClassYear"];
    $modId = (int) $_POST["modId"];
    execSQL("UPDATE classes SET name = '$newClassName', year = $newClassYear WHERE id = '$modId';");
}
//students
if (isset($_POST['delete-stu'])){
    $deleteId = $_POST['delete-stu'];
    execSQL("DELETE FROM students WHERE id = $deleteId;");
}
if (isset($_POST['mod-stu'])){
    $modId = $_POST['mod-stu'];
    modifyStu($modId);
}
if (isset($_POST['upd-stu-btn'])){
    $newStuName = $_POST["newStuName"];
    $newClassId = $_POST["newClassId"];
    $modId = (int) $_POST["modId"];
    execSQL("UPDATE students SET name = '$newStuName', class_id = $newClassId WHERE id = '$modId';");
}