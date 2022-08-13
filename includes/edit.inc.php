<?php

if (isset($_POST["edit"])) {
    $t_name = $_POST['et_name'];
    $columns = $_POST['ecol'];
    $id = $_GET['editid'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($t_name, $t_name) !== false) {
        header("location: ../index.php?error=emptyname");
        exit();
    }
    if (checkDuplicateEdit($conn, $id, $t_name) !== false) {
        header("location: ../index.php?error=templatenameexists");
        exit();
    }
    if (empty($columns)) {
        header("location: ../index.php?error=emptycol");
        exit();
    } else {
        $t_column = implode(",", $columns);
        updateTemplate($conn, $id, $t_name, $t_column);
    }
} else {
    header("location: ../index.php");
    exit();
}