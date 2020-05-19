<?php
include 'connection.php';
session_start();

$error = null;

$message = null;

// Register the user if the user has clicked register.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userId = $_POST['user_ids'];
    $confirmPassword = $_POST['confirm-password'];
    $password = $_POST['passwords'];

    if ($userId == NULL || $password == NULL) {
        $error = "Please fill all the fields";
    } else {
        if ($password == $confirmPassword) {

            // Check if ther eis already a user with the same user id.
            $command = "SELECT * FROM user WHERE user_id = '$userId'";
            $stmt = $dbh->prepare($command);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                $error = "Sorry there is a user with the given user id.";
            } else {
                // prepare the insert command
                $command = "INSERT INTO user (user_id, password) VALUES ('$userId','$password')";
                $stmt = $dbh->prepare($command);
                $stmt->execute();

                $message = "Your account has been created, you can now login to create orders.";
                 header("Location: login.php");
            }
        } else {
            $error = "It should match the password you entered";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Niko Apparel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--        <link rel="stylesheet" type="text/css" href="css/style.css">-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-top: -94px;
                margin-bottom: 0;
                border-radius: 0;
            }


            #block{
                margin-top: 80px;
                margin-bottom: 80px;
            }

            body{
                background-color: whitesmoke;
            }

            ul li{
                list-style-type: none;
            }



            #home,#manage,#order,#contact {
                font-size: 17px;


            }


            #headers {
                font-size: 22px;
            }


            .footer{
                background: #152F4F;
                color:white;

                .links{
                    ul {list-style-type: none;}
                    li a{
                        color: white;
                        transition: color .2s;
                        &:hover{
                            text-decoration:none;
                            color:#4180CB;
                        }
                    }
                }  
                .about-company{
                    i{font-size: 25px;}
                    a{
                        color:white;
                        transition: color .2s;
                        &:hover{color:#4180CB}
                    }
                } 
                .location{
                    i{font-size: 18px;}
                }
                .copyright p{border-top:1px solid rgba(255,255,255,.1);} 
            }





            body {
                padding-top: 90px;
            }
            .panel-login {
                border-color: #ccc;
                -webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
                -moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
                box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
            }
            .panel-login>.panel-heading {
                color: #00415d;
                background-color: #fff;
                border-color: #fff;
                text-align:center;
            }
            .panel-login>.panel-heading a{
                text-decoration: none;
                color: #666;
                font-weight: bold;
                font-size: 15px;
                -webkit-transition: all 0.1s linear;
                -moz-transition: all 0.1s linear;
                transition: all 0.1s linear;
            }
            .panel-login>.panel-heading a.active{
                color: #029f5b;
                font-size: 18px;
            }
            .panel-login>.panel-heading hr{
                margin-top: 10px;
                margin-bottom: 0px;
                clear: both;
                border: 0;
                height: 1px;
                background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
                background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
                background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
                background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
            }
            .panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
                height: 45px;
                border: 1px solid #ddd;
                font-size: 16px;
                -webkit-transition: all 0.1s linear;
                -moz-transition: all 0.1s linear;
                transition: all 0.1s linear;
            }
            .panel-login input:hover,
            .panel-login input:focus {
                outline:none;
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
                border-color: #ccc;
            }
            .btn-login {
                background-color: #59B2E0;
                outline: none;
                color: #fff;
                font-size: 14px;
                height: auto;
                font-weight: normal;
                padding: 14px 0;
                text-transform: uppercase;
                border-color: #59B2E6;
            }
            .btn-login:hover,
            .btn-login:focus {
                color: #fff;
                background-color: #53A3CD;
                border-color: #53A3CD;
            }
            .forgot-password {
                text-decoration: underline;
                color: #888;
            }
            .forgot-password:hover,
            .forgot-password:focus {
                text-decoration: underline;
                color: #666;
            }

            .btn-register {
                background-color: #1CB94E;
                outline: none;
                color: #fff;
                font-size: 14px;
                height: auto;
                font-weight: normal;
                padding: 14px 0;
                text-transform: uppercase;
                border-color: #1CB94A;
            }
            .btn-register:hover,
            .btn-register:focus {
                color: #fff;
                background-color: #1CA347;
                border-color: #1CA347;
            }

        </style>

    </head>
    <body>


        <div id="mainBox">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <a class="navbar-brand" id="headers" href="#">Niko Apparel Systems</a>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="index.php" id="home">Home</a></li>
                            <li><a href="formPage.php" id="order">Create Order</a></li>
                            <li><a href="http://nikoapparel.ca/contact/" id="contact">Contact</a></li>
                            <li><a href="admin-dashboard/index.html" id="manage">Admin Panel</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php
                echo $message;
                
                ?>
            </div>
        <?php endif; ?>
            <?php if ($error): ?>
            <div class="alert alert-danger">
            <?php echo $error; ?>
            </div>
<?php endif; ?>

        <div class="container" id="block">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">

                                <div class="col-xs-12">
                                    <a href="register.php" id="register-form-link">Register</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <form id="register-form" method="POST" role="form" style="display: block;">
                                        <div class="form-group">
                                            <input type="text" name="user_ids" id="username" tabindex="1" required="" class="form-control" placeholder="Username" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" tabindex="1" required="" class="form-control" placeholder="Email Address" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="passwords" id="password" tabindex="2" required="" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirm-password" id="confirm-password"  required="" tabindex="2" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
