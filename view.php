<?php
include_once 'header.php';
include_once 'includes/dbh.inc.php';

if (isset($_SESSION["id"])) {
    if (isset($_GET['viewid'])) {
        $id = $_GET['viewid'];
        $sql = "SELECT template_name,template_column FROM tbl_template WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: index.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $name, $data);
        mysqli_stmt_fetch($stmt);

        $str_arr = explode(",", $data);
        $count = count($str_arr);
?>
        <div class="container">
            <div class="d-flex justify-content-between mt-5">
                <h2>Template Name: <?php echo $name; ?></h2>
                <a href="export_report.php?template_id=<?php echo $id; ?>"><button type="button" class="btn btn-primary">Generate Report</button></a>
            </div>

            <table>
                <tr>
                    <?php
                    for ($i = 0; $i < $count; $i++) {
                        echo '<th>' . $str_arr[$i] . '</th>';
                    }
                    ?>
                </tr>
                <?php
                $sql = "SELECT $data from tbl_members";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: ../index.php?error=stmtfailed");
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

                while (mysqli_stmt_fetch($stmt)) {
                    if ($count === 2) {
                        echo
                        '<tr>
                    <td>' . $a . '</td>
                    <td>' . $b . '</td>
                </tr>';
                    } else if ($count === 3) {
                        echo
                        '<tr>
                    <td>' . $a . '</td>
                    <td>' . $b . '</td>
                    <td>' . $c . '</td>
                </tr>';
                    } else if ($count === 4) {
                        echo
                        '<tr>
                    <td>' . $a . '</td>
                    <td>' . $b . '</td>
                    <td>' . $c . '</td>
                    <td>' . $d . '</td>
                </tr>';
                    } else if ($count === 5) {
                        echo
                        '<tr>
                    <td>' . $a . '</td>
                    <td>' . $b . '</td>
                    <td>' . $c . '</td>
                    <td>' . $d . '</td>
                    <td>' . $e . '</td>
                </tr>';
                    } else if ($count === 6) {
                        echo
                        '<tr>
                    <td>' . $a . '</td>
                    <td>' . $b . '</td>
                    <td>' . $c . '</td>
                    <td>' . $d . '</td>
                    <td>' . $e . '</td>
                    <td>' . $f . '</td>
                </tr>';
                    }
                }
                ?>
            </table>
            <div>

        <?php
    } else {
        include_once 'index.php';
    }
} else {
    include_once 'index.php';
}


include_once 'footer.php';
