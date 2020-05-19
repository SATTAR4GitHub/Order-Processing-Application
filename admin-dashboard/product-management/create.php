<?php
/*
 */
session_start();

include "connection.php";

$v1 = filter_input(INPUT_POST, "prod_name", FILTER_SANITIZE_SPECIAL_CHARS);
$v2 = filter_input(INPUT_POST, "prod_price", FILTER_SANITIZE_SPECIAL_CHARS);
$v3 = filter_input(INPUT_POST, "prod_size", FILTER_SANITIZE_SPECIAL_CHARS);
$v4 = filter_input(INPUT_POST, "prod_color", FILTER_SANITIZE_SPECIAL_CHARS);

//getting the image from the field
//$product_image = $_FILES['product_image']['name'];
//$product_image_tmp = $_FILES['product_image']['tmp_name'];
//move_uploaded_file($product_image_tmp, "product_images/$product_image");

$message = "";
if ($v1 !== NULL && $v2 !== NULL && $v3 !== NULL && $v4 !== NULL) {
// do the insert
    $sql = "INSERT INTO product (name, price, size, color) VALUES (?,?,?,?)";
    $stmt = $dbh->prepare($sql);
    $result = $stmt->execute([$v1, $v2, $v3, $v4]);
    if ($result) {
        $message = "Successfully inserted!";
    } else {
        $message = "Not succesful!";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Niko Apparel: Add New Product</title>
        <meta charset="UTF-8">
        <link rel="stylesheet"  type="text/css" href="main.css">
        <link rel="stylesheet"  type="text/css" href="styling.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>

        <?php require('navbar.php'); ?>

        <?php
        if ($v1 == NULL) {
            ?>
            <div class="margin-div">
                <h1>Create a New Product</h1>

                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Product Name:<sup class="star">*</sup></td>
                            <td><input type="text" size="50" required name="prod_name"  class ='forminput'></td>
                        </tr>
                        <tr>
                            <td>Price:<sup class="star">*</sup> </td>
                            <td><input type="text" size="50" required name="prod_price"  class ='forminput'></td>
                        </tr>
                        <tr>
                            <td>Size:<sup class="star">*</sup> </td>
                            <td><select class = "forminput" name="prod_size" required>
                                    <option selected=""> </option>
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
                            <td>Color: </td>
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
                            <td></td>
                            <td><input type="submit" class="btn btn-primary" value="Submit"></td>
                        </tr>
                    </table>
                </form>

                <p style="margin:40px 0 30px 100px"><a class="btn btn-success" href='productSummary.php'>Return to Product List.</a></p>

                <?php
            } else {
                echo"<h3>$message</h3>";
                echo "<p id='tryAgain'><a href='productSummary.php'>Go Back to Product List.</a></p>";
            }

            ?>
        </div>
        
         <?php include 'footer.php'; ?>
    </body>
</html>
