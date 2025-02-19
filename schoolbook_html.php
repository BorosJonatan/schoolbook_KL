<?php
require_once('insert.php');
require_once('backhand.php');

function showStudents($oszt)
{
    $data_assoc = execQuery("SELECT s.name
    FROM students s
    JOIN classes c ON s.class_id = c.id
    WHERE c.name = '$oszt';");
    var_dump($data_assoc);
    $array = array_column($data_assoc, 'name');

    echo "<table>";
    echo "<h3>$oszt</h3>";
    echo "<tr>Sorszám<th></th><th>Név</th>";
    
    foreach ($array as $i => $student){
        $in = $i+1;
        echo "<tr>";
        echo "<td>$in</td><td>$student</td>";
        echo "</tr>";
    }
    echo "</table>";
}
