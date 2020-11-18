<?php
    include("includes/a_config.php");
?>

<!DOCTYPE html>
<html>
<head>

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

	<?php include("includes/head-tag-contents.php");?>
</head>
<body>

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="wrapper">
    <h2>Add your address</h2>

    <form action="includes/addresses-inc.php" methot="POST">
        <div class="form-group ">
            <label>Country</label>
            <input type="text" name="country" class="form-control">
        </div>

        <div class="form-group ">
            <label>Region</label>
            <input type="text" name="region" class="form-control">
        </div>

        <div class="form-group ">
            <label>City</label>
            <input type="text" name="city" class="form-control">
        </div>

        <div class="form-group ">
            <label>Street</label>
            <input type="text" name="street" class="form-control" placeholder="steet, building, appartment">
        </div>

        <div class="form-group">
            <input type="submit" name="addAddress" class="btn btn-success" value="+ Add">
        </div>
       
</div>

<?php include("includes/footer.php");?>

</body>
</html>