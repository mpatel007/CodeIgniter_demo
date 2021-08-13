<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script>
		var BASE_URL = "<?php echo base_url(); ?>";
	</script>
	<style>
		body {
			color: #fff;
			background: #3598dc;
			font-family: 'Roboto', sans-serif;
		}

		form .error {
			color: #ff0000;
		}

		.form-control {
			height: 41px;
			background: #f2f2f2;
			box-shadow: none !important;
			border: none;
		}

		.form-control:focus {
			background: #e2e2e2;
		}

		.form-control,
		.btn {
			border-radius: 3px;
		}

		.signup-form {
			width: 390px;
			margin: 30px auto;
		}

		.signup-form form {
			color: #999;
			border-radius: 3px;
			margin-bottom: 15px;
			background: #fff;
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			padding: 30px;
		}

		.signup-form h2 {
			color: #333;
			font-weight: bold;
			margin-top: 0;
		}

		.signup-form hr {
			margin: 0 -30px 20px;
		}

		.signup-form .form-group {
			margin-bottom: 20px;
		}

		.signup-form input[type="checkbox"] {
			margin-top: 3px;
		}

		.signup-form .row div:first-child {
			padding-right: 10px;
		}

		.signup-form .row div:last-child {
			padding-left: 10px;
		}

		.signup-form .btn {
			font-size: 16px;
			font-weight: bold;
			background: #3598dc;
			border: none;
			min-width: 140px;
		}

		.signup-form .btn:hover,
		.signup-form .btn:focus {
			background: #2389cd !important;
			outline: none;
		}

		.signup-form a {
			color: #fff;
			text-decoration: underline;
		}

		.signup-form a:hover {
			text-decoration: none;
		}

		.signup-form form a {
			color: #3598dc;
			text-decoration: none;
		}

		.signup-form form a:hover {
			text-decoration: underline;
		}

		.signup-form .hint-text {
			padding-bottom: 15px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="signup-form">
		<form onsubmit="return false" method="post" name="formdata" enctype="multipart/form-data" id="formdata">
			<h2>Sign Up</h2>
			<p>Please fill in this form to create an account!</p>
			<hr>
			<div class="form-group">
				<div class=""><input type="text" class="form-control" name="fname" id="fname" placeholder="Full Name"></div>
				<!-- <div class="col-xs-6"><input type="text" class="form-control" name="last_name" placeholder="Last Name" ></div> -->
			</div>
			<div class="form-group">
				<input type="contect" class="form-control" name="contect" id="contect" placeholder="Contact Number">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">
			</div>
			<div class="form-group" name="genderr" id="genderr">
				<h5>Gender</h5>
				<input type="radio" name="gender" value="male" id="male">
				<label for="male">Male</label>
				<input type="radio" name="gender" value="female" id="female">
				<label for="female">Female</label>
			</div>
			<div class="form-group">
				<h6>Country:</h6>
				<select name="country" id="country" class="custom-select">
					<?php foreach ($country as $country) { ?>
						<option placeholder="Select Country" value='<?php echo $country->id ?>'> <?php echo $country->name ?> </option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<h6>State:</h6>
				<div id="statelist">
					<select name="state" id="state" class="custom-select">
						<option value="">Select Country First</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<h6>City:</h6>
				<div id="citylist">
					<select name="city" id="city" class="custom-select">
						<option value="">Select State First</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<h5>Upload Photo:</h5>
				<div class="custom-file mb-3">
					<input type="file" class="custom-file-input" id="fileupload" name="fileupload">
					<label class="custom-file-label" for="customFile">Choose Photo</label>
				</div>
				<div class="form-group">
					<label class="checkbox-inline" id="checkbox"><input type="checkbox"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
				</div>
				<div class="form-group">
					<button type="submit" id="signup" name="signup" class="btn btn-primary btn-lg">Sign Up</button>
				</div>
		</form>
		<div class="hint-text">Already have an account? <a href="<?php echo base_url('index.php/user/login'); ?>">Login here</a></div>
	</div>

	<script src="<?php echo base_url(); ?>assets\script\script.js"></script>
</body>

</html>