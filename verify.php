<?php
session_start();
if(isset($_POST['btnVerify']))
{
    include('connection.php');
	$code = $_REQUEST['code'];
	if(!empty($code) && $_POST['otp'] != ""){
	
		$sql=mysqli_query($conn,"SELECT * FROM user where email='".base64_decode($code)."' and status=0");
		$row  = mysqli_fetch_array($sql);
		if(is_array($row))
		{
			if($_POST['otp'] == $row['otp']){
				$msg="User Successfully verified";
				header ("Location: verify.php?success=".$msg);	
				exit;
			}
			else
			{
				$msg="Invalid OTP Code";
				header ("Location: verify.php?code=".$code."&error=".$msg);	
				exit;
			}
		}
		else
		{
			$msg="Invalid OTP Code";
			header ("Location: verify.php?code=".$code."&error=".$msg);	
			exit;
		}
    }
	else{
		$msg="All fields are mandatory";
		header ("Location: verify.php?code=".$code."&error=".$msg);	
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title></title>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
		  <a class="navbar-brand" href="verify.php">Verify</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		</div>
    </nav>

<div class="container">
  <div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3>User Verification using OTP</h3>
        <hr>
         <?php if (isset($_REQUEST['success'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_REQUEST['success']; ?>
          </div>
        <?php endif; ?>
        <form class="" method="post">
          <div class="form-group">
           <label for="otp">Enter OTP</label>
           <input type="text" class="form-control" name="otp" id="otp" value="">
          </div>
           <?php if (isset($_REQUEST['error'])): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?php echo $_REQUEST['error']; ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" name="btnVerify" class="btn btn-primary">Verify</button>
            </div>
            <div class="col-12 col-sm-8 text-right">
              <a href="resend.php">Resend</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>