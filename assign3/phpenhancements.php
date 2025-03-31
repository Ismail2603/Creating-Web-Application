<?php
//function for checking if HR is login
function checklogin(){
    session_start();
    if ($_SESSION['login'] ==""){
    //if not login
    ?>
    <script>
        alert("You are not Authorized to access this page. Please Login to access");
        window.location.assign("login.php");
    </script>
    <?php
    }
    return true;
}
//logout function
function destroy() {
    session_start();
    session_destroy();
    header('Location: login.php');
}
//function for ensuring HR is login
function checkSession(){
    if ($_SESSION["login"] == false) {
        //destroys all the session there maybe and redirects to login page
        destroy();
        header('Location: login.php');
    }
}
//including Database connection
require_once "setting.php"; 
//function for adding manager's account
function adduser($data){
    //include database file
    include "setting.php"; 
    //defination and sanitization of post data
    $fname=mysqli_real_escape_string($conn,$data['fullname']);
   
    $password=mysqli_real_escape_string($conn,$data['password']);
    $encrypted_password= md5($password);
    $manager_username=mysqli_real_escape_string($conn,$data['manager_username']);
    $email=mysqli_real_escape_string($conn,$data['email']);
    $statusupdate='Active';
    
    $message="";
    if (empty($manager_username) || empty($encrypted_password)  || empty($fname)) {
        
         echo $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Username, password and name cannot be empty</p>";
         //return $message;
        } else {
        $query1="select id from `hr-manager` where `manager_username` ='$manager_username' ";
        $status1 = mysqli_query($conn,$query1);
        
        if(mysqli_num_rows($status1) >0){
            echo $message="Sorry, The account is already created!!. Use a different username";
        }else{
            //inserting data to the table
            $insert = mysqli_query($conn,"INSERT INTO `hr-manager`( `manager_username`, `encrypted_password`, `email`, `full_name`) VALUES ('$manager_username','$encrypted_password','$email','$fname')");
            //$djd = mysqli_query($conn,$insert);
            if($insert){
                echo $message="<p style='color:green;font-size:22px' id='message'><i class='fa fa-times'></i>HR Manager account has been added successfully. Please Login to continue!!</p>";
                
            }else{
                echo $message="<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>Sorry, an error occurred while creating HR Manager Account. Please Try again!!</p>";
            }
        }
    }
return $message;
}
//function for login in user
function login($data) {
        require "setting.php"; 
        $username = $data['username'];
        $password = $data['password'];
        $message = '';
        //checking if the username and password are sent
        if (empty($username) || empty($password)) {
            echo $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Username or Password Must Not be Empty</p>";
        } else {
            $username = mysqli_real_escape_string($conn,$username);
            $encrypted_password = md5(mysqli_real_escape_string($conn,$password));
            //checking if the user's account is locked or not
            checkaccountloack(array(
                'username' => $username
            ));
            $query = "select * from `hr-manager` where `manager_username` ='$username' and `encrypted_password` = '$encrypted_password'";
            $status = mysqli_query($conn,$query);
            // checking if the username or password is already correct
            if (mysqli_num_rows($status)==1) {
                $data = mysqli_fetch_assoc($status);

               
                //Session start;
                session_start();
                $_SESSION['login']=true;
                $_SESSION['username']= $data['manager_username'];
                $_SESSION['fname']=  $data['full_name'];
                $_SESSION['email']=  $data['email'];
                $_SESSION['status']=  $data['status'];

                 //redirecting to manager page(manager.php)
                header("Location: manager.php");
            } else {
                //saving attempts if the password and username is incorrect
                saveAttemptUser(array(
                    'username' => $username,
                    'password' => $data['password']
                ));
                echo $message="<p style='color:red;font-size:20px'>Sorry, Invalid Username or Password</p>";
                 
            }
        }
        return $message;
    }
