<?php 
session_start();
if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {

  if ($_SESSION['role'] == 'Admin' && isset($_POST['delete_r_user_id'])) {
     include "../DB_connection.php";
     include "data/registrar_office.php";

     $id = $_POST['delete_r_user_id'];

     // Check if ID exists
     $user = getR_usersById($id, $conn);
     if ($user) {
        if (removeRUser($id, $conn)) {
            $sm = "Successfully deleted!";
            header("Location: registrar-office.php?success=$sm");
            exit;
        } else {
            $em = "Unknown error occurred";
            header("Location: registrar-office.php?error=$em");
            exit;
        }
     } else {
        $em = "Please enter a valid ID for deletion!";
        header("Location: registrar-office.php?error=$em");
        exit;
     }

  } else {
    header("Location: registrar-office.php");
    exit;
  } 
} else {
    header("Location: registrar-office.php");
    exit;
} 
?>
