<?php
//stating the session
session_start();

include 'connection.php';
// Need to login to access this page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$blockRowz = filter_input(INPUT_POST, "blockZ", FILTER_SANITIZE_SPECIAL_CHARS);
// create coin data and validate parameters
$teamname = filter_input(INPUT_POST, "teamname", FILTER_SANITIZE_SPECIAL_CHARS);
$teamcoachname = filter_input(INPUT_POST, "teamcoachname", FILTER_SANITIZE_SPECIAL_CHARS);
$managername = filter_input(INPUT_POST, "managername", FILTER_SANITIZE_SPECIAL_CHARS);
$teamemail = filter_input(INPUT_POST, "teamemail", FILTER_SANITIZE_EMAIL);

$teamOrder = "";
$teamdetails = "";

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




if ($teamname !== NULL && $teamcoachname !== NULL && $managername !== NULL && $teamemail !== NULL) {
// do the insert 


    $command = "INSERT INTO `orderform`(`teamname`, `teamcoachname`, `managername`, `teamemail`, `playername`, `playerkitnumber`, `cost`, `products`, `quantity`, `color`, `size`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";


    $stmt = $dbh->prepare($command);
    $result = $stmt->execute([$teamname, $teamcoachname, $managername, $teamemail, $playername, $playerkitnumber, $costzz, $products, $quantity, $colour, $size]);
    if ($result) {
        $msg = "Insert successful (Order ID={$dbh->lastInsertId()})";
        //$_SESSION["orderId"] = lastInsertId();
    } else {
        $msg = "Insert failed";
    }
} else {
    $msg = "Parameters not set";
}

$command2 = "SELECT `ordernumber` FROM `orderform` ORDER BY `ordernumber` DESC LIMIT 1";
$stmtz = $dbh->prepare($command2);
$resultZ = $stmtz->execute();
if ($resultZ) {
    $msg2 = "Order Id retreived successfully";
} else {
    $msg2 = "retreival failed";
}




while ($row = $stmtz->fetch()) {
    $searchOrderids = $row['ordernumber'];
}
$_SESSION["orderID"] = $searchOrderids;








//////////////////////////
if ($teamname !== NULL && $teamcoachname !== NULL && $managername !== NULL && $teamemail !== NULL) {
// do the insert 
    $commandv = "INSERT INTO `teamDetails`(`team_name`, `team_coachname`, `manager_name`, `team_email`) VALUES (?,?,?,?)";
    $stmtvm = $dbh->prepare($commandv);
    $resultu = $stmtvm->execute([$teamname, $teamcoachname, $managername, $teamemail]);
    if ($resultu) {
        $msg4 = "Insert successful (Order ID={$dbh->lastInsertId()})";
        //$_SESSION["orderId"] = lastInsertId();
    } else {
        $msg4 = "Insert failed";
    }
} else {
    $msg4 = "Parameters not set";
}
$commandvz = "SELECT `order_number` FROM `teamDetails` ORDER BY `order_number` DESC LIMIT 1";
$stmtvs = $dbh->prepare($commandvz);
$resultuy = $stmtvs->execute();
if ($resultuy) {
    $msg41 = "Order Id retreived successfully";
} else {
    $msg41 = "retreival failed";
}
while ($rowu = $stmtvs->fetch()) {
    $teamdetails = $rowu['order_number'];
}
$_SESSION["teamDetails"] = $teamdetails;






