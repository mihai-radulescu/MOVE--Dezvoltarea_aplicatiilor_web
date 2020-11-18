<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
	<h2 style="text-align:center">Verifica un cod:</h2>

	<div class="d-flex justify-content-center">
		<form action="index.php" method="post">
			<div class="form-group justify-content-center">
				<input type="text" name="deliveryCode" class="form-control"> <br>
				
				<div class="d-flex justify-content-center">
					<input type="submit" class="btn btn-primary">
				</div>	
			</div>
	</div>

	<br>

	<h4>Parerile clientiilor nostri</h4>

	<br>

	<i>
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
	</i>
	<br>
	<p style="text-align:right; font-weight:bold">-John Doe.</p>

	<br>

	<i>
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
	</i>
	<br>
	<p style="text-align:right; font-weight:bold">-Jane Doe.</p>

</div>

<?php include("includes/footer.php");?>

</body>
</html>