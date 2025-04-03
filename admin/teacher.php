<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/subject.php";
        include "data/grade.php";
        include "data/class.php";
        include "data/section.php";
        $teachers = getAllTeachers($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    <div class="container mt-5">
        <a href="teacher-add.php" class="btn btn-dark">Add New Teacher</a>
        <form action="teacher-search.php" class="mt-3" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </form>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3" role="alert">
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; foreach ($teachers as $teacher) { $i++; ?>
                    <tr>
                        <th><?= $i ?></th>
                        <td><?= $teacher['teacher_id'] ?></td>
                        <td><a href="teacher-view.php?teacher_id=<?= $teacher['teacher_id'] ?>"><?= $teacher['fname'] ?></a></td>
                        <td><?= $teacher['lname'] ?></td>
                        <td><?= $teacher['username'] ?></td>
                        <td><?= getSubjectById($teacher['subjects'], $conn)['subject_code'] ?? 'N/A' ?></td>
                        <td><?= getClassById($teacher['class'], $conn)['grade'] ?? 'N/A' ?></td>
                        <td>
                            <a href="teacher-edit.php?teacher_id=<?= $teacher['teacher_id'] ?>" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <form action="teacher-delete.php" method="post" class="mt-4">
            <label for="teacher_id">Enter Teacher ID to Delete:</label>
            <input type="text" name="teacher_id" id="teacher_id" class="form-control mb-2" required>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
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