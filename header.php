<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TG_Test</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="row justify-content-between" style="width: 100%;">
            <a class="navbar-brand col mx-3" href="./index.php">
                <img class="icon" src="img/Top_Glove_logo.png" alt="tg_icon" />
            </a>
            <div class="col">
                <div style="text-align: right;" class="mt-3">
                    <?php
                    if (isset($_SESSION['id'])) {
                        echo "<a href='includes/logout.inc.php' style='color: white;'>Logout</a>";
                    } ?>
                </div>
            </div>
    </nav>