<?php
include_once"phpenhancements.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Assighment part  1" />
    <meta name="keywords" content="HTML, CSS, " />
    <meta name="author" content="Ismail Mamedov" />
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="images/logo.png">
    <title>Rubicon International </title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="images/logo.png">
    
</head>

<body>
    <?php
    include_once"header.inc";
    ?>
    <main class="container1">
        <div class="form">
            <?php
            //echo md5("12345678");
            if(isset($_POST['addaccount'])){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                     adduser($_POST);
                     
                }
                
            }
            ?>
            <form action="" method="post" id="application-form" >
                Full Name:
                <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                <span class="glyphicon glyphicon-user error-message"></span>
                Email:
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-lock error-message"></span>
                
                Username:
                <input type="text" name="manager_username" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-user error-message"></span>
                Password
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock error-message"></span>
            
            <div class="row">
            
                <!-- /.col -->
                <div class="col-xs-4">
                <button type="submit" name="addaccount" class="btn btn-primary btn-block btn-flat">Create New Account</button>
                </div>
                <!-- /.col -->
            </div>
            
            </form>
            <br>
            

            </main>

    <hr>
    <?php include_once"footer.inc";?>
</body>

</html>