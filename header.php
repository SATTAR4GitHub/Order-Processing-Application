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
                <li class="active"><a href="index.php" id="home">Home</a></li>
             
                    <li><a href="formPage.php" id="order">Create Order</a></li>
            
                <li><a href="http://nikoapparel.ca/contact/" id="contact">Contact</a></li>

                <li><a href="admin-dashboard/admin.php" id="manage">Admin Panel</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Welcome <?= $_SESSION["user_id"] ?>! <span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login to create orders</a></li>
                    <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>