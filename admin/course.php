<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/subject.php";
        include "data/grade.php";
        $courses = getAllSubjects($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .delete-box {
            width: 200px; /* Adjust input size */
            padding: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    
    <div class="container mt-5">
        <a href="course-add.php" class="btn btn-dark">Add New Course</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php } ?>

        <?php if ($courses) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Course</th>
                            <th scope="col">Course Code</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($courses as $course) { $i++; ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td><?= htmlspecialchars($course['subject']) ?></td>
                            <td><?= htmlspecialchars($course['subject_code']) ?></td>
                            <td>
                                <?php 
                                    $grade = getGradeById($course['grade'], $conn);
                                    echo htmlspecialchars($grade['grade_code'].'-'.$grade['grade']);
                                ?>
                            </td>
                            <td>
                                <a href="course-edit.php?course_id=<?= $course['subject_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Delete Course Form -->
            <div class="mt-4">
                <h5>Delete Course</h5>
                <form action="course-delete.php" method="POST" class="d-flex gap-2">
                    <input type="number" name="course_id" class="form-control delete-box" placeholder="Enter Course ID" required>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>

        <?php } else { ?>
            <div class="alert alert-info w-50 mt-5" role="alert">
                No courses available.
            </div>
        <?php } ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(8) a").addClass('active');
        });
    </script>
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
