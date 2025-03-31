<?php
include_once"phpenhancements.php";
checklogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Assighment Part 1" />
    <meta name="keywords" content="HTML, CSS" />
    <meta name="author" content="Ismail Mamedov" />
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Rubicon International</title>
</head>

<body class="container4">

<?php
    include_once"header.inc";
    include_once"menu.inc";
    ?>

    <main>

        <?php
        //new Job display 
        if(isset($_GET['action'])=="newjob"){
            ?>
            <h1> Add New Job</h1>
            <main class="container1">
            <div class="form">
            <?php
            //echo md5("12345678");
            if(isset($_POST['addjob'])){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    addnewjob($_POST);
                     
                }
                
            }
            ?>
            <form action="" method="post" id="application-form" >
                Job Reference Number:
                <?php 
                $Job_Reference_number="J".rand(123,321);
                ?>
                <input type="text" name="job_reference_number" class="form-control" required  value="<?php echo $Job_Reference_number?>"placeholder="Job Reference Number">
                <span class="glyphicon glyphicon-user error-message"></span>
                Title:
                <input type="text" name="job_title" class="form-control" placeholder="Job Title" required>
                <span class="glyphicon glyphicon-lock error-message"></span>
                
                Description:
                <textarea rows="5" name="job_description" class="form-control" placeholder="Job Description" required></textarea>
                <span class="glyphicon glyphicon-user error-message"></span>
               
            
            <div class="row">
            
                <!-- /.col -->
                <div class="col-xs-4">
                <button type="submit" name="addjob" class="btn btn-primary btn-block btn-flat">Add new Job</button>
                </div>
                <!-- /.col -->
            </div>
            
            </form>
            <br>
            </div>
        </div>
        </main>
        <?php
        
        }
        else if(isset($_GET['job'])=="joblist"){
            //Job Listing display
            ?>
            <h1>  Job Listing</h1>
            <main class="container1">
                <?php
                //call function for displaying jobs
                joblisting();
                ?>
            </main>
            
        <?php
        }

        else if(isset($_GET['jobapp'])=="jobapplications"){
            //Job application Received
            ?>
            <h1>  Job Applications</h1>
            <main class="container1">
            <?php
            //function for updating status of the application
            if(isset($_POST['statusupdate'])){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    jobStatus($_POST);
                     
                }
                
            }
            //job application delete function
            if(isset($_GET['action']) =='del'){
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    deleteJob($_GET);
                     
                }
                
            }
            //job application Listing
            jobapplications();

            ?>
            </main>
            
        <?php
        }
        

        else if(isset($_GET['jobsearch'])=="jobsearch"){
            //Job application search 
            ?>
            <h1>   Applications Search</h1>
            <main class="container1">

            <div class="form">
            <?php
            if(isset($_POST['search'])){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    searchapplication($_POST);
                     
                }
                
            }
           //application search form 
            ?>
            <form action="" method="post" id="application-form" >
                Search by Reference Number:
                <input type="text" name="EOINumber" class="form-control" placeholder="reference number">
                <span class="glyphicon glyphicon-user error-message"></span>
                Search by First / last Name or both
                <input type="text" name="name" class="form-control" placeholder="Search by name">
                <span class="glyphicon glyphicon-lock error-message"></span>
            
            <div >
                <button type="submit"name="search" class="btn btn-primary btn-block btn-flat">Search</button>
               
            </div>
            
            </form>
            <br>
            </main>
            
        <?php
        }
        ?>
        
    </main>
    
        <hr>
    <?php include_once"footer.inc";?>
</body>

</html>