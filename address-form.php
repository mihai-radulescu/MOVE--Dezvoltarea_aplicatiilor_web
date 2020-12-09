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

<?php
    $country = $region = $city = $street = "";

    $addressid = NULL;
    $buttonName = "addAddress";
    $buttonValue = "+ Add";

    if(isset($_POST["updateAddress"])){

        require_once "includes/functions.php";
        require_once "includes/db_config.php";

        $addressid = $_POST["addressid"];

        $result = readOneAddress($conn, $addressid);
        $row = mysqli_fetch_assoc($result);

        $country = $row["country"];
        $region = $row["region"];
        $city = $row["city"];
        $street = $row["street"];

        $buttonName = "updateAddressButton";
        $buttonValue = "Update";

    }
?>

<div class="wrapper">
    <h2>Add your address</h2>

    <form action="includes/addresses-inc.php" method="POST">
        <div class="form-group ">
            <label>Country</label>
            <input type="text" name="country" class="form-control" value="<?php echo $country ?>">
        </div>

        <div class="form-group ">
            <label>Region</label>
            <input type="text" name="region" class="form-control" value="<?php echo $region ?>">
        </div>

        <div class="form-group ">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="<?php echo $city ?>">
        </div>

        <div class="form-group ">
            <label>Street</label>
            <input type="text" name="street" class="form-control" placeholder="steet, building, appartment" value="<?php echo $street ?>">
        </div>

        <div class="form-group">
            <input type="hidden" name="addressid" value="<?php echo $addressid; ?>">
            <input type="submit" name="<?php echo $buttonName; ?>" class="btn btn-success" value="<?php echo $buttonValue; ?>">
        </div>
       
</div>

<?php include("includes/footer.php");?>

</body>
</html>