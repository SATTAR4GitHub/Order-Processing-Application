<?php
/*
 * 

 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();
include "connection.php";

$viewid = filter_input(INPUT_POST, "orderNumber", FILTER_VALIDATE_INT);
$command = "SELECT o.order_id, o.orderTime, o.cost, o.order_status, t.team_name
FROM order_details o
JOIN teamDetails t
WHERE o.order_id = t.order_number AND order_id  = ?";

$stmtView = $dbh->prepare($command);
$stmtView->execute([$viewid]);



//Retrieve order id from OrderSummary.
$updateid = filter_input(INPUT_POST, "orderNumber", FILTER_VALIDATE_INT);
$orderno = filter_input(INPUT_POST, "order_no", FILTER_SANITIZE_STRING);

//$v1 = filter_input(INPUT_POST, "newtitle", FILTER_SANITIZE_STRING);
//$v2 = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
//$v3 = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_STRING);
//$v4 = filter_input(INPUT_POST, "newdate", FILTER_SANITIZE_STRING);
$v5 = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
//$v6 = filter_input(INPUT_POST, "newcontent", FILTER_SANITIZE_STRING);

$sql = "UPDATE order_details SET order_status = '$v5' WHERE order_id = ?";
$stmt = $dbh->prepare($sql);
$result = $stmt->execute([$orderno]);
if ($result)
    $message = "Successfully updated!";
else
    $message = "Not Successful"
    ?>  

<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel: Order Update</title>
        <meta charset="UTF-8">
        <link rel="stylesheet"  type="text/css" href="main.css">
        <link rel="stylesheet"  type="text/css" href="styling.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php require('navbar.php'); ?>
        <div class="margin-div">
            <?php
            if ($v5 == NULL) {
                ?>
                <h1>Update Order:</h1>

                <form action="update.php" method="POST" class="">
                    <table>
                        <?php
                        foreach ($stmtView as $row) {

                            echo"<tr>
                            <td>Order Number:</td>
                            <td><input type = 'text' size = '50' name = 'orderNo' class = 'forminput' value = '$row[order_id]'  disabled></td>
                            </tr>
                            <tr>
                            <td>Team Name: </td>
                            <td><input type = 'text' size = '50' name = 'name' class = 'forminput' value = '$row[team_name]' disabled></td>
                            </tr>
                            <tr>
                            <td>Oder Date:</td>
                            <td><input type = 'text' size = '50' name = 'orderDate' class = 'forminput' value = '$row[orderTime]' disabled></td>
                            </tr>";
                        }
                        ?>
                        <tr>
                            <td>Order Status:<sup class="star">*</sup> </td>
                            <td><select class = "forminput" name="status" required>
                                    <option selected=""></option>
                                    <option>Completed</option>
                                    <option>Processing</option>
                                    <option>Shipped</option>
                                    <option>Pending</option>
                                    <option>Canceled</option>                                
                                </select></td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr>
                            <td><input type="hidden" name="order_no" value="<?= $updateid ?>"></td>
                            <td><input type="submit" name="btn_submit" class="button" value="Submit"></td>
                        </tr>
                    </table>
                </form>
                
                <p style="margin:20px 0 0 0"><a href='orderSummary.php'><input type='submit' id='home' value='Return to Order List'></a></p>

                <?php
            } else {
                echo"<p><h3>$message</h3></p>";
                echo"<p><a href='orderSummary.php'><input type='submit' id='home' value='Return to Order List'></a></p>";
            }

            
            ?>
        </div>
        
         <?php include 'footer.php'; ?>
    </body>
</html>