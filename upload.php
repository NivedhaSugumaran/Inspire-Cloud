<?php
// Include config file
require_once "config.php";
 

// Processing form data when form is submitted
if(isset($_POST["certid"]) && !empty($_POST["certid"])){
    // Get hidden input value
          $certid = $_POST["certid"];
          $employeename=$_POST['employeename'];
          $certtype=$_POST['certtype'];
          $certlevel=$_POST['certlevel'];
          $certname=$_POST['certname'];
          $certid=$_POST['certid'];
          $certdate=$_POST['certdate'];
          $expirydate=$_POST['expirydate'];
          $validity=$_POST['validity'];
          
    
        // Prepare an update statement
        $sql = "UPDATE certificate SET certname='$certname',certtype='$certtype',certlevel='$certlevel',employeename='$employeename',certdate='$certdate',expirydate='$expirydate',validity='$validity' WHERE certid='$certid'";

        if(mysqli_query($link, $sql))
      {
           header("location: welcome.php");


      }



        
} 
else{
    // Check existence of id parameter before processing further
    if(isset($_GET["certid"]) && !empty(trim($_GET["certid"]))){
        // Get URL parameter
        $certid =  trim($_GET["certid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM certificate WHERE certid = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $certid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                $certid = $row["certid"];
                $certname = $row["certname"];
                $certtype = $row["certtype"];
                $certlevel = $row["certlevel"];
                $certdate = $row["certdate"];
                $expirydate = $row["expirydate"];
                $validity = $row["validity"];
                
                $employeename=$row["employeename"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    alert("outside form");
                    //header("location: error.php");
                    //exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        //header("location: error.php");
        //exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Certificate</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Employee Name</label>
                            <input type="text" name="employeename" maxlength="25" class="form-control" value="<?php echo $employeename; ?>">
                        </div>
                        <div class="form-group">
                            <label>CSP type</label>
                            <select name="certtype">
                              <option value="<?php echo $certtype; ?>"></option>
                              <option value="Aws">AWS</option>
                              <option value="Azure">Azure</option>
                              <option value="Gcp">GCP</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Certification Level</label>
                            <input type="text" name="certlevel"  class="form-control" value="<?php echo $certlevel; ?>">
                        </div>
                           <div class="form-group">
                            <label>Certification Name</label>
                            <input type="text" name="certname"  class="form-control" value="<?php echo $certlevel; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Certification Date</label>
                            <input type="date" name="certdate"  class="form-control" value="<?php echo $certdate; ?>">
                        </div>
                        <div class="form-group">
                            <label>Expiry Date of Certification</label>
                            <input type="date" name="expirydate"  class="form-control" value="<?php echo $expirydate; ?>">
                        </div>
                        <div class="form-group">
                            <label>Validity</label>
                            <input type="number" name="validity"  class="form-control" value="<?php echo $validity; ?>">
                        </div>
                         
                        
                        <input type="hidden" name="certid" value="<?php echo $certid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="welcome.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
