<?php require_once('includes/access.php'); 
 require_once('includes/logout.php'); 
 require_once('../Connections/database.php'); 
 require_once('includes/functions.php');    

  
  mysqli_select_db($database, $database_database); 
$query_get_duplicates = "SELECT c.id, c.kid_id, c.seat_id, c.subject_id, c.month
                        FROM control c
                        INNER JOIN (
                            SELECT kid_id, seat_id, subject_id, month, MIN(id) as min_id
                            FROM control
                            WHERE month = 4
                            GROUP BY kid_id, seat_id, subject_id, month
                            HAVING COUNT(*) > 1
                        ) dup 
                        ON c.kid_id = dup.kid_id 
                        AND c.seat_id = dup.seat_id
                        AND c.subject_id = dup.subject_id
                        AND c.month = dup.month
                        AND c.id != dup.min_id
                        ORDER BY c.kid_id, c.seat_id, c.subject_id";

$get_duplicates = mysqli_query($database, $query_get_duplicates) or die(mysqli_error($database));

while ($row_duplicates = mysqli_fetch_assoc($get_duplicates)) {
    // Delete all duplicate records except the one with the minimum ID
    $deleteSQL = sprintf("DELETE FROM control WHERE id = %s",
        GetSQLValueString($database, $row_duplicates['id'], "int"));
    mysqli_query($database, $deleteSQL) or die(mysqli_error($database));
}