//////////////////////////
if ($playername !== NULL && $playerkitnumber !== NULL && $costzz !== NULL && $products !== NULL) {
// do the insert 
    $command8 = "INSERT INTO `order_details`(`player_name`, `playerkit_number`, `product_name`, `cost`, `quantity`, `color`, `size`) VALUES (?,?,?,?,?,?,?)";
    $stmt8 = $dbh->prepare($command8);
    $result8 = $stmt8->execute([$playername, $playerkitnumber, $products, $costzz, $quantity, $colour, $size]);
    if ($result8) {
        $msg4 = "Insert successful (Order ID={$dbh->lastInsertId()})";
        //$_SESSION["orderId"] = lastInsertId();
    } else {
        $msg4 = "Insert failed";
    }
} else {
    $msg4 = "Parameters not set";
}
$command81 = "SELECT `order_id` FROM `order_details` ORDER BY `order_id` DESC LIMIT 1";
$stmt81 = $dbh->prepare($command81);
$result81 = $stmt81->execute();
if ($result81) {
    $msg41 = "Order Id retreived successfully";
} else {
    $msg41 = "retreival failed";
}
while ($row81 = $stmt81->fetch()) {
    $teamOrder = $row81['order_id'];
}
$_SESSION["teamOrder"] = $teamOrder;

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

        </style>










        <script>
            $(document).ready(function () {
                var i = 0;


                $('#add').click(function () {
                    i++;

                    $('.payerBlockz').append('<div class="thumbnail" id="row' + i + '"><div class="form-group"><label for="exampleInputTeamCoach">Player Name</label><input type="text" class="form-control" name="playername[]" required></div> <div class="form-group"> <label for="exampleInputTeamCoach">Player Kit Number</label><input type="number" class="form-control" name="playerkit[]" required></div><div class="form-group"><figure>   <img src="images/Mainproduct3" alt="product1" width="180" height="180" id="imag1' + i + '" class="img-thumbnail"><figcaption>Product</figcaption> </figure></figure>   <input type="text" name="costzz[]" value="$19.00" id="cost2' + i + '"> </div><div class="form-group"><label class="form-sub-label" for="select" style="min-height:13px" aria-hidden="false"> Products </label><select class="form-dropdown" name="products[]" id="list' + i + '" required> <option value="None">None</option><option  value="BCC Black T-Shirt">BCC Black T-shirt </option><option value="GHACPom">GHACPom</option><option selected value="BrantCycling Vest">BrantCycling Vest</option> <option value="HLA-Pants">HLA-Pants</option> <option value="HFA-Hat">HFA-Hat</option> <option value="V-Escadrille">V-Escadrille</option> <option value="V-E3 Jacket">V-E3 Jacket</option></select><label class="form-sub-label" for="input_16_quantity_1002_0" style="min-height:13px" aria-hidden="false"> Quantity </label><select class="form-dropdown" name="Quantity" required><option value="None"> None </option><option value="1"> 1 </option><option value="2"> 2 </option><option value="3"> 3 </option><option value="4"> 4 </option><option value="5"> 5 </option><option value="6"> 6 </option><option value="7"> 7 </option><option value="8"> 8 </option><option value="9"> 9 </option><option value="10"> 10 </option></select><label class="form-sub-label" for="input_16_custom_1002_1" style="min-height:13px" aria-hidden="false"> Color </label><select class="form-dropdown" name="colour" required><option value="None"> None </option><option value="Green"> Green </option><option value="Blue"> Blue </option><option value="Red"> Red </option><option value="Black"> Black </option><option value="Magenta"> Magenta </option></select><label class="form-sub-label" for="input_16_custom_1002_2" style="min-height:13px" aria-hidden="false">Size </label><select class="form-dropdown" name="size" required><option value="None"> None </option><option value="XS"> XS </option><option value="S"> S </option><option value="M"> M </option><option value="L"> L </option><option value="XL"> XL </option><option value="XXL"> XXL </option><option value="XXXL"> XXXL </option></select></div><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Remove Player</button></div>');
                });

                $(document).on('click', '.btn_remove', function () {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });



                $("#productList").change(function () {

                    if ($(this).val() == "V-E3 Jacket") {
                        document.getElementById("imageSelect").src = "images/Mainproduct7";
//                        $("#cost").text("$20.00");
                        $("#cost").attr("value", "$20.00");
                    } else if ($(this).val() == "V-Escadrille") {
                        document.getElementById("imageSelect").src = "images/Mainproduct6";
//                        $("#cost").text("$15.00");
                        $("#cost").attr("value", "$15.00");
                    } else if ($(this).val() == "HFA-Hat") {
                        document.getElementById("imageSelect").src = "images/Mainproduct5";
                        // $("#cost").text("$10.00");
                        $("#cost").attr("value", "$10.00");
                    } else if ($(this).val() == "HLA-Pants") {
                        document.getElementById("imageSelect").src = "images/Mainproduct4";
                        //  $("#cost").text("$14.00");
                        $("#cost").attr("value", "$14.00");
                    } else if ($(this).val() == "BrantCycling Vest") {
                        document.getElementById("imageSelect").src = "images/Mainproduct3";
                        //$("#cost").text("$18.00");
                        $("#cost").attr("value", "$18.00");
                    } else if ($(this).val() == "GHACPom") {
                        document.getElementById("imageSelect").src = "images/Mainproduct2";
                        //$("#cost").text("$13.00");
                        $("#cost").attr("value", "$13.00");
                    } else if ($(this).val() == "BCC Black T-Shirt") {
                        document.getElementById("imageSelect").src = "images/Mainproduct1";
                        // $("#cost").text("$19.00");
                        $("#cost").attr("value", "$19.00");
                    }


                });


                $("#productListz").change(function () {

                    if ($(this).val() == "V-E3 Jacket") {
                        document.getElementById("imagez").src = "images/Mainproduct7";
//                        $("#costz").text("$20.00");
                        $("#costz").attr("value", "$20.00");

                    } else if ($(this).val() == "V-Escadrille") {
                        document.getElementById("imagez").src = "images/Mainproduct6";
//                        $("#costz").text("$15.00");
                        $("#costz").attr("value", "$15.00");

                    } else if ($(this).val() == "HFA-Hat") {
                        document.getElementById("imagez").src = "images/Mainproduct5";
//                        $("#costz").text("$10.00");
                        $("#costz").attr("value", "$10.00");

                    } else if ($(this).val() == "HLA-Pants") {
                        document.getElementById("imagez").src = "images/Mainproduct4";
//                        $("#costz").text("$14.00");
                        $("#costz").attr("value", "$14.00");

                    } else if ($(this).val() == "BrantCycling Vest") {
                        document.getElementById("imagez").src = "images/Mainproduct3";
//                        $("#costz").text("$18.00");
                        $("#costz").attr("value", "$18.00");

                    } else if ($(this).val() == "GHACPom") {
                        document.getElementById("imagez").src = "images/Mainproduct2";
//                        $("#costz").text("$13.00");
                        $("#costz").attr("value", "$13.00");

                    } else if ($(this).val() == "BCC Black T-Shirt") {
                        document.getElementById("imagez").src = "images/Mainproduct1";
                        // $("#costz").text("$19.00");
                        $("#costz").attr("value", "$19.00");

                    }


                });

                var initial = 0;

                $('#add').click(function () {



                    initial++;
                    $('#list' + initial).change(function () {

                        if ($(this).val() == "V-E3 Jacket") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct7";
                            //$('#cost2' + initial).text("$20.00");
                            $('#cost2' + initial).attr("value", "$20.00");
                        } else if ($(this).val() == "V-Escadrille") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct6";
                            //$('#cost2' + initial).text("$15.00");
                            $('#cost2' + initial).attr("value", "$15.00");
                        } else if ($(this).val() == "HFA-Hat") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct5";
                            //$("#cost2" + initial).text("$10.00");
                            $('#cost2' + initial).attr("value", "$10.00");
                        } else if ($(this).val() == "HLA-Pants") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct4";
                            //$("#cost2" + initial).text("$14.00");
                            $('#cost2' + initial).attr("value", "$14.00");
                        } else if ($(this).val() == "BrantCycling Vest") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct3";
                            //$("#cost2" + initial).text("$18.00");
                            $('#cost2' + initial).attr("value", "$18.00");
                        } else if ($(this).val() == "GHACPom") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct2";
                            //$("#cost2" + initial).text("$13.00");
                            $('#cost2' + initial).attr("value", "$13.00");
                        } else if ($(this).val() == "BCC Black T-Shirt") {
                            document.getElementById('imag1' + initial).src = "images/Mainproduct1";
                            //$("#cost2" + initial).text("$19.00");
                            $('#cost2' + initial).attr("value", "$19.00");
                        }



                    });



                });




                $('#editButton').click(function () {
//                    document.getElementById('teamName').disabled = false;


                    document.getElementById('add').disabled = false;

                    $(".form-control").prop("disabled", false);
                    $(".form-dropdown").prop("disabled", false);
                });


                var r = 0;

