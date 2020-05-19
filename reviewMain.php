<?php
//stating the session
session_start();
include 'connection.php';

// Need to login to access this page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

//$orderIds = isset($_SESSION["orderID"]);      //storing the session object to the variable access
// make sure the GET parameter is set
$orderIds = filter_input(INPUT_POST, "orderID", FILTER_SANITIZE_SPECIAL_CHARS);

$teamDetails = filter_input(INPUT_POST, "teamDetails", FILTER_SANITIZE_SPECIAL_CHARS);

$teamOrder = filter_input(INPUT_POST, "teamOrder", FILTER_SANITIZE_SPECIAL_CHARS);


// create coin data and validate parameters
$teamname = filter_input(INPUT_POST, "teamname", FILTER_SANITIZE_SPECIAL_CHARS);
$teamcoachname = filter_input(INPUT_POST, "teamcoachname", FILTER_SANITIZE_SPECIAL_CHARS);
$managername = filter_input(INPUT_POST, "managername", FILTER_SANITIZE_SPECIAL_CHARS);
$teamemail = filter_input(INPUT_POST, "teamemail", FILTER_SANITIZE_EMAIL);

$costzz = "";

if (isset($_POST["playername"]) && is_array($_POST["playername"])) {
    $playername = implode(", ", $_POST["playername"]);
}

if (isset($_POST["playerkit"]) && is_array($_POST["playerkit"])) {
    $playerkitnumber = implode(", ", $_POST["playerkit"]);
}

if (isset($_POST["costzz"]) && is_array($_POST["costzz"])) {
    $costzz = implode(", ", $_POST["costzz"]);
}
if (isset($_POST["products"]) && is_array($_POST["products"])) {
    $products = implode(", ", $_POST["products"]);
}

if (isset($_POST["Quantity"]) && is_array($_POST["Quantity"])) {
    $quantity = implode(", ", $_POST["Quantity"]);
}

if (isset($_POST["colour"]) && is_array($_POST["colour"])) {
    $colour = implode(", ", $_POST["colour"]);
}
if (isset($_POST["size"]) && is_array($_POST["size"])) {
    $size = implode(", ", $_POST["size"]);
}




if ($teamname !== NULL && $teamcoachname !== NULL && $managername !== NULL && $teamemail !== NULL && $playerkitnumber !== NULL) {
// do the insert

    $command = "UPDATE `orderform` SET `teamname`=?,`teamcoachname`=?,`managername`=?,`teamemail`=?,`playername`=?,`playerkitnumber`=?,`products`=?,`quantity`=?,`color`=?,`size`=? WHERE `ordernumber`=?";
    $stmt = $dbh->prepare($command);
    $result = $stmt->execute([$teamname, $teamcoachname, $managername, $teamemail, $playername, $playerkitnumber, $products, $quantity, $colour, $size, $orderIds]);

    if ($result) {
        $msg = "Update successful";
    } else {
        $msg = "Update failed";
    }
} else {
    $msg = "Parameters not set";
}


/////////////////


if ($teamname !== NULL && $teamcoachname !== NULL && $managername !== NULL && $teamemail !== NULL && $playerkitnumber !== NULL) {
// do the insert

    $command2 = "UPDATE `order_details` SET `player_name`=?,`playerkit_number`=?,`product_name`=?,`cost`=?,`quantity`=?,`color`=?,`size`=? WHERE `order_id` = ?";
    $stmt2 = $dbh->prepare($command2);
    $result2 = $stmt2->execute([$playername, $playerkitnumber, $products, $costzz, $quantity, $colour, $size, $teamOrder]);

    if ($result2) {
        $msg = "Update successful";
    } else {
        $msg = "Update failed";
    }
} else {
    $msg = "Parameters not set";
}

//////////////////


if ($teamname !== NULL && $teamcoachname !== NULL && $managername !== NULL && $teamemail !== NULL && $playerkitnumber !== NULL) {
// do the insert


    $command45 = "UPDATE `teamDetails` SET `team_name`=?,`team_coachname`=?,`manager_name`=?,`team_email`=? WHERE `order_number` = ?";
    $stmt45 = $dbh->prepare($command45);
    $result3 = $stmt45->execute([$teamname, $teamcoachname, $managername, $teamemail, $teamDetails]);

    if ($result3) {
        $msg = "Update successful";
    } else {
        $msg = "Update failed";
    }
} else {
    $msg = "Parameters not set";
}






