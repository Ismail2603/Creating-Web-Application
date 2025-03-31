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
            if(isset($_POST['login'])){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    login($_POST);
                     
                }
                
            }
           
            ?>
            <form action="" method="post" id="application-form" >
                Username:
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <span class="glyphicon glyphicon-user error-message"></span>
                Password
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock error-message"></span>
            
            <div class="row">
            
                <!-- /.col -->
                <div class="col-xs-4">
                <button type="submit"name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <h3>HR Logins</h3>
                <p>USERNAME: admin</p>
                <p>PASSWORD: 123456</p>
            </div>
            </form>
            <br>
            

            </main>

    <hr>
    <?php include_once"footer.inc";?>
</body>

</html>