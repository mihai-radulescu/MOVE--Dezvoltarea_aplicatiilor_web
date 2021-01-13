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

    <form action="includes/courier-inc.php" method="POST">

        <div class="form-group ">
            <label>Username / Email</label>
            <input type="text" name="username" class="form-control">
        </div>    

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">    
        </div>

        <div class="form-group ">
            <label>Country</label>
            <input type="text" name="country" class="form-control" placeholder="Romania" required >
        </div>

        <div class="form-group ">
            <label>Region</label>
            <input type="text" name="region" class="form-control" placeholder="Arges" required >
        </div>

        <div class="form-group ">
            <label>City</label>
            <input type="text" name="city" class="form-control" placeholder="Pitesti" required >
        </div>

        <div class="form-group ">
            <label>Wieght (Up to 10 Kg)</label>
            <input type="number" name="weight" class="form-control" placeholder="5" min="1" max="10" required>
        </div>

        <div class="form-group">
            <input type="submit" name="courier" class="btn btn-success" value="Join our team">
        </div>

</div>

<?php include("includes/footer.php");?>

</body>
</html>