/////
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Niko Apparel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>





        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Add a gray background color and some padding to the footer */
            footer {
                background-color: #f2f2f2;
                padding: 25px;
            }


            body{
                background-color: whitesmoke;
            }

            form{

                background-color: white;}


            ul li{
                list-style-type: none;
            }

            #Jump{
                margin-bottom: 150px;
            }


        </style>










        <script>
            $(document).ready(function () {
                var i = 1;


                $('#add').click(function () {
                    i++;

                    $('.payerBlockz').append('<div class="thumbnail" id="row' + i + '"><div class="form-group"><label for="exampleInputTeamCoach">Player Name</label><input type="text" class="form-control" name="playername[]" required></div> <div class="form-group"> <label for="exampleInputTeamCoach">Player Kit Number</label><input type="number" class="form-control" name="playerkit[]" required></div><div class="form-group"><figure>   <img src="images/Mainproduct3" alt="product1" width="180" height="180" id="imag1' + i + '" class="img-thumbnail"><figcaption>Product</figcaption> </figure></figure><label for="exampleInputTeamCoach" >Cost = <span id="cost2' + i + '">$18.00</span></label></div><div class="form-group"><label class="form-sub-label" for="select" style="min-height:13px" aria-hidden="false"> Products </label><select class="form-dropdown" name="products[]" id="list' + i + '" required> <option value="None">None</option><option  value="BCC Black T-Shirt">BCC Black T-shirt </option><option value="GHACPom">GHACPom</option><option selected value="BrantCycling Vest">BrantCycling Vest</option> <option value="HLA-Pants">HLA-Pants</option> <option value="HFA-Hat">HFA-Hat</option> <option value="V-Escadrille">V-Escadrille</option> <option value="V-E3 Jacket">V-E3 Jacket</option></select><label class="form-sub-label" for="input_16_quantity_1002_0" style="min-height:13px" aria-hidden="false"> Quantity </label><select class="form-dropdown" name="Quantity" required><option value="None"> None </option><option value="1"> 1 </option><option value="2"> 2 </option><option value="3"> 3 </option><option value="4"> 4 </option><option value="5"> 5 </option><option value="6"> 6 </option><option value="7"> 7 </option><option value="8"> 8 </option><option value="9"> 9 </option><option value="10"> 10 </option></select><label class="form-sub-label" for="input_16_custom_1002_1" style="min-height:13px" aria-hidden="false"> Color </label><select class="form-dropdown" name="colour" required><option value="None"> None </option><option value="Green"> Green </option><option value="Blue"> Blue </option><option value="Red"> Red </option><option value="Black"> Black </option><option value="Magenta"> Magenta </option></select><label class="form-sub-label" for="input_16_custom_1002_2" style="min-height:13px" aria-hidden="false">Size </label><select class="form-dropdown" name="size" required><option value="None"> None </option><option value="XS"> XS </option><option value="S"> S </option><option value="M"> M </option><option value="L"> L </option><option value="XL"> XL </option><option value="XXL"> XXL </option><option value="XXXL"> XXXL </option></select></div><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Remove Player</button></div>');




                });

                $(document).on('click', '.btn_remove', function () {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });







                $("#productList").change(function () {

                    if ($(this).val() == "V-E3 Jacket") {
                        document.getElementById("imageSelect").src = "images/Mainproduct7";
                        $("#cost").text("$20.00");
                        //$("#cost").attr("value", "$20.00");
                    } else if ($(this).val() == "V-Escadrille") {
                        document.getElementById("imageSelect").src = "images/Mainproduct6";
                        $("#cost").text("$15.00");
                        //$("#cost").attr("value", "$15.00");
                    } else if ($(this).val() == "HFA-Hat") {
                        document.getElementById("imageSelect").src = "images/Mainproduct5";
                        $("#cost").text("$10.00");
                        //$("#cost").attr("value", "$10.00");
                    } else if ($(this).val() == "HLA-Pants") {
                        document.getElementById("imageSelect").src = "images/Mainproduct4";
                        $("#cost").text("$14.00");
                        //$("#cost").attr("value", "$14.00");
                    } else if ($(this).val() == "BrantCycling Vest") {
                        document.getElementById("imageSelect").src = "images/Mainproduct3";
                        $("#cost").text("$18.00");
                        //$("#cost").attr("value", "$18.00");
                    } else if ($(this).val() == "GHACPom") {
                        document.getElementById("imageSelect").src = "images/Mainproduct2";
                        $("#cost").text("$13.00");
                        //$("#cost").attr("value", "$13.00");
                    } else if ($(this).val() == "BCC Black T-Shirt") {
                        document.getElementById("imageSelect").src = "images/Mainproduct1";
                        $("#cost").text("$19.00");
//                        $("#cost").attr("value", "$19.00");
                    }


                });


                $("#productListz").change(function () {

                    if ($(this).val() == "V-E3 Jacket") {
                        document.getElementById("imagez").src = "images/Mainproduct7";
                        $("#costz").text("$20.00");
//                        $("#costz").attr("value", "$20.00");

                    } else if ($(this).val() == "V-Escadrille") {
                        document.getElementById("imagez").src = "images/Mainproduct6";
                        $("#costz").text("$15.00");
//                        $("#costz").attr("value", "$15.00");

                    } else if ($(this).val() == "HFA-Hat") {
                        document.getElementById("imagez").src = "images/Mainproduct5";
                        $("#costz").text("$10.00");
//                        $("#costz").attr("value", "$10.00");

                    } else if ($(this).val() == "HLA-Pants") {
                        document.getElementById("imagez").src = "images/Mainproduct4";
                        $("#costz").text("$14.00");
//                        $("#costz").attr("value", "$14.00");

                    } else if ($(this).val() == "BrantCycling Vest") {
                        document.getElementById("imagez").src = "images/Mainproduct3";
                        $("#costz").text("$18.00");
//                        $("#costz").attr("value", "$18.00");

                    } else if ($(this).val() == "GHACPom") {
                        document.getElementById("imagez").src = "images/Mainproduct2";
                        $("#costz").text("$13.00");
//                        $("#costz").attr("value", "$13.00");

                    } else if ($(this).val() == "BCC Black T-Shirt") {
                        document.getElementById("imagez").src = "images/Mainproduct1";
                        $("#costz").text("$19.00");
                        //$("#costz").attr("value", "$19.00");

                    }


                });

                var initial = 1;

                $('#add').click(function () {



                    initial++;
                    $('#list' + initial).change(function () {

                        if ($(this).val() == "V-E3 Jacket") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct7";
                            $('#cost2' + initial).text("$20.00");
                            //$('#cost2' + initial).attr("value", "$20.00");
                        } else if ($(this).val() == "V-Escadrille") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct6";
                            $('#cost2' + initial).text("$15.00");
                            //$('#cost2' + initial).attr("value", "$15.00");
                        } else if ($(this).val() == "HFA-Hat") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct5";
                            $("#cost2" + initial).text("$10.00");
                            //$('#cost2' + initial).attr("value", "$10.00");
                        } else if ($(this).val() == "HLA-Pants") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct4";
                            $("#cost2" + initial).text("$14.00");
                            //$('#cost2' + initial).attr("value", "$14.00");
                        } else if ($(this).val() == "BrantCycling Vest") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct3";
                            $("#cost2" + initial).text("$18.00");
                            //$('#cost2' + initial).attr("value", "$18.00");
                        } else if ($(this).val() == "GHACPom") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct2";
                            $("#cost2" + initial).text("$13.00");
                            // $('#cost2' + initial).attr("value", "$13.00");
                        } else if ($(this).val() == "BCC Black T-Shirt") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct1";
                            $("#cost2" + initial).text("$19.00");
                            //$('#cost2' + initial).attr("value", "$19.00");
                        }



                    });



                });


            });
        </script>




    </head>
    <body>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" id="header" href="#">Niko Apparel Systems</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php" id="home">Home</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="active"><a href="formPage.php"  id="order">Create Order</a></li>
                        <?php endif; ?>
                        <li><a href="http://nikoapparel.ca/contact/" id="contact">Contact</a></li>
                         <li><a href="admin-dashboard/index.html" id="manage">Admin Panel</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login to create orders</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>



        <?php
