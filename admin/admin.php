

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <button id="a" name="mainBtn" type="submit" value="subj">Tantárgyak</button>
        <button id="a" name="mainBtn" type="submit" value="oszt">Osztályok</button>
        <button id="a" name="mainBtn" type="submit" value="diak">Diákok</button>
    </form>

</body>
</html>
<?php

require_once("../schoolbook_sql.php");
require_once("admin_back.php");