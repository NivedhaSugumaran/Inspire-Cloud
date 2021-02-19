<?php
// Check existence of id parameter before processing further
if(isset($_GET["certid"]) && !empty(trim($_GET["certid"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM certificate WHERE certid = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["certid"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $employeename=$row["employeename"];
                $certid = $row["certid"];
                $certname = $row["certname"];
                $certtype = $row["certtype"];
                $certlevel = $row["certlevel"];
                $certdate = $row["certdate"];
                $expirydate = $row["expirydate"];
                $validity = $row["validity"];
                $filename = $row["filename"];
                
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>View Certificate</h1>
                    </div>
                    <div class="form-group">
                        <label>Employee Name</label>
                        <p class="form-control-static"><?php echo $row["employeename"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Certificate ID</label>
                        <p class="form-control-static"><?php echo $row["certid"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Certificate Name</label>
                        <p class="form-control-static"><?php echo $row["certname"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Certificate type</label>
                        <p class="form-control-static"><?php echo $row["certtype"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Certificate Level</label>
                        <p class="form-control-static"><?php echo $row["certlevel"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Certificate Date</label>
                        <p class="form-control-static"><?php echo $row["certdate"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <p class="form-control-static"><?php echo $row["expirydate"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Validity</label>
                        <p class="form-control-static"><?php echo $row["validity"]; ?></p>
                    </div>
                     <div class="form-group">
                        <label>Filename</label>
                        <p class="form-control-static"><?php echo $row["filename"]; ?></p>
                    </div>
                    <div>
                    <a href="uploads/<?php echo $row['filename']; ?>" target="_blank">View</a>
                    <a href="uploads/<?php echo $row['filename']; ?>" download>Download</a>
                    <div>
                    <p><a href="welcome.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
