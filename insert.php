<?php
require_once('schoolbook_sql.php');
require_once('data.php');

function generateGrades()
{
    foreach (SUBJ as $subject) {
        insertIfNot('subjects', 8, "INSERT INTO `subjects`(name) VALUES ('$subject')");
    }
}

function generateClasses()
{
    foreach (CLASSES as $class) {
        $start = strtotime("1968-01-01 00:00:00");
        $end = strtotime("2025-02-19 23:59:59");
        $randomTimestamp = mt_rand($start, $end);  // Véletlenszerű időbélyeg az adott tartományban
        $string = date("Y", $randomTimestamp);
        insertIfNot('classes', 6, "INSERT INTO `classes`(name, year) VALUES ('$class', '$string')");
    }
}

function generateMarksAndStudents(){
    $class_id = 0;
    foreach (CLASSES as $class){
        $class_id++;
        $classNumber = rand(10, 15);
        $maxCount = $classNumber*6;
        for ($i = 0; $i < $classNumber; $i++){
            $query = execQuery("SELECT year FROM classes WHERE id = $class_id LIMIT 1;");
            $year = $query[0]['year'];
            $lastname = NAMES['lastnames'][array_rand(NAMES['lastnames'])];
            $firstname = NAMES['firstnames'][array_rand(NAMES['firstnames'])];
            $name = "$lastname $firstname";
            insertIfNot('students', $maxCount, "INSERT INTO `students`(name, class_id) VALUES ('$name', $class_id)");
            foreach(SUBJ as $index => $subject){
                $markCount = rand(3, 5);
                $maxMarkCount = $markCount * $maxCount;
                for ($j = 0; $j < $markCount;$j++){
                    $mark = rand(1,5);
                    $start = strtotime("$year-01-01 00:00:00");
                    $end = strtotime("$year-12-31 23:59:59");
                    $randomTimestamp = mt_rand($start, $end);
                    $date = date("Y-m-d", $randomTimestamp);
                    insertIfNot('marks', $maxMarkCount, "INSERT INTO `marks`(student_id, subject_id, mark, date) VALUES ($i+1, $index+1, $mark, '$date');");
                }
            }
        }
    }
}



