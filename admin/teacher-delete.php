<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin' && isset($_POST['teacher_id'])) {
        include "../DB_connection.php";
        include "data/teacher.php";

        $id = $_POST['teacher_id'];
        $teacher = getTeacherById($id, $conn);
        if ($teacher) {
            if (removeTeacher($id, $conn)) {
                $sm = "Successfully deleted!";
                header("Location: teacher.php?success=$sm");
                exit;
            } else {
                $em = "Unknown error occurred";
                header("Location: teacher.php?error=$em");
                exit;
            }
        } else {
            $em = "Please input correct ID for deletion";
            header("Location: teacher.php?error=$em");
            exit;
        }
    } else {
        header("Location: teacher.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
