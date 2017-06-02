
<?php
     
    require 'database.php';

    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    }
 

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
            $JobroleError = 'Please enter a job role';
            $valid = false;
        }
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE workers  set firstname = ?, lastname = ?, emailaddress =?,mobile =?,jobrole =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($firstname,$lastname,$emailaddress,$mobile,$jobrole,$id));
            Database::disconnect();
            header("Location: index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM workers where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $emailaddress = $data['emailaddress'];
        $mobile = $data['mobile'];
        $jobrole = $data['jobrole'];
        Database::disconnect();
    }
?>



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
                        <h3>Update a Worker</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">

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
                            <input name="lastname" type="text"  placeholder="Last Name" value="<?php echo !empty($lastname)?$lastname:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>



                      <div class="control-group <?php echo !empty($EmailaddressError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="emailaddress" type="text" placeholder="Email Address" value="<?php echo !empty($emailaddress)?$emailaddress:'';?>">
                            <?php if (!empty($EmailaddressError)): ?>
                                <span class="help-inline"><?php echo $EmailaddressError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <div class="control-group <?php echo !empty($MobileError)?'error':'';?>">
                        <label class="control-label">Mobile</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($MobileError)): ?>
                                <span class="help-inline"><?php echo $MobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($JobroleError)?'error':'';?>">
                        <label class="control-label">Jobrole</label>
                        <div class="controls">
                            <input name="jobrole" type="text"  placeholder="Job Role" value="<?php echo !empty($jobrole)?$jobrole:'';?>">
                            <?php if (!empty($JobroleError)): ?>
                                <span class="help-inline"><?php echo $JobroleError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                     




                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>