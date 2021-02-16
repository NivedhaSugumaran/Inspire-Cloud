<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$connect = mysqli_connect("ls-dd4af8cf955490fff21b5b6a14b67d56a90ae3eb.cfp0h459lz09.ap-south-1.rds.amazonaws.com:3306", "admin", "12345678", "inspirecloud");
$id=$_SESSION['id'];
$query1 = "SELECT * FROM certificate where id='$id'";
$result=mysqli_query($connect,$query1);

 if(isset($_POST["submit"]))
 {

      $employeename=$_POST['employeename'];
      $certtype=$_POST['certtype'];
      $certlevel=$_POST['certlevel'];
      $certname=$_POST['certname'];
      $certid=$_POST['certid'];
      $certdate=$_POST['certdate'];
      $expirydate=$_POST['expirydate'];
      $validity=$_POST['validity'];
      $id=$_SESSION['id'];


      $query = "INSERT INTO certificate(certid,certname,certtype,certlevel,employeename,certdate,expirydate,validity,id) VALUES ('$certid','$certname','$certtype','$certlevel','$employeename','$certdate','$expirydate','$validity','$id')";
      if(mysqli_query($connect, $query))
      {
           echo '<script>alert("Successfully added");
window.location.reload();</script>';


      }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"></script>


  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .modal{font: 14px sans-serif; text-align: left;}
    </style>
    <script type="text/javascript">
    $('#myForm').on('submit', function(e){
  $('#myModal').modal('show');
  e.preventDefault();
});
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</head>
<body style="background-color:#ADD8E6;">
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to Inspire Cloud!</h1>
        <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
    </div>


   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Add Certification
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <form action="welcome.php" role="form"  method="post" enctype="multipart/form-data">
      <div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle"><b>Add Certification</b></h5>
        <button type="button" class="close" onClick="window.location.reload();"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <div class="form-group">
                            <label>Employee Name</label>
                            <input type="text" name="employeename" maxlength="25" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>CSP type</label>
                            <select name="certtype">
                              <option value="Aws">AWS</option>
                              <option value="Azure">Azure</option>
                              <option value="Gcp">GCP</option>

                            </select>
 </div>
                        <div class="form-group">
                            <label>Certification Level</label>
                            <input type="text" name="certlevel"  class="form-control" required>
                        </div>
 <div class="form-group">
                            <label>Certification Name</label>
                            <input type="text" name="certname"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Certification ID</label>
                            <input type="text" name="certid"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Certification Date</label>
                            <input type="date" name="certdate"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Expiry Date of Certification</label>
                            <input type="date" name="expirydate"  class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Validity</label>
                            <input type="number" name="validity"  class="form-control" required>
                        </div>
      </div>
      <div class="modal-footer">
        <input type="reset" value="cancel" onClick="window.location.reload();"  class="btn btn-secondary" data-dismiss="modal">

 <input type="submit" name="submit" class="btn btn-primary">
      </div>
  </form>
    </div>
  </div>
</div>


              <!-- DataTables Example -->
        <div class="card mb-3">

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Certification ID</th>
                    <th>Certification Name</th>
                    <th>Certification Type</th>
                    <th>Certification Level</th>

                    <th>Certification Date</th>
                    <th>Expiry Date</th>
 <th>Validity</th>

                  </tr>
                </thead>

                <tbody>
                <!-- populate table from mysql database -->
               <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $row['certid'];?></td>
                    <td><?php echo $row['certname'];?></td>
                    <td><?php echo $row['certtype'];?></td>
                    <td><?php echo $row['certlevel'];?></td>

                    <td><?php echo $row['certdate'];?></td>
                    <td><?php echo $row['expirydate'];?></td>
                    <td><?php echo $row['validity'];?></td>


                </tr>
                  <?php } ?>
                </tbody>
              </table>
  </table>
            </div>
          </div>

        </div>



</body>
</html>