//saving the number of wrong password for locking the account
    function saveAttemptUser($data){
        require "setting.php"; 
        date_default_timezone_set('Africa/Nairobi');
        $ip = $_SERVER['REMOTE_ADDR'];
        $username = mysqli_real_escape_string($conn, $data['username']);
        $password =  mysqli_real_escape_string($conn,$data['password']);
        $date =  date('Y-m-d h:i:s');
        //get number of attempts
        $query1="SELECT * FROM tbl_accesslog WHERE date >= NOW() - INTERVAL 1 DAY";
        $results= mysqli_query($conn,$query1);
        if(mysqli_num_rows($results)>3){
         //lock Account
         lockaccount(array(
            'username' => $username
        ));
        echo  $message = "Account is Locked. Too many Login Attempts!!!";
        }else{
            //lock account after the 3 wrong attempt
            $query = "insert into tbl_accesslog(ip,user,pass,date) values('$ip','$username','$password','$date')";
            $status = mysqli_query($conn,$query);
            $delq = "DELETE FROM tbl_accesslog WHERE date > NOW() - INTERVAL 1 DAY ";
            $status = mysqli_query($conn,$delq);
            if ($status) {
                echo $message = "<p style='color:red' id='message'><i class='fa fa-times'></i>&nbsp;ATTEMPT:".mysqli_num_rows($results)."</p>";
            }else{
                echo  $message = "";
            }
        } 
        
        return $message;
    }
//function for locking an account when more than 3 times login attempts are made
    function lockaccount($data){
        //lock of 10mins
        require "setting.php"; 
        date_default_timezone_set('Africa/Nairobi');
        
        $date =  date('Y-m-d h:i:s');
        $username = mysqli_real_escape_string($conn, $data['username']);
        $status2='1';
        $query4 = "insert into tbl_lockaccount(user,date,status) values('$username','$date','$status2')";
        $status4 = mysqli_query($conn,$query4);
        if($status4){
            echo  $message = "<p style='color:red' id='message'><i class='fa fa-times'></i>&nbsp;Account has been Locked. Try After 10mins</p>";
           
        }else{
            echo  $message = "";
        }
    return $message;
    }
//function for checking if the account is locked after several login attempts
    function checkaccountloack($data){
        require "setting.php"; 
        date_default_timezone_set('Africa/Nairobi');

        $username = mysqli_real_escape_string($conn, $data['username']);
        $query5 = "SELECT id,status FROM tbl_lockaccount WHERE user='$username'  and date < NOW() - INTERVAL 10 MINUTE order by id desc limit 1";
        $status5 = mysqli_query($conn,$query5);
        if(mysqli_num_rows($status5) >='1'){
            //check status
            $sqls=mysqli_fetch_assoc($status5);
            if($sqls['status']=='1'){
                
                $lockID=$sqls['id'];
                //update status if the waiting time is over
                $query6 = "UPDATE tbl_lockaccount SET status='0' WHERE id='$lockID' ";
                mysqli_query($conn,$query6);  
                echo  $message="";
            }else{
                echo  $message = "<p style='color:red' id='message'><i class='fa fa-times'></i>&nbsp;Account Locked. Try again later!!</p>";
            }
        }else{
            
            echo  $message="";
        }
        return $message;
    }

    //function for adding new job start here
    function addnewjob($data){
        require "setting.php"; 
        $job_reference_number= mysqli_real_escape_string($conn,$data['job_reference_number']);
        $job_title= mysqli_real_escape_string($conn,$data['job_title']);
        $job_description= mysqli_real_escape_string($conn,$data['job_description']);
        $job_status="Active";
        //ensuring the values are not empty
        if (empty($job_reference_number) || empty($job_title)  || empty($job_description)) {
            echo $message = "<p style='color:red;dont-size: 20ps' id='message'><i class='fa fa-times'></i>&nbsp;Please Fill all the fields</p>";
        } else {
            //checking if there is another job with the same reference number
            $queryd5 = "SELECT id FROM jobs WHERE Job_Reference_number='$job_reference_number' ";
            $status5 = mysqli_query($conn,$queryd5);
            if(mysqli_num_rows($status5) >=1){
               echo  $message="Job with Reference Number:".$job_reference_number." is already Added. Please Try again!!";
            }else{
                $insert = "INSERT INTO `jobs`( `Job_Reference_number`, `job_title`, `job_description`, `job_status`) values('$job_reference_number','$job_title','$job_description','$job_status')";
                $status = mysqli_query($conn,$insert);
                if($status){
                    echo $message="Job has been Added Successfully!! The Job Reference Number is:".$job_reference_number;
                }else{
                    echo $message="Sorry, an error occurred while new job. Please Try again!!";
                }
            }
        }
        
    return $message;
    }
