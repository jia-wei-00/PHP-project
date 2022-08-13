<?php

if (isset($_GET['template_id'])) {
    $id = $_GET['template_id'];

    // Load the database configuration file 
    include_once 'includes/dbh.inc.php';

    // Filter the excel data 
    function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    // Excel file name for download 
    $fileName = "members-data_" . date('Y-m-d') . ".xls";

    $sql = "SELECT template_column FROM tbl_template WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $data);
    mysqli_stmt_fetch($stmt);

    $str_arr = explode(",", $data);
    $count = count($str_arr);

    // Column names 
    $fields = $str_arr;

    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n";

    // Fetch records from database 
    $sql = "SELECT $data from tbl_members";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    if ($count === 2) {
        mysqli_stmt_bind_result($stmt, $a, $b);
    } else if ($count === 3) {
        mysqli_stmt_bind_result($stmt, $a, $b, $c);
    } else if ($count === 4) {
        mysqli_stmt_bind_result($stmt, $a, $b, $c, $d);
    } else if ($count === 5) {
        mysqli_stmt_bind_result($stmt, $a, $b, $c, $d, $e);
    } else if ($count === 6) {
        mysqli_stmt_bind_result($stmt, $a, $b, $c, $d, $e, $f);
    }
    
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Output each row of the data 
        while (mysqli_stmt_fetch($stmt)) {
            if ($count === 2) {
                $lineData = array($a, $b);
            } else if ($count === 3) {
                $lineData = array($a, $b, $c);
            } else if ($count === 4) {
                $lineData = array($a, $b, $c, $d);
            } else if ($count === 5) {
                $lineData = array($a, $b, $c, $d, $e);
            } else if ($count === 6) {
                $lineData = array($a, $b, $c, $d, $e, $f);
            }
            array_walk($lineData, 'filterData');
            $excelData .= implode("\t", array_values($lineData)) . "\n";
        }
    } else {
        $excelData .= 'No records found...' . "\n";
    }
    
    // Headers for download 
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");

    // Render excel data 
    echo $excelData;

    exit;
} else {
    header("location: index.php");
}
