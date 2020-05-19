<?php
/*
 * This file allows a user to logout from the app and give a option to login again.
 * Created on : 24-Oct-2018, 10:00:13 AM
 * Author     : Abdus Sattar Mia - 000394648
 */
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Assignment 3</title>
         <meta charset="UTF-8">
         <link rel="stylesheet"  type="text/css" href="styling.css">
    </head>
    <body>
        <h3>Logged out successfully!</h3>
         <p id='tryAgain'><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/index.html">Login again</a></p>
    </body>
</html>
