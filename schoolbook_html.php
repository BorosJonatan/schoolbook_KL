<?php
require_once('insert.php');

function showStudents($oszt)
{
    $data_assoc = execQuery("SELECT s.name
    FROM students s
    JOIN classes c ON s.class_id = c.id
    WHERE c.name = '$oszt'
    ORDER BY s.name;");
    $array = array_column($data_assoc, 'name');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<h2>$oszt</h2>";
    echo "<tr class='tah'><th>Sorszám</th><th>Név</th></tr>";
    
    foreach ($array as $i => $student){
        $in = $i+1;
        echo "<tr>";
        echo "<td>$in</td><td>$student</td></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}

function getStudentAvg(){
    $data_assoc = execQuery("
    SELECT c.name AS class_name, c.year, AVG(m.mark) AS average_mark
    FROM marks m
    JOIN students s ON m.student_id = s.id
    JOIN classes c ON s.class_id = c.id
    GROUP BY c.id, c.name;");
    $avg = array_column($data_assoc, 'average_mark');
    $data_assoc = execQuery("
    SELECT s.name, AVG(m.mark) AS average_mark
    FROM students s
    JOIN marks m ON s.id = m.student_id
    GROUP BY s.id, s.name;
    ");
    $avg_s = array_column($data_assoc, 'average_mark');
    $name_s = array_column($data_assoc, 'name');
    echo "<div class='table-div'>";
    echo "<table>";
    echo "<tr class='tah'><th>Diák</th><th>Átlag</th></tr>";
    foreach ($avg_s as $i => $value){
        echo "<tr>";
        echo "<td>". strval($name_s[$i]) ."</td><td>" . strval($value) . "</td>";
        echo "</tr>";
    }
    echo "<tr class='oszt'>";
    echo "<th class='a'>Egész osztály</td><td>" . strval($avg[0]) . "</th>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

function getStudentAvg_subj(){
    $names_assoc = execQuery("SELECT s.name FROM students s JOIN marks m ON s.id = m.student_id GROUP BY s.id, s.name;");
    $students = array_column($names_assoc, 'name');
    echo "<div class='table-div'>";
    foreach ($students as $student){
        echo "<table>";
        echo "<h2>$student</h2>";
        echo "<tr class='tah'><th>Tantárgy</th><th>Átlag</th></tr>";
        foreach (SUBJ as $subj){
            $data_assoc = execQuery("
            SELECT sub.name, AVG(m.mark) AS average_mark
            FROM students s
            JOIN marks m ON s.id = m.student_id
            JOIN subjects sub ON m.subject_id = sub.id
            WHERE sub.name = '$subj' AND s.name = '$student'
            GROUP BY s.id, s.name;
            ");
            $avg = array_column($data_assoc, 'average_mark');
            $name = array_column($data_assoc, 'name');
            foreach ($avg as $i => $value){
                echo "<tr>";
                echo "<td>". strval($name[$i]) ."</td><td>" . strval($value) . "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    echo "</div>";
}

function showClassAvg_subj(){
    $class_assoc = execQuery("SELECT c.name AS class_name FROM marks m JOIN students s ON m.student_id = s.id JOIN classes c ON s.class_id = c.id GROUP BY c.id, c.name;");
    $classes = array_column($class_assoc, 'class_name');
    echo "<div class='table-div'>";
    foreach ($classes as $class){
        echo "<table>";
        echo "<h2>$class</h2>";
        echo "<tr class='tah'><th>Tantárgy</th><th>Átlag</th></tr>";
        foreach (SUBJ as $subj){
            $data_assoc = execQuery("
            SELECT sub.name, AVG(m.mark) AS average_mark
            FROM students s
            JOIN marks m ON s.id = m.student_id
            JOIN classes c ON s.class_id = c.id
            JOIN subjects sub ON m.subject_id = sub.id
            WHERE sub.name = '$subj' AND c.name = '$class'
            GROUP BY c.id, c.name;
            ");
            $avg = array_column($data_assoc, 'average_mark');
            $name = array_column($data_assoc, 'name');

            foreach ($avg as $i => $value){
                echo "<tr>";
                echo "<td>". strval($name[$i]) ."</td><td>" . strval($value) . "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    echo "</div>";
}

function getTop10StudentAvg(){
    $data_assoc = execQuery("
    SELECT s.name, AVG(m.mark) AS average_mark
    FROM students s
    JOIN marks m ON s.id = m.student_id
    GROUP BY s.id, s.name
    ORDER BY average_mark DESC
    LIMIT 10;
    ");
    $avg = array_column($data_assoc, 'average_mark');
    $name = array_column($data_assoc, 'name');
    echo "<div class='table-div'>";
    echo "<h2>TOP 10</h2>";
    echo "<table>";
    echo "<tr class='tah'><th>Diák</th><th>Átlag</th></tr>";
    foreach ($avg as $i => $value){
        echo "<tr>";
        echo "<td>". strval($name[$i]) ."</td><td>" . strval($value) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}