//function for Job Listing begins here
    function joblisting(){
        require "setting.php"; 
        $queryd5 = "SELECT * FROM jobs  order by id desc ";
        $status5 = mysqli_query($conn,$queryd5);
        echo $message='<table id="example2" width="100%" class="table table-concept table-display" role="grid" aria-describedby="example2_info" style="background-color:white,">
        <thead>
            <tr role="row" style="text-align: center;">
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending" >#</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Reference Number</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Title</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Description</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Status</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Date</td>
        </tr>
        </thead>
        <tbody style="text-align: center;">
        ';
        $c=1;
        while($results=mysqli_fetch_assoc($status5)){
            echo $message="
            <tr>
                <td>". $c."</td>
                <td>". $results['Job_Reference_number']."</td>
                <td>". $results['job_title']."</td>
                <td>". $results['job_description']."</td>
                <td>". $results['job_status']."</td>
                <td>". $results['date']."</td>
            </tr>
            ";
            $c++;
        }

        echo $message="</tbody></table>";
    }
//job application Listing begins here
    function jobapplications(){
        require "setting.php"; 
        $queryd5 = "SELECT * FROM `eoi`  order by `EOInumber` desc ";
        $status5 = mysqli_query($conn,$queryd5);
        echo $message='<table id="example" width="100%" class="table table-concept table-display" role="grid" aria-describedby="example2_info" style="background-color:white,">
        <thead class="table-title">
            <tr role="row" style="text-align: center;">
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending" >#</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">EOInumber</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Full Name</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Gender</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Date of Birth</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Address</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">State</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Email Address</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Phone Number</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Applied</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Skills</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Status</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Date</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Action</td>
        </tr>
        </thead>
        <tbody style="text-align: center;">
        ';
        $c=1;
        while($results=mysqli_fetch_assoc($status5)){
            //get Job details of the Job applied
            $query2=mysqli_query($conn, "SELECT * FROM `jobs` where `Job_Reference_number`='".$results['Job_Reference_number']."' ");
            $results2=mysqli_fetch_assoc($query2);

            //get skills of the applicant
            $query3=mysqli_query($conn, "SELECT * FROM `skills` where `EOInumber`='".$results['EOInumber']."' ");
            $results3=mysqli_fetch_assoc($query3);

            echo $message ="
            <tr>
                <td>". $c."</td>
                <td>". $results['EOInumber']."</td>
                <td>". $results['First_name'].' '. $results['Last_name']."</td>
                <td>". $results['gender']."</td>
                <td>". $results['dob']."</td>
                <td>". $results['Street_address'].' -'. $results['Suburb']."</td>
                <td>". $results['State'].' -'. $results['Postcode']."</td>
                <td>". $results['Email_address']."</td>
                <td>". $results['Phone_number']."</td>
                <td>". $results2['Job_Reference_number'].'<br>-'.$results2['job_title']."</td>
                <td>". $results3['skillCheckboxes'].'<br>-'.$results3['Other_skills']."</td>
                <td>". $results['status']."</td>
                <td>". $results['date']."</td>
                <td>";?>
                <button class="btn btn-primary btn-block btn-flat" data-toggle="collapse" data-target="#statusmodal<?php echo $results['EOInumber']?>"> Update Status</button>
                <!-- Modal -->

                <div class="collapse" id="statusmodal<?php echo $results['EOInumber']?>"focus="true" role="dialog">
                    
                        <div class="form">
        
                    <form id="application-form" action="" method="POST">
                        
                        <select name="jobstatus"   placeholder="Status..."required>
                           
                                <option value="New" <?php if($results['status']=="New"){ echo 'selected';}else{ echo '';}?>>New</option>
                                <option value="Current" <?php if($results['status']=="Current"){ echo 'selected';}else{ echo '';}?>>Current</option>
                                <option value="Final" <?php if($results['status']=="Final"){ echo 'selected';}else{ echo '';}?>>Final</option>
                               
                        </select>
                        <input type="hidden" value="<?php echo $results['EOInumber']?>" name="EOInumber" required>
                        <input type="submit" value="Save" name="statusupdate" id="submit">
                    </form>
                    </div>
                </div>
                
                <a href="enhancement.php?jobapp=jobapplications&action=del&keyword=<?php echo base64_encode($results['EOInumber'])?>"onclick ='return confirm("Please cofirm to delete this Application??")'><button class="btn btn-primary btn-block btn-flat" > Delete</button></a>
                
                <?php
                echo $message="
                </td>
                
            </tr>
            ";
            $c++;
        }

        echo $message="</tbody></table>";
    }
    //Updating the job application status start here
     function jobStatus($data){
        require "setting.php";
        //get the EOInumber and status submited  from 
        $EOInumber = mysqli_real_escape_string($conn, $data['EOInumber']);
        $jobstatus = mysqli_real_escape_string($conn, $data['jobstatus']);
        $query5 = "SELECT EOInumber FROM `eoi` WHERE EOInumber='$EOInumber' ";
        $status5 = mysqli_query($conn,$query5);
        //check of such an entry
        if(mysqli_num_rows($status5) <= 0){
            
            echo  $message = "<p style='color:red;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Sorry No Such EOInumber found!!</p>";
           
        }else{
            //updating the status
            $query6 = "UPDATE `eoi` SET status='$jobstatus' WHERE EOInumber='$EOInumber' ";
            $status6 = mysqli_query($conn,$query6);
            if($status6){
                echo  $message = "<p style='color:green;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Status Updated successfully!!</p>";
            }else{
                echo  $message = "<p style='color:red;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Sorry, an error occurred when changing the status of the Applicant!!</p>";
            }
            
        }
        return $message;
     }
