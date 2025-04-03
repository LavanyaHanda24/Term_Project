<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin' && isset($_POST['delete_id'])) {
        include "../DB_connection.php";
        include "data/class.php";

        $entered_id = $_POST['delete_id'];

        // Validate if the class exists
        $class = getClassById($entered_id, $conn);

        if ($class != 0) {
            if (removeClass($entered_id, $conn)) {
                $sm = "Successfully deleted!";
                header("Location: class.php?success=$sm");
                exit;
            } else {
                $em = "Unknown error occurred";
                header("Location: class.php?error=$em");
                exit;
            }
        } else {
            $em = "Please input correct ID for delete";
            header("Location: class.php?error=$em");
            exit;
        }
    } else {
        header("Location: class.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
