<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/grade.php";

        if (isset($_POST['delete_id'])) {
            $id = $_POST['delete_id'];
            $grade = getGradeById($id, $conn);

            if ($grade) {
                if (removeGrade($id, $conn)) {
                    $sm = "Grade successfully deleted!";
                    header("Location: grade.php?success=$sm");
                    exit;
                } else {
                    $em = "Error deleting grade. Please try again.";
                    header("Location: grade.php?error=$em");
                    exit;
                }
            } else {
                $em = "Invalid ID! Please enter a correct Grade ID.";
                header("Location: grade.php?error=$em");
                exit;
            }
        }
    } else {
        header("Location: grade.php");
        exit;
    }
} else {
    header("Location: grade.php");
    exit;
}
?>
