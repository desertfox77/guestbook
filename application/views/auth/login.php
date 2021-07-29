<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Go-Fit</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?= base_url('alogin/'); ?>images/icons/favicon4.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('alogin/'); ?>css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<form class="login100-form" method="post" action="<?= base_url('auth/login')?>" >
					<span class="login100-form-title p-b-43">
						Guestbook
					</span>
					
					<?= $this->session->flashdata('message'); ?>
					<div class="wrap-input100" >
						<input class="input100" type="text" name="email" id="email" placeholder="Enter Email Address..." value="<?= set_value('email')?>">
						<span class="focus-input100"></span>
						
						<?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
					
					<br>
					<div class="wrap-input100" >
						<input class="input100" type="password" name="password" placeholder="Password" id="password">
						<span class="focus-input100"></span>
						
						<?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
					<br>

			
						
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
                    <br>
                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/forgot')?>">Forgot Password?</a>
                                    </div>
					
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/registration')?>">Don't have account? Register</a>
                                    </div>
				</form>

				<div class="login100-more" style="background-image: url('<?= base_url('alogin/'); ?>images/b1.jpg');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url('alogin/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url('alogin/'); ?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('alogin/'); ?>js/main.js"></script>
	<script type="application/javascript">  
     /** After windod Load */  
     $(window).bind("load", function() {  
       window.setTimeout(function() {  
         $(".alert").fadeTo(500, 0).slideUp(500, function() {  
           $(this).remove();  
         });  
       }, 500);  
     });  
   </script>

</body>
</html>