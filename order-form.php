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

<?php /*
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

    }*/
?>

<div class="wrapper">
    <h2>Orders</h2>

    <h3>Select an address</h3>
    <form method="POST" action="addresses.php">
        <input type="submit" name="selectAddress" value="Select" class="btn btn-success btn-lg btn-block">
    </form>

    <?php
    include("includes/functions.php");
    $addressid = 0;

    if(isset($_POST["selectedAddress"])){

    $addressid = $_POST["addressid"];    
    $result = readOneAddress($conn, $addressid); 
    if($row = mysqli_fetch_assoc($result)){
        ?>
            <br>
            <table class='table table-bordered table-striped table-sm'>
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Street</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $row["country"];?></td>
                        <td><?php echo $row["region"];?></td>
                        <td><?php echo $row["city"];?></td>
                        <td><?php echo $row["street"];?></td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
    <?php
    }
}
?>

    <br>

    <h3>Add your clients information</h3>
    <form action="includes/order-inc.php" method="POST">
        <input type="hidden" name="addressid" value=<?php echo $addressid ?> >
        <div class="form-group ">
            <label>Name</label>
            <input type="text" name="clientName" class="form-control" required>
        </div>

        <div class="form-group ">
            <label>Phone</label>
            <input type="tel" name="clientPhone" class="form-control" pattern="[0-9]{10}" placeholder="0123456789" required>
        </div>

        <div class="form-group ">
            <label>Email</label>
            <input type="email" name="clientEmail" class="form-control" required>
        </div>

        <div class="form-group ">
            <label>Street</label>
            <input type="text" name="clientStreet" class="form-control" placeholder="steet, building, appartment" required>
        </div>

        <div class="form-group ">
            <label>Wieght (Up to 10 Kg)</label>
            <input type="number" name="weight" class="form-control" placeholder="5" min="1" max="10" required>
        </div>

        <div class="form-group">
            <input type="submit" name="orderSubmit" class="btn btn-success" value="Place your order">
        </div>
       
</div>

<?php include("includes/footer.php");?>

</body>
</html>