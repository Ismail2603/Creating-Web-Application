<?php
include_once"phpenhancements.php";

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
        <div class="form">
        
        <form id="application-form" action="processEOI.php" method="POST">
            <h1>Job application</h1>
            <select id="reference"name="Job_Reference_number"  maxlength="5" minlength="5" placeholder="Reference number..."
                    required>
                <option value="">Select Job</option>
                <?php
                $queryss=mysqli_query($conn,"select * from `jobs` where `job_status`='Active' order by id desc");
                while($results=mysqli_fetch_assoc($queryss)){
                    ?>
                    <option value="<?php echo $results['Job_Reference_number'];?>"><?php echo $results['Job_Reference_number']." -".$results['job_title'] ?></option>
                    <?php
                }
                ?>
            </select>
                <input id="name" name="First_name" type="text" maxlength="20" placeholder="First Name..." required>
                <input id='lastName' name="Last_name" type="text" maxlength="20" placeholder="Last name..." required>
                <label for="dateOfBirth">Date of birth</label>
                <input type="date"name="dob" id="dateOfBirth" required>
                <label for="dateOfBirth" id="dob-error" class="error-message"></label>
                <fieldset>
                    <legend>Gender</legend>
                    <input type="radio" id="gender1" name="gender" value="Male"><label id="gender1Label"
                        for="gender1">Male</label>
                    <input type="radio" id="gender2" name="gender" value="Female"><label id="gender2Label"
                        for="gender2">Female</label>
                    <input type="radio" id="gender3" name="gender" value="Other"><label id="gender3Label"
                        for="gender3">Other</label>
                </fieldset>
                <input id="street"name="Street_address" type="text" maxlength="40" placeholder="Street address...">
                <input id="town" name="Suburb" type="text" maxlength="40" placeholder="Suburb/town...">
                <label for="state">Select state</label>
                <select id="state" aria-label="state" name="State">
                    <option value="VIC">VIC</option>
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="NT">NT</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>
                </select>
                <input type="number" name="Postcode" placeholder="Postcode..." maxlength="4" minlength="4" id="postCode">
                <label for="postCode" id="postCode-error" class="error-message"></label>
                <input id="email" name="Email_address" type="email" placeholder="Email...">
                <input id="phone" type="number"  name="Phone_number" placeholder="Phone number..." minlength="8" maxlength="12">
                <h3>Your skills</h3>
                <div class="checkbox">
                    <input type="checkbox" name="skillCheckboxes[]"value="Responsible" id="check1"><label for="check1">Responsible</label>
                    <input type="checkbox" name="skillCheckboxes[]" value="Reliable"id="check2"><label for="check2">Reliable</label>
                    <input type="checkbox" name="skillCheckboxes[]" value="Restitude" id="check3"><label for="check3">Restitude</label>
                    <input type="checkbox" name="skillCheckboxes[]" value="Teamwork"id="check4"><label for="check4">Teamwork
                        skills</label>
                    <input type="checkbox" name="skillCheckboxes[]" value="Time-management"id="check5"><label for="check5">Time-management
                        skills</label>
                    <input type="checkbox" name="skillCheckboxes[]" value="Other"id="check6"><label for="check6">Other
                        skills...</label>
                </div>
                <textarea id="other-skills" name="Other_skills" placeholder="Other skills..."></textarea>
                <label for="other-skills" id="other-skills-error" class="error-message"></label>
                <input type="submit" value="Submit" name="jobApplication" id="submit">
            </form>
        </div>
    </main>


    <hr>
    <?php include_once"footer.inc";?>
</body>

</html>