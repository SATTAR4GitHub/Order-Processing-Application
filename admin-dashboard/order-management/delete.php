<?php
/*
 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();
include "connection.php";

$deleteOrderID = filter_input(INPUT_POST, "orderNumber", FILTER_VALIDATE_INT);

//DELETE FROM Student, Enrollment USING Student INNER JOIN Enrollment ON 
//Student.studentId = Enrollment.studentId  WHERE Student.studentId= 51

$sql = "DELETE FROM order_details,
teamDetails USING order_details INNER JOIN teamDetails ON order_details.order_id = teamDetails.order_number WHERE order_id =?";
$stmt = $dbh->prepare($sql);
$result = $stmt->execute([$deleteOrderID]);
if ($result)
    $message = "Successfully deleted!";
else
    $message = "Sorry, can't delete!"
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet"  type="text/css" href="styling.css">
    </head>
    <body>
        <?php
        echo"<p><h3>$message</h3></p>";
        echo"<p id='tryAgain'><a href='orderSummary.php'>Return to Order List</a></p>";
        ?>
        
    </body>
</html>
