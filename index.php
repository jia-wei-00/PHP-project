<?php
include_once 'header.php';
include_once 'includes/functions.inc.php';
include_once 'includes/dbh.inc.php';
?>

<div class="container">
    <?php
    if (isset($_SESSION["id"])) {
    ?>
        <div class="d-flex justify-content-between mt-5">
            <h2>Template List</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTemplateModal">
                Add
            </button>
        </div>

        <table>
            <tr>
                <th>No.</th>
                <th>Template Name</th>
                <th>Actions</th>
            </tr>
            <?php
            $no = null;
            $sql = "SELECT id, template_name FROM tbl_template";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $name);
            while (mysqli_stmt_fetch($stmt)) {
                $no++;
                echo
                '<tr>
                    <td>' . $no . '</td>
                    <td>' . $name . '</td>
                    <td>
                        <button type="button" class="btn btn-info">
                            <a style="color: white; text-decoration: none;" href="view.php?viewid=' . $id . '">View</a>
                        </button>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTemplateModal">
                        <a style="color: black; text-decoration: none;" href="?editid=' . $id . '">Edit</a>
                        </button>
                        <button type="button" class="btn btn-danger">
                            <a style="color: white; text-decoration: none;" href="includes/delete.inc.php?deleteid=' . $id . '">Delete</a>
                        </button>
                    </td>
                </tr>';
            } ?>
        </table>

    <?php } else {
        include_once 'login.php';
    } ?>
</div>

<!-- Add Template Modal -->
<div class="modal fade" id="addTemplateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="includes/add.inc.php" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <input type="text" name="t_name" class="form-control" placeholder="Template Name" required>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="id" value="id" checked required>
                        <label class="form-check-label" for="id">ID</label>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="name" value="fullname" checked required>
                        <label class="form-check-label" for="name">FULLNAME</label>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="email" value="email">
                        <label class="form-check-label" for="email">EMAIL</label>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="gender" value="gender_category">
                        <label class="form-check-label" for="gender">GENDER CATEGORY</label>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="department" value="department">
                        <label class="form-check-label" for="department">DEPARTMENT</label>
                    </div>
                    <div class="form-group form-check form-switch">
                        <input name="col[]" class="form-check-input" type="checkbox" id="factory" value="factory">
                        <label class="form-check-label" for="factory">FACTORY</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_GET["editid"])) {
    $id = $_GET['editid'];
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
?>
    <!-- Edit Template Modal -->
    <div class="modal fade" id="editTemplateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="includes/edit.inc.php?editid=<?php echo $id; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input value="<?php echo $name; ?>" type="text" name="et_name" class="form-control" placeholder="Template Name" required>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="eid" value="id" <?php echo (in_array("id", $str_arr) ? 'checked' : ''); ?> required>
                            <label class="form-check-label" for="eid">ID</label>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="ename" value="fullname" <?php echo (in_array("fullname", $str_arr) ? 'checked' : ''); ?> required>
                            <label class="form-check-label" for="ename">FULLNAME</label>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="eemail" value="email" <?php echo (in_array("email", $str_arr) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="eemail">EMAIL</label>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="egender" value="gender_category" <?php echo (in_array("gender_category", $str_arr) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="egender">GENDER CATEGORY</label>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="edepartment" value="department" <?php echo (in_array("department", $str_arr) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="edepartment">DEPARTMENT</label>
                        </div>
                        <div class="form-group form-check form-switch">
                            <input name="ecol[]" class="form-check-input" type="checkbox" id="efactory" value="factory" <?php echo (in_array("factory", $str_arr) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="efactory">FACTORY</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#editTemplateModal').modal('show');
        });

        $('#editTemplateModal').on('hidden.bs.modal', function() {
            window.location = 'index.php';
        });
    </script>
<?php } ?>

<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyname") {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Empty Template Name!")';
        echo '</script>';
    } else if ($_GET["error"] == "templatenameexists") {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Template Name Exists!")';
        echo '</script>';
    } else if ($_GET["error"] == "emptycol") {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Something Went Wrong! Please Try Again")';
        echo '</script>';
    }
}
?>

<?php
include_once 'footer.php';
?>