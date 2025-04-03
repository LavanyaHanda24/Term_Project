<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        include "../DB_connection.php";
        include "data/course.php";

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
            $id = trim($_POST['course_id']);

            // Validate if the course ID exists
            $check_sql = "SELECT * FROM subject WHERE subject_id = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->execute([$id]);

            if ($stmt->rowCount() == 1) {
                // Delete the course
                if (removeCourse($id, $conn)) {
                    $sm = "Successfully deleted!";
                    header("Location: course.php?success=$sm");
                    exit;
                } else {
                    $em = "Error occurred while deleting.";
                    header("Location: course.php?error=$em");
                    exit;
                }
            } else {
                $em = "Please input a correct Course ID for deletion.";
                header("Location: course.php?error=$em");
                exit;
            }
        } else {
            header("Location: course.php");
            exit;
        }
    } else {
        header("Location: course.php");
        exit;
    }
} else {
    header("Location: course.php");
    exit;
}
?>
