<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    
    if ($_SESSION['role'] == 'Admin' && isset($_POST['delete_id'])) {
        include "../DB_connection.php";
        include "data/student.php";

        $entered_id = $_POST['delete_id'];
        $student = getStudentById($entered_id, $conn);

        if ($student) {
            if (removeStudent($entered_id, $conn)) {
                $sm = "Student successfully deleted!";
                header("Location: student.php?success=$sm");
                exit;
            } else {
                $em = "Error deleting student. Please try again.";
                header("Location: student.php?error=$em");
                exit;
            }
        } else {
            $em = "Invalid Student ID! Please enter a correct ID.";
            header("Location: student.php?error=$em");
            exit;
        }
    } else {
        header("Location: student.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
