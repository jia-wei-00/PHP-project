<?php

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $pass = $_POST["pass"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($name, $pass) !== false) {
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $name, $pass);
} else {
    header("location: ../index.php");
    exit();
}
