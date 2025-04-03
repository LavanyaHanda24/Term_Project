<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/grade.php";
        $grades = getAllGrades($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <?php include "inc/navbar.php"; ?>

    <div class="container mt-5">
        <a href="grade-add.php" class="btn btn-dark">Add New Grade</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3"><?= $_GET['error'] ?></div>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3"><?= $_GET['success'] ?></div>
        <?php } ?>

        <?php if ($grades != 0) { ?>
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Grade</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($grades as $grade) { $i++; ?>
                        <tr>
                            <th><?= $i ?></th>
                            <td><?= $grade['grade_code'] . '-' . $grade['grade'] ?></td>
                            <td>
                                <a href="grade-edit.php?grade_id=<?= $grade['grade_id'] ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Delete Input Field Below Table -->
            <div class="mt-4">
                <h5>Delete a Grade</h5>
                <form action="grade-delete.php" method="post" class="d-flex">
                    <input type="text" name="delete_id" class="form-control w-25 me-2" placeholder="Enter Grade ID to delete" required>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

        <?php } else { ?>
            <div class="alert alert-info mt-5">No grades found!</div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
    } else {
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
