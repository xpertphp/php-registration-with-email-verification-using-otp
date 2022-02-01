<?php
if(isset($_POST['btnResend']))
{
    include('connection.php');
	$email = $_REQUEST['email'];
	if(!empty($email)){
	
		$sql=mysqli_query($conn,"SELECT * FROM user where email='$email' and status=0");
		$row  = mysqli_fetch_array($sql);
		if(is_array($row))
		{
			$otp = rand(100000, 999999);

			$update_query = "UPDATE user SET otp = '".$otp."' WHERE id = '".$row['id']."'";
			mysqli_query($conn,$insert);
			
			
			require 'class/class.phpmailer.php';

			$mail = new PHPMailer;

			$mail->IsSMTP();

			$mail->Host = 'ssl://smtp.gmail.com';

			$mail->Port = '465';

			$mail->SMTPAuth = true;

			$mail->Username = 'xxxxxxxxxxxx';

			$mail->Password = 'xxxxxxxxxxx';

			$mail->SMTPSecure = '';

			$mail->From = 'Enter Form Email';

			$mail->FromName = 'Enter From Name';

			$mail->AddAddress($row['email']);

			$mail->IsHTML(true);

			$mail->Subject = 'Resend Email Verification OTP For Registration';

			$message_body = '
			<p>For verify your email address, enter this verification code when prompted:: <b>'.$otp.'</b>.</p>
			<p>Sincerely,</p>
			';

			$mail->Body = $message_body;

			if($mail->Send())
			{
				$code = base64_encode($row['email']);
				header('location:verify.php?code='.$code);
				exit;
			}
		}
		else
		{
			$msg="Email Address already verified";
			header ("Location: resend.php?error=".$msg);	
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
    <title>Resend Email Verification OTP using PHP</title>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
		  <a class="navbar-brand" href="resend.php">Resend</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		</div>
    </nav>

<div class="container">
  <div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3>Resend Email Verification OTP</h3>
        <hr>
         <?php if (isset($_REQUEST['success'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_REQUEST['success']; ?>
          </div>
        <?php endif; ?>
        <form class="" method="post">
			<div class="col-12">
              <div class="form-group">
               <label for="email">Email address</label>
               <input type="text" class="form-control" name="email" id="email" value="">
              </div>
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
              <button type="submit" name="btnResend" class="btn btn-primary">Resend</button>
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