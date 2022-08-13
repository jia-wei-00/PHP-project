<?php

function emptyInputLogin($name, $pass)
{
    if (empty($name) || empty($pass)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function userExists($conn, $name, $email)
{
    $sql = "SELECT * FROM tbl_admin WHERE fullname = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return ($row);
    } else {
        $result = false;
        return ($result);
    }

    mysqli_stmt_close($stmt);
}

function loginUser($conn, $name, $pass)
{
    $userExists = userExists($conn, $name, $name);

    if ($userExists == false) {
        header("location: ../index.php?error=wronglogininfo");
        exit();
    }

    $passHash = $userExists["pass"];

    $passCheck = md5($pass);
    if ($passCheck == $passHash) {
        // print_r($userExists);
        // echo($userExists["id"]);
        session_start();
        $_SESSION["id"] = $userExists["id"];
        $_SESSION["name"] = $userExists["fullname"];
        header("location: ../index.php");
        exit();
    } else {
        header("location: ../index.php?error=wronglogininfo");
    }
}

function fetchTemplate($conn)
{
    $sql = "SELECT * FROM tbl_template";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    while (mysqli_fetch_assoc($resultData)) {
        echo "<tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>Germany</td>
        </tr>";
    }
}

function deleteTemplate($conn, $id)
{
    $sql = "DELETE FROM tbl_template WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return ($result);
    mysqli_close($conn);
}

function viewTemplate($conn, $id)
{
    $sql = "SELECT template_data FROM tbl_admin WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $data);

    if (mysqli_stmt_fetch($stmt)) {
        $sql = $data;
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
    } else {
        $result = false;
        return ($result);
    }

    mysqli_stmt_close($stmt);
}

function addTemplate($conn, $t_name, $t_column)
{
    $sql = "INSERT INTO tbl_template (template_name, template_column) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $t_name, $t_column);

    if (mysqli_stmt_execute($stmt)) {
        header("location: ../index.php");
    }

    mysqli_stmt_close($stmt);
}

function updateTemplate($conn, $id, $t_name, $t_column)
{
    $sql = "UPDATE tbl_template SET template_name = ?, template_column = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssi", $t_name, $t_column, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("location: ../index.php");
    }

    mysqli_stmt_close($stmt);
}

function checkDuplicate($conn, $t_name)
{
    $sql = "SELECT template_name FROM tbl_template WHERE template_name = '$t_name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

    mysqli_close($conn);
}

function checkDuplicateEdit($conn, $id, $t_name)
{
    $sql = "SELECT template_name FROM tbl_template WHERE template_name = '$t_name' AND id != '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

    mysqli_close($conn);
}
