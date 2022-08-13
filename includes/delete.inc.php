<?php

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (deleteTemplate($conn, $id)) {
        header("location: ../index.php?success=deletesuccess");
    } else {
        header("location: ../index.php?error=deletefailed");
    }
}
