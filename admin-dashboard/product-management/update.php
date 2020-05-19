<?php
/*
 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();
include "connection.php";

$viewid = filter_input(INPUT_POST, "productNumber", FILTER_VALIDATE_INT);
$command = "SELECT * FROM product WHERE product_id  = ?";
$stmtView = $dbh->prepare($command);
$stmtView->execute([$viewid]);



//Retrieve order id from OrderSummary.
$updateid = filter_input(INPUT_POST, "productNumber", FILTER_VALIDATE_INT);
$productno = filter_input(INPUT_POST, "product_no", FILTER_SANITIZE_STRING);


$v1 = filter_input(INPUT_POST, "prod_name", FILTER_SANITIZE_STRING);
$v2 = filter_input(INPUT_POST, "prod_price", FILTER_SANITIZE_STRING);
$v3 = filter_input(INPUT_POST, "prod_size", FILTER_SANITIZE_STRING);
$v4 = filter_input(INPUT_POST, "prod_color", FILTER_SANITIZE_STRING);

$sql = "UPDATE product SET name = '$v1', price = '$v2', size = '$v3', color = '$v4' WHERE product_id = ?";
$stmt = $dbh->prepare($sql);
$result = $stmt->execute([$productno]);
if ($result)
    $message = "Successfully updated!";
else
    $message = "Not Successful"
    ?>  

<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel: Product Update</title>
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
            if ($v3 == NULL) {
                ?>
                <h1>Update Product:</h1>

                <form action="update.php" method="POST">
                    <table>
                        <?php
                        foreach ($stmtView as $row) {

                            echo"<tr>
                            <td>Product Number:</td>
                            <td><input type = 'text' size = '50' name = 'productNo' class = 'forminput' value = '$row[product_id]'  disabled></td>
                            </tr>
                            <tr>
                            <td>Product Name:<sup class='star'>*</sup> </td>
                            <td><input type = 'text' size = '50' name = 'prod_name' class = 'forminput' value = '$row[name]'></td>
                            </tr>
                            <tr>
                            <td>Price:<sup class='star'>*</sup></td>
                            <td><input type = 'text' size = '50' name = 'prod_price' class = 'forminput' value = '$row[price]'></td>
                            </tr>";
                        }
                        ?>
                        <tr>
                            <td>Size:<sup class="star">*</sup> </td>
                            <td><select class = "forminput" name="prod_size" required>
                                    <option selected=""></option>
                                    <option value="XS"> XS </option>
                                    <option value="S"> S </option>
                                    <option value="M"> M </option>
                                    <option value="L"> L </option>
                                    <option value="XL"> XL </option>
                                    <option value="XXL"> XXL </option>
                                    <option value="XXXL"> XXXL </option>                               
                                </select></td>
                        </tr>
                        <tr>
                            <td>Color:<sup class="star">*</sup> </td>
                            <td><select class = "forminput" name="prod_color" required>
                                    <option selected=""></option>
                                    <option value="None"> None </option>
                                    <option value="Green"> Green </option>
                                    <option value="Blue"> Blue </option>
                                    <option value="Red"> Red </option>
                                    <option value="Black"> Black </option>
                                    <option value="Magenta"> Magenta </option>                                
                                </select></td>
                        </tr>
                        
                         <tr>
                            <td>Upload Image:</td>
                            <td><input type="file" name="product_image" class ='forminput'/></td>
                        </tr>
                        
                        <tr><td><br></td></tr>
                        <tr>
                            <td><input type="hidden" name="product_no" value="<?= $updateid ?>"></td>
                            <td><input type="submit" name="btn_submit" class="btn btn-primary" value="Submit"></td>
                        </tr>
                    </table>
                </form>

                <p style="margin:40px 0 30px 100px"><a class="btn btn-success" href='productSummary.php'>Return to Product List</a></p>

                <?php
            } else {
                echo"<p><h3>$message</h3></p>";
                echo"<p id='tryAgain'><a href='productSummary.php'>Back to product List</a></p>";
            }

            ?>
        </div>
        
         <?php include 'footer.php'; ?>
    </body>
</html>