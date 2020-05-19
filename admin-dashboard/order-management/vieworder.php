<?php
session_start();
include "connection.php";
// Get the orders made by the user.
//$user_id = $_SESSION['user_id'];
$ordernumber = filter_input(INPUT_POST, "orderNumber", FILTER_VALIDATE_INT);

$command = "SELECT *
FROM order_details o
JOIN teamDetails t
WHERE o.order_id = t.order_number AND order_id = $ordernumber";
$stmt = $dbh->prepare($command);
$stmt->execute();
$order = $stmt->fetch();

// Prep the data to show all the producs and their sum.
$players = explode(',', $order['player_name']);
$kits = explode(',', $order['playerkit_number']);
$products = explode(',', $order['product_name']);
$quantity = explode(',', $order['quantity']);
$colors = explode(',', $order['color']);
$size = explode(',', $order['size']);
$cost = explode(',', $order['cost']);

$total_cost = 0;


$total_players = count($players);
$summary = [];


for ($index = 0; $index < count($players); ++$index) {
    $data = array(
        'playername' => $players[$index],
        'kitnumber' => $kits[$index],
        'product' => $products[$index],
        'quantity' => $quantity[$index],
        'color' => $colors[$index],
        'size' => $size[$index],
        'cost' => $cost[$index]
    );
    $total_cost += intval(str_replace('$', '', $data['cost'])) * intval($data['quantity']);
    $summary[] = $data;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Niko Apparel: Order Details</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"  type="text/css" href="main.css">
        <link rel="stylesheet"  type="text/css" href="styling.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            ul li{
                list-style-type: none;
            }

        </style>
    </head>
    <body>


        <div id="m">

            <?php require('navbar.php'); ?>

            <div class="margin-div">
                <h1>
                    <b>Order #<?php echo $order['order_id']; ?></b>
                </h1><hr>
                

                <h3><strong>Team Details</strong></h3>

                <div class="div-team">
                    Team: <?php echo $order['team_name']; ?><br>
                Coach: <?php echo $order['team_coachname']; ?><br>
                Manager: <?php echo $order['manager_name']; ?><br>
                Email: <?php echo $order['team_email']; ?>
                </div>

                <hr>


                <h4><strong>Players & Products</strong></h4>
                <br>

                <table class='table table-striped'>
                    <tr>
                        <th>No.</th>
                        <th>Player</th>
                        <th>Kit No.</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($summary as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $item['playername']; ?></td>
                            <td><?php echo $item['kitnumber']; ?></td>
                            <td><?php echo $item['product']; ?></td>
                            <td><?php echo $item['color']; ?></td>
                            <td><?php echo $item['size']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$ <?php echo $item['cost']; ?></td>
                            <td>$ <?php echo intval($item['cost']) * intval($item['quantity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <h3>Total: <span class='text text-success'>$ <?php echo $total_cost; ?></span></h3>

                <br>
                <h4>Products by their sizes</h4>

                <table class='table table-bordered'>
                    <tr>
                        <th>No.</th>
                        <th>Product</th>
                        <th>XS</th>
                        <th>S</th>
                        <th>SM</th>
                        <th>M</th>
                        <th>L</th>
                        <th>XL</th>
                        <th>XLL</th>  
                        <th>XLLL</th>  
                        <th>Total</th>
                    </tr>
                    <?php foreach ($summary as $index => $item): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $item['product']; ?></td>
                            <td><?php echo trim($item['size']) == 'XS' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'S' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'SM' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'M' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'L' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'XL' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'XLL' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo trim($item['size']) == 'XLLL' ? $item['quantity'] : 0; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>





                <?php
                echo"<p><a href='orderSummary.php'><input type='submit' id='home' value='Return to Order List'></a></p>";
                ?>
            </div>
 <?php include 'footer.php'; ?>

    </body>
</html>
