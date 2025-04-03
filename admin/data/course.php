<?php  

// Get all courses
function getAllCourses($conn) {
   $sql = "SELECT * FROM subject";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     return $stmt->fetchAll();
   } else {
    return [];
   }
}

// Check if course exists
function courseExists($id, $conn) {
   $sql = "SELECT subject_id FROM subject WHERE subject_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);
   return $stmt->rowCount() > 0;
}

// Delete course
function removeCourse($id, $conn) {
   $sql = "DELETE FROM subject WHERE subject_id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]);
}
?>