<?php
if (isset($_POST["blockZ"])) {
    ?>

                    r++;
                    $('.payerBlockz').append('<div class="thumbnail" id="row' + r + '"><div class="form-group"><label for="exampleInputTeamCoach">Player Name</label><input type="text" class="form-control" name="playername[]" value="<?php echo $_POST["playername"][r]; ?>" required></div> <div class="form-group"> <label for="exampleInputTeamCoach">Player Kit Number</label><input type="number" class="form-control" name="playerkit[]" value="<?php echo $_POST["playerkit"][r]; ?>" required></div><div class="form-group"><figure>   <img src="images/Mainproduct3" alt="product1" width="180" height="180" id="imag1' + r + '" class="img-thumbnail"><figcaption>Product</figcaption> </figure></figure> <input type="text" name="costzz[]" value="$19.00" id="cost2' + r + '">       </div><div class="form-group"><label class="form-sub-label" for="select" style="min-height:13px" aria-hidden="false"> Products </label><select class="form-dropdown" name="products[]" id="list' + r + '" required> <option value="None" <?= $_POST["products"][r] == 'None' ? ' selected="selected"' : ''; ?>>None</option><option value="BCC Black T-Shirt"  <?= $_POST["products"][r] == 'BCC Black T-Shirt' ? ' selected="selected"' : ''; ?>>BCC Black T-shirt </option><option value="GHACPom" <?= $_POST["products"][0] == 'GHACPom' ? ' selected="selected"' : ''; ?>>GHACPom</option><option value="BrantCycling Vest" <?= $_POST["products"][r] == 'BrantCycling Vest' ? ' selected="selected"' : ''; ?>>BrantCycling Vest</option> <option value="HLA-Pants" <?= $_POST["products"][r] == 'HLA-Pants' ? ' selected="selected"' : ''; ?>>HLA-Pants</option> <option value="HFA-Hat" <?= $_POST["products"][r] == 'HFA-Hat' ? ' selected="selected"' : ''; ?>>HFA-Hat</option> <option value="V-Escadrille" <?= $_POST["products"][r] == 'V-Escadrille' ? ' selected="selected"' : ''; ?>>V-Escadrille</option> <option value="V-E3 Jacket" <?= $_POST["products"][0] == 'V-E3 Jacket' ? ' selected="selected"' : ''; ?>>V-E3 Jacket</option></select><label class="form-sub-label" for="input_16_quantity_1002_0" style="min-height:13px" aria-hidden="false"> Quantity </label><select class="form-dropdown" name="Quantity[]" required><option value="None" <?= $_POST["Quantity"][r] == 'None' ? ' selected="selected"' : ''; ?>> None </option><option value="1" <?= $_POST["Quantity"][r] == '1' ? ' selected="selected"' : ''; ?>> 1 </option><option value="2" <?= $_POST["Quantity"][r] == '2' ? ' selected="selected"' : ''; ?>> 2 </option><option value="3" <?= $_POST["Quantity"][r] == '3' ? ' selected="selected"' : ''; ?>> 3 </option><option value="4" <?= $_POST["Quantity"][r] == '4' ? ' selected="selected"' : ''; ?>> 4 </option><option value="5" <?= $_POST["Quantity"][r] == '5' ? ' selected="selected"' : ''; ?>> 5 </option><option value="6" <?= $_POST["Quantity"][r] == '6' ? ' selected="selected"' : ''; ?>> 6 </option><option value="7" <?= $_POST["Quantity"][r] == '7' ? ' selected="selected"' : ''; ?>> 7 </option><option value="8" <?= $_POST["Quantity"][r] == '8' ? ' selected="selected"' : ''; ?>> 8 </option><option value="9" <?= $_POST["Quantity"][r] == '9' ? ' selected="selected"' : ''; ?>> 9 </option><option value="10" <?= $_POST["Quantity"][r] == '10' ? ' selected="selected"' : ''; ?>> 10 </option></select><label class="form-sub-label" for="input_16_custom_1002_1" style="min-height:13px" aria-hidden="false"> Color </label><select class="form-dropdown" name="colour[]" required><option value="None" <?= $_POST["colour"][r] == 'None' ? ' selected="selected"' : ''; ?>> None </option><option value="Green" <?= $_POST["colour"][r] == 'Green' ? ' selected="selected"' : ''; ?>> Green </option><option value="Blue" <?= $_POST["colour"][r] == 'Blue' ? ' selected="selected"' : ''; ?>> Blue </option><option value="Red" <?= $_POST["colour"][r] == 'Red' ? ' selected="selected"' : ''; ?>> Red </option><option value="Black" <?= $_POST["colour"][r] == 'Black' ? ' selected="selected"' : ''; ?>> Black </option><option value="Magenta" <?= $_POST["colour"][r] == 'Magenta' ? ' selected="selected"' : ''; ?>> Magenta </option></select><label class="form-sub-label" for="input_16_custom_1002_2" style="min-height:13px" aria-hidden="false">Size </label><select class="form-dropdown" name="size[]" required><option value="None"> None </option><option value="XS" <?= $_POST["size"][r] == 'XS' ? ' selected="selected"' : ''; ?>> XS </option><option value="S" <?= $_POST["size"][r] == 'S' ? ' selected="selected"' : ''; ?>> S </option><option value="M" <?= $_POST["size"][r] == 'M' ? ' selected="selected"' : ''; ?>> M </option><option value="L" <?= $_POST["size"][r] == 'L' ? ' selected="selected"' : ''; ?>> L </option><option value="XL" <?= $_POST["size"][r] == 'XL' ? ' selected="selected"' : ''; ?>> XL </option><option value="XXL" <?= $_POST["size"][r] == 'XXL' ? ' selected="selected"' : ''; ?>> XXL </option><option value="XXXL" <?= $_POST["size"][r] == 'XXXL' ? ' selected="selected"' : ''; ?>> XXXL </option></select></div><button type="button" name="remove" id="' + r + '" class="btn btn-danger btn_remove">Remove Player</button></div>');


    <?php
}
?>

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
//        echo "<h1  class='p-3 mb-2 bg-success text-white'>$msg2</h1>";
//        echo "<h1  class='p-3 mb-2 bg-success text-white'> Row Id = $searchOrderids</h1>";
        ?>






        <div class="container">
            <form  action="reviewMain.php" method="POST">
                <div id="productHeader">
                    <h2>Edit/Review Order Form</h2>
                    <input type="hidden" id="orderID" name="orderID" value="<?php echo $searchOrderids; ?>">
                    <input type="hidden" id="teamDetails" name="teamDetails" value="<?php echo $teamdetails; ?>">
                    <input type="hidden" id="teamOrder" name="teamOrder" value="<?php echo $teamOrder; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Team Name</label>
                    <input type="text" class="form-control" name="teamname" required value="<?php echo $teamname; ?>" id="teamName" disabled>

                </div>
                <div class="form-group">
                    <label for="exampleInputTeamCoach">Team Coach Name</label>
                    <input type="text" class="form-control" name="teamcoachname"required value="<?php echo $teamcoachname; ?>" id="teamCoachName" disabled>
                </div>

                <div class="form-group">
                    <label for="exampleInputTeamCoach">Manager Name</label>
                    <input type="text" class="form-control" name="managername" required  value="<?php echo $managername; ?>"   id="managerName" disabled>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Team Email</label>
                    <input type="email" class="form-control" id="teamEmail"  required name="teamemail" value="<?php echo $teamemail; ?>"   aria-describedby="emailHelp" disabled >
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>


                <div class="thumbnail">
                    <div class="form-group">
                        <label for="exampleInputTeamCoach">Player Name</label>
                        <input type="text" name="playername[]" required value="<?php echo $_POST["playername"][0]; ?>"  class="form-control" disabled="" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputTeamCoach">Player Kit Number</label>
                        <input type="number" name="playerkit[]" required value="<?php echo $_POST["playerkit"][0]; ?>" class="form-control" disabled="" >
                    </div>


                    <div class="form-group">
                        <figure>
                            <img src="images/Mainproduct1" alt="product1" width="180" height="180" class="img-thumbnail">
                            <figcaption>Product</figcaption>
                        </figure>
                        <input type="text" name="costzz[]" value="$19.00" id="cost"  disabled>
                      <!-- <label for="exampleInputTeamCoach" >Cost = <span id="cost" >$19.00</span></label>-->
                    </div>
                    <div class="form-group">


                        <label class="form-sub-label" for="select" style="min-height:13px" aria-hidden="false"> Products </label>
                        <select class="form-dropdown" name="products[]"  id="productList" required disabled="">
                            <option value="None" <?= $_POST["products"][0] == 'None' ? ' selected="selected"' : ''; ?>>None</option>
                            <option value="BCC Black T-Shirt" <?= $_POST["products"][0] == 'BCC Black T-Shirt' ? ' selected="selected"' : ''; ?>>BCC Black T-shirt </option>
                            <option value="GHACPom" <?= $_POST["products"][0] == 'GHACPom' ? ' selected="selected"' : ''; ?>>GHACPom</option>
                            <option value="BrantCycling Vest" <?= $_POST["products"][0] == 'BrantCycling Vest' ? ' selected="selected"' : ''; ?>>BrantCycling Vest</option>
                            <option value="HLA-Pants" <?= $_POST["products"][0] == 'HLA-Pants' ? ' selected="selected"' : ''; ?>>HLA-Pants</option>
                            <option value="HFA-Hat" <?= $_POST["products"][0] == 'HFA-Hat' ? ' selected="selected"' : ''; ?>>HFA-Hat</option>
                            <option value="V-Escadrille" <?= $_POST["products"][0] == 'V-Escadrille' ? ' selected="selected"' : ''; ?>>V-Escadrille</option>
                            <option value="V-E3 Jacket" <?= $_POST["products"][0] == 'V-E3 Jacket' ? ' selected="selected"' : ''; ?>>V-E3 Jacket</option>
                        </select>

                        <label class="form-sub-label" for="input_16_quantity_1002_0" style="min-height:13px" aria-hidden="false"> Quantity </label>
                        <select class="form-dropdown" name="Quantity[]"   required  disabled="">
                            <option value="None" <?= $_POST["Quantity"][0] == 'None' ? ' selected="selected"' : ''; ?>>None </option>
                            <option value="1" <?= $_POST["Quantity"][0] == '1' ? ' selected="selected"' : ''; ?>>1</option>
                            <option value="2" <?= $_POST["Quantity"][0] == '2' ? ' selected="selected"' : ''; ?>>2</option>
                            <option value="3" <?= $_POST["Quantity"][0] == '3' ? ' selected="selected"' : ''; ?>>3</option>
                            <option value="4" <?= $_POST["Quantity"][0] == '4' ? ' selected="selected"' : ''; ?>>4</option>
                            <option value="5"<?= $_POST["Quantity"][0] == '5' ? ' selected="selected"' : ''; ?>>5</option>
                            <option value="6" <?= $_POST["Quantity"][0] == '6' ? ' selected="selected"' : ''; ?>>6</option>
                            <option value="7" <?= $_POST["Quantity"][0] == '7' ? ' selected="selected"' : ''; ?>>7</option>
                            <option value="8" <?= $_POST["Quantity"][0] == '8' ? ' selected="selected"' : ''; ?>>8</option>
                            <option value="9" <?= $_POST["Quantity"][0] == '9' ? ' selected="selected"' : ''; ?>>9</option>
                            <option value="10"<?= $_POST["Quantity"][0] == '10' ? ' selected="selected"' : ''; ?>>10 </option>
                        </select>

                        <label class="form-sub-label" for="input_16_custom_1002_1" style="min-height:13px" aria-hidden="false"> Color </label>
                        <select class="form-dropdown" name="colour[]" required disabled="" >
                            <option value="None" <?= $_POST["colour"][0] == 'None' ? ' selected="selected"' : ''; ?>> None </option>
                            <option value="Green" <?= $_POST["colour"][0] == 'Green' ? ' selected="selected"' : ''; ?>> Green </option>
                            <option value="Blue" <?= $_POST["colour"][0] == 'Blue' ? ' selected="selected"' : ''; ?>> Blue </option>
                            <option value="Red" <?= $_POST["colour"][0] == 'Red' ? ' selected="selected"' : ''; ?>> Red </option>
                            <option value="Black" <?= $_POST["colour"][0] == 'Black' ? ' selected="selected"' : ''; ?>> Black </option>
                            <option value="Magenta" <?= $_POST["colour"][0] == 'Magenta' ? ' selected="selected"' : ''; ?>> Magenta </option>
                        </select>

                        <label class="form-sub-label" for="input_16_custom_1002_2" style="min-height:13px" aria-hidden="false">Size </label>
                        <select class="form-dropdown" name="size[]"  required disabled="" >
                            <option value="None"> None </option>
                            <option value="XS"  <?= $_POST["size"][0] == 'XS' ? ' selected="selected"' : ''; ?>>XS </option>
                            <option value="S"  <?= $_POST["size"][0] == 'S' ? ' selected="selected"' : ''; ?>> S </option>
                            <option value="M" <?= $_POST["size"][0] == 'M' ? ' selected="selected"' : ''; ?>> M </option>
                            <option value="L" <?= $_POST["size"][0] == 'L' ? ' selected="selected"' : ''; ?>> L </option>
                            <option value="XL"<?= $_POST["size"][0] == 'XL' ? ' selected="selected"' : ''; ?>> XL </option>
                            <option value="XXL" <?= $_POST["size"][0] == 'XXL' ? ' selected="selected"' : ''; ?>> XXL </option>
                            <option value="XXXL"<?= $_POST["size"][0] == 'XXXL' ? ' selected="selected"' : ''; ?>> XXXL </option>
                        </select>

                    </div>

                </div>



                <div class="thumbnail" id="payerBlock">
                    <div class="form-group">
                        <label for="exampleInputTeamCoach">Player Name</label>
                        <input type="text" class="form-control" name="playername[]" value="<?php echo $_POST["playername"][1]; ?>" required  disabled>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputTeamCoach">Player Kit Number</label>
                        <input type="number" class="form-control" name="playerkit[]" value="<?php echo $_POST["playerkit"][1]; ?>" required  disabled>
                    </div>


                    <div class="form-group">
                        <figure>
                            <img src="images/Mainproduct2" alt="product1" width="180" height="180" class="img-thumbnail">
                            <figcaption>Product</figcaption>
                        </figure>
                        <input type="text" name="costzz[]" value="$10.00" id="costz" disabled>
