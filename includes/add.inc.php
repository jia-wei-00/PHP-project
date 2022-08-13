<?php

if (isset($_POST["add"])) {
    $t_name = $_POST['t_name'];
    $columns = $_POST['col'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($t_name, $t_name) !== false) {
        header("location: ../index.php?error=emptyname");
        exit();
    }
    if (checkDuplicate($conn, $t_name) !== false) {
        header("location: ../index.php?error=templatenameexists");
        exit();
    }
    if (empty($columns)) {
        header("location: ../index.php?error=emptycol");
        exit();
    } else {
        $t_column = implode(",", $columns);
        addTemplate($conn, $t_name, $t_column);
    }
} else {
    header("location: ../index.php");
    exit();
}
