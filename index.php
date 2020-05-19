<?php session_start(); ?>
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

            ul li{
                list-style-type: none;
            }
  
        </style>
    </head>
    <body>


        <div id="mainBox">
            <?php require('header.php'); ?>



            <div class="container-fluid text-center">


                <button onclick="window.location.href = 'formPage.php'" type="button" id="buttonCreate" class="btn btn-primary btn-lg ">CREATE ORDER</button>

                <img src="images/jersey2.jpg" alt="jersey" id="img1" class="img-responsive">


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
