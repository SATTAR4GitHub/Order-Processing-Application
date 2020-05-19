<?php
/*
 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();
include "connection.php";

$deleteProductID = filter_input(INPUT_POST, "productNumber", FILTER_VALIDATE_INT);

$sql = "DELETE FROM product WHERE product_id =?";
$stmt = $dbh->prepare($sql);
$result = $stmt->execute([$deleteProductID]);
if ($result)
    $message = "Your selected product successfully deleted!";
else
    $message = "Sorry, can't delete this product!"
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
        echo"<p id='tryAgain'><a href='productSummary.php'>Go Back to Product List</a></p>";
        ?>
    </body>
</html>
