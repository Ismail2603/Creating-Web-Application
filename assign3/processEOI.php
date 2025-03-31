<?php
include_once"phpenhancements.php";

function job_application($data){
    require "setting.php"; 
    $Job_Reference_number=mysqli_real_escape_string($conn,$data['Job_Reference_number']);
    $First_name=mysqli_real_escape_string($conn,$data['First_name']);
    $Last_name=mysqli_real_escape_string($conn,$data['Last_name']);
    $gender=mysqli_real_escape_string($conn,$data['gender']);
    $dob=mysqli_real_escape_string($conn,$data['dob']);
    $Street_address=mysqli_real_escape_string($conn,$data['Street_address']);
    $Suburb=mysqli_real_escape_string($conn,$data['Suburb']);
    $State=mysqli_real_escape_string($conn,$data['State']);
    $Postcode=mysqli_real_escape_string($conn,$data['Postcode']);
    $Email_address=mysqli_real_escape_string($conn,$data['Email_address']);
    $Phone_number=mysqli_real_escape_string($conn,$data['Phone_number']);
    $string="";
    foreach($data['skillCheckboxes'] as $Skills){
        $string = $string.'/'.$Skills;
    }
    $Other_skills=mysqli_real_escape_string($conn,$data['Other_skills']);
    
    if (empty($Job_Reference_number) || empty($First_name)  || empty($Last_name)) {
        echo $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Fill all the fields</p>";
    } else {
        
            $insert = "INSERT INTO `eoi`( `Job_Reference_number`, `First_name`, `Last_name`, `gender`, `dob`, `Street_address`, `Suburb`, `State`, `Postcode`, `Email_address`, `Phone_number`) 
            values('$Job_Reference_number','$First_name','$Last_name','$gender','$dob','$Street_address','$Suburb','$State','$Postcode','$Email_address','$Phone_number')";
            $status = mysqli_query($conn,$insert);
            if($status){
                $EOInumber=mysqli_insert_id($conn);
                $insert2="INSERT INTO `skills`( `EOInumber`, `skillCheckboxes`, `Other_skills`) VALUES ('$EOInumber','$string','$Other_skills')";
                $status2 = mysqli_query($conn,$insert2);
                echo $message="<p style='color:green;font-size:20px'>Job Application has been done successfully. <b>Your Reference number is:<u> ".$EOInumber."</u></b> !!</p>";
            }else{
                echo $message="Sorry, an error occurred while applying for this job. Please Try again!!";
            }
        }
    
return $message;
}  
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
    <script src="scripts/apply.js"></script>
    <title>Rubicon International.</title>
</head>

<body class="container3">
    <?php
    include_once"header.inc";
    ?>
    <main>
        <?php
        if(isset($_POST['jobApplication'])){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                job_application($_POST);
                    
            }
            
        }
        ?>
    </main>


<hr>
<?php include_once"footer.inc";?>
</body>

</html>