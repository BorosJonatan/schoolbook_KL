<?php
require_once('insert.php');

if (isset($_POST['sql']) && $_POST['sql'] == 'create_db') {
    execDB($sql_create_db);
    execDB($sql_create_tantargy);
    execDB($sql_create_tanulo);
    execDB($sql_create_osztaly);
    execDB($sql_create_osztalyzatok);
    
    generateGrades();
    generateClasses();
    generateMarksAndStudents();
}
if (isset($_POST['sql']) && $_POST['sql'] == 'delete_db') {
    execDB($sql_drop_db);
}
?>