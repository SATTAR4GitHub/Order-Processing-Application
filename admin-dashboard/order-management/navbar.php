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
                <li><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/admin.php" id="manage">Admin Panel</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="https://csunix.mohawkcollege.ca/~000394648/teamOrderApp/admin-dashboard/index.html">Welcome <?= $_SESSION["userid"] ?>! <span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>