// deleting job application function begins here
     function deleteJob($data){
        require "setting.php";

        //decode sent EOI Number
        $EOInumber = base64_decode($data['keyword']);
        //check for an entry with this EOInumber
       $query5 = "SELECT EOInumber FROM `eoi` WHERE EOInumber='$EOInumber' ";
        $status5 = mysqli_query($conn,$query5);
        if(mysqli_num_rows($status5) <= 0){
            
            echo  $message = "<p style='color:red;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Sorry No Such EOInumber found!!</p>";
           
        }else{
            //deleting the entry 
            $query6 = "DELETE FROM `eoi`  WHERE EOInumber='$EOInumber' ";
            $status6 = mysqli_query($conn,$query6);
            if($status6){
                //check if its deleted
                echo  $message = "<p style='color:green;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Application Deleted successfully!!</p>";
            }else{
                echo  $message = "<p style='color:red;font-size:20px' id='message'><i class='fa fa-times'></i>&nbsp;Sorry, an error occurred when Deleting the entry!!</p>";
            }
            
        }
        return $message;
     }
     //job search function
     function searchapplication($data){
        require "setting.php"; 
        $EOINumber=$data['EOINumber'];
        $name=$data['name'];
        //check which field has value to make a search
        if($EOINumber =="" && $name !="" ){
            // when the search by name is not empty
            $queryd5 = "SELECT * FROM `eoi` where `First_name` like '%$name%' or `Last_name` like '%$name%'  order by `EOInumber` desc ";
        }
        if($EOINumber !="" && $name =="" ){
            // when the search by EOInumber is not empty
            $queryd5 = "SELECT * FROM `eoi` where `EOInumber` = '$EOINumber'  order by `EOInumber` desc ";
        }
        else{
            // when the search by EOInumber is not empty and also by name
            $queryd5 = "SELECT * FROM `eoi` where `First_name` like '%$name%' or `Last_name` like '%$name%' or `EOInumber` = '$EOINumber'  order by `EOInumber` desc ";
        }
        //display data after search
        $status5 = mysqli_query($conn,$queryd5);
        echo $message='<table id="example" width="100%" class="table table-concept table-display" role="grid" aria-describedby="example2_info" style="background-color:white,">
        <thead class="table-title">
            <tr role="row" style="text-align: center;">
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending" >#</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">EOInumber</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Full Name</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Gender</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Date of Birth</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Address</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">State</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Email Address</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Phone Number</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Job Applied</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Skills</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Status</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Date</td>
                <td class="sorting" tabindex="0" aria-controls="example2"  aria-label="CSS grade: activate to sort column ascending">Action</td>
        </tr>
        </thead>
        <tbody style="text-align: center;">
        ';
        $c=1;
        while($results=mysqli_fetch_assoc($status5)){
            //get Job details of the Job applied
            $query2=mysqli_query($conn, "SELECT * FROM `jobs` where `Job_Reference_number`='".$results['Job_Reference_number']."' ");
            $results2=mysqli_fetch_assoc($query2);

            //get skills of the applicant
            $query3=mysqli_query($conn, "SELECT * FROM `skills` where `EOInumber`='".$results['EOInumber']."' ");
            $results3=mysqli_fetch_assoc($query3);

            echo $message ="
            <tr>
                <td>". $c."</td>
                <td>". $results['EOInumber']."</td>
                <td>". $results['First_name'].' '. $results['Last_name']."</td>
                <td>". $results['gender']."</td>
                <td>". $results['dob']."</td>
                <td>". $results['Street_address'].' -'. $results['Suburb']."</td>
                <td>". $results['State'].' -'. $results['Postcode']."</td>
                <td>". $results['Email_address']."</td>
                <td>". $results['Phone_number']."</td>
                <td>". $results2['Job_Reference_number'].'<br>-'.$results2['job_title']."</td>
                <td>". $results3['skillCheckboxes'].'<br>-'.$results3['Other_skills']."</td>
                <td>". $results['status']."</td>
                <td>". $results['date']."</td>
                <td>";?>
                <button class="btn btn-primary btn-block btn-flat" data-toggle="collapse" data-target="#statusmodal<?php echo $results['EOInumber']?>"> Update Status</button>
                <!-- Modal -->

                <div class="collapse" id="statusmodal<?php echo $results['EOInumber']?>"focus="true" role="dialog">
                    
                        <div class="form">
        
                    <form id="application-form" action="" method="POST">
                        
                        <select name="jobstatus"   placeholder="Status..."required>
                           
                                <option value="New" <?php if($results['status']=="New"){ echo 'selected';}else{ echo '';}?>>New</option>
                                <option value="Current" <?php if($results['status']=="Current"){ echo 'selected';}else{ echo '';}?>>Current</option>
                                <option value="Final" <?php if($results['status']=="Final"){ echo 'selected';}else{ echo '';}?>>Final</option>
                               
                        </select>
                        <input type="hidden" value="<?php echo $results['EOInumber']?>" name="EOInumber" required>
                        <input type="submit" value="Save" name="statusupdate" id="submit">
                    </form>
                    </div>
                </div>
                
                <a href="enhancement.php?jobapp=jobapplications&action=del&keyword=<?php echo base64_encode($results['EOInumber'])?>"onclick ='return confirm("Please cofirm to delete this Application??")'><button class="btn btn-primary btn-block btn-flat" > Delete</button></a>
                
                <?php
                echo $message="
                </td>
                
            </tr>
            ";
            $c++;
        }

        echo $message="</tbody></table>";
     }
?>