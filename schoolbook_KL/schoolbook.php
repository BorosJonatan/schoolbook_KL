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
</body>
</html>