<!--                        <label for="exampleInputTeamCoach" >Cost = <span id="costz">$10.00</span></label>-->
                    </div>
                    <div class="form-group">


                        <label class="form-sub-label" for="select" style="min-height:13px" aria-hidden="false"> Products </label>
                        <select class="form-dropdown" name="products[]" required disabled="" >
                            <option value="None" <?= $_POST["products"][1] == 'None' ? ' selected="selected"' : ''; ?>>None</option>
                            <option value="BCC Black T-Shirt" <?= $_POST["products"][1] == 'BCC Black T-Shirt' ? ' selected="selected"' : ''; ?>>BCC Black T-shirt </option>
                            <option value="GHACPom" <?= $_POST["products"][1] == 'GHACPom' ? ' selected="selected"' : ''; ?>>GHACPom</option>
                            <option value="BrantCycling Vest" <?= $_POST["products"][1] == 'BrantCycling Vest' ? ' selected="selected"' : ''; ?>>BrantCycling Vest</option>
                            <option value="HLA-Pants" <?= $_POST["products"][1] == 'HLA-Pants' ? ' selected="selected"' : ''; ?>>HLA-Pants</option>
                            <option value="HFA-Hat" <?= $_POST["products"][1] == 'HFA-Hat' ? ' selected="selected"' : ''; ?>>HFA-Hat</option>
                            <option value="V-Escadrille" <?= $_POST["products"][1] == 'V-Escadrille' ? ' selected="selected"' : ''; ?>>V-Escadrille</option>
                            <option value="V-E3 Jacket" <?= $_POST["products"][1] == 'V-E3 Jacket' ? ' selected="selected"' : ''; ?>>V-E3 Jacket</option>
                        </select>

                        <label class="form-sub-label" for="input_16_quantity_1002_0" style="min-height:13px" aria-hidden="false"> Quantity </label>
                        <select class="form-dropdown" name="Quantity[]" required disabled="">
                            <option value="None" <?= $_POST["Quantity"][1] == 'None' ? ' selected="selected"' : ''; ?>>None </option>
                            <option value="1" <?= $_POST["Quantity"][1] == '1' ? ' selected="selected"' : ''; ?>>1</option>
                            <option value="2" <?= $_POST["Quantity"][1] == '2' ? ' selected="selected"' : ''; ?>>2</option>
                            <option value="3" <?= $_POST["Quantity"][1] == '3' ? ' selected="selected"' : ''; ?>>3</option>
                            <option value="4" <?= $_POST["Quantity"][1] == '4' ? ' selected="selected"' : ''; ?>>4</option>
                            <option value="5"<?= $_POST["Quantity"][1] == '5' ? ' selected="selected"' : ''; ?>>5</option>
                            <option value="6" <?= $_POST["Quantity"][1] == '6' ? ' selected="selected"' : ''; ?>>6</option>
                            <option value="7" <?= $_POST["Quantity"][1] == '7' ? ' selected="selected"' : ''; ?>>7</option>
                            <option value="8" <?= $_POST["Quantity"][1] == '8' ? ' selected="selected"' : ''; ?>>8</option>
                            <option value="9" <?= $_POST["Quantity"][1] == '9' ? ' selected="selected"' : ''; ?>>9</option>
                            <option value="10"<?= $_POST["Quantity"][1] == '10' ? ' selected="selected"' : ''; ?>>10 </option>
                        </select>

                        <label class="form-sub-label" for="input_16_custom_1002_1" style="min-height:13px" aria-hidden="false"> Color </label>
                        <select class="form-dropdown" name="colour[]"  required disabled="">
                            <option value="None" <?= $_POST["colour"][1] == 'None' ? ' selected="selected"' : ''; ?>> None </option>
                            <option value="Green" <?= $_POST["colour"][1] == 'Green' ? ' selected="selected"' : ''; ?>> Green </option>
                            <option value="Blue" <?= $_POST["colour"][1] == 'Blue' ? ' selected="selected"' : ''; ?>> Blue </option>
                            <option value="Red" <?= $_POST["colour"][1] == 'Red' ? ' selected="selected"' : ''; ?>> Red </option>
                            <option value="Black" <?= $_POST["colour"][1] == 'Black' ? ' selected="selected"' : ''; ?>> Black </option>
                            <option value="Magenta" <?= $_POST["colour"][1] == 'Magenta' ? ' selected="selected"' : ''; ?>> Magenta </option>
                        </select>

                        <label class="form-sub-label" for="input_16_custom_1002_2" style="min-height:13px" aria-hidden="false">Size </label>
                        <select class="form-dropdown" name="size[]"  required disabled="" >
                            <option value="None"> None </option>
                            <option value="XS"  <?= $_POST["size"][1] == 'XS' ? ' selected="selected"' : ''; ?>>XS </option>
                            <option value="S"  <?= $_POST["size"][1] == 'S' ? ' selected="selected"' : ''; ?>> S </option>
                            <option value="M" <?= $_POST["size"][1] == 'M' ? ' selected="selected"' : ''; ?>> M </option>
                            <option value="L" <?= $_POST["size"][1] == 'L' ? ' selected="selected"' : ''; ?>> L </option>
                            <option value="XL"<?= $_POST["size"][1] == 'XL' ? ' selected="selected"' : ''; ?>> XL </option>
                            <option value="XXL" <?= $_POST["size"][1] == 'XXL' ? ' selected="selected"' : ''; ?>> XXL </option>
                            <option value="XXXL"<?= $_POST["size"][1] == 'XXXL' ? ' selected="selected"' : ''; ?>> XXXL </option>
                        </select>

                    </div>

                </div>


                <div class="payerBlockz">




                </div>


                <div class="form-group form-check">
                    <button type="button" name="add" id="add" hidden class="btn btn-success"  disabled="disabled">Add More Player</button>


                </div>
                <button type="button" class="btn btn-danger" id="editButton" >Edit</button>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>


        </div>






        <div class="mt-5 pt-5 pb-5 footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-xs-12 about-company">
                        <h2>Niko Apparel</h2>
                        <p class="pr-5 text-white-50">Since 1996 Niko has had the privilege of bringing high quality, custom made apparel to its clients, made in Canada. With  </p>
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