//        echo "<h1  class='p-3 mb-2 bg-success text-white'>$msg</h1>";
//        echo "<h1  class='p-3 mb-2 bg-success text-white'>Session order Id no = $orderIds</h1>";
        ?>
        <div class="jumbotron text-center" id="Jump">
            <h1 class="display-3">Thank You for your Order!</h1>
            <p class="lead"><strong>Order no# <?php echo $orderIds; ?></strong> has successfully completed</p>
            <hr>
            <p>
                Having trouble? <a href="http://nikoapparel.ca/contact/">Contact us</a>
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-sm" href="index.php" role="button">Continue to homepage</a>
            </p>
        </div>



        <div class="mt-5 pt-5 pb-5 footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-xs-12 about-company">
                        <h2>Niko Apparel</h2>
                        <p class="pr-5 text-white-50">Since 1996 Niko has had the privilege of bringing high quality, custom made apparel to its clients, made in Canada.</p>
                        <p><a href="#"><i class="fa fa-facebook-square mr-1"></i></a><a href="#"><i class="fa fa-linkedin-square"></i></a></p>
                    </div>
                    <div class="col-lg-3 col-xs-12 links">
                        <h4 class="mt-lg-0 mt-sm-3">Links</h4>
                        <ul class="m-0 p-0">

                            <li>- <a href="http://nikoapparel.ca/"> Main Home Page</a></li>
                            <li>- <a href="http://nikoapparel.ca/accessibility/"> Accessibility</a></li>
                            <li>- <a href="http://nikoapparel.ca/contact/"> Contact</a></li>
                            <li>- <a href="http://nine-o.ca/"> Nine-O Website</a></li>
                            <li>- <a href="https://www.aegisimpact.com/"> Aegis Website</a></li>

                        </ul>
                    </div>
                    <div class="col-lg-4 col-xs-12 location">
                        <h4 class="mt-lg-0 mt-sm-4">Location</h4>
                        <h5>Niko Apparel </h5>
                        <p>61 Hempstead Drive
                            Hamilton, ON L8W 2Y6
                            Canada
                        </p>
                        <p class="mb-0"><i class="fa fa-phone mr-3"></i>Phone: (905) 318-0845</p>
                        <p><i class="fa fa-envelope-o mr-3"></i><a href = "mailto: info@nikoapparel.ca">info@nikoapparel.ca</a></p>
                    </div>


                </div>
                <div class="row mt-5">
                    <div class="col copyright">
                        <p class=""><small class="text-white-50">© 2020. All Rights Reserved.</small></p>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>

