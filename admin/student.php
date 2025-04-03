<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/grade.php";
       $students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>

    <div class="container mt-5">
        <a href="student-add.php" class="btn btn-dark">Add New Student</a>
        
        <!-- Search Form -->
        <form action="student-search.php" class="mt-3" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="searchKey" placeholder="Search...">
                <button class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </form>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3"><?= $_GET['error'] ?></div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3"><?= $_GET['success'] ?></div>
        <?php } ?>

        <?php if ($students != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($students as $student) { $i++; ?>
                        <tr>
                            <th><?= $i ?></th>
                            <td><?= $student['student_id'] ?></td>
                            <td><a href="student-view.php?student_id=<?= $student['student_id'] ?>"><?= $student['fname'] ?></a></td>
                            <td><?= $student['lname'] ?></td>
                            <td><?= $student['username'] ?></td>
                            <td>
                                <?php 
                                    $g_temp = getGradeById($student['grade'], $conn);
                                    if ($g_temp != 0) {
                                        echo $g_temp['grade_code'] . '-' . $g_temp['grade'];
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="student-edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Delete Input Field Below Table -->
            <div class="mt-4">
                <h5>Delete a Student</h5>
                <form action="student-delete.php" method="post" class="d-flex">
                    <input type="text" name="delete_id" class="form-control w-25 me-2" placeholder="Enter Student ID to delete" required>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

        <?php } else { ?>
            <div class="alert alert-info mt-5">No students found!</div>
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
