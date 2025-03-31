<?php
include_once"phpenhancements.php";
checklogin();
checkSession();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
    <?php
    include_once"header.inc";
    include_once"menu.inc";
    ?>
    
    
    <main class="container1">
        <h4 style="font-size:18px">HR Dashboard</h3>
        
            
            <div  width="100%" class="">
                <table width="700%" class="table table-concept "style="border:2px">
                    <tr>
                        <td>
                            <a href="enhancement.php?jaction=newjob">
                            <img src="images/download34.jfif" alt="newjob" width="80%">
                            <p> Add New Job</p>
                            </a>
                        <td>
                        <td>
                            <a href="enhancement.php?job=joblist">
                            <img src="images/download.png" alt="joblist" width="80%">
                            <p> Job Listing</p>
                            </a>
                        <td>
                        <td>
                            <a href="enhancement.php?jobapp=jobapplications">
                            <img src="images/images.png" alt="Applications" width="80%">
                            <p> Job Applications</p>
                            </a>
                        <td>

                    </tr>
                    <tr>
                        <td>
                            <a href="enhancement.php?jobsearch=jobsearch">
                            <img src="images/downloadq.jfif" alt="Search" width="80%">
                            <p> Search Application</p>
                            </a>
                        <td>
                        
                        <td>
                            <a href="logout.php?action=logout">
                            <img src="images/downloadt.jfif" alt="logout" width="80%">
                            <p> Logout</p>
                            </a>
                        <td>

                    </tr>
                </table>
            </div>
        
    </main>

    <hr>
    <?php include_once"footer.inc";?>
</body>

</html>