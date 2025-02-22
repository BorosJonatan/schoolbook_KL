<?php

function getCLassAVG($oszt){
    $data_assoc = execQuery("
    SELECT c.name AS class_name, c.year, AVG(m.mark) AS average_mark
    FROM marks m
    JOIN students s ON m.student_id = s.id
    JOIN classes c ON s.class_id = c.id
    GROUP BY c.id, c.name, c.year
    WHERE c.name = $oszt;");
    $tmp = array_column($data_assoc, 'average_mark');
    var_dump($tmp);
}