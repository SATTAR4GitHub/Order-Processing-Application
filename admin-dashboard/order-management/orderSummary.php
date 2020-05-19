<?php
/*
 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();

if (isset($_POST["userid"]) and isset($_POST["password"])) {
    if ($_POST["userid"] === "admin" and $_POST["password"] === "admin123") {
        $_SESSION["userid"] = $_POST["userid"];
        //$_session["password"] = $_POST["password"];
    } else {
        session_unset();
        session_destroy();
    }
}
?>
<?php
include "connection.php";
$orderids = [];
$custnames = [];
$orderdates = [];
$prices = [];
$statuses = [];
$total;

// prepare the command
$command = "SELECT o.order_id, o.orderTime, o.cost, o.order_status, t.team_name
FROM order_details o
JOIN teamDetails t
WHERE o.order_id = t.order_number";
$stmt = $dbh->prepare($command);
$stmt->execute();


//Fetch and store the order data
while ($row = $stmt->fetch()) {
    array_push($orderids, $row['order_id']);
    array_push($custnames, $row['team_name']);
    array_push($orderdates, $row['orderTime']);
    array_push($prices, $row['cost']);
    array_push($statuses, $row['order_status']);
}

//Search field section 
$searchOrderids = [];
$searchCustomerNames = [];
$searchOrderDates = [];
$searchPrices = [];
$searchStatuses = [];
if (isset($_POST['search'])) {
    $orderStatus = filter_input(INPUT_POST, "search", FILTER_SANITIZE_SPECIAL_CHARS);

    $command = "SELECT o.order_id, o.orderTime, o.cost, o.order_status, t.team_name
FROM order_details o
JOIN teamDetails t
WHERE o.order_id = t.order_number AND o.order_status LIKE ?";
    $stmt = $dbh->prepare($command);
    $stmt->execute([$orderStatus]);
    while ($row = $stmt->fetch()) {
        array_push($searchOrderids, $row['order_id']);
        array_push($searchCustomerNames, $row['team_name']);
        array_push($searchOrderDates, $row['orderTime']);
        array_push($searchPrices, $row['cost']);
        array_push($searchStatuses, $row['order_status']);
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel</title>
        <meta charset="UTF-8">
        <link rel="stylesheet"  type="text/css" href="main.css">
        <link rel="stylesheet"  type="text/css" href="styling.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <script>
        function delete_order()
        {
            var conf = confirm("Are you sure you want to delete this order? This action can't be undone once click 'OK'.");
            if (conf) {
                document.getElementById("deleteForm").action;
                document.getElementById("deleteForm").submit();
            } else {
                return conf;
            }
        }

    </script>

    <body >
        <?php
        if (isset($_SESSION["userid"])) {
            ?>

            <?php require('navbar.php'); ?>

            <h2 style="margin-bottom: 25px;">Order Summary</h2>

            <div class="container-fluid">
                <form  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="searchform">
                    <select type="text" name="search" class="customizedField">
                        <option disabled selected> Filter by order status </option>
                        <option> Completed </option>
                        <option> Incomplete </option> 
                        <option> Shipped </option>
                        <option> Processing</option>
                        <option> Canceled </option>
                    </select>

                    <input type="submit" value="Filter" class = 'btn btn-primary'> <span>&nbsp;</span> | <span>&nbsp;</span>


                    <?php
                    $page = $_SERVER['PHP_SELF'];
                    print "<a href=\"$page\" class = 'btn btn-primary'>All Orders</a>";
                    ?>
                </form>
            </div>


            <div class="margin-div">
                <?php
                //display blogs 
                if (!isset($_POST["search"])) {
                    echo "<table class='table table-striped'>";
                    echo "<tr> "
                    . "<th scope='col'>Order#</th>"
                    . "<th scope='col'>Team Name</th>"
                    . "<th scope='col'>Order Date</th>"
                    //. "<th scope='col'>Price</th>"
                    . "<th scope='col'>Order Status</th>"
                    . "<th scope='col'></th>"
                    . "<th scope='col'></th>"
                    . "<th scope='col'></th>"
                    . "</tr>";

                    for ($i = 0; $i < count($orderids); $i++) {


                        echo "<tr>";
                        echo "<td>$orderids[$i]</td>"
                        . "<td>$custnames[$i]</td>"
                        . "<td>$orderdates[$i]</td>"
                        //. "<td>$$prices[$i]</td>"
                        . "<td> $statuses[$i]</td>";
//Order details
                        echo "<td>";
                        echo"<form action = 'vieworder.php' method = 'post' >";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $orderids[$i]>";
                        echo "<input type = 'submit' value = 'Details' class='btn btn-success'>";
                        echo"</form>";
                        echo "</td>";
// Update order 
                        echo "<td>";
                        echo"<form action = 'update.php' method = 'post'>";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $orderids[$i]>";
                        echo "<input type = 'submit' value = 'Edit' class='btn btn-info'>";
                        echo"</form>";
                        echo "</td>";
// Delete order 
                        echo "<td>";
                        echo"<form action = 'delete.php'  method = 'post'>";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $orderids[$i]>";
                        echo "<button type = 'submit' class = 'btn btn-danger'>Delete</button>";
                        echo"</form>";
                        echo"</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
//Search result display **********************************************************************************
                    echo "<table class='table table-striped'>";
                    echo "<tr> "
                    . "<th scope='col'>Order#</th>"
                    . "<th scope='col'>Team Name</th>"
                    . "<th scope='col'>Order Date</th>"
                    //. "<th scope='col'>Price</th>"
                    . "<th scope='col'>Order Status</th>"
                    . "<th scope='col'></th>"
                    . "<th scope='col'></th>"
                    . "<th scope='col'></th>"
                    . "</tr>";

                    for ($i = 0; $i < count($searchOrderids); $i++) {
                        echo "<tr>";
                        echo "<td>$searchOrderids[$i]</td>"
                        . "<td>$searchCustomerNames[$i] </td>"
                        . "<td>$searchOrderDates[$i]</td> "
                       // . "<td>$$$searchPrices[$i]</td>"
                        . "<td>$searchStatuses[$i]</td>";
//View order
                        echo "<td>";
                        echo"<form action = 'vieworder.php' method = 'post'>";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $searchOrderids[$i]>";
                        echo "<input type = 'submit' value = 'Details' class='btn btn-success'>";
                        echo"</form>";
                        echo "</td>";
// Update order
                        echo "<td>";
                        echo"<form action = 'update.php' method = 'post'>";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $searchOrderids[$i]>";
                        echo "<input type = 'submit' value = 'Edit' class='btn btn-info'>";
                        echo"</form>";
                        echo "</td>";
// Delete order 
                        echo "<td>";
                        echo"<form action = 'delete.php' method = 'post' >";
                        echo "<input type = 'hidden' name = 'orderNumber' value = $searchOrderids[$i]>";
                        echo "<input type = 'submit' value = 'Delete' id='trash' class = 'btn btn-danger'>";
                        echo"</form>";
                        echo"</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } else {
                echo"<h1>Login Error! Access denied.</h1>";
                echo"<p id = 'tryAgain'><a href = 'https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/index.html'>Try Again</a</p>";
            }


            //  *********************Footer*********************** 
            ?>

        </div>
            <?php include 'footer.php'; ?>
    </body>
</html>

