

<!-- Receiving data and sending to the database-->
<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        //validation errors
        $FirstnameError = null;
        $LastnameError = null;
        $EmailaddressError = null;
        $MobileError = null;
        $JobroleError = null;
         
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $emailaddress = $_POST['emailaddress'];
        $mobile = $_POST['mobile'];
        $jobrole = $_POST['jobrole'];
         
        // validate input
        $valid = true;
        if (empty($firstname)) {
            $FirstnameError = 'Please enter your First Name';
            $valid = false;
        }

       
        if (empty($lastname)) {
            $LastnameError = 'Please enter your Last Name';
            $valid = false;
        }
         
        if (empty($emailaddress)) {
            $EmailaddressError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($emailaddress,FILTER_VALIDATE_EMAIL) ) {
            $EmailaddressError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        if (empty($mobile)) {
            $MobileError = 'Please enter Mobile Number';
            $valid = false;
        }

         if (empty($jobrole)) {
            $JobroleError = 'Please enter Mobile Number';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO workers (firstname,lastname,emailaddress,mobile,jobrole) values(?, ?, ?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($firstname,$lastname,$emailaddress,$mobile,$jobrole));
            Database::disconnect();
            header("Location: index.php");
        }
    }
?>



<!-- Form where we receive the data-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
             <div class="span10 offset1">
                 <div class="row">
                     <h3>Create a worker</h3>
                 </div>
                 <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($FirstnameError)?'error':'';?>">
                       <label class="control-label">First Name</label>
                      <div class="controls">
                     <input name="firstname" type="text"  placeholder="First Name" value="<?php echo !empty($firstname)?$firstname:'';?>">
                            <?php if (!empty($FirstnameError)): ?>
                                <span class="help-inline"><?php echo $FirstnameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($LastnameError)?'error':'';?>">
                        <label class="control-label">Last Name</label>
                        <div class="controls">
                      <input name="lastname" type="text" placeholder="Last name" value="<?php echo !empty($lastname)?$lastname:'';?>">
                            <?php if (!empty($LastnameError)): ?>
                                <span class="help-inline"><?php echo $LastnameError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($EmailaddressError)?'error':'';?>">
                       <label class="control-label">Email Address</label>
                      <div class="controls">
                        <input name="emailaddress" type="text"  placeholder="Email Address" value="<?php echo !empty($emailaddress)?$emailaddress:'';?>">
                            <?php if (!empty($EmailaddressError)): ?>
                                <span class="help-inline"><?php echo $EmailaddressError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($MobileError)?'error':'';?>">
                        <label class="control-label">Mobile</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile"  value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($JobroleError)?'error':'';?>">
                        <label class="control-label">Job Role</label>
                        <div class="controls">
                            <input name="jobrole" type="text"  placeholder="Job role" value="<?php echo !empty($jobrole)?$jobrole:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $jobrole;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> 
  </body>
</html>