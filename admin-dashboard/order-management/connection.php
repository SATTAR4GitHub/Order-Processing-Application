<?php
/* MySQL connection code
 *Abdus Sattar Mia - 000394648
 *Created on : 24-Oct-2018, 10:00:13 AM
 */
try {
    $dbh = new PDO('mysql:host=localhost;dbname=bdname', "username", "password");
} catch (Exception $e) {
    die('Could not connect to DB: ' . $e->getMessage());
}


