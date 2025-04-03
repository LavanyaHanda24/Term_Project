<?php  
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        if (isset($_GET['searchKey'])) {

            $search_key = $_GET['searchKey'];
            include "../DB_connection.php";
            include "data/teacher.php";
            include "data/subject.php";
            include "data/grade.php";
            $teachers = searchTeachers($search_key, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Search Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>

    <?php if ($teachers != 0) { ?>
        <div class="container mt-5">
            <a href="teacher-add.php" class="btn btn-dark">Add New Teacher</a>

            <form action="teacher-search.php" method="get" class="mt-3 n-table">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="searchKey" value="<?=htmlspecialchars($search_key)?>" placeholder="Search...">
                    <button class="btn btn-primary">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger mt-3 n-table" role="alert">
                    <?=htmlspecialchars($_GET['error'])?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-info mt-3 n-table" role="alert">
                    <?=htmlspecialchars($_GET['success'])?>
                </div>
            <?php } ?>

            <div class="table-responsive">
                <table class="table table-bordered mt-3 n-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($teachers as $teacher) { $i++; ?>
                            <tr>
                                <th><?=$i?></th>
                                <td><?=$teacher['teacher_id']?></td>
                                <td><a href="teacher-view.php?teacher_id=<?=$teacher['teacher_id']?>"><?=$teacher['fname']?></a></td>
                                <td><?=$teacher['lname']?></td>
                                <td><?=$teacher['username']?></td>
                                <td>
                                    <?php 
                                    $s = '';
                                    if (!empty($teacher['subjects'])) {
                                        $subjects = explode(',', trim($teacher['subjects']));
                                        foreach ($subjects as $subject) {
                                            $s_temp = getSubjectById($subject, $conn);
                                            if ($s_temp != 0) 
                                                $s .= $s_temp['subject_code'] . ', ';
                                        }
                                    }
                                    echo rtrim($s, ', ');
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $g = '';
                                    if (!empty($teacher['grades'])) {
                                        $grades = explode(',', trim($teacher['grades']));
                                        foreach ($grades as $grade) {
                                            $g_temp = getGradeById($grade, $conn);
                                            if ($g_temp != 0) 
                                                $g .= $g_temp['grade_code'] . '-' . $g_temp['grade'] . ', ';
                                        }
                                    }
                                    echo rtrim($g, ', ');
                                    ?>
                                </td>
                                <td>
                                    <a href="teacher-edit.php?teacher_id=<?=$teacher['teacher_id']?>" class="btn btn-warning">Edit</a>
                                    <button class="btn btn-danger delete-btn" data-id="<?=$teacher['teacher_id']?>">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="deleteForm" action="teacher-delete.php" method="POST">
                                <label for="teacherId">Enter Teacher ID to Confirm:</label>
                                <input type="text" id="teacherId" name="teacher_id" class="form-control" required>
                                <input type="hidden" id="hiddenTeacherId" name="hidden_teacher_id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="deleteForm" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php } else { ?>
        <div class="alert alert-info m-5" role="alert">
            No Results Found
            <a href="teacher.php" class="btn btn-dark">Go Back</a>
        </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function() {
            $("#navLinks li:nth-child(2) a").addClass('active');

            $(".delete-btn").on("click", function() {
                let teacherId = $(this).data("id");
                $("#hiddenTeacherId").val(teacherId);
                $("#deleteModal").modal("show");
            });

            $("#deleteForm").on("submit", function(e) {
                let enteredId = $("#teacherId").val();
                let actualId = $("#hiddenTeacherId").val();
                if (enteredId !== actualId) {
                    alert("Entered ID does not match the teacher ID!");
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
<?php 
        } else {
            header("Location: teacher.php");
            exit;
        } 
    } else {
        header("Location: ../login.php");
        exit;
    } 
} else {
    header("Location: ../login.php");
    exit;
} 
?>
