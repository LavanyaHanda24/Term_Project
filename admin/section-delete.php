<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    
    if ($_SESSION['role'] == 'Admin' && isset($_POST['delete_id'])) {
        include "../DB_connection.php";
        include "data/section.php";

        $entered_id = $_POST['delete_id'];

        // Validate if the section exists
        $section = getSectioById($entered_id, $conn);

        if ($section != 0) {
            if (removeSection($entered_id, $conn)) {
                $sm = "Successfully deleted!";
                header("Location: section.php?success=$sm");
                exit;
            } else {
                $em = "Unknown error occurred";
                header("Location: section.php?error=$em");
                exit;
            }
        } else {
            $em = "Please input correct ID for delete";
            header("Location: section.php?error=$em");
            exit;
        }
    } else {
        header("Location: section.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
