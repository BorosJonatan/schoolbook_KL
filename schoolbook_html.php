<?php
require_once('insert.php');
require_once('backhand.php');

function showStudents($oszt)
{
    $data_assoc = execQuery("SELECT s.name
    FROM students s
    JOIN classes c ON s.class_id = c.id
    WHERE c.name = '$oszt'
    ORDER BY s.name;");
    $array = array_column($data_assoc, 'name');

    echo "<table>";
    echo "<h3>$oszt</h3>";
    echo "<tr><th>Sorszám</th><th>Név</th></tr>";
    
    foreach ($array as $i => $student){
        $in = $i+1;
        echo "<tr>";
        echo "<td>$in</td><td>$student</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function getCLassAVG($oszt){

    $data_assoc = execQuery("
    SELECT c.name AS class_name, c.year, AVG(m.mark) AS average_mark
    FROM marks m
    JOIN students s ON m.student_id = s.id
    JOIN classes c ON s.class_id = c.id
    WHERE c.name = '$oszt'
    GROUP BY c.id, c.name;");
    $avg = array_column($data_assoc, 'average_mark');
    $name = array_column($data_assoc, 'class_name');
    print_r($avg);
    echo "<table>";
    echo "<h3>$oszt</h3>";
    echo "<tr><th>Név</th><th>Átlag</th></tr>";
        echo "<tr>";
        echo "<td>". strval($name[0]) ."</td><td>" . strval($avg[0]) . "</td>";
        echo "</tr>";
    echo "</table>";
}

