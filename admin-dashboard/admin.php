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

<!DOCTYPE> 

<html>
    <head>
        <title>Niko Apparel: Admin Panel</title> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/style.css" media="all" /> 
        <link rel="stylesheet"  type="text/css" href="main.css">
        <link rel="stylesheet"  type="text/css" href="styling.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>


    <body> 
        <?php
        if (isset($_SESSION["userid"])) {
            ?>

            <div class="main_wrapper">
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        
                        <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" id="header" href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/index.php">Niko Apparel Systems</a>
                </div>

                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav">
                                <li><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/index.php" id="home">Home</a></li>
                                <li><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/formPage.php" id="order">Create Order</a></li>
                                <li><a href="#" id="contact">Contact</a></li>
                                <li class="active"><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/admin.php" id="manage">Admin Panel</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="logout.php">Welcome <?= $_SESSION["userid"] ?>! <span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                            </ul>

                        </div>
                    </div>
                </nav>

                <div id="right">
                    <h2 style="text-align:center;">Manage Content</h2>
                    <a class="active" href="order-management/orderSummary.php" id="manage">Manage Order</a>
                    <a class="active" href="product-management/productSummary.php" id="manage">Manage Product</a>
                </div>
                <div id="left">

                </div>
            </div>
            <?php
            } else {
            echo"<h1>Login Error! Access denied.</h1>";
            echo"<p id = 'tryAgain'><a href = 'https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/index.html'>Try Again</a</p>";
            }
            ?>
    </body>
</html>

