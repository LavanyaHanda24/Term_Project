<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/section.php";
       $sections = getAllSections($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include "inc/navbar.php"; ?>
    
    <div class="container mt-5">
        <a href="section-add.php" class="btn btn-dark">Add New Section</a>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger mt-3"><?= $_GET['error'] ?></div>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-info mt-3"><?= $_GET['success'] ?></div>
        <?php } ?>

        <?php if ($sections != 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($sections as $section) { $i++; ?>
                        <tr>
                            <th><?= $i ?></th>
                            <td><?= $section['section'] ?></td>
                            <td>
                                <a href="section-edit.php?section_id=<?= $section['section_id'] ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Delete Section Form (OUTSIDE TABLE) -->
            <div class="mt-4">
                <form action="section-delete.php" method="post">
                    <label for="delete_id" class="form-label"><strong>Enter Section ID to Delete:</strong></label><br>
                    <input type="text" class="form-control w-25 d-inline" name="delete_id" placeholder="Enter ID" required>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

        <?php } else { ?>
            <div class="alert alert-info mt-5">Empty!</div>
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
