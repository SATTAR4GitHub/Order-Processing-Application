<?php
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
$images = [];

// prepare the command
$command = "SELECT product_id, name, price, size, color, image
            FROM product ORDER BY product_id";
$stmt = $dbh->prepare($command);
$stmt->execute();


//Fetch and store the order data
while ($row = $stmt->fetch()) {
    array_push($orderids, $row['product_id']);
    array_push($custnames, $row['name']);
    array_push($orderdates, $row['price']);
    array_push($prices, $row['size']);
    array_push($statuses, $row['color']);
    array_push($images, $row['image']);
}
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel: Manage Product </title>
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


            <h2>Product Summary</h2>
            <h3><a href="create.php">Add New Product</a></h3>

            <div class="margin-div">
                <?php
                //display blogs 
                echo "<table class='table table-striped'>";
                echo "<tr> "
                . "<th scope='col'>ProductID</th>"
                . "<th scope='col'>Product Name</th>"
                . "<th scope='col'>Price</th>"
                . "<th scope='col'>Size</th>"
                . "<th scope='col'>Color</th>"
                . "<th scope='col'></th>"
                . "</tr>";

                for ($i = 0; $i < count($orderids); $i++) {
                    echo "<tr>";
                    //$j = $i + 1;
                    echo "<td>$orderids[$i]</td>"
                    . "<td>$custnames[$i]</td>"
                    . "<td>$$orderdates[$i]</td>"
                    . "<td>$prices[$i]</td>"
                    . "<td> $statuses[$i]</td>";

// Update order 
                    echo "<td>";
                    echo"<form action = 'update.php' method = 'post'>";
                    echo "<input type = 'hidden' name = 'productNumber' value = $orderids[$i]>";
                    echo "<button type = 'submit' class = 'buttonProd'>Edit</button>";
                    echo"</form>";

// Delete order 

                    echo"<form action = 'delete.php'  method = 'post'>";
                    echo "<input type = 'hidden' name = 'productNumber' value = $orderids[$i]>";
                    echo "<button type = 'submit' class = 'btn btn-danger'>Delete</button>";
                    echo"</form>";
                    echo"</td>";

                    echo "</tr>";
                }
                echo "</table>";
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